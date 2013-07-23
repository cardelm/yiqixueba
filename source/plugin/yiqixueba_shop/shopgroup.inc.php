<?php

/**
*	商家展示-商家组程序
*	文件名：shopgroup.inc.php 创建时间：2013-7-23 09:16  杨文
*
*/

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

require_once DISCUZ_ROOT.'source/plugin/yiqixueba_shop/function.func.php';

$this_page = substr($_SERVER['QUERY_STRING'],7,strlen($_SERVER['QUERY_STRING'])-7);
stripos($this_page,'subac=') ? $this_page = substr($this_page,0,stripos($this_page,'subac=')-1) : $this_page;

$subac = getgpc('subac');
$subacs = array('shopgrouplist','shopgroupedit');
$subac = in_array($subac,$subacs) ? $subac : $subacs[0];

$shopgroupid = getgpc('shopgroupid');
$shopgroup_info = $shopgroupid ? DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_shop_shopgroup')." WHERE shopgroupid=".$shopgroupid) : array();

if($subac == 'shopgrouplist') {
	if(!submitcheck('submit')) {
		showtips(lang('plugin/yiqixueba_shop','shopgroup_list_tips'));
		showformheader($this_page.'&subac=shopgrouplist');
		showtableheader(lang('plugin/yiqixueba_shop','shopgroup_list'));
		$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_shop_shopgroup')." order by displayorder asc");
		while($row = DB::fetch($query)) {
			showtablerow('', array('class="td25"', 'class="td23"', 'class="td28"'), array(
				"<input class=\"checkbox\" type=\"checkbox\" name=\"delete[]\" value=\"$row[shopgroupid]\">",
				$row['shopgroupname'],
				"<input class=\"checkbox\" type=\"checkbox\" name=\"statusnew[".$row['shopgroupid']."]\" value=\"1\" ".($row['status'] > 0 ? 'checked' : '').">",
				"<a href=\"".ADMINSCRIPT."?action=".$this_page."&subac=shopgroupedit&shopgroupid=$row[shopgroupid]\" class=\"act\">".lang('plugin/yiqixueba_shop','edit')."</a>",
			));
		}
	echo '<tr><td></td><td colspan="6"><div><a href="'.ADMINSCRIPT.'?action='.$this_page.'&subac=shopgroupedit" class="addtr">'.lang('plugin/yiqixueba_shop','add_shopgroup').'</a></div></td></tr>';
	showsubmit('submit','submit','del');
	showtablefooter();
	showformfooter();
	}else{
	}
}elseif($subac == 'shopgroupedit') {
	if(!submitcheck('submit')) {
		showtips(lang('plugin/yiqixueba_shop','shopgroup_edit_tips'));
		showformheader($this_page.'&subac=shopgroupedit','enctype');
		showtableheader(lang('plugin/yiqixueba_shop','shopgroup_edit'));
		$shopgroupid ? showhiddenfields(array('shopgroupid'=>$shopgroupid)) : '';
		showsetting(lang('plugin/yiqixueba_shop','shopgroupname'),'shopgroup_info[shopgroupname]',$shopgroup_info['shopgroupname'],'text','',0,lang('plugin/yiqixueba_shop','shopgroupname_comment'),'','',true);
		showsubmit('submit');
		showtablefooter();
		showformfooter();
	}else{
		if(!htmlspecialchars(trim($_GET['shopgroup_info']['shopgroupname']))) {
			cpmsg(lang('plugin/yiqixueba_shop','shopgroupname_nonull'));
		}
		$datas = $_GET['shopgroup_info'];
		foreach ( $datas as $k=>$v) {
			$data[$k] = htmlspecialchars(trim($v));
			if(!DB::result_first("describe ".DB::table('yiqixueba_shop_shopgroup')." ".$k)) {
				$sql = "alter table ".DB::table('yiqixueba_shop_shopgroup')." add `".$k."` varchar(255) not Null;";
				runquery($sql);
			}
		}
		if($shopgroupid) {
			DB::update('yiqixueba_shop_shopgroup',$data,array('shopgroupid'=>$shopgroupid));
		}else{
			DB::insert('yiqixueba_shop_shopgroup',$data);
		}
		cpmsg(lang('plugin/yiqixueba_shop', 'shopgroup_edit_succeed'), 'action='.$this_page.'&subac=shopgrouplist', 'succeed');
	}
	
}
?>