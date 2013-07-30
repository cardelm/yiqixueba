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

//页面的不同功能数组
$page_type_array = array('admin','module','ajax','api','hook','member');

//页面类型
$pagetype = trim($_GET['pagetype']);


//得到subop
$subop = getgpc('subop');
$subops = array('mokuailist','mokuaiedit','mokuaiverlist','mokuaiveredit','pagelist','pageedit','codelist','codeedit','fenzhilist','fenzhiedit');
foreach ( $page_type_array as $v) {
	$subops[] = $v.'pageedit';
}
$subop = in_array($subop,$subops) ? $subop : $subops[0];

//获取模块信息
$mokuaiid = getgpc('mokuaiid');
$mokuai_info = $mokuaiid ? DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_server_mokuai')." WHERE mokuaiid=".$mokuaiid) : array();

//获取常用代码段信息
$codeid = getgpc('codeid');
$code_info = $codeid ? DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_server_code')." WHERE codeid=".$codeid) : array();


//获取模块版本信息
$verid = getgpc('verid');
$ver_info = $verid ? DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_server_mokuaiver')." WHERE verid=".$verid) : array();


//
$adminacs = array('setting','datalist','dataedit');

//获取模块基本信息，每增加一个模块，就相应地建立第一个版本
$mokuai_info_array = $mokuaiver_info_array = array();
$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_server_mokuai'));
while($row = DB::fetch($query)) {
	$mokuai_info_array[$row['mokuaiid']] = $row;
	if(DB::result_first("SELECT count(*) FROM ".DB::table('yiqixueba_server_mokuaiver')." WHERE mokuaiid=".$row['mokuaiid'])==0) {
		$data = array();
		$data['mokuaiid'] = $row['mokuaiid'];
		$data['versionname'] = 'V1.0';
		$data['mokuaidescription'] = '';
		$data['mokuaipice'] = 200;
		$data['displayorder'] = 0;
		$data['status'] = 0;
		DB::insert('yiqixueba_server_mokuaiver',$data);
	}
	$data = array();
	$data['mokuaiver'] = DB::result_first("SELECT verid FROM ".DB::table('yiqixueba_server_mokuaiver')." WHERE mokuaiid=".$row['mokuaiid']);
	DB::update('yiqixueba_server_mokuai',$data,array('mokuaiid'=>$row['mokuaiid']));
}
$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_server_mokuaiver')." order by displayorder asc");
while($row = DB::fetch($query)) {
	$mokuaiver_info_array[$row['verid']] = $row;
}

//其他链接初始化
$other_links = '';
foreach ( $subops as $v) {
	if(strpos($v,'list')) {
		$other_links .= '<a href="'.ADMINSCRIPT.'?action='.$this_page.'&subop='.$v.'">'.lang('plugin/yiqixueba_server',($subop==$v ? 'myself_page':$v)).'</a>&nbsp;&nbsp;';
	}
}
////////




