<?php

/**
*	商家展示-商家管理程序
*	文件名：shop.inc.php 创建时间：2013-7-23 23:14  杨文
*
*/

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

require_once DISCUZ_ROOT.'source/plugin/yiqixueba_shop/function.func.php';

$this_page = substr($_SERVER['QUERY_STRING'],7,strlen($_SERVER['QUERY_STRING'])-7);
stripos($this_page,'subac=') ? $this_page = substr($this_page,0,stripos($this_page,'subac=')-1) : $this_page;

$subac = getgpc('subac');
$subacs = array('shoplist','shopedit');
$subac = in_array($subac,$subacs) ? $subac : $subacs[0];

$shopid = getgpc('shopid');
$shop_info = $shopid ? DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_shop_shop')." WHERE shopid=".$shopid) : array();

if($subac == 'shoplist') {
	if(!submitcheck('submit')) {
		showtips(lang('plugin/yiqixueba_shop','shop_list_tips'));
		showformheader($this_page.'&subac=shoplist');
		showtableheader(lang('plugin/yiqixueba_shop','shop_list'));
		$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_shop_shop')." order by displayorder asc");
		while($row = DB::fetch($query)) {
			showtablerow('', array('class="td25"', 'class="td23"', 'class="td28"'), array(
				"<input class=\"checkbox\" type=\"checkbox\" name=\"delete[]\" value=\"$row[shopid]\">",
				$row['shopname'],
				"<input class=\"checkbox\" type=\"checkbox\" name=\"statusnew[".$row['shopid']."]\" value=\"1\" ".($row['status'] > 0 ? 'checked' : '').">",
				"<a href=\"".ADMINSCRIPT."?action=".$this_page."&subac=shopedit&shopid=$row[shopid]\" class=\"act\">".lang('plugin/yiqixueba_shop','edit')."</a>",
			));
		}
	echo '<tr><td></td><td colspan="6"><div><a href="'.ADMINSCRIPT.'?action='.$this_page.'&subac=shopedit" class="addtr">'.lang('plugin/yiqixueba_shop','add_shop').'</a></div></td></tr>';
	showsubmit('submit','submit','del');
	showtablefooter();
	showformfooter();
	}else{
	}
}elseif($subac == 'shopedit') {
	if(!submitcheck('submit')) {
		showtips(lang('plugin/yiqixueba_shop','shop_edit_tips'));
		showformheader($this_page.'&subac=shopedit','enctype');
		showtableheader(lang('plugin/yiqixueba_shop','shop_edit'));
		$shopid ? showhiddenfields(array('shopid'=>$shopid)) : '';
		showsetting(lang('plugin/yiqixueba_shop','shopname'),'shop_info[shopname]',$shop_info['shopname'],'text','',0,lang('plugin/yiqixueba_shop','shopname_comment'),'','',true);
		showsubmit('submit');
		showtablefooter();
		showformfooter();
	}else{
		if(!htmlspecialchars(trim($_GET['shop_info']['shopname']))) {
			cpmsg(lang('plugin/yiqixueba_shop','shopname_nonull'));
		}
		$datas = $_GET['shop_info'];
		foreach ( $datas as $k=>$v) {
			$data[$k] = htmlspecialchars(trim($v));
			if(!DB::result_first("describe ".DB::table('yiqixueba_shop_shop')." ".$k)) {
				$sql = "alter table ".DB::table('yiqixueba_shop_shop')." add `".$k."` varchar(255) not Null;";
				runquery($sql);
			}
		}
		if($shopid) {
			DB::update('yiqixueba_shop_shop',$data,array('shopid'=>$shopid));
		}else{
			DB::insert('yiqixueba_shop_shop',$data);
		}
		cpmsg(lang('plugin/yiqixueba_shop', 'shop_edit_succeed'), 'action='.$this_page.'&subac=shoplist', 'succeed');
	}
	
}
?>