<?php

/**
*	一起学吧平台程序
*	文件名：brand_member.inc.php  创建时间：2013-6-8 13:05  杨文
*
*/

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
$this_page = 'plugins&identifier=yiqixueba&pmod=admin&submod=brand_member';

$subac = getgpc('subac');
$subacs = array('brand_memberlist','brand_memberedit');
$subac = in_array($subac,$subacs) ? $subac : $subacs[0];

$brand_memberid = getgpc('brand_memberid');
$brand_member_info = $brand_memberid ? DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_brand_member')." WHERE brand_memberid=".$brand_memberid) : array();

if($subac == 'brand_memberlist') {
	if(!submitcheck('submit')) {
		showtips(lang('plugin/yiqixueba','brand_member_list_tips'));
		showformheader($this_page.'&subac=brand_memberlist');
		showtableheader(lang('plugin/yiqixueba','brand_member_list'));
		showsubtitle(array('', lang('plugin/yiqixueba','brand_membername'),lang('plugin/yiqixueba','shopnum'), lang('plugin/yiqixueba','brand_memberquanxian'), lang('plugin/yiqixueba','status'), ''));
		//$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_brand_member')." order by brand_memberid asc");
		//while($row = DB::fetch($query)) {
			showtablerow('', array('class="td25"','class="td23"', 'class="td23"', 'class="td23"','class="td25"',''), array(
				"<input class=\"checkbox\" type=\"checkbox\" name=\"delete[]\" value=\"$row[brand_memberid]\">",
			$row['brand_membername'],
			$row['brand_membername'],
			$row['brand_membername'],
			"<input class=\"checkbox\" type=\"checkbox\" name=\"statusnew[".$row['brand_memberid']."]\" value=\"1\" ".($row['status'] > 0 ? 'checked' : '').">",
				"<a href=\"".ADMINSCRIPT."?action=".$this_page."&subac=brand_memberedit&brand_memberid=$row[brand_memberid]\" class=\"act\">".lang('plugin/yiqixueba','edit')."</a>",
			));
		//}
		echo '<tr><td></td><td colspan="6"><div><a href="'.ADMINSCRIPT.'?action='.$this_page.'&subac=brand_memberedit" class="addtr">'.lang('plugin/yiqixueba','add_brand_member').'</a></div></td></tr>';
		showsubmit('submit','submit','del');
		showtablefooter();
		showformfooter();
	}else{
	}
}elseif($subac == 'brand_memberedit') {
	if(!submitcheck('submit')) {
		showtips(lang('plugin/yiqixueba','brand_member_edit_tips'));
		showformheader($this_page.'&subac=brand_memberedit','enctype');
		showtableheader(lang('plugin/yiqixueba','brand_member_edit'));
		$brand_memberid ? showhiddenfields(array('brand_memberid'=>$brand_memberid)) : '';
		showsetting(lang('plugin/yiqixueba','brand_membername'),'brand_member_info[brand_membername]',$brand_member_info['brand_membername'],'text','',0,lang('plugin/yiqixueba','brand_membername_comment'),'','',true);
		showsubmit('submit');
		showtablefooter();
		showformfooter();
	}else{
		if(!htmlspecialchars(trim($_GET['brand_member_info']['brand_membername']))) {
			cpmsg(lang('plugin/yiqixueba','brand_membername_nonull'));
		}
		$datas = $_GET['brand_member_info'];
		foreach ( $datas as $k=>$v) {
			$data[$k] = htmlspecialchars(trim($v));
			if(!DB::result_first("describe ".DB::table('yiqixueba_brand_member')." ".$k)) {
				$sql = "alter table ".DB::table('yiqixueba_brand_member')." add `".$k."` varchar(255) not Null;";
				runquery($sql);
			}
		}
		if($brand_memberid) {
			DB::update('yiqixueba_brand_member',$data,array('brand_memberid'=>$brand_memberid));
		}else{
			DB::insert('yiqixueba_brand_member',$data);
		}
		cpmsg(lang('plugin/yiqixueba', 'brand_member_edit_succeed'), 'action='.$this_page.'&subac=brand_memberlist', 'succeed');
	}
}

?>