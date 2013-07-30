<?php

/**
*	一起学吧平台程序
*	站长管理
*	文件名：site.php  创建时间：2013-5-30 09:48  杨文
*
*/

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
$this_page = 'plugins&identifier=yiqixueba_server&pmod=admincp&submod=site';

$subop = getgpc('subop');
$subops = array('sitelist','siteedit','sitemokuai');
$subop = in_array($subop,$subops) ? $subop : $subops[0];

$siteid = intval($_GET['siteid']);
$site_info = $siteid ? DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_server_site')." WHERE siteid=".$siteid) : array();

//站长列表
if($subop == 'sitelist') {
	if(!submitcheck('submit')) {
		showtips(lang('plugin/yiqixueba_server','site_list_tips'));
		showformheader($this_page.'&subop=sitelist');
		showtableheader(lang('plugin/yiqixueba_server','site_list'));
		showsubtitle(array('', lang('plugin/yiqixueba_server','siteurl'),lang('plugin/yiqixueba_server','installtime'),lang('plugin/yiqixueba_server','validity'),lang('plugin/yiqixueba_server','districtproxy'), lang('plugin/yiqixueba_server','usemokuai'), lang('plugin/yiqixueba_server','status'), ''));
		$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_server_site')." order by installtime asc");
		while($row = DB::fetch($query)) {
			showtablerow('', array('class="td25"','class="td28"', 'class="td23"', 'class="td23"', 'class="td23"','class="td28"','class="td25"',''), array(
				"<input class=\"checkbox\" type=\"checkbox\" name=\"delete[]\" value=\"$row[siteid]\">",
				$row['siteurl'],
				$row['installtime'] ? dgmdate($row['installtime'],'d') : '',
				dgmdate($row['groupexpiry'],'d'),
				$row['prov'].$row['city'].$row['dist'],
				'',
				$row['status'] == 0 ? lang('plugin/yiqixueba_server','shenqinging') : ($row['status'] == 1 ? lang('plugin/yiqixueba_server','ok') : lang('plugin/yiqixueba_server','no')),
				"<a href=\"".ADMINSCRIPT."?action=$this_page&subop=siteedit&siteid=$row[siteid]\" class=\"act\">".lang('plugin/yiqixueba_server','edit')."</a>&nbsp;&nbsp;<a href=\"".ADMINSCRIPT."?action=$this_page&subop=sitemokuai&siteid=$row[siteid]\" class=\"act\">".lang('plugin/yiqixueba_server','mokuai')."</a>",
			));
		}
		echo '<tr><td></td><td colspan="7"><div><a href="'.ADMINSCRIPT.'?action='.$this_page.'&subop=siteedit" class="addtr">'.lang('plugin/yiqixueba_server','add_site').'</a></div></td></tr>';
		showsubmit('submit','submit','del');
		showtablefooter();
		showformfooter();
	}else{
		if($idg = $_GET['delete']) {
			$idg = dintval($idg, is_array($idg) ? true : false);
			if($idg) {
				DB::delete('yiqixueba_server_site', DB::field('siteid', $idg));
			}
		}
		cpmsg(lang('plugin/yiqixueba_server', 'site_edit_succeed'), 'action='.$this_page, 'succeed');
	}
//模块列表
}elseif($subop == 'siteedit'){

	if(!submitcheck('submit')) {
		require_once libfile('function/profile');
		$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_server_mokuai')." WHERE status <> 3 order by displayorder asc");
		while($row = DB::fetch($query)) {
			$mkgroup_info = DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_server_mokuai_group')." WHERE groupid=".$row['groupid']);
			$mokuai_checkbox .="<label><input name=\"mokuais[]\" type=\"checkbox\" class=\"checkbox\" value=\"".$row['mokuaiid']."\" ".( DB::result_first("SELECT count(*) FROM ".DB::table('wxq123_server_site_mokuai')." WHERE mokuaiid=".$row['mokuaiid'] ." and siteid = ".$siteid) ? ' checked="checked"' : '')."/> ".$mkgroup_info['mokuaititle'].$row['versionname']."</label><br />";
		}
		$status_select = '<select name ="status"><option value="-1" '.($site_info['status']==-1 ? ' selected' :'').'>'.lang('plugin/yiqixueba_server','no').'</option><option value="0" '.($site_info['status']==0 ? ' selected' :'').'>'.lang('plugin/yiqixueba_server','shenqinging').'</option><option value="1" '.($site_info['status']==1 ? ' selected' :'').'>'.lang('plugin/yiqixueba_server','ok').'</option></select>';
		showformheader($this_page.'&subop=siteedit');
		showtableheader($site_info['siteurl'].lang('plugin/yiqixueba_server','site_authorize'));
		$siteid ?showhiddenfields(array('siteid'=>$siteid)) : '';
		showsetting(lang('plugin/yiqixueba_server','siteurl'),'site[siteurl]',$site_info['siteurl'] ? $site_info['siteurl'] : 'http://www.','text','',0,lang('plugin/yiqixueba_server','server_siteurl_comment'),'','',true);
		showsetting(lang('plugin/yiqixueba_server','searchurl'),'site[searchurl]',$site_info['searchurl'] ? $site_info['searchurl'] : str_replace(array("","www."),array("",""),$site_info['siteurl']),'text','',0,lang('plugin/yiqixueba_server','server_searchurl_comment'),'','',true);
		showsetting(lang('plugin/yiqixueba_server','districtproxy'),'','','<div id="residedistrictbox">'.showdistrict(array(DB::result_first("SELECT id FROM ".DB::table('common_district')." WHERE name='".$site_info['prov']."'"),DB::result_first("SELECT id FROM ".DB::table('common_district')." WHERE name='".$site_info['city']."'"),DB::result_first("SELECT id FROM ".DB::table('common_district')." WHERE name='".$site_info['dist']."'"),0), $elems, 'residedistrictbox', 3, 'reside').'</div>','',0,lang('plugin/yiqixueba_server','district_comment'),'','',true);
		echo '<script src="static/js/calendar.js" type="text/javascript"></script>';
		showsetting(lang('plugin/yiqixueba_server','validity'),'groupexpiry',$siteid&&intval($site_info['groupexpiry']==0)?'0':($site_info['groupexpiry'] ? dgmdate($site_info['groupexpiry'],'d') : (intval(date('Y')+1).'-'.date('m').'-'.date('d'))),'calendar','',0,lang('plugin/yiqixueba_server','groupexpiry_comment'),'','',true);
		showsetting(lang('plugin/wxq123','mokuais'),'mokuais','',$mokuai_checkbox,'',0,lang('plugin/wxq123','mokuais_comment'),'','',true);
		showsetting(lang('plugin/yiqixueba_server','status'),'','',$status_select,'',0,lang('plugin/yiqixueba_server','site_status_comment'),'','',true);
		showsubmit('submit');
		showtablefooter();
		showformfooter();
	}else{
		$data['siteurl'] = htmlspecialchars(trim($_GET['site']['siteurl']));
		$data['searchurl'] = $_GET['site']['searchurl'] ? htmlspecialchars(trim($_GET['site']['searchurl'])) : str_replace("www.","",$data['siteurl']);
		$data['updatetime'] = TIMESTAMP;
		$data['salt'] = random(6);
		$data['sitekey'] = md5(md5($data['siteurl']).$data['salt']);
		$data['prov'] = htmlspecialchars(trim($_GET['resideprovince']));
		$data['city'] = htmlspecialchars(trim($_GET['residecity']));
		$data['dist'] = htmlspecialchars(trim($_GET['residedistrict']));
		$data['groupexpiry'] = strtotime(trim(htmlspecialchars($_GET['groupexpiry'])));
		$data['status'] = intval($_GET['status']);
		if(!$data['siteurl']) {
			cpmsg(lang('plugin/yiqixueba_server','siteurl_nonull'));
		}
		if($siteid){
			DB::update('yiqixueba_server_site', $data,array('siteid'=>$siteid));
		}else{
			if (DB::result_first("SELECT count(*) FROM ".DB::table('yiqixueba_server_site')." WHERE siteurl= '".$data['siteurl']."'")==0 ){
				DB::insert('yiqixueba_server_site', $data);
				$siteid = insert_id();
			}
		}
		cpmsg(lang('plugin/yiqixueba_server', 'site_edit_succeed'), 'action='.$this_page.'&subop=sitelist', 'succeed');
	}
}elseif($subop == 'sitemokuai'){
	if(!submitcheck('submit')) {
		showtips(lang('plugin/yiqixueba_server','mokuai_site_tips'));
		showformheader($this_page.'&subop=list');
		showtableheader(lang('plugin/yiqixueba_server','mokuai_site'));
		showsubtitle(array('', lang('plugin/yiqixueba_server','mokuaiico'), lang('plugin/yiqixueba_server','mokuaititle'), lang('plugin/yiqixueba_server','versionname'),lang('plugin/yiqixueba_server','mokuaipice'), lang('plugin/yiqixueba_server','mokuaidescription'),lang('plugin/yiqixueba_server','status'), ''));
		$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_server_mokuai_group')." order by displayorder asc");
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
			$mknum = DB::result_first("SELECT count(*) FROM ".DB::table('yiqixueba_server_mokuai')." WHERE groupid=".$row['groupid']." order by displayorder asc");
			showtablerow('', array('class="td25"', 'class="td25"', 'class="td23"','class="td25"','class="td28"',''), array(
				'',
				$mokuaiico.'<input type="hidden" name="mokuainamenew['.$row['mokuaiid'].']" value="'.$row['mokuainame'].'">',
				$row['mokuaititle'].'('.$row['mokuainame'].')',
				'',
				'',
				'',
				'',
				"<a href=\"".ADMINSCRIPT."?action=$this_page&subop=groupedit&groupid=$row[groupid]\" class=\"act\">".lang('plugin/yiqixueba_server','edit')."</a>&nbsp;&nbsp;".'<a href="'.ADMINSCRIPT.'?action='.$this_page.'&subop=editmokuai&groupid='.$row['groupid'].'"  class="addchildboard">'.lang('plugin/yiqixueba_server','add_ver').'</a>',
			));
			$query1 = DB::query("SELECT * FROM ".DB::table('yiqixueba_server_mokuai')." WHERE groupid=".$row['groupid']." order by displayorder asc");
			$kk = 0;
			while($row1 = DB::fetch($query1)) {
				showtablerow('', array('class="td25"', 'class="td25"', 'class="td23"','class="td25"','class="td23"','class="td29"', 'class="td25"',''), array(
					"",
					'',
					'',
					$row1['versionname'],
					$row1['mokuaipice'],
					$row1['mokuaidescription'],
					$row1['status'] == 0 ? lang('plugin/yiqixueba_server','designing') :($row1['status'] == 1 ? lang('plugin/yiqixueba_server','open') :lang('plugin/yiqixueba_server','close')),
					"<a href=\"".ADMINSCRIPT."?action=$this_page&subop=editmokuai&groupid=$row[groupid]&mokuaiid=$row1[mokuaiid]\" class=\"act\">".lang('plugin/yiqixueba_server','edit')."</a>&nbsp;&nbsp;<a href=\"".ADMINSCRIPT."?action=$this_page&subop=pagelist&groupid=$row[groupid]&mokuaiid=$row1[mokuaiid]\" class=\"act\">".lang('plugin/yiqixueba_server','page')."</a>"
				));
			}
			$kk++;
		}
		echo '<tr><td></td><td colspan="8"><div><a href="'.ADMINSCRIPT.'?action='.$this_page.'&subop=groupedit" class="addtr">'.lang('plugin/yiqixueba_server','add_mokuai').'</a></div></td></tr>';
		showsubmit('submit','submit','del');
		showtablefooter();
		showformfooter();
	}else{
		if($idg = $_GET['delgroup']) {
			$idg = dintval($idg, is_array($idg) ? true : false);
			if($idg) {
				DB::delete('yiqixueba_server_mokuai_group', DB::field('groupid', $idg));
			}
		}
		if($idm = $_GET['delmokuai']) {
			$idm = dintval($idm, is_array($idm) ? true : false);
			if($idm) {
				foreach ( $idm as $k=>$v) {
					rmdirs(DISCUZ_ROOT.'source/plugin/yiqixueba_server/source/mokuai/ver'.$v.'/');
				}
				DB::delete('yiqixueba_server_mokuai', DB::field('mokuaiid', $idm));
			}
		}
		$displayordergnew = $_GET['displayordergnew'];
		if(is_array($displayordergnew)) {
			foreach ( $displayordergnew as $k=>$v) {
				$data['displayorder'] = intval($v);
				DB::update('yiqixueba_server_mokuai_group',$data,array('groupid'=>$k));
			}
		}
		$displayordermnew = $_GET['displayordermnew'];
		if(is_array($displayordermnew)) {
			foreach ( $displayordermnew as $k=>$v) {
				$data['displayorder'] = intval($v);
				DB::update('yiqixueba_server_mokuai',$data,array('mokuaiid'=>$k));
			}
		}
		cpmsg(lang('plugin/yiqixueba_server', 'mokuai_edit_succeed'), 'action='.$this_page, 'succeed');
	}
}

?>