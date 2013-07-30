<?php

/**
*	一起学吧平台程序
*	前台管理
*	文件名：manage.inc.php  创建时间：2013-6-1 15:17  杨文
*
*/

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
$submod = getgpc('submod');
if($submod == 'baidumap') {
	include template('yiqixueba:yiqixueba/default/baidumap');
	exit();
}
$base_setting = array();
$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_setting'));
while($row = DB::fetch($query)) {
	$base_setting[$row['skey']] = $row['svalue'];
}

$thistemplate = $base_setting['thistemplate'];
include template('yiqixueba:yiqixueba/'.$thistemplate.'/main');

?>