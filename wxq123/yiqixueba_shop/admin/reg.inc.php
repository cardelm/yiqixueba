<?php
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
$this_page = 'plugins&identifier=yiqixueba_shop&pmod=admin&submod=basesetting';

$shop_setting = array();
$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_client_setting')." where skey LIKE 'mokuai_shop_%'");
while($row = DB::fetch($query)) {
	$shop_setting[$row['skey']] = $row['svalue'];
}

if(!submitcheck('submit')) {
	showtips(lang('plugin/yiqixueba_shop','shop_reg_tips'));
	showformheader($this_page.'&subop=groupedit','enctype');
	showtableheader(lang('plugin/yiqixueba_shop','shop_reg'));
	showsetting(lang('plugin/yiqixueba_shop','shopfenlei'),'shop_setting[mokuai_shop_shopfenlei]',$shop_setting['mokuai_shop_shopfenlei'],'textarea','',0,lang('plugin/yiqixueba_shop','shopfenlei_comment'),'','',true);
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
	cpmsg(lang('plugin/yiqixueba_shop', 'mokuai_edit_succeed'), 'action='.$this_page, 'succeed');
}




?>