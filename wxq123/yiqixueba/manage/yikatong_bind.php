<?php

/**
*	һ��ѧ��ƽ̨����
*	�ļ�����yikatong_bind.php  ����ʱ�䣺2013-6-21 22:43  ����
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
			showmessage('������Ŀ����Ѿ������ȷ������Ŀ���');
		}else{
			DB::update('yiqixueba_yikatong_card',array('uid'=>$_G['uid'],'bindtime'=>time()),array('cardno'=>$cardno));
			showmessage('��Ա���󶨳ɹ��ɹ�', $this_page, 'succeed');
		}
	}else{
		showmessage('��ȷ��������Ŀ��źͼ�����');
	}
}