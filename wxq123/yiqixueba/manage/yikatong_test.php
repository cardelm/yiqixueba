<?php

/**
*	һ��ѧ��ƽ̨����
*	�ļ�����yikatong_xiaofei.php  ����ʱ�䣺2013-6-21 00:52  ����
*
*/

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$this_page = 'plugin.php?id=yiqixueba:manage&man=yikatong&subman=xiaofei';

$cardid = getgpc('cardid');
$xiaofei_info = $cardid ? DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_yikatong_card')." WHERE cardid = ".$cardid):array();

if(!submitcheck('xiaofeisubmit')) {

}else{
	$data = array();
	$data['cardno'] = trim(addslashes(getgpc('cardno')));
	$data['cardpass'] = trim(addslashes(getgpc('cardpass')));
	if($cardid) {
		//DB::update('yiqixueba_yikatong_card',$data,array('cardid'=>$cardid));
	}else{
		//DB::insert('yiqixueba_yikatong_card',$data);
	}
	showmessage('��Ա���ѱ༭�ɹ�', $this_page, 'succeed');
}
?>
