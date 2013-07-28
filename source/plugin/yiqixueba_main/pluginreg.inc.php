<?php

/**
*	一起学吧主程序-插件注册程序
*	文件名：pluginreg.inc.php 创建时间：2013-7-27 14:23  杨文
*	修改时间：2013-7-27 14:23 杨文
*/

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

require_once DISCUZ_ROOT.'source/plugin/yiqixueba_main/function.func.php';

$this_page = substr($_SERVER['QUERY_STRING'],7,strlen($_SERVER['QUERY_STRING'])-7);
stripos($this_page,'subac=') ? $this_page = substr($this_page,0,stripos($this_page,'subac=')-1) : $this_page;

$subac = getgpc('subac');
$subacs = array('pluginreglist','pluginregedit');
$subac = in_array($subac,$subacs) ? $subac : $subacs[0];

$pluginregid = getgpc('pluginregid');
$pluginreg_info = $pluginregid ? DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_main_pluginreg')." WHERE pluginregid=".$pluginregid) : array();

if($subac == 'pluginreglist') {
	if(!submitcheck('submit')) {
		showtips(lang('plugin/yiqixueba_main','pluginreg_list_tips'));
		showformheader($this_page.'&subac=pluginreglist');
		showtableheader(lang('plugin/yiqixueba_main','pluginreg_list'));
		showsubtitle(array('', lang('plugin/yiqixueba_main','ico'),lang('plugin/yiqixueba_main','pluginregname'), lang('plugin/yiqixueba_main','displayorder'), lang('plugin/yiqixueba_main','status'), ''));
		$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_main_pluginreg')." order by displayorder asc");
		while($row = DB::fetch($query)) {
			$pluginregico = '';
			if($row['pluginregico']!='') {
				$pluginregico = str_replace('{STATICURL}', STATICURL, $row['pluginregico']);
				if(!preg_match("/^".preg_quote(STATICURL, '/')."/i", $pluginregico) && !(($valueparse = parse_url($pluginregico)) && isset($valueparse['host']))) {
					$pluginregico = $_G['setting']['attachurl'].'common/'.$row['pluginregico'].'?'.random(6);
				}
			}
			showtablerow('', array('class="td25"','style="width:45px"', 'class="td23"', 'class="td28"'), array(
				"<input class=\"checkbox\" type=\"checkbox\" name=\"delete[]\" value=\"$row[pluginregid]\">",
				$pluginregico ?'<img src="'.$pluginregico.'" width="40" height="40" align="left" style="margin-right:5px" />' : '',
				$row['pluginregname'],
				"<input type=\"text\" name=\"displayordernew[".$row['pluginregid']."]\" value=\"".$row['displayorder']."\"  size=\"2\">",
				"<input class=\"checkbox\" type=\"checkbox\" name=\"statusnew[".$row['pluginregid']."]\" value=\"1\" ".($row['status'] > 0 ? 'checked' : '').">",
				"<a href=\"".ADMINSCRIPT."?action=".$this_page."&subac=pluginregedit&pluginregid=$row[pluginregid]\" class=\"act\">".lang('plugin/yiqixueba_main','edit')."</a>",
			));
		}
	echo '<tr><td></td><td colspan="6"><div><a href="'.ADMINSCRIPT.'?action='.$this_page.'&subac=pluginregedit" class="addtr">'.lang('plugin/yiqixueba_main','add_pluginreg').'</a></div></td></tr>';
	showsubmit('submit','submit','del');
	showtablefooter();
	showformfooter();
	}else{
	}
}elseif($subac == 'pluginregedit') {
	if(!submitcheck('submit')) {
		if($pluginreg_info['pluginregico']!='') {
			$pluginregico = str_replace('{STATICURL}', STATICURL, $pluginreg_info['pluginregico']);
			if(!preg_match("/^".preg_quote(STATICURL, '/')."/i", $pluginregico) && !(($valueparse = parse_url($pluginregico)) && isset($valueparse['host']))) {
				$pluginregico = $_G['setting']['attachurl'].'common/'.$pluginreg_info['pluginregico'].'?'.random(6);
				$pluginregicohtml = '<br /><label><input type="checkbox" class="checkbox" name="delete1" value="yes" /> '.$lang['del'].'</label><br /><img src="'.$pluginregico.'" width="40" height="40"/>';
			}
		}
		showtips(lang('plugin/yiqixueba_main','pluginreg_edit_tips'));
		showformheader($this_page.'&subac=pluginregedit','enctype');
		showtableheader(lang('plugin/yiqixueba_main','pluginreg_edit'));
		$pluginregid ? showhiddenfields(array('pluginregid'=>$pluginregid)) : '';
		showsetting(lang('plugin/yiqixueba_main','pluginregico'),'pluginregico',$pluginreg_info['pluginregico'],'filetext','',0,lang('plugin/yiqixueba_main','pluginregico_comment').$pluginregicohtml,'','',true);
		showsetting(lang('plugin/yiqixueba_main','pluginregname'),'pluginreg_info[pluginregname]',$pluginreg_info['pluginregname'],'text','',0,lang('plugin/yiqixueba_main','pluginregname_comment'),'','',true);
		showsubmit('submit');
		showtablefooter();
		showformfooter();
	}else{
		if(!htmlspecialchars(trim($_GET['pluginreg_info']['pluginregname']))) {
			cpmsg(lang('plugin/yiqixueba_main','pluginregname_nonull'));
		}
		$pluginregico = addslashes($_POST['pluginregico']);
		if($_FILES['pluginregico']) {
			$upload = new discuz_upload();
			if($upload->init($_FILES['pluginregico'], 'common') && $upload->save()) {
				$pluginregico = $upload->attach['attachment'];
			}
		}
		if($_POST['delete1'] && addslashes($_POST['pluginregico'])) {
			$valueparse = parse_url(addslashes($_POST['pluginregico']));
			if(!isset($valueparse['host']) && !strexists(addslashes($_POST['pluginregico']), '{STATICURL}')) {
				@unlink($_G['setting']['attachurl'].'temp/'.addslashes($_POST['pluginregico']));
			}
			$pluginregico = '';
		}
		$datas = $_GET['pluginreg_info'];
		$datas['pluginregico'] = $pluginregico;
		foreach ( $datas as $k=>$v) {
			$data[$k] = htmlspecialchars(trim($v));
			if(!DB::result_first("describe ".DB::table('yiqixueba_main_pluginreg')." ".$k)) {
				$sql = "alter table ".DB::table('yiqixueba_main_pluginreg')." add `".$k."` varchar(255) not Null;";
				runquery($sql);
			}
		}
		if($pluginregid) {
			DB::update('yiqixueba_main_pluginreg',$data,array('pluginregid'=>$pluginregid));
		}else{
			DB::insert('yiqixueba_main_pluginreg',$data);
		}
		cpmsg(lang('plugin/yiqixueba_main', 'pluginreg_edit_succeed'), 'action='.$this_page.'&subac=pluginreglist', 'succeed');
	}
	
}
?>