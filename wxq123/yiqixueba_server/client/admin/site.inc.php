<?php

/**
*	һ��ѧ��ƽ̨����
*	�ļ�����site.inc.php  ����ʱ�䣺2013-6-1 15:17  ����
*
*/

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
$this_page = 'plugins&identifier=yiqixueba_server&pmod=admincp&submod=site';

$subop = getgpc('subop');
$subops = array('sitelist','siteedit','sitemokuailist');
$subop = in_array($subop,$subops) ? $subop : $subops[0];

$siteid = intval($_GET['siteid']);
$site_info = $siteid ? DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_server_site')." WHERE siteid=".$siteid) : array();

//վ��������
$sitegroups = array();
$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_server_sitegroup')." order by sitegroupid asc");
while($row = DB::fetch($query)) {
	$sitegroups[$row['sitegroupid']] = $row['sitegroupname'];
}
//ģ������
$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_server_mokuai'));
while($row = DB::fetch($query)) {
	$mokuaiinfo_array[$row['mokuaiid']] = $row;
		
}
//�������ӳ�ʼ��
$other_links = '';
foreach ( $subops as $v) {
	if(strpos($v,'list')) {
		$other_links .= '<a href="'.ADMINSCRIPT.'?action='.$this_page.'&subop='.$v.'">'.lang('plugin/yiqixueba_server',($subop==$v ? 'myself_page':$v)).'</a>&nbsp;&nbsp;';
	}
}
////////

