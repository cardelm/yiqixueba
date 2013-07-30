<?php


if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
$query = DB::query("SELECT * FROM ".DB::table('wxq123_setting'));
while($row = DB::fetch($query)) {
	$wxq123_setting[$row['skey']] = $row['svalue'];
}
if(!$wxq123_setting['sitekey'] || !$wxq123_setting['shibiema']) {
	cpmsg(lang('plugin/wxq123', 'wxq123_daoban_error'));
}
function get_server_data($action,$apidata = array()){
	global $_G,$wxq123_setting;
	$apidata['clientip'] = $_G['clientip'];
	$apidata['siteurl'] = $_G['siteurl'];
	$apidata['charset'] = $_G['charset'];
	$apidata['sitekey'] = $wxq123_setting['sitekey'];
	$apidata['action'] = $action;
	$apidata = serialize($apidata);
	$apidata = base64_encode($apidata);
	$api_url = 'http://www.wxq123.com/plugin.php?id=wxq123:api&apidata='.$apidata.'&sign='.md5(md5($apidata));
	$xml = @file_get_contents($api_url);
	require_once libfile('class/xml');
	$outdata = xml2array($xml);

	return $outdata;
}



?>