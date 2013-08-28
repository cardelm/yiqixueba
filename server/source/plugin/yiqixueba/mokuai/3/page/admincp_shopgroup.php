<?php
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

$this_page = substr($_SERVER['QUERY_STRING'],7,strlen($_SERVER['QUERY_STRING'])-7);
stripos($this_page,'subop=') ? $this_page = substr($this_page,0,stripos($this_page,'subop=')-1) : $this_page;

$subop = getgpc('subop');
$subops = array('grouplist','groupedit');
$subop = in_array($subop,$subops) ? $subop : $subops[0];

$groupid = getgpc('groupid');
$group_info = $groupid ? DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_shop_group')." WHERE groupid=".$groupid) : array();

if($subop == 'grouplist') {
	if(!submitcheck('submit')) {
		showtips(lang('plugin/'.$plugin['identifier'],'group_list_tips'));
		showformheader($this_page.'&subop=grouplist');
		showtableheader(lang('plugin/'.$plugin['identifier'],'group_list'));
		showsubtitle(array('', lang('plugin/'.$plugin['identifier'],'group_name'),lang('plugin/'.$plugin['identifier'],'group_mokuai'),lang('plugin/'.$plugin['identifier'],'status'),''));
		$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_shop_group')." order by groupid asc");
		while($row = DB::fetch($query)) {
			$vervalues = array();
			$vert = '';
			foreach(dunserialize($row['versions']) as $k=>$v ){
				$vervalues[] = $k;
			}

			$query1 = DB::query("SELECT * FROM ".DB::table('yiqixueba_server_mokuai')." order by displayorder asc");
			while($row1 = DB::fetch($query1)) {
				$vert .= in_array($row1['mokuaiid'],$vervalues) ? ($row1['name'].'-'.$row1['version'].'&nbsp;&nbsp;') : '';
			}
			showtablerow('', array('class="td25"', 'class="td28"', 'class="td29"','class="td25"'), array(
				'',
				'<span class="bold">'.$row['groupname'].'</span>',
				$vert,
				"<input class=\"checkbox\" type=\"checkbox\" name=\"statusnew[".$row['groupid']."]\" value=\"1\" ".($row['status'] > 0 ? 'checked' : '').">",
				"<a href=\"".ADMINSCRIPT."?action=".$this_page."&subop=groupedit&groupid=$row[groupid]\" >".lang('plugin/'.$plugin['identifier'],'edit')."</a>",
			));
		}
		echo '<tr><td></td><td colspan="4"><div><a href="'.ADMINSCRIPT.'?action='.$this_page.'&subop=groupedit" class="addtr" >'.lang('plugin/'.$plugin['identifier'],'add_group').'</a></div></td></tr>';
		showsubmit('submit');
		showtablefooter();
		showformfooter();
	}else{
		DB::update('yiqixueba_server_group', array('available'=>0));
		foreach( getgpc('vernew') as $k=>$v ){
			if($v){
				DB::update('yiqixueba_server_group', array('available'=>1),array('groupid'=>$k));
			}
		}
		foreach(getgpc('newdisplayorder') as $k=>$v ){
			DB::update('yiqixueba_server_group', array('displayorder'=>$v),array('groupid'=>$k));
		}
		cpmsg(lang('plugin/'.$plugin['identifier'],'group_main_succeed'), 'action='.$this_page.'&subop=grouplist', 'succeed');
	}
}elseif ($subop == 'groupedit'){
	if(!submitcheck('submit')) {
		$vers = $vervalues = array();
		$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_server_mokuai')." order by displayorder asc");
		while($row = DB::fetch($query)) {
			$vers[] = array($row['mokuaiid'],$row['name'].'-'.$row['version']);
		}
		foreach(dunserialize($group_info['versions']) as $k=>$v ){
			$vervalues[] = $k;
		}
		showtips(lang('plugin/'.$plugin['identifier'],$groupid ?'edit_group_tips':'add_group_tips'));
		showformheader($this_page.'&subop=groupedit');
		showtableheader(lang('plugin/'.$plugin['identifier'],'group_edit'));
		$groupid ? showhiddenfields(array('groupid'=>$groupid)) : '';
		showsetting(lang('plugin/'.$plugin['identifier'],'group_name'),'name',$group_info['groupname'],'text','',0,lang('plugin/'.$plugin['identifier'],'group_name_comment'),'','',true);
		showsetting(lang('plugin/'.$plugin['identifier'],'group_mokuai'),array('versions',$vers),$vervalues,'mcheckbox','',0,lang('plugin/'.$plugin['identifier'],'group_edit_version_comment'),'','',true);
		showsubmit('submit');
		showtablefooter();
		showformfooter();
	} else {
		$group_name	= dhtmlspecialchars(trim($_GET['name']));
		if(!$group_name){
			cpmsg(lang('plugin/'.$plugin['identifier'],'group_name_invalid'), '', 'error');
		}
		$data = array(
			'groupname' => $group_name,
			'status' => 1,
			'versions' => serialize($_POST['versions']),
		);
		if($groupid){
			$data['updatetime'] = time();
			DB::update('yiqixueba_server_group', $data,array('groupid'=>$groupid));
		}else{
			$data['createtime'] = time();
			DB::insert('yiqixueba_server_group', $data);
		}

		cpmsg(lang('plugin/'.$plugin['identifier'],'add_group_succeed'), 'action='.$this_page.'&subop=grouplist', 'succeed');
	}
}
?>