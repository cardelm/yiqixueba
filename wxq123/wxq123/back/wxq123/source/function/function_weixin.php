<?php
//这个是客户端微信函数

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

function out_data($outdata){
	if(is_array($outdata)){
		require_once libfile('class/xml');
		$filename = $data['action'].'.xml';
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