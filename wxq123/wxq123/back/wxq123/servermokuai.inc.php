<?php

/**
 *      [17xue8.cn] (C)2013-2099 杨文.
 *      这不是免费的。
 *
 */

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

require_once DISCUZ_ROOT.'source/plugin/wxq123/server/function_server.php';

$mysql_keywords = array( 'ADD', 'ALL', 'ALTER', 'ANALYZE', 'AND', 'AS', 'ASC', 'ASENSITIVE', 'BEFORE', 'BETWEEN', 'BIGINT', 'BINARY', 'BLOB', 'BOTH', 'BY', 'CALL', 'CASCADE', 'CASE', 'CHANGE', 'CHAR', 'CHARACTER', 'CHECK', 'COLLATE', 'COLUMN', 'CONDITION', 'CONNECTION', 'CONSTRAINT', 'CONTINUE', 'CONVERT', 'CREATE', 'CROSS', 'CURRENT_DATE', 'CURRENT_TIME', 'CURRENT_TIMESTAMP', 'CURRENT_USER', 'CURSOR', 'DATABASE', 'DATABASES', 'DAY_HOUR', 'DAY_MICROSECOND', 'DAY_MINUTE', 'DAY_SECOND', 'DEC', 'DECIMAL', 'DECLARE', 'DEFAULT', 'DELAYED', 'DELETE', 'DESC', 'DESCRIBE', 'DETERMINISTIC', 'DISTINCT', 'DISTINCTROW', 'DIV', 'DOUBLE', 'DROP', 'DUAL', 'EACH', 'ELSE', 'ELSEIF', 'ENCLOSED', 'ESCAPED', 'EXISTS', 'EXIT', 'EXPLAIN', 'FALSE', 'FETCH', 'FLOAT', 'FLOAT4', 'FLOAT8', 'FOR', 'FORCE', 'FOREIGN', 'FROM', 'FULLTEXT', 'GOTO', 'GRANT', 'GROUP', 'HAVING', 'HIGH_PRIORITY', 'HOUR_MICROSECOND', 'HOUR_MINUTE', 'HOUR_SECOND', 'IF', 'IGNORE', 'IN', 'INDEX', 'INFILE', 'INNER', 'INOUT', 'INSENSITIVE', 'INSERT', 'INT', 'INT1', 'INT2', 'INT3', 'INT4', 'INT8', 'INTEGER', 'INTERVAL', 'INTO', 'IS', 'ITERATE', 'JOIN', 'KEY', 'KEYS', 'KILL', 'LABEL', 'LEADING', 'LEAVE', 'LEFT', 'LIKE', 'LIMIT', 'LINEAR', 'LINES', 'LOAD', 'LOCALTIME', 'LOCALTIMESTAMP', 'LOCK', 'LONG', 'LONGBLOB', 'LONGTEXT', 'LOOP', 'LOW_PRIORITY', 'MATCH', 'MEDIUMBLOB', 'MEDIUMINT', 'MEDIUMTEXT', 'MIDDLEINT', 'MINUTE_MICROSECOND', 'MINUTE_SECOND', 'MOD', 'MODIFIES', 'NATURAL', 'NOT', 'NO_WRITE_TO_BINLOG', 'NULL', 'NUMERIC', 'ON', 'OPTIMIZE', 'OPTION', 'OPTIONALLY', 'OR', 'ORDER', 'OUT', 'OUTER', 'OUTFILE', 'PRECISION', 'PRIMARY', 'PROCEDURE', 'PURGE', 'RAID0', 'RANGE', 'READ', 'READS', 'REAL', 'REFERENCES', 'REGEXP', 'RELEASE', 'RENAME', 'REPEAT', 'REPLACE', 'REQUIRE', 'RESTRICT', 'RETURN', 'REVOKE', 'RIGHT', 'RLIKE', 'SCHEMA', 'SCHEMAS', 'SECOND_MICROSECOND', 'SELECT', 'SENSITIVE', 'SEPARATOR', 'SET', 'SHOW', 'SMALLINT', 'SPATIAL', 'SPECIFIC', 'SQL', 'SQLEXCEPTION', 'SQLSTATE', 'SQLWARNING', 'SQL_BIG_RESULT', 'SQL_CALC_FOUND_ROWS', 'SQL_SMALL_RESULT', 'SSL', 'STARTING', 'STRAIGHT_JOIN', 'TABLE', 'TERMINATED', 'THEN', 'TINYBLOB', 'TINYINT', 'TINYTEXT', 'TO', 'TRAILING', 'TRIGGER', 'TRUE', 'UNDO', 'UNION', 'UNIQUE', 'UNLOCK', 'UNSIGNED', 'UPDATE', 'USAGE', 'USE', 'USING', 'UTC_DATE', 'UTC_TIME', 'UTC_TIMESTAMP', 'VALUES', 'VARBINARY', 'VARCHAR', 'VARCHARACTER', 'VARYING', 'WHEN', 'WHERE', 'WHILE', 'WITH', 'WRITE', 'X509', 'XOR', 'YEAR_MONTH', 'ZEROFILL', 'ACTION', 'BIT', 'DATE', 'ENUM', 'NO', 'TEXT', 'TIME');

