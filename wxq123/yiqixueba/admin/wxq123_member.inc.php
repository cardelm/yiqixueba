<?php

/**
*	一起学吧平台程序
*	文件名：wxq123_member.inc.php  创建时间：2013-6-30 22:14  杨文
*
*/

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
$this_page = 'plugins&identifier=yiqixueba&pmod=admin&submod=wxq123_member';

$subac = getgpc('subac');
$subacs = array('memberlist','memberedit');
$subac = in_array($subac,$subacs) ? $subac : $subacs[0];

$memberid = getgpc('memberid');
$member_info = $memberid ? DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_wxq123_member')." WHERE memberid=".$memberid) : array();

if($subac == 'memberlist') {
	if(!submitcheck('submit')) {
		showtips(lang('plugin/yiqixueba','member_list_tips'));
		showformheader($this_page.'&subac=memberlist');
		showtableheader(lang('plugin/yiqixueba','member_list'));
		showsubtitle(array('', lang('plugin/yiqixueba','membername'),lang('plugin/yiqixueba','shopnum'), lang('plugin/yiqixueba','memberquanxian'), lang('plugin/yiqixueba','status'), ''));
		//$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_wxq123_member')." order by memberid asc");
		//while($row = DB::fetch($query)) {
			showtablerow('', array('class="td25"','class="td23"', 'class="td23"', 'class="td23"','class="td25"',''), array(
				"<input class=\"checkbox\" type=\"checkbox\" name=\"delete[]\" value=\"$row[memberid]\">",
			$row['membername'],
			$row['membername'],
			$row['membername'],
			"<input class=\"checkbox\" type=\"checkbox\" name=\"statusnew[".$row['memberid']."]\" value=\"1\" ".($row['status'] > 0 ? 'checked' : '').">",
				"<a href=\"".ADMINSCRIPT."?action=".$this_page."&subac=memberedit&memberid=$row[memberid]\" class=\"act\">".lang('plugin/yiqixueba','edit')."</a>",
			));
		//}
		echo '<tr><td></td><td colspan="6"><div><a href="'.ADMINSCRIPT.'?action='.$this_page.'&subac=memberedit" class="addtr">'.lang('plugin/yiqixueba','add_member').'</a></div></td></tr>';
		showsubmit('submit','submit','del');
		showtablefooter();
		showformfooter();
	}else{
	}
}elseif($subac == 'memberedit') {
	if(!submitcheck('submit')) {
		showtips(lang('plugin/yiqixueba','member_edit_tips'));
		showformheader($this_page.'&subac=memberedit','enctype');
		showtableheader(lang('plugin/yiqixueba','member_edit'));
		$memberid ? showhiddenfields(array('memberid'=>$memberid)) : '';
		showsetting(lang('plugin/yiqixueba','membername'),'member_info[membername]',$member_info['membername'],'text','',0,lang('plugin/yiqixueba','membername_comment'),'','',true);
		showsubmit('submit');
		showtablefooter();
		showformfooter();
	}else{
		if(!htmlspecialchars(trim($_GET['member_info']['membername']))) {
			cpmsg(lang('plugin/yiqixueba','membername_nonull'));
		}
		$datas = $_GET['member_info'];
		foreach ( $datas as $k=>$v) {
			$data[$k] = htmlspecialchars(trim($v));
			if(!DB::result_first("describe ".DB::table('yiqixueba_wxq123_member')." ".$k)) {
				$sql = "alter table ".DB::table('yiqixueba_wxq123_member')." add `".$k."` varchar(255) not Null;";
				runquery($sql);
			}
		}
		if($memberid) {
			DB::update('yiqixueba_wxq123_member',$data,array('memberid'=>$memberid));
		}else{
			DB::insert('yiqixueba_wxq123_member',$data);
		}
		cpmsg(lang('plugin/yiqixueba', 'member_edit_succeed'), 'action='.$this_page.'&subac=memberlist', 'succeed');
	}
}

?>