<?php

/**
*	һ��ѧ��ƽ̨����
*	ǰ̨����
*	�ļ�����manage.inc.php  ����ʱ�䣺2013-6-1 15:17  ����
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