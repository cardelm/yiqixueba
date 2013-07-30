<?php

/**
*	瀑布流图文-重建缩略图程序
*	filename:buildthumb.inc.php createtime:2013-7-30 15:07  yangwen
*
*/

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

require_once DISCUZ_ROOT.'source/plugin/yiqixueba_pbl/function.func.php';

$this_page = substr($_SERVER['QUERY_STRING'],7,strlen($_SERVER['QUERY_STRING'])-7);
stripos($this_page,'subac=') ? $this_page = substr($this_page,0,stripos($this_page,'subac=')-1) : $this_page;

$subac = getgpc('subac');
$subacs = array('buildthumblist','buildthumbedit');
$subac = in_array($subac,$subacs) ? $subac : $subacs[0];

$buildthumbid = getgpc('buildthumbid');
$buildthumb_info = $buildthumbid ? DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_pbl_buildthumb')." WHERE buildthumbid=".$buildthumbid) : array();

if($subac == 'buildthumblist') {
	if(!submitcheck('submit')) {
		showtips(lang('plugin/yiqixueba_pbl','buildthumb_list_tips'));
		showformheader($this_page.'&subac=buildthumblist');
		showtableheader(lang('plugin/yiqixueba_pbl','buildthumb_list'));
		showsubtitle(array('', lang('plugin/yiqixueba_pbl','ico'),lang('plugin/yiqixueba_pbl','buildthumbname'), lang('plugin/yiqixueba_pbl','displayorder'), lang('plugin/yiqixueba_pbl','status'), ''));
		$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_pbl_buildthumb')." order by displayorder asc");
		while($row = DB::fetch($query)) {
			$buildthumbico = '';
			if($row['buildthumbico']!='') {
				$buildthumbico = str_replace('{STATICURL}', STATICURL, $row['buildthumbico']);
				if(!preg_match("/^".preg_quote(STATICURL, '/')."/i", $buildthumbico) && !(($valueparse = parse_url($buildthumbico)) && isset($valueparse['host']))) {
					$buildthumbico = $_G['setting']['attachurl'].'common/'.$row['buildthumbico'].'?'.random(6);
				}
			}
			showtablerow('', array('class="td25"','style="width:45px"', 'class="td23"', 'class="td28"'), array(
				"<input class=\"checkbox\" type=\"checkbox\" name=\"delete[]\" value=\"$row[buildthumbid]\">",
				$buildthumbico ?'<img src="'.$buildthumbico.'" width="40" height="40" align="left" style="margin-right:5px" />' : '',
				$row['buildthumbname'],
				"<input type=\"text\" name=\"displayordernew[".$row['buildthumbid']."]\" value=\"".$row['displayorder']."\"  size=\"2\">",
				"<input class=\"checkbox\" type=\"checkbox\" name=\"statusnew[".$row['buildthumbid']."]\" value=\"1\" ".($row['status'] > 0 ? 'checked' : '').">",
				"<a href=\"".ADMINSCRIPT."?action=".$this_page."&subac=buildthumbedit&buildthumbid=$row[buildthumbid]\" class=\"act\">".lang('plugin/yiqixueba_pbl','edit')."</a>",
			));
		}
	echo '<tr><td></td><td colspan="6"><div><a href="'.ADMINSCRIPT.'?action='.$this_page.'&subac=buildthumbedit" class="addtr">'.lang('plugin/yiqixueba_pbl','add_buildthumb').'</a></div></td></tr>';
	showsubmit('submit','submit','del');
	showtablefooter();
	showformfooter();
	}else{
	}
}elseif($subac == 'buildthumbedit') {
	if(!submitcheck('submit')) {
		if($buildthumb_info['buildthumbico']!='') {
			$buildthumbico = str_replace('{STATICURL}', STATICURL, $buildthumb_info['buildthumbico']);
			if(!preg_match("/^".preg_quote(STATICURL, '/')."/i", $buildthumbico) && !(($valueparse = parse_url($buildthumbico)) && isset($valueparse['host']))) {
				$buildthumbico = $_G['setting']['attachurl'].'common/'.$buildthumb_info['buildthumbico'].'?'.random(6);
				$buildthumbicohtml = '<br /><label><input type="checkbox" class="checkbox" name="delete1" value="yes" /> '.$lang['del'].'</label><br /><img src="'.$buildthumbico.'" width="40" height="40"/>';
			}
		}
		showtips(lang('plugin/yiqixueba_pbl','buildthumb_edit_tips'));
		showformheader($this_page.'&subac=buildthumbedit','enctype');
		showtableheader(lang('plugin/yiqixueba_pbl','buildthumb_edit'));
		$buildthumbid ? showhiddenfields(array('buildthumbid'=>$buildthumbid)) : '';
		showsetting(lang('plugin/yiqixueba_pbl','buildthumbico'),'buildthumbico',$buildthumb_info['buildthumbico'],'filetext','',0,lang('plugin/yiqixueba_pbl','buildthumbico_comment').$buildthumbicohtml,'','',true);
		showsetting(lang('plugin/yiqixueba_pbl','buildthumbname'),'buildthumb_info[buildthumbname]',$buildthumb_info['buildthumbname'],'text','',0,lang('plugin/yiqixueba_pbl','buildthumbname_comment'),'','',true);
		showsubmit('submit');
		showtablefooter();
		showformfooter();
	}else{
		if(!htmlspecialchars(trim($_GET['buildthumb_info']['buildthumbname']))) {
			cpmsg(lang('plugin/yiqixueba_pbl','buildthumbname_nonull'));
		}
		$buildthumbico = addslashes($_POST['buildthumbico']);
		if($_FILES['buildthumbico']) {
			$upload = new discuz_upload();
			if($upload->init($_FILES['buildthumbico'], 'common') && $upload->save()) {
				$buildthumbico = $upload->attach['attachment'];
			}
		}
		if($_POST['delete1'] && addslashes($_POST['buildthumbico'])) {
			$valueparse = parse_url(addslashes($_POST['buildthumbico']));
			if(!isset($valueparse['host']) && !strexists(addslashes($_POST['buildthumbico']), '{STATICURL}')) {
				@unlink($_G['setting']['attachurl'].'temp/'.addslashes($_POST['buildthumbico']));
			}
			$buildthumbico = '';
		}
		$datas = $_GET['buildthumb_info'];
		$datas['buildthumbico'] = $buildthumbico;
		foreach ( $datas as $k=>$v) {
			$data[$k] = htmlspecialchars(trim($v));
			if(!DB::result_first("describe ".DB::table('yiqixueba_pbl_buildthumb')." ".$k)) {
				$sql = "alter table ".DB::table('yiqixueba_pbl_buildthumb')." add `".$k."` varchar(255) not Null;";
				runquery($sql);
			}
		}
		if($buildthumbid) {
			DB::update('yiqixueba_pbl_buildthumb',$data,array('buildthumbid'=>$buildthumbid));
		}else{
			DB::insert('yiqixueba_pbl_buildthumb',$data);
		}
		cpmsg(lang('plugin/yiqixueba_pbl', 'buildthumb_edit_succeed'), 'action='.$this_page.'&subac=buildthumblist', 'succeed');
	}
	
}
?>