<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
$mod = $_GET['mod'];

$modarray = array('index','xfjl','shopsetting','goods','groupbuy','adddianyuan','consume','member','login');

$mod = !in_array($mod,$modarray)?'index':$mod;

$navtitle = '���̹���';

if($mod == 'login') {
	$navtitle = 'һ��ͨ��¼';
	require dirname(__FILE__).'/source/module/yktmanage_'.$mod.'.php';
	exit();
}

if($_G['uid'] == 0 ) {
	showmessage('��Ҫ��¼', '', array(), array('login' => true));
}
$shop_sortid = DB::result_first("SELECT value FROM ".DB::table('brand_settings')." WHERE variable='shop_zidingyi'");
$shop_fid = DB::result_first("SELECT value FROM ".DB::table('brand_settings')." WHERE variable='shop_forum'");
if(DB::result_first("SELECT count(*) FROM ".DB::table('forum_typeoptionvar')." WHERE optionid=".(DB::result_first("SELECT optionid FROM ".DB::table('forum_typeoption')." WHERE identifier='ykt_UID'"))." and value = '".$_G['uid']."'")==0) {
	showmessage('����û���Լ��ĵ���', 'forum.php?mod=post&action=newthread&fid='.$shop_fid.'&sortid='.$shop_sortid);
}
$shopid = $_GET['shopid'];

$template = DB::result_first("SELECT directory FROM ".DB::table('common_template')." WHERE templateid='".DB::result_first("SELECT value FROM ".DB::table('brand_settings')." WHERE variable='ykt_template'")."'");

require dirname(__FILE__).'/source/module/yktmanage_'.$mod.'.php';


?>