<?php

/**
*	商家展示-商家模型程序
*	文件名：shopmoxing.inc.php 创建时间：2013-7-23 17:42  杨文
*
*/

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

require_once DISCUZ_ROOT.'source/plugin/yiqixueba_shop/function.func.php';

$this_page = substr($_SERVER['QUERY_STRING'],7,strlen($_SERVER['QUERY_STRING'])-7);
stripos($this_page,'subac=') ? $this_page = substr($this_page,0,stripos($this_page,'subac=')-1) : $this_page;

$subac = getgpc('subac');
$subacs = array('shopmoxinglist','shopmoxingedit');
$subac = in_array($subac,$subacs) ? $subac : $subacs[0];

$shopmoxingid = getgpc('shopmoxingid');
$shopmoxing_info = $shopmoxingid ? DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_shop_shopmoxing')." WHERE shopmoxingid=".$shopmoxingid) : array();

if($subac == 'shopmoxinglist') {
	if(!submitcheck('submit')) {
		showtips(lang('plugin/yiqixueba_shop','shopmoxing_list_tips'));
		showformheader($this_page.'&subac=shopmoxinglist');
		showtableheader(lang('plugin/yiqixueba_shop','shopmoxing_list'));
		$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_shop_shopmoxing')." order by displayorder asc");
		while($row = DB::fetch($query)) {
			showtablerow('', array('class="td25"', 'class="td23"', 'class="td28"'), array(
				"<input class=\"checkbox\" type=\"checkbox\" name=\"delete[]\" value=\"$row[shopmoxingid]\">",
				$row['shopmoxingname'],
				"<input class=\"checkbox\" type=\"checkbox\" name=\"statusnew[".$row['shopmoxingid']."]\" value=\"1\" ".($row['status'] > 0 ? 'checked' : '').">",
				"<a href=\"".ADMINSCRIPT."?action=".$this_page."&subac=shopmoxingedit&shopmoxingid=$row[shopmoxingid]\" class=\"act\">".lang('plugin/yiqixueba_shop','edit')."</a>",
			));
		}
	echo '<tr><td></td><td colspan="6"><div><a href="'.ADMINSCRIPT.'?action='.$this_page.'&subac=shopmoxingedit" class="addtr">'.lang('plugin/yiqixueba_shop','add_shopmoxing').'</a></div></td></tr>';
	showsubmit('submit','submit','del');
	showtablefooter();
	showformfooter();
	}else{
	}
}elseif($subac == 'shopmoxingedit') {
	if(!submitcheck('submit')) {
		showtips(lang('plugin/yiqixueba_shop','shopmoxing_edit_tips'));
		showformheader($this_page.'&subac=shopmoxingedit','enctype');
		showtableheader(lang('plugin/yiqixueba_shop','shopmoxing_edit'));
		$shopmoxingid ? showhiddenfields(array('shopmoxingid'=>$shopmoxingid)) : '';
		showsetting(lang('plugin/yiqixueba_shop','shopmoxingname'),'shopmoxing_info[shopmoxingname]',$shopmoxing_info['shopmoxingname'],'text','',0,lang('plugin/yiqixueba_shop','shopmoxingname_comment'),'','',true);
		showsubmit('submit');
		showtablefooter();
		showformfooter();
	}else{
		if(!htmlspecialchars(trim($_GET['shopmoxing_info']['shopmoxingname']))) {
			cpmsg(lang('plugin/yiqixueba_shop','shopmoxingname_nonull'));
		}
		$datas = $_GET['shopmoxing_info'];
		foreach ( $datas as $k=>$v) {
			$data[$k] = htmlspecialchars(trim($v));
			if(!DB::result_first("describe ".DB::table('yiqixueba_shop_shopmoxing')." ".$k)) {
				$sql = "alter table ".DB::table('yiqixueba_shop_shopmoxing')." add `".$k."` varchar(255) not Null;";
				runquery($sql);
			}
		}
		if($shopmoxingid) {
			DB::update('yiqixueba_shop_shopmoxing',$data,array('shopmoxingid'=>$shopmoxingid));
		}else{
			DB::insert('yiqixueba_shop_shopmoxing',$data);
		}
		cpmsg(lang('plugin/yiqixueba_shop', 'shopmoxing_edit_succeed'), 'action='.$this_page.'&subac=shopmoxinglist', 'succeed');
	}
	
}
?>