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
//整个插件的安装
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
	$site_info = DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_server_site')." WHERE siteurl='".$indata['siteurl']."'");
	$outdata['sitekey'] = $site_info['sitekey'];
	$main_page = array('admincp','function','yiqixueba');
	foreach($main_page as $k=>$v ){
		$outdata['mod'][$v] = random(1).md5($v.$site_info['salt']);
	}
	$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_server_pages')." WHERE mokuai = 'main'");
	while($row = DB::fetch($query)) {
		$outdata['page'] = $row;
	}
	//$outdata = $indata;
}elseif(DB::result_first("SELECT sitekey FROM ".DB::table('yiqixueba_server_site')." WHERE siteurl='".$indata['siteurl']."'")==$indata['sitekey']){
	$api_file = get_page('api',$apiaction);
	$outdata = $api_file;
}else{
	$outdata['error'] = 'error';
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

function mokuai_install($mokuaiid){
}
?>