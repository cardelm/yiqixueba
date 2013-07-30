<?php

/**
*	一起学吧平台程序
*	文件名：tuisong.inc.php  创建时间：2013-6-27 19:21  杨文
*
*/

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

if($_G['adminid']!=1){
	showmessage('你没有权限操作！');
}
$shopid = intval(getgpc('shopid'));
$oldshopid = intval(getgpc('oldshopid'));
$tuisongweizhi = $_POST['tuisongweizhi'];
$addnew = $_POST['addnew'];

$referer = trim(getgpc('referer'));
$tuisong = dunserialize($base_setting['index_tuisong']);
$tuisong = $tuisong ? $tuisong : array();

if(submitcheck('submit')) {
	
	foreach( $tuisongweizhi as $k => $v ){
		if($addnew[$k] == $v){
			if(!in_array($shopid,$tuisong[$v])){
				$tuisong[$v][] = $shopid;
			}
			
		}else{
			$newtuisong = array();
			if(is_array($tuisong[$v])){
				foreach($tuisong[$v] as $kk=>$vv ){
					$newtuisong[$v][] = $vv == $oldshopid && $oldshopid ? $oldshopid : $vv;
				}
				$tuisong[$v] = $newtuisong[$v] ;
			}
		}
	}
	
	if(DB::result_first("SELECT count(*) FROM ".DB::table('yiqixueba_setting')." WHERE skey='index_tuisong'")==0){
		DB::insert('yiqixueba_setting', array('skey'=>'index_tuisong','svalue'=>serialize($tuisong)));
	}else{
		DB::update('yiqixueba_setting', array('svalue'=>serialize($tuisong)),array('skey'=>'index_tuisong'));
	}
}

//showmessage(lang('plugin/yiqixueba','joinbusiness_exists'), 'plugin.php?id=yiqixueba:manage&man=brand&subman=business', array(), array('header' => true));
//dheader($referer);
dheader('Location:'.$referer);
?>