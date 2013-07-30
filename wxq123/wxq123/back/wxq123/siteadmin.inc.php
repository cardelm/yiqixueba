<?php

/**
 *      [17xue8.cn] (C)2013-2099 杨文.
 *      这不是免费的。
 *
 */

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

$subop = getgpc('subop');
$subops = array('sitelist','siteedit','sitesetting');
$subop = in_array($subop,$subops) ? $subop : $subops[0];

$siteid = getgpc('siteid');
$query = DB::query("SELECT * FROM ".DB::table('wxq123_mokuai')." WHERE status = 1 and urluser = 1 order by displayorder asc");
while($row = DB::fetch($query)) {
	$mokuais[] = $row;
}


if($subop == 'sitelist'){
	$sitename = trim(getgpc('sitename'));
	$tpp = intval(getgpc('tpp')) ? intval(getgpc('tpp')) : '20';
	$renling = intval(getgpc('renling'));
	$bhmokuai = trim(getgpc('bhmokuai'));
	$qianfei = intval(getgpc('qianfei'));
	$select[$tpp] = $tpp ? "selected='selected'" : '';
	$tpp_options = "<option value='20' $select[20]>20</option><option value='50' $select[50]>50</option><option value='100' $select[100]>100</option>";
	$renlingoptions = '<option value="0" '.(!$renling?' selected':'').'>'.lang('plugin/wxq123','all').'</option><option value="1" '.($renling ==1?' selected':'').'>'.lang('plugin/wxq123','renling_no').'</option><option value="2" '.($renling ==2?' selected':'').'>'.lang('plugin/wxq123','renling_yes').'</option>';
	$qianfeioptions = '<option value="0" '.(!$qianfei?' selected':'').'>'.lang('plugin/wxq123','all').'</option><option value="1" '.($qianfei ==1?' selected':'').'>'.lang('plugin/wxq123','qianfei_no').'</option><option value="2" '.($qianfei ==2?' selected':'').'>'.lang('plugin/wxq123','qianfei_yes').'</option><option value="3" '.($qianfei ==3?' selected':'').'>'.lang('plugin/wxq123','qianfei_mian').'</option>';
	$baohanmokuais = '<select name="bhmokuai"><option value="" '.(!$bhmokuai?' selected':'').'>'.lang('plugin/wxq123','all').'</option>';
	$get_text = '&tpp='.$tpp.'&sitename='.$sitename.'&renling='.$renling.'&qianfei='.$qianfei.'&bhmokuai='.$bhmokuai;
	foreach ( $mokuais as $key=>$mokuai) {
		$baohanmokuais .= '<option value="'.$mokuai['mokuainame'].'" '.($bhmokuai == $mokuai['mokuainame'] ? ' selected':'').'>'.$mokuai['mokuaititle'].'</option>';
	}
	$baohanmokuais .= '</select>';
	showtips(lang('plugin/wxq123','site_list_tips'));
	showformheader("plugins&identifier=wxq123&pmod=siteadmin&submod=list".$get_text);
	showtableheader('search');
	showtablerow('', array('width="60"', 'width="160"', 'width="60"'),
		array(
			lang('plugin/wxq123','sitename'), "<input size=\"15\" name=\"sitename\" type=\"text\" value=\"$sitename\" />",
			lang('plugin/wxq123','baohanmokuai'), $baohanmokuais,
		)
	);
	showtablerow('', array('width="60"', 'width="160"', 'width="60"'),
			array(
					"$lang[perpage]",
					"<select name=\"tpp\">$tpp_options</select>",
					"$lang[moderate_bound]",
					"<select name=\"renling\">$renlingoptions</select>
					<select name=\"qianfei\">$qianfeioptions</select>
					<input class=\"btn\" type=\"submit\" value=\"$lang[search]\" />"
			)
	);

	showtablefooter();
	showformfooter();
	showformheader("plugins&identifier=wxq123&pmod=siteadmin&submod=list".$get_text);
	$perpage = $tpp;
	$start = ($page - 1) * $perpage;
	$where = "";
	if($renling) {
		$where1 .= " and stauts = ".$renling;
	}
	if($qianfei) {
		if($qianfei==1) {
			$where1 .= " and groupexpiry > ".time();
		}elseif($qianfei==2) {
			$where1 .= " and groupexpiry < ".time();
		}elseif($qianfei==3) {
			$where1 .= " and groupexpiry = 0 ";
		}
	}
	foreach ( $mokuais as $key=>$mokuai) {
		if($bhmokuai ==$mokuai['mokuainame']) {
			$where1 .= " and m_".$mokuai['mokuainame']." = 1";
		}
	}
	if(substr($where1,0,4)==' and') {
		$where1 = substr($where1,4,strlen($where1));
	}
	if($sitename) {
		if($where1) {
			$where .= $where1." and sitename like '%".$sitename."%' or ".$where1." and siteshortname like '%".$sitename."%'";
		}else{
			$where .= " sitename like '%".$sitename."%' or siteshortname like '%".$sitename."%'";
		}
	}else{
		$where .= $where1;
	}
	$where = $where ? (" where ".$where):'';
	$sitecount = DB::result_first("SELECT count(*) FROM ".DB::table('wxq123_site').$where);
	$multi = multi($sitecount, $perpage, $page, ADMINSCRIPT."?action=plugins&identifier=wxq123&pmod=siteadmin".$get_text);
	showtableheader(lang('plugin/wxq123','site_list').'&nbsp;&nbsp;'.lang('plugin/wxq123','sitecount').$sitecount);
	showsubtitle(array('',lang('plugin/wxq123','siteshortname'),lang('plugin/wxq123','shibiecode'),lang('plugin/wxq123','sitemember'), lang('plugin/wxq123','sitevalidity'),lang('plugin/wxq123','sitemokuais'),lang('plugin/wxq123','sitestauts'),'' ));
	$query = DB::query("SELECT * FROM ".DB::table('wxq123_site').$where." order by siteid desc limit ".$start.",".$perpage." ");
	while($row = DB::fetch($query)) {
		$sitemokuais = '';
		foreach ( $mokuais as $key=>$mokuai) {
			if($row['m_'.$mokuai['mokuainame']]) {
				$sitemokuais .= '&nbsp;'.$mokuai['mokuaititle'];
			}
		}
		$sitemember = dunserialize($row['sitemember']);
		$sitemember_text ='';
		if(is_array($sitemember['sitemanage'])) {
			foreach ( $sitemember['sitemanage'] as $v) {
				$sitemember_text .= $v ?('&nbsp;<a href="'.ADMINSCRIPT.'?action=members&operation=edit&uid='.DB::result_first("SELECT uid FROM ".DB::table('common_member')." WHERE username='".$v."'").'" target="_blank">'.$v.'</a>'):'';
			}
		}
		if(is_array($sitemember['siteuser'])) {
			foreach ( $sitemember['siteuser'] as $v) {
				$sitemember_text .= $v ?('&nbsp;<a href="'.ADMINSCRIPT.'?action=members&operation=edit&uid='.DB::result_first("SELECT uid FROM ".DB::table('common_member')." WHERE username='".$v."'").'" target="_blank">'.$v.'</a>'):'';
			}
		}
		showtablerow('', array('class="td25"', 'class="td23"', '', ''), array(
			"<input class=\"checkbox\" type=\"checkbox\" name=\"delete[]\" value=\"$row[siteid]\">",
			$row['siteurl'] ? '<a href="'.$row['siteurl'].'" target="_blank" title="'.$row['siteurl'].'">'.$row['siteshortname'].'</a>':$row['siteshortname'],
			$row['shibiecode'],
			$sitemember_text,
			$row['groupexpiry'] ? dgmdate($row['groupexpiry'],'d') : lang('plugin/wxq123','qianfei_mian'),
			$sitemokuais,
			$row['stauts']==0 ? '<img src="static/image/common/access_disallow.gif" width="16" height="16" />':($row['stauts']==1 ? '<img src="static/image/common/access_allow.gif" width="16" height="16" />':'<img src="static/image/common/fav.gif" width="16" height="16" />'),
			"<a href=\"".ADMINSCRIPT."?action=plugins&identifier=wxq123&pmod=siteadmin&subop=siteedit&siteid=$row[siteid]\" class=\"act\">".$lang['edit']."</a>",
		));
	}
	echo '<tr><td></td><td colspan="6"><div><a href="'.ADMINSCRIPT.'?action=plugins&identifier=wxq123&pmod=siteadmin&subop=siteedit" class="addtr">'.lang('plugin/wxq123','add_site').'</a></div></td></tr>';
	showsubmit('submit','submit','del','',$multi);
	showtablefooter();
	showformfooter();
}elseif($subop == 'siteedit'){
	if($siteid){
		$site_info = DB::fetch_first("SELECT * FROM ".DB::table('wxq123_site')." WHERE siteid='".$siteid."'");
	}
	if(!submitcheck('submit')) {
		if($site_info['sitelogo']!='') {
			$sitelogo = str_replace('{STATICURL}', STATICURL, $site_info['sitelogositelogo']);
			if(!preg_match("/^".preg_quote(STATICURL, '/')."/i", $sitelogo) && !(($valueparse = parse_url($sitelogo)) && isset($valueparse['host']))) {
				$sitelogo = $_G['setting']['attachurl'].'common/'.$site_info['sitelogo'].'?'.random(6);
				list($imgwidth,$imgheight) =  GetImageSize($_G['setting']['attachurl'].'common/'.$site_info['sitelogo']);
			}
			$sitelogohtml = '<label><input type="checkbox" class="checkbox" name="delete1" value="yes" /> '.$lang['del'].'</label><br /><img src="'.$sitelogo.'" width="'.$imgwidth.'" height="'.$imgheight.'"/>';
		}
		if($site_info['weixinimage']!='') {
			$weixinimage = str_replace('{STATICURL}', STATICURL, $site_info['weixinimageweixinimage']);
			if(!preg_match("/^".preg_quote(STATICURL, '/')."/i", $weixinimage) && !(($valueparse = parse_url($weixinimage)) && isset($valueparse['host']))) {
				$weixinimage = $_G['setting']['attachurl'].'common/'.$site_info['weixinimage'].'?'.random(6);
				list($imgwidth,$imgheight) =  GetImageSize($_G['setting']['attachurl'].'common/'.$site_info['weixinimage']);
			}
			$weixinimagehtml = '<label><input type="checkbox" class="checkbox" name="delete2" value="yes" /> '.$lang['del'].'</label><br /><img src="'.$weixinimage.'" width="'.$imgwidth.'" height="'.$imgheight.'"/>';
		}
		$query = DB::query("SELECT * FROM ".DB::table('wxq123_mokuai')." WHERE status = 1 and urluser = 1 order by displayorder asc");
		while($row = DB::fetch($query)) {
			$mokuai_checkbox .="<label><input name=\"m_".$row['mokuainame']."\" type=\"checkbox\" class=\"checkbox\" value=\"1\" ".($site_info['m_'.$row['mokuainame']] ? ' checked="checked"' : '')."/> ".$row['mokuaititle']."</label><br />";
		}
		$baidus = dunserialize($site_info['sitebaidu']);
		$sitemember = dunserialize($site_info['sitemember']);
		showtips($siteid ? lang('plugin/wxq123','site_edit_tips') : lang('plugin/wxq123','site_add_tips'));
		showformheader("plugins&identifier=wxq123&pmod=siteadmin&subop=siteedit",'enctype');
		showtableheader($siteid ? lang('plugin/wxq123','site_edit') : lang('plugin/wxq123','site_add'));
		showhiddenfields(array('siteid'=>$siteid));
		showsetting(lang('plugin/wxq123','siteshortname'),'siteshortname',$site_info['siteshortname'],'text','',0,lang('plugin/wxq123','siteshortname_comment'),'','',true);
		showsetting(lang('plugin/wxq123','sitename'),'sitename',$site_info['sitename'],'text','',0,lang('plugin/wxq123','sitename_comment'),'','',true);
		showsetting(lang('plugin/wxq123','siteurl'),'siteurl',$site_info['siteurl'],'text','','',lang('plugin/wxq123','siteurl_comment'));
		showsetting(lang('plugin/wxq123','sitemokuais'),'','',$mokuai_checkbox);
		showsetting(lang('plugin/wxq123','shibiecode'),'shibiecode',$site_info['shibiecode'],'text','','','');
		showsetting(lang('plugin/wxq123','sitelogo'),'sitelogo',$site_info['sitelogo'],'filetext','','',$sitelogohtml);
		showsetting(lang('plugin/wxq123','sitephone'),'sitephone',$site_info['sitephone'],'text','',0,lang('plugin/wxq123','sitephone_comment'),'','',true);
		showsetting(lang('plugin/wxq123','siteaddress'),'siteaddress',$site_info['siteaddress'],'text','',0,lang('plugin/wxq123','siteaddress_comment'),'','',true);
		showsetting(lang('plugin/wxq123','sitelianxiren'),'sitelianxiren',$site_info['sitelianxiren'],'text','',0,lang('plugin/wxq123','sitelianxiren_comment'),'','',true);
		echo '<script src="static/js/calendar.js" type="text/javascript"></script>';
		showtablefooter();
		showtableheader();
		showsetting(lang('plugin/wxq123','sitevalidity'),'groupexpiry',$siteid&&intval($site_info['groupexpiry']==0)?'0':($site_info['groupexpiry'] ? dgmdate($site_info['groupexpiry'],'d') : (intval(date('Y')+1).'-'.date('m').'-'.date('d'))),'calendar','',0,'','','',true);
		showsetting(lang('plugin/wxq123','sitetoken'),'token',$site_info['token']?$site_info['token']:random(6),'text','',0,'','','',true);
		showsetting(lang('plugin/wxq123','siteweixinimage'),'weixinimage',$site_info['weixinimage'],'filetext','',0,$weixinimagehtml,'','',true);
		showsetting(lang('plugin/wxq123','siteweixinhao'),'siteweixinhao',$site_info['siteweixinhao'],'text','',0,'','','',true);
		showsetting(lang('plugin/wxq123','siteweixinpass'),'siteweixinpass',$site_info['siteweixinpass'],'password','',0,'','','',true);
		showsetting(lang('plugin/wxq123','sitemanage'),'sitemanage',implode("\n",$sitemember['sitemanage']),'textarea','',0,lang('plugin/wxq123','sitemanage_comment'),'','',true);
		showsetting(lang('plugin/wxq123','siteuser'),'siteuser',implode("\n",$sitemember['siteuser']),'textarea','',0,lang('plugin/wxq123','siteuser_comment'),'','',true);
		showsetting(lang('plugin/wxq123','sitestauts'),'stauts',$site_info['stauts'],'radio','',0,'','','',true);
		showsubmit('submit');
		showtablefooter();
		showformfooter();
	}else{
		$sitelogo = addslashes($_POST['sitelogo']);
		if($_FILES['sitelogo']) {
			$upload = new discuz_upload();
			if($upload->init($_FILES['sitelogo'], 'common') && $upload->save()) {
				$sitelogo = $upload->attach['attachment'];
			}
		}
		if($_POST['delete1'] && addslashes($_POST['sitelogo'])) {
			$valueparse = parse_url(addslashes($_POST['sitelogo']));
			if(!isset($valueparse['host']) && !strexists(addslashes($_POST['sitelogo']), '{STATICURL}')) {
				@unlink($_G['setting']['attachurl'].'common/'.addslashes($_POST['sitelogo']));
			}
			$sitelogo = '';
		}
		$weixinimage = addslashes($_POST['weixinimage']);
		if($_FILES['weixinimage']) {
			$upload = new discuz_upload();
			if($upload->init($_FILES['weixinimage'], 'common') && $upload->save()) {
				$weixinimage = $upload->attach['attachment'];
			}
		}
		if($_POST['delete2'] && addslashes($_POST['weixinimage'])) {
			$valueparse = parse_url(addslashes($_POST['weixinimage']));
			if(!isset($valueparse['host']) && !strexists(addslashes($_POST['weixinimage']), '{STATICURL}')) {
				@unlink($_G['setting']['attachurl'].'common/'.addslashes($_POST['weixinimage']));
			}
			$weixinimage = '';
		}
		$sitemember_old = dunserialize($site_info['sitemember']);//原管理员
		$sitemember['sitemanage'] = htmlspecialchars(trim($_GET['sitemanage'])) ?explode("\n",htmlspecialchars(trim($_GET['sitemanage']))) : '';
		$sitemember['siteuser'] = htmlspecialchars(trim($_GET['siteuser'])) ? explode("\n",htmlspecialchars(trim($_GET['siteuser']))) : '';
		if(is_array($sitemember['sitemanage'])) {
			foreach ( $sitemember['sitemanage'] as $v) {
				if($v && DB::result_first("SELECT count(*) FROM ".DB::table('common_member')." WHERE username='".$v."'")==0) {
					cpmsg(lang('plugin/wxq123','sitemanage_err'));
				}
			}
		}
		if(is_array($sitemember['siteuser'])) {
			foreach ($v &&  $sitemember['siteuser'] as $v) {
				if(DB::result_first("SELECT count(*) FROM ".DB::table('common_member')." WHERE username='".$v."'")==0) {
					cpmsg(lang('plugin/wxq123','siteuser_err'));
				}
			}
		}
		$data['sitename'] = htmlspecialchars($_GET['sitename']);
		$data['siteshortname'] = htmlspecialchars($_GET['siteshortname']);
		$data['sitemember'] = is_array($sitemember['sitemanage'])||is_array($sitemember['siteuser'])?serialize($sitemember):'';
		$data['sitelogo'] = $sitelogo;
		$data['siteurl'] = htmlspecialchars($_GET['siteurl']);
		$data['shibiecode'] = htmlspecialchars($_GET['shibiecode']);
		$data['sitephone'] = htmlspecialchars($_GET['sitephone']);
		$data['siteaddress'] = htmlspecialchars($_GET['siteaddress']);
		$data['sitelianxiren'] = htmlspecialchars($_GET['sitelianxiren']);
		$query = DB::query("SELECT * FROM ".DB::table('wxq123_mokuai')." WHERE status = 1 and urluser = 1 order by displayorder asc");
		while($row = DB::fetch($query)) {
			$data['m_'.$row['mokuainame']] = trim(htmlspecialchars($_GET['m_'.$row['mokuainame']]));
		}
		$data['groupexpiry'] = strtotime(trim(htmlspecialchars($_GET['groupexpiry'])));
		$data['stauts'] = intval($_GET['stauts']);
		$data['siteweixinhao'] = htmlspecialchars($_GET['siteweixinhao']);
		$data['siteweixinpass'] = htmlspecialchars($_GET['siteweixinpass']);
		$data['token'] = htmlspecialchars($_GET['token']);
		$data['weixinimage'] = $weixinimage;
		if(!$data['sitename']) {
			cpmsg(lang('plugin/wxq123','sitename_nonull'));
		}
		if(!$data['siteshortname']) {
			cpmsg(lang('plugin/wxq123','siteshortname_nonull'));
		}
		if($siteid){
			DB::update('wxq123_site', $data,array('siteid'=>$siteid));
		}else{
			if (DB::result_first("SELECT count(*) FROM ".DB::table('wxq123_site')." WHERE sitename= '".$data['sitename']."'")==0 ){
				DB::insert('wxq123_site', $data);
				$siteid = insert_id();
			}
		}
		//删除wxq123_member表中的数值
		foreach ($sitemember_old['sitemanage'] as $v){
			if (!in_array($v,$sitemember['sitemanage'])){
				$muid = intval(DB::result_first("SELECT uid FROM ".DB::table('common_member')." WHERE username= '".$v."'"));
				$membermanage = dunserialize(DB::result_first("SELECT sitemanage FROM ".DB::table('wxq123_member')." WHERE uid= ".$muid));
				foreach ($membermanage as $vu){
					if ($vu!=$site){
						$membermanage_new[] = $vu;
					}
				}
				if (DB::result_first("SELECT count(*) FROM ".DB::table('wxq123_member')." WHERE uid= ".$muid)==0){
					DB::insert('wxq123_member',array('sitemanage'=>serialize($membermanage_new),'regtime'=>time(),'uid'=>$muid));
				}else{
					DB::update('wxq123_member',array('sitemanage'=>serialize($membermanage_new)),array('uid'=>$muid));
				}
			}
		}
		foreach ($sitemember_old['siteuser'] as $v){
			if (!in_array($v,$sitemember['siteuser'])){
				$muid = intval(DB::result_first("SELECT uid FROM ".DB::table('common_member')." WHERE username= '".$v."'"));
				$memberuser = dunserialize(DB::result_first("SELECT siteuser FROM ".DB::table('wxq123_member')." WHERE uid= ".$muid));
				foreach ($memberuser as $vu){
					if ($vu!=$site){
						$memberuser_new[] = $vu;
					}
				}
				if (DB::result_first("SELECT count(*) FROM ".DB::table('wxq123_member')." WHERE uid= ".$muid)==0){
					DB::insert('wxq123_member',array('siteuser'=>serialize($memberuser_new),'regtime'=>time(),'uid'=>$muid));
				}else{
					DB::update('wxq123_member',array('siteuser'=>serialize($memberuser_new)),array('uid'=>$muid));
				}
			}
		}
		//增加wxq123_member表中的数值
		foreach ($sitemember['sitemanage'] as $v){
			$muid = intval(DB::result_first("SELECT uid FROM ".DB::table('common_member')." WHERE username= '".$v."'"));
			$membermanage = dunserialize(DB::result_first("SELECT sitemanage FROM ".DB::table('wxq123_member')." WHERE uid= ".$muid));
			if (!$membermanage||!in_array($siteid,$membermanage)){
				$membermanage[] = $siteid;
			}
			if (DB::result_first("SELECT count(*) FROM ".DB::table('wxq123_member')." WHERE uid= ".$muid)==0){
				DB::insert('wxq123_member',array('sitemanage'=>serialize($membermanage),'regtime'=>time(),'uid'=>$muid));
			}else{
				DB::update('wxq123_member',array('sitemanage'=>serialize($membermanage)),array('uid'=>$muid));
			}
		}
		foreach ($sitemember['siteuser'] as $v){
			$muid = intval(DB::result_first("SELECT uid FROM ".DB::table('common_member')." WHERE username= '".$v."'"));
			$memberuser = dunserialize(DB::result_first("SELECT siteuser FROM ".DB::table('wxq123_member')." WHERE uid= ".$muid));
			if (!$memberuser||!in_array($siteid,$memberuser)){
				$memberuser[] = $siteid;
			}
			if (DB::result_first("SELECT count(*) FROM ".DB::table('wxq123_member')." WHERE uid= ".$muid)==0){
				DB::insert('wxq123_member',array('siteuser'=>serialize($memberuser),'regtime'=>time(),'uid'=>$muid));
			}else{
				DB::update('wxq123_member',array('siteuser'=>serialize($memberuser)),array('uid'=>$muid));
			}
		}
		cpmsg(lang('plugin/wxq123', 'site_edit_succeed'), 'action=plugins&identifier=wxq123&pmod=siteadmin', 'succeed');
	}
}
?>