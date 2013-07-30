<?php

/**
*
*	文件名：api.inc.php 创建时间：2013-7-27 15:39  杨文
*	修改时间：2013-7-29 08:44 杨文
*/
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
$indata = addslashes($_GET['indata']);
$sign = addslashes($_GET['sign']);
$apiaction = addslashes($_GET['apiaction']);


$outdata = array();

if($sign != md5(md5($indata))) {
	$outdata[] = lang('plugin/yiqixueba_server','api_sign_error');
}
if(!$apiaction) {
	$outdata[] = lang('plugin/yiqixueba_server','api_apiaction_error');
}


$indata = base64_decode($indata);
$indata = dunserialize($indata);
////////////////////////////////////////





////////////////////////////////////////
if(is_array($outdata)){
	require_once libfile('class/xml');
	$filename = $apiaction.'.xml';
	$plugin_export = array2xml($outdata, 1);
	ob_end_clean();
	dheader('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
	dheader('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT');
	dheader('Cache-Control: no-cache, must-revalidate');
	dheader('Pragma: no-cache');
	dheader('Content-Encoding: none');
	dheader('Content-Length: '.strlen($plugin_export));
	dheader('Content-Disposition: attachment; filename='.$filename);
	dheader('Content-Type: text/xml');
	echo $plugin_export;
	define('FOOTERDISABLED' , 1);
	exit();
}else{
	echo $outdata;
}

?>