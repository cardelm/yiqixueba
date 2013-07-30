<?php

/**
*	一起学吧平台程序
*	文件名：yikatong_kahuiyuan.php  创建时间：2013-6-17 10:03  杨文
*
*/

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
$card_member_list = array();
//$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_yikatong_card')." WHERE fafanguid = ".$id." order by displayorder asc");
//while($row = DB::fetch($query)) {
//}


$multi = '';
if($count) {
	$multi = multi($count, $perpage, $page, $theurl);
}
