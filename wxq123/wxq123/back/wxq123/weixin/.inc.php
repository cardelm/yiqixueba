<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$signature = trim(htmlspecialchars($_GET["signature"]));
$timestamp = trim(htmlspecialchars($_GET["timestamp"]));
$nonce = trim(htmlspecialchars($_GET["nonce"]));
$type = trim(htmlspecialchars($_GET["wxqtype"]));
$token = $_G['cache']['plugin']['wxq123']['weixintoken'];
$tmpArr = array($token, $timestamp, $nonce);
sort($tmpArr);
$tmpStr = implode( $tmpArr );
$tmpStr = sha1( $tmpStr );

if( $tmpStr == $signature ){
	$postStr = file_get_contents("php://input");

	if (!empty($postStr)){
		$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
		$inputtype = $postObj->MsgType;
		require_once('source/plugin/wxq123/weixin/weixin_'.$inputtype.'.php');
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
		}elseif($inputtype == 'event'){
		}
		$fromusername = $postObj->FromUserName;
		reg_member(htmlspecialchars($fromusername));
		$tousername = $postObj->ToUserName;
		$data['time'] = time();
		$data['postxml'] = htmlspecialchars(trim($postStr)).$keyword;
		$data['type'] = htmlspecialchars($inputtype);
		$data['inputtype'] = $type;
		$data['fromusername'] = htmlspecialchars($fromusername);
		$data['tousername'] = htmlspecialchars($tousername);
		DB::insert('wxq123_weixin_temp',$data);
		if(!empty( $keyword )) {
			$music_info = array();
			$music_info['title'] = "谢雨欣【老公老公我爱你】";
			$music_info['description'] = "微信音乐回复测试";
			$music_info['music_url'] = "http://www.wxq123.com/lglgwan.mp3";
			$music_info['hq_music_url'] = "http://www.wxq123.com/lglgwan.mp3";
			//echo display_music($music_info);
			display_help('news');
			//echo display_text('fsdafsdf');
			//echo display_news($newsarray);
		}else{//关注回复
			echo display_text('fsdafsdf');
			//display_help('news');
		}
	}else {
		$echoStr = $_GET["echostr"];
		echo $echoStr;
		exit;
	}
}
//var_dump(display_help('news'));

//display_help('news');

//
function display_text($contentStr,$FuncFlag = 0) {
	global $_G,$fromusername, $tousername;
	$contentStr = $_G['charset'] == 'gbk' ? iconv('gbk','UTF-8',$contentStr) : $contentStr;
	$return = "<xml>
	<ToUserName><![CDATA[$fromusername]]></ToUserName>
	<FromUserName><![CDATA[$tousername]]></FromUserName>
	<CreateTime>".time()."</CreateTime>
	<MsgType><![CDATA[text]]></MsgType>
	<Content><![CDATA[$contentStr]]></Content>
	<FuncFlag>$FuncFlag</FuncFlag>
	</xml>";
	return $return;

}//end func
//
function display_music($music_info,$FuncFlag = 0) {
	global $_G,$fromusername, $tousername;
	$title = $_G['charset'] == 'gbk' ? iconv('gbk','UTF-8',$music_info['title']):$music_info['title'];
	$description = $_G['charset'] == 'gbk' ? iconv('gbk','UTF-8',$music_info['description']): $music_info['description'];
	$return ="<xml>
		 <ToUserName><![CDATA[$fromusername]]></ToUserName>
		 <FromUserName><![CDATA[$tousername]]></FromUserName>
		 <CreateTime>".time()."</CreateTime>
		 <MsgType><![CDATA[music]]></MsgType>
		 <Music>
		 <Title><![CDATA[$title]]></Title>
		 <Description><![CDATA[$description]]></Description>
		 <MusicUrl><![CDATA[$music_info[music_url]]]></MusicUrl>
		 <HQMusicUrl><![CDATA[$music_info[hq_music_url]]]></HQMusicUrl>
		 </Music>
		 <FuncFlag>0</FuncFlag>
		 </xml>";
	return $return;
}//end func
//
function display_news($newsarray,$FuncFlag = 0) {
	global $_G,$fromusername, $tousername;
	$return = "<xml>
		 <ToUserName><![CDATA[$fromusername]]></ToUserName>
		 <FromUserName><![CDATA[$tousername]]></FromUserName>
		 <CreateTime>".time()."</CreateTime>
		 <MsgType><![CDATA[news]]></MsgType>
		 <ArticleCount>".count($newsarray)."</ArticleCount>
		 <Articles>";
		foreach ( $newsarray as $news) {
			$title = $_G['charset'] == 'gbk' ? iconv('gbk','UTF-8',$news['title']):$news['title'];
			$description = $_G['charset'] == 'gbk' ? iconv('gbk','UTF-8',$news['description']):$news['description'];
			$return .="<item>
				 <Title><![CDATA[".$title."]]></Title>
				 <Description><![CDATA[".$description."]]></Description>
				 <PicUrl><![CDATA[".$news['picurl']."]]></PicUrl>
				 <Url><![CDATA[".$news['url']."]]></Url>
				 </item>";
		}
	$return .="</Articles>
		 <FuncFlag>$FuncFlag</FuncFlag>
		 </xml>";

	return $return;
}//end func
//
function reg_member($fromusername) {
	if(!empty($fromusername)) {
		if(DB::result_first("SELECT count(*) FROM ".DB::table('wxq123_member')." WHERE wid='".$fromusername."'")==0) {
			DB::insert('wxq123_member',array('wid'=>$fromusername,'regtime'=>time()));
		}
	}
	return ;
}//end func

