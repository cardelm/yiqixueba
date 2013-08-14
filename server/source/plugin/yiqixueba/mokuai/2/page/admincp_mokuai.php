<?php
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
$this_page = substr($_SERVER['QUERY_STRING'],7,strlen($_SERVER['QUERY_STRING'])-7);
stripos($this_page,'subop=') ? $this_page = substr($this_page,0,stripos($this_page,'subop=')-1) : $this_page;

$subop = getgpc('subop');
$subops = array('mokuailist','mokuaiedit','pagelist','pageedit','versionlist','shuaxin','huanyuan','pluginlang','currentver','mokuaimake');
$subop = in_array($subop,$subops) ? $subop : $subops[0];

$mokuaiid = getgpc('mokuaiid');
$mokuai_info = $mokuaiid ? DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_server_mokuai')." WHERE mokuaiid=".$mokuaiid) : array();


if($subop == 'mokuailist') {
	if(!submitcheck('submit')) {
		showtips(lang('plugin/'.$plugin['identifier'],'mokuai_list_tips'));
		showformheader($this_page.'&subop=mokuailist');
		showtableheader(lang('plugin/'.$plugin['identifier'],'mokuai_list'));
		showsubtitle(array('', lang('plugin/'.$plugin['identifier'],'mokuai_name'),lang('plugin/'.$plugin['identifier'],'mokuai_description'),lang('plugin/'.$plugin['identifier'],'mokuai_status')));
		$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_server_mokuai')." group by identifier order by displayorder asc");
		while($row = DB::fetch($query)) {
			$zhuanhuanen_ids = array();//是否已经转换插件数组
			$zhuanhuanen_ids[] = 'yiqixueba_'.$row['identifier'];//转换之后去掉了yiqixuaba_，需要再加上
			$ver_text = $currenver_text = '';
			$query1 = DB::query("SELECT * FROM ".DB::table('yiqixueba_server_mokuai')." WHERE identifier = '".$row['identifier']."' order by createtime asc");
			$verk = 0;
			while($row1 = DB::fetch($query1)) {
				$ver_text .= ($verk ==0 ? '' :'&nbsp;&nbsp;|&nbsp;&nbsp;')."<input class=\"checkbox\" type=\"checkbox\" name=\"vernew[".$row1['mokuaiid']."]\" value=\"1\" ".($row1['available'] > 0 ? 'checked' : '').">&nbsp;&nbsp;<a href=\"".ADMINSCRIPT."?action=".$this_page."&subop=currentver&mokuaiid=$row1[mokuaiid]\" >".$row1['version'].'</a>';
				if($row1['currentversion']){
					$currenver_text = $row1['version'];
				}
				$verk++;
			}
			$currenver_text =$currenver_text ? $currenver_text : $row['version'];
			$currenver_text ? $currenver_text : DB::update('yiqixueba_server_mokuai', array('currentversion'=>1),array('identifier'=>$row['identifier'],'version'=>$currenver_text));
			showtablerow('', array('style="width:45px"', 'valign="top" style="width:320px"', 'valign="top"', 'align="right" valign="top" style="width:200px"'), array(
				$mokuaiico ?'<img src="'.$mokuaiico.'" width="40" height="40" align="left" style="margin-right:5px" />' : '<img src="'.cloudaddons_pluginlogo_url($row['identifier']).'" onerror="this.src=\'static/image/admincp/plugin_logo.png\';this.onerror=null" width="40" height="40" align="left" />',
				'<span class="bold">'.$row['name'].'-'.$currenver_text.($filemtime > TIMESTAMP - 86400 ? ' <font color="red">New!</font>' : '').'</span>  <span class="sml">('.str_replace("yiqixueba_","",$row['identifier']).')</span><br />'.$ver_text.'<br />',
				$row['description'],
				"<a href=\"".ADMINSCRIPT."?action=".$this_page."&subop=pluginlang&mokuaiid=$row[mokuaiid]\" >".lang('plugin/'.$plugin['identifier'],'pluginlang')."</a>&nbsp;&nbsp;<a href=\"".ADMINSCRIPT."?action=".$this_page."&subop=shuaxin&mokuaiid=$row[mokuaiid]\" >".lang('plugin/'.$plugin['identifier'],'shuaxin')."</a>&nbsp;&nbsp;<a href=\"".ADMINSCRIPT."?action=".$this_page."&subop=pagelist&mokuaiid=$row[mokuaiid]\" >".lang('plugin/'.$plugin['identifier'],'pagelist')."</a>&nbsp;&nbsp;<a href=\"".ADMINSCRIPT."?action=".$this_page."&subop=mokuaiedit&mokuaiid=$row[mokuaiid]\" >".lang('plugin/'.$plugin['identifier'],'edit')."</a>&nbsp;&nbsp;<a href=\"".ADMINSCRIPT."?action=".$this_page."&subop=mokuaimake&mokuaiid=$row[mokuaiid]\" >".lang('plugin/'.$plugin['identifier'],'mokuai_make')."</a><br /><br />".lang('plugin/'.$plugin['identifier'],'status')."<input class=\"checkbox\" type=\"checkbox\" name=\"statusnew[".$row['mokuaiid']."]\" value=\"1\" ".($row['available'] > 0 ? 'checked' : '').">&nbsp;&nbsp;".lang('plugin/'.$plugin['identifier'],'displayorder')."<INPUT type=\"text\" name=\"newdisplayorder[]\" value=\"".$row['displayorder']."\" size=\"2\">",
			));
		}
		echo '<tr><td></td><td colspan="3"><div><a href="'.ADMINSCRIPT.'?action='.$this_page.'&subop=mokuaiedit" class="addtr" >'.lang('plugin/'.$plugin['identifier'],'add_mokuai').'</a></div></td></tr>';
		showsubmit('submit');
		showtablefooter();
		showformfooter();
	}else{
		DB::update('yiqixueba_server_mokuai', array('available'=>0));
		foreach( getgpc('vernew') as $k=>$v ){
			if($v){
				DB::update('yiqixueba_server_mokuai', array('available'=>1),array('mokuaiid'=>$k));
			}
		}
		cpmsg(lang('plugin/'.$plugin['identifier'],'mokuai_main_succeed'), 'action='.$this_page.'&subop=mokuailist', 'succeed');
	}
}elseif ($subop == 'mokuaiedit'){
	if(!submitcheck('submit')) {
		showtips(lang('plugin/'.$plugin['identifier'],$mokuaiid ?'edit_mokuai_tips':'add_mokuai_tips'));
		showformheader($this_page.'&subop=mokuaiedit');
		showtableheader(lang('plugin/'.$plugin['identifier'],'mokuai_edit'));
		$mokuaiid ? showhiddenfields(array('mokuaiid'=>$mokuaiid)) : '';
		showsetting(lang('plugin/'.$plugin['identifier'],'mokuai_edit_identifier'),'mokuai_identifier',$mokuai_info['identifier'],'text','',0,lang('plugin/'.$plugin['identifier'],'mokuai_edit_identifier_comment'),'','',true);
		showsetting(lang('plugin/'.$plugin['identifier'],'mokuai_edit_name'),'name',$mokuai_info['name'],'text','',0,lang('plugin/'.$plugin['identifier'],'mokuai_edit_name_comment'),'','',true);
		showsetting(lang('plugin/'.$plugin['identifier'],'mokuai_edit_version'),'version',$mokuai_info['version'],'text','',0,lang('plugin/'.$plugin['identifier'],'mokuai_edit_version_comment'),'','',true);
		showsetting(lang('plugin/'.$plugin['identifier'],'mokuai_edit_description'),'description',$mokuai_info['description'],'textarea','',0,lang('plugin/'.$plugin['identifier'],'mokuai_edit_description_comment'),'','',true);
		showsetting(lang('plugin/'.$plugin['identifier'],'mokuai_edit_ico'),'ico',$mokuai_info['ico'],'filetext','',0,lang('plugin/'.$plugin['identifier'],'mokuai_edit_ico_comment'),'','',true);
		showsubmit('submit');
		showtablefooter();
		showformfooter();
	} else {
		$mokuai_identifier	= trim($_GET['mokuai_identifier']);
		$mokuai_name	= dhtmlspecialchars(trim($_GET['name']));
		$mokuai_version	= strip_tags(trim($_GET['version']));
		$mokuai_description	= dhtmlspecialchars(trim($_GET['description']));

		if(!$mokuai_identifier){
			cpmsg(lang('plugin/'.$plugin['identifier'],'mokuai_identifier_invalid'), '', 'error');
		}
		if(!$mokuai_name){
			cpmsg(lang('plugin/'.$plugin['identifier'],'mokuai_name_invalid'), '', 'error');
		}
		if(!$mokuai_version){
			cpmsg(lang('plugin/'.$plugin['identifier'],'mokuai_version_invalid'), '', 'error');
		}
		if(!ispluginkey($mokuai_identifier)) {
			cpmsg(lang('plugin/'.$plugin['identifier'],'mokuai_identifier_invalid'), '', 'error');
		}
		if(!$mokuaiid&&DB::result_first("SELECT count(*) FROM ".DB::table('yiqixueba_server_mokuai')." WHERE identifier='".$mokuai_identifier."' and version = '".$mokuai_version."'")){
			cpmsg(lang('plugin/'.$plugin['identifier'],'mokuai_identifier_invalid'), '', 'error');
		}
		$data = array(
			'name' => $mokuai_name,
			'version' => $mokuai_version,
			'identifier' => $mokuai_identifier,
			'description' => $mokuai_description,
		);
		if($mokuaiid){
			$data['updatetime'] = time();
			DB::update('yiqixueba_server_mokuai', $data,array('mokuaiid'=>$mokuaiid));
		}else{
			$data['createtime'] = time();
			DB::insert('yiqixueba_server_mokuai', $data);
		}
		cpmsg(lang('plugin/'.$plugin['identifier'],'add_mokuai_succeed'), 'action='.$this_page.'&subop=mokuailist', 'succeed');
	}
}elseif ($subop == 'pluginlang'){
	$pluginfile_array = $plugin_lang = array();
	//$pluginfile_array = get_plugin_file(DISCUZ_ROOT.'source/plugin/'.$plugin_info['directory']);
	if(!submitcheck('submit')) {
		showtips(lang('plugin/'.$plugin['identifier'],'mokuai_list_tips'));
		showformheader($this_page.'&subac=pluginlang&pluginid='.$pluginid);
		foreach($pluginfile_array as $k=>$v ){
			showtableheader(lang('plugin/'.$plugin['identifier'],'mokuai_pluginlang_list').$v['file']);
			//$plugin_lang = get_plugin_lang($v['file']);
			//array_unique($plugin_lang);
			foreach($plugin_lang as $k1=>$v1 ){
				showtablerow('', array('class="td29"', 'class="td28"'), array(
					lang('plugin/'.$plugin['identifier'],'english').$v1['en'],
					lang('plugin/'.$plugin['identifier'],'chinese').'<TEXTAREA name="script_lang['.$v1['en'].']" rows="3" cols="30">'.$v1['cn'].'</TEXTAREA>',
				));
			}
			showtablefooter();
		}
		showsubmit('submit');
		showtablefooter();
		showformfooter();
	}else{
		//$script_lang = getgpc('script_lang');
		//write_scriptlang_file($pluginid,$script_lang);
		cpmsg(lang('plugin/'.$plugin['identifier'], 'mokuai_langedit_succeed'), 'action='.$this_page.'&subac=mokuailist', 'succeed');
	}
}elseif ($subop == 'pagelist'){
	if(!submitcheck('submit')) {
		showtips(lang('plugin/'.$plugin['identifier'],'page_list_tips'));
		showformheader($this_page.'&subop=pagelist&mokuaiid='.$mokuaiid);
		showtableheader(lang('plugin/'.$plugin['identifier'],'page_list').'&nbsp;&nbsp;'.$mokuai_info['name']);
		showsubtitle(array('', lang('plugin/'.$plugin['identifier'],'page_identifier'),lang('plugin/'.$plugin['identifier'],'page_name'),lang('plugin/'.$plugin['identifier'],'page_type'),lang('plugin/'.$plugin['identifier'],'page_description'),lang('plugin/'.$plugin['identifier'],'displayorder'),lang('plugin/'.$plugin['identifier'],'status')));
		$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_server_pages')." WHERE mokuaiid= ".$mokuaiid." order by displayorder asc");
		while($row = DB::fetch($query)) {
			showtablerow('', array('class="td25"', 'class="td28"','class="td28"', 'class="td28"','class="td29"', 'class="td25"', 'class="td25"'), array(
				"<input class=\"checkbox\" type=\"checkbox\" name=\"delete[]\" value=\"".$row['pageid']."\">",
				$row['identifier'],
				$row['name'],
				$row['type'],
				$row['description'],
				"<INPUT type=\"text\" name=\"newdisplayorder[".$row['pageid']."]\" value=\"".$row['displayorder']."\" size=\"2\">",
				"<input class=\"checkbox\" type=\"checkbox\" name=\"statusnew[".$row['pageid']."]\" value=\"1\" ".($row['available'] > 0 ? 'checked' : '').">",
				"<a href=\"".ADMINSCRIPT."?action=".$this_page."&subop=pageedit&pageid=$row[pageid]\" >".lang('plugin/'.$plugin['identifier'],'edit')."</a>",
			));
		}
		echo '<tr><td></td><td colspan="7"><div><a href="'.ADMINSCRIPT.'?action='.$this_page.'&subop=pageedit&mokuaiid='.$mokuaiid.'" class="addtr" >'.lang('plugin/'.$plugin['identifier'],'add_page').'</a></div></td></tr>';
		showsubmit('submit');
		showtablefooter();
		showformfooter();
	}else{
		if($idg = $_GET['delete']) {
			$idg = dintval($idg, is_array($idg) ? true : false);
			if($idg) {
				DB::delete('yiqixueba_server_pages', DB::field('pageid', $idg));
			}
		}
		foreach(getgpc('newdisplayorder') as $k=>$v ){
			DB::update('yiqixueba_server_pages', array('displayorder'=>$v),array('pageid'=>$k));
		}
		DB::update('yiqixueba_server_pages', array('available'=>0));
		foreach( getgpc('statusnew') as $k=>$v ){
			if($v){
				DB::update('yiqixueba_server_pages', array('available'=>1),array('pageid'=>$k));
			}
		}
		//dump(getgpc('statusnew'));
		cpmsg(lang('plugin/'.$plugin['identifier'],'page_edit_succeed'), 'action='.$this_page.'&subop=pagelist&mokuaiid='.$mokuaiid, 'succeed');
	}
}elseif ($subop == 'pageedit'){
	$pageid = getgpc('pageid');
	$page_info = $pageid ? DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_server_pages')." WHERE pageid=".$pageid) : array();
	$mokuaiid = $mokuaiid ? $mokuaiid : $page_info['mokuaiid'];
	$mokuai_info = $mokuaiid ? DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_server_mokuai')." WHERE mokuaiid=".$mokuaiid) : array();
	if(!submitcheck('submit')) {
		showtips(lang('plugin/'.$plugin['identifier'],$pageid ?'edit_page_tips':'add_page_tips'));
		showformheader($this_page.'&subop=pageedit');
		showtableheader(lang('plugin/'.$plugin['identifier'],'page_edit').'&nbsp;&nbsp;'.$mokuai_info['name']);
		$pageid ? showhiddenfields(array('pageid'=>$pageid)) : '';
		$mokuaiid ? showhiddenfields(array('mokuaiid'=>$mokuaiid)) : '';
		showsetting(lang('plugin/'.$plugin['identifier'],'page_identifier'),'page_identifier',$page_info['identifier'],'text','',0,lang('plugin/'.$plugin['identifier'],'page_identifier_comment'),'','',true);
		showsetting(lang('plugin/'.$plugin['identifier'],'page_name'),'name',$page_info['name'],'text','',0,lang('plugin/'.$plugin['identifier'],'page_name_comment'),'','',true);
		showsetting(lang('plugin/'.$plugin['identifier'],'page_type'),array('type',array(array('',lang('plugin/'.$plugin['identifier'],'page_type')),array('admincp','admincp'),array('member','member'),array('index','index'))),$page_info['type'],'select','',0,lang('plugin/'.$plugin['identifier'],'page_type_comment'),'','',true);
		showsetting(lang('plugin/'.$plugin['identifier'],'page_description'),'description',$page_info['description'],'textarea','',0,lang('plugin/'.$plugin['identifier'],'page_description_comment'),'','',true);
		showsubmit('submit');
		showtablefooter();
		showformfooter();
	} else {
		$page_identifier	= trim($_GET['page_identifier']);
		$page_name	= dhtmlspecialchars(trim($_GET['name']));
		$page_type	= strip_tags(trim($_GET['type']));
		$page_description	= dhtmlspecialchars(trim($_GET['description']));

		if(!$page_identifier){
			cpmsg(lang('plugin/'.$plugin['identifier'],'page_identifier_invalid'), '', 'error');
		}
		if(!$page_name){
			cpmsg(lang('plugin/'.$plugin['identifier'],'page_name_invalid'), '', 'error');
		}
		if(!$page_type){
			cpmsg(lang('plugin/'.$plugin['identifier'],'page_version_invalid'), '', 'error');
		}
		if(!ispluginkey($page_identifier)) {
			cpmsg(lang('plugin/'.$plugin['identifier'],'page_identifier_invalid'), '', 'error');
		}
		if(DB::result_first("SELECT count(*) FROM ".DB::table('yiqixueba_server_pages')." WHERE identifier='".$page_identifier."' and type = '".$page_type."'")){
			//cpmsg(lang('plugin/'.$plugin['identifier'],'page_identifier_invalid'), '', 'error');
		}
		$data = array(
			'name' => $page_name,
			'mokuaiid' => $mokuaiid,
			'type' => $page_type,
			'identifier' => $page_identifier,
			'description' => $page_description,
		);
		if($pageid){
			DB::update('yiqixueba_server_pages', $data,array('pageid'=>$pageid));
		}else{
			DB::insert('yiqixueba_server_pages', $data);
		}
		cpmsg(lang('plugin/'.$plugin['identifier'],'page_edit_succeed'), 'action='.$this_page.'&subop=pagelist&mokuaiid='.$mokuaiid, 'succeed');
	}
}elseif ($subop == 'mokuaimake'){
	dump($mokuai_info);
	$mokuai_dir = DISCUZ_ROOT.'source/plugin/yiqixueba/mokuai/'.$mokuaiid;
	if(!is_dir($mokuai_dir)){
		dmkdir($mokuai_dir);
	}

}
$db = & DB::object();
$dumpcharset = str_replace('-', '', $_G['charset']);

