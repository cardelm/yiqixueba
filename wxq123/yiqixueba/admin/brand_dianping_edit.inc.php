<?php

/**
*	一起学吧平台程序
*	文件名：brand_dianping_setting.inc.php  创建时间：2013-6-9 16:25  杨文
*
*/
//一卡通设置页面
//此页面有两个地方引用，一个是“基础设置”中的模块管理中的模块列表中的设置
//还有就是顶部菜单中一卡通中的设置
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}


//读取yiqixueba_setting参数设置中的一卡通参数
$mokuai_setting = array();
$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_setting')." WHERE skey like 'yiqixueba_".$mokuai_info['upmokuai']."_".$mokuai_info['mokuainame']."%'");
while($row = DB::fetch($query)) {
	$mokuai_setting[$row['skey']] = $row['svalue'];
}
$mokuaiid = $mokuaiid ? $mokuaiid : $mokuai_info['mokuaiid'];

$pre_var = 'yiqixueba_'.$mokuai_info['upmokuai'].'_'.$mokuai_info['mokuainame'];

if(!submitcheck('submit')) {
	showtips(lang('plugin/yiqixueba','brand_goods_edit_tips'));
	showformheader($this_page.'&subac=brand_goodsedit','enctype');
	showtableheader(lang('plugin/yiqixueba','brand_goods_edit'));
	$brand_goodsid ? showhiddenfields(array('brand_goodsid'=>$brand_goodsid)) : '';
	showsetting(lang('plugin/yiqixueba','brand_goodsname'),'brand_goods_info[brand_goodsname]',$brand_goods_info['brand_goodsname'],'text','',0,lang('plugin/yiqixueba','brand_goodsname_comment'),'','',true);
	showsubmit('submit');
	showtablefooter();
	showformfooter();
}else{
	if(!htmlspecialchars(trim($_GET['brand_goods_info']['brand_goodsname']))) {
		cpmsg(lang('plugin/yiqixueba','brand_goodsname_nonull'));
	}
	$datas = $_GET['brand_goods_info'];
	foreach ( $datas as $k=>$v) {
		$data[$k] = htmlspecialchars(trim($v));
		if(!DB::result_first("describe ".DB::table('yiqixueba_brand_goods')." ".$k)) {
			$sql = "alter table ".DB::table('yiqixueba_brand_goods')." add `".$k."` varchar(255) not Null;";
			runquery($sql);
		}
	}
	if($brand_goodsid) {
		DB::update('yiqixueba_brand_goods',$data,array('brand_goodsid'=>$brand_goodsid));
	}else{
		DB::insert('yiqixueba_brand_goods',$data);
	}
	cpmsg(lang('plugin/yiqixueba', 'brand_goods_edit_succeed'), 'action='.$this_page.'&subac=brand_goodslist', 'succeed');
}
?>