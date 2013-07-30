<?php
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit();
}

if(!submitcheck('submit')) {
	showtips($mokuailang['mokuai_setting_tips']);
	showformheader($basepage);
	showtableheader($mokuailang['mokuai_setting']);
	showsetting(lang('plugin/wxq123','type'),'filetype','','text');
	showsetting(lang('plugin/wxq123','conment'),'fileconment','','textarea');
	showsubmit('submit');
	showformfooter();
}else{
}
?>