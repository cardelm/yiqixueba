<?php

/**
*	一起学吧平台程序
*	文件名：wxq_shopgroup.inc.php  创建时间：2013-6-15 02:53  杨文
*
*/

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
$this_page = 'plugins&identifier=yiqixueba&pmod=admin&submod=wxq_shopgroup';

$subac = getgpc('subac');
$subacs = array('wxq_shopgrouplist','wxq_shopgroupedit');
$subac = in_array($subac,$subacs) ? $subac : $subacs[0];

$wxq_shopgroupid = getgpc('wxq_shopgroupid');
$wxq_shopgroup_info = $wxq_shopgroupid ? DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_wxq_shopgroup')." WHERE wxq_shopgroupid=".$wxq_shopgroupid) : array();

if($subac == 'wxq_shopgrouplist') {
	if(!submitcheck('submit')) {
		showtips(lang('plugin/yiqixueba','wxq_shopgroup_list_tips'));
		showformheader($this_page.'&subac=wxq_shopgrouplist');
		showtableheader(lang('plugin/yiqixueba','wxq_shopgroup_list'));
		showsubtitle(array('', lang('plugin/yiqixueba','wxq_shopgroupname'),lang('plugin/yiqixueba','shopnum'), lang('plugin/yiqixueba','wxq_shopgroupquanxian'), lang('plugin/yiqixueba','status'), ''));
		//$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_wxq_shopgroup')." order by wxq_shopgroupid asc");
		//while($row = DB::fetch($query)) {
			showtablerow('', array('class="td25"','class="td23"', 'class="td23"', 'class="td23"','class="td25"',''), array(
				"<input class=\"checkbox\" type=\"checkbox\" name=\"delete[]\" value=\"$row[wxq_shopgroupid]\">",
			$row['wxq_shopgroupname'],
			$row['wxq_shopgroupname'],
			$row['wxq_shopgroupname'],
			"<input class=\"checkbox\" type=\"checkbox\" name=\"statusnew[".$row['wxq_shopgroupid']."]\" value=\"1\" ".($row['status'] > 0 ? 'checked' : '').">",
				"<a href=\"".ADMINSCRIPT."?action=".$this_page."&subac=wxq_shopgroupedit&wxq_shopgroupid=$row[wxq_shopgroupid]\" class=\"act\">".lang('plugin/yiqixueba','edit')."</a>",
			));
		//}
		echo '<tr><td></td><td colspan="6"><div><a href="'.ADMINSCRIPT.'?action='.$this_page.'&subac=wxq_shopgroupedit" class="addtr">'.lang('plugin/yiqixueba','add_wxq_shopgroup').'</a></div></td></tr>';
		showsubmit('submit','submit','del');
		showtablefooter();
		showformfooter();
	}else{
	}
}elseif($subac == 'wxq_shopgroupedit') {
	if(!submitcheck('submit')) {
		showtips(lang('plugin/yiqixueba','wxq_shopgroup_edit_tips'));
		showformheader($this_page.'&subac=wxq_shopgroupedit','enctype');
		showtableheader(lang('plugin/yiqixueba','wxq_shopgroup_edit'));
		$wxq_shopgroupid ? showhiddenfields(array('wxq_shopgroupid'=>$wxq_shopgroupid)) : '';
		showsetting(lang('plugin/yiqixueba','wxq_shopgroupname'),'wxq_shopgroup_info[wxq_shopgroupname]',$wxq_shopgroup_info['wxq_shopgroupname'],'text','',0,lang('plugin/yiqixueba','wxq_shopgroupname_comment'),'','',true);
		showsubmit('submit');
		showtablefooter();
		showformfooter();
	}else{
		if(!htmlspecialchars(trim($_GET['wxq_shopgroup_info']['wxq_shopgroupname']))) {
			cpmsg(lang('plugin/yiqixueba','wxq_shopgroupname_nonull'));
		}
		$datas = $_GET['wxq_shopgroup_info'];
		foreach ( $datas as $k=>$v) {
			$data[$k] = htmlspecialchars(trim($v));
			if(!DB::result_first("describe ".DB::table('yiqixueba_wxq_shopgroup')." ".$k)) {
				$sql = "alter table ".DB::table('yiqixueba_wxq_shopgroup')." add `".$k."` varchar(255) not Null;";
				runquery($sql);
			}
		}
		if($wxq_shopgroupid) {
			DB::update('yiqixueba_wxq_shopgroup',$data,array('wxq_shopgroupid'=>$wxq_shopgroupid));
		}else{
			DB::insert('yiqixueba_wxq_shopgroup',$data);
		}
		cpmsg(lang('plugin/yiqixueba', 'wxq_shopgroup_edit_succeed'), 'action='.$this_page.'&subac=wxq_shopgrouplist', 'succeed');
	}
}

?>