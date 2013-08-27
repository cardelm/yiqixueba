<?php
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

$this_page = substr($_SERVER['QUERY_STRING'],7,strlen($_SERVER['QUERY_STRING'])-7);
stripos($this_page,'subop=') ? $this_page = substr($this_page,0,stripos($this_page,'subop=')-1) : $this_page;

$subop = getgpc('subop');
$subops = array('sitegrouplist','sitegroupedit');
$subop = in_array($subop,$subops) ? $subop : $subops[0];

$sitegroupid = getgpc('sitegroupid');
$sitegroup_info = $sitegroupid ? DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_server_sitegroup')." WHERE sitegroupid=".$sitegroupid) : array();

if($subop == 'sitegrouplist') {
	if(!submitcheck('submit')) {
		showtips(lang('plugin/'.$plugin['identifier'],'sitegroup_list_tips'));
		showformheader($this_page.'&subop=sitegrouplist');
		showtableheader(lang('plugin/'.$plugin['identifier'],'sitegroup_list'));
		showsubtitle(array('', lang('plugin/'.$plugin['identifier'],'sitegroup_name'),lang('plugin/'.$plugin['identifier'],'sitegroup_description'),lang('plugin/'.$plugin['identifier'],'sitegroup_status')));
		$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_server_sitegroup')." order by sitegroupid asc");
		while($row = DB::fetch($query)) {
			$zhuanhuanen_ids = array();//是否已经转换插件数组
			$zhuanhuanen_ids[] = 'yiqixueba_'.$row['identifier'];//转换之后去掉了yiqixuaba_，需要再加上
			$ver_text = $currenver_text = '';
			$query1 = DB::query("SELECT * FROM ".DB::table('yiqixueba_server_sitegroup')." WHERE identifier = '".$row['identifier']."' order by createtime asc");
			$verk = 0;
			while($row1 = DB::fetch($query1)) {
				$ver_text .= ($verk ==0 ? '' :'&nbsp;&nbsp;|&nbsp;&nbsp;')."<input class=\"checkbox\" type=\"checkbox\" name=\"vernew[".$row1['sitegroupid']."]\" value=\"1\" ".($row1['available'] > 0 ? 'checked' : '').">&nbsp;&nbsp;<a href=\"".ADMINSCRIPT."?action=".$this_page."&subop=currentver&sitegroupid=$row1[sitegroupid]\" >".$row1['version'].'</a>';
				if($row1['currentversion']){
					$currenver_text = $row1['version'];
				}
				$verk++;
			}
			$currenver_text =$currenver_text ? $currenver_text : $row['version'];
			$currenver_text ? $currenver_text : DB::update('yiqixueba_server_sitegroup', array('currentversion'=>1),array('identifier'=>$row['identifier'],'version'=>$currenver_text));
			showtablerow('', array('style="width:45px"', 'valign="top" style="width:320px"', 'valign="top"', 'align="right" valign="top" style="width:200px"'), array(
				$sitegroupico ?'<img src="'.$sitegroupico.'" width="40" height="40" align="left" style="margin-right:5px" />' : '<img src="'.cloudaddons_pluginlogo_url($row['identifier']).'" onerror="this.src=\'static/image/admincp/plugin_logo.png\';this.onerror=null" width="40" height="40" align="left" />',
				'<span class="bold">'.$row['name'].'-'.$currenver_text.($filemtime > TIMESTAMP - 86400 ? ' <font color="red">New!</font>' : '').'</span>  <span class="sml">('.str_replace("yiqixueba_","",$row['identifier']).')</span><br />'.$ver_text.'<br />'.lang('plugin/'.$plugin['identifier'],'price').$row['price'],
				$row['description'],
				"<a href=\"".ADMINSCRIPT."?action=".$this_page."&subop=pluginlang&sitegroupid=$row[sitegroupid]\" >".lang('plugin/'.$plugin['identifier'],'pluginlang')."</a>&nbsp;&nbsp;<a href=\"".ADMINSCRIPT."?action=".$this_page."&subop=shuaxin&sitegroupid=$row[sitegroupid]\" >".lang('plugin/'.$plugin['identifier'],'shuaxin')."</a>&nbsp;&nbsp;<a href=\"".ADMINSCRIPT."?action=".$this_page."&subop=pagelist&sitegroupid=$row[sitegroupid]\" >".lang('plugin/'.$plugin['identifier'],'pagelist')."</a>&nbsp;&nbsp;<a href=\"".ADMINSCRIPT."?action=".$this_page."&subop=sitegroupedit&sitegroupid=$row[sitegroupid]\" >".lang('plugin/'.$plugin['identifier'],'edit')."</a>&nbsp;&nbsp;<a href=\"".ADMINSCRIPT."?action=".$this_page."&subop=sitegroupmake&sitegroupid=$row[sitegroupid]\" >".lang('plugin/'.$plugin['identifier'],'sitegroup_make')."</a><br /><br />".lang('plugin/'.$plugin['identifier'],'status')."<input class=\"checkbox\" type=\"checkbox\" name=\"statusnew[".$row['sitegroupid']."]\" value=\"1\" ".($row['available'] > 0 ? 'checked' : '').">&nbsp;&nbsp;".lang('plugin/'.$plugin['identifier'],'displayorder')."<INPUT type=\"text\" name=\"newdisplayorder[".$row['sitegroupid']."]\" value=\"".$row['displayorder']."\" size=\"2\">",
			));
		}
		echo '<tr><td></td><td colspan="3"><div><a href="'.ADMINSCRIPT.'?action='.$this_page.'&subop=sitegroupedit" class="addtr" >'.lang('plugin/'.$plugin['identifier'],'add_sitegroup').'</a></div></td></tr>';
		showsubmit('submit');
		showtablefooter();
		showformfooter();
	}else{
		DB::update('yiqixueba_server_sitegroup', array('available'=>0));
		foreach( getgpc('vernew') as $k=>$v ){
			if($v){
				DB::update('yiqixueba_server_sitegroup', array('available'=>1),array('sitegroupid'=>$k));
			}
		}
		foreach(getgpc('newdisplayorder') as $k=>$v ){
			DB::update('yiqixueba_server_sitegroup', array('displayorder'=>$v),array('sitegroupid'=>$k));
		}
		cpmsg(lang('plugin/'.$plugin['identifier'],'sitegroup_main_succeed'), 'action='.$this_page.'&subop=sitegrouplist', 'succeed');
	}
}elseif ($subop == 'sitegroupedit'){
	if(!submitcheck('submit')) {
		$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_server_mokuai')." group by identifier order by displayorder asc");
		while($row = DB::fetch($query)) {
			dump($row);
		}

		showtips(lang('plugin/'.$plugin['identifier'],$sitegroupid ?'edit_sitegroup_tips':'add_sitegroup_tips'));
		showformheader($this_page.'&subop=sitegroupedit');
		showtableheader(lang('plugin/'.$plugin['identifier'],'sitegroup_edit'));
		$sitegroupid ? showhiddenfields(array('sitegroupid'=>$sitegroupid)) : '';
		showsetting(lang('plugin/'.$plugin['identifier'],'sitegroup_name'),'name',$sitegroup_info['name'],'text','',0,lang('plugin/'.$plugin['identifier'],'sitegroup_name_comment'),'','',true);
		showsetting(lang('plugin/'.$plugin['identifier'],'sitegroup_mokuai'),'versions',$sitegroup_info['versions'],'text','',0,lang('plugin/'.$plugin['identifier'],'sitegroup_edit_version_comment'),'','',true);
		showsubmit('submit');
		showtablefooter();
		showformfooter();
	} else {
		$sitegroup_identifier	= trim($_GET['sitegroup_identifier']);
		$sitegroup_name	= dhtmlspecialchars(trim($_GET['name']));
		$sitegroup_price	= trim($_GET['price']);
		$sitegroup_version	= strip_tags(trim($_GET['version']));
		$sitegroup_description	= dhtmlspecialchars(trim($_GET['description']));

		if(!$sitegroup_identifier){
			cpmsg(lang('plugin/'.$plugin['identifier'],'sitegroup_identifier_invalid'), '', 'error');
		}
		if(!$sitegroup_name){
			cpmsg(lang('plugin/'.$plugin['identifier'],'sitegroup_name_invalid'), '', 'error');
		}
		if(!$sitegroup_version){
			cpmsg(lang('plugin/'.$plugin['identifier'],'sitegroup_version_invalid'), '', 'error');
		}
		if(!ispluginkey($sitegroup_identifier)) {
			cpmsg(lang('plugin/'.$plugin['identifier'],'sitegroup_identifier_invalid'), '', 'error');
		}
		if(!$sitegroupid&&DB::result_first("SELECT count(*) FROM ".DB::table('yiqixueba_server_sitegroup')." WHERE identifier='".$sitegroup_identifier."' and version = '".$sitegroup_version."'")){
			cpmsg(lang('plugin/'.$plugin['identifier'],'sitegroup_identifier_invalid'), '', 'error');
		}
		$data = array(
			'name' => $sitegroup_name,
			'price' => $sitegroup_price,
			'version' => $sitegroup_version,
			'identifier' => $sitegroup_identifier,
			'description' => $sitegroup_description,
		);
		if($sitegroupid){
			$data['updatetime'] = time();
			DB::update('yiqixueba_server_sitegroup', $data,array('sitegroupid'=>$sitegroupid));
		}else{
			$data['createtime'] = time();
			DB::insert('yiqixueba_server_sitegroup', $data);
		}
		cpmsg(lang('plugin/'.$plugin['identifier'],'add_sitegroup_succeed'), 'action='.$this_page.'&subop=sitegrouplist', 'succeed');
	}
}

?>