$submod = getgpc('submod');
$submods = array('list','groupedit','designmokuai','editmokuai','viewmokuai','adminedit','moduleedit','templateedit','shop','setting','goods');
$submod = in_array($submod,$submods) ? $submod : $submods[0];

$mokuaiid = getgpc('mokuaiid');
$mokuai_info = $mokuaiid ? DB::fetch_first("SELECT * FROM ".DB::table('wxq123_server_mokuai')." WHERE mokuaiid=".$mokuaiid) : array();

$groupid = getgpc('groupid');
$group_info = $groupid ? DB::fetch_first("SELECT * FROM ".DB::table('wxq123_server_mokuai_group')." WHERE groupid=".$groupid) : array();

$filename = trim(getgpc('filename'));

//模块列表
if($submod == 'list') {
	if(!submitcheck('submit')) {
		showtips(lang('plugin/wxq123','mokuai_list_tips'));
		showformheader('plugins&identifier=wxq123&pmod=servermokuai&submod=list');
		showtableheader(lang('plugin/wxq123','mokuai_list'));
		showsubtitle(array('', lang('plugin/wxq123','displayorder'),lang('plugin/wxq123','mokuaiico'), lang('plugin/wxq123','mokuaititle'), lang('plugin/wxq123','versionname'),lang('plugin/wxq123','mokuaipice'), lang('plugin/wxq123','mokuaidescription'),lang('plugin/wxq123','status'), ''));
		$query = DB::query("SELECT * FROM ".DB::table('wxq123_server_mokuai_group')." order by displayorder asc");
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
			$mknum = DB::result_first("SELECT count(*) FROM ".DB::table('wxq123_server_mokuai')." WHERE groupid=".$row['groupid']." order by displayorder asc");
			showtablerow('', array('class="td25"','class="td25"', 'class="td25"', 'class="td23"','class="td25"','class="td23"','class="td29"', 'class="td25"',''), array(
				($mknum ?'<a href="javascript:;" class="right" onclick="toggle_group(\'mokuai_'.$row['groupid'].'\', this)">[+]</a>':'')."<input class=\"checkbox\" type=\"checkbox\" name=\"delgroup[]\" value=\"$row[groupid]\">",
				'<input type="text" class="txt" name="displayordergnew['.$row['groupid'].']" value="'.$row['displayorder'].'" size="1" />',
				$mokuaiico.'<input type="hidden" name="mokuainamenew['.$row['mokuaiid'].']" value="'.$row['mokuainame'].'">',
				'<div>'.$row['mokuaititle'].'('.$row['mokuainame'].')<a href="'.ADMINSCRIPT.'?action=plugins&identifier=wxq123&pmod=servermokuai&submod=editmokuai&groupid='.$row['groupid'].'"  class="addchildboard">'.lang('plugin/wxq123','add_ver').'</a></div>',
				'',
				'',
				'',
				'',
				"<a href=\"".ADMINSCRIPT."?action=plugins&identifier=wxq123&pmod=servermokuai&submod=groupedit&groupid=$row[groupid]\" class=\"act\">".lang('plugin/wxq123','edit')."</a>",
			));
			$query1 = DB::query("SELECT * FROM ".DB::table('wxq123_server_mokuai')." WHERE groupid=".$row['groupid']." order by displayorder asc");
			$kk = 0;
			showtagheader('tbody', 'mokuai_'.$row['groupid'], false);
			while($row1 = DB::fetch($query1)) {
				showtablerow('', array('class="td25"','class="td25"', 'class="td25"', 'class="td23"','class="td25"','class="td23"','class="td29"', 'class="td25"',''), array(
					"<input class=\"checkbox\" type=\"checkbox\" name=\"delmokuai[]\" value=\"$row1[mokuaiid]\">",
					"<div class=\"".($kk == $mknum ? 'board' : 'lastboard')."\">&nbsp;</div>",
					'<input type="text" class="txt" name="displayordermnew['.$row1['mokuaiid'].']" value="'.$row1['displayorder'].'" size="1" />',
					'('.$row1['mokuaiid'].')',
					$row1['versionname'],
					$row1['mokuaipice'],
					$row1['mokuaidescription'],
					$row1['status'] == 0 ? lang('plugin/wxq123','designing') :($row1['status'] == 1 ? lang('plugin/wxq123','open') :lang('plugin/wxq123','close')),
					"<a href=\"".ADMINSCRIPT."?action=plugins&identifier=wxq123&pmod=servermokuai&submod=editmokuai&groupid=$row[groupid]&mokuaiid=$row1[mokuaiid]\" class=\"act\">".lang('plugin/wxq123','edit')."</a>&nbsp;&nbsp;<a href=\"".ADMINSCRIPT."?action=plugins&identifier=wxq123&pmod=servermokuai&submod=setting&groupid=$row[groupid]&mokuaiid=$row1[mokuaiid]\" class=\"act\">".lang('plugin/wxq123','mokuai_setting')."</a>&nbsp;&nbsp;<a href=\"".ADMINSCRIPT."?action=plugins&identifier=wxq123&pmod=servermokuai&submod=shop&groupid=$row[groupid]&mokuaiid=$row1[mokuaiid]\" class=\"act\">".lang('plugin/wxq123','mokuai_shop')."</a>&nbsp;&nbsp;<a href=\"".ADMINSCRIPT."?action=plugins&identifier=wxq123&pmod=servermokuai&submod=goods&groupid=$row[groupid]&mokuaiid=$row1[mokuaiid]\" class=\"act\">".lang('plugin/wxq123','mokuai_goods')."</a>".($row1['status'] == 0 ? "&nbsp;&nbsp;<a href=\"".ADMINSCRIPT."?action=plugins&identifier=wxq123&pmod=servermokuai&submod=designmokuai&groupid=$row[groupid]&mokuaiid=$row1[mokuaiid]\" class=\"act\">".lang('plugin/wxq123','design')."</a>":''),
				));
			}
			showtagfooter('tbody');
			$kk++;
		}
		echo '<tr><td></td><td colspan="8"><div><a href="'.ADMINSCRIPT.'?action=plugins&identifier=wxq123&pmod=servermokuai&submod=groupedit" class="addtr">'.lang('plugin/wxq123','add_mokuai').'</a></div></td></tr>';
		showsubmit('submit','submit','del');
		showtablefooter();
		showformfooter();
	}else{
		if($idg = $_GET['delgroup']) {
			$idg = dintval($idg, is_array($idg) ? true : false);
			if($idg) {
				DB::delete('wxq123_server_mokuai_group', DB::field('groupid', $idg));
			}
		}
		if($idm = $_GET['delmokuai']) {
			$idm = dintval($idm, is_array($idm) ? true : false);
			if($idm) {
				foreach ( $idm as $k=>$v) {
					rmdirs(DISCUZ_ROOT.'source/plugin/wxq123/server/mokuai/ver'.$v.'/');
				}
				DB::delete('wxq123_server_mokuai', DB::field('mokuaiid', $idm));
			}
		}
		$displayordergnew = $_GET['displayordergnew'];
		if(is_array($displayordergnew)) {
			foreach ( $displayordergnew as $k=>$v) {
				$data['displayorder'] = intval($v);
				DB::update('wxq123_server_mokuai_group',$data,array('groupid'=>$k));
			}
		}
		$displayordermnew = $_GET['displayordermnew'];
		if(is_array($displayordermnew)) {
			foreach ( $displayordermnew as $k=>$v) {
				$data['displayorder'] = intval($v);
				DB::update('wxq123_server_mokuai',$data,array('mokuaiid'=>$k));
			}
		}
		cpmsg(lang('plugin/wxq123', 'mokuai_edit_succeed'), 'action=plugins&identifier=wxq123&pmod=servermokuai', 'succeed');
	}
