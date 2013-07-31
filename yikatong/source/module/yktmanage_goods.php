<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
$navtitle = '商品管理';
$shopid = $_GET['shopid'];
$shop_name = DB::result_first("SELECT subject FROM ".DB::table('forum_thread')." WHERE tid=".$shopid);
$shop_sortid = DB::result_first("SELECT value FROM ".DB::table('brand_settings')." WHERE variable='shop_zidingyi'");
$goods_sortid = DB::result_first("SELECT value FROM ".DB::table('brand_settings')." WHERE variable='goods_zidingyi'");
$shop_fid = DB::result_first("SELECT value FROM ".DB::table('brand_settings')." WHERE variable='shop_forum'");
$goods_fid = DB::result_first("SELECT value FROM ".DB::table('brand_settings')." WHERE variable='goods_forum'");

$sortid = $shop_fid;
$sortoption_array = array('ykt_logo','ykt_dpdh','ykt_dizhi','ykt_UID','ykt_shuomin','ykt_shopid','ykt_sptp');
foreach ($sortoption_array as $sokey=>$sovalue){
	$sort_dis[$sovalue] = DB::result_first("SELECT optionid FROM ".DB::table('forum_typeoption')." WHERE identifier='".$sovalue."'");
}

$query = DB::query("SELECT * FROM ".DB::table('forum_typeoptionvar')." WHERE optionid =".$sort_dis['ykt_shopid']." and value='".$shopid."'");
while($row = DB::fetch($query)) {
	$query1 = DB::query("SELECT optionid,value FROM ".DB::table('forum_typeoptionvar')." WHERE tid =".$row['tid']);
	while($row1 = DB::fetch($query1)) {
		$sortvalue[$row['tid']][$row1['optionid']] = $row1['value'];
	}
	$sortvalue[$row['tid']]['subject'] = DB::result_first("SELECT subject FROM ".DB::table('forum_thread')." WHERE tid=".$row['tid']);
	$sortvalue[$row['tid']]['fid'] = DB::result_first("SELECT fid FROM ".DB::table('forum_thread')." WHERE tid=".$row['tid']);
	$sortvalue[$row['tid']]['pid'] = DB::result_first("SELECT pid FROM ".DB::table('forum_post')." WHERE tid=".$row['tid']." and first=1");
	$sortvalue[$row['tid']]['xfjl_num'] = DB::result_first("SELECT count(*) FROM ".DB::table('brand_xfjl')." WHERE sptid =".$row['tid']);
	$sortvalue[$row['tid']]['tid'] = $row['tid'];
}
$shop_num = count($sortvalue);


//$query = DB::query("SELECT * FROM ".DB::table('brand_dianyuan')." WHERE sjuid =".$_G['uid'] );
$query = DB::query("SELECT * FROM ".DB::table('brand_dianyuan') );
while($row = DB::fetch($query)) {
	$dianyuan[] = $row;
}
include_once template('yktmanage_'.$mod ,0,$template.'/plugin');

?>