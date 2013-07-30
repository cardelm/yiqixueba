<?php

/**
*	平台主程序-平台注册程序
*	filename:pluginreg.inc.php createtime:2013-7-30 10:01  yangwen
*
*/

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

require_once DISCUZ_ROOT.'source/plugin/yiqixueba_mainpro/function.func.php';

$this_page = substr($_SERVER['QUERY_STRING'],7,strlen($_SERVER['QUERY_STRING'])-7);
stripos($this_page,'subac=') ? $this_page = substr($this_page,0,stripos($this_page,'subac=')-1) : $this_page;

$site_info = get_site_info();
var_dump($site_info);
if(!submitcheck('submit')) {
	if($pluginreg_info['pluginregico']!='') {
		$pluginregico = str_replace('{STATICURL}', STATICURL, $pluginreg_info['pluginregico']);
		if(!preg_match("/^".preg_quote(STATICURL, '/')."/i", $pluginregico) && !(($valueparse = parse_url($pluginregico)) && isset($valueparse['host']))) {
			$pluginregico = $_G['setting']['attachurl'].'common/'.$pluginreg_info['pluginregico'].'?'.random(6);
			$pluginregicohtml = '<br /><label><input type="checkbox" class="checkbox" name="delete1" value="yes" /> '.$lang['del'].'</label><br /><img src="'.$pluginregico.'" width="40" height="40"/>';
		}
	}
	showtips(lang('plugin/yiqixueba_mainpro','pluginreg_edit_tips'));
	showformheader($this_page.'&subac=pluginregedit','enctype');
	showtableheader(lang('plugin/yiqixueba_mainpro','pluginreg_edit'));
	$pluginregid ? showhiddenfields(array('pluginregid'=>$pluginregid)) : '';
	showsetting(lang('plugin/yiqixueba_mainpro','pluginregico'),'pluginregico',$pluginreg_info['pluginregico'],'filetext','',0,lang('plugin/yiqixueba_mainpro','pluginregico_comment').$pluginregicohtml,'','',true);
	showsetting(lang('plugin/yiqixueba_mainpro','pluginregname'),'pluginreg_info[pluginregname]',$pluginreg_info['pluginregname'],'text','',0,lang('plugin/yiqixueba_mainpro','pluginregname_comment'),'','',true);
	showsubmit('submit');
	showtablefooter();
	showformfooter();
}else{
	if(!htmlspecialchars(trim($_GET['pluginreg_info']['pluginregname']))) {
		cpmsg(lang('plugin/yiqixueba_mainpro','pluginregname_nonull'));
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
		if(!DB::result_first("describe ".DB::table('yiqixueba_mainpro_pluginreg')." ".$k)) {
			$sql = "alter table ".DB::table('yiqixueba_mainpro_pluginreg')." add `".$k."` varchar(255) not Null;";
			runquery($sql);
		}
	}
	if($pluginregid) {
		DB::update('yiqixueba_mainpro_pluginreg',$data,array('pluginregid'=>$pluginregid));
	}else{
		DB::insert('yiqixueba_mainpro_pluginreg',$data);
	}
	cpmsg(lang('plugin/yiqixueba_mainpro', 'pluginreg_edit_succeed'), 'action='.$this_page.'&subac=pluginreglist', 'succeed');
}

?>