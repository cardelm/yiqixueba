<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
$navtitle = '查看消费记录';

$shopid = $_GET['shopid'];
$goodsid = $_GET['goodsid'];
$page = $_GET['page']?$_GET['page']:1;

$xflx_array = array('不限','现金消费','余额消费','积分消费','企业消费','快速消费');
$zt_array = array('买单','撤单');

$xiaofeileixin_array = array('1'=>'现金消费','2'=>'余额消费','3'=>'积分消费','5'=>'快速消费');
$search_xflx = '<select name="xflx"><option value="0">请选择</option>';
foreach ( $xiaofeileixin_array as $xk=>$xv){
	$search_xflx .= '<option value="'.$xk.'" '.($_POST['xflx']==$xk?' selected':'').'>'.$xv.'</option>';
}
$search_xflx .= '</select>';



$goods_sortid = DB::result_first("SELECT value FROM ".DB::table('brand_settings')." WHERE variable='goods_zidingyi'");
$goods_fid = DB::result_first("SELECT value FROM ".DB::table('brand_settings')." WHERE variable='goods_forum'");
$shop_sortid = DB::result_first("SELECT value FROM ".DB::table('brand_settings')." WHERE variable='shop_zidingyi'");
$shop_fid = DB::result_first("SELECT value FROM ".DB::table('brand_settings')." WHERE variable='shop_forum'");

$where = " WHERE sjuid =".$_G['uid'];
if($_POST['sssj']){
	$where .= " and sssj like '%".trim($_POST['sssj'])."%' ";
}
if($_POST['czy']){
	$where .= " and czy = '".trim($_POST['czy'])."' ";
}
if($_POST['hykh']){
	$where .= " and hykh = '".trim($_POST['hykh'])."' ";
}
if($_POST['xflx']){
	$where .= " and xflx = '".trim($_POST['xflx'])."' ";
}
if($shopid){
	$where .= " and dptid = ".intval($shopid)." ";
	$shop_name = DB::result_first("SELECT subject FROM ".DB::table('forum_thread')." WHERE tid=".$shopid);
}
if($goodsid){
	$where .= " and sptid = '".intval($goodsid)."' ";
	$goods_name = DB::result_first("SELECT subject FROM ".DB::table('forum_thread')." WHERE tid=".$goodsid);
}
if($_POST['starttime'] && $_POST['endtime']){
	$where .= " and jysj BETWEEN  '".$_POST['starttime']." 00:00:00' and '".$_POST['endtime']." 23:59:59' ";
}
$perpage = 10;
$start = ($page - 1) * $perpage;
$sitecount = DB::result_first("SELECT count(*) FROM ".DB::table('brand_xfjl').$where);
$multi = multi($sitecount, $perpage, $page,"plugin.php?id=yikatong:yktmanage&mod=xfjl&goodsid=$goodsid&shopid=$shopid");
$query = DB::query("SELECT * FROM ".DB::table('brand_xfjl').$where." order by jysj desc limit ".$start.",".$perpage." ");
$xiaofeijilu = array();
$key = 0;
while($row = DB::fetch($query)) {
	$xiaofeijilu[$key] = $row;
	$xiaofeijilu[$key]['xflx'] = $xflx_array[$row['xflx']];
	$xiaofeijilu[$key]['zt'] = $zt_array[$row['zt']];
	$key++;
}
$xflu_num = count($xiaofeijilu);

$multi = $multi ? $multi : "共有 <em>{$xflu_num}</em> 条消费记录";
$p1 = DB::result_first("SELECT sum(jg*js) FROM ".DB::table('brand_xfjl').$where." and xflx=1");
$p2 = DB::result_first("SELECT sum(jg*js) FROM ".DB::table('brand_xfjl').$where." and xflx=2");
$p3 = DB::result_first("SELECT sum(jg*js) FROM ".DB::table('brand_xfjl').$where." and xflx=3");
$p5 = DB::result_first("SELECT sum(jg*js) FROM ".DB::table('brand_xfjl').$where." and xflx=5");
$r1 = DB::result_first("SELECT sum(rangli) FROM ".DB::table('brand_xfjl').$where);
$p1 = $p1+$p5;
include_once template('yktmanage_'.$mod ,0,$template.'/plugin');

?>