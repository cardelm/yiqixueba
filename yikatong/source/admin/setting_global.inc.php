<?php
/**
 *      [yikatong!] (C)2012-2099 YiQiXueBa.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: setting_reg.inc.php 24411 2012-09-17 05:09:03Z yangwen $
 */
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

if(!submitcheck('submit')) {
	$ykt_config = array();
	$query = DB::query("SELECT * FROM ".DB::table('brand_settings'));
	while($row = DB::fetch($query)) {
			$ykt_config[$row['variable']] = $row['value'];
	}
	$ykt_config['magicqixian'] = $ykt_config['magicqixian'] ? $ykt_config['magicqixian'] : 7;
	showtips('<li>一卡通的基础设置</li>');
	showformheader('plugins&identifier=yikatong&pmod=admin&bmenu=setting&baction=setting_global');
	showtableheader('基础设置');
	showsetting('一卡通会员对应用户组','','',groupselect(),'','','当一卡通会员绑定之后，对应的用户组');
	showsetting('一卡通积分赠送类型','','',jifenselect('zengsong'),'','','请选择一卡通积分赠送类型');
	showsetting('一卡通货币类型','','',jifenselect('jiaoyi'),'','','请选择一卡通货币类型');
	showsetting('自荐卡道具的有效期','magicqixian',$ykt_config['magicqixian'],'text','','','设置自荐卡道具的置顶有效期，单位：天；默认为7天。');
	showsubmit('submit');
	showtablefooter();
	showformfooter();
}else{
	$post_array = array('yikatong_group','yikatong_zengsongjifen','yikatong_jiaoyijifen');
	foreach ( $post_array as $value){
		$data[$value] = $_POST[$value];
		if(DB::result_first("SELECT count(*) FROM ".DB::table('brand_settings')." WHERE variable='".$value."'")==1){
			DB::update('brand_settings', array('value'=>$data[$value]),array('variable'=>$value));
		}else{
			DB::insert('brand_settings', array('value'=>$data[$value],'variable'=>$value));
		}
		DB::update('forum_threadtype', array('fid'=>$data['shop_forum']),array('typeid'=>$data['shop_zidingyi']));
	}
	cpmsg('一卡通基础设置成功！','action=plugins&identifier=yikatong&pmod=admin&bmenu=setting&baction=setting_global','succeed');

}
//
function groupselect() {
	global $ykt_config;
	$groupselect = '<select name="yikatong_group">';
	$query = DB::query("SELECT * FROM ".DB::table('common_usergroup')." WHERE type = 'special'");
	while($row = DB::fetch($query)) {
		$groupselect .= '<option value="'.$row['groupid'].'" '.($ykt_config['yikatong_group'] == $row['groupid']? ' selected' : '').'>'.$row['grouptitle'].'</option>';
	}
	$groupselect .= '</select>';
	return $groupselect;
}//end func

//
function jifenselect($type) {
	global $ykt_config;
	$setting = C::t('common_setting')->fetch_all(null);
	$setting['extcredits'] = dunserialize($setting['extcredits']);
	$zsjifenselect = '<select name="yikatong_'.$type.'jifen">';
	foreach ( $setting['extcredits'] as $key=>$value){
		if($value['available']==1){
			$zsjifenselect .= '<option value="'.$key.'" '.($ykt_config['yikatong_'.$type.'jifen'] == $key? ' selected' : '').'>'.$value['title'].'</option>';
		}
	}
	$threadtypeselect .= '</select>';
	return $zsjifenselect;
}//end func


?>