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
$subops = array('shoplist','shopedit','shopsetting');
$subop = in_array($subop,$subops) ? $subop : $subops[0];

$shopid = getgpc('shopid');
$query = DB::query("SELECT * FROM ".DB::table('wxq123_mokuai')." WHERE status = 1 and shopuser = 1 order by displayorder asc");
while($row = DB::fetch($query)) {
	$mokuais[] = $row;
}


if($subop == 'shoplist'){
	if(!submitcheck('submit')) {
		$shopname = trim(getgpc('shopname'));
		$tpp = intval(getgpc('tpp')) ? intval(getgpc('tpp')) : '20';
		$renling = intval(getgpc('renling'));
		$bhmokuai = trim(getgpc('bhmokuai'));
		$qianfei = intval(getgpc('qianfei'));
		$select[$tpp] = $tpp ? "selected='selected'" : '';
		$tpp_options = "<option value='20' $select[20]>20</option><option value='50' $select[50]>50</option><option value='100' $select[100]>100</option>";
		$renlingoptions = '<option value="0" '.(!$renling?' selected':'').'>'.lang('plugin/wxq123','all').'</option><option value="1" '.($renling ==1?' selected':'').'>'.lang('plugin/wxq123','renling_no').'</option><option value="2" '.($renling ==2?' selected':'').'>'.lang('plugin/wxq123','renling_yes').'</option>';
		$qianfeioptions = '<option value="0" '.(!$qianfei?' selected':'').'>'.lang('plugin/wxq123','all').'</option><option value="1" '.($qianfei ==1?' selected':'').'>'.lang('plugin/wxq123','qianfei_no').'</option><option value="2" '.($qianfei ==2?' selected':'').'>'.lang('plugin/wxq123','qianfei_yes').'</option><option value="3" '.($qianfei ==3?' selected':'').'>'.lang('plugin/wxq123','qianfei_mian').'</option>';
		$baohanmokuais = '<select name="bhmokuai"><option value="" '.(!$bhmokuai?' selected':'').'>'.lang('plugin/wxq123','all').'</option>';
		$get_text = '&tpp='.$tpp.'&shopname='.$shopname.'&renling='.$renling.'&qianfei='.$qianfei.'&bhmokuai='.$bhmokuai;
		foreach ( $mokuais as $key=>$mokuai) {
			$baohanmokuais .= '<option value="'.$mokuai['mokuainame'].'" '.($bhmokuai == $mokuai['mokuainame'] ? ' selected':'').'>'.$mokuai['mokuaititle'].'</option>';
		}
		$baohanmokuais .= '</select>';
		showtips(lang('plugin/wxq123','shop_list_tips'));
		showformheader("plugins&identifier=wxq123&pmod=shopadmin&submod=list".$get_text);
		showtableheader('search');
		showtablerow('', array('width="60"', 'width="160"', 'width="60"'),
			array(
				lang('plugin/wxq123','shopname'), "<input size=\"15\" name=\"shopname\" type=\"text\" value=\"$shopname\" />",
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
		showformheader("plugins&identifier=wxq123&pmod=shopadmin&submod=list".$get_text);
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
		if($shopname) {
			if($where1) {
				$where .= $where1." and shopname like '%".$shopname."%' or ".$where1." and shopshortname like '%".$shopname."%'";
			}else{
				$where .= " shopname like '%".$shopname."%' or shopshortname like '%".$shopname."%'";
			}
		}else{
			$where .= $where1;
		}
		$where = $where ? (" where ".$where):'';
		$shopcount = DB::result_first("SELECT count(*) FROM ".DB::table('wxq123_shop').$where);
		$multi = multi($shopcount, $perpage, $page, ADMINSCRIPT."?action=plugins&identifier=wxq123&pmod=shopadmin".$get_text);
		showtableheader(lang('plugin/wxq123','shop_list').'&nbsp;&nbsp;'.lang('plugin/wxq123','shopcount').$shopcount);
		showsubtitle(array('',lang('plugin/wxq123','shopshortname'),lang('plugin/wxq123','shopname'),lang('plugin/wxq123','shopmember'), lang('plugin/wxq123','shopvalidity'),lang('plugin/wxq123','shopmokuais'),lang('plugin/wxq123','shopstauts'),'' ));
		$query = DB::query("SELECT * FROM ".DB::table('wxq123_shop').$where." order by shopid desc limit ".$start.",".$perpage." ");
		while($row = DB::fetch($query)) {
			$shopmokuais = '';
			foreach ( $mokuais as $key=>$mokuai) {
				if($row['m_'.$mokuai['mokuainame']]) {
					$shopmokuais .= '&nbsp;'.$mokuai['mokuaititle'];
				}
			}
			$shopmember = dunserialize($row['shopmember']);
			$shopmember_text ='';
			if(is_array($shopmember['shopmanage'])) {
				foreach ( $shopmember['shopmanage'] as $v) {
					$shopmember_text .= $v ?('&nbsp;<a href="'.ADMINSCRIPT.'?action=members&operation=edit&uid='.DB::result_first("SELECT uid FROM ".DB::table('common_member')." WHERE username='".$v."'").'" target="_blank">'.$v.'</a>'):'';
				}
			}
			if(is_array($shopmember['shopdianyuan'])) {
				foreach ( $shopmember['shopdianyuan'] as $v) {
					$shopmember_text .= $v ?('&nbsp;<a href="'.ADMINSCRIPT.'?action=members&operation=edit&uid='.DB::result_first("SELECT uid FROM ".DB::table('common_member')." WHERE username='".$v."'").'" target="_blank">'.$v.'</a>'):'';
				}
			}
			showtablerow('', array('class="td25"', 'class="td23"', '', ''), array(
				"<input class=\"checkbox\" type=\"checkbox\" name=\"delete[]\" value=\"$row[shopid]\">",
				$row['shopurl'] ? '<a href="'.$row['shopurl'].'" target="_blank" title="'.$row['shopurl'].'">'.$row['shopshortname'].'</a>':$row['shopshortname'],
				$row['shopname'],
				$shopmember_text,
				$row['groupexpiry'] ? dgmdate($row['groupexpiry'],'d') : lang('plugin/wxq123','qianfei_mian'),
				$shopmokuais,
				$row['stauts']==0 ? '<img src="static/image/common/access_disallow.gif" width="16" height="16" />':($row['stauts']==1 ? '<img src="static/image/common/access_allow.gif" width="16" height="16" />':'<img src="static/image/common/fav.gif" width="16" height="16" />'),
				"<a href=\"".ADMINSCRIPT."?action=plugins&identifier=wxq123&pmod=shopadmin&subop=shopedit&shopid=$row[shopid]\" class=\"act\">".$lang['edit']."</a>",
			));
		}
		echo '<tr><td></td><td colspan="6"><div><a href="'.ADMINSCRIPT.'?action=plugins&identifier=wxq123&pmod=shopadmin&subop=shopedit" class="addtr">'.lang('plugin/wxq123','add_shop').'</a></div></td></tr>';
		showsubmit('submit','submit','del','',$multi);
		showtablefooter();
		showformfooter();
	}else{
		if($ids = $_GET['delete']) {
			$ids = dintval($ids, is_array($ids) ? true : false);
			if($ids) {
				DB::delete('wxq123_shop', DB::field('shopid', $ids));
			}
		}
		cpmsg(lang('plugin/wxq123', 'shop_edit_succeed'), 'action=plugins&identifier=wxq123&pmod=shopadmin', 'succeed');
	}
}elseif($subop == 'shopedit'){
	if($shopid){
		$shop_info = DB::fetch_first("SELECT * FROM ".DB::table('wxq123_shop')." WHERE shopid='".$shopid."'");
	}
	if(!submitcheck('submit')) {
		if($shop_info['shoplogo']!='') {
			$shoplogo = str_replace('{STATICURL}', STATICURL, $shop_info['shoplogoshoplogo']);
			if(!preg_match("/^".preg_quote(STATICURL, '/')."/i", $shoplogo) && !(($valueparse = parse_url($shoplogo)) && isset($valueparse['host']))) {
				$shoplogo = $_G['setting']['attachurl'].'common/'.$shop_info['shoplogo'].'?'.random(6);
				list($imgwidth,$imgheight) =  GetImageSize($_G['setting']['attachurl'].'common/'.$shop_info['shoplogo']);
			}
			$shoplogohtml = '<label><input type="checkbox" class="checkbox" name="delete1" value="yes" /> '.$lang['del'].'</label><br /><img src="'.$shoplogo.'" width="'.$imgwidth.'" height="'.$imgheight.'"/>';
		}
		if($shop_info['weixinimage']!='') {
			$weixinimage = str_replace('{STATICURL}', STATICURL, $shop_info['weixinimageweixinimage']);
			if(!preg_match("/^".preg_quote(STATICURL, '/')."/i", $weixinimage) && !(($valueparse = parse_url($weixinimage)) && isset($valueparse['host']))) {
				$weixinimage = $_G['setting']['attachurl'].'common/'.$shop_info['weixinimage'].'?'.random(6);
				list($imgwidth,$imgheight) =  GetImageSize($_G['setting']['attachurl'].'common/'.$shop_info['weixinimage']);
			}
			$weixinimagehtml = '<label><input type="checkbox" class="checkbox" name="delete2" value="yes" /> '.$lang['del'].'</label><br /><img src="'.$weixinimage.'" width="'.$imgwidth.'" height="'.$imgheight.'"/>';
		}
		$query = DB::query("SELECT * FROM ".DB::table('wxq123_mokuai')." WHERE status = 1 and shopuser = 1 order by displayorder asc");
		while($row = DB::fetch($query)) {
			$mokuai_checkbox .="<label><input name=\"m_".$row['mokuainame']."\" type=\"checkbox\" class=\"checkbox\" value=\"1\" ".($shop_info['m_'.$row['mokuainame']] ? ' checked="checked"' : '')."/> ".$row['mokuaititle']."</label><br />";
		}
		$mokuai_select .= '</select>';
		$baidus = dunserialize($shop_info['shopbaidu']);
		$shopmember = dunserialize($shop_info['shopmember']);
		showtips($shopid ? lang('plugin/wxq123','shop_edit_tips') : lang('plugin/wxq123','shop_add_tips'));
		showformheader("plugins&identifier=wxq123&pmod=shopadmin&subop=shopedit",'enctype');
		showtableheader($shopid ? lang('plugin/wxq123','shop_edit') : lang('plugin/wxq123','shop_add'));
		showhiddenfields(array('shopid'=>$shopid));
		echo '<tr class="noborder" ><td class="td27" s="1">&nbsp;</td><td >&nbsp;</td></tr>';
		showsetting(lang('plugin/wxq123','shopshortname'),'shopshortname',$shop_info['shopshortname'],'text','',0,lang('plugin/wxq123','shopshortname_comment'),'','',true);
		showsetting(lang('plugin/wxq123','shopname'),'shopname',$shop_info['shopname'],'text','',0,lang('plugin/wxq123','shopname_comment'),'','',true);
		showsetting(lang('plugin/wxq123','shopmokuais'),'','',$mokuai_checkbox);
		showsetting(lang('plugin/wxq123','shoplogo'),'shoplogo',$shop_info['shoplogo'],'filetext','','',$shoplogohtml);
		showsetting(lang('plugin/wxq123','shopphone'),'shopphone',$shop_info['shopphone'],'text','',0,lang('plugin/wxq123','shopphone_comment'),'','',true);
		showsetting(lang('plugin/wxq123','shopaddress'),'shopaddress',$shop_info['shopaddress'],'text','',0,lang('plugin/wxq123','shopaddress_comment'),'','',true);
		showsetting(lang('plugin/wxq123','shoplianxiren'),'shoplianxiren',$shop_info['shoplianxiren'],'text','',0,lang('plugin/wxq123','shoplianxiren_comment'),'','',true);
		echo '<input type="hidden" name="baidu_x" id="baidu_x" value="'.$baidus['x'].'">';
		echo '<input type="hidden" name="baidu_y" id="baidu_y" value="'.$baidus['y'].'">';
		echo '<tr class="noborder" ><td colspan="2" class="td27" s="1">'.lang('plugin/wxq123','shop_baidu').'</td></tr>';
		echo '<tr class="noborder" ><td colspan="2" ><iframe id="baidumapboa" src="plugin.php?id=wxq123:baidumap" width="600" height="400" frameborder="0" ></iframe></td></tr>';
		echo '<script src="static/js/calendar.js" type="text/javascript"></script>';
		showtablefooter();
		showtableheader();
		showsetting(lang('plugin/wxq123','shopvalidity'),'groupexpiry',$shopid&&intval($shop_info['groupexpiry']==0)?'0':($shop_info['groupexpiry'] ? dgmdate($shop_info['groupexpiry'],'d') : (intval(date('Y')+1).'-'.date('m').'-'.date('d'))),'calendar','',0,'','','',true);
		showsetting(lang('plugin/wxq123','shoptoken'),'token',$shop_info['token']?$shop_info['token']:random(6),'text','',0,'','','',true);
		showsetting(lang('plugin/wxq123','shopweixinimage'),'weixinimage',$shop_info['weixinimage'],'filetext','',0,$weixinimagehtml,'','',true);
		showsetting(lang('plugin/wxq123','shopweixinhao'),'shopweixinhao',$shop_info['shopweixinhao'],'text','',0,'','','',true);
		showsetting(lang('plugin/wxq123','shopweixinpass'),'shopweixinpass',$shop_info['shopweixinpass'],'password','',0,'','','',true);
		showsetting(lang('plugin/wxq123','shopmanage'),'shopmanage',implode("\n",$shopmember['shopmanage']),'textarea','',0,lang('plugin/wxq123','shopmanage_comment'),'','',true);
		showsetting(lang('plugin/wxq123','shopdianyuan'),'shopdianyuan',implode("\n",$shopmember['shopdianyuan']),'textarea','',0,lang('plugin/wxq123','shopdianyuan_comment'),'','',true);
		showsetting(lang('plugin/wxq123','shopstauts'),'stauts',$shop_info['stauts'],'radio','',0,'','','',true);
		showsubmit('submit');
		showtablefooter();
		showformfooter();
	}else{
		$shoplogo = addslashes($_POST['shoplogo']);
		if($_FILES['shoplogo']) {
			$upload = new discuz_upload();
			if($upload->init($_FILES['shoplogo'], 'common') && $upload->save()) {
				$shoplogo = $upload->attach['attachment'];
			}
		}
		if($_POST['delete1'] && addslashes($_POST['shoplogo'])) {
			$valueparse = parse_url(addslashes($_POST['shoplogo']));
			if(!isset($valueparse['host']) && !strexists(addslashes($_POST['shoplogo']), '{STATICURL}')) {
				@unlink($_G['setting']['attachurl'].'common/'.addslashes($_POST['shoplogo']));
			}
			$shoplogo = '';
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
		$shopmember_old = dunserialize($shop_info['shopmember']);//原管理员
		$shopmember['shopmanage'] = htmlspecialchars(trim($_GET['shopmanage'])) ?explode("\n",htmlspecialchars(trim($_GET['shopmanage']))) : '';
		$shopmember['shopdianyuan'] = htmlspecialchars(trim($_GET['shopdianyuan'])) ? explode("\n",htmlspecialchars(trim($_GET['shopdianyuan']))) : '';
		if(is_array($shopmember['shopmanage'])) {
			foreach ( $shopmember['shopmanage'] as $v) {
				if($v && DB::result_first("SELECT count(*) FROM ".DB::table('common_member')." WHERE username='".$v."'")==0) {
					cpmsg(lang('plugin/wxq123','shopmanage_err'));
				}
			}
		}
		if(is_array($shopmember['shopdianyuan'])) {
			foreach ($v &&  $shopmember['shopdianyuan'] as $v) {
				if(DB::result_first("SELECT count(*) FROM ".DB::table('common_member')." WHERE username='".$v."'")==0) {
					cpmsg(lang('plugin/wxq123','shopdianyuan_err'));
				}
			}
		}
		$data['shopname'] = htmlspecialchars($_GET['shopname']);
		$data['shopshortname'] = htmlspecialchars($_GET['shopshortname']);
		$data['shopmember'] = is_array($shopmember['shopmanage'])||is_array($shopmember['shopdianyuan'])?serialize($shopmember):'';
		$data['shoplogo'] = $shoplogo;
		$data['shopphone'] = htmlspecialchars($_GET['shopphone']);
		$data['shopaddress'] = htmlspecialchars($_GET['shopaddress']);
		$data['shoplianxiren'] = htmlspecialchars($_GET['shoplianxiren']);
		$data['shopbaidu'] = serialize(array('x'=>$_GET['baidu_x'],'y'=>$_GET['baidu_y']));
		$query = DB::query("SELECT * FROM ".DB::table('wxq123_mokuai')." WHERE status = 1 and shopuser = 1 order by displayorder asc");
		while($row = DB::fetch($query)) {
			$data['m_'.$row['mokuainame']] = trim(htmlspecialchars($_GET['m_'.$row['mokuainame']]));
		}
		$data['groupexpiry'] = strtotime(trim(htmlspecialchars($_GET['groupexpiry'])));
		$data['stauts'] = intval($_GET['stauts']);
		$data['shopweixinhao'] = htmlspecialchars($_GET['shopweixinhao']);
		$data['shopweixinpass'] = htmlspecialchars($_GET['shopweixinpass']);
		$data['token'] = htmlspecialchars($_GET['token']);
		$data['weixinimage'] = $weixinimage;
		if(!$data['shopname']) {
			cpmsg(lang('plugin/wxq123','shopname_nonull'));
		}
		if(!$data['shopshortname']) {
			cpmsg(lang('plugin/wxq123','shopshortname_nonull'));
		}
		if($shopid){
			DB::update('wxq123_shop', $data,array('shopid'=>$shopid));
		}else{
			if (DB::result_first("SELECT count(*) FROM ".DB::table('wxq123_shop')." WHERE shopname= '".$data['shopname']."'")==0 ){
				DB::insert('wxq123_shop', $data);
				$shopid = insert_id();
			}
		}
		//删除wxq123_member表中的数值
		foreach ($shopmember_old['shopmanage'] as $v){
			if (!in_array($v,$shopmember['shopmanage'])){
				$muid = intval(DB::result_first("SELECT uid FROM ".DB::table('common_member')." WHERE username= '".$v."'"));
				$membermanage = dunserialize(DB::result_first("SELECT shopmanage FROM ".DB::table('wxq123_member')." WHERE uid= ".$muid));
				foreach ($membermanage as $vu){
					if ($vu!=$shop){
						$membermanage_new[] = $vu;
					}
				}
				if (DB::result_first("SELECT count(*) FROM ".DB::table('wxq123_member')." WHERE uid= ".$muid)==0){
					DB::insert('wxq123_member',array('shopmanage'=>serialize($memberuser_new),'regtime'=>time(),'uid'=>$muid));
				}else{
					DB::update('wxq123_member',array('shopmanage'=>serialize($memberuser_new)),array('uid'=>$muid));
				}
			}
		}
		foreach ($shopmember_old['shopdianyuan'] as $v){
			if (!in_array($v,$shopmember['shopdianyuan'])){
				$muid = intval(DB::result_first("SELECT uid FROM ".DB::table('common_member')." WHERE username= '".$v."'"));
				$memberuser = dunserialize(DB::result_first("SELECT shopdianyuan FROM ".DB::table('wxq123_member')." WHERE uid= ".$muid));
				foreach ($memberuser as $vu){
					if ($vu!=$shop){
						$memberuser_new[] = $vu;
					}
				}
				if (DB::result_first("SELECT count(*) FROM ".DB::table('wxq123_member')." WHERE uid= ".$muid)==0){
					DB::insert('wxq123_member',array('shopdianyuan'=>serialize($memberuser_new),'regtime'=>time(),'uid'=>$muid));
				}else{
					DB::update('wxq123_member',array('shopdianyuan'=>serialize($memberuser_new)),array('uid'=>$muid));
				}
			}
		}
		//增加wxq123_member表中的数值
		foreach ($shopmember['shopmanage'] as $v){
			$muid = intval(DB::result_first("SELECT uid FROM ".DB::table('common_member')." WHERE username= '".$v."'"));
			$membermanage = dunserialize(DB::result_first("SELECT shopmanage FROM ".DB::table('wxq123_member')." WHERE uid= ".$muid));
			if (!$membermanage||!in_array($shopid,$membermanage)){
				$membermanage[] = $shopid;
			}
			if (DB::result_first("SELECT count(*) FROM ".DB::table('wxq123_member')." WHERE uid= ".$muid)==0){
				DB::insert('wxq123_member',array('shopmanage'=>serialize($membermanage),'regtime'=>time(),'uid'=>$muid));
			}else{
				DB::update('wxq123_member',array('shopmanage'=>serialize($membermanage)),array('uid'=>$muid));
			}
		}
		foreach ($shopmember['shopdianyuan'] as $v){
			$muid = intval(DB::result_first("SELECT uid FROM ".DB::table('common_member')." WHERE username= '".$v."'"));
			$memberuser = dunserialize(DB::result_first("SELECT shopdianyuan FROM ".DB::table('wxq123_member')." WHERE uid= ".$muid));
			if (!$memberuser||!in_array($shopid,$memberuser)){
				$memberuser[] = $shopid;
			}
			if (DB::result_first("SELECT count(*) FROM ".DB::table('wxq123_member')." WHERE uid= ".$muid)==0){
				DB::insert('wxq123_member',array('shopdianyuan'=>serialize($membermanage),'regtime'=>time(),'uid'=>$muid));
			}else{
				DB::update('wxq123_member',array('shopdianyuan'=>serialize($membermanage)),array('uid'=>$muid));
			}
		}
		cpmsg(lang('plugin/wxq123', 'shop_edit_succeed'), 'action=plugins&identifier=wxq123&pmod=shopadmin', 'succeed');
	}

}
?>