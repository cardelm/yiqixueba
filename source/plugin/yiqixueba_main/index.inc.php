<?php

/**
*	一起学吧-平台首页 
*	filename:index.inc.php createtime:2013-8-2 03:17  yangwen
*
*/

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

require_once DISCUZ_ROOT.'source/plugin/yiqixueba_main/function.func.php';

$this_page = substr($_SERVER['QUERY_STRING'],7,strlen($_SERVER['QUERY_STRING'])-7);
stripos($this_page,'subac=') ? $this_page = substr($this_page,0,stripos($this_page,'subac=')-1) : $this_page;

$subac = getgpc('subac');
$subacs = array('indexlist','indexedit');
$subac = in_array($subac,$subacs) ? $subac : $subacs[0];

$indexid = getgpc('indexid');
$index_info = $indexid ? DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_main_index')." WHERE indexid=".$indexid) : array();

if($subac == 'indexlist') {
	if(!submitcheck('submit')) {
		showtips(lang('plugin/yiqixueba_main','index_list_tips'));
		showformheader($this_page.'&subac=indexlist');
		showtableheader(lang('plugin/yiqixueba_main','index_list'));
		showsubtitle(array('', lang('plugin/yiqixueba_main','ico'),lang('plugin/yiqixueba_main','indexname'), lang('plugin/yiqixueba_main','displayorder'), lang('plugin/yiqixueba_main','status'), ''));
		$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_main_index')." order by displayorder asc");
		while($row = DB::fetch($query)) {
			$indexico = '';
			if($row['indexico']!='') {
				$indexico = str_replace('{STATICURL}', STATICURL, $row['indexico']);
				if(!preg_match("/^".preg_quote(STATICURL, '/')."/i", $indexico) && !(($valueparse = parse_url($indexico)) && isset($valueparse['host']))) {
					$indexico = $_G['setting']['attachurl'].'common/'.$row['indexico'].'?'.random(6);
				}
			}
			showtablerow('', array('class="td25"','style="width:45px"', 'class="td23"', 'class="td28"'), array(
				"<input class=\"checkbox\" type=\"checkbox\" name=\"delete[]\" value=\"$row[indexid]\">",
				$indexico ?'<img src="'.$indexico.'" width="40" height="40" align="left" style="margin-right:5px" />' : '',
				$row['indexname'],
				"<input type=\"text\" name=\"displayordernew[".$row['indexid']."]\" value=\"".$row['displayorder']."\"  size=\"2\">",
				"<input class=\"checkbox\" type=\"checkbox\" name=\"statusnew[".$row['indexid']."]\" value=\"1\" ".($row['status'] > 0 ? 'checked' : '').">",
				"<a href=\"".ADMINSCRIPT."?action=".$this_page."&subac=indexedit&indexid=$row[indexid]\" class=\"act\">".lang('plugin/yiqixueba_main','edit')."</a>",
			));
		}
	echo '<tr><td></td><td colspan="6"><div><a href="'.ADMINSCRIPT.'?action='.$this_page.'&subac=indexedit" class="addtr">'.lang('plugin/yiqixueba_main','add_index').'</a></div></td></tr>';
	showsubmit('submit','submit','del');
	showtablefooter();
	showformfooter();
	}else{
	}
}elseif($subac == 'indexedit') {
	if(!submitcheck('submit')) {
		if($index_info['indexico']!='') {
			$indexico = str_replace('{STATICURL}', STATICURL, $index_info['indexico']);
			if(!preg_match("/^".preg_quote(STATICURL, '/')."/i", $indexico) && !(($valueparse = parse_url($indexico)) && isset($valueparse['host']))) {
				$indexico = $_G['setting']['attachurl'].'common/'.$index_info['indexico'].'?'.random(6);
				$indexicohtml = '<br /><label><input type="checkbox" class="checkbox" name="delete1" value="yes" /> '.$lang['del'].'</label><br /><img src="'.$indexico.'" width="40" height="40"/>';
			}
		}
		showtips(lang('plugin/yiqixueba_main','index_edit_tips'));
		showformheader($this_page.'&subac=indexedit','enctype');
		showtableheader(lang('plugin/yiqixueba_main','index_edit'));
		$indexid ? showhiddenfields(array('indexid'=>$indexid)) : '';
		showsetting(lang('plugin/yiqixueba_main','indexico'),'indexico',$index_info['indexico'],'filetext','',0,lang('plugin/yiqixueba_main','indexico_comment').$indexicohtml,'','',true);
		showsetting(lang('plugin/yiqixueba_main','indexname'),'index_info[indexname]',$index_info['indexname'],'text','',0,lang('plugin/yiqixueba_main','indexname_comment'),'','',true);
		showsubmit('submit');
		showtablefooter();
		showformfooter();
	}else{
		if(!htmlspecialchars(trim($_GET['index_info']['indexname']))) {
			cpmsg(lang('plugin/yiqixueba_main','indexname_nonull'));
		}
		$indexico = addslashes($_POST['indexico']);
		if($_FILES['indexico']) {
			$upload = new discuz_upload();
			if($upload->init($_FILES['indexico'], 'common') && $upload->save()) {
				$indexico = $upload->attach['attachment'];
			}
		}
		if($_POST['delete1'] && addslashes($_POST['indexico'])) {
			$valueparse = parse_url(addslashes($_POST['indexico']));
			if(!isset($valueparse['host']) && !strexists(addslashes($_POST['indexico']), '{STATICURL}')) {
				@unlink($_G['setting']['attachurl'].'temp/'.addslashes($_POST['indexico']));
			}
			$indexico = '';
		}
		$datas = $_GET['index_info'];
		$datas['indexico'] = $indexico;
		foreach ( $datas as $k=>$v) {
			$data[$k] = htmlspecialchars(trim($v));
			if(!DB::result_first("describe ".DB::table('yiqixueba_main_index')." ".$k)) {
				$sql = "alter table ".DB::table('yiqixueba_main_index')." add `".$k."` varchar(255) not Null;";
				runquery($sql);
			}
		}
		if($indexid) {
			DB::update('yiqixueba_main_index',$data,array('indexid'=>$indexid));
		}else{
			DB::insert('yiqixueba_main_index',$data);
		}
		cpmsg(lang('plugin/yiqixueba_main', 'index_edit_succeed'), 'action='.$this_page.'&subac=indexlist', 'succeed');
	}
	
}
?>