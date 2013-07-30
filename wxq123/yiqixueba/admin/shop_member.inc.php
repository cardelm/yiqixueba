<?php

/**
*	一起学吧平台程序
*	文件名：shop_member.inc.php  创建时间：2013-6-8 12:39  杨文
*
*/

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
$this_page = 'plugins&identifier=yiqixueba&pmod=admin&submod=shop_member';

$subac = getgpc('subac');
$subacs = array('shop_memberlist','shop_memberedit');
$subac = in_array($subac,$subacs) ? $subac : $subacs[0];

$shop_memberid = getgpc('shop_memberid');
$shop_member_info = $shop_memberid ? DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_shop_member')." WHERE shop_memberid=".$shop_memberid) : array();

if($subac == 'shop_memberlist') {
	if(!submitcheck('submit')) {
		showtips(lang('plugin/yiqixueba','shop_member_list_tips'));
		showformheader($this_page.'&subac=shop_memberlist');
		showtableheader(lang('plugin/yiqixueba','shop_member_list'));
		showsubtitle(array('', lang('plugin/yiqixueba','shop_membername'),lang('plugin/yiqixueba','shopnum'), lang('plugin/yiqixueba','shop_memberquanxian'), lang('plugin/yiqixueba','status'), ''));
		//$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_shop_member')." order by shop_memberid asc");
		//while($row = DB::fetch($query)) {
			showtablerow('', array('class="td25"','class="td23"', 'class="td23"', 'class="td23"','class="td25"',''), array(
				"<input class=\"checkbox\" type=\"checkbox\" name=\"delete[]\" value=\"$row[shop_memberid]\">",
			$row['shop_membername'],
			$row['shop_membername'],
			$row['shop_membername'],
			"<input class=\"checkbox\" type=\"checkbox\" name=\"statusnew[".$row['shop_memberid']."]\" value=\"1\" ".($row['status'] > 0 ? 'checked' : '').">",
				"<a href=\"".ADMINSCRIPT."?action=".$this_page."&subac=shop_memberedit&shop_memberid=$row[shop_memberid]\" class=\"act\">".lang('plugin/yiqixueba','edit')."</a>",
			));
		//}
		echo '<tr><td></td><td colspan="6"><div><a href="'.ADMINSCRIPT.'?action='.$this_page.'&subac=shop_memberedit" class="addtr">'.lang('plugin/yiqixueba','add_shop_member').'</a></div></td></tr>';
		showsubmit('submit','submit','del');
		showtablefooter();
		showformfooter();
	}else{
	}
}elseif($subac == 'shop_memberedit') {
	if(!submitcheck('submit')) {
		showtips(lang('plugin/yiqixueba','shop_member_edit_tips'));
		showformheader($this_page.'&subac=shop_memberedit','enctype');
		showtableheader(lang('plugin/yiqixueba','shop_member_edit'));
		$shop_memberid ? showhiddenfields(array('shop_memberid'=>$shop_memberid)) : '';
		showsetting(lang('plugin/yiqixueba','shop_membername'),'shop_member_info[shop_membername]',$shop_member_info['shop_membername'],'text','',0,lang('plugin/yiqixueba','shop_membername_comment'),'','',true);
		showsubmit('submit');
		showtablefooter();
		showformfooter();
	}else{
		if(!htmlspecialchars(trim($_GET['shop_member_info']['shop_membername']))) {
			cpmsg(lang('plugin/yiqixueba','shop_membername_nonull'));
		}
		$datas = $_GET['shop_member_info'];
		foreach ( $datas as $k=>$v) {
			$data[$k] = htmlspecialchars(trim($v));
			if(!DB::result_first("describe ".DB::table('yiqixueba_shop_member')." ".$k)) {
				$sql = "alter table ".DB::table('yiqixueba_shop_member')." add `".$k."` varchar(255) not Null;";
				runquery($sql);
			}
		}
		if($shop_memberid) {
			DB::update('yiqixueba_shop_member',$data,array('shop_memberid'=>$shop_memberid));
		}else{
			DB::insert('yiqixueba_shop_member',$data);
		}
		cpmsg(lang('plugin/yiqixueba', 'shop_member_edit_succeed'), 'action='.$this_page.'&subac=shop_memberlist', 'succeed');
	}
}

?>