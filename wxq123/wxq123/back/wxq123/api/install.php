<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
//$apidata['siteurl'] = $_G['siteurl'];
$indata['siteurl'] = $apidata['siteurl'];
$apidata['searchurl'] = str_replace("http://","",$apidata['siteurl']);
$indata['searchurl'] = str_replace("www.","",$apidata['searchurl']);
$indata['charset'] = $apidata['charset'];
$indata['clientip'] = $apidata['clientip'];
$indata['updatetime'] = TIMESTAMP;

if (DB::result_first("SELECT count(*) FROM ".DB::table('wxq123_server_site')." WHERE siteurl='".$indata['siteurl']."' or searchurl='".$indata['searchurl']."'")==0){
	$shibiema = random(4,1);
	while(DB::result_first("SELECT count(*) FROM ".DB::table('wxq123_server_site')." WHERE shibiema='".$shibiema ."'")) {
		$shibiema = random(4,1);
	}
	$indata['token'] = random(6,0);
	$indata['shibiema'] = $shibiema;
	$indata['salt'] = random(6);
	$indata['installtime'] = TIMESTAMP;
	$indata['sitekey'] = md5(md5($indata['siteurl']).$indata['salt']);
	DB::insert('wxq123_server_site',$indata);
}else{
	DB::update('wxq123_server_site',$indata,array('siteurl'=>$indata['siteurl']));
}
$outdata = DB::fetch_first("SELECT sitekey,shibiema,token FROM ".DB::table('wxq123_server_site')." WHERE siteurl='".$indata['siteurl']."'");
//foreach ($outdata as $k=>$v){
//	if(DB::result_first("SELECT count(*) FROM ".DB::table('wxq123_setting')." WHERE skey='".$k."'")==0) {
//		DB::insert('wxq123_setting',array('skey'=>$k,'svalue'=>$v));
//	}else{
//		DB::update('wxq123_setting',array('svalue'=>$v),array('skey'=>$k));
//	}
//}
//$outdata = array();

?>