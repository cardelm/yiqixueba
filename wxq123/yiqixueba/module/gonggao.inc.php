<?php

/**
*	һ��ѧ��ƽ̨����
*	�ļ�����gonggao.inc.php  ����ʱ�䣺2013-6-23 23:02  ����
*
*/

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
$ggid = intval(getgpc('ggid'));
$gonggaoinfo = DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_brand_gonggao')." WHERE gonggaoid=".$ggid);
include template('yiqixueba:'.$template_file);
?>