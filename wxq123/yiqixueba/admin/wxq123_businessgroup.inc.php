<?php

/**
*	一起学吧平台程序
*	文件名：wxq123_businessgroup.inc.php  创建时间：2013-6-23 01:55  杨文
*
*/

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
$this_page = 'plugins&identifier=yiqixueba&pmod=admin&submod=wxq123_businessgroup';

$subac = getgpc('subac');
$subacs = array('businessgrouplist','businessgroupedit');
$subac = in_array($subac,$subacs) ? $subac : $subacs[0];

$businessgroupid = getgpc('businessgroupid');
$businessgroup_info = $businessgroupid ? DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_wxq123_businessgroup')." WHERE businessgroupid=".$businessgroupid) : array();

if($subac == 'businessgrouplist') {
	if(!submitcheck('submit')) {
		showtips(lang('plugin/yiqixueba','businessgroup_list_tips'));
		showformheader($this_page.'&subac=businessgrouplist');
		showtableheader(lang('plugin/yiqixueba','businessgroup_list'));
		showsubtitle(array('', lang('plugin/yiqixueba','businessgroupname'),lang('plugin/yiqixueba','shopnum'), lang('plugin/yiqixueba','businessgroupquanxian'), lang('plugin/yiqixueba','status'), ''));
		$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_wxq123_businessgroup')." order by businessgroupid asc");
		while($row = DB::fetch($query)) {
			showtablerow('', array('class="td25"','class="td23"', 'class="td23"', 'class="td23"','class="td25"',''), array(
				"<input class=\"checkbox\" type=\"checkbox\" name=\"delete[]\" value=\"$row[businessgroupid]\">",
			$row['businessgroupname'],
			$row['businessgroupname'],
			$row['businessgroupname'],
			"<input class=\"checkbox\" type=\"checkbox\" name=\"statusnew[".$row['businessgroupid']."]\" value=\"1\" ".($row['status'] > 0 ? 'checked' : '').">",
				"<a href=\"".ADMINSCRIPT."?action=".$this_page."&subac=businessgroupedit&businessgroupid=$row[businessgroupid]\" class=\"act\">".lang('plugin/yiqixueba','edit')."</a>",
			));
		}
		echo '<tr><td></td><td colspan="6"><div><a href="'.ADMINSCRIPT.'?action='.$this_page.'&subac=businessgroupedit" class="addtr">'.lang('plugin/yiqixueba','add_businessgroup').'</a></div></td></tr>';
		showsubmit('submit','submit','del');
		showtablefooter();
		showformfooter();
	}else{
	}
}elseif($subac == 'businessgroupedit') {
	if(!submitcheck('submit')) {
		showtips(lang('plugin/yiqixueba','businessgroup_edit_tips'));
		showformheader($this_page.'&subac=businessgroupedit','enctype');
		showtableheader(lang('plugin/yiqixueba','businessgroup_edit'));
		$businessgroupid ? showhiddenfields(array('businessgroupid'=>$businessgroupid)) : '';
		showsetting(lang('plugin/yiqixueba','businessgroupname'),'businessgroup_info[businessgroupname]',$businessgroup_info['businessgroupname'],'text','',0,lang('plugin/yiqixueba','businessgroupname_comment'),'','',true);
		showsubmit('submit');
		showtablefooter();
		showformfooter();
	}else{
		if(!htmlspecialchars(trim($_GET['businessgroup_info']['businessgroupname']))) {
			cpmsg(lang('plugin/yiqixueba','businessgroupname_nonull'));
		}
		$datas = $_GET['businessgroup_info'];
		foreach ( $datas as $k=>$v) {
			$data[$k] = htmlspecialchars(trim($v));
			if(!DB::result_first("describe ".DB::table('yiqixueba_wxq123_businessgroup')." ".$k)) {
				$sql = "alter table ".DB::table('yiqixueba_wxq123_businessgroup')." add `".$k."` varchar(255) not Null;";
				runquery($sql);
			}
		}
		if($businessgroupid) {
			DB::update('yiqixueba_wxq123_businessgroup',$data,array('businessgroupid'=>$businessgroupid));
		}else{
			DB::insert('yiqixueba_wxq123_businessgroup',$data);
		}
		cpmsg(lang('plugin/yiqixueba', 'businessgroup_edit_succeed'), 'action='.$this_page.'&subac=businessgrouplist', 'succeed');
	}
}

?>