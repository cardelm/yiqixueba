<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
var_dump('dasd');
$indata = addslashes($_GET['indata']);
$sign = addslashes($_GET['sign']);
$apiaction = addslashes($_GET['apiaction']);


$outdata = array();

if($sign != md5(md5($indata))) {
	$outdata[] = lang('plugin/'.$plugin['identifier'],'api_sign_error');
}
if(!$apiaction) {
	$outdata[] = lang('plugin/'.$plugin['identifier'],'api_apiaction_error');
}


$indata = base64_decode($indata);
$indata = dunserialize($indata);
////////////////////////////////////////
if($apiaction == 'install'){
	if(DB::result_first("SELECT count(*) FROM ".DB::table('yiqixueba_server_site')." WHERE siteurl='".$indata['siteurl']."'")==0){
		$data = array();
		$data['salt'] = random(6);
		$data['charset'] = $indata['charset'];
		$data['clientip'] = $indata['clientip'];
		$data['version'] = $indata['version'];
		$data['siteurl'] = $indata['siteurl'];
		$data['sitekey'] = md5($indata['siteurl'].$data['salt']);
		$data['sitegroup'] = 1;
		$data['installtime'] = time();
		DB::insert('yiqixueba_server_site', $data);
	}
	$outdata = $indata;
}


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
var_dump('dasd');

?>