//模块组编辑
}elseif($submod == 'groupedit'){
	if(!submitcheck('submit')) {
		if($group_info['mokuaiico']!='') {
			$mokuaiico = str_replace('{STATICURL}', STATICURL, $group_info['mokuaiico']);
			if(!preg_match("/^".preg_quote(STATICURL, '/')."/i", $mokuaiico) && !(($valueparse = parse_url($mokuaiico)) && isset($valueparse['host']))) {
				$mokuaiico = $_G['setting']['attachurl'].'common/'.$group_info['mokuaiico'].'?'.random(6);
			}
			$mokuaiicohtml = '<br /><label><input type="checkbox" class="checkbox" name="delete" value="yes" /> '.$lang['del'].'</label><br /><img src="'.$mokuaiico.'" width="40" height="40"/>';
		}
		showformheader('plugins&identifier=wxq123&pmod=servermokuai&submod=groupedit','enctype');
		showtableheader(lang('plugin/wxq123','mokuai_edit'));
		$groupid ? showhiddenfields($hiddenfields = array('groupid'=>$groupid)) : '';
		$mokuai_dir = DISCUZ_ROOT.'source/plugin/wxq123/server/mokuai/'.$group_info['mokuainame'];
		showsetting(lang('plugin/wxq123','mokuainame'),'mokuainame',$group_info['mokuainame'],'text','',0,lang('plugin/wxq123','mokuainame_comment'),'','',true);
		showsetting(lang('plugin/wxq123','mokuaititle'),'mokuaititle',$group_info['mokuaititle'],'text','',0,lang('plugin/wxq123','mokuaititle_comment'),'','',true);
		showsetting(lang('plugin/wxq123','mokuaiico'),'mokuaiico',$group_info['mokuaiico'],'filetext','','',lang('plugin/wxq123','mokuaiico_comment').$mokuaiicohtml,'','',true);
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
		if ($groupid && DB::result_first("SELECT count(*) FROM ".DB::table('wxq123_server_mokuai_group')." WHERE mokuainame='".$data['mokuainame']."' and groupid <> ".$groupid)){
			cpmsg(lang('plugin/wxq123','mokuainame_err'));
		}
		$data['mokuaititle'] = htmlspecialchars(trim($_GET['mokuaititle']));
		$data['mokuaiico'] = $mokuaiico;
		if($groupid) {
			DB::update('wxq123_server_mokuai_group',$data,array('groupid'=>$groupid));
		}else{
			DB::insert('wxq123_server_mokuai_group',$data);
		}
		cpmsg(lang('plugin/wxq123', 'mokuai_edit_succeed'), 'action=plugins&identifier=wxq123&pmod=servermokuai&submod=list', 'succeed');
	}
//编辑模块
}elseif($submod == 'editmokuai'){
	if(!submitcheck('submit')) {
		if($group_info['mokuaiico']!='') {
			$mokuaiico = str_replace('{STATICURL}', STATICURL, $group_info['mokuaiico']);
			if(!preg_match("/^".preg_quote(STATICURL, '/')."/i", $mokuaiico) && !(($valueparse = parse_url($mokuaiico)) && isset($valueparse['host']))) {
				$mokuaiico = $_G['setting']['attachurl'].'common/'.$group_info['mokuaiico'].'?'.random(6);
			}
		}

		$status_select = '<select name="status"><option value="0" '.($mokuai_info['status']==0?' selected':'').'>'.lang('plugin/wxq123','design').'</option><option value="1" '.($mokuai_info['status']==1?' selected':'').'>'.lang('plugin/wxq123','open').'</option><option value="2" '.($mokuai_info['status']==2?' selected':'').'>'.lang('plugin/wxq123','close').'</option></select>';
		showtips(lang('plugin/wxq123','mokuai_edit_tips'));
		showformheader('plugins&identifier=wxq123&pmod=servermokuai&submod=editmokuai');
		showtableheader(lang('plugin/wxq123','mokuai_edit'));
		showhiddenfields($hiddenfields = array('groupid'=>$groupid));
		$mokuaiid ? showhiddenfields($hiddenfields = array('mokuaiid'=>$mokuaiid)) : '';
		showsetting(lang('plugin/wxq123','mokuainame'),'','',$mokuaiico.$group_info['mokuaititle'].$group_info['mokuainame']);
		showsetting(lang('plugin/wxq123','versionname'),'versionname',$mokuai_info['versionname'],'text');
		showsetting(lang('plugin/wxq123','mokuaipice'),'mokuaipice',$mokuai_info['mokuaipice'],'text');
		showsetting(lang('plugin/wxq123','mokuaidescription'),'mokuaidescription',$mokuai_info['mokuaidescription'],'textarea');
		showsetting(lang('plugin/wxq123','status'),'','',$status_select,'','',lang('plugin/wxq123','status_comment'));
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
			DB::update('wxq123_server_mokuai',$data,array('mokuaiid'=>$mokuaiid));
		}else{
			DB::insert('wxq123_server_mokuai',$data);
			$mokuaiid = DB::insert_id();
		}
		if($mokuaiid) {
			$mokuai_dir = DISCUZ_ROOT.'source/plugin/wxq123/server/mokuai/ver'.$mokuaiid;
			if(!is_dir($mokuai_dir)) {
				dmkdir($mokuai_dir);
				dmkdir($mokuai_dir.'/admin');
				dmkdir($mokuai_dir.'/module');
				dmkdir($mokuai_dir.'/template');
				file_put_contents($mokuai_dir.'/lang.php',"<?php\n\$mokuailang = array(\n\t''=>'',\n);\n?>");
			}
		}
		cpmsg(lang('plugin/wxq123', 'mokuai_edit_succeed'), 'action=plugins&identifier=wxq123&pmod=servermokuai', 'succeed');
	}
