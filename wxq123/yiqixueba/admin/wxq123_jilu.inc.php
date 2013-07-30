<?php

/**
*	一起学吧平台程序
*	文件名：wxq123_jilu.inc.php  创建时间：2013-7-1 09:18  杨文
*
*/

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
$this_page = 'plugins&identifier=yiqixueba&pmod=admin&submod=wxq123_jilu';

$subac = getgpc('subac');
$subacs = array('jilulist','jiluedit');
$subac = in_array($subac,$subacs) ? $subac : $subacs[0];

$jiluid = getgpc('jiluid');
$jilu_info = $jiluid ? DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_wxq123_jilu')." WHERE jiluid=".$jiluid) : array();



if($subac == 'jilulist') {
	if(!submitcheck('submit')) {
		showtips(lang('plugin/yiqixueba','jilu_list_tips'));
		showformheader($this_page.'&subac=jilulist');
		showtableheader(lang('plugin/yiqixueba','jilu_list'));
		showsubtitle(array('', lang('plugin/yiqixueba','time'),lang('plugin/yiqixueba','type'), lang('plugin/yiqixueba','fromusername'), lang('plugin/yiqixueba','tousername'), ''));
		$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_wxq123_jilu')." order by jiluid asc");
		while($row = DB::fetch($query)) {
			showtablerow('', array('class="td25"','class="td23"', 'class="td23"', 'class="td23"','class="td25"',''), array(
				"<input class=\"checkbox\" type=\"checkbox\" name=\"delete[]\" value=\"$row[jiluid]\">",
			$row['jiluname'],
			$row['jiluname'],
			$row['jiluname'],
			"<input class=\"checkbox\" type=\"checkbox\" name=\"statusnew[".$row['jiluid']."]\" value=\"1\" ".($row['status'] > 0 ? 'checked' : '').">",
				"<a href=\"".ADMINSCRIPT."?action=".$this_page."&subac=jiluedit&jiluid=$row[jiluid]\" class=\"act\">".lang('plugin/yiqixueba','edit')."</a>",
			));
		}
		echo '<tr><td></td><td colspan="6"><div><a href="'.ADMINSCRIPT.'?action='.$this_page.'&subac=jiluedit" class="addtr">'.lang('plugin/yiqixueba','add_jilu').'</a></div></td></tr>';
		showsubmit('submit','submit','del');
		showtablefooter();
		showformfooter();
	}else{
	}
}elseif($subac == 'jiluedit') {
	if(!submitcheck('submit')) {
		showtips(lang('plugin/yiqixueba','jilu_edit_tips'));
		showformheader($this_page.'&subac=jiluedit','enctype');
		showtableheader(lang('plugin/yiqixueba','jilu_edit'));
		$jiluid ? showhiddenfields(array('jiluid'=>$jiluid)) : '';
		showsetting(lang('plugin/yiqixueba','jiluname'),'jilu_info[jiluname]',$jilu_info['jiluname'],'text','',0,lang('plugin/yiqixueba','jiluname_comment'),'','',true);
		showsubmit('submit');
		showtablefooter();
		showformfooter();
	}else{
		if(!htmlspecialchars(trim($_GET['jilu_info']['jiluname']))) {
			cpmsg(lang('plugin/yiqixueba','jiluname_nonull'));
		}
		$datas = $_GET['jilu_info'];
		foreach ( $datas as $k=>$v) {
			$data[$k] = htmlspecialchars(trim($v));
			if(!DB::result_first("describe ".DB::table('yiqixueba_wxq123_jilu')." ".$k)) {
				$sql = "alter table ".DB::table('yiqixueba_wxq123_jilu')." add `".$k."` varchar(255) not Null;";
				runquery($sql);
			}
		}
		if($jiluid) {
			DB::update('yiqixueba_wxq123_jilu',$data,array('jiluid'=>$jiluid));
		}else{
			DB::insert('yiqixueba_wxq123_jilu',$data);
		}
		cpmsg(lang('plugin/yiqixueba', 'jilu_edit_succeed'), 'action='.$this_page.'&subac=jilulist', 'succeed');
	}
}

?>