//dump(sqldumptablestruct(DB::table('yiqixueba_server_mokuai')));
//dump(sqldumptable(DB::table('yiqixueba_server_mokuai')));
function sqldumptablestruct($table) {
	global $_G, $db, $excepttables;

	if(in_array($table, $excepttables)) {
		return;
	}

	$createtable = DB::query("SHOW CREATE TABLE $table", 'SILENT');


	if(!DB::error()) {
		$tabledump = "DROP TABLE IF EXISTS $table;\n";
	} else {
		return '';
	}

	$create = $db->fetch_row($createtable);

	if(strpos($table, '.') !== FALSE) {
		$tablename = substr($table, strpos($table, '.') + 1);
		$create[1] = str_replace("CREATE TABLE $tablename", 'CREATE TABLE '.$table, $create[1]);
	}
	$tabledump .= $create[1];

	if($_GET['sqlcompat'] == 'MYSQL41' && $db->version() < '4.1') {
		$tabledump = preg_replace("/TYPE\=(.+)/", "ENGINE=\\1 DEFAULT CHARSET=".$dumpcharset, $tabledump);
	}
	if($db->version() > '4.1' && $_GET['sqlcharset']) {
		$tabledump = preg_replace("/(DEFAULT)*\s*CHARSET=.+/", "DEFAULT CHARSET=".$_GET['sqlcharset'], $tabledump);
	}

	$tablestatus = DB::fetch_first("SHOW TABLE STATUS LIKE '$table'");
	$tabledump .= ($tablestatus['Auto_increment'] ? " AUTO_INCREMENT=$tablestatus[Auto_increment]" : '').";\n\n";
	if($_GET['sqlcompat'] == 'MYSQL40' && $db->version() >= '4.1' && $db->version() < '5.1') {
		if($tablestatus['Auto_increment'] <> '') {
			$temppos = strpos($tabledump, ',');
			$tabledump = substr($tabledump, 0, $temppos).' auto_increment'.substr($tabledump, $temppos);
		}
		if($tablestatus['Engine'] == 'MEMORY') {
			$tabledump = str_replace('TYPE=MEMORY', 'TYPE=HEAP', $tabledump);
		}
	}
	return $tabledump;
}
function sqldumptable($table, $startfrom = 0, $currsize = 0) {
	global $_G, $db, $startrow, $dumpcharset, $complete, $excepttables;

	$offset = 300;
	$tabledump = '';
	$tablefields = array();

	$query = DB::query("SHOW FULL COLUMNS FROM $table", 'SILENT');
	if(strexists($table, 'adminsessions')) {
		return ;
	} elseif(!$query && DB::errno() == 1146) {
		return;
	} elseif(!$query) {
		$_GET['usehex'] = FALSE;
	} else {
		while($fieldrow = DB::fetch($query)) {
			$tablefields[] = $fieldrow;
		}
	}
//dump($_GET['extendins'] == '0');
	if(!in_array($table, $excepttables)) {
		$tabledumped = 0;
		$numrows = $offset;
		$firstfield = $tablefields[0];

		if($_GET['extendins'] == '0') {
			while($currsize + strlen($tabledump) + 500 < $_GET['sizelimit'] * 1000 && $numrows == $offset) {
				if($firstfield['Extra'] == 'auto_increment') {
					$selectsql = "SELECT * FROM $table WHERE $firstfield[Field] > $startfrom ORDER BY $firstfield[Field] LIMIT $offset";
				} else {
					$selectsql = "SELECT * FROM $table LIMIT $startfrom, $offset";
				}
				$tabledumped = 1;
				$rows = DB::query($selectsql);
				$numfields = $db->num_fields($rows);

				$numrows = DB::num_rows($rows);
				while($row = $db->fetch_row($rows)) {
					$comma = $t = '';
					for($i = 0; $i < $numfields; $i++) {
						$t .= $comma.($_GET['usehex'] && !empty($row[$i]) && (strexists($tablefields[$i]['Type'], 'char') || strexists($tablefields[$i]['Type'], 'text')) ? '0x'.bin2hex($row[$i]) : '\''.mysql_escape_string($row[$i]).'\'');
						$comma = ',';
					}
					if(strlen($t) + $currsize + strlen($tabledump) + 500 < $_GET['sizelimit'] * 1000) {
						if($firstfield['Extra'] == 'auto_increment') {
							$startfrom = $row[0];
						} else {
							$startfrom++;
						}
						$tabledump .= "INSERT INTO $table VALUES ($t);\n";
					} else {
						$complete = FALSE;
						break 2;
					}
				}
			}
		} else {
//dump($currsize);
//dump($_GET['sizelimit']);
			while($currsize + strlen($tabledump) + 500 < $_GET['sizelimit'] * 1000 && $numrows == $offset) {
				if($firstfield['Extra'] == 'auto_increment') {
					$selectsql = "SELECT * FROM $table WHERE $firstfield[Field] > $startfrom LIMIT $offset";
				} else {
					$selectsql = "SELECT * FROM $table LIMIT $startfrom, $offset";
				}
//dump($selectsql);
				$tabledumped = 1;
				$rows = DB::query($selectsql);
				$numfields = $db->num_fields($rows);

				if($numrows = DB::num_rows($rows)) {
					$t1 = $comma1 = '';
					while($row = $db->fetch_row($rows)) {
						$t2 = $comma2 = '';
						for($i = 0; $i < $numfields; $i++) {
							$t2 .= $comma2.($_GET['usehex'] && !empty($row[$i]) && (strexists($tablefields[$i]['Type'], 'char') || strexists($tablefields[$i]['Type'], 'text'))? '0x'.bin2hex($row[$i]) : '\''.mysql_escape_string($row[$i]).'\'');
							$comma2 = ',';
						}
						if(strlen($t1) + $currsize + strlen($tabledump) + 500 < $_GET['sizelimit'] * 1000) {
							if($firstfield['Extra'] == 'auto_increment') {
								$startfrom = $row[0];
							} else {
								$startfrom++;
							}
							$t1 .= "$comma1 ($t2)";
							$comma1 = ',';
						} else {
							$tabledump .= "INSERT INTO $table VALUES $t1;\n";
							$complete = FALSE;
							break 2;
						}
					}
					$tabledump .= "INSERT INTO $table VALUES $t1;\n";
				}
			}
		}

		$startrow = $startfrom;
		$tabledump .= "\n";
	}

	return $tabledump;
}

?>