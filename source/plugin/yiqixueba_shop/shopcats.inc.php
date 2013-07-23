<?php

/**
*	商家展示-商家分类程序
*	文件名：shopcats.inc.php 创建时间：2013-7-23 09:16  杨文
*
*/

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

require_once DISCUZ_ROOT.'source/plugin/yiqixueba_shop/function.func.php';

$this_page = substr($_SERVER['QUERY_STRING'],7,strlen($_SERVER['QUERY_STRING'])-7);
stripos($this_page,'subac=') ? $this_page = substr($this_page,0,stripos($this_page,'subac=')-1) : $this_page;

$subac = getgpc('subac');
$subacs = array('shopcatslist','shopcatsedit');
$subac = in_array($subac,$subacs) ? $subac : $subacs[0];

$shopcatsid = getgpc('shopcatsid');
$shopcats_info = $shopcatsid ? DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_shop_shopcats')." WHERE shopcatsid=".$shopcatsid) : array();

if($subac == 'shopcatslist') {
	if(!submitcheck('submit')) {
		showtips(lang('plugin/yiqixueba_shop','shopcats_list_tips'));
		showformheader($this_page.'&subac=shopcatslist');
		showtableheader(lang('plugin/yiqixueba_shop','shopcats_list'));
		$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_shop_shopcats')." order by displayorder asc");
		while($row = DB::fetch($query)) {
			showtablerow('', array('class="td25"', 'class="td23"', 'class="td28"'), array(
				"<input class=\"checkbox\" type=\"checkbox\" name=\"delete[]\" value=\"$row[shopcatsid]\">",
				$row['shopcatsname'],
				"<input class=\"checkbox\" type=\"checkbox\" name=\"statusnew[".$row['shopcatsid']."]\" value=\"1\" ".($row['status'] > 0 ? 'checked' : '').">",
				"<a href=\"".ADMINSCRIPT."?action=".$this_page."&subac=shopcatsedit&shopcatsid=$row[shopcatsid]\" class=\"act\">".lang('plugin/yiqixueba_shop','edit')."</a>",
			));
		}
	echo '<tr><td></td><td colspan="6"><div><a href="'.ADMINSCRIPT.'?action='.$this_page.'&subac=shopcatsedit" class="addtr">'.lang('plugin/yiqixueba_shop','add_shopcats').'</a></div></td></tr>';
	showsubmit('submit','submit','del');
	showtablefooter();
	showformfooter();
	}else{
	}
}elseif($subac == 'shopcatsedit') {
	if(!submitcheck('submit')) {
		showtips(lang('plugin/yiqixueba_shop','shopcats_edit_tips'));
		showformheader($this_page.'&subac=shopcatsedit','enctype');
		showtableheader(lang('plugin/yiqixueba_shop','shopcats_edit'));
		$shopcatsid ? showhiddenfields(array('shopcatsid'=>$shopcatsid)) : '';
		showsetting(lang('plugin/yiqixueba_shop','shopcatsname'),'shopcats_info[shopcatsname]',$shopcats_info['shopcatsname'],'text','',0,lang('plugin/yiqixueba_shop','shopcatsname_comment'),'','',true);
		showsubmit('submit');
		showtablefooter();
		showformfooter();
	}else{
		if(!htmlspecialchars(trim($_GET['shopcats_info']['shopcatsname']))) {
			cpmsg(lang('plugin/yiqixueba_shop','shopcatsname_nonull'));
		}
		$datas = $_GET['shopcats_info'];
		foreach ( $datas as $k=>$v) {
			$data[$k] = htmlspecialchars(trim($v));
			if(!DB::result_first("describe ".DB::table('yiqixueba_shop_shopcats')." ".$k)) {
				$sql = "alter table ".DB::table('yiqixueba_shop_shopcats')." add `".$k."` varchar(255) not Null;";
				runquery($sql);
			}
		}
		if($shopcatsid) {
			DB::update('yiqixueba_shop_shopcats',$data,array('shopcatsid'=>$shopcatsid));
		}else{
			DB::insert('yiqixueba_shop_shopcats',$data);
		}
		cpmsg(lang('plugin/yiqixueba_shop', 'shopcats_edit_succeed'), 'action='.$this_page.'&subac=shopcatslist', 'succeed');
	}
	
}
?>