<?php

/**
*	һ��ѧ��ƽ̨����
*	�ļ�����yikatong_base.php  ����ʱ�䣺2013-6-20 17:07  ����
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