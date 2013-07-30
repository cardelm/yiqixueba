<?php

/**
*	一起学吧平台程序
*	文件名：brand_goods.inc.php  创建时间：2013-6-9 16:38  杨文
*
*/

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
$this_page = 'plugins&identifier=yiqixueba&pmod=admin&submod=brand_goods';

$subac = getgpc('subac');
$subacs = array('goodstypelist','goodssetting','goodslist','goodsedit');
$subac = in_array($subac,$subacs) ? $subac : $subacs[0];

$upmokuai = $shopid ? $shop_info['upmokuai'] :intval(getgpc('upmokuai'));

$mokuai_data = array();
$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_mokuai')."  WHERE upmokuai='brand' order by displayorder asc");
while($row = DB::fetch($query)) {
	$mokuai_data[$row['mokuaiid']] = $row;
}

$mokuaiid = getgpc('mokuaiid');
$mokuai_info = $mokuaiid ? DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_mokuai')." WHERE mokuaiid=".$mokuaiid) : array();

$goodsid = getgpc('goodsid');
$goods_info = $goodsid ? DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_brand_goods')." WHERE goodsid=".$goodsid) : array();

if($subac == 'goodstypelist') {
	if(!submitcheck('submit')) {
		showtips(lang('plugin/yiqixueba','brand_goodstype_list_tips'));
		showformheader($this_page.'&subac=goodstypelist');
		showtableheader(lang('plugin/yiqixueba','goodstype_list'));
		showsubtitle(array('', lang('plugin/yiqixueba','goodstype'),lang('plugin/yiqixueba','goodsnum'), lang('plugin/yiqixueba','status'), ''));
		$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_mokuai')." WHERE upmokuai = 'brand' order by displayorder asc");
		$k = 1;
		while($row = DB::fetch($query)) {
			showtablerow('', array('class="td25"','class="td27"', 'class="td23"', 'class="td25"',''), array(
				$k,
				$row['mokuaititle'],
				intval(DB::result_first("SELECT count(*) FROM ".DB::table('yiqixueba_brand_'.$row['mokuainame']))),
				"<input class=\"checkbox\" type=\"checkbox\" name=\"statusnew[".$row['brand_goodsid']."]\" value=\"1\" ".($row['status'] > 0 ? 'checked' : '').">",
				"<a href=\"".ADMINSCRIPT."?action=".$this_page."&subac=goodssetting&mokuaiid=$row[mokuaiid]\" class=\"act\">".lang('plugin/yiqixueba','mokuai_setting')."</a>&nbsp;&nbsp;<a href=\"".ADMINSCRIPT."?action=".$this_page."&subac=goodslist&mokuaiid=$row[mokuaiid]\" class=\"act\">".lang('plugin/yiqixueba','mokuai_manage')."</a>",
			));
			$k++;
		}
		//echo $upmokuai ? '<tr><td></td><td colspan="6"><div><a href="'.ADMINSCRIPT.'?action='.$this_page.'&subac=goodsedit" class="addtr">'.lang('plugin/yiqixueba','add_goods').'</a></div></td></tr>' : '' ;
		//showsubmit('submit','submit','');
		showtablefooter();
		showformfooter();
	}else{
	}
}elseif($subac == 'goodssetting') {
	$setting_file = DISCUZ_ROOT.'source/plugin/yiqixueba/admin/'.($mokuai_info['upmokuai'] ? $mokuai_info['upmokuai'].'_' : '').$mokuai_info['mokuainame'].'_setting.inc.php';
	if (!file_exists($setting_file)){
		copy(DISCUZ_ROOT.'source/plugin/yiqixueba/admin/brand_dianping_setting.inc.php',$setting_file);
	}
	require_once $setting_file;
}elseif($subac == 'goodslist') {
	$list_file = DISCUZ_ROOT.'source/plugin/yiqixueba/admin/'.($mokuai_info['upmokuai'] ? $mokuai_info['upmokuai'].'_' : '').$mokuai_info['mokuainame'].'_list.inc.php';
	if (!file_exists($list_file)){
		copy(DISCUZ_ROOT.'source/plugin/yiqixueba/admin/brand_dianping_list.inc.php',$list_file);
	}
	require_once $list_file;
}
elseif($subac == 'goodsedit') {
	$edit_file = DISCUZ_ROOT.'source/plugin/yiqixueba/admin/'.($mokuai_info['upmokuai'] ? $mokuai_info['upmokuai'].'_' : '').$mokuai_info['mokuainame'].'_edit.inc.php';
	if (!file_exists($edit_file)){
		copy(DISCUZ_ROOT.'source/plugin/yiqixueba/admin/brand_dianping_edit.inc.php',$edit_file);
	}
	require_once $edit_file;
}
?>