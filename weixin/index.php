<?php

/**
 *      [wxq123!] (C)2001-2099 wxq123.
 *      This is NOT a freeware
 *
 *      $Id: weixin/index.php 001 2013-03-25 06:53:01Z yangwen $
 */

define('APPTYPEID', 0);
define('CURSCRIPT', 'weixin');


require_once '../source/class/class_core.php';
$discuz = C::app();
$discuz->init();

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

//require_once '../source/plugin/wxq123/source/function/function_server.php';
require_once 'source/function_server.php';

$sbm = trim($_GET['sbm']);//读取识别码
$sitesbm = substr($sbm,0,4);//截取前四位，判断是否是站长
$weixin_info = DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_server_wxq123_member')." WHERE shibiema='".$sitesbm."'");//读取站长信息
if ($sbm == $sitesbm){//站长操作
	$token = $weixin_info['token'];
}else{//站长下的微信用户操作
	$indata['sbm'] = $sbm;
	$outdata = get_client_data('gettoken',$site_info,$indata);
	$token = $outdata['token'];
}
//
$signature = trim(htmlspecialchars($_GET["signature"]));
$timestamp = trim(htmlspecialchars($_GET["timestamp"]));
$nonce = trim(htmlspecialchars($_GET["nonce"]));
$tmpArr = array($token, $timestamp, $nonce);
sort($tmpArr);
$tmpStr = implode( $tmpArr );
$tmpStr = sha1( $tmpStr );

if( $tmpStr == $signature ){
	$postStr = file_get_contents("php://input");
	if (!empty($postStr)){
		$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);

		$inputtype = $postObj->MsgType;
		$createtime = $postObj->CreateTime;
		$fromusername = $postObj->FromUserName;
		$tousername = $postObj->ToUserName;
		$wxintdata['inputtype'] =  trim($inputtype);
		$wxintdata['createtime'] =  trim($createtime);
		$wxintdata['fromusername'] =  trim($fromusername);
		$wxintdata['tousername'] =  trim($tousername);
		if($inputtype == 'text'){
			$content = iconv('UTF-8','gbk',trim($postObj->Content));
			$wxintdata['content'] = iconv('UTF-8','gbk',trim($postObj->Content));
			$keyword = $content?true:false;
		}elseif($inputtype == 'location'){
			$location_x = trim($postObj->Location_X);
			$location_y = trim($postObj->Location_Y);
			$scale = trim($postObj->Scale);
			$label = iconv('UTF-8','gbk',trim($postObj->Label));
			$wxintdata['content'] = (array('location_x'=>trim($postObj->Location_X),'location_y'=>trim($postObj->Location_Y),'scale'=>trim($postObj->Scale),'label'=>iconv('UTF-8','gbk',trim($postObj->Label))));
			$keyword = ($location_x&&$location_y)?true:false;
		}elseif($inputtype == 'image'){
			$picurl = trim($postObj->PicUrl);
			$wxintdata['content'] = trim($postObj->PicUrl);
			$keyword = $picurl?true:false;

		}elseif($inputtype == 'link'){
			$linktitle = trim($postObj->Title);
			$linkdescription = trim($postObj->Description);
			$linkurl = trim($postObj->Url);
			$wxintdata['content'] = (array('linktitle'=>trim($postObj->Title),'linkdescription'=>trim($postObj->Description),'linkurl'=>trim($postObj->Url)));
			$keyword = $picurl?true:false;
		}elseif($inputtype == 'event'){
			$event = $postObj->Event;
			$eventkey = $postObj->EventKey;
			//$wxintdata['content'] = serialize(array('event'=>$postObj->Event,'eventkey'=>$postObj->EventKey));
			$wxintdata['content'] = (array('event'=>$postObj->Event,'eventkey'=>$postObj->EventKey));
			$keyword = $eventkey?true:false;
		}
		//system_log();
		//$wxoutdata = get_client_data('getoutdata',$site_info,$wxintdata);
		//reg_member(htmlspecialchars($fromusername));
		$data['time'] = time();
		$data['postxml'] = htmlspecialchars(trim($postStr)).$keyword;
		$data['type'] = htmlspecialchars($inputtype);
		$data['inputtype'] = $type;
		$data['get'] = $_GET ? serialize($_GET) : 'kong';
		$data['post'] = $_POST?serialize($_POST):'kong';
		$data['fromusername'] = htmlspecialchars($fromusername);
		$data['tousername'] = htmlspecialchars($tousername);
		DB::insert('wxq123_weixin_temp',$data);
		require_once 'source/'.$inputtype.'.php';
//		$indata['inputtype'] = htmlspecialchars($inputtype);
//		$indata['fromusername'] = htmlspecialchars($fromusername);
//		$indata['tousername'] = htmlspecialchars($tousername);
//		$indata['keyword'] = $keyword;
		$indata['postxml'] = htmlspecialchars(trim($postStr));
		api_indata('addwxjilu',$indata);
		if(!empty( $keyword )) {
			$music_info = array();
			$music_info['title'] = "谢雨欣【老公老公我爱你】";
			$music_info['description'] = "微信音乐回复测试";
			$music_info['music_url'] = "http://www.wxq123.com/lglgwan.mp3";
			$music_info['hq_music_url'] = "http://www.wxq123.com/lglgwan.mp3";
			echo display_music($music_info);
			//display_help('news');
			//echo display_text($wxoutdata['fromusername']);
			//echo display_news($newsarray);
		}else{//关注回复
			echo display_text('fsdafsdf');
			//display_help('news');
		}
	}else {
		$echoStr = $_GET["echostr"];
		DB::update('yiqixueba_server_wxq123_member',array('tijiaotime'=>time()),array('shibiema'=>$sbm));
		echo $echoStr;
		exit;
	}
}else{
	DB::update('yiqixueba_server_wxq123_member',array('tijiaotime'=>0),array('shibiema'=>$sbm));
}
//var_dump(display_help('news'));
//var_dump('nasdj');
//var_dump(DB::fetch_first("SELECT * FROM ".DB::table('wxq123_member')." WHERE uid=1"));

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
			'url'=>"",
		);
		//var_dump(display_news($newsarray));
		echo display_news($newsarray);
	}
	//return $content;
}//end func

//api_api_indata
function api_indata($apiaction,$indata=array()){
	global $_G,$indata,$sitesbm;
	$site_info = DB::fetch_first("SELECT siteurl FROM ".DB::table('yiqixueba_server_site')." WHERE shibiema='".$sitesbm."'");
	if(fsockopen($site_info['siteurl'], 80)){
		$indata['sitekey'] = $site_info['sitekey'];
		$indata['siteurl'] = $site_info['siteurl'];
		if($site_info['charset']=='gbk') {
			foreach ( $indata as $k=>$v) {
				//$indata[$k] = diconv($v,$_G['charset'],'utf8');
			}
		}
		$indata = serialize($indata);
		$indata = base64_encode($indata);
		$api_url =$site_info['siteurl'].'plugin.php?id=yiqixueba:api&apiaction='.$apiaction.'&indata='.$indata.'&sign='.md5(md5($indata));
		$xml = @file_get_contents($api_url);
		require_once libfile('class/xml');
		$outdata = is_array(xml2array($xml)) ? xml2array($xml) : $xml;
		return $outdata;
	}else{
		return false;
	}
}//end func
?>