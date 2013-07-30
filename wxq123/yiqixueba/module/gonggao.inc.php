<?php

/**
*	一起学吧平台程序
*	文件名：gonggao.inc.php  创建时间：2013-6-23 23:02  杨文
*
*/

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
$ggid = intval(getgpc('ggid'));
$gonggaoinfo = DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_brand_gonggao')." WHERE gonggaoid=".$ggid);
include template('yiqixueba:'.$template_file);
?>