//վ���б�
if($subop == 'sitelist') {
	if(!submitcheck('submit')) {

		showtips(lang('plugin/yiqixueba_server','site_list_tips'));
		showformheader($this_page.'&subop=sitelist');
		showtableheader(lang('plugin/yiqixueba_server','other_link').$other_links);
		showtablefooter();
		showtableheader(lang('plugin/yiqixueba_server','site_list'));
		showsubtitle(array('', '��վ��Ϣ','�û���Ϣ','��װ/����', 'ʹ��ģ��', '״̬', ''));
		$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_server_site')." order by installtime asc");
		while($row = DB::fetch($query)) {
			showtablerow('', array('class="td25"','class="td28"','class="td28"', 'class="td28"', 'class="td28"','class="td25"',''), array(
				"<input class=\"checkbox\" type=\"checkbox\" name=\"delete[]\" value=\"$row[siteid]\">",
				'��ַ:<a href="'.$row['siteurl'].'" target="_blank">'.$row['siteurl'].'</a><br />վ����:'.$sitegroups[$row['sitegroupid']].'<br />����:'.$row['prov'].$row['city'].$row['dist'],
				'����:'.$row['realname'].'&nbsp;&nbsp;�绰:'.$row['phone'].'<br />��ַ:'.$row['address'],
				'��װ:'.($row['installtime'] ? dgmdate($row['installtime'],'d') : '').'<br />����:'.($row['updatetime'] ? dgmdate($row['updatetime'],'d') : '').'<br />ע��:'.($row['regtime'] ? dgmdate($row['regtime'],'d') : '').'<br />ж��:'.($row['uninstalltime'] ? dgmdate($row['uninstalltime'],'d') : '').'<br />����:'.($row['groupexpiry'] ? dgmdate($row['groupexpiry'],'d') : ''),
				'',
				$row['status'] == 0 ? lang('plugin/yiqixueba_server','shenqinging') : ($row['status'] == 1 ? lang('plugin/yiqixueba_server','ok') : lang('plugin/yiqixueba_server','no')),
				"<a href=\"".ADMINSCRIPT."?action=$this_page&subop=siteedit&siteid=$row[siteid]\" class=\"act\">�༭</a><br /><br /><a href=\"".ADMINSCRIPT."?action=$this_page&subop=sitemokuailist&siteid=$row[siteid]\" class=\"act\">ģ��</a>",
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
//վ���༭
}elseif($subop == 'siteedit'){
	//վ��������ѡ��
	$sitegroup_select = '<select name="sitegroupid">';
	foreach ($sitegroups as $k=>$v){
		$sitegroup_select .= '<option value="'.$k.'" '.($site_info['sitegroupid']==$k ? ' selected':'').'>'.$v.'</option>';
	}
	$sitegroup_select .= '</select>';
	if(!submitcheck('submit')) {

		require_once libfile('function/profile');//����ѡ����Ҫʹ�õ�discuz�ĺ���
		//��ȡģ����Ϣ
		$mokuais = dunserialize($site_info['mokuais']);
		//��ȡģ����Ϣ
		$sitegroup_mokuais = dunserialize(DB::result_first("SELECT mokuais FROM ".DB::table('yiqixueba_server_sitegroup')." WHERE sitegroupid=".$site_info['sitegroupid']));
		//���Ϊ����ʹ��վ����Ĭ�ϵ�ģ��ʹ��Ȩ��
		$mokuais = $mokuais ? $mokuais : $sitegroup_mokuais;

		$mokuai_checkbox = '';

		$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_server_mokuai')." WHERE level=2 order by displayorder asc");
		while($row = DB::fetch($query)) {
			$mokuai_checkbox .= "<label><input name=\"mokuais[]\" type=\"checkbox\" class=\"checkbox\" value=\"".$row['verid']."\" ".( in_array($row['verid'],$mokuais) ? ' checked="checked"' : '')."/> ".'<strong>'.$row['mokuaititle'].'</strong><BR>';
			$query1 = DB::query("SELECT * FROM ".DB::table('yiqixueba_server_mokuai')." WHERE upid=".$row['mokuaiid']."  order by displayorder asc");
			while($row1 = DB::fetch($query1)) {
				$query2 = DB::query("SELECT * FROM ".DB::table('yiqixueba_server_mokuaiver')." WHERE mokuaiid=".$row1['mokuaiid']." order by displayorder asc");
				while($row2 = DB::fetch($query2)) {
					$mokuai_checkbox .="<label><input name=\"mokuais[]\" type=\"checkbox\" class=\"checkbox\" value=\"".$row2['verid']."\" ".( in_array($row2['verid'],$mokuais) ? ' checked="checked"' : '')."/> ".$row1['mokuaititle'].$row2['versionname']."</label><BR>";
				}
			}
			$mokuai_checkbox .= '-------------<BR>';
		}

		$status_select = '<select name ="status"><option value="-1" '.($site_info['status']==-1 ? ' selected' :'').'>'.lang('plugin/yiqixueba_server','no').'</option><option value="0" '.($site_info['status']==0 ? ' selected' :'').'>'.lang('plugin/yiqixueba_server','shenqinging').'</option><option value="1" '.($site_info['status']==1 ? ' selected' :'').'>'.lang('plugin/yiqixueba_server','ok').'</option></select>';
		showformheader($this_page.'&subop=siteedit');
		showtableheader($site_info['siteurl'].lang('plugin/yiqixueba_server','site_authorize'));
		$siteid ?showhiddenfields(array('siteid'=>$siteid)) : '';
		showsetting(lang('plugin/yiqixueba_server','siteurl'),'site[siteurl]',$site_info['siteurl'] ? $site_info['siteurl'] : 'http://www.','text','',0,lang('plugin/yiqixueba_server','server_siteurl_comment'),'','',true);
		showsetting(lang('plugin/yiqixueba_server','sitegroupname'),'','',$sitegroup_select,'',0,lang('plugin/yiqixueba_server','server_siteurl_comment'),'','',true);
		showsetting(lang('plugin/yiqixueba_server','searchurl'),'site[searchurl]',$site_info['searchurl'] ? $site_info['searchurl'] : str_replace(array("","www."),array("",""),$site_info['siteurl']),'text','',0,lang('plugin/yiqixueba_server','server_searchurl_comment'),'','',true);
		showsetting(lang('plugin/yiqixueba','realname'),'realname',$site_info['realname'],'text','',0,lang('plugin/yiqixueba','realname_comment'),'','',true);
		showsetting(lang('plugin/yiqixueba','phone'),'phone',$site_info['phone'],'text','',0,lang('plugin/yiqixueba','phone_comment'),'','',true);
		showsetting(lang('plugin/yiqixueba','address'),'address',$site_info['address'],'text','',0,lang('plugin/yiqixueba','address_comment'),'','',true);
		showsetting(lang('plugin/yiqixueba_server','districtproxy'),'','','<div id="residedistrictbox">'.showdistrict(array(DB::result_first("SELECT id FROM ".DB::table('common_district')." WHERE name='".$site_info['prov']."'"),DB::result_first("SELECT id FROM ".DB::table('common_district')." WHERE name='".$site_info['city']."'"),DB::result_first("SELECT id FROM ".DB::table('common_district')." WHERE name='".$site_info['dist']."'"),0), $elems, 'residedistrictbox', 3, 'reside').'</div>','',0,lang('plugin/yiqixueba_server','district_comment'),'','',true);
		showsetting(lang('plugin/yiqixueba','jianyi'),'jianyi',$site_info['jianyi'],'textarea','',0,lang('plugin/yiqixueba','jianyi_comment'),'','',true);
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
		$data['realname'] = htmlspecialchars(trim($_GET['realname']));
		$data['phone'] = htmlspecialchars(trim($_GET['phone']));
		$data['address'] = htmlspecialchars(trim($_GET['address']));
		$data['jianyi'] = htmlspecialchars(trim($_GET['jianyi']));
		$data['prov'] = htmlspecialchars(trim($_GET['resideprovince']));
		$data['city'] = htmlspecialchars(trim($_GET['residecity']));
		$data['dist'] = htmlspecialchars(trim($_GET['residedistrict']));
		$data['groupexpiry'] = strtotime(trim(htmlspecialchars($_GET['groupexpiry'])));
		$data['status'] = intval($_GET['status']);
		$data['sitegroupid'] = intval($_GET['sitegroupid']);
		$data['mokuais'] = serialize($_GET['mokuais']);
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
//վ����ģ��Ȩ�޹���
}elseif($subop == 'sitemokuailist'){
	if(!submitcheck('submit')) {
		showtips('��վ��'.$site_info['siteurl'].'����ģ��Ȩ������');
		showformheader($this_page.'&subop=list');
		showtableheader('ģ���б�');
		showsubtitle(array('', 'ģ������','�汾', '��װʱ��', '��Ч��','ԭ��', 'ʵ��','״̬', ''));
		$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_server_mokuai')." order by displayorder asc");
		while($row = DB::fetch($query)) {
			$mkinfo_site = dunserialize($site_info[$row['mokuainame']]);
			showtablerow('', array('class="td25"', 'class="td23"', 'class="td25"','class="td25"','class="td28"',''), array(
				'',
				$row['mokuaititle'].'('.$row['mokuainame'].')',
				'',
				'',
				'',
				'',
				"<a href=\"".ADMINSCRIPT."?action=$this_page&subop=groupedit&mokuaiid=$row[mokuaiid]\" class=\"act\">".lang('plugin/yiqixueba_server','edit')."</a>&nbsp;&nbsp;".'<a href="'.ADMINSCRIPT.'?action='.$this_page.'&subop=editmokuai&mokuaiid='.$row['mokuaiid'].'"  class="addchildboard">'.lang('plugin/yiqixueba_server','add_ver').'</a>',
			));
			$query1 = DB::query("SELECT * FROM ".DB::table('yiqixueba_server_mokuaiver')." WHERE mokuaiid=".$row['mokuaiid']." order by displayorder asc");
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
					"<a href=\"".ADMINSCRIPT."?action=$this_page&subop=editmokuai&mokuaiid=$row[mokuaiid]&mokuaiid=$row1[mokuaiid]\" class=\"act\">".lang('plugin/yiqixueba_server','edit')."</a>&nbsp;&nbsp;<a href=\"".ADMINSCRIPT."?action=$this_page&subop=pagelist&mokuaiid=$row[mokuaiid]&mokuaiid=$row1[mokuaiid]\" class=\"act\">".lang('plugin/yiqixueba_server','page')."</a>"
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
				DB::delete('yiqixueba_server_mokuai', DB::field('mokuaiid', $idg));
			}
		}
		if($idm = $_GET['delmokuai']) {
			$idm = dintval($idm, is_array($idm) ? true : false);
			if($idm) {
				foreach ( $idm as $k=>$v) {
					rmdirs(DISCUZ_ROOT.'source/plugin/yiqixueba_server/source/mokuai/ver'.$v.'/');
				}
				DB::delete('yiqixueba_server_mokuaiver', DB::field('mokuaiid', $idm));
			}
		}
		$displayordergnew = $_GET['displayordergnew'];
		if(is_array($displayordergnew)) {
			foreach ( $displayordergnew as $k=>$v) {
				$data['displayorder'] = intval($v);
				DB::update('yiqixueba_server_mokuai',$data,array('mokuaiid'=>$k));
			}
		}
		$displayordermnew = $_GET['displayordermnew'];
		if(is_array($displayordermnew)) {
			foreach ( $displayordermnew as $k=>$v) {
				$data['displayorder'] = intval($v);
				DB::update('yiqixueba_server_mokuaiver',$data,array('mokuaiid'=>$k));
			}
		}
		cpmsg(lang('plugin/yiqixueba_server', 'mokuai_edit_succeed'), 'action='.$this_page, 'succeed');
	}
}

?>