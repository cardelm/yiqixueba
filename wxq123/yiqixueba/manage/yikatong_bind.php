<?php

/**
*	一起学吧平台程序
*	文件名：yikatong_bind.php  创建时间：2013-6-21 22:43  杨文
*
*/

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$this_page = 'plugin.php?id=yiqixueba:manage&man=yikatong&subman=bind';

$card_info = DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_yikatong_card')." WHERE uid=".$uid);
//dump($card_info);
if(submitcheck('cardsubmit')) {
	$cardno = trim(addslashes(getgpc('cardno')));
	$cardpass = trim(addslashes(getgpc('cardpass')));
	$cardinfo = DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_yikatong_card')." WHERE cardno='".$cardno."' AND cardpass = '".$cardpass."'");
	if($cardinfo){
		if($cardinfo['uid']){
			showmessage('您输入的卡号已经激活，请确认输入的卡号');
		}else{
			DB::update('yiqixueba_yikatong_card',array('uid'=>$_G['uid'],'bindtime'=>time()),array('cardno'=>$cardno));
			showmessage('会员卡绑定成功成功', $this_page, 'succeed');
		}
	}else{
		showmessage('请确认您输入的卡号和激活码');
	}
}