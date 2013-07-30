<?php
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
$apidata['clientip'] = $_G['clientip'];
$apidata['siteurl'] = $_G['siteurl'];
$apidata['charset'] = $_G['charset'];
$apidata['sitekey'] = $wxq123_setting['sitekey'];
$apidata['action'] = 'install';
$apidata = serialize($apidata);
$apidata = base64_encode($apidata);
//$api_url = 'http://www.wxq123.com/plugin.php?id=wxq123:api&apidata='.$apidata.'&sign='.md5(md5($apidata));
$api_url = 'http://www.wxq123.com/plugin.php?id=wxq123:api&apidata='.$apidata.'&sign='.md5(md5($apidata));
$xml = @file_get_contents($api_url);
require_once libfile('class/xml');
$outdata = xml2array($xml);
if (is_array($outdata)){
	foreach ($outdata as $k=>$v){
		if(DB::result_first("SELECT count(*) FROM ".DB::table('wxq123_setting')." WHERE skey='".$k."'")==0) {
			DB::insert('wxq123_setting',array('skey'=>$k,'svalue'=>$v));
		}else{
			DB::update('wxq123_setting',array('svalue'=>$v),array('skey'=>$k));
		}
	}
}

?>