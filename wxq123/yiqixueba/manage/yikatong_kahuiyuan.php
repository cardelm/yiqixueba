<?php

/**
*	һ��ѧ��ƽ̨����
*	�ļ�����yikatong_kahuiyuan.php  ����ʱ�䣺2013-6-17 10:03  ����
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
