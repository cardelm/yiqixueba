<?php

/**
*	һ��ѧ��ƽ̨����
*	�ļ�����brand_business.php  ����ʱ�䣺2013-6-22 17:12  ����
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
