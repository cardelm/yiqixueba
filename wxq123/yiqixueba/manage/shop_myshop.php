<?php

/**
*	һ��ѧ��ƽ̨����
*	�ļ�����shop_myshop.php  ����ʱ�䣺2013-6-11 02:26  ����
*
*/

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
//$yikatong_fields = dunserialize($base_setting['yiqixueba_yikatong_fields']);
//$shop_table = $base_setting['yiqixueba_yikatong_shop_table'];
//
//$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_yikatong_shop'));
//$sk = 0;
//while($row = DB::fetch($query)) {
//	$oldshop_info = DB::fetch_first("SELECT * FROM ".DB::table($shop_table)." WHERE ".$yikatong_fields['shopid']."=".$row['oldshopid']);
//	$sk++;
//}
//dump($oldshop_info);
$myshoplist = array();
$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_brand_shop')." WHERE uid = ".$_G['uid']." order by shopid asc");
//$k = 0;
while($row = DB::fetch($query)) {
	$myshoplist[] = $row;
}
$myshop_num = count($myshoplist);
?>