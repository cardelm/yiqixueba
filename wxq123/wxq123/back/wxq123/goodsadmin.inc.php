<?php

/**
 *      [17xue8.cn] (C)2013-2099 杨文.
 *      这不是免费的。
 *
 */

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

$mokuaiid = getgpc('mokuaiid');

$subop = getgpc('subop');
$subops = array('goodslist','goodsedit','goodssetting');
$subop = in_array($subop,$subops) ? $subop : $subops[0];

$goodsid = getgpc('goodsid');
$mokuai_select = '<option value=""></option>';
$query = DB::query("SELECT * FROM ".DB::table('wxq123_mokuai')." WHERE status = 1 and urluser = 1 order by displayorder asc");
while($row = DB::fetch($query)) {
	$mokuais[] = $row;
	$mokuai_select .= '<option value="'.$row['mokuaiid'].'">'.$row['mokuaititle'].'</option>';
}

if(empty($mokuaiid)) {
	cpmsg(lang('plugin/wxq123','mikuai_nonexistence'), 'action=plugins&identifier=wxq123&pmod=goodsadmin&submod=list', 'form', array(), '<select name="mokuaiid">'.$mokuai_select.'</select>');
}

if($subop == 'goodslist'){
	$goodsname = trim(getgpc('goodsname'));
	$tpp = intval(getgpc('tpp')) ? intval(getgpc('tpp')) : '20';
	$renling = intval(getgpc('renling'));
	$bhmokuai = trim(getgpc('bhmokuai'));
	$qianfei = intval(getgpc('qianfei'));
	$select[$tpp] = $tpp ? "selected='selected'" : '';
	$tpp_options = "<option value='20' $select[20]>20</option><option value='50' $select[50]>50</option><option value='100' $select[100]>100</option>";
	$renlingoptions = '<option value="0" '.(!$renling?' selected':'').'>'.lang('plugin/wxq123','all').'</option><option value="1" '.($renling ==1?' selected':'').'>'.lang('plugin/wxq123','renling_no').'</option><option value="2" '.($renling ==2?' selected':'').'>'.lang('plugin/wxq123','renling_yes').'</option>';
	$qianfeioptions = '<option value="0" '.(!$qianfei?' selected':'').'>'.lang('plugin/wxq123','all').'</option><option value="1" '.($qianfei ==1?' selected':'').'>'.lang('plugin/wxq123','qianfei_no').'</option><option value="2" '.($qianfei ==2?' selected':'').'>'.lang('plugin/wxq123','qianfei_yes').'</option><option value="3" '.($qianfei ==3?' selected':'').'>'.lang('plugin/wxq123','qianfei_mian').'</option>';
	$baohanmokuais = '<select name="bhmokuai"><option value="" '.(!$bhmokuai?' selected':'').'>'.lang('plugin/wxq123','all').'</option>';
	$get_text = '&tpp='.$tpp.'&goodsname='.$goodsname.'&renling='.$renling.'&qianfei='.$qianfei.'&bhmokuai='.$bhmokuai;
	foreach ( $mokuais as $key=>$mokuai) {
		$baohanmokuais .= '<option value="'.$mokuai['mokuainame'].'" '.($bhmokuai == $mokuai['mokuainame'] ? ' selected':'').'>'.$mokuai['mokuaititle'].'</option>';
	}
	$baohanmokuais .= '</select>';
	showtips(lang('plugin/wxq123','goods_list_tips'));
	showformheader("plugins&identifier=wxq123&pmod=goodsadmin&submod=list".$get_text);
	showtableheader('search');
	showtablerow('', array('width="60"', 'width="160"', 'width="60"'),
		array(
			lang('plugin/wxq123','goodsname'), "<input size=\"15\" name=\"goodsname\" type=\"text\" value=\"$goodsname\" />",
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
	showformheader("plugins&identifier=wxq123&pmod=goodsadmin&submod=list".$get_text);
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
	if($goodsname) {
		if($where1) {
			$where .= $where1." and goodsname like '%".$goodsname."%' or ".$where1." and goodsshortname like '%".$goodsname."%'";
		}else{
			$where .= " goodsname like '%".$goodsname."%' or goodsshortname like '%".$goodsname."%'";
		}
	}else{
		$where .= $where1;
	}
	$where = $where ? (" where ".$where):'';
	$goodscount = DB::result_first("SELECT count(*) FROM ".DB::table('wxq123_goods').$where);
	$multi = multi($goodscount, $perpage, $page, ADMINSCRIPT."?action=plugins&identifier=wxq123&pmod=goodsadmin".$get_text);
	showtableheader(lang('plugin/wxq123','goods_list').'&nbsp;&nbsp;'.lang('plugin/wxq123','goodscount').$goodscount);
	showsubtitle(array('',lang('plugin/wxq123','goodsshortname'),lang('plugin/wxq123','shibiecode'),lang('plugin/wxq123','goodsmember'), lang('plugin/wxq123','validity'),lang('plugin/wxq123','mokuais'),lang('plugin/wxq123','stauts'),'' ));
	$query = DB::query("SELECT * FROM ".DB::table('wxq123_goods').$where." order by goodsid desc limit ".$start.",".$perpage." ");
	while($row = DB::fetch($query)) {
		$goodsmokuais = '';
		foreach ( $mokuais as $key=>$mokuai) {
			if($row['m_'.$mokuai['mokuainame']]) {
				$goodsmokuais .= '&nbsp;'.$mokuai['mokuaititle'];
			}
		}
		$goodsmember = dunserialize($row['goodsmember']);
		$goodsmember_text ='';
		if(is_array($goodsmember['goodsmanage'])) {
			foreach ( $goodsmember['goodsmanage'] as $v) {
				$goodsmember_text .= $v ?('&nbsp;<a href="'.ADMINSCRIPT.'?action=members&operation=edit&uid='.DB::result_first("SELECT uid FROM ".DB::table('common_member')." WHERE username='".$v."'").'" target="_blank">'.$v.'</a>'):'';
			}
		}
		if(is_array($goodsmember['goodsuser'])) {
			foreach ( $goodsmember['goodsuser'] as $v) {
				$goodsmember_text .= $v ?('&nbsp;<a href="'.ADMINSCRIPT.'?action=members&operation=edit&uid='.DB::result_first("SELECT uid FROM ".DB::table('common_member')." WHERE username='".$v."'").'" target="_blank">'.$v.'</a>'):'';
			}
		}
		showtablerow('', array('class="td25"', 'class="td23"', '', ''), array(
			"<input class=\"checkbox\" type=\"checkbox\" name=\"delete[]\" value=\"$row[goodsid]\">",
			$row['goodsurl'] ? '<a href="'.$row['goodsurl'].'" target="_blank" title="'.$row['goodsurl'].'">'.$row['goodsshortname'].'</a>':$row['goodsshortname'],
			$row['shibiecode'],
			$goodsmember_text,
			$row['groupexpiry'] ? dgmdate($row['groupexpiry'],'d') : lang('plugin/wxq123','qianfei_mian'),
			$goodsmokuais,
			$row['stauts']==0 ? '<img src="static/image/common/access_disallow.gif" width="16" height="16" />':($row['stauts']==1 ? '<img src="static/image/common/access_allow.gif" width="16" height="16" />':'<img src="static/image/common/fav.gif" width="16" height="16" />'),
			"<a href=\"".ADMINSCRIPT."?action=plugins&identifier=wxq123&pmod=goodsadmin&subop=goodsedit&goodsid=$row[goodsid]\" class=\"act\">".$lang['edit']."</a>",
		));
	}
	echo '<tr><td></td><td colspan="6"><div><a href="'.ADMINSCRIPT.'?action=plugins&identifier=wxq123&pmod=goodsadmin&subop=goodsedit" class="addtr">'.lang('plugin/wxq123','add_goods').'</a></div></td></tr>';
	showsubmit('submit','submit','del','',$multi);
	showtablefooter();
	showformfooter();
}elseif($subop == 'goodsedit'){
	if($goodsid){
		$goods_info = DB::fetch_first("SELECT * FROM ".DB::table('wxq123_goods')." WHERE goodsid='".$goodsid."'");
	}
	if(!submitcheck('submit')) {
		if($goods_info['goodslogo']!='') {
			$goodslogo = str_replace('{STATICURL}', STATICURL, $goods_info['goodslogogoodslogo']);
			if(!preg_match("/^".preg_quote(STATICURL, '/')."/i", $goodslogo) && !(($valueparse = parse_url($goodslogo)) && isset($valueparse['host']))) {
				$goodslogo = $_G['setting']['attachurl'].'common/'.$goods_info['goodslogo'].'?'.random(6);
				list($imgwidth,$imgheight) =  GetImageSize($_G['setting']['attachurl'].'common/'.$goods_info['goodslogo']);
			}
			$goodslogohtml = '<label><input type="checkbox" class="checkbox" name="delete1" value="yes" /> '.$lang['del'].'</label><br /><img src="'.$goodslogo.'" width="'.$imgwidth.'" height="'.$imgheight.'"/>';
		}
		if($goods_info['weixinimage']!='') {
			$weixinimage = str_replace('{STATICURL}', STATICURL, $goods_info['weixinimageweixinimage']);
			if(!preg_match("/^".preg_quote(STATICURL, '/')."/i", $weixinimage) && !(($valueparse = parse_url($weixinimage)) && isset($valueparse['host']))) {
				$weixinimage = $_G['setting']['attachurl'].'common/'.$goods_info['weixinimage'].'?'.random(6);
				list($imgwidth,$imgheight) =  GetImageSize($_G['setting']['attachurl'].'common/'.$goods_info['weixinimage']);
			}
			$weixinimagehtml = '<label><input type="checkbox" class="checkbox" name="delete2" value="yes" /> '.$lang['del'].'</label><br /><img src="'.$weixinimage.'" width="'.$imgwidth.'" height="'.$imgheight.'"/>';
		}
		$query = DB::query("SELECT * FROM ".DB::table('wxq123_mokuai')." WHERE status = 1 and urluser = 1 order by displayorder asc");
		while($row = DB::fetch($query)) {
			$mokuai_checkbox .="<label><input name=\"m_".$row['mokuainame']."\" type=\"checkbox\" class=\"checkbox\" value=\"1\" ".($goods_info['m_'.$row['mokuainame']] ? ' checked="checked"' : '')."/> ".$row['mokuaititle']."</label><br />";
		}
		$mokuai_select .= '</select>';
		$baidus = dunserialize($goods_info['goodsbaidu']);
		$goodsmember = dunserialize($goods_info['goodsmember']);
		showtips($goodsid ? lang('plugin/wxq123','goods_edit_tips') : lang('plugin/wxq123','goods_add_tips'));
		showformheader("plugins&identifier=wxq123&pmod=goodsadmin&subop=goodsedit",'enctype');
		showtableheader($goodsid ? lang('plugin/wxq123','goods_edit') : lang('plugin/wxq123','goods_add'));
		showhiddenfields(array('goodsid'=>$goodsid));
		showsetting(lang('plugin/wxq123','goodsshortname'),'goodsshortname',$goods_info['goodsshortname'],'text','',0,lang('plugin/wxq123','goodsshortname_comment'),'','',true);
		showsetting(lang('plugin/wxq123','goodsname'),'goodsname',$goods_info['goodsname'],'text','',0,lang('plugin/wxq123','goodsname_comment'),'','',true);
		showsetting(lang('plugin/wxq123','goodsurl'),'goodsurl',$goods_info['goodsurl'],'text','','',lang('plugin/wxq123','goodsurl_comment'));
		showsetting(lang('plugin/wxq123','mokuais'),'','',$mokuai_checkbox);
		showsetting(lang('plugin/wxq123','shibiecode'),'shibiecode',$goods_info['shibiecode'],'text','','','');
		showsetting(lang('plugin/wxq123','goodslogo'),'goodslogo',$goods_info['goodslogo'],'filetext','','',$goodslogohtml);
		showsetting(lang('plugin/wxq123','goodsphone'),'goodsphone',$goods_info['goodsphone'],'text','',0,lang('plugin/wxq123','goodsphone_comment'),'','',true);
		showsetting(lang('plugin/wxq123','goodsaddress'),'goodsaddress',$goods_info['goodsaddress'],'text','',0,lang('plugin/wxq123','goodsaddress_comment'),'','',true);
		showsetting(lang('plugin/wxq123','goodslianxiren'),'goodslianxiren',$goods_info['goodslianxiren'],'text','',0,lang('plugin/wxq123','goodslianxiren_comment'),'','',true);
		echo '<script src="static/js/calendar.js" type="text/javascript"></script>';
		showtablefooter();
		showtableheader();
		showsetting(lang('plugin/wxq123','goodsvalidity'),'groupexpiry',$goodsid&&intval($goods_info['groupexpiry']==0)?'0':($goods_info['groupexpiry'] ? dgmdate($goods_info['groupexpiry'],'d') : (intval(date('Y')+1).'-'.date('m').'-'.date('d'))),'calendar','',0,'','','',true);
		showsetting(lang('plugin/wxq123','goodstoken'),'token',$goods_info['token']?$goods_info['token']:random(6),'text','',0,'','','',true);
		showsetting(lang('plugin/wxq123','goodsweixinimage'),'weixinimage',$goods_info['weixinimage'],'filetext','',0,$weixinimagehtml,'','',true);
		showsetting(lang('plugin/wxq123','goodsweixinhao'),'goodsweixinhao',$goods_info['goodsweixinhao'],'text','',0,'','','',true);
		showsetting(lang('plugin/wxq123','goodsweixinpass'),'goodsweixinpass',$goods_info['goodsweixinpass'],'password','',0,'','','',true);
		showsetting(lang('plugin/wxq123','goodsmanage'),'goodsmanage',implode("\n",$goodsmember['goodsmanage']),'textarea','',0,lang('plugin/wxq123','goodsmanage_comment'),'','',true);
		showsetting(lang('plugin/wxq123','goodsuser'),'goodsuser',implode("\n",$goodsmember['goodsuser']),'textarea','',0,lang('plugin/wxq123','goodsuser_comment'),'','',true);
		showsetting(lang('plugin/wxq123','goodsstauts'),'stauts',$goods_info['stauts'],'radio','',0,'','','',true);
		showsubmit('submit');
		showtablefooter();
		showformfooter();
	}else{
		$goodslogo = addslashes($_POST['goodslogo']);
		if($_FILES['goodslogo']) {
			$upload = new discuz_upload();
			if($upload->init($_FILES['goodslogo'], 'common') && $upload->save()) {
				$goodslogo = $upload->attach['attachment'];
			}
		}
		if($_POST['delete1'] && addslashes($_POST['goodslogo'])) {
			$valueparse = parse_url(addslashes($_POST['goodslogo']));
			if(!isset($valueparse['host']) && !strexists(addslashes($_POST['goodslogo']), '{STATICURL}')) {
				@unlink($_G['setting']['attachurl'].'common/'.addslashes($_POST['goodslogo']));
			}
			$goodslogo = '';
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
		$goodsmember_old = dunserialize($goods_info['goodsmember']);//原管理员
		$goodsmember['goodsmanage'] = htmlspecialchars(trim($_GET['goodsmanage'])) ?explode("\n",htmlspecialchars(trim($_GET['goodsmanage']))) : '';
		$goodsmember['goodsuser'] = htmlspecialchars(trim($_GET['goodsuser'])) ? explode("\n",htmlspecialchars(trim($_GET['goodsuser']))) : '';
		if(is_array($goodsmember['goodsmanage'])) {
			foreach ( $goodsmember['goodsmanage'] as $v) {
				if($v && DB::result_first("SELECT count(*) FROM ".DB::table('common_member')." WHERE username='".$v."'")==0) {
					cpmsg(lang('plugin/wxq123','goodsmanage_err'));
				}
			}
		}
		if(is_array($goodsmember['goodsuser'])) {
			foreach ($v &&  $goodsmember['goodsuser'] as $v) {
				if(DB::result_first("SELECT count(*) FROM ".DB::table('common_member')." WHERE username='".$v."'")==0) {
					cpmsg(lang('plugin/wxq123','goodsuser_err'));
				}
			}
		}
		$data['goodsname'] = htmlspecialchars($_GET['goodsname']);
		$data['goodsshortname'] = htmlspecialchars($_GET['goodsshortname']);
		$data['goodsmember'] = is_array($goodsmember['goodsmanage'])||is_array($goodsmember['goodsuser'])?serialize($goodsmember):'';
		$data['goodslogo'] = $goodslogo;
		$data['goodsurl'] = htmlspecialchars($_GET['goodsurl']);
		$data['shibiecode'] = htmlspecialchars($_GET['shibiecode']);
		$data['goodsphone'] = htmlspecialchars($_GET['goodsphone']);
		$data['goodsaddress'] = htmlspecialchars($_GET['goodsaddress']);
		$data['goodslianxiren'] = htmlspecialchars($_GET['goodslianxiren']);
		$query = DB::query("SELECT * FROM ".DB::table('wxq123_mokuai')." WHERE status = 1 and urluser = 1 order by displayorder asc");
		while($row = DB::fetch($query)) {
			$data['m_'.$row['mokuainame']] = trim(htmlspecialchars($_GET['m_'.$row['mokuainame']]));
		}
		$data['groupexpiry'] = strtotime(trim(htmlspecialchars($_GET['groupexpiry'])));
		$data['stauts'] = intval($_GET['stauts']);
		$data['goodsweixinhao'] = htmlspecialchars($_GET['goodsweixinhao']);
		$data['goodsweixinpass'] = htmlspecialchars($_GET['goodsweixinpass']);
		$data['token'] = htmlspecialchars($_GET['token']);
		$data['weixinimage'] = $weixinimage;
		if(!$data['goodsname']) {
			cpmsg(lang('plugin/wxq123','goodsname_nonull'));
		}
		if(!$data['goodsshortname']) {
			cpmsg(lang('plugin/wxq123','goodsshortname_nonull'));
		}
		if($goodsid){
			DB::update('wxq123_goods', $data,array('goodsid'=>$goodsid));
		}else{
			if (DB::result_first("SELECT count(*) FROM ".DB::table('wxq123_goods')." WHERE goodsname= '".$data['goodsname']."'")==0 ){
				DB::insert('wxq123_goods', $data);
				$goodsid = insert_id();
			}
		}
		//删除wxq123_member表中的数值
		foreach ($goodsmember_old['goodsmanage'] as $v){
			if (!in_array($v,$goodsmember['goodsmanage'])){
				$muid = intval(DB::result_first("SELECT uid FROM ".DB::table('common_member')." WHERE username= '".$v."'"));
				$membermanage = dunserialize(DB::result_first("SELECT goodsmanage FROM ".DB::table('wxq123_member')." WHERE uid= ".$muid));
				foreach ($membermanage as $vu){
					if ($vu!=$goods){
						$membermanage_new[] = $vu;
					}
				}
				if (DB::result_first("SELECT count(*) FROM ".DB::table('wxq123_member')." WHERE uid= ".$muid)==0){
					DB::insert('wxq123_member',array('goodsmanage'=>serialize($membermanage_new),'regtime'=>time(),'uid'=>$muid));
				}else{
					DB::update('wxq123_member',array('goodsmanage'=>serialize($membermanage_new)),array('uid'=>$muid));
				}
			}
		}
		foreach ($goodsmember_old['goodsuser'] as $v){
			if (!in_array($v,$goodsmember['goodsuser'])){
				$muid = intval(DB::result_first("SELECT uid FROM ".DB::table('common_member')." WHERE username= '".$v."'"));
				$memberuser = dunserialize(DB::result_first("SELECT goodsuser FROM ".DB::table('wxq123_member')." WHERE uid= ".$muid));
				foreach ($memberuser as $vu){
					if ($vu!=$goods){
						$memberuser_new[] = $vu;
					}
				}
				if (DB::result_first("SELECT count(*) FROM ".DB::table('wxq123_member')." WHERE uid= ".$muid)==0){
					DB::insert('wxq123_member',array('goodsuser'=>serialize($memberuser_new),'regtime'=>time(),'uid'=>$muid));
				}else{
					DB::update('wxq123_member',array('goodsuser'=>serialize($memberuser_new)),array('uid'=>$muid));
				}
			}
		}
		//增加wxq123_member表中的数值
		foreach ($goodsmember['goodsmanage'] as $v){
			$muid = intval(DB::result_first("SELECT uid FROM ".DB::table('common_member')." WHERE username= '".$v."'"));
			$membermanage = dunserialize(DB::result_first("SELECT goodsmanage FROM ".DB::table('wxq123_member')." WHERE uid= ".$muid));
			if (!$membermanage||!in_array($goodsid,$membermanage)){
				$membermanage[] = $goodsid;
			}
			if (DB::result_first("SELECT count(*) FROM ".DB::table('wxq123_member')." WHERE uid= ".$muid)==0){
				DB::insert('wxq123_member',array('goodsmanage'=>serialize($membermanage),'regtime'=>time(),'uid'=>$muid));
			}else{
				DB::update('wxq123_member',array('goodsmanage'=>serialize($membermanage)),array('uid'=>$muid));
			}
		}
		foreach ($goodsmember['goodsuser'] as $v){
			$muid = intval(DB::result_first("SELECT uid FROM ".DB::table('common_member')." WHERE username= '".$v."'"));
			$memberuser = dunserialize(DB::result_first("SELECT goodsuser FROM ".DB::table('wxq123_member')." WHERE uid= ".$muid));
			if (!$memberuser||!in_array($goodsid,$memberuser)){
				$memberuser[] = $goodsid;
			}
			if (DB::result_first("SELECT count(*) FROM ".DB::table('wxq123_member')." WHERE uid= ".$muid)==0){
				DB::insert('wxq123_member',array('goodsuser'=>serialize($memberuser),'regtime'=>time(),'uid'=>$muid));
			}else{
				DB::update('wxq123_member',array('goodsuser'=>serialize($memberuser)),array('uid'=>$muid));
			}
		}
		cpmsg(lang('plugin/wxq123', 'goods_edit_succeed'), 'action=plugins&identifier=wxq123&pmod=goodsadmin', 'succeed');
	}
}
?>