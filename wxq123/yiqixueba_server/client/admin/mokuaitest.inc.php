<?php

/**
*	一起学吧平台程序
*	文件名：mokuai.inc.php  创建时间：2013-6-1 15:17  杨文
*
*/
//此文件为整个插件程序的核心程序
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
//本页的地址
$this_page = 'plugins&identifier=yiqixueba_server&pmod=admincp&submod=mokuai';

//得到subop
$subop = getgpc('subop');
$subops = array('mokuailist','editmokuai','verlist','veredit','designmokuai','pageedit','adminedit','moduleedit','templateedit','pagelist','makemokuai','adminacedit');
$subop = in_array($subop,$subops) ? $subop : $subops[0];

//获取模块信息（主要是版本）
$mokuaiid = getgpc('mokuaiid');
$mokuai_info = $mokuaiid ? DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_server_mokuai')." WHERE mokuaiid=".$mokuaiid) : array();

//获取模块组信息（模块基本信息）
$verid = getgpc('verid');
$ver_info = $verid ? DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_server_mokuaiver')." WHERE verid=".$verid) : array();

//页面的不同功能数组
$page_type_array = array('admin','module','ajax','api','hook');

//
$adminacs = array('setting','datalist','dataedit');


//模块列表
if($subop == $subops[0]) {
	if(!submitcheck('submit')) {
		$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_server_mokuai')." order by displayorder asc");
		while($row = DB::fetch($query)) {
			$mokuais_info[$row['mokuaiid']] = $row;
		}
		showtips(lang('plugin/yiqixueba_server','mokuai_list_tips'));
		showformheader($this_page.'&subop='.$subops[0]);
		showtableheader(lang('plugin/yiqixueba_server','mokuai_list'));
		showsubtitle(array('',lang('plugin/yiqixueba_server','displayorder'),lang('plugin/yiqixueba_server','mokuaiico'),lang('plugin/yiqixueba_server','mokuaititle'),  lang('plugin/yiqixueba_server','upmokuai'), ''));
		foreach ($mokuais_info as $k=>$row){
			if ($row['level']>1){
				$mokuaiico = '';
				if($row['mokuaiico']!='') {
					$mokuaiico = str_replace('{STATICURL}', STATICURL, $row['mokuaiico']);
					if(!preg_match("/^".preg_quote(STATICURL, '/')."/i", $mokuaiico) && !(($valueparse = parse_url($mokuaiico)) && isset($valueparse['host']))) {
						$mokuaiico = $_G['setting']['attachurl'].'common/'.$row['mokuaiico'].'?'.random(6);
					}
					$mokuaiico = '<img src="'.$mokuaiico.'" width="40" height="40"/>';
				}else{
					$mokuaiico = '';
				}
				$mknum = DB::result_first("SELECT count(*) FROM ".DB::table('yiqixueba_server_mokuai')." WHERE upmokuai='".$row['mokuainame']."' order by displayorder asc");
				showtablerow('', array('class="td25"','class="td25"','class="td25"',  'class="td28"',''), array(
					($mknum ?'<a href="javascript:;" class="right" onclick="toggle_group(\'mokuai_'.$row['mokuaiid'].'\', this)">[-]</a>':'')."<input class=\"checkbox\" type=\"checkbox\" name=\"delete[]\" value=\"$row[mokuaiid]\">",
					'<input type="text" class="txt" name="displayordergnew['.$row['mokuaiid'].']" value="'.$row['displayorder'].'" size="1" />',
					$mokuaiico.'<input type="hidden" name="mokuainamenew['.$row['mokuaiid'].']" value="'.$row['mokuainame'].'">',
					$row['mokuaititle'].'('.$row['mokuainame'].')',
					$mokuais_info[$row['upid']]['mokuaititle'],
					"<a href=\"".ADMINSCRIPT."?action=$this_page&subop=editmokuai&mokuaiid=$row[mokuaiid]\" class=\"act\">".lang('plugin/yiqixueba_server','edit')."</a>&nbsp;&nbsp;<a href=\"".ADMINSCRIPT."?action=$this_page&subop=$subops[2]&mokuaiid=$row[mokuaiid]\" class=\"act\">".lang('plugin/yiqixueba_server','versionname')."</a>&nbsp;&nbsp;",
				));
			}
		}
		echo '<tr><td></td><td colspan="8"><div><a href="'.ADMINSCRIPT.'?action='.$this_page.'&subop=editmokuai" class="addtr">'.lang('plugin/yiqixueba_server','add_mokuai').'</a></div></td></tr>';
		showsubmit('submit','submit','del');
		showtablefooter();
		showformfooter();
	}else{
		if($idg = $_GET['delgroup']) {
			$idg = dintval($idg, is_array($idg) ? true : false);
			if($idg) {
				DB::delete('yiqixueba_server_mokuai_group', DB::field('groupid', $idg));
				//删除站长数据表中的模块设置字段
				//$sql = "alter table ".DB::table('wxq123_site')." DROP `m_".$mokuainame."`;";
			}
		}
		if($idm = $_GET['delmokuai']) {
			$idm = dintval($idm, is_array($idm) ? true : false);
			if($idm) {
				foreach ( $idm as $k=>$v) {
					rmdirs(DISCUZ_ROOT.'source/plugin/yiqixueba_server/source/mokuai/ver'.$v.'/');
				}
				DB::delete('yiqixueba_server_mokuai', DB::field('mokuaiid', $idm));
			}
		}
		$displayordergnew = $_GET['displayordergnew'];
		if(is_array($displayordergnew)) {
			foreach ( $displayordergnew as $k=>$v) {
				$data['displayorder'] = intval($v);
				DB::update('yiqixueba_server_mokuai_group',$data,array('groupid'=>$k));
			}
		}
		$displayordermnew = $_GET['displayordermnew'];
		if(is_array($displayordermnew)) {
			foreach ( $displayordermnew as $k=>$v) {
				$data['displayorder'] = intval($v);
				DB::update('yiqixueba_server_mokuai',$data,array('mokuaiid'=>$k));
			}
		}
		cpmsg(lang('plugin/yiqixueba_server', 'mokuai_edit_succeed'), 'action='.$this_page, 'succeed');
	}
//模块组编辑
}elseif($subop == 'groupedit'){
	if(!submitcheck('submit')) {
		$upmokuai_select = '<select name="upid"><option value="0">'.lang('plugin/yiqixueba_server','top_mokuai').'</option>';
		$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_server_mokuai_group').($groupid ? " where groupid <> ".$groupid:"")." order by displayorder asc");
		while($row = DB::fetch($query)) {
			$upmokuai_select .= '<option value="'.$row['groupid'].'" '.($group_info['upid']==$row['groupid'] ? ' selected' :'' ).'>'.$row['mokuaititle'].'</option>';
		}
		$upmokuai_select .= '</select>';
		if($group_info['mokuaiico']!='') {
			$mokuaiico = str_replace('{STATICURL}', STATICURL, $group_info['mokuaiico']);
			if(!preg_match("/^".preg_quote(STATICURL, '/')."/i", $mokuaiico) && !(($valueparse = parse_url($mokuaiico)) && isset($valueparse['host']))) {
				$mokuaiico = $_G['setting']['attachurl'].'common/'.$group_info['mokuaiico'].'?'.random(6);
			}
			$mokuaiicohtml = '<br /><label><input type="checkbox" class="checkbox" name="delete" value="yes" /> '.$lang['del'].'</label><br /><img src="'.$mokuaiico.'" width="40" height="40"/>';
		}
		showtips(lang('plugin/yiqixueba_server','mokuai_edit_tips'));
		showtableheader(lang('plugin/yiqixueba_server','other_link').'<a href="'.ADMINSCRIPT.'?action='.$this_page.'&subop=list">'.lang('plugin/yiqixueba_server','mokuai_list').'</a>');
		showtablefooter();
		showformheader($this_page.'&subop=groupedit','enctype');
		showtableheader(lang('plugin/yiqixueba_server','mokuai_edit'));
		$groupid ? showhiddenfields($hiddenfields = array('groupid'=>$groupid)) : '';
		$mokuai_dir = DISCUZ_ROOT.'source/plugin/wxq123/server/mokuai/'.$group_info['mokuainame'];
		showsetting(lang('plugin/yiqixueba_server','mokuainame'),'mokuainame',$group_info['mokuainame'],'text','',0,lang('plugin/yiqixueba_server','mokuainame_comment'),'','',true);
		showsetting(lang('plugin/yiqixueba_server','mokuaititle'),'mokuaititle',$group_info['mokuaititle'],'text','',0,lang('plugin/yiqixueba_server','mokuaititle_comment'),'','',true);
		showsetting(lang('plugin/yiqixueba_server','mokuaiico'),'mokuaiico',$group_info['mokuaiico'],'filetext','','',lang('plugin/yiqixueba_server','mokuaiico_comment').$mokuaiicohtml,'','',true);
		showsetting(lang('plugin/yiqixueba_server','top_mokuai'),'','',$upmokuai_select,'','',lang('plugin/yiqixueba_server','top_mokuai_comment'),'','',true);
		showsubmit('submit');
		showtablefooter();
		showformfooter();
	}else{
		$mokuaiico = addslashes($_POST['mokuaiico']);
		if($_FILES['mokuaiico']) {
			$upload = new discuz_upload();
			if($upload->init($_FILES['mokuaiico'], 'common') && $upload->save()) {
				$mokuaiico = $upload->attach['attachment'];
			}
		}
		if($_POST['delete'] && addslashes($_POST['mokuaiico'])) {
			$valueparse = parse_url(addslashes($_POST['mokuaiico']));
			if(!isset($valueparse['host']) && !strexists(addslashes($_POST['mokuaiico']), '{STATICURL}')) {
				@unlink($_G['setting']['attachurl'].'temp/'.addslashes($_POST['mokuaiico']));
			}
			$mokuaiico = '';
		}
		$data['mokuainame'] = htmlspecialchars(trim($_GET['mokuainame']));
		if ($groupid && DB::result_first("SELECT count(*) FROM ".DB::table('yiqixueba_server_mokuai_group')." WHERE mokuainame='".$data['mokuainame']."' and groupid <> ".$groupid)){
			cpmsg(lang('plugin/yiqixueba_server','mokuainame_err'));
		}
		$data['mokuaititle'] = htmlspecialchars(trim($_GET['mokuaititle']));
		$data['mokuaiico'] = $mokuaiico;
		$data['upid'] = intval($_GET['upid']);
		$data['level'] = intval($_GET['upid']) >0 ? (intval(DB::result_first("SELECT level FROM ".DB::table('yiqixueba_server_mokuai_group')." WHERE groupid = ".intval($_GET['upid'])))+1) : 0;
		if($groupid) {
			DB::update('yiqixueba_server_mokuai_group',$data,array('groupid'=>$groupid));
			if(!DB::result_first("describe ".DB::table('yiqixueba_server_site')." ".$data['mokuainame'])) {
				$sql = "alter table ".DB::table('yiqixueba_server_site')." add `".$data['mokuainame']."` text(0) not Null;";
				runquery($sql);
			}
		}else{
			DB::insert('yiqixueba_server_mokuai_group',$data);
		}
		cpmsg(lang('plugin/yiqixueba_server', 'mokuai_edit_succeed'), 'action='.$this_page.'&subop=list', 'succeed');
	}
//编辑模块
}elseif($subop == $subops[1]){
	if(!submitcheck('submit')) {
		$upmokuai_select = '<select name="upid"><option value="0">'.lang('plugin/yiqixueba_server','top_mokuai').'</option>';
		$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_server_mokuai')." where level=2 ".($mokuaiid ? " and mokuaiid <> ".$mokuaiid:"")." order by displayorder asc");
		while($row = DB::fetch($query)) {
			$upmokuai_select .= '<option value="'.$row['mokuaiid'].'" '.($mokuai_info['upid']==$row['mokuaiid'] ? ' selected' :'' ).'>'.str_repeat("--",$row['level']-2).$row['mokuaititle'].'</option>';
			if ($mokuaiid && $mokuai_info['upid'] == $row['mokuaiid']){
				$upmokuai = $row['mokuaititle'];
			}
		}
		$upmokuai_select .= '</select>';
		if($mokuai_info['mokuaiico']!='') {
			$mokuaiico = str_replace('{STATICURL}', STATICURL, $mokuai_info['mokuaiico']);
			if(!preg_match("/^".preg_quote(STATICURL, '/')."/i", $mokuaiico) && !(($valueparse = parse_url($mokuaiico)) && isset($valueparse['host']))) {
				$mokuaiico = $_G['setting']['attachurl'].'common/'.$mokuai_info['mokuaiico'].'?'.random(6);
			}
			$mokuaiico = '<img src="'.$mokuaiico.'" width="40" height="40"/>';
		}else{
			$mokuaiico = '';
		}

		$status_select = '<select name="status"><option value="0" '.($mokuai_info['status']==0?' selected':'').'>'.lang('plugin/yiqixueba_server','design').'</option><option value="1" '.($mokuai_info['status']==1?' selected':'').'>'.lang('plugin/yiqixueba_server','open').'</option><option value="2" '.($mokuai_info['status']==2?' selected':'').'>'.lang('plugin/yiqixueba_server','close').'</option></select>';
		showtips(lang('plugin/yiqixueba_server','mokuai_edit_tips'));
		showtableheader(lang('plugin/yiqixueba_server','other_link').'<a href="'.ADMINSCRIPT.'?action='.$this_page.'&subop='.$subops[0].'">'.lang('plugin/yiqixueba_server','mokuai_list').'</a>&nbsp;&nbsp;<a href="'.ADMINSCRIPT.'?action='.$this_page.'&subop='.$subops[2].'&mokuaiid='.$mokuaiid.'">'.lang('plugin/yiqixueba_server','versionname').'</a>');
		showtablefooter();
		showformheader($this_page.'&subop=editmokuai');
		showtableheader(lang('plugin/yiqixueba_server','mokuai_edit'));
		if ($mokuaiid){
			showhiddenfields(array('mokuaiid'=>$mokuaiid));
			showsetting(lang('plugin/yiqixueba_server','upmokuai'),'','',$upmokuai,'','','','','',true);
			showsetting(lang('plugin/yiqixueba_server','mokuainame'),'','',$mokuaiico.$mokuai_info['mokuaititle'].$group_info['mokuainame']);
		}else{
			showsetting(lang('plugin/yiqixueba_server','mokuainame'),'mokuainame',$mokuai_info['mokuainame'],'text','',0,lang('plugin/yiqixueba_server','mokuainame_comment'),'','',true);
			showsetting(lang('plugin/yiqixueba_server','upmokuai'),'','',$upmokuai_select,'','',lang('plugin/yiqixueba_server','top_mokuai_comment'),'','',true);
			showsetting(lang('plugin/yiqixueba_server','mokuaititle'),'mokuaititle',$mokuai_info['mokuaititle'],'text','',0,lang('plugin/yiqixueba_server','mokuaititle_comment'),'','',true);
		}
		showsetting(lang('plugin/yiqixueba_server','mokuaiico'),'mokuaiico',$mokuai_info['mokuaiico'],'filetext','','',lang('plugin/yiqixueba_server','mokuaiico_comment').$mokuaiicohtml,'','',true);
		showsubmit('submit');
		showtablefooter();
		showformfooter();
	}else{
		$data['groupid'] = $groupid;
		$data['mokuaipice'] =intval($_GET['mokuaipice']);
		$data['versionname'] = htmlspecialchars(trim($_GET['versionname']));
		$data['mokuaidescription'] = htmlspecialchars(trim($_GET['mokuaidescription']));
		$data['status'] = intval($_GET['status']);
		if($mokuaiid) {
			DB::update('yiqixueba_server_mokuai',$data,array('mokuaiid'=>$mokuaiid));
		}else{
			DB::insert('yiqixueba_server_mokuai',$data);
			$mokuaiid = DB::insert_id();
		}
		if($mokuaiid) {
			$mokuai_dir = DISCUZ_ROOT.'source/plugin/yiqixueba_server/source/mokuai/ver'.$mokuaiid;
			if(!is_dir($mokuai_dir)) {
				dmkdir($mokuai_dir);
				dmkdir($mokuai_dir.'/admin');
				dmkdir($mokuai_dir.'/module');
				dmkdir($mokuai_dir.'/template');
				file_put_contents($mokuai_dir.'/lang.php',"<?php\n\$mokuailang = array(\n\t''=>'',\n);\n?>");
			}
		}
		cpmsg(lang('plugin/yiqixueba_server', 'mokuai_edit_succeed'), 'action='.$this_page, 'succeed');
	}
//版本列表
}elseif($subop == $subops[2]){
	if(!submitcheck('submit')) {
		$mokuaiico = '';
		if($mokuai_info['mokuaiico']!='') {
			$mokuaiico = str_replace('{STATICURL}', STATICURL, $mokuai_info['mokuaiico']);
			if(!preg_match("/^".preg_quote(STATICURL, '/')."/i", $mokuaiico) && !(($valueparse = parse_url($mokuaiico)) && isset($valueparse['host']))) {
				$mokuaiico = $_G['setting']['attachurl'].'common/'.$mokuai_info['mokuaiico'].'?'.random(6);
			}
			$mokuaiico = '<img src="'.$mokuaiico.'" width="40" height="40"/>';
		}else{
			$mokuaiico = '';
		}

		showtips(lang('plugin/yiqixueba_server','mokuaiver_list_tips'));
		showformheader($this_page.'&subop='.$subops[2]);
		showtableheader(lang('plugin/yiqixueba_server','mokuai_info'));
		echo '<tr><td>'.$mokuaiico.$mokuai_info['mokuaititle'].'（'.$mokuai_info['mokuainame'].'）&nbsp;&nbsp;'.lang('plugin/yiqixueba_server','upmokuai').':'. DB::result_first("SELECT mokuaititle FROM ".DB::table('yiqixueba_server_mokuai')." WHERE mokuainame='".$mokuai_info['upmokuai']."'").'&nbsp;&nbsp;'.lang('plugin/yiqixueba_server','other_link').'<a href="'.ADMINSCRIPT.'?action='.$this_page.'&subop='.$subops[0].'">'.lang('plugin/yiqixueba_server','mokuai_list').'</a>&nbsp;&nbsp;<a href="'.ADMINSCRIPT.'?action='.$this_page.'&subop='.$subops[1].'&mokuaiid='.$mokuaiid.'">'.lang('plugin/yiqixueba_server','mokuai_edit').'</a></td></tr>';
		showtablefooter();
		showtableheader(lang('plugin/yiqixueba_server','mokuaiver_list'));
		showsubtitle(array('',lang('plugin/yiqixueba_server','displayorder'),lang('plugin/yiqixueba_server','mokuaiico'),lang('plugin/yiqixueba_server','mokuaititle'),  lang('plugin/yiqixueba_server','upmokuai'), ''));
		$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_server_mokuaiver')." WHERE mokuaiid = ".$mokuaiid." order by displayorder asc");
		while($row = DB::fetch($query)) {
			$mokuaiico = '';
			if($row['mokuaiico']!='') {
				$mokuaiico = str_replace('{STATICURL}', STATICURL, $row['mokuaiico']);
				if(!preg_match("/^".preg_quote(STATICURL, '/')."/i", $mokuaiico) && !(($valueparse = parse_url($mokuaiico)) && isset($valueparse['host']))) {
					$mokuaiico = $_G['setting']['attachurl'].'common/'.$row['mokuaiico'].'?'.random(6);
				}
				$mokuaiico = '<img src="'.$mokuaiico.'" width="40" height="40"/>';
			}else{
				$mokuaiico = '';
			}
			$mknum = DB::result_first("SELECT count(*) FROM ".DB::table('yiqixueba_server_mokuai')." WHERE upmokuai='".$row['mokuainame']."'");
			showtablerow('', array('class="td25"','class="td25"','class="td25"',  'class="td28"',''), array(
				($mknum ?'<a href="javascript:;" class="right" onclick="toggle_group(\'mokuai_'.$row['mokuaiid'].'\', this)">[-]</a>':'')."<input class=\"checkbox\" type=\"checkbox\" name=\"delete[]\" value=\"$row[mokuaiid]\">",
				'<input type="text" class="txt" name="displayordergnew['.$row['mokuaiid'].']" value="'.$row['displayorder'].'" size="1" />',
				$mokuaiico.'<input type="hidden" name="mokuainamenew['.$row['mokuaiid'].']" value="'.$row['mokuainame'].'">',
				$row['mokuaititle'].'('.$row['mokuainame'].')',
				$mokuais_info[$row['upid']]['mokuaititle'],
				"<a href=\"".ADMINSCRIPT."?action=$this_page&subop=editmokuai&mokuaiid=$row[mokuaiid]\" class=\"act\">".lang('plugin/yiqixueba_server','edit')."</a>&nbsp;&nbsp;<a href=\"".ADMINSCRIPT."?action=$this_page&subop=editmokuai&mokuaiid=$row[mokuaiid]\" class=\"act\">".lang('plugin/yiqixueba_server','versionname')."</a>&nbsp;&nbsp;",
			));
		}
		echo '<tr><td></td><td colspan="8"><div><a href="'.ADMINSCRIPT.'?action='.$this_page.'&subop='.$subops[3].'&mokuaiid='.$mokuaiid.'" class="addtr">'.lang('plugin/yiqixueba_server','add_ver').'</a></div></td></tr>';
		showsubmit('submit','submit','del');
		showtablefooter();
		showformfooter();
	}else{
		if($idg = $_GET['delgroup']) {
			$idg = dintval($idg, is_array($idg) ? true : false);
			if($idg) {
				DB::delete('yiqixueba_server_mokuai_group', DB::field('groupid', $idg));
				//删除站长数据表中的模块设置字段
				//$sql = "alter table ".DB::table('wxq123_site')." DROP `m_".$mokuainame."`;";
			}
		}
		if($idm = $_GET['delmokuai']) {
			$idm = dintval($idm, is_array($idm) ? true : false);
			if($idm) {
				foreach ( $idm as $k=>$v) {
					rmdirs(DISCUZ_ROOT.'source/plugin/yiqixueba_server/source/mokuai/ver'.$v.'/');
				}
				DB::delete('yiqixueba_server_mokuai', DB::field('mokuaiid', $idm));
			}
		}
		$displayordergnew = $_GET['displayordergnew'];
		if(is_array($displayordergnew)) {
			foreach ( $displayordergnew as $k=>$v) {
				$data['displayorder'] = intval($v);
				DB::update('yiqixueba_server_mokuai_group',$data,array('groupid'=>$k));
			}
		}
		$displayordermnew = $_GET['displayordermnew'];
		if(is_array($displayordermnew)) {
			foreach ( $displayordermnew as $k=>$v) {
				$data['displayorder'] = intval($v);
				DB::update('yiqixueba_server_mokuai',$data,array('mokuaiid'=>$k));
			}
		}
		cpmsg(lang('plugin/yiqixueba_server', 'mokuai_edit_succeed'), 'action='.$this_page, 'succeed');
	}

//版本编辑
}elseif($subop == $subops[3]){
	if(!submitcheck('submit')) {
		$status_select = '<select name="status"><option value="0" '.($mokuai_info['status']==0?' selected':'').'>'.lang('plugin/yiqixueba_server','design').'</option><option value="1" '.($mokuai_info['status']==1?' selected':'').'>'.lang('plugin/yiqixueba_server','open').'</option><option value="2" '.($mokuai_info['status']==2?' selected':'').'>'.lang('plugin/yiqixueba_server','close').'</option></select>';
		showtips(lang('plugin/yiqixueba_server','mokuai_edit_tips'));
		showformheader($this_page.'&subop='.$subops[3]);
		showtableheader(lang('plugin/yiqixueba_server','mokuai_info'));
		echo '<tr><td>'.$mokuaiico.$mokuai_info['mokuaititle'].'（'.$mokuai_info['mokuainame'].'）&nbsp;&nbsp;'.lang('plugin/yiqixueba_server','upmokuai').':'. DB::result_first("SELECT mokuaititle FROM ".DB::table('yiqixueba_server_mokuai')." WHERE mokuainame='".$mokuai_info['upmokuai']."'").'&nbsp;&nbsp;'.lang('plugin/yiqixueba_server','other_link').'<a href="'.ADMINSCRIPT.'?action='.$this_page.'&subop='.$subops[0].'">'.lang('plugin/yiqixueba_server','mokuai_list').'</a>&nbsp;&nbsp;<a href="'.ADMINSCRIPT.'?action='.$this_page.'&subop='.$subops[1].'&mokuaiid='.$mokuaiid.'">'.lang('plugin/yiqixueba_server','mokuai_edit').'</a></td></tr>';
		showtablefooter();
		showtableheader(lang('plugin/yiqixueba_server','mokuaiver_list'));
		showsetting(lang('plugin/yiqixueba_server','versionname'),'versionname',$mokuai_info['versionname'],'text');
		showsetting(lang('plugin/yiqixueba_server','mokuaipice'),'mokuaipice',$mokuai_info['mokuaipice'],'text');
		showsetting(lang('plugin/yiqixueba_server','mokuaidescription'),'mokuaidescription',$mokuai_info['mokuaidescription'],'textarea');
		showsetting(lang('plugin/yiqixueba_server','status'),'','',$status_select,'','',lang('plugin/yiqixueba_server','status_comment'));
		showsubmit('submit');
		showtablefooter();
		showformfooter();
	}else{
		var_dump($_POST);
	}
//页面列表
}elseif($subop == 'pagelist'){
	if(!submitcheck('submit')) {
		showtips('<li>'.lang('plugin/yiqixueba_server','edit').$group_info['mokuaititle'].'-'.$mokuai_info['versionname'].'</li>'.lang('plugin/yiqixueba_server','page_list_tips'));
		showtableheader(lang('plugin/yiqixueba_server','other_link').'<a href="'.ADMINSCRIPT.'?action='.$this_page.'&subop=list">'.lang('plugin/yiqixueba_server','mokuai_list').'</a>&nbsp;&nbsp;<a href="'.ADMINSCRIPT.'?action='.$this_page.'&subop=editmokuai&groupid='.$groupid.'">'.$group_info['mokuaititle'].lang('plugin/yiqixueba_server','mokuai_edit').'</a>');
		showtablefooter();
		showformheader($this_page.'&subop=pagelist');
		showtableheader(lang('plugin/yiqixueba_server','page_list'));
		showsubtitle(array('', lang('plugin/yiqixueba_server','displayorder'),lang('plugin/yiqixueba_server','pagename'),lang('plugin/yiqixueba_server','pagetitle'), lang('plugin/yiqixueba_server','pagetype'), lang('plugin/yiqixueba_server','pagedescription'),lang('plugin/yiqixueba_server','pageac'), ''));
		$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_server_page')." WHERE mokuai='ver".$mokuaiid."' order by displayorder asc");
		while($row = DB::fetch($query)) {
			$pageac = '';
			if ($row['pagetype']=='admin'){
				$query1 = DB::query("SELECT * FROM ".DB::table('yiqixueba_server_page_adminac')." WHERE pageid=".$row['pageid']." order by displayorder asc");
				while($row1 = DB::fetch($query1)) {
					$pageac .= $row1['adminactitle'].'<BR>';
				}
			}
			showtablerow('', array('class="td25"','class="td25"', 'class="td25"', 'class="td25"','class="td25"','class="td29"', 'class="td29"', ''), array(
				"<input class=\"checkbox\" type=\"checkbox\" name=\"delete[]\" value=\"$row[pageid]\">",
				'<input type="text" class="txt" name="displayordernew['.$row['pageid'].']" value="'.$row['displayorder'].'" size="2" />',
				//'<input type="text" name="namenew['.$row['pageid'].']" value="'.$row['filename'].'">',
				$row['filename'],
				'<input type="text" name="titlenew['.$row['pageid'].']" size="10" value="'.$row['filetitle'].'">',
				lang('plugin/yiqixueba_server',$row['pagetype']),
				'<textarea name="descriptionnew['.$row['pageid'].']" rows="3" cols="20">'.$row['pagedescription'].'</textarea>',
				$pageac,
				"<a href=\"".ADMINSCRIPT."?action=$this_page&subop=".$row['pagetype']."edit&groupid=$groupid&mokuaiid=$mokuaiid&pageid=$row[pageid]\" class=\"act\">".lang('plugin/yiqixueba_server','edit')."</a>&nbsp;&nbsp;<a href=\"".ADMINSCRIPT."?action=".$this_page."&subop=adminacedit&groupid=$groupid&mokuaiid=$mokuaiid&pageid=".$pageid."&adminacid=".$row['adminacid']."\" class=\"act\">".lang('plugin/yiqixueba_server','makemokuai')."</a>"
			));
		}
		echo '<tr><td></td><td colspan="8"><div><a href="###" onclick="addrow(this, 0);" class="addtr">'.lang('plugin/yiqixueba_server','add_page').'</a><input type="hidden" name="mokuaiid" value="'.$mokuaiid.'"><input type="hidden" name="groupid" value="'.$groupid.'"></div></td></tr>';
		showsubmit('submit','submit','del');
		showtablefooter();
		showformfooter();
		$type_select = '<select name="newtype[]">';
		foreach ( $page_type_array as $k=>$v) {
			$type_select .= '<option value="'.$v.'">'.lang('plugin/yiqixueba_server',$v).'</option>';
		}
		$type_select .='</select>';
		echo <<<EOT
<script type="text/JavaScript">
	var rowtypedata = [
		[[1,''], [1,'<input name="newdisplayorder[]" type="text" class="txt" value="0">','td25'], [1, '<input name="newname[]" type="text" class="txt" size="10">','td25'], [1, '<input name="newtitle[]" type="text" class="txt" size="10">','td25'],[1,'$type_select','td25'],[1, '<textarea name="newdescription[]" rows="3" cols="20"></textarea>','td23'],[2,''],],
	];
	</script>
EOT;
	}else{
		if(getgpc('newname')) {
			$newdisplayorder = getgpc('newdisplayorder');
			$newtype = getgpc('newtype');
			$newtitle = getgpc('newtitle');
			$newdescription = getgpc('newdescription');
			foreach ( getgpc('newname') as $k=>$v) {
				if(DB::result_first("SELECT count(*) FROM ".DB::table('yiqixueba_server_page')." WHERE mokuai=".$mokuaiid."  and filename ='".trim($v)."' and pagetype = '".trim($newtype[$k])."'")) {
					cpmsg(lang('plugin/yiqixueba_server', 'page_edit_error'));
				}else{
					$data['mokuai'] = 'ver'.$mokuaiid;
					$data['pagetype'] = trim($newtype[$k]);
					$data['filename'] = trim($v);
					$data['filetitle'] = trim($newtitle[$k]);
					$data['displayorder'] = trim($newdisplayorder[$k]);
					$data['pagedescription'] = trim($newdescription[$k]);
					$data['status'] = 0;
					DB::insert('yiqixueba_server_page',$data);
				}
			}
		}
		if($ids = $_GET['delete']) {
			$ids = dintval($ids, is_array($ids) ? true : false);
			if($ids) {
				foreach ( $ids as $k=>$v) {
					//rmdirs(DISCUZ_ROOT.'source/plugin/yiqixueba_server/source/mokuai/ver'.$v.'/');
				}
				DB::delete('yiqixueba_server_page', DB::field('pageid', $ids));
			}
		}
		$data = array();
		$displayordernew = $_GET['displayordernew'];
		//$filenamenew = $_GET['namenew'];
		$filetitlenew = $_GET['titlenew'];
		$descriptionnew = $_GET['descriptionnew'];
		if(is_array($displayordernew)) {
			foreach ( $displayordernew as $k=>$v) {
				$data['displayorder'] = intval($v);
				//$data['filename'] = trim($filenamenew[$k]);
				$data['filetitle'] = trim($filetitlenew[$k]);
				$data['pagedescription'] = trim($descriptionnew[$k]);
				DB::update('yiqixueba_server_page',$data,array('pageid'=>$k));
			}
		}
		cpmsg($group_info['mokuaititle'].'-'.$mokuai_info['versionname'].lang('plugin/yiqixueba_server', 'page_edit_succeed'), 'action='.$this_page.'&subop=pagelist&mokuaiid='.$mokuaiid.'&groupid='.$groupid, 'succeed');
	}
//编辑页面
}elseif($subop == 'pageedit'){
	$pageid = intval(getgpc('pageid'));
	$page_info = DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_server_page')." WHERE pageid='".$pageid."'");
	var_dump($pageid);
	if(!submitcheck('submit')) {
		showtips('<li>'.lang('plugin/yiqixueba_server','edit').'&nbsp;&nbsp;'.$group_info['mokuaititle'].'-'.$mokuai_info['versionname'].'&nbsp;&nbsp;'.lang('plugin/yiqixueba_server','pagename').'('.$page_info['filename'].')&nbsp;&nbsp;'.lang('plugin/yiqixueba_server','pagetitle').'('.$page_info['filetitle'].')&nbsp;&nbsp;'.lang('plugin/yiqixueba_server','pagetype').'('.lang('plugin/yiqixueba_server',$page_info['pagetype']).')</li>'.lang('plugin/yiqixueba_server','page_edit_tips'));
		showformheader($this_page.'&subop=pageedit');
		showtableheader(lang('plugin/yiqixueba_server','page_edit'));
		showhiddenfields(array('mokuaiid'=>$mokuaiid,'groupid'=>$groupid,'pageid'=>$pageid));
		if($page_info['pagetype'] =='admin') {
		}elseif($page_info['pagetype'] =='hook') {
		}elseif($page_info['pagetype'] =='hook') {
		}elseif($page_info['pagetype'] =='hook') {
		}elseif($page_info['pagetype'] =='hook') {
		}
		showsubmit('submit');
		showtablefooter();
		showformfooter();
	}else{
		if(DB::result_first("SELECT count(*) FROM ".DB::table('yiqixueba_server_page')." WHERE mokuai=".$mokuaiid."  and filename='".trim(getgpc('pagename'))."' and pagetype = '".trim($newtype[$k])."' and pageid <>".$pageid)) {
			cpmsg(lang('plugin/yiqixueba_server', 'page_edit_error'));
		}
		$data['menu'] = trim(getgpc('menunew')) ? trim(getgpc('menunew')) : trim(getgpc('menu'));
		$data['filename'] = trim(getgpc('pagename'));
		$data['filetitle'] = trim(getgpc('pagetitle'));
		$data['pagedescription'] = trim(getgpc('pagedescription'));
		$data['pagecontents'] = htmlspecialchars(trim(getgpc('pagecontents')));
		$data['status'] = trim(getgpc('status'));
		DB::update('yiqixueba_server_page',$data,array('pageid'=>$pageid));
		$file_name = DISCUZ_ROOT.'source/plugin/yiqixueba_server/source/mokuai/ver'.$mokuaiid.'/'.trim(getgpc('pagetype')).'/'.$data['filename'].'.php';
		if(trim(getgpc('pagetype')=='admin')) {
			$file_header = "<?php\n\n/**\n*\t一起学吧平台程序\n*\t".$data['filetitle']."\n*\n文件名：".$data['filename'].".php  创建时间：".dgmdate(time(),'dt')."  杨文\n*\n*/\n\nif(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {\n\texit('Access Denied');\n}\n";
			file_put_contents($file_name, $file_header.htmlspecialchars_decode($data['pagecontents'])."\n?>");
		}elseif(trim(getgpc('pagetype')=='module')) {






		}
		cpmsg($group_info['mokuaititle'].'-'.$mokuai_info['versionname'].lang('plugin/yiqixueba_server', 'page_edit_succeed'), 'action='.$this_page.'&subop=pagelist&mokuaiid='.$mokuaiid.'&groupid='.$groupid, 'succeed');
	}
//模块设计
}elseif($subop == 'makemokuai'){
	if(!submitcheck('submit')) {
		showtips(lang('plugin/yiqixueba_server','edit').$group_info['mokuaititle'].$mokuai_info['versionname']);
		showformheader($this_page.'&subop=designmokuai');
		showtableheader();
		showsubtitle(array('', lang('plugin/yiqixueba_server','displayorder'),lang('plugin/yiqixueba_server','filename'), lang('plugin/yiqixueba_server','menu'), lang('plugin/yiqixueba_server','type'), lang('plugin/yiqixueba_server','description'),lang('plugin/yiqixueba_server','status'), ''));
		$admin_dir = DISCUZ_ROOT.'source/plugin/wxq123/server/mokuai/ver'.$mokuaiid.'/admin/';
		$admin_file_array = read_file($admin_dir);
		//var_dump($admin_file_array);
		showtagheader('tbody', 'admin', true);
		showtagfooter('tbody');
		showtablefooter();
		showtableheader(lang('plugin/yiqixueba_server','mokuai_admin'));
		echo '<tr><td></td><td colspan="7"><div><a href="'.ADMINSCRIPT.'?action=$this_page&subop=adminedit&groupid='.$groupid.'&mokuaiid='.$mokuaiid.'" class="addtr">'.lang('plugin/yiqixueba_server','add_admin').'</a></div></td></tr>';
		showtablefooter();
		showtableheader(lang('plugin/yiqixueba_server','mokuai_module'));
		echo '<tr><td></td><td colspan="7"><div><a href="'.ADMINSCRIPT.'?action=$this_page&subop=moduleedit&groupid='.$groupid.'&mokuaiid='.$mokuaiid.'" class="addtr">'.lang('plugin/yiqixueba_server','add_module').'</a></div></td></tr>';
		showtablefooter();
		showtableheader(lang('plugin/yiqixueba_server','mokuai_template'));
		echo '<tr><td></td><td colspan="7"><div><a href="'.ADMINSCRIPT.'?action=$this_page&subop=templateedit&groupid='.$groupid.'&mokuaiid='.$mokuaiid.'" class="addtr">'.lang('plugin/yiqixueba_server','add_template').'</a></div></td></tr>';
		showsubmit('submit','submit','del');
		showformfooter();
	}else{
	}
//后台页面分支列表
}elseif($subop == 'adminedit'){
	$pageid = intval(getgpc('pageid'));
	$page_info = DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_server_page')." WHERE pageid='".$pageid."'");
	if(!submitcheck('submit')) {
		showtips('<li>'.lang('plugin/yiqixueba_server','edit').'&nbsp;&nbsp;'.$group_info['mokuaititle'].'-'.$mokuai_info['versionname'].'&nbsp;&nbsp;'.lang('plugin/yiqixueba_server','pagename').'('.$page_info['filename'].')&nbsp;&nbsp;'.lang('plugin/yiqixueba_server','pagetitle').'('.$page_info['filetitle'].')&nbsp;&nbsp;'.lang('plugin/yiqixueba_server','pagetype').'('.lang('plugin/yiqixueba_server',$page_info['pagetype']).')</li>');
		showtableheader(lang('plugin/yiqixueba_server','other_link').'<a href="'.ADMINSCRIPT.'?action='.$this_page.'&subop=list">'.lang('plugin/yiqixueba_server','mokuai_list').'</a>&nbsp;&nbsp;<a href="'.ADMINSCRIPT.'?action='.$this_page.'&subop=editmokuai&groupid='.$groupid.'">'.$group_info['mokuaititle'].lang('plugin/yiqixueba_server','mokuai_edit').'</a>&nbsp;&nbsp;<a href="'.ADMINSCRIPT.'?action='.$this_page.'&subop=pagelist&groupid='.$groupid.'&mokuaiid='.$mokuaiid.'">'.$group_info['mokuaititle'].'-'.$mokuai_info['versionname'].lang('plugin/yiqixueba_server','page_list').'</a>');
		showtablefooter();
		showformheader($this_page.'&subop=adminedit&groupid='.$groupid.'&mokuaiid='.$mokuaiid.'&pageid='.$pageid);
		showtableheader(lang('plugin/yiqixueba_server','page_list'));
		showsubtitle(array('', lang('plugin/yiqixueba_server','displayorder'),lang('plugin/yiqixueba_server','acname'),lang('plugin/yiqixueba_server','actitle'), lang('plugin/yiqixueba_server','actype'), lang('plugin/yiqixueba_server','status'), ''));
		$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_server_page_adminac')." WHERE pageid=".$pageid." order by displayorder asc");
		while($row = DB::fetch($query)) {
		showtablerow('', array('class="td25"','class="td25"', 'class="td23"', 'class="td23"','class="td23"','class="td29"', 'class="td29"', 'class="td25"',''), array(
				"<input class=\"checkbox\" type=\"checkbox\" name=\"delete[]\" value=\"$row[adminacid]\">",
				'<input type="text" class="txt" name="displayordernew['.$row['adminacid'].']" value="'.$row['displayorder'].'" size="2" />',
				//'<input type="text" name="namenew['.$row['pageid'].']" value="'.$row['filename'].'">',
				$row['adminacname'],
				'<input type="text" name="adminactitlenew['.$row['adminacid'].']" value="'.$row['adminactitle'].'">',
				lang('plugin/yiqixueba_server','ac_'.$row['adminactype']),
				$pageac,
				$row['status'] == 0 ? lang('plugin/yiqixueba_server','close') :lang('plugin/yiqixueba_server','open'),
				"<a href=\"".ADMINSCRIPT."?action=".$this_page."&subop=adminacedit&groupid=$groupid&mokuaiid=$mokuaiid&pageid=".$pageid."&adminacid=".$row['adminacid']."\" class=\"act\">".lang('plugin/yiqixueba_server','edit')."</a>"
			));
		}
		echo '<tr><td></td><td colspan="8"><div><a href="###" onclick="addrow(this, 0);" class="addtr">'.lang('plugin/yiqixueba_server','add_pageac').'</a><input type="hidden" name="pageid" value="'.$pageid.'"></div></td></tr>';
		showsubmit('submit','submit','del');
		showtablefooter();
		showformfooter();
		$adminac_select = '<select name="newtype[]">';
		foreach ( $adminacs as $k=>$v) {
			$adminac_select .= '<option value="'.$v.'">'.lang('plugin/yiqixueba_server','ac_'.$v).'</option>';
		}
		$adminac_select .='</select>';
		echo <<<EOT
<script type="text/JavaScript">
	var rowtypedata = [
		[[1,''], [1,'<input name="newdisplayorder[]" type="text" class="txt" value="0">','td25'], [1, '<input name="newname[]" type="text" class="txt">','td23'], [1, '<input name="newtitle[]" type="text" class="txt">','td23'],[1,'$adminac_select','td23'],[2,''],],
	];
	</script>
EOT;
	}else{
		if(getgpc('newname')) {
			$newdisplayorder = getgpc('newdisplayorder');
			$newtype = getgpc('newtype');
			$newtitle = getgpc('newtitle');
			$newdescription = getgpc('newdescription');
			foreach ( getgpc('newname') as $k=>$v) {
				if(DB::result_first("SELECT count(*) FROM ".DB::table('yiqixueba_server_page_adminac')." WHERE  adminacname ='".trim($v)."' and pageid = ".$pageid)) {
					cpmsg(lang('plugin/yiqixueba_server', 'page_edit_error'));
				}else{
					$data['pageid'] = $pageid;
					$data['adminactype'] = trim($newtype[$k]);
					$data['adminacname'] = trim($v);
					$data['adminactitle'] = trim($newtitle[$k]);
					$data['displayorder'] = trim($newdisplayorder[$k]);
					DB::insert('yiqixueba_server_page_adminac',$data);
				}
			}
		}
		cpmsg($group_info['mokuaititle'].'-'.$mokuai_info['versionname'].lang('plugin/yiqixueba_server', 'page_edit_succeed'), 'action='.$this_page.'&subop=adminedit&groupid='.$groupid.'&mokuaiid='.$mokuaiid.'&pageid='.$pageid, 'succeed');
	}
//后台页面分支编辑
}elseif($subop == 'adminacedit'){
	$pageid = intval(getgpc('pageid'));
	$page_info = DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_server_page')." WHERE pageid='".$pageid."'");
	$adminacid = intval(getgpc('adminacid'));
	$adminacs = DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_server_page_adminac')." WHERE adminacid='".$adminacid."'");
	$adminac_info = dunserialize($adminacs['adminacrule']);
	if(!submitcheck('submit')) {
		showtips(lang('plugin/yiqixueba_server','adminac_edit_tips'));
		showtableheader(lang('plugin/yiqixueba_server','other_link').'<a href="'.ADMINSCRIPT.'?action='.$this_page.'&subop=list">'.lang('plugin/yiqixueba_server','mokuai_list').'</a>&nbsp;&nbsp;<a href="'.ADMINSCRIPT.'?action='.$this_page.'&subop=editmokuai&groupid='.$groupid.'">'.$group_info['mokuaititle'].lang('plugin/yiqixueba_server','mokuai_edit').'</a>&nbsp;&nbsp;<a href="'.ADMINSCRIPT.'?action='.$this_page.'&subop=pagelist&groupid='.$groupid.'&mokuaiid='.$mokuaiid.'">'.$group_info['mokuaititle'].'-'.$mokuai_info['versionname'].lang('plugin/yiqixueba_server','page_list').'</a>&nbsp;&nbsp;<a href="'.ADMINSCRIPT.'?action='.$this_page.'&subop=adminedit&groupid='.$groupid.'&mokuaiid='.$mokuaiid.'&pageid='.$pageid.'">'.$page_info['filename'].lang('plugin/yiqixueba_server','page_list').'</a>');
		showtablefooter();
		showformheader($this_page.'&subop=adminacedit');
		showtableheader(lang('plugin/yiqixueba_server','adminac_edit'));
		showhiddenfields(array('pageid'=>$pageid,'adminacid'=>$adminacid));
		showsetting(lang('plugin/yiqixueba_server','page_tips'),'rules[page_tips]',$adminac_info['page_tips'],'textarea','',0,lang('plugin/yiqixueba_server','page_tips_comment'),'','',true);;
		showsetting(lang('plugin/yiqixueba_server','global_link'),'rules[globallink]',$adminac_info['globallink'],'textarea','',0,lang('plugin/yiqixueba_server','global_link_comment'),'','',true);
		if ($adminacs['adminactype'] == 'datalist'){
			showsetting(lang('plugin/yiqixueba_server','searchfield'),'rules[searchfield]',$adminac_info['searchfield'],'textarea','',0,lang('plugin/yiqixueba_server','searchfield_comment'),'','',true);
			showsetting(lang('plugin/yiqixueba_server','tablename'),'rules[tablename]',$adminac_info['tablename'],'text','',0,lang('plugin/yiqixueba_server','tablename_comment'),'','',true);
			showsetting(lang('plugin/yiqixueba_server','fieldinfo'),'rules[fieldinfo]',$adminac_info['fieldinfo'],'textarea','',0,lang('plugin/yiqixueba_server','fieldinfo_comment'),'','',true);
			showsetting(lang('plugin/yiqixueba_server','listheader'),'rules[listheader]',$adminac_info['listheader'],'text','',0,lang('plugin/yiqixueba_server','listheader_comment'),'','',true);
			showsetting(lang('plugin/yiqixueba_server','listinfo'),'rules[listinfo]',$adminac_info['listinfo'],'textarea','',0,lang('plugin/yiqixueba_server','listinfo_comment'),'','',true);
			showsetting(lang('plugin/yiqixueba_server','listlink'),'rules[listlink]',$adminac_info['listlink'],'textarea','',0,lang('plugin/yiqixueba_server','listlink_comment'),'','',true);
			showsetting(lang('plugin/yiqixueba_server','prepage'),'rules[prepage]',$adminac_info['prepage'],'radio','',0,lang('plugin/yiqixueba_server','prepage_comment'),'','',true);
			showsetting(lang('plugin/yiqixueba_server','listdel'),'rules[listdel]',$adminac_info['listdel'],'radio','',0,lang('plugin/yiqixueba_server','listdel_comment'),'','',true);
		}
		showsubmit('submit');
		showtablefooter();
		showformfooter();
	}else{
		$data = array();
		$data = serialize($_POST['rules']);
		DB::update('yiqixueba_server_page_adminac',array('adminacrule'=>$data),array('adminacid'=>$adminacid));
		cpmsg($group_info['mokuaititle'].'-'.$mokuai_info['versionname'].lang('plugin/yiqixueba_server', 'page_edit_succeed'), 'action='.$this_page.'&subop=adminedit&groupid='.$groupid.'&mokuaiid='.$mokuaiid.'&pageid='.$pageid, 'succeed');
	}
//前台页面
}elseif($subop == 'moduleedit'){
	if(!submitcheck('submit')) {
		showtips(lang('plugin/yiqixueba_server','edit').$group_info['mokuaititle'].$mokuai_info['versionname'].lang('plugin/yiqixueba_server','mokuai_module').$filename);
		showformheader($this_page.'&subop=moduleedit&groupid='.$groupid.'&mokuaiid='.$mokuaiid);
		showtableheader(lang('plugin/yiqixueba_server','mokuai_module'));
		showsubmit('submit');
		showformfooter();
	}else{
	}
//模版页面
}elseif($subop == 'templateedit'){
	if(!submitcheck('submit')) {
		showtips(lang('plugin/yiqixueba_server','edit').$group_info['mokuaititle'].$mokuai_info['versionname'].lang('plugin/yiqixueba_server','mokuai_template'.$filename));
		showformheader($this_page.'&subop=adminedit&groupid='.$groupid.'&mokuaiid='.$mokuaiid);
		showtableheader(lang('plugin/yiqixueba_server','mokuai_template'));
		showsubmit('submit');
		showformfooter();
	}else{
	}
//设置、商家、产品页面
}elseif(in_array($subop,array('setting','shop','goods'))){
	$mokuainame = 'ver'.$mokuaiid;
	$adminfile = DISCUZ_ROOT.'source/plugin/wxq123/server/mokuai/ver'.$mokuaiid.'/admin/'.$subop.'.php';
	if (!file_exists($adminfile)){
		file_put_contents($adminfile,"<?php\n\n?>");
	}
	$basepage = $this_page.'&subop='.$subop.'&groupid='.$groupid.'&mokuaiid='.$mokuaiid;
	require_once DISCUZ_ROOT.'source/plugin/wxq123/server/mokuai/ver'.$mokuaiid.'/lang.php';
	//require_once DISCUZ_ROOT.'source/plugin/wxq123/server/mokuai/ver'.$mokuaiid.'/install.php';
	echo $group_info['mokuaititle'].$mokuai_info['versionname'].'--'.lang('plugin/yiqixueba_server','mokuai_admin').'--'.lang('plugin/yiqixueba_server','mokuai_'.$subop).'&nbsp;&nbsp;&nbsp;&nbsp;<a href="'.ADMINSCRIPT.'?action='.$basepage.'">'.lang('plugin/yiqixueba_server','shuaxin').'</a>';
	require_once $adminfile;
}
//
function getupmenu($menutype,$menuvalue) {
	$query = DB::query("SELECT menu FROM ".DB::table('yiqixueba_server_page')." WHERE pagetype='".$menutype."' group by menu");
	$return = '<select name="">';
	while($row = DB::fetch($query)) {
		$return .= '<option value="'.$row['menu'].'" '.($menuvalue ==$row['menu'] ? ' selected' : '').'>'.$row['menu'].'</option>';
	}
	$return .= '</select>';
	return $return;
}//end func

function rmdirs($srcdir) {
	$dir = @opendir($srcdir);
	while($entry = @readdir($dir)) {
		$file = $srcdir.$entry;
		if($entry != '.' && $entry != '..') {
			if(is_dir($file)) {
				rmdirs($file.'/');
			} else {
				@unlink($file);
			}
		}
	}
	closedir($dir);
	rmdir($srcdir);
}

function array_sort($arr, $keys, $type = 'desc') {
    $keysvalue = $new_array = array();
    foreach ($arr as $k => $v) {
        $keysvalue[$k] = $v[$keys];
    }
    if ($type == 'asc') {
        asort($keysvalue);
    } else {
        arsort($keysvalue);
    }
    reset($keysvalue);
    foreach ($keysvalue as $k => $v) {
        $new_array[$k] = $arr[$k];
    }
    return $new_array;
}
?>