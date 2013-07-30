<?php

/**
*	一起学吧平台程序
*	文件名：wxq_wxqmember.inc.php  创建时间：2013-6-4 09:37  杨文
*
*/

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
$this_page = 'plugins&identifier=yiqixueba&pmod=admin&submod=wxqmember';

$subac = getgpc('subac');
$subacs = array('wxqmemberlist','wxqmemberedit');
$subac = in_array($subac,$subacs) ? $subac : $subacs[0];

$wxqmemberid = getgpc('wxqmemberid');
$wxqmember_info = $wxqmemberid ? DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_wxqmember')." WHERE wxqmemberid=".$wxqmemberid) : array();

if($subac == 'wxqmemberlist') {
	if(!submitcheck('submit')) {
		showtips(lang('plugin/yiqixueba','wxqmember_list_tips'));
		showformheader($this_page.'&subac=wxqmemberlist');
		showtableheader(lang('plugin/yiqixueba','wxqmember_list'));
		showsubtitle(array('', lang('plugin/yiqixueba','wxqmembername'),lang('plugin/yiqixueba','shopnum'), lang('plugin/yiqixueba','wxqmemberquanxian'), lang('plugin/yiqixueba','status'), ''));
		//$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_wxqmember')." order by wxqmemberid asc");
		//while($row = DB::fetch($query)) {
			showtablerow('', array('class="td25"','class="td23"', 'class="td23"', 'class="td23"','class="td25"',''), array(
				"<input class=\"checkbox\" type=\"checkbox\" name=\"delete[]\" value=\"$row[wxqmemberid]\">",
			$row['wxqmembername'],
			$row['wxqmembername'],
			$row['wxqmembername'],
			"<input class=\"checkbox\" type=\"checkbox\" name=\"statusnew[".$row['wxqmemberid']."]\" value=\"1\" ".($row['status'] > 0 ? 'checked' : '').">",
				"<a href=\"".ADMINSCRIPT."?action=".$this_page."&subac=wxqmemberedit&wxqmemberid=$row[wxqmemberid]\" class=\"act\">".lang('plugin/yiqixueba','edit')."</a>",
			));
		//}
		echo '<tr><td></td><td colspan="6"><div><a href="'.ADMINSCRIPT.'?action='.$this_page.'&subac=wxqmemberedit" class="addtr">'.lang('plugin/yiqixueba','add_wxqmember').'</a></div></td></tr>';
		showsubmit('submit','submit','del');
		showtablefooter();
		showformfooter();
	}else{
	}
}elseif($subac == 'wxqmemberedit') {
	if(!submitcheck('submit')) {
		showtips(lang('plugin/yiqixueba','wxqmember_edit_tips'));
		showformheader($this_page.'&subac=wxqmemberedit','enctype');
		showtableheader(lang('plugin/yiqixueba','wxqmember_edit'));
		$wxqmemberid ? showhiddenfields(array('wxqmemberid'=>$wxqmemberid)) : '';
		showsetting(lang('plugin/yiqixueba','wxqmembername'),'wxqmember_info[wxqmembername]',$wxqmember_info['wxqmembername'],'text','',0,lang('plugin/yiqixueba','wxqmembername_comment'),'','',true);
		showsubmit('submit');
		showtablefooter();
		showformfooter();
	}else{
		if(!htmlspecialchars(trim($_GET['wxqmember_info']['wxqmembername']))) {
			cpmsg(lang('plugin/yiqixueba','wxqmembername_nonull'));
		}
		$datas = $_GET['wxqmember_info'];
		foreach ( $datas as $k=>$v) {
			$data[$k] = htmlspecialchars(trim($v));
			if(!DB::result_first("describe ".DB::table('yiqixueba_wxqmember')." ".$k)) {
				$sql = "alter table ".DB::table('yiqixueba_wxqmember')." add `".$k."` varchar(255) not Null;";
				runquery($sql);
			}
		}
		if($wxqmemberid) {
			DB::update('yiqixueba_wxqmember',$data,array('wxqmemberid'=>$wxqmemberid));
		}else{
			DB::insert('yiqixueba_wxqmember',$data);
		}
		cpmsg(lang('plugin/yiqixueba', 'wxqmember_edit_succeed'), 'action='.$this_page.'&subac=wxqmemberlist', 'succeed');
	}
}

?>