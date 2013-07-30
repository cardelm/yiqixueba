<?php

/**
*	推荐人-插件注册程序
*	filename:admincp.inc.php createtime:2013-7-30 15:07  yangwen
*
*/

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

require_once DISCUZ_ROOT.'source/plugin/yiqixueba_tuijianren/function.func.php';

$this_page = substr($_SERVER['QUERY_STRING'],7,strlen($_SERVER['QUERY_STRING'])-7);
stripos($this_page,'subac=') ? $this_page = substr($this_page,0,stripos($this_page,'subac=')-1) : $this_page;

$subac = getgpc('subac');
$subacs = array('admincplist','admincpedit');
$subac = in_array($subac,$subacs) ? $subac : $subacs[0];

$admincpid = getgpc('admincpid');
$admincp_info = $admincpid ? DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_tuijianren_admincp')." WHERE admincpid=".$admincpid) : array();

if($subac == 'admincplist') {
	if(!submitcheck('submit')) {
		showtips(lang('plugin/yiqixueba_tuijianren','admincp_list_tips'));
		showformheader($this_page.'&subac=admincplist');
		showtableheader(lang('plugin/yiqixueba_tuijianren','admincp_list'));
		showsubtitle(array('', lang('plugin/yiqixueba_tuijianren','ico'),lang('plugin/yiqixueba_tuijianren','admincpname'), lang('plugin/yiqixueba_tuijianren','displayorder'), lang('plugin/yiqixueba_tuijianren','status'), ''));
		$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_tuijianren_admincp')." order by displayorder asc");
		while($row = DB::fetch($query)) {
			$admincpico = '';
			if($row['admincpico']!='') {
				$admincpico = str_replace('{STATICURL}', STATICURL, $row['admincpico']);
				if(!preg_match("/^".preg_quote(STATICURL, '/')."/i", $admincpico) && !(($valueparse = parse_url($admincpico)) && isset($valueparse['host']))) {
					$admincpico = $_G['setting']['attachurl'].'common/'.$row['admincpico'].'?'.random(6);
				}
			}
			showtablerow('', array('class="td25"','style="width:45px"', 'class="td23"', 'class="td28"'), array(
				"<input class=\"checkbox\" type=\"checkbox\" name=\"delete[]\" value=\"$row[admincpid]\">",
				$admincpico ?'<img src="'.$admincpico.'" width="40" height="40" align="left" style="margin-right:5px" />' : '',
				$row['admincpname'],
				"<input type=\"text\" name=\"displayordernew[".$row['admincpid']."]\" value=\"".$row['displayorder']."\"  size=\"2\">",
				"<input class=\"checkbox\" type=\"checkbox\" name=\"statusnew[".$row['admincpid']."]\" value=\"1\" ".($row['status'] > 0 ? 'checked' : '').">",
				"<a href=\"".ADMINSCRIPT."?action=".$this_page."&subac=admincpedit&admincpid=$row[admincpid]\" class=\"act\">".lang('plugin/yiqixueba_tuijianren','edit')."</a>",
			));
		}
	echo '<tr><td></td><td colspan="6"><div><a href="'.ADMINSCRIPT.'?action='.$this_page.'&subac=admincpedit" class="addtr">'.lang('plugin/yiqixueba_tuijianren','add_admincp').'</a></div></td></tr>';
	showsubmit('submit','submit','del');
	showtablefooter();
	showformfooter();
	}else{
	}
}elseif($subac == 'admincpedit') {
	if(!submitcheck('submit')) {
		if($admincp_info['admincpico']!='') {
			$admincpico = str_replace('{STATICURL}', STATICURL, $admincp_info['admincpico']);
			if(!preg_match("/^".preg_quote(STATICURL, '/')."/i", $admincpico) && !(($valueparse = parse_url($admincpico)) && isset($valueparse['host']))) {
				$admincpico = $_G['setting']['attachurl'].'common/'.$admincp_info['admincpico'].'?'.random(6);
				$admincpicohtml = '<br /><label><input type="checkbox" class="checkbox" name="delete1" value="yes" /> '.$lang['del'].'</label><br /><img src="'.$admincpico.'" width="40" height="40"/>';
			}
		}
		showtips(lang('plugin/yiqixueba_tuijianren','admincp_edit_tips'));
		showformheader($this_page.'&subac=admincpedit','enctype');
		showtableheader(lang('plugin/yiqixueba_tuijianren','admincp_edit'));
		$admincpid ? showhiddenfields(array('admincpid'=>$admincpid)) : '';
		showsetting(lang('plugin/yiqixueba_tuijianren','admincpico'),'admincpico',$admincp_info['admincpico'],'filetext','',0,lang('plugin/yiqixueba_tuijianren','admincpico_comment').$admincpicohtml,'','',true);
		showsetting(lang('plugin/yiqixueba_tuijianren','admincpname'),'admincp_info[admincpname]',$admincp_info['admincpname'],'text','',0,lang('plugin/yiqixueba_tuijianren','admincpname_comment'),'','',true);
		showsubmit('submit');
		showtablefooter();
		showformfooter();
	}else{
		if(!htmlspecialchars(trim($_GET['admincp_info']['admincpname']))) {
			cpmsg(lang('plugin/yiqixueba_tuijianren','admincpname_nonull'));
		}
		$admincpico = addslashes($_POST['admincpico']);
		if($_FILES['admincpico']) {
			$upload = new discuz_upload();
			if($upload->init($_FILES['admincpico'], 'common') && $upload->save()) {
				$admincpico = $upload->attach['attachment'];
			}
		}
		if($_POST['delete1'] && addslashes($_POST['admincpico'])) {
			$valueparse = parse_url(addslashes($_POST['admincpico']));
			if(!isset($valueparse['host']) && !strexists(addslashes($_POST['admincpico']), '{STATICURL}')) {
				@unlink($_G['setting']['attachurl'].'temp/'.addslashes($_POST['admincpico']));
			}
			$admincpico = '';
		}
		$datas = $_GET['admincp_info'];
		$datas['admincpico'] = $admincpico;
		foreach ( $datas as $k=>$v) {
			$data[$k] = htmlspecialchars(trim($v));
			if(!DB::result_first("describe ".DB::table('yiqixueba_tuijianren_admincp')." ".$k)) {
				$sql = "alter table ".DB::table('yiqixueba_tuijianren_admincp')." add `".$k."` varchar(255) not Null;";
				runquery($sql);
			}
		}
		if($admincpid) {
			DB::update('yiqixueba_tuijianren_admincp',$data,array('admincpid'=>$admincpid));
		}else{
			DB::insert('yiqixueba_tuijianren_admincp',$data);
		}
		cpmsg(lang('plugin/yiqixueba_tuijianren', 'admincp_edit_succeed'), 'action='.$this_page.'&subac=admincplist', 'succeed');
	}
	
}
?>