//模块预览
}elseif($submod == 'viewmokuai'){
	echo $mokuaiid;
//模块设计
}elseif($submod == 'designmokuai'){
	if(!submitcheck('submit')) {
		showtips(lang('plugin/wxq123','edit').$group_info['mokuaititle'].$mokuai_info['versionname']);
		showformheader('plugins&identifier=wxq123&pmod=servermokuai&submod=designmokuai');
		showtableheader();
		showsubtitle(array('', lang('plugin/wxq123','displayorder'),lang('plugin/wxq123','filename'), lang('plugin/wxq123','menu'), lang('plugin/wxq123','type'), lang('plugin/wxq123','description'),lang('plugin/wxq123','status'), ''));
		$admin_dir = DISCUZ_ROOT.'source/plugin/wxq123/server/mokuai/ver'.$mokuaiid.'/admin/';
		$admin_file_array = read_file($admin_dir);
		//var_dump($admin_file_array);
		showtagheader('tbody', 'admin', true);
		showtagfooter('tbody');
		showtablefooter();
		showtableheader(lang('plugin/wxq123','mokuai_admin'));
		echo '<tr><td></td><td colspan="7"><div><a href="'.ADMINSCRIPT.'?action=plugins&identifier=wxq123&pmod=servermokuai&submod=adminedit&groupid='.$groupid.'&mokuaiid='.$mokuaiid.'" class="addtr">'.lang('plugin/wxq123','add_admin').'</a></div></td></tr>';
		showtablefooter();
		showtableheader(lang('plugin/wxq123','mokuai_module'));
		echo '<tr><td></td><td colspan="7"><div><a href="'.ADMINSCRIPT.'?action=plugins&identifier=wxq123&pmod=servermokuai&submod=moduleedit&groupid='.$groupid.'&mokuaiid='.$mokuaiid.'" class="addtr">'.lang('plugin/wxq123','add_module').'</a></div></td></tr>';
		showtablefooter();
		showtableheader(lang('plugin/wxq123','mokuai_template'));
		echo '<tr><td></td><td colspan="7"><div><a href="'.ADMINSCRIPT.'?action=plugins&identifier=wxq123&pmod=servermokuai&submod=templateedit&groupid='.$groupid.'&mokuaiid='.$mokuaiid.'" class="addtr">'.lang('plugin/wxq123','add_template').'</a></div></td></tr>';
		showsubmit('submit','submit','del');
		showformfooter();
	}else{
	}
//后台页面
}elseif($submod == 'adminedit'){
	if(!submitcheck('submit')) {
		showtips(lang('plugin/wxq123','edit').$group_info['mokuaititle'].$mokuai_info['versionname'].lang('plugin/wxq123','mokuai_admin').$filename);
		showformheader('plugins&identifier=wxq123&pmod=servermokuai&submod=adminedit&groupid='.$groupid.'&mokuaiid='.$mokuaiid);
		showhiddenfields($hiddenfields = array('groupid'=>$groupid));
		showhiddenfields($hiddenfields = array('mokuaiid'=>$mokuaiid));
		showtableheader(lang('plugin/wxq123','mokuai_admin'));
		$filename ? showhiddenfields($hiddenfields = array('filename'=>$filename)) :showsetting(lang('plugin/wxq123','filename'),'filename','','text');
		showsetting(lang('plugin/wxq123','menu'),'filemenu','','text');
		showsetting(lang('plugin/wxq123','type'),'filetype','','text');
		showsetting(lang('plugin/wxq123','conment'),'fileconment','','textarea');
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
}elseif($submod == 'moduleedit'){
	if(!submitcheck('submit')) {
		showtips(lang('plugin/wxq123','edit').$group_info['mokuaititle'].$mokuai_info['versionname'].lang('plugin/wxq123','mokuai_module').$filename);
		showformheader('plugins&identifier=wxq123&pmod=servermokuai&submod=moduleedit&groupid='.$groupid.'&mokuaiid='.$mokuaiid);
		showtableheader(lang('plugin/wxq123','mokuai_module'));
		showsubmit('submit');
		showformfooter();
	}else{
	}
//模版页面
}elseif($submod == 'templateedit'){
	if(!submitcheck('submit')) {
		showtips(lang('plugin/wxq123','edit').$group_info['mokuaititle'].$mokuai_info['versionname'].lang('plugin/wxq123','mokuai_template'.$filename));
		showformheader('plugins&identifier=wxq123&pmod=servermokuai&submod=adminedit&groupid='.$groupid.'&mokuaiid='.$mokuaiid);
		showtableheader(lang('plugin/wxq123','mokuai_template'));
		showsubmit('submit');
		showformfooter();
	}else{
	}
//设置、商家、产品页面
}elseif(in_array($submod,array('setting','shop','goods'))){
	$mokuainame = 'ver'.$mokuaiid;
	$adminfile = DISCUZ_ROOT.'source/plugin/wxq123/server/mokuai/ver'.$mokuaiid.'/admin/'.$submod.'.php';
	if (!file_exists($adminfile)){
		file_put_contents($adminfile,"<?php\n\n?>");
	}
	$basepage = 'plugins&identifier=wxq123&pmod=servermokuai&submod='.$submod.'&groupid='.$groupid.'&mokuaiid='.$mokuaiid;
	require_once DISCUZ_ROOT.'source/plugin/wxq123/server/mokuai/ver'.$mokuaiid.'/lang.php';
	//require_once DISCUZ_ROOT.'source/plugin/wxq123/server/mokuai/ver'.$mokuaiid.'/install.php';
	echo $group_info['mokuaititle'].$mokuai_info['versionname'].'--'.lang('plugin/wxq123','mokuai_admin').'--'.lang('plugin/wxq123','mokuai_'.$submod).'&nbsp;&nbsp;&nbsp;&nbsp;<a href="'.ADMINSCRIPT.'?action='.$basepage.'">'.lang('plugin/wxq123','shuaxin').'</a>';
	require_once $adminfile;
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
?>
