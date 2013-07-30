<?php

/**
*	一起学吧平台程序
*	文件名：openweixin.inc.php  创建时间：2013-6-30 04:22  杨文
*
*/

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
//需要登录
if(!$_G['uid']) {
	showmessage('login_before_enter_home', null, array(), array('showmsg' => true, 'login' => 1));
}

if(DB::result_first("SELECT count(*) FROM ".DB::table('yiqixueba_mokuai')." WHERE mokuainame='wxq123'")==0){
	//showmessage('微信设置不正常，请联系站长');
}
$indata = array();
$wxq123_setting = api_indata('getweixinsetting',$indata);

$type= trim(getgpc('type'));
$shibiema_info = DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_wxq123_member')." WHERE uid=".$_G['uid']);
if($shibiema_info){
	showmessage('您已经开通了微信', 'plugin.php?id=yiqixueba:manage&man=wxq123&subman=member');
}else{
	if($type=='bendi'){
		$openweixin_text = '开通本地企业微信';
		$shibiema = random(5,1);
		while(DB::result_first("SELECT count(*) FROM ".DB::table('yiqixueba_wxq123_member')." WHERE shibiema='".$shibiema."' AND membertype='bendi'")){
			$shibiema = random(5,1);
		}
		$token = random(6);
	}elseif($type=='lianmeng'){
		$openweixin_text = '开通联盟企业微信';
		$shibiema = random(6,1);
		while(DB::result_first("SELECT count(*) FROM ".DB::table('yiqixueba_wxq123_member')." WHERE shibiema='".$shibiema."' AND membertype='lianmeng'")){
			$shibiema = random(6,1);
		}
		$token = random(6);
	}elseif($type=='geren'){
		$openweixin_text = '开通个人微信';
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
	showmessage('您已经开通了微信', 'plugin.php?id=yiqixueba:manage&man=wxq123&subman=member');
}
include template('yiqixueba:'.$template_file);
?>