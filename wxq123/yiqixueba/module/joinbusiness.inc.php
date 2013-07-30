<?php

/**
*	一起学吧平台程序
*	文件名：joinbusiness.inc.php  创建时间：2013-6-19 02:52  杨文
*
*/

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$rzstep = intval(getgpc('rzstep')) ? intval(getgpc('rzstep')) : 1;
$businessgroupid = intval(getgpc('businessgroupid'));
$bgroup_info = $businessgroupid ? DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_yikatong_businessgroup')." WHERE businessgroupid=".$businessgroupid) : array();

$xflx_array = array('jici','shijian','liangka','xianjin','yue','jifen');

dump('sada');

$business_info = DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_yikatong_business')." WHERE uid=".$_G['uid']);
if($business_info){
	if($business_info['status'] == 1){
		showmessage(lang('plugin/yiqixueba','joinbusiness_exists'), 'plugin.php?id=yiqixueba:manage&man=brand&subman=business', array(), array('header' => true));
	}else{
		$businessid = $business_info['businessid'];

		if($business_info['shenfenphoto'] && $business_info['gerenphoto'] && $business_info['contractimage'] ){
			$rzstep = 4;
		}else{
			$rzstep = 3;
			$bgroup_info = DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_yikatong_businessgroup')." WHERE businessgroupid=".$business_info['businessgroupid']);
		}
	}
}else{
	//$rzstep = 2;
}


