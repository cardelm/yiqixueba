<?php

/**
*	一起学吧平台程序
*	文件名：tuangou_setting.inc.php  创建时间：2013-6-9 16:25  杨文
*
*/

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

if(!submitcheck('submit')) {
	showtips(lang('plugin/yiqixueba','yikatong_'.$mokuai_info['mokuainame'].'_setting_tips'));
	showformheader($this_page.'&subac=mokuaisetting&mokuaiid='.$mokuaiid);
	showtableheader(lang('plugin/yiqixueba','yikatong_setting'));
	showhiddenfields(array('mokuaiid'=>$mokuaiid));
	showsetting(lang('plugin/yiqixueba','nav_menu'),'setting[yiqixueba_'.$mokuai_info['mokuainame'].'_nav_menu]',$mokuai_setting['yiqixueba_'.$mokuai_info['mokuainame'].'_nav_menu'],'radio','','',lang('plugin/yiqixueba','nav_menu_comment'),'','',true);
	showsetting(lang('plugin/yiqixueba','top_menu'),'setting[yiqixueba_'.$mokuai_info['mokuainame'].'_top_menu]',$mokuai_setting['yiqixueba_'.$mokuai_info['mokuainame'].'_top_menu'],'radio','','',lang('plugin/yiqixueba','top_menu_comment'),'','',true);
	showsubmit('submit');
	showtablefooter();
	showformfooter();
}else{
	$setting = getgpc('setting');
	if (is_array($setting)){
		foreach ($setting as $key => $value){
			if (DB::result_first("SELECT count(*) FROM ".DB::table('yiqixueba_setting')." WHERE skey='".$key."'") == 0){
				DB::insert('yiqixueba_setting',array('skey'=>$key,'svalue'=>$value));
			}else{
				DB::update('yiqixueba_setting',array('svalue'=>$value),array('skey'=>$key));
			}
		}
	}
	cpmsg(lang('plugin/yiqixueba', 'mokuai_setting_succeed'), 'action='.$this_page.'&subac=mokuailist', 'succeed');
}

?>