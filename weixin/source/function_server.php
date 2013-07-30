<?php

function get_client_data($action,$site_info,$indata){
	global $_G;
	$indata['charset'] = $_G['charset'];
	$indata['sitekey'] = $site_info['sitekey'];
	$indata['action'] = $action;
	$indata = serialize($indata);
	file_put_contents(DISCUZ_ROOT.'weixin/ttt.txt',$indata);
	$indata = base64_encode($indata);
	$api_url = $site_info['siteurl'].'plugin.php?id=wxq123:weixin&indata='.$indata.'&sign='.md5(md5($indata));
	$xml = @file_get_contents($api_url);
	require_once libfile('class/xml');
	$outdata = xml2array($xml);
	return $outdata;
}


function system_log(){
	global $wxintdata;
}
?>