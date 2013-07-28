<?php

/**
*	微信墙-微信分类程序
*	文件名：wxqcats.inc.php 创建时间：2013-7-27 14:20  杨文
*	修改时间：2013-7-27 14:20 杨文
*/

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

require_once DISCUZ_ROOT.'source/plugin/yiqixueba_wxq/function.func.php';

$this_page = substr($_SERVER['QUERY_STRING'],7,strlen($_SERVER['QUERY_STRING'])-7);
stripos($this_page,'subac=') ? $this_page = substr($this_page,0,stripos($this_page,'subac=')-1) : $this_page;

$subac = getgpc('subac');
$subacs = array('wxqcatslist','wxqcatsedit');
$subac = in_array($subac,$subacs) ? $subac : $subacs[0];

$wxqcatsid = getgpc('wxqcatsid');
$wxqcats_info = $wxqcatsid ? DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_wxq_wxqcats')." WHERE wxqcatsid=".$wxqcatsid) : array();

if($subac == 'wxqcatslist') {
	if(!submitcheck('submit')) {
		showtips(lang('plugin/yiqixueba_wxq','wxqcats_list_tips'));
		showformheader($this_page.'&subac=wxqcatslist');
		showtableheader(lang('plugin/yiqixueba_wxq','wxqcats_list'));
		showsubtitle(array('', lang('plugin/yiqixueba_wxq','ico'),lang('plugin/yiqixueba_wxq','wxqcatsname'), lang('plugin/yiqixueba_wxq','displayorder'), lang('plugin/yiqixueba_wxq','status'), ''));
		$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_wxq_wxqcats')." order by displayorder asc");
		while($row = DB::fetch($query)) {
			$wxqcatsico = '';
			if($row['wxqcatsico']!='') {
				$wxqcatsico = str_replace('{STATICURL}', STATICURL, $row['wxqcatsico']);
				if(!preg_match("/^".preg_quote(STATICURL, '/')."/i", $wxqcatsico) && !(($valueparse = parse_url($wxqcatsico)) && isset($valueparse['host']))) {
					$wxqcatsico = $_G['setting']['attachurl'].'common/'.$row['wxqcatsico'].'?'.random(6);
				}
			}
			showtablerow('', array('class="td25"','style="width:45px"', 'class="td23"', 'class="td28"'), array(
				"<input class=\"checkbox\" type=\"checkbox\" name=\"delete[]\" value=\"$row[wxqcatsid]\">",
				$wxqcatsico ?'<img src="'.$wxqcatsico.'" width="40" height="40" align="left" style="margin-right:5px" />' : '',
				$row['wxqcatsname'],
				"<input type=\"text\" name=\"displayordernew[".$row['wxqcatsid']."]\" value=\"".$row['displayorder']."\"  size=\"2\">",
				"<input class=\"checkbox\" type=\"checkbox\" name=\"statusnew[".$row['wxqcatsid']."]\" value=\"1\" ".($row['status'] > 0 ? 'checked' : '').">",
				"<a href=\"".ADMINSCRIPT."?action=".$this_page."&subac=wxqcatsedit&wxqcatsid=$row[wxqcatsid]\" class=\"act\">".lang('plugin/yiqixueba_wxq','edit')."</a>",
			));
		}
	echo '<tr><td></td><td colspan="6"><div><a href="'.ADMINSCRIPT.'?action='.$this_page.'&subac=wxqcatsedit" class="addtr">'.lang('plugin/yiqixueba_wxq','add_wxqcats').'</a></div></td></tr>';
	showsubmit('submit','submit','del');
	showtablefooter();
	showformfooter();
	}else{
	}
}elseif($subac == 'wxqcatsedit') {
	if(!submitcheck('submit')) {
		if($wxqcats_info['wxqcatsico']!='') {
			$wxqcatsico = str_replace('{STATICURL}', STATICURL, $wxqcats_info['wxqcatsico']);
			if(!preg_match("/^".preg_quote(STATICURL, '/')."/i", $wxqcatsico) && !(($valueparse = parse_url($wxqcatsico)) && isset($valueparse['host']))) {
				$wxqcatsico = $_G['setting']['attachurl'].'common/'.$wxqcats_info['wxqcatsico'].'?'.random(6);
				$wxqcatsicohtml = '<br /><label><input type="checkbox" class="checkbox" name="delete1" value="yes" /> '.$lang['del'].'</label><br /><img src="'.$wxqcatsico.'" width="40" height="40"/>';
			}
		}
		showtips(lang('plugin/yiqixueba_wxq','wxqcats_edit_tips'));
		showformheader($this_page.'&subac=wxqcatsedit','enctype');
		showtableheader(lang('plugin/yiqixueba_wxq','wxqcats_edit'));
		$wxqcatsid ? showhiddenfields(array('wxqcatsid'=>$wxqcatsid)) : '';
		showsetting(lang('plugin/yiqixueba_wxq','wxqcatsico'),'wxqcatsico',$wxqcats_info['wxqcatsico'],'filetext','',0,lang('plugin/yiqixueba_wxq','wxqcatsico_comment').$wxqcatsicohtml,'','',true);
		showsetting(lang('plugin/yiqixueba_wxq','wxqcatsname'),'wxqcats_info[wxqcatsname]',$wxqcats_info['wxqcatsname'],'text','',0,lang('plugin/yiqixueba_wxq','wxqcatsname_comment'),'','',true);
		showsubmit('submit');
		showtablefooter();
		showformfooter();
	}else{
		if(!htmlspecialchars(trim($_GET['wxqcats_info']['wxqcatsname']))) {
			cpmsg(lang('plugin/yiqixueba_wxq','wxqcatsname_nonull'));
		}
		$wxqcatsico = addslashes($_POST['wxqcatsico']);
		if($_FILES['wxqcatsico']) {
			$upload = new discuz_upload();
			if($upload->init($_FILES['wxqcatsico'], 'common') && $upload->save()) {
				$wxqcatsico = $upload->attach['attachment'];
			}
		}
		if($_POST['delete1'] && addslashes($_POST['wxqcatsico'])) {
			$valueparse = parse_url(addslashes($_POST['wxqcatsico']));
			if(!isset($valueparse['host']) && !strexists(addslashes($_POST['wxqcatsico']), '{STATICURL}')) {
				@unlink($_G['setting']['attachurl'].'temp/'.addslashes($_POST['wxqcatsico']));
			}
			$wxqcatsico = '';
		}
		$datas = $_GET['wxqcats_info'];
		$datas['wxqcatsico'] = $wxqcatsico;
		foreach ( $datas as $k=>$v) {
			$data[$k] = htmlspecialchars(trim($v));
			if(!DB::result_first("describe ".DB::table('yiqixueba_wxq_wxqcats')." ".$k)) {
				$sql = "alter table ".DB::table('yiqixueba_wxq_wxqcats')." add `".$k."` varchar(255) not Null;";
				runquery($sql);
			}
		}
		if($wxqcatsid) {
			DB::update('yiqixueba_wxq_wxqcats',$data,array('wxqcatsid'=>$wxqcatsid));
		}else{
			DB::insert('yiqixueba_wxq_wxqcats',$data);
		}
		cpmsg(lang('plugin/yiqixueba_wxq', 'wxqcats_edit_succeed'), 'action='.$this_page.'&subac=wxqcatslist', 'succeed');
	}
	
}
?>