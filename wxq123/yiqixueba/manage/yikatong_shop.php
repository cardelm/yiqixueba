<?php

/**
*	一起学吧平台程序
*	文件名：yikatong_shop.php  创建时间：2013-6-21 23:38  杨文
*
*/

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$this_page = 'plugin.php?id=yiqixueba:manage&man=yikatong&subman=shop';

$shopid = intval(getgpc('shopid'));
$shop_info = DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_yikatong_shop')." WHERE shopid=".$shopid);

//$businessid = DB::result_first("SELECT businessid FROM ".DB::table('yiqixueba_yikatong_business')." WHERE uid=".$uid);

if(!$shopid){
	$oldshoplist = array();
	$query = DB::query("SELECT * FROM ".DB::table($base_setting['yiqixueba_yikatong_shop_table'])." WHERE ".$shopfields['uid']."=".$uid);
	$k = 0;
	while($row = DB::fetch($query)) {
		$oldshoplist[$k]['shopname'] = $row[$shopfields['shopname']];
		$oldshoplist[$k]['shopurl'] = str_replace("{shopid}",$row[$shopfields['shopid']],$base_setting['yiqixueba_yikatong_shop_url']);
		if(DB::result_first("SELECT count(*) FROM ".DB::table('yiqixueba_yikatong_shop')." WHERE shopid=".$row[$shopfields['shopid']])==0){
			DB::insert('yiqixueba_yikatong_shop', array('shopid'=>$row[$shopfields['shopid']],'uid'=>$uid,'jointime'=>time()));
		}
		$k++;
	}
	$oldshop_num = count($oldshoplist);
	$shoplists = array();
	$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_yikatong_shop')." WHERE upshopid = 0 AND uid = ".$uid." order by shopid asc");
	$k = 0;
	while($row = DB::fetch($query)) {
		$shoplists[$k]['shopname'] = $oldshoplist[$k]['shopname'];
		$k++;
	}
	$shopnum = count($shoplists);
	//dump($oldshoplists);
}else{
	if(!submitcheck('shopsubmit')){
	}else{
		$data = array();
		$data = htmlspecialchars(trim(getgpc('')));
		if($shopid) {
			DB::update('yiqixueba_brand_shop',$data,array('shopid'=>$shopid));
		}else{
			DB::insert('yiqixueba_brand_shop',$data);
		}
		showmessage(lang('plugin/yiqixueba', 'shop_edit_succeed'), $this_page);
	}
}
