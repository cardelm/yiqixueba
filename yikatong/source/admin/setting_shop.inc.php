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
	$shop_config = array();
	$query = DB::query("SELECT * FROM ".DB::table('brand_settings'));
	while($row = DB::fetch($query)) {
		//if(substr($row['variable'],0,5) == 'shop_'){
			$shop_config[$row['variable']] = $row['value'];
		//}
	}

	$threadtypeselect = '<select name="shop_zidingyi">';
	$query = DB::query("SELECT * FROM ".DB::table('forum_threadtype'));
	while($row = DB::fetch($query)) {
		$threadtypeselect .= '<option value="'.$row['typeid'].'" '.($shop_config['shop_zidingyi'] == $row['typeid']? ' selected' : '').'>'.$row['name'].'</option>';
	}
	$threadtypeselect .= '</select>';
	showtips('<li>�̼�����</li>');
	showformheader('plugins&identifier=yikatong&pmod=admin&bmenu=setting&baction=setting_shop');
	showtableheader('�̼�����');
	showsetting('�̼Ҷ�Ӧ��̳���','','',forumselect('shop'),'','','��ѡ���̼Ҷ�Ӧ��̳���');
	showsetting('�̼��Զ�����Ϣ��Ӧ������Ϣ','','',threadtypeselect('shop'),'','','��ѡ���̼��Զ�����Ϣ��Ӧ������Ϣ');
	showtablefooter();
	showtableheader('��Ʒ����');
	showsetting('��Ʒ��Ӧ��̳���','','',forumselect('goods'),'','','��ѡ����Ʒ��Ӧ��̳���');
	showsetting('��Ʒ�Զ�����Ϣ��Ӧ������Ϣ','','',threadtypeselect('goods'),'','','��ѡ����Ʒ�Զ�����Ϣ��Ӧ������Ϣ');
	showtablefooter();
	showtableheader('�Ź�����');
	showsetting('�Ź���Ӧ��̳���','','',forumselect('groupbuy'),'','','��ѡ���Ź���Ӧ��̳���');
	showsetting('�Ź��Զ�����Ϣ��Ӧ������Ϣ','','',threadtypeselect('groupbuy'),'','','��ѡ���Ź��Զ�����Ϣ��Ӧ������Ϣ');
	showtablefooter();
	showtableheader('�Żݾ�����');
	showsetting('�Żݾ��Ӧ��̳���','','',forumselect('consume'),'','','��ѡ���Żݾ��Ӧ��̳���');
	showsetting('�Żݾ��Զ�����Ϣ��Ӧ������Ϣ','','',threadtypeselect('consume'),'','','��ѡ���Żݾ��Զ�����Ϣ��Ӧ������Ϣ');
	showtablefooter();
	showtableheader('ģ������');
	showsetting('��Ӧ��ʾģ��','','',templateselect('ykt_template'),'','','��ѡ��ҳ��ʾģ��');
	showsubmit('submit');
	showtablefooter();
	showformfooter();
}else{
	$post_array = array('shop_forum','shop_zidingyi','goods_forum','goods_zidingyi','groupbuy_forum','groupbuy_zidingyi','consume_forum','ykt_template','consume_zidingyi');
	foreach ( $post_array as $value){
		$data[$value] = $_POST[$value];
		if(DB::result_first("SELECT count(*) FROM ".DB::table('brand_settings')." WHERE variable='".$value."'")==1){
			DB::update('brand_settings', array('value'=>$data[$value]),array('variable'=>$value));
		}else{
			DB::insert('brand_settings', array('value'=>$data[$value],'variable'=>$value));
		}
		DB::update('forum_threadtype', array('fid'=>$data['shop_forum']),array('typeid'=>$data['shop_zidingyi']));
	}
	cpmsg('�̼����óɹ���','action=plugins&identifier=yikatong&pmod=admin&bmenu=setting&baction=setting_shop','succeed');

}


//
function forumselect($type) {
	global $shop_config;
	$forumselect = '<select name="'.$type.'_forum">';
	$query = DB::query("SELECT * FROM ".DB::table('forum_forum')." WHERE type <> 'group' and status = 1");
	while($row = DB::fetch($query)) {
		$forumselect .= '<option value="'.$row['fid'].'" '.($shop_config[$type.'_forum'] == $row['fid']? ' selected' : '').'>'.$row['name'].'</option>';
	}
	$forumselect .= '</select>';
	return $forumselect;
}//end func

//
function threadtypeselect($type) {
	global $shop_config;
	$threadtypeselect = '<select name="'.$type.'_zidingyi">';
	$query = DB::query("SELECT * FROM ".DB::table('forum_threadtype'));
	while($row = DB::fetch($query)) {
		$threadtypeselect .= '<option value="'.$row['typeid'].'" '.($shop_config[$type.'_zidingyi'] == $row['typeid']? ' selected' : '').'>'.$row['name'].'</option>';
	}
	$threadtypeselect .= '</select>';
	return $threadtypeselect;
}//end func

//
function templateselect($type) {
	global $shop_config;
	$templateselect = '<select name="'.$type.'">';
	$query = DB::query("SELECT * FROM ".DB::table('common_template'));
	while($row = DB::fetch($query)) {
		$templateselect .= '<option value="'.$row['templateid'].'" '.($shop_config[$type] == $row['templateid']? ' selected' : '').'>'.$row['name'].'</option>';
	}
	$templateselect .= '</select>';
	return $templateselect;
}//end func


?>