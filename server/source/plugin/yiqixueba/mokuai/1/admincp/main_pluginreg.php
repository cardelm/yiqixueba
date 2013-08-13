<?php
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

$this_page = substr($_SERVER['QUERY_STRING'],7,strlen($_SERVER['QUERY_STRING'])-7);
stripos($this_page,'subop=') ? $this_page = substr($this_page,0,stripos($this_page,'subop=')-1) : $this_page;

$subop = getgpc('subop');
$subops = array('pluginregedit');
$subop = in_array($subop,$subops) ? $subop : $subops[0];
if($subop == 'pluginregedit') {
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
}
?>