<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
require_once dirname(__FILE__).'/source/function/function_main.php';

$mod = $_GET['mod'];

$modarray = array('index','shopedit','shopsetting','goods','groupbuy','consume','member','login');

$mod = !in_array($mod,$modarray)?'shopedit':$mod;

$navtitle = '���̹���';

if($mod == 'login') {
	$navtitle = 'һ��ͨ��¼';
	require dirname(__FILE__).'/source/module/shopadmin_'.$mod.'.php';
	exit();
}

if($_G['uid'] == 0 ) {
	showmessage('��Ҫ��¼', '', array(), array('login' => true));
}
//if(DB::result_first("SELECT count(*) FROM ".DB::table('brand_shopitems')." WHERE uid=".$_G['uid']." order by displayorder desc")==0) {
if(DB::result_first("SELECT count(*) FROM ".DB::table('forum_typeoptionvar')." WHERE optionid=".(DB::result_first("SELECT optionid FROM ".DB::table('forum_typeoption')." WHERE identifier='ykt_UID'"))." and value = '".$_G['uid']."'")==0) {
	showmessage('����û���Լ��ĵ���', 'plugin.php?id='.$plugin_config['plugin_name'].':brand&mod=attend', array(), array('header' => true));
}
$shopid = $_GET['shopid'];


require dirname(__FILE__).'/source/module/shopadmin_'.$mod.'.php';


?>