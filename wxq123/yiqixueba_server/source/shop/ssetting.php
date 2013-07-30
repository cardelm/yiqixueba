<?php

/**
*	一起学吧平台程序
*	商家设置
*	文件名：ssetting.php  创建时间：2013-5-31 11:14  杨文
*
*/

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
$this_page = 'plugins&identifier=yiqixueba_server&pmod=admincp&submod=ssetting';

$shop_setting = array();
$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_client_setting')." where skey LIKE 'mokuai_shop_%'");
while($row = DB::fetch($query)) {
	$shop_setting[$row['skey']] = $row['svalue'];
}

if(!submitcheck('submit')) {
	showtips(lang('plugin/yiqixueba_server','shop_setting_tips'));
	showformheader($this_page.'&subop=groupedit','enctype');
	showtableheader(lang('plugin/yiqixueba_server','shop_setting'));
	showsetting(lang('plugin/yiqixueba_server','shopfenlei'),'shop_setting[mokuai_shop_shopfenlei]',$shop_setting['mokuai_shop_shopfenlei'],'textarea','',0,lang('plugin/yiqixueba_server','shopfenlei_comment'),'','',true);
	showsubmit('submit');
	showtablefooter();
	showformfooter();
}else{
	$data = getgpc('shop_setting');
	foreach ($data as $k=>$v){
		if (DB::result_first("SELECT count(*) FROM ".DB::table('yiqixueba_client_setting')." WHERE skey='".$k."'")==0){
			DB::insert('yiqixueba_client_setting',array('skey'=>$k,'svalue'=>$v));
		}else{
			DB::update('yiqixueba_client_setting',array('svalue'=>$v),array('skey'=>$k));
		}
	}
	cpmsg(lang('plugin/yiqixueba_server', 'mokuai_edit_succeed'), 'action='.$this_page, 'succeed');
}

?>