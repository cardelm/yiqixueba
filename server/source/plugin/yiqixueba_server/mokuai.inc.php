<?php
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

require_once DISCUZ_ROOT.'source/plugin/'.$plugin['directory'].'function.func.php';

$this_page = substr($_SERVER['QUERY_STRING'],7,strlen($_SERVER['QUERY_STRING'])-7);
stripos($this_page,'subop=') ? $this_page = substr($this_page,0,stripos($this_page,'subop=')-1) : $this_page;

$subop = getgpc('subop');
$subops = array('mokuailist','addmokuai','pagelist','pageedit','versionlist','shuaxin','huanyuan','pluginlang','xiangqing','currentver');
$subop = in_array($subop,$subops) ? $subop : $subops[0];

$mokuaiid = getgpc('mokuaiid');
$mokuai_info = $mokuaiid ? DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_server_mokuai')." WHERE mokuaiid=".$mokuaiid) : array();

if($subop == 'mokuailist') {
	if(!submitcheck('submit')) {
		showtips(lang('plugin/'.$plugin['identifier'],'mokuai_list_tips'));
		showformheader($this_page.'&subop=mokuailist');
		showtableheader(lang('plugin/'.$plugin['identifier'],'mokuai_list'));
		$query = DB::query("SELECT * FROM ".DB::table('common_plugin')." WHERE identifier like 'yiqixueba_%' order by identifier asc");
		while($row = DB::fetch($query)) {
			refresh_plugin($row);
			$ver_text = $currenver_text = '';
			$query1 = DB::query("SELECT * FROM ".DB::table('yiqixueba_server_mokuai')." WHERE pluginid = ".$row['pluginid']." order by displayorder asc");
			$verk = 0;
			while($row1 = DB::fetch($query1)) {
				$ver_text .= ($verk ==0 ? '' :'&nbsp;&nbsp;|&nbsp;&nbsp;')."<input class=\"checkbox\" type=\"checkbox\" name=\"statusnew[".$row1['mokuaiid']."]\" value=\"1\" ".($row1['available'] > 0 ? 'checked' : '').">&nbsp;&nbsp;<a href=\"".ADMINSCRIPT."?action=".$this_page."&subop=currentver&mokuaiid=$row1[mokuaiid]\" >".$row1['version'].'</a>';
				if($row1['currentversion']){
					$currenver_text = $row1['version'];
				}
				$verk++;
			}
			$currenver_text =$currenver_text ? $currenver_text : $row['version'];
			$currenver_text ? $currenver_text : DB::update('yiqixueba_server_mokuai', array('currentversion'=>1),array('identifier'=>$row['identifier'],'version'=>$currenver_text));
			showtablerow('', array('style="width:45px"', 'valign="top" style="width:320px"', 'valign="top"', 'align="right" valign="top" style="width:160px"'), array(
				$mokuaiico ?'<img src="'.$mokuaiico.'" width="40" height="40" align="left" style="margin-right:5px" />' : '<img src="'.cloudaddons_pluginlogo_url($row['identifier']).'" onerror="this.src=\'static/image/admincp/plugin_logo.png\';this.onerror=null" width="40" height="40" align="left" />',
				'<span class="bold">'.$row['name'].'-'.$currenver_text.($filemtime > TIMESTAMP - 86400 ? ' <font color="red">New!</font>' : '').'</span>  <span class="sml">('.str_replace("yiqixueba_","",$row['identifier']).')</span><br />'.$ver_text.'<br />',
				$row['description'],
				"<a href=\"".ADMINSCRIPT."?action=".$this_page."&subop=pluginlang&pluginid=$row[pluginid]\" >".lang('plugin/'.$plugin['identifier'],'pluginlang')."</a>&nbsp;&nbsp;<a href=\"".ADMINSCRIPT."?action=".$this_page."&subop=shuaxin&pluginid=$row[pluginid]\" >".lang('plugin/'.$plugin['identifier'],'shuaxin')."</a>&nbsp;&nbsp;<a href=\"".ADMINSCRIPT."?action=plugins&operation=edit&pluginid=$row[pluginid]\" >".lang('plugin/'.$plugin['identifier'],'xiangqing')."</a><br /><br />".				lang('plugin/'.$plugin['identifier'],'status')."<input class=\"checkbox\" type=\"checkbox\" name=\"statusnew[".$row['mokuaiid']."]\" value=\"1\" ".($row['available'] > 0 ? 'checked' : '').">&nbsp;&nbsp;".lang('plugin/'.$plugin['identifier'],'displayorder')."<INPUT type=\"text\" name=\"newdisplayorder[]\" value=\"".$row['displayorder']."\" size=\"2\">",
			));
		}
		echo '<tr><td></td><td colspan="3"><div><a href="'.ADMINSCRIPT.'?action='.$this_page.'&subop=addmokuai" class="addtr">'.lang('plugin/'.$plugin['identifier'],'add_mokuai').'</a></div></td></tr>';
		showsubmit('submit');
		showtablefooter();
		showformfooter();
	}else{
		refresh_mokuai();
		cpmsg(lang('plugin/'.$plugin['identifier'],'mokuai_main_succeed'), 'action='.$this_page.'&subop=mokuailist', 'succeed');
	}
}elseif ($subop == 'addmokuai'){
	if(!submitcheck('addsubmit')) {
		showtips(lang('plugin/'.$plugin['identifier'],'add_mokuai_tips'));

		showformheader($this_page.'&subop=addmokuai');
		showtableheader();
		showsetting('plugins_edit_name', 'namenew', 'zxc', 'text');
		showsetting('plugins_edit_version', 'versionnew', 'sdacsa', 'text');
		showsetting('plugins_edit_copyright', 'copyrightnew', 'csadc', 'text');
		showsetting('plugins_edit_identifier', 'identifiernew', 'csadcas', 'text');
		showsubmit('addsubmit');
		showtablefooter();
		showformfooter();
	} else {
		$namenew	= dhtmlspecialchars(trim($_GET['namenew']));
		$versionnew	= strip_tags(trim($_GET['versionnew']));
		$identifiernew	= trim($_GET['identifiernew']);
		$copyrightnew	= dhtmlspecialchars($_GET['copyrightnew']);

		if(!$namenew) {
			cpmsg('plugins_edit_name_invalid', '', 'error');
		} else {
			if(!ispluginkey($identifiernew) || DB::result_first("SELECT count(*) FROM ".DB::table('yiqixueba_server_mokuai')." WHERE identifier='".$identifiernew."'")) {
				cpmsg('plugins_edit_identifier_invalid', '', 'error');
			}
		}
		$data = array(
			'name' => $namenew,
			'version' => $versionnew,
			'identifier' => $identifiernew,
			'directory' => $identifiernew.'/',
			'available' => 0,
			'copyright' => $copyrightnew,
		);
		dump($data);
		DB::insert('yiqixueba_server_mokuai', $data);
		cpmsg(lang('plugin/'.$plugin['identifier'],'add_mokuai_succeed'), 'action='.$this_page.'&subop=mokuailist', 'succeed');
	}
}
?>