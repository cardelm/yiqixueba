<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
loadcache('plugin');

$signature = $_GET["signature"];
$timestamp = $_GET["timestamp"];
$nonce = $_GET["nonce"];	
$token = $_G['cache']['plugin']['yiqixueba_weixin']['token'];
$tmpArr = array($token, $timestamp, $nonce);
sort($tmpArr);
$tmpStr = implode( $tmpArr );
$tmpStr = sha1( $tmpStr );

if( $tmpStr == $signature ){
	$postStr = file_get_contents("php://input");
	if (!empty($postStr)){
		$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
		$inputtype = $postObj->MsgType;
		if($inputtype == 'text'){
			$content = iconv('UTF-8','gbk',trim($postObj->Content));
			$keyword = $content?true:false;
			
		}elseif($inputtype == 'location'){
			$location_x = trim($postObj->Location_X);
			$location_y = trim($postObj->Location_Y);
			$scale = trim($postObj->Scale);
			$label = iconv('UTF-8','gbk',trim($postObj->Label));
			$keyword = ($location_x&&$location_y)?true:false;
		}elseif($inputtype == 'image'){
			$picurl = trim($postObj->PicUrl);
			$keyword = $picurl?true:false;
			
		}elseif($inputtype == 'link'){
			$linktitle = trim($postObj->Title);
			$linkdescription = trim($postObj->Description);
			$linkurl = trim($postObj->Url);
			$keyword = $picurl?true:false;
			
		}
		
		$fromusername = $postObj->Fromusername;
		$tousername = $postObj->Tousername;
		$time = time();
		$textTpl = "<xml>
					<Tousername><![CDATA[%s]]></Tousername>
					<Fromusername><![CDATA[%s]]></Fromusername>
					<CreateTime>%s</CreateTime>
					<MsgType><![CDATA[%s]]></MsgType>
					<Content><![CDATA[%s]]></Content>
					<FuncFlag>1</FuncFlag>
					</xml>";             
		if(!empty( $keyword )) {
			require_once './source/class/class_core.php';
			$discuz = C::app();
			$discuz->init();
			$shopoptionid = DB::result_first("SELECT value FROM ".DB::table('brand_settings')." WHERE variable = 'shop_zidingyi'");

			require_once libfile('function/threadsort');
			if($inputtype == 'text'){
				$zhuangtai = 'tuwen';
				if(substr($content,0,1)=='@'){
					$sql = "SELECT * FROM ".DB::table('forum_thread')." WHERE subject like '%".substr($content,1)."%'";
					$query = DB::query($sql);
					$distid = array();
					while($row = DB::fetch($query)) {
						$distid[] = $row['tid'];
					}
				}else{
					//商家的分类数组
					$shop_fenlei_text =  dunserialize(DB::result_first("SELECT rules FROM ".DB::table('forum_typeoption')." WHERE identifier='ykt_dpfl'"));
					$shop_fenlei_array = explode("\n",$shop_fenlei_text['choices']);
					foreach ( $shop_fenlei_array as $key=>$value){
						$danci = explode("=",$value);
						if(stripos($content,trim($danci[1]))!==false||$content ==trim($danci[1]) ){
							$sql_where_fenlei[] = trim($danci[0]);
						}
					}

					//商家的地区数组
					$shop_diqu_text = dunserialize(DB::result_first("SELECT rules FROM ".DB::table('forum_typeoption')." WHERE identifier='ykt_ssdq'"));
					$shop_diqu_array = explode("\n",$shop_diqu_text['choices']);
					foreach ( $shop_diqu_array as $key=>$value){
						$danci = explode("=",$value);
						if(stripos($content,trim($danci[1]))!==false||$content ==trim($danci[1]) ){
							$sql_where_diqu[] = trim($danci[0]);
						}
					}
					if(is_array($sql_where_diqu)||is_array($sql_where_fenlei)){
						$sql = "SELECT * FROM ".DB::table('forum_typeoptionvar')." WHERE sortid=".$shopoptionid;
						$diqu_optionid = DB::result_first("SELECT optionid FROM ".DB::table('forum_typeoption')." WHERE identifier = 'ykt_ssdq'");
						$fenlei_optionid = DB::result_first("SELECT optionid FROM ".DB::table('forum_typeoption')." WHERE identifier = 'ykt_dpfl'");
						$query = DB::query($sql);
						$distid = array();
						while($row = DB::fetch($query)) {
							if($row['optionid']==$diqu_optionid){
								foreach ( $sql_where_diqu as $dkey=>$dvalue){
									if($dvalue==$row['value'] || strpos($row['value'],$dvalue.'.')){
										$distid[] = $row['tid'];
									}
								}
							}
							if($row['optionid']==$fenlei_optionid){
								foreach ($sql_where_fenlei as $fkey=>$fvalue){
									if($fvalue == $row['value'] || strpos($row['value'],$fvalue.'.') !== false){
										$distid[] = $row['tid'];
									}
								}
							}
						}
						if(is_array($sql_where_diqu)&&is_array($sql_where_fenlei)){
							$temp_distid = array_count_values($distid);
							$distid = array();
							foreach ($temp_distid as $tkey=>$tvalue){
								if($tvalue > 1){
									$distid[] = $tkey;
								}
							}
						}
						$distid = array_unique($distid);
					}else{
						$zhuangtai = 'text';
					}
				}
				if($zhuangtai == 'tuwen'){
					if(count($distid)==0){
						$textTpl = "<xml>
							<Tousername><![CDATA['.$fromusername.']]></Tousername>
							<Fromusername><![CDATA['.$tousername.']]></Fromusername>
							<CreateTime>'.$time.'</CreateTime>
							<MsgType><![CDATA[text]]></MsgType>
							<Content><![CDATA['周围没有您所搜索的商家']]></Content>
							<FuncFlag>0</FuncFlag>
							</xml>"; 
							echo $textTpl;
					}else{
						$newsdisplay = '<xml>
							<Tousername><![CDATA['.$fromusername.']]></Tousername> 
							<Fromusername><![CDATA['.$tousername.']]></Fromusername> 
							<CreateTime>'.$time.'</CreateTime> <MsgType><![CDATA[news]]></MsgType> 
							<Content><![CDATA[]]></Content> 
							<ArticleCount>'.count($distid).'</ArticleCount> 
							<Articles>
							';
						foreach ( $distid as $dkey=>$dvalue ) {
							
							$shop_values = threadsortshow($shopoptionid, $dvalue);
							
							$optionid_logo = DB::result_first("SELECT optionid FROM ".DB::table('forum_typeoption')." WHERE identifier = 'ykt_logo'");
							$img_urls1 = DB::result_first("SELECT value FROM ".DB::table('forum_typeoptionvar')." WHERE optionid = ".$optionid_logo." and tid=".$dvalue);
							$img_urls = dunserialize($img_urls1);
							$img_url = $img_urls['url']!=''?('http://'.$_SERVER["HTTP_HOST"].'/'.$img_urls['url']):'';
							$subject = DB::result_first("SELECT subject FROM ".DB::table('forum_thread')." WHERE tid = ".$dvalue);
							//$subject = iconv('UTF-8','gbk',$subject);
							$subject = iconv('gbk','UTF-8',$subject);
							$newsdisplay .= '<item> 
								<Title><![CDATA['.$subject.']]></Title> <Description><![CDATA['.iconv('gbk','UTF-8','店铺地址：'.$shop_values['optionlist']['ykt_dizhi']['value'].'店铺电话:'.$shop_values['optionlist']['ykt_dpdh']['value']).']]></Description> <PicUrl><![CDATA['.$img_url.']]></PicUrl>
								<Url><![CDATA[http://'.$_SERVER["HTTP_HOST"].'/plugin.php?id=yiqixueba_weishangjia:shangjiaview&tid='.$dvalue.'&user='.$fromusername.']]></Url> 
								</item>
								';
						}
						$newsdisplay .= '
						</Articles> 
							<FuncFlag>1</FuncFlag>
							</xml>';
						echo $newsdisplay;
					}
				}else{
					$weixin_jiqiren = $yiqixueba_weishangjia_config['weixin_jiqiren'];
					$weixin_jiqiren_array = explode("\n",$weixin_jiqiren);
					foreach ( $weixin_jiqiren_array as $value){
						$weixin_jiqiren_array1 = explode("=",$value);
						if($content == trim($weixin_jiqiren_array1[0])){
							$contentStr = $weixin_jiqiren_array1[1];;
						}
					}
					$msgType = "text";
					$textTpl = "<xml>
						<Tousername><![CDATA[%s]]></Tousername>
						<Fromusername><![CDATA[%s]]></Fromusername>
						<CreateTime>%s</CreateTime>
						<MsgType><![CDATA[%s]]></MsgType>
						<Content><![CDATA[%s]]></Content>
						<FuncFlag>0</FuncFlag>
						</xml>";             
					$resultStr = sprintf($textTpl, $fromusername, $tousername, $time, $msgType, iconv('gbk','UTF-8',$contentStr));
					echo $resultStr;
				}

			}elseif($inputtype == 'location'){
				$api_key = DB::result_first("SELECT svalue FROM ".DB::table('common_setting')." WHERE skey='yikatong_api_key'");
				$jvli = $yiqixueba_weishangjia_config['weixin_area'];
				$api_url = 'http://www.17xue8.cn/weixinapi.php?api_key='.$api_key.'&location_x='.$location_x.'&location_y='.$location_y.'&jvli='.$jvli;
				$xmldata = file_get_contents($api_url);
				require_once libfile('class/xml');
				$data = xml2array($xmldata);

				$optionid_xzuobiao = DB::result_first("SELECT optionid FROM ".DB::table('forum_typeoption')." WHERE identifier = 'ykt_xzuobiao'");
				$optionid_yzuobiao = DB::result_first("SELECT optionid FROM ".DB::table('forum_typeoption')." WHERE identifier = 'ykt_yzuobiao'");

				$sql = "SELECT tid,value FROM ".DB::table('forum_typeoptionvar')." WHERE sortid = ".$shopoptionid." and optionid = ".$optionid_xzuobiao;
				$query = DB::query($sql);
				while($row = DB::fetch($query)) {
					$xzuobiao_array[$row['tid']] = $row['value'];
				}

				
				$sql = "SELECT tid,value FROM ".DB::table('forum_typeoptionvar')." WHERE sortid = ".$shopoptionid." and optionid = ".$optionid_yzuobiao;
				$query = DB::query($sql);
				while($row = DB::fetch($query)) {
					$yzuobiao_array[$row['tid']] = $row['value'];
				}
				

				$shopcount = 0;
				foreach ( $xzuobiao_array as $tid=>$xx){
					$yy = $yzuobiao_array[$tid];
					if(intval($xx*10000000)>=intval($data['dian_x1']*10000000) && intval($xx*10000000)<=intval($data['dian_x2']*10000000) && intval($yy*10000000)>=intval($data['dian_y4']*10000000) && intval($yy*10000000)<=intval($data['dian_y2']*10000000)){
						$display[$shopcount] = $tid;
						$shopcount++;
					}
				}
					
				if($shopcount==0){
					$resultStr = "<xml>
						<Tousername><![CDATA[".$fromusername."]]></Tousername>
						<Fromusername><![CDATA[".$tousername."]]></Fromusername>
						<CreateTime>".$time."</CreateTime>
						<MsgType><![CDATA[text]]></MsgType>
						<Content><![CDATA[".iconv('gbk','UTF-8',$yiqixueba_weishangjia_config['weixin_text'])."]]></Content>
						<FuncFlag>0</FuncFlag>
						</xml>";             
					echo $resultStr;
				}else{
					$newsdisplay = '<xml>
						<Tousername><![CDATA['.$fromusername.']]></Tousername> 
						<Fromusername><![CDATA['.$tousername.']]></Fromusername> 
						<CreateTime>'.$time.'</CreateTime> <MsgType><![CDATA[news]]></MsgType> <Content><![CDATA[]]></Content> <ArticleCount>'.$shopcount.'</ArticleCount> 
						<Articles>
						';
					foreach ( $display as $dkey=>$dvalue ) {
						$shop_values = threadsortshow($shopoptionid, $dvalue);
						$optionid_logo = DB::result_first("SELECT optionid FROM ".DB::table('forum_typeoption')." WHERE identifier = 'ykt_logo'");
						$img_urls1 = DB::result_first("SELECT value FROM ".DB::table('forum_typeoptionvar')." WHERE optionid = ".$optionid_logo." and tid=".$dvalue);
						$img_urls = dunserialize($img_urls1);
						$img_url = $img_urls['url']!=''?('http://'.$_SERVER["HTTP_HOST"].'/'.$img_urls['url']):'';
						$newsdisplay .= '<item> 
							<Title><![CDATA['.iconv('gbk','UTF-8',DB::result_first("SELECT subject FROM ".DB::table('forum_thread')." WHERE tid = ".$dvalue)).']]></Title> <Description><![CDATA['.iconv('gbk','UTF-8','店铺地址：'.$shop_values['optionlist']['ykt_dizhi']['value'].'店铺电话:'.$shop_values['optionlist']['ykt_dpdh']['value']).']]></Description> <PicUrl><![CDATA['.$img_url.']]></PicUrl>
							<Url><![CDATA[http://'.$_SERVER["HTTP_HOST"].'/plugin.php?id=yiqixueba_weishangjia:shangjiaview&tid='.$dvalue.'&user='.$fromusername.']]></Url> 
							</item>
							';
					}
					$newsdisplay .= '
					</Articles> 
						<FuncFlag>1</FuncFlag>
						</xml>';
						
					echo $newsdisplay;
					$resultStr = "<xml>
						<Tousername><![CDATA[".$fromusername."]]></Tousername>
						<Fromusername><![CDATA[".$tousername."]]></Fromusername>
						<CreateTime>".$time."</CreateTime>
						<MsgType><![CDATA[text]]></MsgType>
						<Content><![CDATA[搜索出".$shopcount."家商家]]></Content>
						<FuncFlag>0</FuncFlag>
						</xml>";             
					echo $resultStr;
				}
			}
			$msgType = "text";
			$contentStr = $yiqixueba_weishangjia_config['weixin_text'];
			$resultStr = sprintf($textTpl, $fromusername, $tousername, $time, $msgType, $contentStr);
			echo $resultStr;
       }else{//关注回复
			$gz_tw = array();
			$gz_neirong = $yiqixueba_weishangjia_config['weixin_guanzhu'];
			$gz_neirong_array = explode("\n",$gz_neirong);
			foreach ( $gz_neirong_array as $gz_nr){
				if(substr($gz_nr,0,3)=='tw='){
					$gz_tw[] = substr($gz_nr,3,strlen($gz_nr));
				}
			}
			if($gz_tw){
				$resultStr = '<xml>
					<Tousername><![CDATA['.$fromusername.']]></Tousername> 
					<Fromusername><![CDATA['.$tousername.']]></Fromusername> 
					<CreateTime>'.$time.'</CreateTime> <MsgType><![CDATA[news]]></MsgType> 
					<Content><![CDATA[]]></Content> 
					<ArticleCount>'.count($gz_tw).'</ArticleCount> 
					<Articles>
					';
				foreach ( $gz_tw as $value){
					$tw_out = explode("|",$value);
					$resultStr .= '<item> 
						<Title><![CDATA['.iconv('gbk','UTF-8',$tw_out[0]).']]></Title> <Description><![CDATA['.iconv('gbk','UTF-8',$tw_out[1]).']]></Description> <PicUrl><![CDATA['.$tw_out[2].']]></PicUrl>
						<Url><![CDATA['.$tw_out[3].']]></Url> 
						</item>
						';
				}
				$resultStr .= '
				</Articles> 
					<FuncFlag>1</FuncFlag>
					</xml>';			
			}else{
				$msgType = "text";
				$contentStr = $gz_neirong;
				$resultStr = sprintf($textTpl, $fromusername, $tousername, $time, $msgType, iconv('gbk','UTF-8',$contentStr));
			}
			echo $resultStr;
       }
	}else {
		$echoStr = $_GET["echostr"];
		echo $echoStr;
		exit;
	}
}

//
function huifutuwen($twarr){

}//end func
?>