//模块列表
if($subop == 'mokuailist') {
	if(!submitcheck('submit')) {
		showtips(lang('plugin/yiqixueba_server','mokuailist_tips'));
		showformheader($this_page.'&subop=mokuailist');
		showtableheader(lang('plugin/yiqixueba_server','other_link').$other_links);
		showtablefooter();
		showtableheader(lang('plugin/yiqixueba_server','mokuailist'));
		showsubtitle(array('', lang('plugin/yiqixueba_server','displayorder'),lang('plugin/yiqixueba_server','mokuaiico'), lang('plugin/yiqixueba_server','mokuaititle'), lang('plugin/yiqixueba_server','mokuaidescription'),lang('plugin/yiqixueba_server','status'),lang('plugin/yiqixueba_server','versionname'),''));
		$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_server_mokuai')." WHERE level <3 order by displayorder desc");
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
			$mknum = DB::result_first("SELECT count(*) FROM ".DB::table('yiqixueba_server_mokuai')." WHERE upid=".$row['mokuaiid']." and level = 3");
			showtablerow('', array('class="td25"','class="td25"', 'class="td25"', 'class="td29"','class="td28"',''), array(
				($mknum ?'<a href="javascript:;" class="right" onclick="toggle_group(\'mokuai_'.$row['mokuaiid'].'\', this)">[-]</a>':'')."<input class=\"checkbox\" type=\"checkbox\" name=\"delgroup[]\" value=\"$row[mokuaiid]\">",
				'<input type="text" class="txt" name="displayordergnew['.$row['mokuaiid'].']" value="'.$row['displayorder'].'" size="1" />',
				$mokuaiico,
				'<a href="'.ADMINSCRIPT.'?action='.$this_page.'&subop=mokuaiedit&mokuaiid='.$row['mokuaiid'].'">'.$row['mokuaititle'].'</a>('.$row['mokuainame'].')&nbsp;&nbsp;'.($row['level']==2 ? ('<a href="'.ADMINSCRIPT.'?action='.$this_page.'&subop=mokuaiedit&upid='.$row['mokuaiid'].'&level=3"  class="addchildboard">'.lang('plugin/yiqixueba_server','add_ver').'</a>') : ''),
				$row['mokuaidescription'],
				$row['status'] == 0 ? lang('plugin/yiqixueba_server','designing') :($row['status'] == 1 ? lang('plugin/yiqixueba_server','open') :lang('plugin/yiqixueba_server','close')),
				"<a href=\"".ADMINSCRIPT."?action=$this_page&subop=pagelist&mokuaiid=$row[mokuaiid]\" class=\"act\">".lang('plugin/yiqixueba_server','page')."</a>&nbsp;&nbsp;<a href=\"".ADMINSCRIPT."?action=$this_page&subop=mokuaiverlist&mokuaiid=$row[mokuaiid]\" class=\"act\">".lang('plugin/yiqixueba_server','versionname')."</a>&nbsp;&nbsp;<a href=\"".ADMINSCRIPT."?action=$this_page&subop=makemokuai&mokuaiid=$row[mokuaiid]&mokuaiid=$row1[mokuaiid]\" class=\"act\">".lang('plugin/yiqixueba_server','makemokuai')."</a>",
			));
			$query1 = DB::query("SELECT * FROM ".DB::table('yiqixueba_server_mokuai')." WHERE upid=".$row['mokuaiid']." and level = 3 order by displayorder desc");
			$kk = 0;
			showtagheader('tbody', 'mokuai_'.$row['mokuaiid'], true);
			while($row1 = DB::fetch($query1)) {
				$mokuaiico = '';
				if($row1['mokuaiico']!='') {
					$mokuaiico = str_replace('{STATICURL}', STATICURL, $row1['mokuaiico']);
					if(!preg_match("/^".preg_quote(STATICURL, '/')."/i", $mokuaiico) && !(($valueparse = parse_url($mokuaiico)) && isset($valueparse['host']))) {
						$mokuaiico = $_G['setting']['attachurl'].'common/'.$row1['mokuaiico'].'?'.random(6);
					}
					$mokuaiico = '<img src="'.$mokuaiico.'" width="40" height="40"/>';
				}else{
					$mokuaiico = '';
				}
				showtablerow('', array('class="td25"','class="td25"', 'class="td25"', 'class="td29"','class="td28"',''), array(
					"<input class=\"checkbox\" type=\"checkbox\" name=\"delmokuai[]\" value=\"$row1[mokuaiid]\">",
					'<input type="text" class="txt" name="displayordermnew['.$row1['mokuaiid'].']" value="'.$row1['displayorder'].'" size="1" />',
					$mokuaiico,
					"<div class=\"".($kk == $mknum ? 'board' : 'lastboard')."\">".'<a href="'.ADMINSCRIPT.'?action='.$this_page.'&subop=mokuaiedit&mokuaiid='.$row1['mokuaiid'].'">'.$row1['mokuaititle'].'</a>('.$row1['mokuainame'].')'."</div>",
					$row1['mokuaidescription'],
					"<a href=\"".ADMINSCRIPT."?action=$this_page&subop=pagelist&mokuaiid=$row1[mokuaiid]\" class=\"act\">".lang('plugin/yiqixueba_server','page')."</a>&nbsp;&nbsp;<a href=\"".ADMINSCRIPT."?action=$this_page&subop=mokuaiverlist&mokuaiid=$row1[mokuaiid]\" class=\"act\">".lang('plugin/yiqixueba_server','versionname')."</a>&nbsp;&nbsp;<a href=\"".ADMINSCRIPT."?action=$this_page&subop=makemokuai&mokuaiid=$row1[mokuaiid]\" class=\"act\">".lang('plugin/yiqixueba_server','makemokuai')."</a>"
				));
			}
			showtagfooter('tbody');
			$kk++;
		}
		echo '<tr><td></td><td colspan="8"><div><a href="'.ADMINSCRIPT.'?action='.$this_page.'&subop=mokuaiedit&upid=4&level=2" class="addtr">'.lang('plugin/yiqixueba_server','add_mokuai').'</a></div></td></tr>';
		showsubmit('submit','submit','del');
		showtablefooter();
		showformfooter();
	}else{
		$data = array();
		if($idg = $_GET['delgroup']) {
			$idg = dintval($idg, is_array($idg) ? true : false);
			if($idg) {
				DB::delete('yiqixueba_server_mokuai', DB::field('mokuaiid', $idg));
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
				DB::delete('yiqixueba_server_mokuaiver', DB::field('mokuaiid', $idm));
				DB::delete('yiqixueba_server_mokuai', DB::field('mokuaiid', $idm));
			}
		}
		$displayordergnew = $_GET['displayordergnew'];
		if(is_array($displayordergnew)) {
			foreach ( $displayordergnew as $k=>$v) {
				$data['displayorder'] = intval($v);
				DB::update('yiqixueba_server_mokuai',$data,array('mokuaiid'=>$k));
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
//模块编辑
}elseif($subop == 'mokuaiedit') {
	$upid = intval($_GET['upid']);
	$level = intval($_GET['level']);
	if(!submitcheck('submit')) {
		if($mokuai_info['mokuaiico']!='') {
			$mokuaiico = str_replace('{STATICURL}', STATICURL, $mokuai_info['mokuaiico']);
			if(!preg_match("/^".preg_quote(STATICURL, '/')."/i", $mokuaiico) && !(($valueparse = parse_url($mokuaiico)) && isset($valueparse['host']))) {
				$mokuaiico = $_G['setting']['attachurl'].'common/'.$mokuai_info['mokuaiico'].'?'.random(6);
			}
			$mokuaiicohtml = '<br /><label><input type="checkbox" class="checkbox" name="delete" value="yes" /> '.$lang['del'].'</label><br /><img src="'.$mokuaiico.'" width="40" height="40"/>';
		}
		showtips(lang('plugin/yiqixueba_server','mokuai_edit_tips'));
		showformheader($this_page.'&subop=mokuaiedit','enctype');
		showtableheader(lang('plugin/yiqixueba_server','other_link').$other_links);
		showtablefooter();
		showtableheader(lang('plugin/yiqixueba_server','mokuai_edit'));
		if($mokuaiid) {
			showhiddenfields(array('mokuaiid'=>$mokuaiid));
		}else{
			showhiddenfields(array('level'=>$level,'upid'=>$upid));
			showsetting(lang('plugin/yiqixueba_server','mokuainame'),'mokuainame',$mokuai_info['mokuainame'],'text','',0,lang('plugin/yiqixueba_server','mokuainame_comment'),'','',true);
		}
		showsetting(lang('plugin/yiqixueba_server','mokuaititle'),'mokuaititle',$mokuai_info['mokuaititle'],'text','',0,lang('plugin/yiqixueba_server','mokuaititle_comment'),'','',true);
		showsetting(lang('plugin/yiqixueba_server','mokuaiico'),'mokuaiico',$mokuai_info['mokuaiico'],'filetext','','',lang('plugin/yiqixueba_server','mokuaiico_comment').$mokuaiicohtml,'','',true);
		showsetting(lang('plugin/yiqixueba_server','mokuaidescription'),'mokuaidescription',$mokuai_info['mokuaidescription'],'textarea','','',lang('plugin/yiqixueba_server','mokuaidescription_comment'),'','',true);
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
		$data = array();
		if(!$mokuaiid) {
			$data['mokuainame'] = htmlspecialchars(trim($_GET['mokuainame']));
			$data['upid'] = $upid;
			$data['level'] = $level;
			$data['mokuaiico'] = $mokuaiico;
		}
		$data['mokuaititle'] = htmlspecialchars(trim($_GET['mokuaititle']));
		$data['mokuaiico'] = $mokuaiico;
		$data['mokuaidescription'] = htmlspecialchars(trim($_GET['mokuaidescription']));
		if($mokuaiid) {
			DB::update('yiqixueba_server_mokuai',$data,array('mokuaiid'=>$mokuaiid));
		}else{
			DB::insert('yiqixueba_server_mokuai',$data);
		}
		cpmsg(lang('plugin/yiqixueba_server', 'mokuai_edit_succeed'), 'action='.$this_page.'&subop=mokuailist', 'succeed');
	}
//模块版本列表
}elseif($subop == 'mokuaiverlist') {
	if(!submitcheck('submit')) {
		showtips(lang('plugin/yiqixueba_server','mokuaiverlist_tips'));
		showformheader($this_page.'&subop=mokuaiverlist');
		showtableheader(lang('plugin/yiqixueba_server','other_link').$other_links);
		echo $mokuaiid ? ('<tr><td>'.lang('plugin/yiqixueba_server','page').':'.$mokuai_info_array[$mokuaiid]['mokuaititle'].'</td></tr>'):'';

		showtablefooter();
		showtableheader(lang('plugin/yiqixueba_server','mokuaiverlist'));
		showsubtitle(array('', lang('plugin/yiqixueba_server','displayorder'),lang('plugin/yiqixueba_server','mokuaiico'), lang('plugin/yiqixueba_server','mokuaititle'), lang('plugin/yiqixueba_server','mokuaiverdescription'),lang('plugin/yiqixueba_server','status'),lang('plugin/yiqixueba_server','versionname'),''));
		foreach ( $mokuaiver_info_array as $k=>$row) {
			if($mokuaiid && $k == $mokuaiid || empty($mokuaiid)) {
				$mokuaiico = '';
				if($mokuai_info_array[$row['mokuaiid']]['mokuaiico']!='') {
					$mokuaiico = str_replace('{STATICURL}', STATICURL, $mokuai_info_array[$row['mokuaiid']]['mokuaiico']);
					if(!preg_match("/^".preg_quote(STATICURL, '/')."/i", $mokuaiico) && !(($valueparse = parse_url($mokuaiico)) && isset($valueparse['host']))) {
						$mokuaiico = $_G['setting']['attachurl'].'common/'.$mokuai_info_array[$row['mokuaiid']]['mokuaiico'].'?'.random(6);
					}
					$mokuaiico = '<img src="'.$mokuaiico.'" width="40" height="40"/>';
				}else{
					$mokuaiico = '';
				}
				showtablerow('', array('class="td25"','class="td25"', 'class="td25"', 'class="td29"','class="td28"',''), array(
					"<input class=\"checkbox\" type=\"checkbox\" name=\"delete[]\" value=\"$row[verid]\">",
					'<input type="text" class="txt" name="displayordergnew['.$row['verid'].']" value="'.$row['displayorder'].'" size="1" />',
					$mokuaiico,
					'<a href="'.ADMINSCRIPT.'?action='.$this_page.'&subop=mokuaiveredit&verid='.$row['verid'].'">'.$mokuai_info_array[$row['mokuaiid']]['mokuaititle'].'</a>('.$mokuai_info_array[$row['mokuaiid']]['mokuainame'].')-'.$row['versionname'],
					$row['mokuaidescription'],
					$row['status'] == 0 ? lang('plugin/yiqixueba_server','designing') :($row['status'] == 1 ? lang('plugin/yiqixueba_server','open') :lang('plugin/yiqixueba_server','close')),
					"<a href=\"".ADMINSCRIPT."?action=$this_page&subop=mokuaiveredit&verid=$row[verid]\" class=\"act\">".lang('plugin/yiqixueba_server','edit')."</a>&nbsp;&nbsp;",
				));
			}
		}
		echo '<tr><td></td><td colspan="8"><div><a href="'.ADMINSCRIPT.'?action='.$this_page.'&subop=mokuaiveredit" class="addtr">'.lang('plugin/yiqixueba_server','add_ver').'</a></div></td></tr>';
		showsubmit('submit','submit','del');
		showtablefooter();
		showformfooter();
	}else{
		if($idg = $_GET['delgroup']) {
			$idg = dintval($idg, is_array($idg) ? true : false);
			if($idg) {
				DB::delete('yiqixueba_server_mokuai', DB::field('mokuaiid', $idg));
				//删除站长数据表中的模块设置字段
				//$sql = "alter table ".DB::table('wxq123_site')." DROP `m_".$mokuainame."`;";
			}
		}
		if($idm = $_GET['delete']) {
			$idm = dintval($idm, is_array($idm) ? true : false);
			if($idm) {
				foreach ( $idm as $k=>$v) {
					rmdirs(DISCUZ_ROOT.'source/plugin/yiqixueba_server/source/mokuai/ver'.$v.'/');
				}
				DB::delete('yiqixueba_server_mokuaiver', DB::field('verid', $idm));
			}
		}
		$data = array();
		$displayordergnew = $_GET['displayordergnew'];
		if(is_array($displayordergnew)) {
			foreach ( $displayordergnew as $k=>$v) {
				$data['displayorder'] = intval($v);
				DB::update('yiqixueba_server_mokuaiver',$data,array('verid'=>$k));
			}
		}
		$displayordermnew = $_GET['displayordermnew'];
		if(is_array($displayordermnew)) {
			foreach ( $displayordermnew as $k=>$v) {
				$data['displayorder'] = intval($v);
				DB::update('yiqixueba_server_mokuaiver',$data,array('mokuaiid'=>$k));
			}
		}
		cpmsg(lang('plugin/yiqixueba_server', 'mokuai_edit_succeed'), 'action='.$this_page.'&subop=mokuaiverlist', 'succeed');
	}
//编辑模块版本
}elseif($subop == 'mokuaiveredit') {
	if(!submitcheck('submit')) {
		$mokuai_select = '<select name="mokuaiverid">';
		$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_server_mokuai')." where level>1 order by displayorder asc");
		while($row = DB::fetch($query)) {
			$mokuai_select .= '<option value="'.$row['mokuaiid'].'">'.($row['level']==3 ?$mokuai_info_array[$mokuai_info_array[$row['mokuaiid']]['upid']]['mokuaititle'].'--':'').$row['mokuaititle'].'</option>';
		}
		$mokuai_select .= '</select>';
		if($mokuai_info['mokuaiico']!='') {
			$mokuaiico = str_replace('{STATICURL}', STATICURL, $mokuai_info['mokuaiico']);
			if(!preg_match("/^".preg_quote(STATICURL, '/')."/i", $mokuaiico) && !(($valueparse = parse_url($mokuaiico)) && isset($valueparse['host']))) {
				$mokuaiico = $_G['setting']['attachurl'].'common/'.$mokuai_info['mokuaiico'].'?'.random(6);
			}
			$mokuaiicohtml = '<br /><label><input type="checkbox" class="checkbox" name="delete" value="yes" /> '.$lang['del'].'</label><br /><img src="'.$mokuaiico.'" width="40" height="40"/>';
		}
		showtips(lang('plugin/yiqixueba_server','mokuai_edit_tips'));
		showformheader($this_page.'&subop=mokuaiveredit','enctype');
		showtableheader(lang('plugin/yiqixueba_server','other_link').$other_links);
		showtablefooter();
		showtableheader(lang('plugin/yiqixueba_server','mokuai_edit'));
		if($verid) {
			showhiddenfields(array('verid'=>$verid));
		}else{
			showsetting(lang('plugin/yiqixueba_server','mokuainame'),'','',$mokuai_select,'','',lang('plugin/yiqixueba_server','mokuainame_comment'),'','',true);
		}
		showsetting(lang('plugin/yiqixueba_server','versionname'),'versionname',$ver_info['versionname'],'text','',0,lang('plugin/yiqixueba_server','versionname_comment'),'','',true);
		showsetting(lang('plugin/yiqixueba_server','mokuaipice'),'mokuaipice',$ver_info['mokuaipice'],'text','',0,lang('plugin/yiqixueba_server','mokuaipice_comment'),'','',true);
		showsetting(lang('plugin/yiqixueba_server','mokuaiverdescription'),'mokuaidescription',$ver_info['mokuaidescription'],'textarea','','',lang('plugin/yiqixueba_server','mokuaidescription_comment'),'','',true);
		showsetting(lang('plugin/yiqixueba_server','status'),'status',$ver_info['status'],'radio','','',lang('plugin/yiqixueba_server','mokuaiver_status_comment'),'','',true);
		showsubmit('submit');
		showtablefooter();
		showformfooter();
	}else{
		$data = array();
		if(!$verid) {
			$data['mokuaiid'] = intval($_GET['mokuaiverid']);
		}
		$data['versionname'] = htmlspecialchars(trim($_GET['versionname']));
		$data['mokuaidescription'] = htmlspecialchars(trim($_GET['mokuaidescription']));
		$data['mokuaipice'] = intval($_GET['mokuaidescription']);
		$data['status'] = intval($_GET['status']);
		if($verid) {
			DB::update('yiqixueba_server_mokuaiver',$data,array('verid'=>$verid));
		}else{
			DB::insert('yiqixueba_server_mokuaiver',$data);
		}
		cpmsg(lang('plugin/yiqixueba_server', 'mokuai_edit_succeed'), 'action='.$this_page.'&subop=mokuaiverlist', 'succeed');
	}
//模块页面列表
}elseif($subop == 'pagelist') {
	if(!submitcheck('submit')) {

		//模块select
		$mokuai_select = '<select name="mokuaiid"><option value="">'.lang('plugin/yiqixueba_server','all').'</option>';
		$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_server_mokuai')." where level>1 order by displayorder asc");
		while($row = DB::fetch($query)) {
			$mokuai_select .= '<option value="'.$row['mokuaiid'].'" '.($mokuaiid == $row['mokuaiid'] ? ' selected' : '').'>'.($row['level']==3 ?$mokuai_info_array[$mokuai_info_array[$row['mokuaiid']]['upid']]['mokuaititle'].'--':'').$row['mokuaititle'].'</option>';
		}
		$mokuai_select .= '</select>';
		//

		//每页显示条数
		$tpp = intval(getgpc('tpp')) ? intval(getgpc('tpp')) : '20';
		$select[$tpp] = $tpp ? "selected='selected'" : '';
		$tpp_options = "<option value='20' $select[20]>20</option><option value='50' $select[50]>50</option><option value='100' $select[100]>100</option>";
		//

		showtips(lang('plugin/yiqixueba_server','pagelist_tips'));
		showformheader($this_page.'&subop=pagelist');
		showtableheader(lang('plugin/yiqixueba_server','other_link').$other_links);
		//////搜索内容
		echo '<tr><td>';
		//模块选择
		echo lang('plugin/yiqixueba_server','mokuainame').'&nbsp;&nbsp;'.$mokuai_select;
		if($mokuaiid) {//版本选择
			$ver_select = '<select name="verid"><option value="">'.lang('plugin/yiqixueba_server','all').'</option>';
			$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_server_mokuaiver')." where mokuaiid = ".$mokuaiid." order by displayorder asc");
			while($row = DB::fetch($query)) {
				$ver_select .= '<option value="'.$row['verid'].'" '.($verid == $row['verid'] ? ' selected' : '').'>'.$row['versionname'].'</option>';
			}
			$ver_select .= '</select>';
			echo '&nbsp;&nbsp;'.lang('plugin/yiqixueba_server','versionname').'&nbsp;&nbsp;'.$ver_select;
		}
		//页面类型选择
		$pagetype_select = '<select name="pagetype"><option value="">'.lang('plugin/yiqixueba_server','all').'</option>';
		foreach ( $page_type_array as $k=>$v) {
			$pagetype_select .= '<option value="'.$v.'" '.($pagetype == $v ? ' selected' : '').'>'.lang('plugin/yiqixueba_server',$v).'</option>';
		}
		$pagetype_select .= '</select>';
		echo '&nbsp;&nbsp;'.lang('plugin/yiqixueba_server','pagetype').'&nbsp;&nbsp;'.$pagetype_select;
		//每页显示条数
		echo "&nbsp;&nbsp;".$lang['perpage']."<select name=\"tpp\">$tpp_options</select>&nbsp;&nbsp;<input class=\"btn\" type=\"submit\" value=\"$lang[search]\" /></td></tr>";
		//////搜索内容
		showtablefooter();
		showtableheader(lang('plugin/yiqixueba_server','pagelist'));
		showsubtitle(array('',  lang('plugin/yiqixueba_server','displayorder'),lang('plugin/yiqixueba_server','mokuainame'),lang('plugin/yiqixueba_server','versionname'),lang('plugin/yiqixueba_server','pagetype'),lang('plugin/yiqixueba_server','pagetitle'), lang('plugin/yiqixueba_server','pagedescription'),''));
		$get_text = '&tpp='.$tpp.'&mokuaiid='.$mokuaiid.'&verid='.$verid.'&pagetype='.$pagetype;
		//搜索条件处理
		$perpage = $tpp;
		$start = ($page - 1) * $perpage;
		$where = "";
		$where .= $mokuaiid ? " and mokuai='".$mokuai_info_array[$mokuaiid]['mokuainame']."'" : "";
		$where .= $verid ? " and mokuaiver=".$verid : "";
		$where .= $pagetype ? " and pagetype='".$pagetype."'" : "";
		if($where) {
			$where = " where ".substr($where,4,strlen($where)-4);
		}

		$pagecount = DB::result_first("SELECT count(*) FROM ".DB::table('yiqixueba_server_page').$where);
		$multi = multi($pagecount, $perpage, $page, ADMINSCRIPT."?action=".$this_page."&subop=pagelist".$get_text);
		$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_server_page').$where."   order by displayorder asc limit ".$start.", ".$perpage."");
		while($row = DB::fetch($query)) {
			showtablerow('', array('class="td25"','class="td25"','class="td23"','class="td25"','class="td25"', 'class="td28"', 'class="td29"','class="td28"',''), array(
				"<input class=\"checkbox\" type=\"checkbox\" name=\"delete[]\" value=\"$row[pageid]\">",
				$mokuaiid && $pagetype && $verid ? '<input type="text" class="txt" name="displayordernew['.$row['pageid'].']" value="'.$row['displayorder'].'" size="1" />':'',
				$row['mokuai'],
				$row['mokuaiver'],
				lang('plugin/yiqixueba_server',$row['pagetype']),
				'<a href="'.ADMINSCRIPT.'?action='.$this_page.'&subop='.$row['pagetype'].'pageedit&pageid='.$row['pageid'].'">'.$row['pagetitle'].'</a>('.$row['pagename'].')',
				$row['pagedescription'],
				"<input class=\"checkbox\" type=\"checkbox\" name=\"statusnew[$row[pageid]]\"".($row['status'] ? ' checked':'')." value=\"1\">",
			));
			//var_dump($row);
		}
		if($mokuaiid && $pagetype) {//只有在模块和页面类型都存在的情况下，才显示增加菜单
			echo '<tr><td></td><td colspan="8"><div><a href="'.ADMINSCRIPT.'?action='.$this_page.'&subop='.$pagetype.'pageedit&mokuaiid='.$mokuaiid.'&verid='.$verid.'&pagetype='.$pagetype.'" class="addtr">'.lang('plugin/yiqixueba_server','add_page').'</a></div></td></tr>';
		}

		showsubmit('submit','submit','del','',$multi);
		showtablefooter();
		showformfooter();
	}else{
		if($idg = $_GET['delete']) {
			$idg = dintval($idg, is_array($idg) ? true : false);
			if($idg) {
				DB::delete('yiqixueba_server_page', DB::field('pageid', $idg));
				//删除站长数据表中的模块设置字段
				//$sql = "alter table ".DB::table('wxq123_site')." DROP `m_".$mokuainame."`;";
			}
		}
		$data = array();
		$displayordernew = $_GET['displayordernew'];
		if(is_array($displayordernew)) {
			foreach ( $displayordernew as $k=>$v) {
				$data['displayorder'] = intval($v);
				DB::update('yiqixueba_server_page',$data,array('pageid'=>$k));
			}
		}
		$data = array();
		$statusnew = $_GET['statusnew'];
		if(is_array($statusnew)) {
			foreach ( $statusnew as $k=>$v) {
				$data['status'] = intval($v);
				DB::update('yiqixueba_server_page',$data,array('pageid'=>$k));
			}
		}
		cpmsg(lang('plugin/yiqixueba_server', 'mokuai_edit_succeed'), 'action='.$this_page.'&subop=pagelist&mokuaiid='.$mokuaiid.'&verid='.$verid.'&pagetype='.$pagetype, 'succeed');
	}
//编辑模块页面
}elseif($subop == 'pageedit') {
//后台页面分支列表
}elseif($subop == 'adminpageedit') {
	if(!submitcheck('submit')) {
		showtips(lang('plugin/yiqixueba_server','adminoplist_tips'));
		showformheader($this_page.'&subop=adminpageedit');
		showtableheader(lang('plugin/yiqixueba_server','other_link').$other_links);
		echo '<tr><td>'.$subop.$mokuaiid.$pagetype.$verid.'</td></tr>';
		showtablefooter();
		showtableheader(lang('plugin/yiqixueba_server','adminoplist'));
		jsinsertunit();
		showtablefooter();
		$template = '';
		$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_server_code')." WHERE  codetype = 'admin'");
		while($row = DB::fetch($query)) {
			$template .= $row['codetitle'].': <a href="###" onclick="insertunit(\''.addcslashes(dhtmlspecialchars($row['codecontent'])).'\')">'.$row['codename'].'</a>';
		}
		$template .= '<textarea cols="100" rows="20" id="jstemplate" name="template" style="width: 95%;">'.$mod_text.'</textarea>';
		$template .= '<input type="hidden" name="preview" value="0" /><input type="hidden" name="menueditsubmit" value="1" />';
		$template .= '<br /><input type="submit" class="btn" value="'.lang('plugin/yiqixueba_server', 'submit').'">&nbsp; &nbsp;<input type="button" class="btn" onclick="history.go(-1);" value="'.lang('plugin/yiqixueba_server', 'cancel').'"></div><br /><br />';
		echo '<div class="colorbox">';
		echo '<div class="extcredits">';
		echo $template;
		echo '</div>';
		echo '</div>';function jsinsertunit() {
?>
<script type="text/JavaScript">
	function isUndefined(variable) {
		return typeof variable == 'undefined' ? true : false;
	}

	function insertunit(text, obj) {
		if(!obj) {
			obj = 'jstemplate';
		}
		$(obj).focus();
		if(!isUndefined($(obj).selectionStart)) {
			var opn = $(obj).selectionStart + 0;
			$(obj).value = $(obj).value.substr(0, $(obj).selectionStart) + text + $(obj).value.substr($(obj).selectionEnd);
			$(obj).selectionStart = opn + strlen(text);
			$(obj).selectionEnd = opn + strlen(text);
		} else if(document.selection && document.selection.createRange) {
			var sel = document.selection.createRange();
			sel.text = text.replace(/\r?\n/g, '\r\n');
			sel.moveStart('character', -strlen(text));
		} else {
			$(obj).value += text;
		}
	}
</script>
<?php
}

		//showsubmit('submit','submit','del');
		showtablefooter();
		showformfooter();
	}else{
		if($idg = $_GET['delgroup']) {
			$idg = dintval($idg, is_array($idg) ? true : false);
			if($idg) {
				DB::delete('yiqixueba_server_mokuai', DB::field('mokuaiid', $idg));
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
				DB::delete('yiqixueba_server_mokuaiver', DB::field('mokuaiid', $idm));
			}
		}
		$displayordergnew = $_GET['displayordergnew'];
		if(is_array($displayordergnew)) {
			foreach ( $displayordergnew as $k=>$v) {
				$data['displayorder'] = intval($v);
				DB::update('yiqixueba_server_mokuai',$data,array('mokuaiid'=>$k));
			}
		}
		$displayordermnew = $_GET['displayordermnew'];
		if(is_array($displayordermnew)) {
			foreach ( $displayordermnew as $k=>$v) {
				$data['displayorder'] = intval($v);
				DB::update('yiqixueba_server_mokuaiver',$data,array('mokuaiid'=>$k));
			}
		}
		cpmsg(lang('plugin/yiqixueba_server', 'mokuai_edit_succeed'), 'action='.$this_page, 'succeed');
	}
//编辑模块页面
}elseif($subop == 'modulepageedit') {
//编辑模块页面
}elseif($subop == 'ajaxpageedit') {
//编辑模块页面
}elseif($subop == 'apipageedit') {
//编辑模块页面
}elseif($subop == 'hookpageedit') {
//编辑模块页面
}elseif($subop == 'memberpageedit') {
//常用代码段列表
}elseif($subop == 'codelist') {
	if(!submitcheck('submit')) {
		showtips(lang('plugin/yiqixueba_server','codelist_tips'));
		showformheader($this_page.'&subop=codelist');
		showtableheader(lang('plugin/yiqixueba_server','other_link').$other_links);
		showtablefooter();
		showtableheader(lang('plugin/yiqixueba_server','codelist'));
		showsubtitle(array('',  lang('plugin/yiqixueba_server','codetype'),lang('plugin/yiqixueba_server','codename'),lang('plugin/yiqixueba_server','codetitle'),lang('plugin/yiqixueba_server','codedescription'), ''));
		$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_server_code'));
			//." ".$code_info['codetype'] != '' ? " WHERE codetype = '".$code_info['codetype']."'":"");
		while($row = DB::fetch($query)) {
			showtablerow('', array('class="td25"','class="td25"', 'class="td23"', 'class="td23"','class="td28"',''), array(
				"<input class=\"checkbox\" type=\"checkbox\" name=\"delete[]\" value=\"$row[codeid]\">",
				lang('plugin/yiqixueba_server',$row['codetype']),
				$row['codename'],
				$row['codetitle'],
				$row['codedescription'],
				"<a href=\"".ADMINSCRIPT."?action=$this_page&subop=codeedit&codeid=$row[codeid]\" class=\"act\">".lang('plugin/yiqixueba_server','edit')."</a>",
			));
		}
		echo '<tr><td></td><td colspan="8"><div><a href="'.ADMINSCRIPT.'?action='.$this_page.'&subop=codeedit&codetype='.$codetype.'" class="addtr">'.lang('plugin/yiqixueba_server','add_code').'</a></div></td></tr>';
		showsubmit('submit','submit','del','',$multi);
		showtablefooter();
		showformfooter();
	}else{
	}

//编辑常用代码段
}elseif($subop == 'codeedit') {
	if(!submitcheck('submit')) {
		showtips(lang('plugin/yiqixueba_server','codeedit_tips'));
		showformheader($this_page.'&subop=codeedit');
		showtableheader(lang('plugin/yiqixueba_server','other_link').$other_links);
		showtablefooter();
		showtableheader(lang('plugin/yiqixueba_server','codeedit'));
		if($codeid) {
			$codetype_select = lang('plugin/yiqixueba_server',$code_info['codetype']);
			showhiddenfields(array('codeid'=>$codeid));
		}else{
			//页面类型选择
			$codetype_select = '<select name="codetype">';
			foreach ( $page_type_array as $k=>$v) {
				$codetype_select .= '<option value="'.$v.'" '.($code_info['codetype'] == $v ? ' selected' : '').'>'.lang('plugin/yiqixueba_server',$v).'</option>';
			}
			$codetype_select .= '</select>';
		}
		showsetting(lang('plugin/yiqixueba_server','codetype'),'','',$codetype_select,'','',lang('plugin/yiqixueba_server','codename_comment'),'','',true);
		showsetting(lang('plugin/yiqixueba_server','codename'),'codename',$code_info['codename'],'text','','',lang('plugin/yiqixueba_server','codename_comment'),'','',true);
		showsetting(lang('plugin/yiqixueba_server','codetitle'),'codetitle',$code_info['codetitle'],'text','','',lang('plugin/yiqixueba_server','codetitle_comment'),'','',true);
		showsetting(lang('plugin/yiqixueba_server','codedescription'),'codedescription',$code_info['codedescription'],'textarea','','',lang('plugin/yiqixueba_server','codedescription_comment'),'','',true);
		showsetting(lang('plugin/yiqixueba_server','codecontent'),'codecontent',$code_info['codecontent'],'textarea','','',lang('plugin/yiqixueba_server','codecontent_comment'),'','',true);
		showsubmit('submit');
		showtablefooter();
		showformfooter();
	}else{
		$data = array();
		if(!$codeid) {
			$data['codetype'] = htmlspecialchars(trim($_GET['codetype']));
		}
		$data['codename'] = htmlspecialchars(trim($_GET['codename']));
		$data['codetitle'] = htmlspecialchars(trim($_GET['codetitle']));
		$data['codedescription'] = htmlspecialchars(trim($_GET['codedescription']));
		$data['codecontent'] = htmlspecialchars(trim($_GET['codecontent']));
		if($codeid) {
			DB::update('yiqixueba_server_code',$data,array('codeid'=>$codeid));
		}else{
			DB::insert('yiqixueba_server_code',$data);
		}
		cpmsg(lang('plugin/yiqixueba_server', 'code_edit_succeed'), 'action='.$this_page.'&subop=codelist', 'succeed');
	}
//页面分支列表
}elseif($subop == 'fenzhilist') {
	if(!submitcheck('submit')) {
		showtips(lang('plugin/yiqixueba_server','fenzhilist_tips'));
		showformheader($this_page.'&subop=fenzhilist');
		showtableheader(lang('plugin/yiqixueba_server','other_link').$other_links);
		showtablefooter();
		showtableheader(lang('plugin/yiqixueba_server','fenzhilist'));
		showsubtitle(array('',  lang('plugin/yiqixueba_server','fenzhitype'),lang('plugin/yiqixueba_server','fenzhiname'),lang('plugin/yiqixueba_server','fenzhititle'),lang('plugin/yiqixueba_server','fenzhidescription'), ''));
		$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_server_fenzhi'));
			//." ".$fenzhi_info['fenzhitype'] != '' ? " WHERE fenzhitype = '".$fenzhi_info['fenzhitype']."'":"");
		while($row = DB::fetch($query)) {
			showtablerow('', array('class="td25"','class="td25"', 'class="td23"', 'class="td23"','class="td28"',''), array(
				"<input class=\"checkbox\" type=\"checkbox\" name=\"delete[]\" value=\"$row[fenzhiid]\">",
				lang('plugin/yiqixueba_server',$row['fenzhitype']),
				$row['fenzhiname'],
				$row['fenzhititle'],
				$row['fenzhidescription'],
				"<a href=\"".ADMINSCRIPT."?action=$this_page&subop=fenzhiedit&fenzhiid=$row[fenzhiid]\" class=\"act\">".lang('plugin/yiqixueba_server','edit')."</a>",
			));
		}
		echo '<tr><td></td><td colspan="8"><div><a href="'.ADMINSCRIPT.'?action='.$this_page.'&subop=fenzhiedit&fenzhitype='.$fenzhitype.'" class="addtr">'.lang('plugin/yiqixueba_server','add_fenzhi').'</a></div></td></tr>';
		showsubmit('submit','submit','del','',$multi);
		showtablefooter();
		showformfooter();
	}else{
	}
//编辑页面分支
}elseif($subop == 'fenzhiedit') {
	if(!submitcheck('submit')) {
		showtips(lang('plugin/yiqixueba_server','fenzhiedit_tips'));
		showformheader($this_page.'&subop=fenzhiedit');
		showtableheader(lang('plugin/yiqixueba_server','other_link').$other_links);
		showtablefooter();
		showtableheader(lang('plugin/yiqixueba_server','fenzhiedit'));
		if($fenzhiid) {
			$fenzhitype_select = lang('plugin/yiqixueba_server',$fenzhi_info['fenzhitype']);
			showhiddenfields(array('fenzhiid'=>$fenzhiid));
		}else{
			//页面类型选择
			$fenzhitype_select = '<select name="fenzhitype">';
			foreach ( $page_type_array as $k=>$v) {
				$fenzhitype_select .= '<option value="'.$v.'" '.($fenzhi_info['fenzhitype'] == $v ? ' selected' : '').'>'.lang('plugin/yiqixueba_server',$v).'</option>';
			}
			$fenzhitype_select .= '</select>';
		}
		showsetting(lang('plugin/yiqixueba_server','fenzhitype'),'','',$fenzhitype_select,'','',lang('plugin/yiqixueba_server','fenzhiname_comment'),'','',true);
		showsetting(lang('plugin/yiqixueba_server','fenzhiname'),'fenzhiname',$fenzhi_info['fenzhiname'],'text','','',lang('plugin/yiqixueba_server','fenzhiname_comment'),'','',true);
		showsetting(lang('plugin/yiqixueba_server','fenzhititle'),'fenzhititle',$fenzhi_info['fenzhititle'],'text','','',lang('plugin/yiqixueba_server','fenzhititle_comment'),'','',true);
		showsetting(lang('plugin/yiqixueba_server','fenzhidescription'),'fenzhidescription',$fenzhi_info['fenzhidescription'],'textarea','','',lang('plugin/yiqixueba_server','fenzhidescription_comment'),'','',true);
		showsetting(lang('plugin/yiqixueba_server','fenzhicontent'),'fenzhicontent',$fenzhi_info['fenzhicontent'],'textarea','','',lang('plugin/yiqixueba_server','fenzhicontent_comment'),'','',true);
		showsubmit('submit');
		showtablefooter();
		showformfooter();
	}else{
		$data = array();
		if(!$fenzhiid) {
			$data['fenzhitype'] = htmlspecialchars(trim($_GET['fenzhitype']));
		}
		$data['fenzhiname'] = htmlspecialchars(trim($_GET['fenzhiname']));
		$data['fenzhititle'] = htmlspecialchars(trim($_GET['fenzhititle']));
		$data['fenzhidescription'] = htmlspecialchars(trim($_GET['fenzhidescription']));
		$data['fenzhicontent'] = htmlspecialchars(trim($_GET['fenzhicontent']));
		if($fenzhiid) {
			DB::update('yiqixueba_server_fenzhi',$data,array('fenzhiid'=>$fenzhiid));
		}else{
			DB::insert('yiqixueba_server_fenzhi',$data);
		}
		cpmsg(lang('plugin/yiqixueba_server', 'fenzhi_edit_succeed'), 'action='.$this_page.'&subop=fenzhilist', 'succeed');
	}
}


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
function jsinsertunit() {
?>
<script type="text/JavaScript">
	function isUndefined(variable) {
		return typeof variable == 'undefined' ? true : false;
	}

	function insertunit(text, obj) {
		if(!obj) {
			obj = 'jstemplate';
		}
		$(obj).focus();
		if(!isUndefined($(obj).selectionStart)) {
			var opn = $(obj).selectionStart + 0;
			$(obj).value = $(obj).value.substr(0, $(obj).selectionStart) + text + $(obj).value.substr($(obj).selectionEnd);
			$(obj).selectionStart = opn + strlen(text);
			$(obj).selectionEnd = opn + strlen(text);
		} else if(document.selection && document.selection.createRange) {
			var sel = document.selection.createRange();
			sel.text = text.replace(/\r?\n/g, '\r\n');
			sel.moveStart('character', -strlen(text));
		} else {
			$(obj).value += text;
		}
	}
</script>
<?php
}


?>