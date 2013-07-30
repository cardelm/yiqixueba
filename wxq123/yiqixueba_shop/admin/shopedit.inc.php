<?php

/**
*	一起学吧平台程序
*	文件名：shopedit.inc.php  创建时间：2013-6-1 01:57  杨文
*
*/

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
$this_page = 'plugins&identifier=yiqixueba_shop&pmod=admin&submod=shopedit';

if(!submitcheck('submit')) {
	showtips(lang('plugin/yiqixueba_shop','shop_edit_tips'));
	showformheader($this_page.'&subac=shopedit','enctype');
	showtableheader(lang('plugin/yiqixueba_shop','shop_edit'));
	$shopid ? showhiddenfields($hiddenfields = array('shopid'=>$shopid)) : '';
	showsetting(lang('plugin/yiqixueba_shop','shopico'),'shopico',$shop_info['shopico'],'filetext','','',lang('plugin/yiqixueba_shop','shopico_comment').$shopicohtml,'','',true);
	showsetting(lang('plugin/yiqixueba_shop','shopname'),'shop_info[shopname]',$shop_info['shopname'],'text','',0,lang('plugin/yiqixueba_shop','shopname_comment'),'','',true);
	showsetting(lang('plugin/yiqixueba_shop','shopdescription'),'shop_info[shopdescription]',$shop_info['shopdescription'],'textarea','',0,lang('plugin/yiqixueba_shop','shopdescription_comment'),'','',true);
	showsetting(lang('plugin/yiqixueba_shop','cardtype'),'','',$cardtype_select,'',0,lang('plugin/yiqixueba_shop','cardtype_comment'),'','',true);
	showsetting(lang('plugin/yiqixueba_shop','cardpice'),'shop_info[cardpice]',$shop_info['cardpice'],'text','',0,lang('plugin/yiqixueba_shop','cardpice_comment'),'','',true);
	showsetting(lang('plugin/yiqixueba_shop','status'),'shop_info[status]',$shop_info['status'],'radio','',0,lang('plugin/yiqixueba_shop','status_comment'),'','',true);
	showsubmit('submit');
	showtablefooter();
	showformfooter();
}else{
}
?>