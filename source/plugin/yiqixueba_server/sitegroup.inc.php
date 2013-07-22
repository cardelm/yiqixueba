<?php

/**
*	卡益联盟服务端程序
*	文件名：system_sitegroup.inc.php  创建时间：2013-7-11 02:45  杨文
*
*/

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
require_once DISCUZ_ROOT.'source/plugin/yiqixueba_server/function.func.php';

$this_page = substr($_SERVER['QUERY_STRING'],7,strlen($_SERVER['QUERY_STRING'])-7);
stripos($this_page,'subac=') ? $this_page = substr($this_page,0,stripos($this_page,'subac=')-1) : $this_page;

$subac = getgpc('subac');

$subacs = array('sitegrouplist','sitegroupedit');
$subac = in_array($subac,$subacs) ? $subac : $subacs[0];

$sitegroupid = getgpc('sitegroupid');
$sitegroup_info = $sitegroupid ? DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_server_sitegroup')." WHERE sitegroupid=".$sitegroupid) : array();

if($subac == 'sitegrouplist') {
	if(!submitcheck('submit')) {
		showtips(lang('plugin/yiqixueba_server','sitegroup_list_tips'));
		showformheader($this_page.'&subac=sitegrouplist');
		showtableheader(lang('plugin/yiqixueba_server','sitegroup_list'));
		showsubtitle(array('', lang('plugin/yiqixueba_server','sitegroupname'),lang('plugin/yiqixueba_server','shopnum'), lang('plugin/yiqixueba_server','sitegroupquanxian'), lang('plugin/yiqixueba_server','status'), ''));
		$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_server_sitegroup')." order by sitegroupid asc");
		while($row = DB::fetch($query)) {
			showtablerow('', array('class="td25"','class="td23"', 'class="td23"', 'class="td23"','class="td25"',''), array(
				"<input class=\"checkbox\" type=\"checkbox\" name=\"delete[]\" value=\"$row[sitegroupid]\">",
				$row['sitegroupname'],
				$row['sitegroupname'],
				$row['sitegroupname'],
				"<input class=\"checkbox\" type=\"checkbox\" name=\"statusnew[".$row['sitegroupid']."]\" value=\"1\" ".($row['status'] > 0 ? 'checked' : '').">",
				"<a href=\"".ADMINSCRIPT."?action=".$this_page."&subac=sitegroupedit&sitegroupid=$row[sitegroupid]\" class=\"act\">".lang('plugin/yiqixueba_server','edit')."</a>",
			));
		}
		echo '<tr><td></td><td colspan="6"><div><a href="'.ADMINSCRIPT.'?action='.$this_page.'&subac=sitegroupedit" class="addtr">'.lang('plugin/yiqixueba_server','add_sitegroup').'</a></div></td></tr>';
		showsubmit('submit','submit','del');
		showtablefooter();
		showformfooter();
	}else{
		foreach(getgpc('statusnew') as $k=>$v ){
			DB::update('yiqixueba_server_sitegroup', array('status'=>1),array('sitegroupid'=>$k));
		}
		cpmsg(lang('plugin/yiqixueba_server', 'sitegroup_edit_succeed'), 'action='.$this_page.'&subac=sitegrouplist', 'succeed');
	}
}elseif($subac == 'sitegroupedit') {
	if(!submitcheck('submit')) {
		showtips(lang('plugin/yiqixueba_server','sitegroup_edit_tips'));
		showformheader($this_page.'&subac=sitegroupedit','enctype');
		showtableheader(lang('plugin/yiqixueba_server','sitegroup_edit'));
		$sitegroupid ? showhiddenfields(array('sitegroupid'=>$sitegroupid)) : '';
		showsetting(lang('plugin/yiqixueba_server','sitegroupname'),'sitegroup_info[sitegroupname]',$sitegroup_info['sitegroupname'],'text','',0,lang('plugin/yiqixueba_server','sitegroupname_comment'),'','',true);
		showsetting(lang('plugin/yiqixueba_server','mokuaitest'),'sitegroup_info[mokuaitest]',$sitegroup_info['mokuaitest'],'radio','',0,lang('plugin/yiqixueba_server','mokuaitest_comment'),'','',true);
		showsubmit('submit');
		showtablefooter();
		showformfooter();
	}else{
		if(!htmlspecialchars(trim($_GET['sitegroup_info']['sitegroupname']))) {
			cpmsg(lang('plugin/yiqixueba_server','sitegroupname_nonull'));
		}
		$datas = $_GET['sitegroup_info'];
		foreach ( $datas as $k=>$v) {
			$data[$k] = htmlspecialchars(trim($v));
			if(!DB::result_first("describe ".DB::table('yiqixueba_server_sitegroup')." ".$k)) {
				$sql = "alter table ".DB::table('yiqixueba_server_sitegroup')." add `".$k."` varchar(255) not Null;";
				runquery($sql);
			}
		}
		if($sitegroupid) {
			DB::update('yiqixueba_server_sitegroup',$data,array('sitegroupid'=>$sitegroupid));
		}else{
			DB::insert('yiqixueba_server_sitegroup',$data);
		}
		cpmsg(lang('plugin/yiqixueba_server', 'sitegroup_edit_succeed'), 'action='.$this_page.'&subac=sitegrouplist', 'succeed');
	}
}

?>