<?php

/**
*	一起学吧平台程序
*	平台程序
*	文件名：mainpro.php  创建时间：2013-5-30 23:35  杨文
*
*/

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
$this_page = 'plugins&identifier=yiqixueba_server&pmod=admincp&submod=mainpro';

$subop = getgpc('subop');
$subops = array('base');
$subop = in_array($subop,$subops) ? $subop : $subops[0];

if($subop == 'base') {
	if(!submitcheck('submit')) {
		showformheader($this_page.'&subop=base');
		showtableheader(lang('plugin/yiqixueba_server','mainpro_base'));
		showsetting(lang('plugin/yiqixueba_server','current_status'),'mokuainame',$group_info['mokuainame'],'text','',0,lang('plugin/yiqixueba_server','current_status_comment'),'','',true);
		showsubmit('submit');
		showtablefooter();
		showformfooter();
	}else{
		cpmsg(lang('plugin/yiqixueba_server', 'mokuai_edit_succeed'), 'action='.$this_page.'&subop=list', 'succeed');
	}
}
?>