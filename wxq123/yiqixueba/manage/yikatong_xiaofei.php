<?php

/**
*	һ��ѧ��ƽ̨����
*	�ļ�����yikatong_xiaofei.php  ����ʱ�䣺2013-6-21 01:03  ����
*
*/

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}


$cardno = getgpc('cardno');
$xiaofei_info = $cardno ? DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_yikatong_card')." WHERE cardno = '".$cardno."'"):array();
$goodsid = getgpc('goodsid');
//$goods_info = $goodsid ? DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_yikatong_goods')." WHERE goodsid = '".$goodsid."'"):array();

if(!submitcheck('xiaofeisubmit')) {

}else{
	$data = array();
	$data['cardno'] = trim(addslashes(getgpc('cardno')));
	//dump($data['cardno']);
	if($cardid) {
		//DB::update('yiqixueba_yikatong_card',$data,array('cardid'=>$cardid));
	}else{
		//DB::insert('yiqixueba_yikatong_card',$data);
	}
	//showmessage('��Ա���ѱ༭�ɹ�', $this_page, 'succeed');
}

?>
