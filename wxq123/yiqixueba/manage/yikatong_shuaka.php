<?php

/**
*	一起学吧平台程序
*	文件名：yikatong_shuaka.php  创建时间：2013-6-14 09:26  杨文
*
*/

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$goods_table = $base_setting['yiqixueba_yikatong_goods_table'];
$goods_fields = dunserialize($base_setting['yiqixueba_yikatong_goodsfields']);

$subop = getgpc('subop');
$xflx_array = array('jici','shijian','liangka','xianjin','yue','jifen');
$subop = $subop ? $subop : $xflx_array[0];

$goodsid = getgpc('goodsid');

$xiaofei_list = array();
foreach ( $xflx_array as $k => $v ){
	$xiaofei_list[$v] = lang('plugin/yiqixueba','xiaofei_'.$v);
}


$goodslist = array();
$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_yikatong_goods')." WHERE ".$subop." = 1 order by goodsid desc");
$k = 0;
while($row = DB::fetch($query)) {
	$goods_info = DB::fetch_first("SELECT * FROM ".DB::table($goods_table)." WHERE ".$goods_fields['goodsid']."=".$row['goodsid']);
	$goodslist[$k]['goodsid'] = $goods_info[$goods_fields['goodsid']];
	$goodslist[$k]['goodsname'] = $goods_info[$goods_fields['goodsname']];
	$goodslist[$k]['goodspice'] = $goods_info[$goods_fields['goodspice']];
	$goodslist[$k]['goodsnum'] = $goods_fields['goodsnum'] ? $goods_info[$goods_fields['goodsnum']] : $row['goodsnum'];
	if($goodsid&&$goodslist[$k]['goodsid'] ==$goodsid){
		$dangqian_k = $k;
	}
	$k++;
}
$skgoods_info = $goodslist[$dangqian_k];
$dangqian_op =  lang('plugin/yiqixueba','xiaofei_'.$subop);
$goods_num = count($goodslist);
if(!submitcheck('shuakasubmit')) {
}else{
	showmessage('商品设置成功，请等待审核', 'plugin.php?id=yiqixueba:manage&man=yktdianzhu&subman=yktgoods');
}