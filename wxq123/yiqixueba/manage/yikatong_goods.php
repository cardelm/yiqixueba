<?php

/**
*	一起学吧平台程序
*	文件名：yikatong_goods.php  创建时间：2013-6-21 23:38  杨文
*
*/

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$this_page = 'plugin.php?id=yiqixueba:manage&man=yikatong&subman=goods';

$goodsfields = dunserialize($base_setting['yiqixueba_yikatong_goodsfields']);

$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_yikatong_shop')." WHERE status = 0 order by shopid asc");
while($row = DB::fetch($query)) {
	$query1 = DB::query("SELECT * FROM ".DB::table($base_setting['yiqixueba_yikatong_goods_table'])." WHERE ".$goodsfields['shopid']."=".$row['shopid']);
	while($row1 = DB::fetch($query1)) {
		if(DB::result_first("SELECT count(*) FROM ".DB::table('yiqixueba_yikatong_goods')." WHERE shopid=".$row['shopid'])==0){
			$indata = array('shopid'=>$row['shopid'],'goodsid'=>$row1[$goodsfields['goodsid']],'uid'=>$uid,'businessid'=>$row['businessid'],'jointime'=>time());
			DB::insert('yiqixueba_yikatong_goods', $indata);
		}
	}
}

	$goodslists = array();
	$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_yikatong_goods')." order by goodsid asc");
	$k = 0;
	while($row = DB::fetch($query)) {
		$goodslists[$k]['goodsname'] = DB::result_first("SELECT ".$goodsfields['goodsname']." FROM ".DB::table($base_setting['yiqixueba_yikatong_goods_table'])." WHERE ".$goodsfields['goodsid']." = ".$row['goodsid']);
		$goodslists[$k]['goodspice'] = DB::result_first("SELECT ".$goodsfields['goodspice']." FROM ".DB::table($base_setting['yiqixueba_yikatong_goods_table'])." WHERE ".$goodsfields['goodsid']." = ".$row['goodsid']);
		$goodslists[$k]['goodsnum'] = intval($goodsfields['goodsnum'] ? DB::result_first("SELECT ".$goodsfields['goodsnum']." FROM ".DB::table($base_setting['yiqixueba_yikatong_goods_table'])." WHERE ".$goodsfields['goodsid']." = ".$row['goodsid']) : $rwo['goodsnum']);
		$goodslists[$k]['status'] = $row['status'];
		$k++;
	}
	$goodsnum = count($goodslists);
	//dump($base_setting);