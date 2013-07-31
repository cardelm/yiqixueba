<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$shop_sortid = DB::result_first("SELECT value FROM ".DB::table('brand_settings')." WHERE variable='shop_zidingyi'");
$goods_sortid = DB::result_first("SELECT value FROM ".DB::table('brand_settings')." WHERE variable='goods_zidingyi'");
$groupbuy_sortid = DB::result_first("SELECT value FROM ".DB::table('brand_settings')." WHERE variable='groupbuy_zidingyi'");
$consume_sortid = DB::result_first("SELECT value FROM ".DB::table('brand_settings')." WHERE variable='consume_zidingyi'");
$shop_fid = DB::result_first("SELECT value FROM ".DB::table('brand_settings')." WHERE variable='shop_forum'");
$goods_fid = DB::result_first("SELECT value FROM ".DB::table('brand_settings')." WHERE variable='goods_forum'");
$groupbuy_fid = DB::result_first("SELECT value FROM ".DB::table('brand_settings')." WHERE variable='groupbuy_forum'");
$consume_fid = DB::result_first("SELECT value FROM ".DB::table('brand_settings')." WHERE variable='consume_forum'");

$sortid = $shop_fid;
$sortoption_array = array('ykt_logo','ykt_dpdh','ykt_dizhi','ykt_UID','ykt_shuomin','ykt_shopid','ykt_sptp');
foreach ($sortoption_array as $sokey=>$sovalue){
	$sort_dis[$sovalue] = DB::result_first("SELECT optionid FROM ".DB::table('forum_typeoption')." WHERE identifier='".$sovalue."'");
}

$query = DB::query("SELECT * FROM ".DB::table('forum_typeoptionvar')." WHERE optionid =".$sort_dis['ykt_UID']." and value='".$_G['uid']."'");
while($row = DB::fetch($query)) {
	$query1 = DB::query("SELECT optionid,value FROM ".DB::table('forum_typeoptionvar')." WHERE tid =".$row['tid']);
	while($row1 = DB::fetch($query1)) {
		$sortvalue[$row['tid']][$row1['optionid']] = $row1['value'];
	}
	$sortvalue[$row['tid']]['subject'] = DB::result_first("SELECT subject FROM ".DB::table('forum_thread')." WHERE tid=".$row['tid']);
	$sortvalue[$row['tid']]['fid'] = DB::result_first("SELECT fid FROM ".DB::table('forum_thread')." WHERE tid=".$row['tid']);
	$sortvalue[$row['tid']]['pid'] = DB::result_first("SELECT pid FROM ".DB::table('forum_post')." WHERE tid=".$row['tid']." and first=1");
	$sortvalue[$row['tid']]['goods_num'] = DB::result_first("SELECT count(*) FROM ".DB::table('forum_typeoptionvar')." WHERE optionid =".$sort_dis['ykt_shopid']." and value='".$row['tid']."'");
	$sortvalue[$row['tid']]['tid'] = $row['tid'];
}
$shop_num = count($sortvalue);
//var_dump($sortvalue);


include_once template('yktmanage_'.$mod ,0,$template.'/plugin');

?>