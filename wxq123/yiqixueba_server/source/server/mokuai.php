<?php

/**
*	一起学吧平台程序
*	模块管理
*	文件名：mokuai.php  创建时间：2013-5-30 09:37  杨文
*
*/

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
$this_page = 'plugins&identifier=yiqixueba_server&pmod=admincp&submod=mokuai';
$subop = getgpc('subop');
$subops = array('list','groupedit','designmokuai','editmokuai','pageedit','moduleedit','templateedit','pagelist','setting','goods');
$subop = in_array($subop,$subops) ? $subop : $subops[0];

$mokuaiid = getgpc('mokuaiid');
$mokuai_info = $mokuaiid ? DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_server_mokuai')." WHERE mokuaiid=".$mokuaiid) : array();

$groupid = getgpc('groupid');
$group_info = $groupid ? DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_server_mokuai_group')." WHERE groupid=".$groupid) : array();

//模块列表
if($subop == 'list') {
	if(!submitcheck('submit')) {
		showtips(lang('plugin/yiqixueba_server','mokuai_list_tips'));
		showformheader($this_page.'&subop=list');
		showtableheader(lang('plugin/yiqixueba_server','mokuai_list'));
		showsubtitle(array('', lang('plugin/yiqixueba_server','displayorder'),lang('plugin/yiqixueba_server','mokuaiico'), lang('plugin/yiqixueba_server','mokuaititle'), lang('plugin/yiqixueba_server','versionname'),lang('plugin/yiqixueba_server','mokuaipice'), lang('plugin/yiqixueba_server','mokuaidescription'),lang('plugin/yiqixueba_server','status'), ''));
		$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_server_mokuai_group')." order by displayorder asc");
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
			$mknum = DB::result_first("SELECT count(*) FROM ".DB::table('yiqixueba_server_mokuai')." WHERE groupid=".$row['groupid']." order by displayorder asc");
			showtablerow('', array('class="td25"','class="td25"', 'class="td25"', 'class="td23"','class="td25"','class="td28"',''), array(
				($mknum ?'<a href="javascript:;" class="right" onclick="toggle_group(\'mokuai_'.$row['groupid'].'\', this)">[+]</a>':'')."<input class=\"checkbox\" type=\"checkbox\" name=\"delgroup[]\" value=\"$row[groupid]\">",
				'<input type="text" class="txt" name="displayordergnew['.$row['groupid'].']" value="'.$row['displayorder'].'" size="1" />',
				$mokuaiico.'<input type="hidden" name="mokuainamenew['.$row['mokuaiid'].']" value="'.$row['mokuainame'].'">',
				$row['mokuaititle'].'('.$row['mokuainame'].')',
				'',
				'',
				'',
				'',
				"<a href=\"".ADMINSCRIPT."?action=$this_page&subop=groupedit&groupid=$row[groupid]\" class=\"act\">".lang('plugin/yiqixueba_server','edit')."</a>&nbsp;&nbsp;".'<a href="'.ADMINSCRIPT.'?action='.$this_page.'&subop=editmokuai&groupid='.$row['groupid'].'"  class="addchildboard">'.lang('plugin/yiqixueba_server','add_ver').'</a>',
			));
			$query1 = DB::query("SELECT * FROM ".DB::table('yiqixueba_server_mokuai')." WHERE groupid=".$row['groupid']." order by displayorder asc");
			$kk = 0;
			showtagheader('tbody', 'mokuai_'.$row['groupid'], false);
			while($row1 = DB::fetch($query1)) {
				showtablerow('', array('class="td25"','class="td25"', 'class="td25"', 'class="td23"','class="td25"','class="td23"','class="td29"', 'class="td25"',''), array(
					"<input class=\"checkbox\" type=\"checkbox\" name=\"delmokuai[]\" value=\"$row1[mokuaiid]\">",
					"<div class=\"".($kk == $mknum ? 'board' : 'lastboard')."\">&nbsp;</div>",
					'<input type="text" class="txt" name="displayordermnew['.$row1['mokuaiid'].']" value="'.$row1['displayorder'].'" size="1" />',
					'('.lang('plugin/yiqixueba_server','verid').$row1['mokuaiid'].')',
					$row1['versionname'],
					$row1['mokuaipice'],
					$row1['mokuaidescription'],
					$row1['status'] == 0 ? lang('plugin/yiqixueba_server','designing') :($row1['status'] == 1 ? lang('plugin/yiqixueba_server','open') :lang('plugin/yiqixueba_server','close')),
					"<a href=\"".ADMINSCRIPT."?action=$this_page&subop=editmokuai&groupid=$row[groupid]&mokuaiid=$row1[mokuaiid]\" class=\"act\">".lang('plugin/yiqixueba_server','edit')."</a>&nbsp;&nbsp;<a href=\"".ADMINSCRIPT."?action=$this_page&subop=pagelist&groupid=$row[groupid]&mokuaiid=$row1[mokuaiid]\" class=\"act\">".lang('plugin/yiqixueba_server','page')."</a>"
				));
			}
			showtagfooter('tbody');
			$kk++;
		}
		echo '<tr><td></td><td colspan="8"><div><a href="'.ADMINSCRIPT.'?action='.$this_page.'&subop=groupedit" class="addtr">'.lang('plugin/yiqixueba_server','add_mokuai').'</a></div></td></tr>';
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
		if($group_info['mokuaiico']!='') {
			$mokuaiico = str_replace('{STATICURL}', STATICURL, $group_info['mokuaiico']);
			if(!preg_match("/^".preg_quote(STATICURL, '/')."/i", $mokuaiico) && !(($valueparse = parse_url($mokuaiico)) && isset($valueparse['host']))) {
				$mokuaiico = $_G['setting']['attachurl'].'common/'.$group_info['mokuaiico'].'?'.random(6);
			}
			$mokuaiicohtml = '<br /><label><input type="checkbox" class="checkbox" name="delete" value="yes" /> '.$lang['del'].'</label><br /><img src="'.$mokuaiico.'" width="40" height="40"/>';
		}
		showformheader($this_page.'&subop=groupedit','enctype');
		showtableheader(lang('plugin/yiqixueba_server','mokuai_edit'));
		$groupid ? showhiddenfields($hiddenfields = array('groupid'=>$groupid)) : '';
		$mokuai_dir = DISCUZ_ROOT.'source/plugin/wxq123/server/mokuai/'.$group_info['mokuainame'];
		showsetting(lang('plugin/yiqixueba_server','mokuainame'),'mokuainame',$group_info['mokuainame'],'text','',0,lang('plugin/yiqixueba_server','mokuainame_comment'),'','',true);
		showsetting(lang('plugin/yiqixueba_server','mokuaititle'),'mokuaititle',$group_info['mokuaititle'],'text','',0,lang('plugin/yiqixueba_server','mokuaititle_comment'),'','',true);
		showsetting(lang('plugin/yiqixueba_server','mokuaiico'),'mokuaiico',$group_info['mokuaiico'],'filetext','','',lang('plugin/yiqixueba_server','mokuaiico_comment').$mokuaiicohtml,'','',true);
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
}elseif($subop == 'editmokuai'){
	if(!submitcheck('submit')) {
		if($group_info['mokuaiico']!='') {
			$mokuaiico = str_replace('{STATICURL}', STATICURL, $group_info['mokuaiico']);
			if(!preg_match("/^".preg_quote(STATICURL, '/')."/i", $mokuaiico) && !(($valueparse = parse_url($mokuaiico)) && isset($valueparse['host']))) {
				$mokuaiico = $_G['setting']['attachurl'].'common/'.$group_info['mokuaiico'].'?'.random(6);
			}
			$mokuaiico = '<img src="'.$mokuaiico.'" width="40" height="40"/>';
		}else{
			$mokuaiico = '';
		}

		$status_select = '<select name="status"><option value="0" '.($mokuai_info['status']==0?' selected':'').'>'.lang('plugin/yiqixueba_server','design').'</option><option value="1" '.($mokuai_info['status']==1?' selected':'').'>'.lang('plugin/yiqixueba_server','open').'</option><option value="2" '.($mokuai_info['status']==2?' selected':'').'>'.lang('plugin/yiqixueba_server','close').'</option></select>';
		showtips(lang('plugin/yiqixueba_server','mokuai_edit_tips'));
		showformheader($this_page.'&subop=editmokuai');
		showtableheader(lang('plugin/yiqixueba_server','mokuai_edit'));
		showhiddenfields($hiddenfields = array('groupid'=>$groupid));
		$mokuaiid ? showhiddenfields(array('mokuaiid'=>$mokuaiid)) : '';
		showsetting(lang('plugin/yiqixueba_server','mokuainame'),'','',$mokuaiico.$group_info['mokuaititle'].$group_info['mokuainame']);
		showsetting(lang('plugin/yiqixueba_server','versionname'),'versionname',$mokuai_info['versionname'],'text');
		showsetting(lang('plugin/yiqixueba_server','mokuaipice'),'mokuaipice',$mokuai_info['mokuaipice'],'text');
		showsetting(lang('plugin/yiqixueba_server','mokuaidescription'),'mokuaidescription',$mokuai_info['mokuaidescription'],'textarea');
		showsetting(lang('plugin/yiqixueba_server','status'),'','',$status_select,'','',lang('plugin/yiqixueba_server','status_comment'));
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
//页面列表
}elseif($subop == 'pagelist'){
	if(!submitcheck('submit')) {
		$page_type_array = array('admin','module','ajax','api','hook');
		showtips('<li>'.lang('plugin/yiqixueba_server','edit').$group_info['mokuaititle'].'-'.$mokuai_info['versionname'].'</li>'.lang('plugin/yiqixueba_server','page_list_tips'));
		showformheader($this_page.'&subop=pagelist');
		showtableheader(lang('plugin/yiqixueba_server','page_list'));
		showsubtitle(array('', lang('plugin/yiqixueba_server','displayorder'),lang('plugin/yiqixueba_server','pagename'),lang('plugin/yiqixueba_server','pagetitle'), lang('plugin/yiqixueba_server','pagetype'), lang('plugin/yiqixueba_server','pagedescription'),lang('plugin/yiqixueba_server','pagetips'), lang('plugin/yiqixueba_server','status'), ''));
		$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_server_page')." WHERE mokuaiid=$mokuaiid order by displayorder asc");
		while($row = DB::fetch($query)) {
			showtablerow('', array('class="td25"','class="td25"', 'class="td23"', 'class="td23"','class="td23"','class="td29"', 'class="td29"', 'class="td25"',''), array(
				"<input class=\"checkbox\" type=\"checkbox\" name=\"delete[]\" value=\"$row[mokuaiid]\">",
				'<input type="text" class="txt" name="displayordermnew['.$row['mokuaiid'].']" value="'.$row['displayorder'].'" size="2" />',
				$row['filename'],
				$row['filetitle'],
				lang('plugin/yiqixueba_server',$row['pagetype']),
				$row['pagedescription'],
				$row1['mokuaidescription'],
				$row['status'] == 0 ? lang('plugin/yiqixueba_server','close') :lang('plugin/yiqixueba_server','open'),
				"<a href=\"".ADMINSCRIPT."?action=$this_page&subop=pageedit&groupid=$groupid&mokuaiid=$mokuaiid&pageid=$row[pageid]\" class=\"act\">".lang('plugin/yiqixueba_server','edit')."</a>&nbsp;&nbsp;<a href=\"".ADMINSCRIPT."?action=$this_page&subop=pagelist&groupid=$row[groupid]&mokuaiid=$row1[mokuaiid]\" class=\"act\">".lang('plugin/yiqixueba_server','page')."</a>"
			));
		}
		echo '<tr><td></td><td colspan="8"><div><a href="###" onclick="addrow(this, 0);" class="addtr">'.lang('plugin/yiqixueba_server','add_page').'</a><input type="hidden" name="mokuaiid" value="'.$mokuaiid.'"><input type="hidden" name="groupid" value="'.$groupid.'"></div></td></tr>';
		showsubmit('submit','submit','del');
		showtablefooter();
		showformfooter();
		$type_select = '<select name="newtype[]"><option value="admin">'.lang('plugin/yiqixueba_server','admin').'</option><option value="module">'.lang('plugin/yiqixueba_server','module').'</option><option value="ajax">'.lang('plugin/yiqixueba_server','ajax').'</option><option value="api">'.lang('plugin/yiqixueba_server','api').'</option><option value="hook">'.lang('plugin/yiqixueba_server','hook').'</option></select>';
		echo <<<EOT
<script type="text/JavaScript">
	var rowtypedata = [
		[[1,''], [1,'<input name="newdisplayorder[]" type="text" class="txt" value="0">','td25'], [1, '','td23'], [1, '<input name="newtitle[]" type="text" class="txt">','td23'],[1,'$type_select','td25'],[3,''],],
	];
	</script>
EOT;
	}else{
		if(getgpc('newtitle')) {
			$newdisplayorder = getgpc('newdisplayorder');
			$newtype = getgpc('newtype');
			foreach ( getgpc('newtitle') as $k=>$v) {
				if(DB::result_first("SELECT count(*) FROM ".DB::table('yiqixueba_server_page')." WHERE mokuaiid=".$mokuaiid."  and filetitle='".trim($v)."' and pagetype = '".trim($newtype[$k])."'")) {
					cpmsg(lang('plugin/yiqixueba_server', 'page_edit_error'));
				}else{
					$data['mokuaiid'] = $mokuaiid;
					$data['pagetype'] = trim($newtype[$k]);
					$data['filetitle'] = trim($v);
					$data['displayorder'] = trim($newdisplayorder[$k]);
					$data['status'] = 0;
					DB::insert('yiqixueba_server_page',$data);
				}
			}
			cpmsg($group_info['mokuaititle'].'-'.$mokuai_info['versionname'].lang('plugin/yiqixueba_server', 'page_edit_succeed'), 'action='.$this_page.'&subop=pagelist&mokuaiid='.$mokuaiid.'&groupid='.$groupid, 'succeed');
		}
	}
//编辑页面
}elseif($subop == 'pageedit'){
	$pageid = intval(getgpc('pageid'));
	$page_info = DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_server_page')." WHERE pageid='".$pageid."'");
	if(!submitcheck('submit')) {
		showtips('<li>'.lang('plugin/yiqixueba_server','edit').$group_info['mokuaititle'].'-'.$mokuai_info['versionname'].$page_info['filename'].'</li>'.lang('plugin/yiqixueba_server','page_edit_tips'));
		showformheader($this_page.'&subop=pageedit');
		showtableheader(lang('plugin/yiqixueba_server','page_edit'));
		showhiddenfields(array('mokuaiid'=>$mokuaiid,'groupid'=>$groupid,'pageid'=>$pageid));
		showsetting(lang('plugin/yiqixueba_server','pagetype'),'','','<input type="hidden" name="pagetype" value="'.$page_info['pagetype'].'">'.lang('plugin/yiqixueba_server',$page_info['pagetype']),'','',lang('plugin/yiqixueba_server','pagetitle_comment'),'','',true);
		showsetting(lang('plugin/yiqixueba_server','pagetitle'),'pagetitle',$page_info['filetitle'],'text','','',lang('plugin/yiqixueba_server','pagetitle_comment'),'','',true);
		if($page_info['pagetype'] =='hook') {
		}else{
			showsetting(lang('plugin/yiqixueba_server','pagename'),'pagename',$page_info['filename'],'text','','',lang('plugin/yiqixueba_server','pagename_comment'),'','',true);
		}
		showsetting(lang('plugin/yiqixueba_server','pagedescription'),'pagedescription',$page_info['pagedescription'],'textarea','','',lang('plugin/yiqixueba_server','pagedescription_comment'),'','',true);
		showsetting(lang('plugin/yiqixueba_server','pagecontents'),'pagecontents',htmlspecialchars_decode($page_info['pagecontents']),'textarea','','',lang('plugin/yiqixueba_server','pagecontents_comment'),'','',true);
		showsetting(lang('plugin/yiqixueba_server','status'),'status',$page_info['status'],'radio','','',lang('plugin/yiqixueba_server','page_status_comment'));
		showsubmit('submit');
		showtablefooter();
		showformfooter();
	}else{
		if(DB::result_first("SELECT count(*) FROM ".DB::table('yiqixueba_server_page')." WHERE mokuaiid=".$mokuaiid."  and filename='".trim(getgpc('pagename'))."' and pagetype = '".trim($newtype[$k])."' and pageid <>".$pageid)) {
			cpmsg(lang('plugin/yiqixueba_server', 'page_edit_error'));
		}
		$data['filename'] = trim(getgpc('pagename'));
		$data['filetitle'] = trim(getgpc('pagetitle'));
		$data['pagedescription'] = trim(getgpc('pagedescription'));
		$data['pagecontents'] = htmlspecialchars(trim(getgpc('pagecontents')));
		$data['status'] = trim(getgpc('status'));
		DB::update('yiqixueba_server_page',$data,array('pageid'=>$pageid));
		$file_name = DISCUZ_ROOT.'source/plugin/yiqixueba_server/source//mokuai/ver'.$mokuaiid.'/'.trim(getgpc('pagetype')).'/'.$data['filename'].'.php';
		if(trim(getgpc('pagetype')=='admin')) {
			$file_header = "<?php\n\n/**\n*\t一起学吧平台程序\n*\t".$data['filetitle']."\n*\n文件名：".$data['filename'].".php  创建时间：".dgmdate(time(),'dt')."  杨文\n*\n*/\n\nif(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {\n\texit('Access Denied');\n}\n";
			file_put_contents($file_name, $file_header.htmlspecialchars_decode($data['pagecontents'])."\n?>");
		}elseif(trim(getgpc('pagetype')=='module')) {






		}
		cpmsg($group_info['mokuaititle'].'-'.$mokuai_info['versionname'].lang('plugin/yiqixueba_server', 'page_edit_succeed'), 'action='.$this_page.'&subop=pagelist&mokuaiid='.$mokuaiid.'&groupid='.$groupid, 'succeed');
	}
//模块设计
}elseif($subop == 'designmokuai'){
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
//后台页面
}elseif($subop == 'adminedit'){
	if(!submitcheck('submit')) {
		showtips(lang('plugin/yiqixueba_server','edit').$group_info['mokuaititle'].$mokuai_info['versionname'].lang('plugin/yiqixueba_server','mokuai_admin').$filename);
		showformheader($this_page.'&subop=adminedit&groupid='.$groupid.'&mokuaiid='.$mokuaiid);
		showhiddenfields($hiddenfields = array('groupid'=>$groupid));
		showhiddenfields($hiddenfields = array('mokuaiid'=>$mokuaiid));
		showtableheader(lang('plugin/yiqixueba_server','mokuai_admin'));
		$filename ? showhiddenfields($hiddenfields = array('filename'=>$filename)) :showsetting(lang('plugin/yiqixueba_server','filename'),'filename','','text');
		showsetting(lang('plugin/yiqixueba_server','menu'),'filemenu','','text');
		showsetting(lang('plugin/yiqixueba_server','type'),'filetype','','text');
		showsetting(lang('plugin/yiqixueba_server','conment'),'fileconment','','textarea');
		showsubmit('submit');
		showformfooter();
	}else{
		$data['filename'] = htmlspecialchars(trim($_GET['filename']));
		$data['menu'] = htmlspecialchars(trim($_GET['menu']));
		$type = htmlspecialchars(trim($_GET['type']));
		$data['fileconment'] = htmlspecialchars(trim($_GET['fileconment']));
		if($filename) {
			file_put_contents(DISCUZ_ROOT.'source/plugin/wxq123/server/mokuai/ver'.$mokuaiid.'/admin/'.$data['filename'], htmlspecialchars(file_get_contents(DISCUZ_ROOT.'source/plugin/wxq123/server/example/admin_'.$type.'.php')));
		}else{
			file_put_contents(DISCUZ_ROOT.'source/plugin/wxq123/server/mokuai/ver'.$mokuaiid.'/admin/'.$data['filename'], htmlspecialchars(file_get_contents(DISCUZ_ROOT.'source/plugin/wxq123/server/example/admin_'.$type.'.php')));
		}
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
?>