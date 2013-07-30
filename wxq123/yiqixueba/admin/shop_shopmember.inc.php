<?php

/**
*	一起学吧平台程序
*	文件名：shop_shopmember.inc.php  创建时间：2013-6-8 09:47  杨文
*
*/

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
$this_page = 'plugins&identifier=yiqixueba&pmod=admin&submod=shopmember';

$subac = getgpc('subac');
$subacs = array('shopmemberlist','shopmemberedit');
$subac = in_array($subac,$subacs) ? $subac : $subacs[0];

$shopmemberid = getgpc('shopmemberid');
$shopmember_info = $shopmemberid ? DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_shop_member')." WHERE shopmemberid=".$shopmemberid) : array();

if($subac == 'shopmemberlist') {
	if(!submitcheck('submit')) {
		showtips(lang('plugin/yiqixueba','shop_member_list_tips'));
		showformheader($this_page.'&subac=shopmemberlist');
		showtableheader(lang('plugin/yiqixueba','shop_member_list'));
		showsubtitle(array('', lang('plugin/yiqixueba','shopmembername'),lang('plugin/yiqixueba','shopnum'), lang('plugin/yiqixueba','shopmemberquanxian'), lang('plugin/yiqixueba','status'), ''));
		//$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_shopmember')." order by shopmemberid asc");
		//while($row = DB::fetch($query)) {
			showtablerow('', array('class="td25"','class="td23"', 'class="td23"', 'class="td23"','class="td25"',''), array(
				"<input class=\"checkbox\" type=\"checkbox\" name=\"delete[]\" value=\"$row[shopmemberid]\">",
			$row['shopmembername'],
			$row['shopmembername'],
			$row['shopmembername'],
			"<input class=\"checkbox\" type=\"checkbox\" name=\"statusnew[".$row['shopmemberid']."]\" value=\"1\" ".($row['status'] > 0 ? 'checked' : '').">",
				"<a href=\"".ADMINSCRIPT."?action=".$this_page."&subac=shopmemberedit&shopmemberid=$row[shopmemberid]\" class=\"act\">".lang('plugin/yiqixueba','edit')."</a>",
			));
		//}
		echo '<tr><td></td><td colspan="6"><div><a href="'.ADMINSCRIPT.'?action='.$this_page.'&subac=shopmemberedit" class="addtr">'.lang('plugin/yiqixueba','add_shopmember').'</a></div></td></tr>';
		showsubmit('submit','submit','del');
		showtablefooter();
		showformfooter();
	}else{
	}
}elseif($subac == 'shopmemberedit') {
	if(!submitcheck('submit')) {
		showtips(lang('plugin/yiqixueba','shop_member_edit_tips'));
		showformheader($this_page.'&subac=shopmemberedit','enctype');
		showtableheader(lang('plugin/yiqixueba','shop_member_edit'));
		$shopmemberid ? showhiddenfields(array('shopmemberid'=>$shopmemberid)) : '';
		showsetting(lang('plugin/yiqixueba','shopmembername'),'shopmember_info[shopmembername]',$shopmember_info['shopmembername'],'text','',0,lang('plugin/yiqixueba','shop_membername_comment'),'','',true);
		showsubmit('submit');
		showtablefooter();
		showformfooter();
	}else{
		if(!htmlspecialchars(trim($_GET['shopmember_info']['shopmembername']))) {
			cpmsg(lang('plugin/yiqixueba','shop_membername_nonull'));
		}
		$datas = $_GET['shopmember_info'];
		foreach ( $datas as $k=>$v) {
			$data[$k] = htmlspecialchars(trim($v));
			if(!DB::result_first("describe ".DB::table('yiqixueba_shop_member')." ".$k)) {
				$sql = "alter table ".DB::table('yiqixueba_shop_member')." add `".$k."` varchar(255) not Null;";
				runquery($sql);
			}
		}
		if($shopmemberid) {
			DB::update('yiqixueba_shop_member',$data,array('shopmemberid'=>$shopmemberid));
		}else{
			DB::insert('yiqixueba_shop_member',$data);
		}
		cpmsg(lang('plugin/yiqixueba', 'shop_member_edit_succeed'), 'action='.$this_page.'&subac=shopmemberlist', 'succeed');
	}
}

?>