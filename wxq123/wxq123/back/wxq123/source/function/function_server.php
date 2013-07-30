<?php

function get_client_data($action,$site_info,$indata){
	$indata = init_data($indata,$site_info);
	$indata['action'] = $action;
	$indata = serialize($indata);
	$indata = base64_encode($indata);
	$api_url = $site_info['siteurl'].'plugin.php?id=wxq123:weixin&indata='.$indata.'&sign='.md5(md5($indata));
	$xml = @file_get_contents($api_url);
	require_once libfile('class/xml');
	$outdata = xml2array($xml);
	return $outdata;
}

function init_data($indata,$site_info){
	global $_G;
	$indata = $indata;
	$indata['charset'] = $_G['charset'];
	$indata['sitekey'] = $site_info['sitekey'];
	return $indata;
}

function system_log(){
	global $wxintdata;
}
?>