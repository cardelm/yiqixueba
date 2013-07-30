<?php

/**
 *      [17xue8.cn] (C)2013-2099 杨文.
 *      这不是免费的。
 *
 */

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

$submod = getgpc('submod');
$submods = array('list','siteyeslist','sitenolist','authorize','mokuaiauthorize');
$submod = in_array($submod,$submods) ? $submod : $submods[0];

$siteid = intval($_GET['siteid']);
$site_info = $siteid ? DB::fetch_first("SELECT * FROM ".DB::table('wxq123_server_site')." WHERE siteid=".$siteid) : array();

$mokuaiid = intval($_GET['mokuaiid']);
$mokuai_info = $mokuaiid ? DB::fetch_first("SELECT * FROM ".DB::table('wxq123_server_mokuai')." WHERE mokuaiid=".$mokuaiid) : array();


if($submod == 'list') {
	if(!submitcheck('submit')) {
		showformheader('plugins&identifier=wxq123&pmod=serversite&submod=list');
		showtableheader(lang('plugin/wxq123','sitekey_list'));
		showsubtitle(array('',lang('plugin/wxq123','siteurl'), lang('plugin/wxq123','installtime'),lang('plugin/wxq123','districtproxy'),lang('plugin/wxq123','weixininfo'),lang('plugin/wxq123','usemokuai'),lang('plugin/wxq123','status'), ''));
		$query = DB::query("SELECT * FROM ".DB::table('wxq123_server_mokuai')." WHERE status = 1 order by displayorder asc");
		while($row = DB::fetch($query)) {
			$mokuais_array[$row['mokuaiid']] = $row['mokuaititle'];
		}
		$perpage = 20;
		$start = ($page - 1) * $perpage;
		$sitecount = DB::result_first("SELECT count(*) FROM ".DB::table('wxq123_server_site'));
		$multi = multi($sitecount, $perpage, $page, ADMINSCRIPT."?action=plugins&identifier=wxq123&pmod=serversite");
		$query = DB::query("SELECT * FROM ".DB::table('wxq123_server_site')." order by siteid asc");
		while($row = DB::fetch($query)) {
			$mokuais = '';
			$mknum = DB::result_first("SELECT count(*) FROM ".DB::table('wxq123_server_site_mokuai')." WHERE siteid = ".$row['siteid']);
			$query1 = DB::query("SELECT * FROM ".DB::table('wxq123_server_site_mokuai')." WHERE siteid = ".$row['siteid']);
			$k = 1;
			while($row1 = DB::fetch($query1)) {
				$mokuais .= '<a href="'.ADMINSCRIPT.'?action=plugins&identifier=wxq123&pmod=serversite&submod=mokuaiauthorize&siteid='.$row1['siteid'].'&mokuaiid='.$row1['mokuaiid'].'">'.$mokuais_array[$row1['mokuaiid']].'</a>'.((ceil($mknum/3)==$k||ceil($mknum*2/3)==$k)?'<br />':'&nbsp;');
				$k++;
			}
			showtablerow('', array('','class="td29"', 'class="td28"','class="td28"','class="td28"','class="td28"','class="td25"',''), array(
				"<input class=\"checkbox\" type=\"checkbox\" name=\"delete[]\" value=\"$row[siteid]\">",
				$row['siteurl'].'<br />'.lang('plugin/wxq123','charset').':'.$row['charset'].'<br />'.lang('plugin/wxq123','clientip').':'.$row['clientip'],
				lang('plugin/wxq123','chuzhuang').dgmdate($row['installtime'],'dt').'<br />'.lang('plugin/wxq123','zuihou').($row['updatetime']?dgmdate($row['updatetime'],'dt'):'').'<br />'.lang('plugin/wxq123','weixintj').($row['tijiaotime']? dgmdate($row['tijiaotime'],'dt'):''),
				$row['prov'].'<br />'.$row['city'].'<br />'.$row['dist'],
				$row['shibiema'].'<br />'.$row['token'],
				$mokuais,
				$row['status'] == 0 ? lang('plugin/wxq123','shenqinging') : ($row['status'] == 1 ? lang('plugin/wxq123','ok') : lang('plugin/wxq123','no')),
			'',
				"<a href=\"".ADMINSCRIPT."?action=plugins&identifier=wxq123&pmod=serversite&submod=authorize&siteid=$row[siteid]\" class=\"act\">".lang('plugin/wxq123','site_authorize')."</a>",
			));
		}
		echo '<tr><td></td><td colspan="7"><div><a href="'.ADMINSCRIPT.'?action=plugins&identifier=wxq123&pmod=serversite&submod=authorize" class="addtr">'.lang('plugin/wxq123','add_site').'</a></div></td></tr>';
		showsubmit('submit','submit','del','',$multi);
		showtablefooter();
		showformfooter();
	}else{
		if($ids = $_GET['delete']) {
			$ids = dintval($ids, is_array($ids) ? true : false);
			if($ids) {
				DB::delete('wxq123_server_site_mokuai', DB::field('siteid', $ids));
			}
		}
	}
}elseif($submod == 'authorize') {
	if(!submitcheck('submit')) {
		require_once libfile('function/profile');
		$shibiema = random(4,1);
		while(DB::result_first("SELECT count(*) FROM ".DB::table('wxq123_server_site')." WHERE shibiema='".$shibiema ."'")) {
			$shibiema = random(4,1);
		}
		$query = DB::query("SELECT * FROM ".DB::table('wxq123_server_mokuai')." WHERE status <> 3 order by displayorder asc");
		while($row = DB::fetch($query)) {
			$mkgroup_info = DB::fetch_first("SELECT * FROM ".DB::table('wxq123_server_mokuai_group')." WHERE groupid=".$row['groupid']);
			$mokuai_checkbox .="<label><input name=\"mokuais[]\" type=\"checkbox\" class=\"checkbox\" value=\"".$row['mokuaiid']."\" ".( DB::result_first("SELECT count(*) FROM ".DB::table('wxq123_server_site_mokuai')." WHERE mokuaiid=".$row['mokuaiid'] ." and siteid = ".$siteid) ? ' checked="checked"' : '')."/> ".$mkgroup_info['mokuaititle'].$row['versionname']."</label><br />";
		}
		$status_select = '<select name ="status"><option value="-1" '.($site_info['status']==-1 ? ' selected' :'').'>'.lang('plugin/wxq123','no').'</option><option value="0" '.($site_info['status']==0 ? ' selected' :'').'>'.lang('plugin/wxq123','shenqinging').'</option><option value="1" '.($site_info['status']==1 ? ' selected' :'').'>'.lang('plugin/wxq123','ok').'</option></select>';
		showformheader('plugins&identifier=wxq123&pmod=serversite&submod=authorize');
		showtableheader($site_info['siteurl'].lang('plugin/wxq123','site_authorize'));
		$siteid ?showhiddenfields($hiddenfields = array('siteid'=>$siteid)) : '';
		showsetting(lang('plugin/wxq123','siteurl'),'site[siteurl]',$site_info['siteurl'],'text','',0,lang('plugin/wxq123','server_siteurl_comment'),'','',true);
		showsetting(lang('plugin/wxq123','districtproxy'),'','','<div id="residedistrictbox">'.showdistrict(array(DB::result_first("SELECT id FROM ".DB::table('common_district')." WHERE name='".$site_info['prov']."'"),DB::result_first("SELECT id FROM ".DB::table('common_district')." WHERE name='".$site_info['city']."'"),DB::result_first("SELECT id FROM ".DB::table('common_district')." WHERE name='".$site_info['dist']."'"),0), $elems, 'residedistrictbox', 3, 'reside').'</div>','',0,lang('plugin/wxq123','district_comment'),'','',true);
		showsetting(lang('plugin/wxq123','shibiecode'),'site[shibiema]',$site_info['shibiema']?$site_info['shibiema']:$shibiema,'text','',0,lang('plugin/wxq123','shibiecode_comment'),'','',true);
		showsetting(lang('plugin/wxq123','sitetoken'),'site[token]',$site_info['token']?$site_info['token']:random(6,0),'text','',0,lang('plugin/wxq123','sitetoken_comment'),'','',true);
		echo '<script src="static/js/calendar.js" type="text/javascript"></script>';
		showsetting(lang('plugin/wxq123','validity'),'groupexpiry',$siteid&&intval($site_info['groupexpiry']==0)?'0':($site_info['groupexpiry'] ? dgmdate($site_info['groupexpiry'],'d') : (intval(date('Y')+1).'-'.date('m').'-'.date('d'))),'calendar','',0,lang('plugin/wxq123','groupexpiry_comment'),'','',true);
		showsetting(lang('plugin/wxq123','mokuais'),'mokuais','',$mokuai_checkbox,'',0,lang('plugin/wxq123','mokuais_comment'),'','',true);
		showsetting(lang('plugin/wxq123','status'),'','',$status_select,'',0,lang('plugin/wxq123','status_comment'),'','',true);
		showsubmit('submit');
		showtablefooter();
		showformfooter();
	}else{
		$data['siteurl'] = htmlspecialchars(trim($_GET['site']['siteurl']));
		$data['searchurl'] = str_replace("http://","",$data['siteurl']);
		$data['searchurl'] = str_replace("www.","",$data['searchurl']);
		$data['updatetime'] = TIMESTAMP;
		$data['token'] = htmlspecialchars(trim($_GET['site']['token']));
		$data['shibiema'] = htmlspecialchars(trim($_GET['site']['shibiema']));
		$data['salt'] = random(6);
		$data['sitekey'] = md5(md5($data['siteurl']).$data['salt']);
		$data['prov'] = htmlspecialchars(trim($_GET['resideprovince']));
		$data['city'] = htmlspecialchars(trim($_GET['residecity']));
		$data['dist'] = htmlspecialchars(trim($_GET['residedistrict']));
		$data['groupexpiry'] = strtotime(trim(htmlspecialchars($_GET['groupexpiry'])));
		$data['status'] = intval($_GET['status']);
		if(!$data['siteurl']) {
			cpmsg(lang('plugin/wxq123','siteurl_nonull'));
		}
		if($siteid){
			DB::update('wxq123_server_site', $data,array('siteid'=>$siteid));
		}else{
			if (DB::result_first("SELECT count(*) FROM ".DB::table('wxq123_server_site')." WHERE siteurl= '".$data['siteurl']."'")==0 ){
				DB::insert('wxq123_server_site', $data);
				$siteid = insert_id();
			}
		}
		$query = DB::query("SELECT * FROM ".DB::table('wxq123_server_site_mokuai')." WHERE siteid = ".$siteid);
		while($row = DB::fetch($query)) {
			if (!in_array($row['mokuaiid'],$_GET['mokuais'])){
				DB::delete('wxq123_server_site_mokuai',array('siteid' => $siteid,'mokuaiid' =>$row['mokuaiid']));
			}
		}
		if (is_array($_GET['mokuais'])){
			foreach ($_GET['mokuais'] as $k=>$v){
				if(DB::result_first("SELECT count(*) FROM ".DB::table('wxq123_server_site_mokuai')." WHERE siteid = ".$siteid." and mokuaiid = ".$v)==0){
					DB::insert('wxq123_server_site_mokuai',array('siteid' => $siteid,'mokuaiid' =>$v));
				}
			}
		}
		cpmsg(lang('plugin/wxq123', 'site_edit_succeed'), 'action=plugins&identifier=wxq123&pmod=serversite', 'succeed');
	}
}elseif($submod == 'mokuaiauthorize') {
	if(!submitcheck('submit')) {
		showformheader('plugins&identifier=wxq123&pmod=serversite&submod=mokuaiauthorize');
		showtableheader($site_info['siteurl'].'--'.$mokuai_info['mokuaititle'].'--'.lang('plugin/wxq123','site_authorize'));
		showhiddenfields($hiddenfields = array( 'siteid'=>$siteid, 'mokuaiid'=>$mokuaiid )) ;
		showsubmit('submit');
		showtablefooter();
		showformfooter();
	}else{
	}




}elseif($submod == 'list1') {
}
function checkchar($char,$lh_num){
	$char_array = str_split($char);
	if ($lh_num > count($char_array))
		$lh_num = count($char_array);

	$char_len = strlen($char);

	$ii = 0;

	for($i=0;$i<=($char_len-$lh_num);$i++){
		$jj = 0;
		for ($j=0;$j<=$i;$j++){
			$kt = $ka = $kd = 0;
			for ($k=0;$k<($char_len-$i-1);$k++){
				$return .= ($k+$j).'='.($k+$j+1).'&nbsp;&nbsp;';
				if ($char_array[($k+$j)] == $char_array[($k+$j+1)]){
					$kt++;
				}
				if ($char_array[($k+$j)] == $char_array[($k+$j+1)]+1 ){
					$ka++;
				}
				if ($char_array[($k+$j)] == $char_array[($k+$j+1)]-1){
					$kd++;
				}
			}
			if ($kt==($char_len-$i-1) ||$ka==($char_len-$i-1) ||$kd==($char_len-$i-1)){
				$ii++;
			}
		}

	}
	$char_array_temp = array_unique($char_array);
	if (count($char_array_temp)<=3){
		$ii=1;
	}
	$return = $ii;
	return $return;
}
//for ($i=0;$i<10;$i++){
//	$char = random(6,1);
//	while (checkchar($char,3)){
//		$char = random(6,1);
//	}
//	//echo checkchar($char,3);
//	//echo $char.' '.(checkchar($char,3)?'Is':'no').' (L or T)<br />';
//}
//$char = random(6,1);
//echo $char;

?>