<?php

/**
*	一起学吧-模块管理程序
*	filename:mokuai.inc.php createtime:2013-8-1 21:52  yangwen
*
*/

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

require_once DISCUZ_ROOT.'source/plugin/yiqixueba_main/function.func.php';

$this_page = substr($_SERVER['QUERY_STRING'],7,strlen($_SERVER['QUERY_STRING'])-7);
stripos($this_page,'subac=') ? $this_page = substr($this_page,0,stripos($this_page,'subac=')-1) : $this_page;

$subac = getgpc('subac');
$subacs = array('mokuailist','mokuaiedit');
$subac = in_array($subac,$subacs) ? $subac : $subacs[0];

$mokuaiid = getgpc('mokuaiid');
$mokuai_info = $mokuaiid ? DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_main_mokuai')." WHERE mokuaiid=".$mokuaiid) : array();

if($subac == 'mokuailist') {
	if(!submitcheck('submit')) {
		showtips(lang('plugin/yiqixueba_main','mokuai_list_tips'));
		showformheader($this_page.'&subac=mokuailist');
		showtableheader(lang('plugin/yiqixueba_main','mokuai_list'));
		showsubtitle(array('', lang('plugin/yiqixueba_main','ico'),lang('plugin/yiqixueba_main','mokuainame'), lang('plugin/yiqixueba_main','displayorder'), lang('plugin/yiqixueba_main','status'), ''));
		$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_main_mokuai')." order by displayorder asc");
		while($row = DB::fetch($query)) {
			$mokuaiico = '';
			if($row['mokuaiico']!='') {
				$mokuaiico = str_replace('{STATICURL}', STATICURL, $row['mokuaiico']);
				if(!preg_match("/^".preg_quote(STATICURL, '/')."/i", $mokuaiico) && !(($valueparse = parse_url($mokuaiico)) && isset($valueparse['host']))) {
					$mokuaiico = $_G['setting']['attachurl'].'common/'.$row['mokuaiico'].'?'.random(6);
				}
			}
			showtablerow('', array('class="td25"','style="width:45px"', 'class="td23"', 'class="td28"'), array(
				"<input class=\"checkbox\" type=\"checkbox\" name=\"delete[]\" value=\"$row[mokuaiid]\">",
				$mokuaiico ?'<img src="'.$mokuaiico.'" width="40" height="40" align="left" style="margin-right:5px" />' : '',
				$row['mokuainame'],
				"<input type=\"text\" name=\"displayordernew[".$row['mokuaiid']."]\" value=\"".$row['displayorder']."\"  size=\"2\">",
				"<input class=\"checkbox\" type=\"checkbox\" name=\"statusnew[".$row['mokuaiid']."]\" value=\"1\" ".($row['status'] > 0 ? 'checked' : '').">",
				"<a href=\"".ADMINSCRIPT."?action=".$this_page."&subac=mokuaiedit&mokuaiid=$row[mokuaiid]\" class=\"act\">".lang('plugin/yiqixueba_main','edit')."</a>",
			));
		}
	echo '<tr><td></td><td colspan="6"><div><a href="'.ADMINSCRIPT.'?action='.$this_page.'&subac=mokuaiedit" class="addtr">'.lang('plugin/yiqixueba_main','add_mokuai').'</a></div></td></tr>';
	showsubmit('submit','submit','del');
	showtablefooter();
	showformfooter();
	}else{
	}
}elseif($subac == 'mokuaiedit') {
	if(!submitcheck('submit')) {
		if($mokuai_info['mokuaiico']!='') {
			$mokuaiico = str_replace('{STATICURL}', STATICURL, $mokuai_info['mokuaiico']);
			if(!preg_match("/^".preg_quote(STATICURL, '/')."/i", $mokuaiico) && !(($valueparse = parse_url($mokuaiico)) && isset($valueparse['host']))) {
				$mokuaiico = $_G['setting']['attachurl'].'common/'.$mokuai_info['mokuaiico'].'?'.random(6);
				$mokuaiicohtml = '<br /><label><input type="checkbox" class="checkbox" name="delete1" value="yes" /> '.$lang['del'].'</label><br /><img src="'.$mokuaiico.'" width="40" height="40"/>';
			}
		}
		showtips(lang('plugin/yiqixueba_main','mokuai_edit_tips'));
		showformheader($this_page.'&subac=mokuaiedit','enctype');
		showtableheader(lang('plugin/yiqixueba_main','mokuai_edit'));
		$mokuaiid ? showhiddenfields(array('mokuaiid'=>$mokuaiid)) : '';
		showsetting(lang('plugin/yiqixueba_main','mokuaiico'),'mokuaiico',$mokuai_info['mokuaiico'],'filetext','',0,lang('plugin/yiqixueba_main','mokuaiico_comment').$mokuaiicohtml,'','',true);
		showsetting(lang('plugin/yiqixueba_main','mokuainame'),'mokuai_info[mokuainame]',$mokuai_info['mokuainame'],'text','',0,lang('plugin/yiqixueba_main','mokuainame_comment'),'','',true);
		showsubmit('submit');
		showtablefooter();
		showformfooter();
	}else{
		if(!htmlspecialchars(trim($_GET['mokuai_info']['mokuainame']))) {
			cpmsg(lang('plugin/yiqixueba_main','mokuainame_nonull'));
		}
		$mokuaiico = addslashes($_POST['mokuaiico']);
		if($_FILES['mokuaiico']) {
			$upload = new discuz_upload();
			if($upload->init($_FILES['mokuaiico'], 'common') && $upload->save()) {
				$mokuaiico = $upload->attach['attachment'];
			}
		}
		if($_POST['delete1'] && addslashes($_POST['mokuaiico'])) {
			$valueparse = parse_url(addslashes($_POST['mokuaiico']));
			if(!isset($valueparse['host']) && !strexists(addslashes($_POST['mokuaiico']), '{STATICURL}')) {
				@unlink($_G['setting']['attachurl'].'temp/'.addslashes($_POST['mokuaiico']));
			}
			$mokuaiico = '';
		}
		$datas = $_GET['mokuai_info'];
		$datas['mokuaiico'] = $mokuaiico;
		foreach ( $datas as $k=>$v) {
			$data[$k] = htmlspecialchars(trim($v));
			if(!DB::result_first("describe ".DB::table('yiqixueba_main_mokuai')." ".$k)) {
				$sql = "alter table ".DB::table('yiqixueba_main_mokuai')." add `".$k."` varchar(255) not Null;";
				runquery($sql);
			}
		}
		if($mokuaiid) {
			DB::update('yiqixueba_main_mokuai',$data,array('mokuaiid'=>$mokuaiid));
		}else{
			DB::insert('yiqixueba_main_mokuai',$data);
		}
		cpmsg(lang('plugin/yiqixueba_main', 'mokuai_edit_succeed'), 'action='.$this_page.'&subac=mokuailist', 'succeed');
	}
	
}
?>