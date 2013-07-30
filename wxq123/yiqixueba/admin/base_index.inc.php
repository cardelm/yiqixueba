<?php

/**
*	一起学吧平台程序
*	文件名：base_index.inc.php  创建时间：2013-6-4 09:34  杨文
*
*/

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
$this_page = 'plugins&identifier=yiqixueba&pmod=admin&submod=index';

showtableheader(lang('plugin/yiqixueba','base_index_status'));
$newshopnum = DB::result_first("SELECT count(*) FROM ".DB::table('yiqixueba_brand_shop')." WHERE status = 0");
showtablerow('', array('class="td28"',''), array(
	'新注册的商家：'.DB::result_first("SELECT count(*) FROM ".DB::table('yiqixueba_brand_shop')." WHERE status = 0").'个店铺需要审核',
));
showtablefooter();
showtableheader(lang('plugin/yiqixueba','base_index_system'));
showtablerow('', array('class="td28"',''), array(
	$row['businessname'],
	$row['businessname'],

));
showtableheader(lang('plugin/yiqixueba','base_index_mingxie'));
showtablerow('', array('class="td28"',''), array(
	$row['businessname'],
	$row['businessname'],

));
showtablefooter();
?>