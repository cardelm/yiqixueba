<?php


if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
require_once dirname(__FILE__).'/source/function/function_main.php';
$baction = $_GET['baction']?$_GET['baction']:'index';

if(DB::result_first("SELECT count(*) FROM ".DB::table('common_pluginvar')." WHERE variable like 'ykt_%'")>0){
	require_once 'source/plugin/yikatong/install.php';
}

$site_key = DB::result_first("SELECT svalue FROM ".DB::table('common_setting')." WHERE skey='yikatong_api_key'");
if($site_key==false) {
	echo '请与一卡通官方联系，设定您的使用城市';
	require_once 'source/plugin/yikatong/source/admin/setting_reg.inc.php';
}else{
	$admincp_url = 'http://www.17xue8.cn/xueba.php?mod=api&type=getadmincp&baction='.$_GET['baction'].'&bmenu='.$_GET['bmenu'].'&charset='.strtolower($_G['charset']).'&data='.$site_key.'&sign='.md5(md5($site_key));
	$output_text = file_get_contents($admincp_url);
	$output_arr = unserialize($output_text);

	if(!in_array($baction, $output_arr['cp'])) {
		cpmsg('您没有权限');
	}
	showsubmenu('商家联盟', $output_arr['menus'], '<a href="'.$_G['siteurl'].'plugin.php?id=yikatong:brand" target="_blank" class="bold" style="float:right;padding-right:40px;">商家联盟首页</a>');
	$_GET['page'] = $_GET['page']?$_GET['page']:1;

	require_once 'source/plugin/yikatong/source/admin/'.$baction.'.inc.php';
}
?>