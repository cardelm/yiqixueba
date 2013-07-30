<?php

/**
*	一起学吧平台程序
*	文件名：base.inc.php  创建时间：2013-5-31 17:49  杨文
*
*/

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
$this_page = 'plugins&identifier=yiqixueba_yikatong&pmod=admin&submod=base';

$shop_setting = array();
$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_yikatong_setting'));
while($row = DB::fetch($query)) {
	$shop_setting[$row['skey']] = $row['svalue'];
}

if(!submitcheck('submit')) {
	showtips(lang('plugin/yiqixueba_yikatong','yikatong_setting_tips'));
	showformheader($this_page.'&subac=base','enctype');
	showtableheader(lang('plugin/yiqixueba_yikatong','yikatong_setting'));
	showsetting(lang('plugin/yiqixueba_yikatong','jiaoyijifen'),'yikatong_setting[jiaoyijifen]',$yikatong_setting['jiaoyijifen'],'select','','',lang('plugin/yiqixueba_yikatong','jiaoyijifen_comment'),'','',true);
	showsetting(lang('plugin/yiqixueba_yikatong','zengsongjifen'),'yikatong_setting[zengsongjifen]',$yikatong_setting['zengsongjifen'],'select','','',lang('plugin/yiqixueba_yikatong','zengsongjifen_comment'),'','',true);
	echo '<script src="static/js/calendar.js" type="text/javascript"></script>';	showsetting(lang('plugin/yiqixueba_yikatong','jifenyouxiaoqi'),'yikatong_setting[jifenyouxiaoqi]',$yikatong_setting['jifenyouxiaoqi'],'calendar','','',lang('plugin/yiqixueba_yikatong','jifenyouxiaoqi_comment'),'','',true);
	showsubmit('submit');
	showtablefooter();
	showformfooter();
}else{
	$data = getgpc('yikatong_setting');
	foreach ($data as $k=>$v){
		if (DB::result_first("SELECT count(*) FROM ".DB::table('yiqixueba_yikatong_setting')." WHERE skey='".$k."'")==0){
			DB::insert('yiqixueba_client_setting',array('skey'=>$k,'svalue'=>$v));
		}else{
			DB::update('yiqixueba_client_setting',array('svalue'=>$v),array('skey'=>$k));
		}
	}
	cpmsg(lang('plugin/yiqixueba_shop', 'mokuai_edit_succeed'), 'action='.$this_page, 'succeed');
}
?>