<?php
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

$this_page = substr($_SERVER['QUERY_STRING'],7,strlen($_SERVER['QUERY_STRING'])-7);
stripos($this_page,'subop=') ? $this_page = substr($this_page,0,stripos($this_page,'subop=')-1) : $this_page;

$subop = getgpc('subop');
$subops = array('sitelist','siteedit');
$subop = in_array($subop,$subops) ? $subop : $subops[0];

$siteid = getgpc('siteid');
$site_info = $siteid ? DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_server_site')." WHERE siteid=".$siteid) : array();

$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_server_sitegroup'));
while($row = DB::fetch($query)) {
	$sitegroups[$row['sitegroupid']] = $row;
}

if($subop == 'sitelist') {
	if(!submitcheck('submit')) {
		showtips(lang('plugin/'.$plugin['identifier'],'site_list_tips'));
		showformheader($this_page.'&subop=sitelist');
		showtableheader(lang('plugin/'.$plugin['identifier'],'site_list'));
		showsubtitle(array('', lang('plugin/'.$plugin['identifier'],'site_info'),lang('plugin/'.$plugin['identifier'],'site_mokuai'),lang('plugin/'.$plugin['identifier'],'status'),''));
		$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_server_site')." order by siteid asc");
		while($row = DB::fetch($query)) {

			showtablerow('', array('class="td25"', 'valign="top" style="width:320px"', 'class="td28"', 'class="td25"', 'class="td28"'), array(
				'',
				$row['sitekey'].'<br /><span class="bold">'.$row['siteurl'].'</span><br />'.$row['version'].'&nbsp;&nbsp;'.$row['charset'].'<br />'.dgmdate($row['installtime']).'&nbsp;&nbsp;'.$sitegroups[$row['sitegroup']]['sitegroupname'],
				$row['sitegroup'],
				"<input class=\"checkbox\" type=\"checkbox\" name=\"statusnew[".$row['siteid']."]\" value=\"1\" ".($row['available'] > 0 ? 'checked' : '').">",
				"<a href=\"".ADMINSCRIPT."?action=".$this_page."&subop=siteedit&siteid=$row[siteid]\" >".lang('plugin/'.$plugin['identifier'],'edit')."</a>",
			));
		}
		echo '<tr><td></td><td colspan="4"><div><a href="'.ADMINSCRIPT.'?action='.$this_page.'&subop=siteedit" class="addtr" >'.lang('plugin/'.$plugin['identifier'],'add_site').'</a></div></td></tr>';
		showsubmit('submit');
		showtablefooter();
		showformfooter();
	}else{
		DB::update('yiqixueba_server_site', array('available'=>0));
		foreach( getgpc('vernew') as $k=>$v ){
			if($v){
				DB::update('yiqixueba_server_site', array('available'=>1),array('siteid'=>$k));
			}
		}
		foreach(getgpc('newdisplayorder') as $k=>$v ){
			DB::update('yiqixueba_server_site', array('displayorder'=>$v),array('siteid'=>$k));
		}
		cpmsg(lang('plugin/'.$plugin['identifier'],'site_main_succeed'), 'action='.$this_page.'&subop=sitelist', 'succeed');
	}
}elseif ($subop == 'siteedit'){
	if(!submitcheck('submit')) {
		showtips(lang('plugin/'.$plugin['identifier'],$siteid ?'edit_site_tips':'add_site_tips'));
		showformheader($this_page.'&subop=siteedit');
		showtableheader(lang('plugin/'.$plugin['identifier'],'site_edit'));
		$siteid ? showhiddenfields(array('siteid'=>$siteid)) : '';
		showsetting(lang('plugin/'.$plugin['identifier'],'site_edit_identifier'),'site_identifier',$site_info['identifier'],'text','',0,lang('plugin/'.$plugin['identifier'],'site_edit_identifier_comment'),'','',true);
		showsetting(lang('plugin/'.$plugin['identifier'],'site_edit_name'),'name',$site_info['name'],'text','',0,lang('plugin/'.$plugin['identifier'],'site_edit_name_comment'),'','',true);
		showsetting(lang('plugin/'.$plugin['identifier'],'site_edit_version'),'version',$site_info['version'],'text','',0,lang('plugin/'.$plugin['identifier'],'site_edit_version_comment'),'','',true);
		showsetting(lang('plugin/'.$plugin['identifier'],'site_edit_price'),'price',$site_info['price'],'text','',0,lang('plugin/'.$plugin['identifier'],'site_edit_price_comment'),'','',true);
		showsetting(lang('plugin/'.$plugin['identifier'],'site_edit_description'),'description',$site_info['description'],'textarea','',0,lang('plugin/'.$plugin['identifier'],'site_edit_description_comment'),'','',true);
		showsetting(lang('plugin/'.$plugin['identifier'],'site_edit_ico'),'ico',$site_info['ico'],'filetext','',0,lang('plugin/'.$plugin['identifier'],'site_edit_ico_comment'),'','',true);
		showsubmit('submit');
		showtablefooter();
		showformfooter();
	} else {
		$site_identifier	= trim($_GET['site_identifier']);
		$site_name	= dhtmlspecialchars(trim($_GET['name']));
		$site_price	= trim($_GET['price']);
		$site_version	= strip_tags(trim($_GET['version']));
		$site_description	= dhtmlspecialchars(trim($_GET['description']));

		if(!$site_identifier){
			cpmsg(lang('plugin/'.$plugin['identifier'],'site_identifier_invalid'), '', 'error');
		}
		if(!$site_name){
			cpmsg(lang('plugin/'.$plugin['identifier'],'site_name_invalid'), '', 'error');
		}
		if(!$site_version){
			cpmsg(lang('plugin/'.$plugin['identifier'],'site_version_invalid'), '', 'error');
		}
		if(!ispluginkey($site_identifier)) {
			cpmsg(lang('plugin/'.$plugin['identifier'],'site_identifier_invalid'), '', 'error');
		}
		if(!$siteid&&DB::result_first("SELECT count(*) FROM ".DB::table('yiqixueba_server_site')." WHERE identifier='".$site_identifier."' and version = '".$site_version."'")){
			cpmsg(lang('plugin/'.$plugin['identifier'],'site_identifier_invalid'), '', 'error');
		}
		$data = array(
			'name' => $site_name,
			'price' => $site_price,
			'version' => $site_version,
			'identifier' => $site_identifier,
			'description' => $site_description,
		);
		if($siteid){
			$data['updatetime'] = time();
			DB::update('yiqixueba_server_site', $data,array('siteid'=>$siteid));
		}else{
			$data['createtime'] = time();
			DB::insert('yiqixueba_server_site', $data);
		}
		cpmsg(lang('plugin/'.$plugin['identifier'],'add_site_succeed'), 'action='.$this_page.'&subop=sitelist', 'succeed');
	}
}

?>