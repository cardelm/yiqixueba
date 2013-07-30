<?php

/**
*	卡益联盟服务端程序
*	文件名：mokuai.inc.php 创建时间：2013-7-26 14:56  杨文
*	修改时间：2013-7-29 08:44 杨文
*/

//该文件是整个服务端的核心文件
//所谓转换就是把插件数据表common_plugin和插件变量数据表common_pluginvar中的数据转换成服务端的模块数据
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

require_once DISCUZ_ROOT.'/source/plugin/yiqixueba_server/function.func.php';

$this_page = substr($_SERVER['QUERY_STRING'],7,strlen($_SERVER['QUERY_STRING'])-7);
stripos($this_page,'subac=') ? $this_page = substr($this_page,0,stripos($this_page,'subac=')-1) : $this_page;

$subac = getgpc('subac');
$subacs = array('mokuailist','mokuaiedit','pagelist','pageedit','versionlist','zhuanhuan','huanyuan','pluginlang');
$subac = in_array($subac,$subacs) ? $subac : $subacs[0];

$mokuaiid = getgpc('mokuaiid');
$mokuai_info = $mokuaiid ? DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_server_mokuai')." WHERE mokuaiid=".$mokuaiid) : array();

if($subac == 'mokuailist') {
	if(!submitcheck('submit')) {
		$zhuanhuanen_ids = array();//是否已经转换插件数组
		showtips(lang('plugin/yiqixueba_server','mokuai_list_tips'));
		showformheader($this_page.'&subac=mokuailist');
		showtableheader(lang('plugin/yiqixueba_server','mokuai_zhuanhuanen_list'));
		$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_server_mokuai')." order by displayorder asc");
		while($row = DB::fetch($query)) {
			$zhuanhuanen_ids[] = 'yiqixueba_'.$row['identifier'];//转换之后去掉了yiqixuaba_，需要再加上
			$mokuaiico = '';
			if($row['mokuaiico']!='') {
				$mokuaiico = str_replace('{STATICURL}', STATICURL, $row['mokuaiico']);
				if(!preg_match("/^".preg_quote(STATICURL, '/')."/i", $mokuaiico) && !(($valueparse = parse_url($mokuaiico)) && isset($valueparse['host']))) {
					$mokuaiico = $_G['setting']['attachurl'].'common/'.$row['mokuaiico'].'?'.random(6);
				}
			}
			showtablerow('', array('style="width:45px"', 'valign="top" style="width:260px"', 'valign="top"', 'align="right" valign="bottom" style="width:160px"'), array(
				$mokuaiico ?'<img src="'.$mokuaiico.'" width="40" height="40" align="left" style="margin-right:5px" />' : '<img src="'.cloudaddons_pluginlogo_url($plugin['identifier']).'" onerror="this.src=\'static/image/admincp/plugin_logo.png\';this.onerror=null" width="40" height="40" align="left" />',
				'<span class="bold">'.$row['name'].$row['version'].($filemtime > TIMESTAMP - 86400 ? ' <font color="red">New!</font>' : '').'</span>  <span class="sml">('.$row['identifier'].')</span>',
				$row['description'],
				lang('plugin/yiqixueba_server','status')."<input class=\"checkbox\" type=\"checkbox\" name=\"statusnew[".$row['mokuaiid']."]\" value=\"1\" ".($row['available'] > 0 ? 'checked' : '').">&nbsp;&nbsp;".lang('plugin/yiqixueba_server','displayorder')."<INPUT type=\"text\" name=\"newdisplayorder[]\" value=\"".$row['displayorder']."\" size=\"2\">".
				"<br /><a href=\"".ADMINSCRIPT."?action=".$this_page."&subac=pluginlang&pluginid=$row[pluginid]\" >".lang('plugin/yiqixueba_server','pluginlang')."</a>&nbsp;&nbsp;<a href=\"".ADMINSCRIPT."?action=".$this_page."&subac=huanyuan&mokuaiid=$row[mokuaiid]\" >".lang('plugin/yiqixueba_server','huanyuan')."</a>&nbsp;&nbsp;<a href=\"".ADMINSCRIPT."?action=".$this_page."&subac=pagelist&mokuaiid=$row[mokuaiid]\" >".lang('plugin/yiqixueba_server','design')."</a>&nbsp;&nbsp;<a href=\"".ADMINSCRIPT."?action=".$this_page."&subac=mokuaiedit&mokuaiid=$row[mokuaiid]\" >".$lang['edit']."</a>",
			));
		}
		showtablefooter();
		showtableheader(lang('plugin/yiqixueba_server','mokuai_nozhuanhuan_list'));
		$query = DB::query("SELECT * FROM ".DB::table('common_plugin')." WHERE identifier like 'yiqixueba_%' order by identifier asc");
		while($row = DB::fetch($query)) {
			make_plugin($row['pluginid']);
			if(!in_array($row['identifier'],$zhuanhuanen_ids)){
				showtablerow('', array('style="width:45px"', 'valign="top" style="width:260px"', 'valign="top"', 'align="right" valign="bottom" style="width:160px"'), array(
					$mokuaiico ?'<img src="'.$mokuaiico.'" width="40" height="40" align="left" style="margin-right:5px" />' : '<img src="'.cloudaddons_pluginlogo_url($plugin['identifier']).'" onerror="this.src=\'static/image/admincp/plugin_logo.png\';this.onerror=null" width="40" height="40" align="left" />',
					'<span class="bold">'.$row['name'].$row['version'].($filemtime > TIMESTAMP - 86400 ? ' <font color="red">New!</font>' : '').'</span>  <span class="sml">('.str_replace("yiqixueba_","",$row['identifier']).')</span>',
					$row['description'],
					"<a href=\"".ADMINSCRIPT."?action=".$this_page."&subac=pluginlang&pluginid=$row[pluginid]\" >".lang('plugin/yiqixueba_server','pluginlang')."</a>&nbsp;&nbsp;<a href=\"".ADMINSCRIPT."?action=".$this_page."&subac=zhuanhuan&pluginid=$row[pluginid]\" >".lang('plugin/yiqixueba_server','zhuanhuan')."</a>",
				));
			}
		}
		showsubmit('submit');
		showtablefooter();
		showformfooter();
	}else{
		refresh_mokuai();
		cpmsg(lang('plugin/yiqixueba_server','mokuai_main_succeed'), 'action='.$this_page.'&subac=mokuailist', 'succeed');
	}
}elseif($subac == 'zhuanhuan') {
	$pluginid = getgpc('pluginid');
	$plugin_info = DB::fetch_first("SELECT * FROM ".DB::table('common_plugin')." WHERE pluginid=".$pluginid);
	$mokuai_info = $mokuai_setting = array();
	$mokuai_info = $plugin_info;
	$mokuai_info['available'] = 1;
	$mokuai_info['identifier'] = str_replace("yiqixueba_","",$mokuai_info['identifier']);
	$query = DB::query("SELECT * FROM ".DB::table('common_pluginvar')." WHERE pluginid = ".$pluginid." order by displayorder asc");
	while($row = DB::fetch($query)) {
		$mokuai_setting[] = $row;
	}
	$mokuai_info['setting'] = serialize($mokuai_setting);
	if(DB::result_first("SELECT count(*) FROM ".DB::table('yiqixueba_server_mokuai')." WHERE identifier='".$mokuai_info['identifier']."'")==0){
		DB::insert('yiqixueba_server_mokuai', $mokuai_info);
	}else{
		DB::update('yiqixueba_server_mokuai', $mokuai_info,array('identifier'=>$mokuai_info['identifier']));
	}
	cpmsg(lang('plugin/yiqixueba_server','mokuai_edit_succeed'), 'action='.$this_page.'&subac=mokuailist', 'succeed');
}elseif($subac == 'pluginlang') {
	$pluginid = getgpc('pluginid');
	$plugin_info = DB::fetch_first("SELECT * FROM ".DB::table('common_plugin')." WHERE pluginid=".$pluginid);
	$pluginfile_array = $plugin_lang = array();
	$pluginfile_array = get_plugin_file(DISCUZ_ROOT.'source/plugin/'.$plugin_info['directory']);
	if(!submitcheck('submit')) {
		showtips(lang('plugin/yiqixueba_server','mokuailang_list_tips'));
		showformheader($this_page.'&subac=pluginlang&pluginid='.$pluginid);
		foreach($pluginfile_array as $k=>$v ){
			showtableheader(lang('plugin/yiqixueba_server','mokuai_pluginlang_list').str_replace(DISCUZ_ROOT,"",$v['file']));
			$plugin_lang = get_plugin_lang($v['file']);
			foreach($plugin_lang as $k1=>$v1 ){
				showtablerow('', array('class="td29"', 'class="td28"'), array(
					lang('plugin/yiqixueba_server','english').$v1['en'],
					lang('plugin/yiqixueba_server','chinese').'<TEXTAREA name="script_lang['.$v1['en'].']" rows="3" cols="30">'.$v1['cn'].'</TEXTAREA>',
				));
			}
			showtablefooter();
		}
		showtableheader();
		showsubmit('submit');
		showtablefooter();
		showformfooter();
	}else{
		$script_lang = getgpc('script_lang');
		write_scriptlang_file($pluginid,$script_lang);
		cpmsg(lang('plugin/yiqixueba_server','mokuai_langedit_succeed'), 'action='.$this_page.'&subac=mokuailist', 'succeed');
	}
}elseif($subac == 'huanyuan') {
	var_dump($mokuaiid['pluginid']);
}

function fetchtablelist($tablepre = '') {
	global $db;
	$arr = explode('.', $tablepre);
	$dbname = $arr[1] ? $arr[0] : '';
	$tablepre = str_replace('_', '\_', $tablepre);
	$sqladd = $dbname ? " FROM $dbname LIKE '$arr[1]%'" : "LIKE '$tablepre%'";
	$tables = $table = array();
	$query = DB::query("SHOW TABLE STATUS $sqladd");
	while($table = DB::fetch($query)) {
		$table['Name'] = ($dbname ? "$dbname." : '').$table['Name'];
		$tables[] = $table;
	}
	return $tables;
}

?>