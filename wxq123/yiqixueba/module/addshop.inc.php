<?php

/**
*	һ��ѧ��ƽ̨����
*	�ļ�����addshop.inc.php  ����ʱ�䣺2013-6-16 17:20  ����
*
*/

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

//��Ҫ��¼
if(!$_G['uid']) {
	showmessage('login_before_enter_home', null, array(), array('showmsg' => true, 'login' => 1));
}

$shopnum = DB::result_first("SELECT count(*) FROM ".DB::table('yiqixueba_brand_shop')." WHERE uid=".$_G['uid']);
if($shopnum){
	showmessage('���Ѿ����̼���', 'plugin.php?id=yiqixueba:manage&man=brand&subman=shop');
}
$shopid = intval(getgpc('shopid'));
$shop_info = $shopid ? DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_brand_shop')." WHERE shopid=".$shopid) : array();

if(!submitcheck('submit')) {
	$sortupid_select = '<select name="shopsort"><option value="0">����</option>';
	$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_brand_shopsort')." order by concat(upids,'-',shopsortid) asc");
	while($row = DB::fetch($query)) {
		$sortupid_select .= '<option value="'.$row['shopsortid'].'" '.($shop_info['shopsort'] == $row['shopsortid'] ? ' selected' :'').'>'.str_repeat("--",$row['sortlevel']-1).$row['sorttitle'].'</option>';
	}
	$sortupid_select .= '</select>';
	$siat_option = '';
	$query = DB::query("SELECT * FROM ".DB::table('common_district')." WHERE upid = 73 order by displayorder asc");
	while($row = DB::fetch($query)) {
		$siat_option .= '<option value="'.$row['id'].'">'.$row['name'].'</option>';
	}
	$shoplocation = explode(',',$shop_info['shoplocation']);
}else{
	$shoplogo = addslashes(getgpc('shoplogo'));
	if($_FILES['shoplogo']) {
		$upload = new discuz_upload();
		if($upload->init($_FILES['shoplogo'], 'common') && $upload->save()) {
			$shoplogo = $upload->attach['attachment'];
		}
	}
	if(!$shoplogo){
		showmessage('���ϴ��̼�ͼƬ');
	}
	$data = array();
	$data['shopname'] = addslashes(trim(getgpc('shopname')));
	$data['shopsort'] = intval(getgpc('shopsort'));
	$data['shoplogo'] = $shoplogo;
	$data['shopintroduction'] = addslashes(trim(getgpc('shopintroduction')));
	$data['shoplocation'] = implode(",",array(trim(getgpc('baidu_x')),trim(getgpc('baidu_y'))));
	$data['shopinformation'] = addslashes(trim(getgpc('shopinformation')));
	$data['address'] = addslashes(trim(getgpc('address')));
	$data['phone'] = addslashes(trim(getgpc('phone')));
	$data['lianxiren'] = addslashes(trim(getgpc('lianxiren')));
	$data['qq'] = addslashes(trim(getgpc('qq')));
	$data['shopvideo'] = addslashes(trim(getgpc('shopvideo')));
	$data['uid'] = $_G['uid'];
	$data['createtime'] = time();
	$data['renlingtime'] = time();
	if(!$data['shopname']){
		showmessage('�̼ң����̣����Ʋ���Ϊ��');

	}elseif(DB::result_first("SELECT count(*) FROM ".DB::table('yiqixueba_brand_shop')." WHERE shopname='".$data['shopname']."'")){
		showmessage('�̼ң����̣������ظ�');
	}
	if(!$data['shopsort']){
		showmessage('��ѡ���̼ҷ���');
	}
	if(!$data['address']){
		showmessage('�̼ҵĵ�ַ����Ϊ��');
	}
	if(!$data['phone']){
		showmessage('��ѡ���̼ҷ���');
	}
	if(!$data['lianxiren']){
		showmessage('����д��ϵ��');
	}
	if($shopid){
		DB::update('yiqixueba_brand_shop', $data,array('shopid'=>$shopid));
	}else{
		DB::insert('yiqixueba_brand_shop', $data);
	}
	dsetcookie('yiqixueba_login','yes',900);
	showmessage('������ӳɹ�����ȴ����', 'plugin.php?id=yiqixueba:manage&man=brand&subman=shop');

}

include template('yiqixueba:'.$template_file);
?>