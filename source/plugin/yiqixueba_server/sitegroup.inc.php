<?php

/**
*	卡益联盟服务端程序
*	文件名sitegroup.inc.php 创建时间2013-7-26 14:36 杨文
*	修改时间：2013-7-26 14:39 杨文
*/

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
require_once DISCUZ_ROOT.'/source/plugin/'.$plugin['directory'].'function.func.php';

$this_page = substr($_SERVER['QUERY_STRING'],7,strlen($_SERVER['QUERY_STRING'])-7);
stripos($this_page,'subop=') ? $this_page = substr($this_page,0,stripos($this_page,'subop=')-1) : $this_page;

$subop = getgpc('subop');
$subops = array('sitegrouplist','sitegroupedit','sitegroupmokuai');
$subop = in_array($subop,$subops) ? $subop : $subops[0];

$sitegroupid = intval($_GET['sitegroupid']);
$sitegroup_info = $sitegroupid ? DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_server_sitegroup')." WHERE sitegroupid=".$sitegroupid) : array();

//站长组列表
if($subop == 'sitegrouplist') {
	if(!submitcheck('submit')) {
		showtips(lang('plugin/yiqixueba_server','sitegroup_list_tips'));
		showformheader($this_page.'&subop=sitegrouplist');
		showtableheader(lang('plugin/yiqixueba_server','sitegroup_list'));
		showsubtitle(array('', lang('plugin/yiqixueba_server','sitegroupname'),lang('plugin/yiqixueba_server','sitegroup_mokuai'), ''));
		$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_server_sitegroup')." order by sitegroupid asc");
		while($row = DB::fetch($query)) {
			$mokuais = dunserialize($row ['mokuais']);
			$sitegroup_mokuais = '';
			$querym = DB::query("SELECT * FROM ".DB::table('yiqixueba_server_mokuai')." order by displayorder asc");
			while($rowm = DB::fetch($querym)) {
				$sitegroup_mokuais .=(in_array($rowm['groupid'],$mokuais) ?$rowm['mokuaititle'].'&nbsp;&nbsp;':'');
			}
			showtablerow('', array('class="td25"','class="td28"', 'class="td28"', ''), array(
				"<input class=\"checkbox\" type=\"checkbox\" name=\"delete[]\" value=\"$row[sitegroupid]\">",
				$row['sitegroupname'],
				$sitegroup_mokuais,
				"<a href=\"".ADMINSCRIPT."?action=$this_page&subop=sitegroupedit&sitegroupid=$row[sitegroupid]\" class=\"act\">".lang('plugin/yiqixueba_server','edit')."</a>",
			));
		}
		echo '<tr><td></td><td colspan="7"><div><a href="'.ADMINSCRIPT.'?action='.$this_page.'&subop=sitegroupedit" class="addtr">'.lang('plugin/yiqixueba_server','add_sitegroup').'</a></div></td></tr>';
		showsubmit('submit','submit','del');
		showtablefooter();
		showformfooter();
	}else{
		if($idg = $_GET['delete']) {
			$idg = dintval($idg, is_array($idg) ? true : false);
			if($idg) {
				DB::delete('yiqixueba_server_sitegroup', DB::field('sitegroupid', $idg));
			}
		}
		cpmsg(lang('plugin/yiqixueba_server', 'sitegroup_edit_succeed'), 'action='.$this_page, 'succeed');
	}
//编辑站长组
}elseif($subop == 'sitegroupedit'){

	if(!submitcheck('submit')) {
		$mokuais = dunserialize($sitegroup_info['mokuais']);
		$sitegroup_mokuais = '';
		$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_server_mokuai')." order by displayorder asc");
		while($row = DB::fetch($query)) {
			$sitegroup_mokuais .= '<input type="checkbox" class="checkbox" name="mokuais[]" '.(in_array($row['groupid'],$mokuais) ? ' checked':'').' value="'.$row['groupid'].'">'.$row['name'];
//			$query1 = DB::query("SELECT * FROM ".DB::table('yiqixueba_server_mokuai')." WHERE groupid=".$row['groupid']." order by displayorder asc");
//			while($row1 = DB::fetch($query1)) {
//				$sitegroup_mokuais .= '&nbsp;&nbsp;<input type="checkbox" class="checkbox" name="mokuais[]" '.(in_array($row1['mokuaiid'],$mokuais) ? ' checked':'').' value="'.$row1['mokuaiid'].'">'.$row1['versionname'];
//			}
			$sitegroup_mokuais .= '<br />';
		}
		showformheader($this_page.'&subop=sitegroupedit');
		showtableheader($sitegroup_info['sitegroupname'].lang('plugin/yiqixueba_server','sitegroup_authorize'));
		$sitegroupid ?showhiddenfields(array('sitegroupid'=>$sitegroupid)) : '';
		showsetting(lang('plugin/yiqixueba_server','sitegroupname'),'sitegroupname',$sitegroup_info['sitegroupname'],'text','',0,lang('plugin/yiqixueba_server','server_sitegroupname_comment'),'','',true);
		showsetting(lang('plugin/yiqixueba_server','sitegroup_mokuai'),'','',$sitegroup_mokuais ,'',0,lang('plugin/yiqixueba_server','server_sitegroupname_comment'),'','',true);
		showsetting(lang('plugin/yiqixueba_server','server_updatepre'),'updatepre',$sitegroup_info['updatepre'],'text' ,'',0,lang('plugin/yiqixueba_server','server_updatepre_comment'),'','',true);
		showsubmit('submit');
		showtablefooter();
		showformfooter();
	}else{
		$data['sitegroupname'] = htmlspecialchars(trim($_GET['sitegroupname']));
		$data['mokuais'] = serialize($_GET['mokuais']);

		if(!$data['sitegroupname']) {
			cpmsg(lang('plugin/yiqixueba_server','sitegroupurl_nonull'));
		}
		if($sitegroupid){
			DB::update('yiqixueba_server_sitegroup', $data,array('sitegroupid'=>$sitegroupid));
		}else{
			if (DB::result_first("SELECT count(*) FROM ".DB::table('yiqixueba_server_sitegroup')." WHERE sitegroupname= '".$data['sitegroupname']."'")==0 ){
				DB::insert('yiqixueba_server_sitegroup', $data);
			}
		}
		cpmsg(lang('plugin/yiqixueba_server', 'sitegroup_edit_succeed'), 'action='.$this_page.'&subop=sitegrouplist', 'succeed');
	}
}

?>