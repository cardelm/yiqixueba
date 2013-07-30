<?php

/**
*	一起学吧平台程序
*	文件名：goods_setting.inc.php  创建时间：2013-7-9 12:24  杨文
*
*/

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
$this_page = 'plugins&identifier=yiqixueba&pmod=admin&submod=goods_setting';

$subac = getgpc('subac');
$subacs = array('settinglist','settingedit');
$subac = in_array($subac,$subacs) ? $subac : $subacs[0];

$settingid = getgpc('settingid');
$setting_info = $settingid ? DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_goods_setting')." WHERE settingid=".$settingid) : array();

if($subac == 'settinglist') {
	if(!submitcheck('submit')) {
		showtips(lang('plugin/yiqixueba','setting_list_tips'));
		showformheader($this_page.'&subac=settinglist');
		showtableheader(lang('plugin/yiqixueba','setting_list'));
		showsubtitle(array('', lang('plugin/yiqixueba','settingname'),lang('plugin/yiqixueba','shopnum'), lang('plugin/yiqixueba','settingquanxian'), lang('plugin/yiqixueba','status'), ''));
		//$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_goods_setting')." order by settingid asc");
		//while($row = DB::fetch($query)) {
			showtablerow('', array('class="td25"','class="td23"', 'class="td23"', 'class="td23"','class="td25"',''), array(
				"<input class=\"checkbox\" type=\"checkbox\" name=\"delete[]\" value=\"$row[settingid]\">",
			$row['settingname'],
			$row['settingname'],
			$row['settingname'],
			"<input class=\"checkbox\" type=\"checkbox\" name=\"statusnew[".$row['settingid']."]\" value=\"1\" ".($row['status'] > 0 ? 'checked' : '').">",
				"<a href=\"".ADMINSCRIPT."?action=".$this_page."&subac=settingedit&settingid=$row[settingid]\" class=\"act\">".lang('plugin/yiqixueba','edit')."</a>",
			));
		//}
		echo '<tr><td></td><td colspan="6"><div><a href="'.ADMINSCRIPT.'?action='.$this_page.'&subac=settingedit" class="addtr">'.lang('plugin/yiqixueba','add_setting').'</a></div></td></tr>';
		showsubmit('submit','submit','del');
		showtablefooter();
		showformfooter();
	}else{
	}
}elseif($subac == 'settingedit') {
	if(!submitcheck('submit')) {
		showtips(lang('plugin/yiqixueba','setting_edit_tips'));
		showformheader($this_page.'&subac=settingedit','enctype');
		showtableheader(lang('plugin/yiqixueba','setting_edit'));
		$settingid ? showhiddenfields(array('settingid'=>$settingid)) : '';
		showsetting(lang('plugin/yiqixueba','settingname'),'setting_info[settingname]',$setting_info['settingname'],'text','',0,lang('plugin/yiqixueba','settingname_comment'),'','',true);
		showsubmit('submit');
		showtablefooter();
		showformfooter();
	}else{
		if(!htmlspecialchars(trim($_GET['setting_info']['settingname']))) {
			cpmsg(lang('plugin/yiqixueba','settingname_nonull'));
		}
		$datas = $_GET['setting_info'];
		foreach ( $datas as $k=>$v) {
			$data[$k] = htmlspecialchars(trim($v));
			if(!DB::result_first("describe ".DB::table('yiqixueba_goods_setting')." ".$k)) {
				$sql = "alter table ".DB::table('yiqixueba_goods_setting')." add `".$k."` varchar(255) not Null;";
				runquery($sql);
			}
		}
		if($settingid) {
			DB::update('yiqixueba_goods_setting',$data,array('settingid'=>$settingid));
		}else{
			DB::insert('yiqixueba_goods_setting',$data);
		}
		cpmsg(lang('plugin/yiqixueba', 'setting_edit_succeed'), 'action='.$this_page.'&subac=settinglist', 'succeed');
	}
}

?>