<?php

/**
*	一起学吧平台程序
*	文件名：yikatong_xiaofei.php  创建时间：2013-6-21 01:03  杨文
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
	//showmessage('会员消费编辑成功', $this_page, 'succeed');
}

?>
