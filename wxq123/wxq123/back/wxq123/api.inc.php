<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
$apidata = trim($_GET['apidata']);
$sign = trim($_GET['sign']);
if($sign != md5(md5($apidata))){
	echo 'system_error';
	exit();
}
$apidata = base64_decode($apidata);
$apidata = dunserialize($apidata);
$apidata['siteurl'] = $apidata['siteurl'];
$apidata['searchurl'] = str_replace("http://","",$apidata['siteurl']);
$apidata['searchurl'] = str_replace("www.","",$apidata['searchurl']);
if ($apidata['action']){
	$api_file = DISCUZ_ROOT.'source/plugin/wxq123/api/'.$apidata['action'].'.php';
}else{
	$api_file = DISCUZ_ROOT.'source/plugin/wxq123/api/error.php';
}
if (file_exists($api_file)){
	require_once $api_file;
}else{
	$outdata['error'] = lang('plugin/wxq123','action_error');
}
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

?>