//
function display_help($type='') {
	global $_G;
	if($type=='') {
		$type = 'text';
	}
	if($type == 'text') {
		$content = "欢迎关注微信墙123\n";
		$content .= "--------------------------\n";
		$query = DB::query("SELECT * FROM ".DB::table('wxq123_mokuai')." order by displayorder asc");
		while($row = DB::fetch($query)) {
			$content .= "发送“".$row['wxsearch']."”进入".$row['mokuaititle']."\n";
		}
		$content .= "--------------------------\n";
		$content .= "发送“0”返回本页面";
		echo display_text($content);
	}elseif($type == 'news'){
		$newsarray[] = array(
			'title'=>"欢迎关注微信墙123",
			'description'=>"欢迎关注微信墙123",
			'picurl'=>"http://www.wxq123.com/source/plugin/wxq123/style/image/wxq123.jpg",
			'url'=>"",
		);
		$query = DB::query("SELECT * FROM ".DB::table('wxq123_mokuai')." WHERE status = 1 order by displayorder asc");
		while($row = DB::fetch($query)) {
			$mokuaiico = '';
			if($row['mokuaiico']!='') {
				$mokuaiico = str_replace('{STATICURL}', STATICURL, $row['mokuaiico']);
				if(!preg_match("/^".preg_quote(STATICURL, '/')."/i", $mokuaiico) && !(($valueparse = parse_url($mokuaiico)) && isset($valueparse['host']))) {
					$mokuaiico = $_G['siteurl'].$_G['setting']['attachurl'].'temp/'.$row['mokuaiico'].'?'.random(6);
				}
			}
			$newsarray[] = array(
				'title'=>$row['mokuaititle']."\n".$row['mokuaidescription'],
				'description'=>$row['mokuaidescription'],
				'picurl'=>$mokuaiico,
				'url'=>'http://www.wxq123.com/plugin.php?id=wxq123:moblic&mokuaiid=1',
			);
		}
		$newsarray[] = array(
			'title'=>"帮助信息",
			'description'=>"发送“0”返回本页面",
			'picurl'=>"欢迎关注微信墙123",
			'url'=>"http://www.wxq123.com/plugin.php?id=wxq123:weixin&shopid=123",
		);
		//var_dump(display_news($newsarray));
		echo display_news($newsarray);
	}
	//return $content;
}//end func

?>