if($rzstep == 1 ){
	$joinbusiness_text = str_replace("&nbsp;","",$base_setting['yiqixueba_yikatong_joinbusiness']);
	$joinbusiness_text = trim(strip_tags($joinbusiness_text));
	$joinbusiness_text = $joinbusiness_text ? html_entity_decode($base_setting['yiqixueba_yikatong_joinbusiness']) :lang('plugin/yiqixueba','joinbusiness_text');
	//dump(strip_tags($base_setting['yiqixueba_yikatong_joinbusiness']));

	$businessgroup_list = array();
	$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_yikatong_businessgroup')." WHERE status = 1 order by businessgroupid asc");
	$k = 0;
	while($row = DB::fetch($query)) {
		$businessgroup_list[$k] = $row;
		$businessgroup_list[$k]['businessgroupname'] = $row['businessgroupname'];
		$businessgroup_text = strip_tags(html_entity_decode($row['businessgroupdescription']));
		$businessgroup_text = trim(str_replace("&nbsp;","",$businessgroup_text));
		$businessgroup_text = html_entity_decode($businessgroup_text);


		if(!$businessgroup_text){
			if($row['businessgroupico']!='') {
				$businessgroupico = str_replace('{STATICURL}', STATICURL, $row['businessgroupico']);
				if(!preg_match("/^".preg_quote(STATICURL, '/')."/i", $businessgroupico) && !(($valueparse = parse_url($businessgroupico)) && isset($valueparse['host']))) {
					$businessgroupico = $_G['setting']['attachurl'].'common/'.$row['businessgroupico'].'?'.random(6);
				}
				$businessgroupicohtml = '<img src="'.$businessgroupico.'" width="120" height="90"/>';
			}
			$businessgroup_list[$k]['businessgroupico'] = $businessgroupicohtml;

			$xiaofei = dunserialize($row['xiaofei']);
			$xiaofei_text = '';
			foreach ( $xflx_array as $xfk => $v ){
				if(in_array($v,$xiaofei)){
					$xiaofei_text .= lang('plugin/yiqixueba','xiaofei_'.$v).'&nbsp;&nbsp;';
				}
			}
			$businessgroup_list[$k]['xiaofei'] = $xiaofei_text;
			$businessgroup_list[$k]['dianzhang'] = dunserialize($row['dianzhang']);
			$businessgroup_list[$k]['caiwu'] = dunserialize($row['caiwu']);
			$businessgroup_list[$k]['shouyin'] = dunserialize($row['shouyin']);

		}else{
			$businessgroup_list[$k]['businessgroup_text'] = html_entity_decode($row['businessgroupdescription']);
		}
		$k++;
	}
}elseif($rzstep == 2){
	if(!submitcheck('createsubmit')) {
		if($bgroup_info['businessgroupico']!='') {
			$businessgroupico = str_replace('{STATICURL}', STATICURL, $bgroup_info['businessgroupico']);
			if(!preg_match("/^".preg_quote(STATICURL, '/')."/i", $businessgroupico) && !(($valueparse = parse_url($businessgroupico)) && isset($valueparse['host']))) {
				$businessgroupico = $_G['setting']['attachurl'].'common/'.$bgroup_info['businessgroupico'].'?'.random(6);
			}
			$businessgroupicohtml = '<img src="'.$businessgroupico.'" width="120" height="90"/>';
		}
		$bgroup_info['businessgroupico'] = $businessgroupicohtml;

		$xiaofei = dunserialize($bgroup_info['xiaofei']);
		$xiaofei_text = '';
		foreach ( $xflx_array as $xfk => $v ){
			if(in_array($v,$xiaofei)){
				$xiaofei_text .= lang('plugin/yiqixueba','xiaofei_'.$v).'&nbsp;&nbsp;';
			}
		}
		$bgroup_info['xiaofei'] = $xiaofei_text;
		$bgroup_info['dianzhang'] = dunserialize($bgroup_info['dianzhang']);
		$bgroup_info['caiwu'] = dunserialize($bgroup_info['caiwu']);
		$bgroup_info['shouyin'] = dunserialize($bgroup_info['shouyin']);
		$cardtype_option = '';
		$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_yikatong_cardcat')." WHERE status = 1 order by cardcatid asc");
		while($row = DB::fetch($query)) {
			$cardtype_option .= '<option value="'.$row['cardcatid'].'">'.$row['cardcatname'].'</option>';
		}
	}else{
		$data = array();
		$data['businessname'] = addslashes(trim(getgpc('businessname')));
		$data['relname'] = addslashes(trim(getgpc('relname')));
		$data['gerenphoto'] = addslashes(trim(getgpc('gerenphoto')));
		$data['sex'] = intval(getgpc('sex'));
		$data['birthday'] = strtotime(trim(getgpc('birthday')));
		$data['phone'] = addslashes(trim(getgpc('phone')));
		$data['address'] = addslashes(trim(getgpc('address')));
		$data['shenfenno'] = addslashes(trim(getgpc('shenfenno')));
		$data['businesssummary'] = addslashes(trim(getgpc('businesssummary')));
		$data['cardtype'] = intval(getgpc('cardtype'));
		$data['cardnum'] = intval(getgpc('cardnum'));
		$data['businessgroupid'] = $businessgroupid;
		$data['uid'] = $_G['uid'];
		$data['status'] = 0;
		if(!$data['businessname'])
			showmessage('商家名称不能为空');
		if(!$data['relname'])
			showmessage('联系人不能为空');
		if(!$data['birthday'])
			showmessage('出生年月不能为空');
		if(!$data['sex'])
			showmessage('性别不能为保密');
		if(!$data['phone'])
			showmessage('电话不能为空');
		if(!$data['address'])
			showmessage('地址不能为空');

		if(!$data['shenfenno'] || strlen($data['shenfenno'])!=18)
			showmessage('身份证号码不能为空或位数不对');

		$gerenphoto = addslashes($_POST['gerenphoto']);
		if($_FILES['gerenphoto']) {
			$upload = new discuz_upload();
			if($upload->init($_FILES['gerenphoto'], 'common') && $upload->save()) {
				$gerenphoto = $upload->attach['attachment'];
			}
		}
		$data['shenfenphoto'] = $gerenphoto;
		$shenfenphoto = addslashes($_POST['shenfenphoto']);
		if($_FILES['shenfenphoto']) {
			$upload = new discuz_upload();
			if($upload->init($_FILES['shenfenphoto'], 'common') && $upload->save()) {
				$shenfenphoto = $upload->attach['attachment'];
			}
		}
		$data['shenfenphoto'] = $shenfenphoto;
		if(DB::result_first("SELECT count(*) FROM ".DB::table('yiqixueba_yikatong_business')." WHERE uid=".$_G['uid'])==0){
			DB::insert('yiqixueba_yikatong_business', $data);
		}
		showmessage(lang('plugin/yiqixueba', 'joinbusiness_rzstep2_succeed'), 'plugin.php?id=yiqixueba&submod=joinbusiness');

	}
}elseif($rzstep == 3){
	if(!submitcheck('createsubmit')) {
		if($bgroup_info['businessgroupico']!='') {
			$businessgroupico = str_replace('{STATICURL}', STATICURL, $bgroup_info['businessgroupico']);
			if(!preg_match("/^".preg_quote(STATICURL, '/')."/i", $businessgroupico) && !(($valueparse = parse_url($businessgroupico)) && isset($valueparse['host']))) {
				$businessgroupico = $_G['setting']['attachurl'].'common/'.$bgroup_info['businessgroupico'].'?'.random(6);
			}
			$businessgroupicohtml = '<img src="'.$businessgroupico.'" width="120" height="90"/>';
		}
		$bgroup_info['businessgroupico'] = $businessgroupicohtml;

		$xiaofei = dunserialize($bgroup_info['xiaofei']);
		$xiaofei_text = '';
		foreach ( $xflx_array as $xfk => $v ){
			if(in_array($v,$xiaofei)){
				$xiaofei_text .= lang('plugin/yiqixueba','xiaofei_'.$v).'&nbsp;&nbsp;';
			}
		}
		$bgroup_info['xiaofei'] = $xiaofei_text;
		$bgroup_info['dianzhang'] = dunserialize($bgroup_info['dianzhang']);
		$bgroup_info['caiwu'] = dunserialize($bgroup_info['caiwu']);
		$bgroup_info['shouyin'] = dunserialize($bgroup_info['shouyin']);
		$cardtype_option = '';
		$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_yikatong_cardcat')." WHERE status = 1 order by cardcatid asc");
		while($row = DB::fetch($query)) {
			$cardtype_option .= '<option value="'.$row['cardcatid'].'">'.$row['cardcatname'].'</option>';
		}
	}else{
		$data = array();

		$gerenphoto = addslashes($_POST['gerenphoto']);
		if($_FILES['gerenphoto']) {
			$upload = new discuz_upload();
			if($upload->init($_FILES['gerenphoto'], 'common') && $upload->save()) {
				$gerenphoto = $upload->attach['attachment'];
			}
		}
		$data['gerenphoto'] = $gerenphoto;
		$shenfenphoto = addslashes($_POST['shenfenphoto']);
		if($_FILES['shenfenphoto']) {
			$upload = new discuz_upload();
			if($upload->init($_FILES['shenfenphoto'], 'common') && $upload->save()) {
				$shenfenphoto = $upload->attach['attachment'];
			}
		}
		$data['shenfenphoto'] = $shenfenphoto;
		$contractimage = addslashes($_POST['contractimage']);
		if($_FILES['contractimage']) {
			$upload = new discuz_upload();
			if($upload->init($_FILES['contractimage'], 'common') && $upload->save()) {
				$contractimage = $upload->attach['attachment'];
			}
		}
		$data['contractimage'] = $contractimage;
		if(DB::result_first("SELECT count(*) FROM ".DB::table('yiqixueba_yikatong_business')." WHERE uid=".$_G['uid'])==1){
			DB::update('yiqixueba_yikatong_business', $data,array('businessid'=>$businessid));
		}
		showmessage(lang('plugin/yiqixueba', 'joinbusiness_rzstep3_succeed'), 'plugin.php?id=yiqixueba&submod=joinbusiness');

	}
}elseif($rzstep == 4){
}
include template('yiqixueba:'.$template_file);
?>