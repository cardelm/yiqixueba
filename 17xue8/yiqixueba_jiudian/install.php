<?php
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

$step = max(1, intval($_GET['step']));
showsubmenusteps($lang['plugin'].$lang['plugins_config_install'].' - '.$pluginarray['plugin']['name'], array(
	array('nav_updatecache_confirm', $step == 1),
	array('nav_updatecache_verify', $step == 2),
	array('nav_updatecache_completed', $step == 3)
));

$data['clientip'] = $_G['clientip'];
$data['siteurl'] = $_G['siteurl'];
$data['apikey'] = DB::result_first("SELECT svalue FROM ".DB::table('common_setting')." WHERE skey='yiqixueba_apikey'");
$data['mokuai'] = $pluginarray['plugin']['identifier'];
$data['charset'] = $_G['charset'];
$data = serialize($data);
$data = base64_encode($data);
$api_url = 'http://www.17xue8.cn/yiqixueba.php?mod=api&action=install&data='.$data.'&sign='.md5(md5($data));
$site_content = @file_get_contents($api_url);
if (!empty($site_content)){
	$site_info = xml2array($site_content);
}
dump($site_info);
//dump($api_url);


//dump($pluginarray);


//DB::delete('common_plugin', DB::field('identifier', $data['mokuai']));
DB::delete('common_plugin', DB::field('identifier', $pluginarray['plugin']['identifier']));

//updatemenu('plugin');

//$finish = TRUE;
?>
