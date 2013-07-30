<?php

/**
*	一起学吧平台程序
*	插件安装
*	文件名：clientinstall.php  创建时间：2013-5-31 00:32  杨文
*
*/

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
$this_page = 'plugins&identifier=yiqixueba_server&pmod=admincp&submod=clientinstall';
$subop = getgpc('subop');
$subops = array('base');
$subop = in_array($subop,$subops) ? $subop : $subops[0];

if($subop == 'base') {
	$install_s = getgpc('install_s');
	if(!submitcheck('submit')) {
		$file_contents = file(DISCUZ_ROOT.'/source/plugin/yiqixueba_server/source/client/install.php');
		foreach ( $file_contents as $k=>$v) {
			if(strpos($v,"EOF;")!==false) {
				$start = $k;
			}
		}
		$start = $start ?$start:13;
		for($i=$start+1;$i<count($file_contents)-1;$i++) {
			$file_contentst .= $file_contents[$i];
		}
		
		$install_status = array('firstinstall');
		$install_status_select = '<select name="install_s">';
		foreach ( $install_status as $k=>$v) {
			$install_status_select .= '<option value="'.$v.'" '.($install_s == $v ? ' selected':'').'>'.lang('plugin/yiqixueba_server', $v).'<option>';
		}
		$install_status_select .= '</select>';
		showformheader($this_page.'&subop=base');
		showtableheader(lang('plugin/yiqixueba_server','mainpro_base'));
		showsetting(lang('plugin/yiqixueba_server','current_status'),'','',$install_status_select,'',0,lang('plugin/yiqixueba_server','current_status_comment'),'','',true);
		showsetting(lang('plugin/yiqixueba_server','pagecontents'),'pagecontents',htmlspecialchars_decode($file_contentst),'textarea','','',lang('plugin/yiqixueba_server','pagecontents_comment'),'','',true);
		showsubmit('submit');
		showtablefooter();
		showformfooter();
	}else{
		$tablepre = $_G['config']['db'][1]['tablepre'];
		$db = & DB::object();
		//require_once libfile('function/attachment');
		$discuz_tables = fetchtablelist($tablepre);
		$dztables = array();
		foreach($discuz_tables as $table) {
			if(strpos($table['Name'],'yiqixueba_client')) {
				$sqldump .= sqldumptablestruct($table['Name'])."\n";
			}
		}
		$file_contentst .= "\$sql = <<<EOF \n".$sqldump."EOF;\n";
		file_put_contents(DISCUZ_ROOT.'/source/plugin/yiqixueba_server/source/client/install.php', "<?php\n\n/**\n*\t一起学吧平台程序\n*\t".lang('plugin/yiqixueba_server',$current_group.'_'.$submod)."\n*\t文件名：install.php  创建时间：".dgmdate(time(),'dt')."  杨文\n*\n*/\n\nif(!defined('IN_DISCUZ')) {\n\texit('Access Denied');\n}\n\n\$sql =  <<<EOF \n".$sqldump."EOF;\n".$_GET['pagecontents']."\n?>");
		//require_once DISCUZ_ROOT.'/source/plugin/yiqixueba_server/source/client/install.php';
		cpmsg(lang('plugin/yiqixueba_server', 'install_succeed'), 'action='.$this_page.'&subop=list', 'succeed');
	}
}

function fetchtablelist($tablepre = '') {
	global $db;
	$arr = explode('.', $tablepre);
	$dbname = isset($arr[1]) && $arr[1] ? $arr[0] : '';
	$tablepre = str_replace('_', '\_', $tablepre);
	$sqladd = $dbname ? " FROM $dbname LIKE '$arr[1]%'" : "LIKE '$tablepre%'";
	$tables = $table = array();
	$query = $db->query("SHOW TABLE STATUS $sqladd");
	while($table = $db->fetch_array($query)) {
		$table['Name'] = ($dbname ? "$dbname." : '').$table['Name'];
		$tables[] = $table;
	}
	return $tables;
}

function sqldumptablestruct($table) {
	global $db;

	$createtable = $db->query("SHOW CREATE TABLE $table", 'SILENT');

	if(!$db->error()) {
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

	$tablestatus = $db->fetch_first("SHOW TABLE STATUS LIKE '$table'");
	$tabledump .= ($tablestatus['Auto_increment'] ? " AUTO_INCREMENT=$tablestatus[Auto_increment]" : '').";\n\n";
	return $tabledump;
}

?>