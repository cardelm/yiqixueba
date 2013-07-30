<?php

/**
*	һ��ѧ��ƽ̨����
*	�ļ�����brand_shop.php  ����ʱ�䣺2013-6-23 04:09  ����
*
*/

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$this_page = 'plugin.php?id=yiqixueba:manage&man=brand&subman=shop';

$type = trim(getgpc('type'));


$shopid = intval(getgpc('shopid'));
$shop_info = DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_brand_shop')." WHERE shopid=".$shopid);

$sort_data = array();
$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_brand_shopsort')." order by displayorder asc");
while($row = DB::fetch($query)) {
	$sort_data[$row['shopsortid']] = $row;
}


$shoplists = array();
$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_brand_shop')." WHERE uid=".$uid." AND upshopid = 0 order by shopid desc");
$k = $yesnum = $nonum = $nobusinessnum = $fendiannum = 0;
while($row = DB::fetch($query)) {
	$subshopnum = DB::result_first("SELECT count(*) FROM ".DB::table('yiqixueba_brand_shop')." WHERE upshopid=".$row['shopid']);
	if($row['shoplogo']!='') {
		$shoplogo = str_replace('{STATICURL}', STATICURL, $row['shoplogo']);
		if(!preg_match("/^".preg_quote(STATICURL, '/')."/i", $mokuaiico) && !(($valueparse = parse_url($shoplogo)) && isset($valueparse['host']))) {
			$shoplogo = $_G['setting']['attachurl'].'common/'.$row['shoplogo'].'?'.random(6);
		}
		$shoplogo = '<img src="'.$shoplogo.'" width="80" height="60"/>';
	}
	$shoplogo = $shoplogo ? $shoplogo : '<img src="source/plugin/yiqixueba/template/yiqixueba/default/style/image/noshoplogo.jpg" width="80" height="60"/>';
	$sssort_title_text = $sssort = '';
	$sssort = $sort_data[$row['shopsort']]['upids'] ? $sort_data[$row['shopsort']]['upids'].'-'.$row['shopsort'] : $row['shopsort'];
	$sssort_array = explode("-",$sssort);
	$sssort_title_array = array();
	foreach ($sssort_array as $v){
		if ($v){
			$sssort_title_array[] = $sort_data[$v]['sorttitle'];
		}
	}
	$sssort_title_text = implode(">>",$sssort_title_array);
	$shoplists[$k]['shopid'] = $row['shopid'];
	$shoplists[$k]['shopname'] = $row['shopname'];
	$shoplists[$k]['shopsort'] = $sssort_title_text;
	$shoplists[$k]['shoplogo'] = $shoplogo;
	$shoplists[$k]['upshopid'] = $row['upshopid'];
	$shoplists[$k]['status'] = $row['status'] ? '<span class="xi1">�����</span>' : '�����';
	$row['status'] ? $yesnum++ : $nonum++;
	if($row['upshopid']==0 && DB::result_first("SELECT count(*) FROM ".DB::table('yiqixueba_brand_business')." WHERE shopid=".$row['shopid'])==0){
		$shoplists[$k]['isbusiness'] = 1;
		$nobusinessnum ++;
	}
	$query1 = DB::query("SELECT * FROM ".DB::table('yiqixueba_brand_shop')." WHERE upshopid = ".$row['shopid']." order by shopid desc");
	$kk = 0;
	while($row1 = DB::fetch($query1)) {
		$shoplogo1 = '';
		if($row1['shoplogo']!='') {
			$shoplogo1 = str_replace('{STATICURL}', STATICURL, $row1['shoplogo']);
			if(!preg_match("/^".preg_quote(STATICURL, '/')."/i", $mokuaiico) && !(($valueparse = parse_url($shoplogo1)) && isset($valueparse['host']))) {
				$shoplogo1 = $_G['setting']['attachurl'].'common/'.$row1['shoplogo'].'?'.random(6);
			}
			$shoplogo1 = '<img src="'.$shoplogo1.'" width="80" height="60"/>';
		}
		$shoplogo1 = $shoplogo1 ? $shoplogo1 : '<img src="source/plugin/yiqixueba/template/yiqixueba/default/style/image/noshoplogo.jpg" width="80" height="60"/>';
		$sssort_title_text = $sssort = '';
		$sssort = $sort_data[$row1['shopsort']]['upids'] ? $sort_data[$row1['shopsort']]['upids'].'-'.$row1['shopsort'] : $row1['shopsort'];
		$sssort_array = explode("-",$sssort);
		$sssort_title_array = array();
		foreach ($sssort_array as $v){
			if ($v){
				$sssort_title_array[] = $sort_data[$v]['sorttitle'];
			}
		}
		$sssort_title_text = implode(">>",$sssort_title_array);
		$shoplists[$k]['subshop'][$kk]['shopid'] = $row1['shopid'];
		$shoplists[$k]['subshop'][$kk]['shopname'] = $row1['shopname'];
		$shoplists[$k]['subshop'][$kk]['shopsort'] = $sssort_title_text;
		$shoplists[$k]['subshop'][$kk]['shoplogo'] = $shoplogo1;
		$shoplists[$k]['subshop'][$kk]['upshopid'] = $row1['upshopid'];
		$shoplists[$k]['subshop'][$kk]['status'] = $row1['status'] ? '<span class="xi1">�����</span>' : '�����';
		$row1['status'] ? $yesnum++ : $nonum++;
		//$shoplists[$k]['subshop'][$kk]['isbusiness'] = 0;
		//$nobusinessnum ++;
		$kk++;
	}
	$k++;
}
$shopnum = count($shoplists);
//dump($shoplists);
if($nobusinessnum == 1){
	$type = 'joinbusiness';
	$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_brand_shop')." WHERE upshopid = 0 order by shopid asc");
	while($row = DB::fetch($query)) {
		if(DB::result_first("SELECT count(*) FROM ".DB::table('yiqixueba_brand_business')." WHERE shopid=".$row['shopid'])==0){
			$shop_info = $row;
		}
	}
}

if($type == 'createfendian'){
	$upshop_info = DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_brand_shop')." WHERE shopid=".$shopid);
}

if(!submitcheck('shopsubmit')){
}else{
	$data = array();
	$data = htmlspecialchars(trim(getgpc('')));
	if($shopid) {
		DB::update('yiqixueba_brand_shop',$data,array('shopid'=>$shopid));
	}else{
		DB::insert('yiqixueba_brand_shop',$data);
	}
	showmessage(lang('plugin/yiqixueba', 'shop_edit_succeed'), $this_page);
}
if(submitcheck('join')){
		$data = array();
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
		$data['shopid'] = $shopid;
		$data['status'] = 0;
		$data['jointime'] = time();
		if(!$data['relname'])
			showmessage('��ϵ�˲���Ϊ��');
		if(!$data['birthday'])
			showmessage('�������²���Ϊ��');
		if(!$data['sex'])
			showmessage('�Ա���Ϊ����');
		if(!$data['phone'])
			showmessage('�绰����Ϊ��');
		if(!$data['address'])
			showmessage('��ַ����Ϊ��');

		if(!$data['shenfenno'] || strlen($data['shenfenno'])!=18)
			showmessage('���֤���벻��Ϊ�ջ�λ������');

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
		//dump($data);
		if(DB::result_first("SELECT count(*) FROM ".DB::table('yiqixueba_brand_business')." WHERE shopid=".$shopid)==0){
			DB::insert('yiqixueba_brand_business', $data);
		}
		showmessage(lang('plugin/yiqixueba', 'joinbusiness_rzstep2_succeed'), $this_page);
}
