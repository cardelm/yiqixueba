<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
$shopid = $_GET['shopid'];
if($_POST['submit']){
	$data['sjwb'] = random(6);
	$data['mima'] = md5(md5($_POST['mima']).$data['sjwb']);
	$data['name'] = $_POST['name'];
	$data['zhanghao'] = $_POST['zhanghao'];
	$data['dhhm'] = $_POST['dhhm'];
	$data['mendian'] = $_POST['mendian'];
	$data['mddz'] = $_POST['mddz'];
	$data['sjuid'] = $_G['uid'];
	if($_POST['dyid']){
		DB::update('brand_dianyuan',$data,array('ID'=>$_POST['dyid']));
	}else{
		DB::insert('brand_dianyuan',$data);
	}
	showmessage('µêÔ±±à¼­³É¹¦','plugin.php?id=yikatong:yktmanage&mod=goods&shopid='.$shopid,'success');
}else{
	if($_GET['dyid']){
		$dianyuan_info = DB::fetch_first("SELECT * FROM ".DB::table('brand_dianyuan')." WHERE ID=".$_GET['dyid']);
	}
}
if($_GET['delid']){
	DB::delete('brand_dianyuan',$data,array('ID'=>$_POST['delid']));
}
include_once template('yktmanage_'.$mod ,0,$template.'/plugin');

?>