<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$temp_name = DB::result_first("SELECT svalue FROM ".DB::table('common_setting')." WHERE skey='site_template'");

$temp_name = $temp_name?$temp_name:'default';

$temp_name = 'fang19';

$plugin_config = array();
$plugin_config['plugin_name'] = 'yikatong';
$plugin_config['plugin_path'] = 'source/plugin/yikatong';
$plugin_config['template_name'] = 'site/'.$temp_name;
$plugin_config['jspath'] = 'source/plugin/yikatong/template/site/'.$temp_name.'/style/js';
$plugin_config['imagespath'] = 'source/plugin/yikatong/template/site/'.$temp_name.'/style/image';
$plugin_config['csspath'] = 'source/plugin/yikatong/template/site/'.$temp_name;
$plugin_config['store_template_name'] = 'store/'.$temp_name;
$plugin_config['store_jspath'] = 'source/plugin/yikatong/template/store/'.$temp_name.'/style/js';
$plugin_config['store_imagespath'] = 'source/plugin/yikatong/template/store/'.$temp_name.'/style/image';
$plugin_config['store_csspath'] = 'source/plugin/yikatong/template/store/'.$temp_name;
?>
