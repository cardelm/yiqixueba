<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
require_once DISCUZ_ROOT.'source/plugin/yiqixueba/function.func.php';

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
$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_mokuai')." WHERE available=1 order by displayorder asc");
while($row = DB::fetch($query)) {
	$api_file = DISCUZ_ROOT.'source/plugin/yiqixueba/source/'.md5($row['mokuaikey'].'api').'.php';
	////////////////debug//////////////////////
	$server_mokuaiid = DB::result_first("SELECT mokuaiid FROM ".DB::table('yiqixueba_server_mokuai')." WHERE identifier='".$row['identifier']."' AND currentversion = 1");
	if($server_mokuaiid && file_exists(DISCUZ_ROOT.'source/plugin/yiqixueba/mokuai/'.$server_mokuaiid.'/api.inc.php')){
		file_put_contents($api_file,file_get_contents(DISCUZ_ROOT.'source/plugin/yiqixueba/mokuai/'.$server_mokuaiid.'/api.inc.php'));
	}
	////////////////debug//////////////////////
	if(file_exists($api_file)){
		require_once $api_file;
	}
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

?>