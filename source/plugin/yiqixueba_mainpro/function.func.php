<?php

/**
*	平台主程序模块函数集
*	filename:function.func.php createtime:2013-7-30 09:59  yangwen
*
*/

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

function get_site_info(){
	$indata = array();
	return api_indata('getsiteinfo',$indata);
}

function plugin_install(){
	global $_G;
	require_once DISCUZ_ROOT.'/source/discuz_version.php';
	$installdata['charset'] = $_G['charset'];
	$installdata['clientip'] = $_G['clientip'];
	$installdata['siteurl'] = $_G['siteurl'];
	$installdata['version'] = DISCUZ_VERSION.'-'.DISCUZ_RELEASE.'-'.DISCUZ_FIXBUG;
}

//api_api_indata
function api_indata($apiaction,$indata){
	global $_G,$sitekey;
	$indata['sitekey'] = $sitekey;
	$indata['siteurl'] = $_G['siteurl'];
	$indata = serialize($indata);
	$indata = base64_encode($indata);
	$api_url = 'http://www.wxq123.com/plugin.php?id=yiqixueba_server:api&apiaction='.$apiaction.'&indata='.$indata.'&sign='.md5(md5($indata));
	$xml = @file_get_contents($api_url);
	require_once libfile('class/xml');
	$outdata = is_array(xml2array($xml)) ? xml2array($xml) : $xml;
	return $api_url;
}//end func

?>