<?php

/**
*	一起学吧平台程序
*	文件名：shop_shopsetting.inc.php  创建时间：2013-6-4 09:36  杨文
*
*/

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
$this_page = 'plugins&identifier=yiqixueba&pmod=admin&submod=shopsetting';

$subac = getgpc('subac');
$subacs = array('shopsettinglist','shopsettingedit');
$subac = in_array($subac,$subacs) ? $subac : $subacs[0];

$shopsettingid = getgpc('shopsettingid');
$shopsetting_info = $shopsettingid ? DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_shopsetting')." WHERE shopsettingid=".$shopsettingid) : array();

if($subac == 'shopsettinglist') {
	if(!submitcheck('submit')) {
		showtips(lang('plugin/yiqixueba','shopsetting_list_tips'));
		showformheader($this_page.'&subac=shopsettinglist');
		showtableheader(lang('plugin/yiqixueba','shopsetting_list'));
		showsubtitle(array('', lang('plugin/yiqixueba','shopsettingname'),lang('plugin/yiqixueba','shopnum'), lang('plugin/yiqixueba','shopsettingquanxian'), lang('plugin/yiqixueba','status'), ''));
		//$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_shopsetting')." order by shopsettingid asc");
		//while($row = DB::fetch($query)) {
			showtablerow('', array('class="td25"','class="td23"', 'class="td23"', 'class="td23"','class="td25"',''), array(
				"<input class=\"checkbox\" type=\"checkbox\" name=\"delete[]\" value=\"$row[shopsettingid]\">",
			$row['shopsettingname'],
			$row['shopsettingname'],
			$row['shopsettingname'],
			"<input class=\"checkbox\" type=\"checkbox\" name=\"statusnew[".$row['shopsettingid']."]\" value=\"1\" ".($row['status'] > 0 ? 'checked' : '').">",
				"<a href=\"".ADMINSCRIPT."?action=".$this_page."&subac=shopsettingedit&shopsettingid=$row[shopsettingid]\" class=\"act\">".lang('plugin/yiqixueba','edit')."</a>",
			));
		//}
		echo '<tr><td></td><td colspan="6"><div><a href="'.ADMINSCRIPT.'?action='.$this_page.'&subac=shopsettingedit" class="addtr">'.lang('plugin/yiqixueba','add_shopsetting').'</a></div></td></tr>';
		showsubmit('submit','submit','del');
		showtablefooter();
		showformfooter();
	}else{
	}
}elseif($subac == 'shopsettingedit') {
	if(!submitcheck('submit')) {
		showtips(lang('plugin/yiqixueba','shopsetting_edit_tips'));
		showformheader($this_page.'&subac=shopsettingedit','enctype');
		showtableheader(lang('plugin/yiqixueba','shopsetting_edit'));
		$shopsettingid ? showhiddenfields(array('shopsettingid'=>$shopsettingid)) : '';
		showsetting(lang('plugin/yiqixueba','shopsettingname'),'shopsetting_info[shopsettingname]',$shopsetting_info['shopsettingname'],'text','',0,lang('plugin/yiqixueba','shopsettingname_comment'),'','',true);
		showsubmit('submit');
		showtablefooter();
		showformfooter();
	}else{
		if(!htmlspecialchars(trim($_GET['shopsetting_info']['shopsettingname']))) {
			cpmsg(lang('plugin/yiqixueba','shopsettingname_nonull'));
		}
		$datas = $_GET['shopsetting_info'];
		foreach ( $datas as $k=>$v) {
			$data[$k] = htmlspecialchars(trim($v));
			if(!DB::result_first("describe ".DB::table('yiqixueba_shopsetting')." ".$k)) {
				$sql = "alter table ".DB::table('yiqixueba_shopsetting')." add `".$k."` varchar(255) not Null;";
				runquery($sql);
			}
		}
		if($shopsettingid) {
			DB::update('yiqixueba_shopsetting',$data,array('shopsettingid'=>$shopsettingid));
		}else{
			DB::insert('yiqixueba_shopsetting',$data);
		}
		cpmsg(lang('plugin/yiqixueba', 'shopsetting_edit_succeed'), 'action='.$this_page.'&subac=shopsettinglist', 'succeed');
	}
}

?>