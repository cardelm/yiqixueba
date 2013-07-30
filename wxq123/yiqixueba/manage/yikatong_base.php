<?php

/**
*	一起学吧平台程序
*	文件名：yikatong_base.php  创建时间：2013-6-20 17:07  杨文
*
*/

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
//$usergroup

$edit = trim(getgpc('edit'));
$edit_stauts = in_array($edit,$groups);
$dq_edit = lang('plugin/yiqixueba','g_'.$edit);

?>