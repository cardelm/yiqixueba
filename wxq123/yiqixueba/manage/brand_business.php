<?php

/**
*	一起学吧平台程序
*	文件名：brand_business.php  创建时间：2013-6-22 17:12  杨文
*
*/

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$this_page = 'plugin.php?id=yiqixueba:manage&man=brand&subman=business';

$businessid = intval(getgpc('businessid'));
$business_info = $businessid ? DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_brand_business')." WHERE businessid=".$businessid) : array();

$type == trim('type');

$joinstep = intval(getgpc('joinstep'));

if(!$businessid && $type == 'editbusiness'){
}


?>
