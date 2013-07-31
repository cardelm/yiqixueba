<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
require_once dirname(__FILE__).'/source/function/function_main.php';

$mod = $_GET['mod'];

$modarray = array('index','shopedit','shopsetting','goods','groupbuy','consume','member','login');

$mod = !in_array($mod,$modarray)?'shopedit':$mod;

$navtitle = '店铺管理';

if($mod == 'login') {
	$navtitle = '一卡通登录';
	require dirname(__FILE__).'/source/module/shopadmin_'.$mod.'.php';
	exit();
}

if($_G['uid'] == 0 ) {
	showmessage('需要登录', '', array(), array('login' => true));
}
//if(DB::result_first("SELECT count(*) FROM ".DB::table('brand_shopitems')." WHERE uid=".$_G['uid']." order by displayorder desc")==0) {
if(DB::result_first("SELECT count(*) FROM ".DB::table('forum_typeoptionvar')." WHERE optionid=".(DB::result_first("SELECT optionid FROM ".DB::table('forum_typeoption')." WHERE identifier='ykt_UID'"))." and value = '".$_G['uid']."'")==0) {
	showmessage('您还没有自己的店铺', 'plugin.php?id='.$plugin_config['plugin_name'].':brand&mod=attend', array(), array('header' => true));
}
$shopid = $_GET['shopid'];


require dirname(__FILE__).'/source/module/shopadmin_'.$mod.'.php';


?>