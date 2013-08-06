<?php
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

require_once DISCUZ_ROOT.'source/plugin/'.$plugin['directory'].'function.func.php';

$this_page = substr($_SERVER['QUERY_STRING'],7,strlen($_SERVER['QUERY_STRING'])-7);
stripos($this_page,'subop=') ? $this_page = substr($this_page,0,stripos($this_page,'subop=')-1) : $this_page;

$subop = getgpc('subop');
$subops = array('mokuailist','mokuaiedit','pagelist','pageedit','versionlist','shuaxin','huanyuan','pluginlang','currentver');
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
				"<a href=\"".ADMINSCRIPT."?action=".$this_page."&subop=pluginlang&mokuaiid=$row[mokuaiid]\" >".lang('plugin/'.$plugin['identifier'],'pluginlang')."</a>&nbsp;&nbsp;<a href=\"".ADMINSCRIPT."?action=".$this_page."&subop=shuaxin&mokuaiid=$row[mokuaiid]\" >".lang('plugin/'.$plugin['identifier'],'shuaxin')."</a>&nbsp;&nbsp;<a href=\"".ADMINSCRIPT."?action=".$this_page."&subop=pagelist&mokuaiid=$row[mokuaiid]\" >".lang('plugin/'.$plugin['identifier'],'pagelist')."</a>&nbsp;&nbsp;<a href=\"".ADMINSCRIPT."?action=".$this_page."&subop=mokuaiedit&mokuaiid=$row[mokuaiid]\" >".lang('plugin/'.$plugin['identifier'],'edit')."</a><br /><br />".lang('plugin/'.$plugin['identifier'],'status')."<input class=\"checkbox\" type=\"checkbox\" name=\"statusnew[".$row['mokuaiid']."]\" value=\"1\" ".($row['available'] > 0 ? 'checked' : '').">&nbsp;&nbsp;".lang('plugin/'.$plugin['identifier'],'displayorder')."<INPUT type=\"text\" name=\"newdisplayorder[]\" value=\"".$row['displayorder']."\" size=\"2\">",
			));
		}
		echo '<tr><td></td><td colspan="3"><div><a href="'.ADMINSCRIPT.'?action='.$this_page.'&subop=mokuaiedit" class="addtr" >'.lang('plugin/'.$plugin['identifier'],'add_mokuai').'</a></div></td></tr>';
		showsubmit('submit');
		showtablefooter();
		showformfooter();
	}else{
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
			DB::update('yiqixueba_server_mokuai', $data,array('mokuaiid'=>$mokuaiid));
		}else{
			DB::insert('yiqixueba_server_mokuai', $data);
		}
		cpmsg(lang('plugin/'.$plugin['identifier'],'add_mokuai_succeed'), 'action='.$this_page.'&subop=mokuailist', 'succeed');
	}
}elseif ($subop == 'pluginlang'){
}elseif ($subop == 'pagelist'){
	if(!submitcheck('submit')) {
		showtips(lang('plugin/'.$plugin['identifier'],'mokuai_list_tips'));
		showformheader($this_page.'&subop=mokuailist');
		showtableheader(lang('plugin/'.$plugin['identifier'],'mokuai_list'));
		showsubtitle(array('', lang('plugin/'.$plugin['identifier'],'mokuai_name'),lang('plugin/'.$plugin['identifier'],'mokuai_description'),lang('plugin/'.$plugin['identifier'],'mokuai_status')));
		$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_server_pages')." order by displayorder asc");
		while($row = DB::fetch($query)) {
			showtablerow('', array('style="width:45px"', 'valign="top" style="width:320px"', 'valign="top"', 'align="right" valign="top" style="width:160px"'), array(
				$mokuaiico ?'<img src="'.$mokuaiico.'" width="40" height="40" align="left" style="margin-right:5px" />' : '<img src="'.cloudaddons_pluginlogo_url($row['identifier']).'" onerror="this.src=\'static/image/admincp/plugin_logo.png\';this.onerror=null" width="40" height="40" align="left" />',
				'<span class="bold">'.$row['name'].'-'.$currenver_text.($filemtime > TIMESTAMP - 86400 ? ' <font color="red">New!</font>' : '').'</span>  <span class="sml">('.str_replace("yiqixueba_","",$row['identifier']).')</span><br />'.$ver_text.'<br />',
				$row['description'],
				"<a href=\"".ADMINSCRIPT."?action=".$this_page."&subop=pluginlang&mokuaiid=$row[mokuaiid]\" >".lang('plugin/'.$plugin['identifier'],'pluginlang')."</a>&nbsp;&nbsp;<a href=\"".ADMINSCRIPT."?action=".$this_page."&subop=shuaxin&mokuaiid=$row[mokuaiid]\" >".lang('plugin/'.$plugin['identifier'],'shuaxin')."</a>&nbsp;&nbsp;<a href=\"".ADMINSCRIPT."?action=".$this_page."&subop=pagelist&mokuaiid=$row[mokuaiid]\" >".lang('plugin/'.$plugin['identifier'],'pagelist')."</a>&nbsp;&nbsp;<a href=\"".ADMINSCRIPT."?action=".$this_page."&subop=mokuaiedit&mokuaiid=$row[mokuaiid]\" >".lang('plugin/'.$plugin['identifier'],'edit')."</a><br /><br />".lang('plugin/'.$plugin['identifier'],'status')."<input class=\"checkbox\" type=\"checkbox\" name=\"statusnew[".$row['mokuaiid']."]\" value=\"1\" ".($row['available'] > 0 ? 'checked' : '').">&nbsp;&nbsp;".lang('plugin/'.$plugin['identifier'],'displayorder')."<INPUT type=\"text\" name=\"newdisplayorder[]\" value=\"".$row['displayorder']."\" size=\"2\">",
			));
		}
		echo '<tr><td></td><td colspan="3"><div><a href="'.ADMINSCRIPT.'?action='.$this_page.'&subop=mokuaiedit" class="addtr" >'.lang('plugin/'.$plugin['identifier'],'add_mokuai').'</a></div></td></tr>';
		showsubmit('submit');
		showtablefooter();
		showformfooter();
	}else{
	}
}elseif ($subop == 'pageedit'){
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
		if(DB::result_first("SELECT count(*) FROM ".DB::table('yiqixueba_server_mokuai')." WHERE identifier='".$mokuai_identifier."' and version = '".$mokuai_version."'")){
			cpmsg(lang('plugin/'.$plugin['identifier'],'mokuai_identifier_invalid'), '', 'error');
		}
		$data = array(
			'name' => $mokuai_name,
			'version' => $mokuai_version,
			'identifier' => $mokuai_identifier,
			'description' => $mokuai_description,
		);
		if($mokuaiid){
			DB::update('yiqixueba_server_mokuai', $data,array('mokuaiid'=>$mokuaiid));
		}else{
			DB::insert('yiqixueba_server_mokuai', $data);
		}
		cpmsg(lang('plugin/'.$plugin['identifier'],'add_mokuai_succeed'), 'action='.$this_page.'&subop=mokuailist', 'succeed');
	}
}
?>