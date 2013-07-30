<?php

/**
 *      [17xue8.cn] (C)2013-2099 杨文.
 *      这不是免费的。
 *
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

require_once DISCUZ_ROOT.'source/plugin/wxq123/source/function/function_main.php';
$indata = trim($_GET['indata']);
$sign = trim($_GET['sign']);
if($sign != md5(md5($indata))){
	echo 'system_error';
	exit();
}
$indata = base64_decode($indata);
$indata = dunserialize($indata);

if ( $wxq123_setting['sitekey'] != $indata['sitekey'] ){
	$outdata['error'] = 'sitekey error!';
	exit();
}

$action = $indata['action'];
$outdata['action'] = $action;
if ($action == 'gettoken' ){
	$outdata['token'] = 'uighjg';
}elseif($action == 'getoutdata'){
	$outdata = $indata;
}
$outdata = out_data($outdata);

function out_data($outdata){
	if(is_array($outdata)){
		require_once libfile('class/xml');
		$filename = $outdata['action'].'.xml';
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
	}
}
?>