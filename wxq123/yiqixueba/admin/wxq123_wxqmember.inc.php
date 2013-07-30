<?php

/**
*	一起学吧平台程序
*	文件名：wxq123_wxqmember.inc.php  创建时间：2013-6-17 11:49  杨文
*
*/

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
$this_page = 'plugins&identifier=yiqixueba&pmod=admin&submod=wxq123_wxqmember';

$subac = getgpc('subac');
$subacs = array('wxq123_wxqmemberlist','wxq123_wxqmemberedit');
$subac = in_array($subac,$subacs) ? $subac : $subacs[0];

$wxq123_wxqmemberid = getgpc('wxq123_wxqmemberid');
$wxq123_wxqmember_info = $wxq123_wxqmemberid ? DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_wxq123_wxqmember')." WHERE wxq123_wxqmemberid=".$wxq123_wxqmemberid) : array();

if($subac == 'wxq123_wxqmemberlist') {
	if(!submitcheck('submit')) {
		showtips(lang('plugin/yiqixueba','wxq123_wxqmember_list_tips'));
		showformheader($this_page.'&subac=wxq123_wxqmemberlist');
		showtableheader(lang('plugin/yiqixueba','wxq123_wxqmember_list'));
		showsubtitle(array('', lang('plugin/yiqixueba','wxq123_wxqmembername'),lang('plugin/yiqixueba','shopnum'), lang('plugin/yiqixueba','wxq123_wxqmemberquanxian'), lang('plugin/yiqixueba','status'), ''));
		//$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_wxq123_wxqmember')." order by wxq123_wxqmemberid asc");
		//while($row = DB::fetch($query)) {
			showtablerow('', array('class="td25"','class="td23"', 'class="td23"', 'class="td23"','class="td25"',''), array(
				"<input class=\"checkbox\" type=\"checkbox\" name=\"delete[]\" value=\"$row[wxq123_wxqmemberid]\">",
			$row['wxq123_wxqmembername'],
			$row['wxq123_wxqmembername'],
			$row['wxq123_wxqmembername'],
			"<input class=\"checkbox\" type=\"checkbox\" name=\"statusnew[".$row['wxq123_wxqmemberid']."]\" value=\"1\" ".($row['status'] > 0 ? 'checked' : '').">",
				"<a href=\"".ADMINSCRIPT."?action=".$this_page."&subac=wxq123_wxqmemberedit&wxq123_wxqmemberid=$row[wxq123_wxqmemberid]\" class=\"act\">".lang('plugin/yiqixueba','edit')."</a>",
			));
		//}
		echo '<tr><td></td><td colspan="6"><div><a href="'.ADMINSCRIPT.'?action='.$this_page.'&subac=wxq123_wxqmemberedit" class="addtr">'.lang('plugin/yiqixueba','add_wxq123_wxqmember').'</a></div></td></tr>';
		showsubmit('submit','submit','del');
		showtablefooter();
		showformfooter();
	}else{
	}
}elseif($subac == 'wxq123_wxqmemberedit') {
	if(!submitcheck('submit')) {
		showtips(lang('plugin/yiqixueba','wxq123_wxqmember_edit_tips'));
		showformheader($this_page.'&subac=wxq123_wxqmemberedit','enctype');
		showtableheader(lang('plugin/yiqixueba','wxq123_wxqmember_edit'));
		$wxq123_wxqmemberid ? showhiddenfields(array('wxq123_wxqmemberid'=>$wxq123_wxqmemberid)) : '';
		showsetting(lang('plugin/yiqixueba','wxq123_wxqmembername'),'wxq123_wxqmember_info[wxq123_wxqmembername]',$wxq123_wxqmember_info['wxq123_wxqmembername'],'text','',0,lang('plugin/yiqixueba','wxq123_wxqmembername_comment'),'','',true);
		showsubmit('submit');
		showtablefooter();
		showformfooter();
	}else{
		if(!htmlspecialchars(trim($_GET['wxq123_wxqmember_info']['wxq123_wxqmembername']))) {
			cpmsg(lang('plugin/yiqixueba','wxq123_wxqmembername_nonull'));
		}
		$datas = $_GET['wxq123_wxqmember_info'];
		foreach ( $datas as $k=>$v) {
			$data[$k] = htmlspecialchars(trim($v));
			if(!DB::result_first("describe ".DB::table('yiqixueba_wxq123_wxqmember')." ".$k)) {
				$sql = "alter table ".DB::table('yiqixueba_wxq123_wxqmember')." add `".$k."` varchar(255) not Null;";
				runquery($sql);
			}
		}
		if($wxq123_wxqmemberid) {
			DB::update('yiqixueba_wxq123_wxqmember',$data,array('wxq123_wxqmemberid'=>$wxq123_wxqmemberid));
		}else{
			DB::insert('yiqixueba_wxq123_wxqmember',$data);
		}
		cpmsg(lang('plugin/yiqixueba', 'wxq123_wxqmember_edit_succeed'), 'action='.$this_page.'&subac=wxq123_wxqmemberlist', 'succeed');
	}
}

?>