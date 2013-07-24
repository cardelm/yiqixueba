<?php

/**
*	商家展示-商家模型程序
*	文件名：shopmoxing.inc.php 创建时间：2013-7-24 11:19  杨文
*
*/

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

require_once DISCUZ_ROOT.'source/plugin/yiqixueba_shop/function.func.php';

$this_page = substr($_SERVER['QUERY_STRING'],7,strlen($_SERVER['QUERY_STRING'])-7);
stripos($this_page,'subac=') ? $this_page = substr($this_page,0,stripos($this_page,'subac=')-1) : $this_page;

$subac = getgpc('subac');
$subacs = array('shopmoxinglist','shopmoxingedit','shopmoxingfield');
$subac = in_array($subac,$subacs) ? $subac : $subacs[0];

$shopmoxingid = getgpc('shopmoxingid');
$shopmoxing_info = $shopmoxingid ? DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_shop_shopmoxing')." WHERE shopmoxingid=".$shopmoxingid) : array();


if($subac == 'shopmoxinglist') {
	if(!submitcheck('submit')) {
		showtips(lang('plugin/yiqixueba_shop','shopmoxing_list_tips'));
		showformheader($this_page.'&subac=shopmoxinglist');
		showtableheader(lang('plugin/yiqixueba_shop','shopmoxing_list'));
		showsubtitle(array('', lang('plugin/yiqixueba_shop','ico'),lang('plugin/yiqixueba_shop','shopmoxingname'), lang('plugin/yiqixueba_shop','displayorder'), lang('plugin/yiqixueba_shop','status'), ''));
		$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_shop_shopmoxing')." order by displayorder asc");
		while($row = DB::fetch($query)) {
			$shopmoxingico = '';
			if($row['shopmoxingico']!='') {
				$shopmoxingico = str_replace('{STATICURL}', STATICURL, $row['shopmoxingico']);
				if(!preg_match("/^".preg_quote(STATICURL, '/')."/i", $shopmoxingico) && !(($valueparse = parse_url($shopmoxingico)) && isset($valueparse['host']))) {
					$shopmoxingico = $_G['setting']['attachurl'].'common/'.$row['shopmoxingico'].'?'.random(6);
				}
			}
			showtablerow('', array('class="td25"','style="width:45px"', 'class="td23"', 'class="td28"'), array(
				"<input class=\"checkbox\" type=\"checkbox\" name=\"delete[]\" value=\"$row[shopmoxingid]\">",
				$shopmoxingico ?'<img src="'.$shopmoxingico.'" width="40" height="40" align="left" style="margin-right:5px" />' : '',
				$row['shopmoxingname'],
				"<input type=\"text\" name=\"displayordernew[".$row['shopmoxingid']."]\" value=\"".$row['displayorder']."\" size=\"2\">",
				"<input class=\"checkbox\" type=\"checkbox\" name=\"statusnew[".$row['shopmoxingid']."]\" value=\"1\" ".($row['status'] > 0 ? 'checked' : '').">",
				"<a href=\"".ADMINSCRIPT."?action=".$this_page."&subac=shopmoxingfield&shopmoxingid=$row[shopmoxingid]\" class=\"act\">".lang('plugin/yiqixueba_shop','field')."</a>&nbsp;&nbsp;<a href=\"".ADMINSCRIPT."?action=".$this_page."&subac=shopmoxingedit&shopmoxingid=$row[shopmoxingid]\" class=\"act\">".lang('plugin/yiqixueba_shop','edit')."</a>",
			));
		}
		echo '<tr><td></td><td colspan="6"><div><a href="'.ADMINSCRIPT.'?action='.$this_page.'&subac=shopmoxingedit" class="addtr">'.lang('plugin/yiqixueba_shop','add_shopmoxing').'</a></div></td></tr>';
		showsubmit('submit','submit','del');
		showtablefooter();
		showformfooter();
	}else{
	}
}elseif($subac == 'shopmoxingedit') {
	if(!submitcheck('submit')) {
		if($shopmoxing_info['shopmoxingico']!='') {
			$shopmoxingico = str_replace('{STATICURL}', STATICURL, $shopmoxing_info['shopmoxingico']);
			if(!preg_match("/^".preg_quote(STATICURL, '/')."/i", $shopmoxingico) && !(($valueparse = parse_url($shopmoxingico)) && isset($valueparse['host']))) {
				$shopmoxingico = $_G['setting']['attachurl'].'common/'.$shopmoxing_info['shopmoxingico'].'?'.random(6);
				$shopmoxingicohtml = '<br /><label><input type="checkbox" class="checkbox" name="delete1" value="yes" /> '.$lang['del'].'</label><br /><img src="'.$shopmoxingico.'" width="40" height="40"/>';
			}
		}
		showtips(lang('plugin/yiqixueba_shop','shopmoxing_edit_tips'));
		showformheader($this_page.'&subac=shopmoxingedit','enctype');
		showtableheader(lang('plugin/yiqixueba_shop','shopmoxing_edit'));
		$shopmoxingid ? showhiddenfields(array('shopmoxingid'=>$shopmoxingid)) : '';
		showsetting(lang('plugin/yiqixueba_shop','shopmoxingico'),'shopmoxingico',$shopmoxing_info['shopmoxingico'],'filetext','',0,lang('plugin/yiqixueba_shop','shopmoxingico_comment').$shopmoxingicohtml,'','',true);
		showsetting(lang('plugin/yiqixueba_shop','shopmoxingname'),'shopmoxing_info[shopmoxingname]',$shopmoxing_info['shopmoxingname'],'text','',0,lang('plugin/yiqixueba_shop','shopmoxingname_comment'),'','',true);
		showsubmit('submit');
		showtablefooter();
		showformfooter();
	}else{
		if(!htmlspecialchars(trim($_GET['shopmoxing_info']['shopmoxingname']))) {
			cpmsg(lang('plugin/yiqixueba_shop','shopmoxingname_nonull'));
		}
		$shopmoxingico = addslashes($_POST['shopmoxingico']);
		if($_FILES['shopmoxingico']) {
			$upload = new discuz_upload();
			if($upload->init($_FILES['shopmoxingico'], 'common') && $upload->save()) {
				$shopmoxingico = $upload->attach['attachment'];
			}
		}
		if($_POST['delete1'] && addslashes($_POST['shopmoxingico'])) {
			$valueparse = parse_url(addslashes($_POST['shopmoxingico']));
			if(!isset($valueparse['host']) && !strexists(addslashes($_POST['shopmoxingico']), '{STATICURL}')) {
				@unlink($_G['setting']['attachurl'].'temp/'.addslashes($_POST['shopmoxingico']));
			}
			$shopmoxingico = '';
		}
		$datas = $_GET['shopmoxing_info'];
		$datas['shopmoxingico'] = $shopmoxingico;
		foreach ( $datas as $k=>$v) {
			$data[$k] = htmlspecialchars(trim($v));
			if(!DB::result_first("describe ".DB::table('yiqixueba_shop_shopmoxing')." ".$k)) {
				$sql = "alter table ".DB::table('yiqixueba_shop_shopmoxing')." add `".$k."` varchar(255) not Null;";
				runquery($sql);
			}
		}
		if($shopmoxingid) {
			DB::update('yiqixueba_shop_shopmoxing',$data,array('shopmoxingid'=>$shopmoxingid));
		}else{
			DB::insert('yiqixueba_shop_shopmoxing',$data);
		}
		cpmsg(lang('plugin/yiqixueba_shop', 'shopmoxing_edit_succeed'), 'action='.$this_page.'&subac=shopmoxinglist', 'succeed');
	}
}elseif($subac == 'shopmoxingfield') {
	if(!submitcheck('submit')) {
		showtips(lang('plugin/yiqixueba_shop','shopmoxingfield_list_tips'));
		showformheader($this_page.'&subac=shopmoxingfield&shopmoxingid='.$shopmoxingid);
		showtableheader(lang('plugin/yiqixueba_shop','shopmoxingfield_list'));
		showsubtitle(array('', 'display_order', 'plugins_vars_title', 'plugins_vars_variable', 'plugins_vars_type', ''));
		$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_shop_shopmoxingvar')." WHERE shopmoxingid = ".$shopmoxingid." order by displayorder asc");
		while($row = DB::fetch($query)) {
			$row['type'] = $lang['plugins_edit_vars_type_'. $row['type']];
			$row['title'] .= isset($lang[$row['title']]) ? '<br />'.$lang[$row['title']] : '';
			showtablerow('', array('class="td25"', 'class="td28"'), array(
				"<input class=\"checkbox\" type=\"checkbox\" name=\"delete[]\" value=\"$row[pluginvarid]\">",
				"<input type=\"text\" class=\"txt\" size=\"2\" name=\"displayordernew[$row[pluginvarid]]\" value=\"$row[displayorder]\">",
				$row['title'],
				$row['variable'],
				$row['type'],
				"<a href=\"".ADMINSCRIPT."?action=plugins&operation=vars&pluginid=$plugin[pluginid]&pluginvarid=$row[pluginvarid]\" class=\"act\">$lang[detail]</a>"
			));
		}
		showtablerow('', array('class="td25"', 'class="td28"'), array(
			cplang('add_new'),
			'<input type="text" class="txt" size="2" name="newdisplayorder" value="0">',
			'<input type="text" class="txt" size="15" name="newtitle">',
			'<input type="text" class="txt" size="15" name="newvariable">',
			'<select name="newtype">
				<option value="number">'.cplang('plugins_edit_vars_type_number').'</option>
				<option value="text" selected>'.cplang('plugins_edit_vars_type_text').'</option>
				<option value="textarea">'.cplang('plugins_edit_vars_type_textarea').'</option>
				<option value="radio">'.cplang('plugins_edit_vars_type_radio').'</option>
				<option value="select">'.cplang('plugins_edit_vars_type_select').'</option>
				<option value="selects">'.cplang('plugins_edit_vars_type_selects').'</option>
				<option value="color">'.cplang('plugins_edit_vars_type_color').'</option>
				<option value="date">'.cplang('plugins_edit_vars_type_date').'</option>
				<option value="datetime">'.cplang('plugins_edit_vars_type_datetime').'</option>
				<option value="forum">'.cplang('plugins_edit_vars_type_forum').'</option>
				<option value="forums">'.cplang('plugins_edit_vars_type_forums').'</option>
				<option value="group">'.cplang('plugins_edit_vars_type_group').'</option>
				<option value="groups">'.cplang('plugins_edit_vars_type_groups').'</option>
				<option value="extcredit">'.cplang('plugins_edit_vars_type_extcredit').'</option>
				<option value="forum_text">'.cplang('plugins_edit_vars_type_forum_text').'</option>
				<option value="forum_textarea">'.cplang('plugins_edit_vars_type_forum_textarea').'</option>
				<option value="forum_radio">'.cplang('plugins_edit_vars_type_forum_radio').'</option>
				<option value="forum_select">'.cplang('plugins_edit_vars_type_forum_select').'</option>
				<option value="group_text">'.cplang('plugins_edit_vars_type_group_text').'</option>
				<option value="group_textarea">'.cplang('plugins_edit_vars_type_group_textarea').'</option>
				<option value="group_radio">'.cplang('plugins_edit_vars_type_group_radio').'</option>
				<option value="group_select">'.cplang('plugins_edit_vars_type_group_select').'</option>
			</seletc>',
			''
		));
		showsubmit('submit','submit','del');
		showtablefooter();
		showformfooter();
	}else{
		if($_GET['delete']) {
			//C::t('common_pluginvar')->delete($_GET['delete']);
		}

		if(is_array($_GET['displayordernew'])) {
			foreach($_GET['displayordernew'] as $id => $displayorder) {
				//C::t('common_pluginvar')->update($id, array('displayorder' => $displayorder));
			}
		}

		$newtitle = dhtmlspecialchars(trim($_GET['newtitle']));
		$newvariable = trim($_GET['newvariable']);
		if($newtitle && $newvariable) {
			if(strlen($newvariable) > 40 || !ispluginkey($newvariable) || C::t('common_pluginvar')->check_variable($pluginid, $newvariable)) {
				cpmsg('plugins_edit_var_invalid', '', 'error');
			}
			$data = array(
				'shopmoxingid' => $shopmoxingid,
				'displayorder' => $_GET['newdisplayorder'],
				'title' => $newtitle,
				'variable' => $newvariable,
				'type' => $_GET['newtype'],
			);
			DB::insert('yiqixueba_shop_shopmoxingvar', $data);
		}

		cpmsg('plugins_edit_succeed', "action=".$this_page.'&subac=shopmoxingfield&shopmoxingid='.$shopmoxingid, 'succeed');

	}
}
?>