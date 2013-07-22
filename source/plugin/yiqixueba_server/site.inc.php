<?php

/**
*	一起学吧服务端-站长管理程序
*	文件名：site.inc.php 创建时间：2013-7-23 01:49  杨文
*
*/

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

require_once DISCUZ_ROOT.'source/plugin/yiqixueba_server/function.func.php';

$this_page = substr($_SERVER['QUERY_STRING'],7,strlen($_SERVER['QUERY_STRING'])-7);
stripos($this_page,'subac=') ? $this_page = substr($this_page,0,stripos($this_page,'subac=')-1) : $this_page;

$subac = getgpc('subac');
$subacs = array('sitelist','siteedit');
$subac = in_array($subac,$subacs) ? $subac : $subacs[0];

$siteid = getgpc('siteid');
$site_info = $siteid ? DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_server_site')." WHERE siteid=".$siteid) : array();

if($subac == 'sitelist') {
	if(!submitcheck('submit')) {
		showtips(lang('plugin/yiqixueba_server','site_list_tips'));
		showformheader($this_page.'&subac=sitelist');
		showtableheader(lang('plugin/yiqixueba_server','site_list'));
		$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_server_site')." order by displayorder asc");
		while($row = DB::fetch($query)) {
			showtablerow('', array('class="td25"', 'class="td23"', 'class="td28"'), array(
				"<input class=\"checkbox\" type=\"checkbox\" name=\"delete[]\" value=\"$row[siteid]\">",
				$row['sitename'],
				"<input class=\"checkbox\" type=\"checkbox\" name=\"statusnew[".$row['siteid']."]\" value=\"1\" ".($row['status'] > 0 ? 'checked' : '').">",
				"<a href=\"".ADMINSCRIPT."?action=".$this_page."&subac=siteedit&siteid=$row[siteid]\" class=\"act\">".lang('plugin/yiqixueba_server','edit')."</a>",
			));
		}
	echo '<tr><td></td><td colspan="6"><div><a href="'.ADMINSCRIPT.'?action='.$this_page.'&subac=siteedit" class="addtr">'.lang('plugin/yiqixueba_server','add_site').'</a></div></td></tr>';
	showsubmit('submit','submit','del');
	showtablefooter();
	showformfooter();
	}else{
	}
}elseif($subac == 'siteedit') {
	if(!submitcheck('submit')) {
		showtips(lang('plugin/yiqixueba_server','site_edit_tips'));
		showformheader($this_page.'&subac=siteedit','enctype');
		showtableheader(lang('plugin/yiqixueba_server','site_edit'));
		$siteid ? showhiddenfields(array('siteid'=>$siteid)) : '';
		showsetting(lang('plugin/yiqixueba_server','sitename'),'site_info[sitename]',$site_info['sitename'],'text','',0,lang('plugin/yiqixueba_server','sitename_comment'),'','',true);
		showsubmit('submit');
		showtablefooter();
		showformfooter();
	}else{
		if(!htmlspecialchars(trim($_GET['site_info']['sitename']))) {
			cpmsg(lang('plugin/yiqixueba_server','sitename_nonull'));
		}
		$datas = $_GET['site_info'];
		foreach ( $datas as $k=>$v) {
			$data[$k] = htmlspecialchars(trim($v));
			if(!DB::result_first("describe ".DB::table('yiqixueba_server_site')." ".$k)) {
				$sql = "alter table ".DB::table('yiqixueba_server_site')." add `".$k."` varchar(255) not Null;";
				runquery($sql);
			}
		}
		if($siteid) {
			DB::update('yiqixueba_server_site',$data,array('siteid'=>$siteid));
		}else{
			DB::insert('yiqixueba_server_site',$data);
		}
		cpmsg(lang('plugin/yiqixueba_server', 'site_edit_succeed'), 'action='.$this_page.'&subac=sitelist', 'succeed');
	}
	
}
?>