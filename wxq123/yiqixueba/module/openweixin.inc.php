<?php

/**
*	һ��ѧ��ƽ̨����
*	�ļ�����openweixin.inc.php  ����ʱ�䣺2013-6-30 04:22  ����
*
*/

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
//��Ҫ��¼
if(!$_G['uid']) {
	showmessage('login_before_enter_home', null, array(), array('showmsg' => true, 'login' => 1));
}

if(DB::result_first("SELECT count(*) FROM ".DB::table('yiqixueba_mokuai')." WHERE mokuainame='wxq123'")==0){
	//showmessage('΢�����ò�����������ϵվ��');
}
$indata = array();
$wxq123_setting = api_indata('getweixinsetting',$indata);

$type= trim(getgpc('type'));
$shibiema_info = DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_wxq123_member')." WHERE uid=".$_G['uid']);
if($shibiema_info){
	showmessage('���Ѿ���ͨ��΢��', 'plugin.php?id=yiqixueba:manage&man=wxq123&subman=member');
}else{
	if($type=='bendi'){
		$openweixin_text = '��ͨ������ҵ΢��';
		$shibiema = random(5,1);
		while(DB::result_first("SELECT count(*) FROM ".DB::table('yiqixueba_wxq123_member')." WHERE shibiema='".$shibiema."' AND membertype='bendi'")){
			$shibiema = random(5,1);
		}
		$token = random(6);
	}elseif($type=='lianmeng'){
		$openweixin_text = '��ͨ������ҵ΢��';
		$shibiema = random(6,1);
		while(DB::result_first("SELECT count(*) FROM ".DB::table('yiqixueba_wxq123_member')." WHERE shibiema='".$shibiema."' AND membertype='lianmeng'")){
			$shibiema = random(6,1);
		}
		$token = random(6);
	}elseif($type=='geren'){
		$openweixin_text = '��ͨ����΢��';
		$shibiema = random(7,1);
		while(DB::result_first("SELECT count(*) FROM ".DB::table('yiqixueba_wxq123_member')." WHERE shibiema='".$shibiema."' AND membertype='geren'")){
			$shibiema = random(7,1);
		}
		$token = random(6);
	}
}
if(!submitcheck('weixinsubmit')) {
}else{
	$insertdata['shibiema'] = trim(getgpc('shibiema'));
	$insertdata['token'] = trim(getgpc('token'));
	$insertdata['membertype'] = $type;
	$insertdata['uid'] = $_G['uid'];
	if(DB::result_first("SELECT count(*) FROM ".DB::table('yiqixueba_wxq123_member')." WHERE uid=".$_G['uid'])==0){
		DB::insert('yiqixueba_wxq123_member', $insertdata);
	}else{
		DB::update('yiqixueba_wxq123_member', $insertdata,array('uid'=>$_G['uid']));
	}
	showmessage('���Ѿ���ͨ��΢��', 'plugin.php?id=yiqixueba:manage&man=wxq123&subman=member');
}
include template('yiqixueba:'.$template_file);
?>