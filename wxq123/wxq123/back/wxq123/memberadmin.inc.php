<?php

/**
 *      [17xue8.cn] (C)2013-2099 杨文.
 *      这不是免费的。
 *
 */

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
$subop = getgpc('subop');
$subops = array('memberlist','memberedit');
$subop = in_array($subop,$subops) ? $subop : $subops[0];
$page = max(1, $_G['page']);
$membergroup = array('normal','web','shop','admin');

if($subop == 'memberlist'){
	$str = 'http://www.wxq123.com/plugin.php?id=wxq123:weixin';
	var_dump($_SERVER['QUERY_STRING']);
	if(!submitcheck('submit')) {
		showtips(lang('plugin/wxq123','member_list_tips'));
		showformheader("plugins&identifier=wxq123&pmod=memberadmin&subop=memberlist");
		showtableheader(lang('plugin/wxq123','member_list'));
		showsubtitle(array('','username','usergroup',lang('plugin/wxq123','goodsmember'), lang('plugin/wxq123','validity'),lang('plugin/wxq123','mokuais'),lang('plugin/wxq123','stauts'),'' ));
		$perpage = 20;
		$start = ($page - 1) * $perpage;
		$goodscount = DB::result_first("SELECT count(*) FROM ".DB::table('common_member'));
		$multi = multi($goodscount, $perpage, $page, ADMINSCRIPT."?action=plugins&identifier=wxq123&pmod=memberlist");
		$query = DB::query("SELECT * FROM ".DB::table('common_member').$where." order by uid desc limit ".$start.",".$perpage." ");
		while($row = DB::fetch($query)) {
			$member_info = DB::fetch_first("SELECT * FROM ".DB::table('wxq123_member')." WHERE uid=".$row['uid']);
			showtablerow('', array('class="td25"', 'class="td23"', '', ''), array(
				"<input class=\"checkbox\" type=\"checkbox\" name=\"delete[]\" value=\"$row[uid]\">",
				$row['username'],
				lang('plugin/wxq123','wxq_'.$membergroup[intval($member_info['wxqgroup'])]),
				$row['shibiecode'],
				'',
				$row['groupexpiry'] ? dgmdate($row['groupexpiry'],'d') : lang('plugin/wxq123','qianfei_mian'),
				$goodsmokuais,
				$row['stauts']==0 ? '<img src="static/image/common/access_disallow.gif" width="16" height="16" />':($row['stauts']==1 ? '<img src="static/image/common/access_allow.gif" width="16" height="16" />':'<img src="static/image/common/fav.gif" width="16" height="16" />'),
				"<a href=\"".ADMINSCRIPT."?action=plugins&identifier=wxq123&pmod=memberadmin&subop=memberedit&uid=$row[uid]\" class=\"act\">".$lang['edit']."</a>",
			));
		}

		showsubmit('submit','submit','del','',$multi);
		showtablefooter();
		showformfooter();
	}else{
	}
}elseif($subop == 'memberedit'){
	$uid = intval(getgpc('uid'));
	$member_info = DB::fetch_first("SELECT * FROM ".DB::table('wxq123_member')." WHERE uid=".$uid);
	if(!submitcheck('submit')) {
		$wxqgroup_select = '<select name="wxqgroup">';
		foreach ($membergroup as $k=>$v){
			$wxqgroup_select .= '<option value="'.$k.' '.($member_info['wxqgroup'] == $k ? ' selected' : '').'">'.lang('plugin/wxq123','wxq_'.$v).'</option>';
		}
		$wxqgroup_select .= '</select>';
		showtips(lang('plugin/wxq123','member_edit_tips'));
		showformheader("plugins&identifier=wxq123&pmod=memberadmin&subop=memberedit",'enctype');
		showtableheader(lang('plugin/wxq123','member_edit'));
		showhiddenfields(array('memberid'=>$memberid));
		showsetting('usergroup','','',$wxqgroup_select,'',0,lang('plugin/wxq123','usergroup_comment'),'','',true);
		showsubmit('submit');
		showtablefooter();
		showformfooter();
	}else{
	}
}