<?php

/**
*	һ��ѧ��ƽ̨����
*	�ļ�����yikatong_business.php  ����ʱ�䣺2013-6-21 15:31  ����
*
*/

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$this_page = 'plugin.php?id=yiqixueba:manage&man=yikatong&subman=business';

$business_info = DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_yikatong_business')." WHERE uid=".$uid);

$businessgroupid = intval(getgpc('businessgroupid'));

$type = trim(getgpc('type'));

$joinstep = trim(getgpc('joinstep'));
$joinstep = $joinstep ? $joinstep : 1;

$businessgroup_list = getbgrouplist();

//ԭ����һ���û�ֻ����һ���̼ң��ָ�Ϊ���
$business_list = array();
$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_yikatong_business')." WHERE uid = ".$uid);
while($row = DB::fetch($query)) {
	$business_list[] = $row;
}
$businessnum = count($business_list);

///////////////////////

if(!$business_info && !$type){
	$oldshoplist = array();
	$query = DB::query("SELECT * FROM ".DB::table($base_setting['yiqixueba_yikatong_shop_table'])." WHERE ".$shopfields['uid']."=".$uid);
	$k = 0;
	while($row = DB::fetch($query)) {
		$oldshoplist[$k]['shopname'] = $row[$shopfields['shopname']];
		$oldshoplist[$k]['shopurl'] = str_replace("{shopid}",$row[$shopfields['shopid']],$base_setting['yiqixueba_yikatong_shop_url']);
		$k++;
	}
	$oldshop_num = count($oldshoplist);
	if($oldshop_num ==0 ){
		$outtype = 'msg';
		$msg_text = '������һ������Ҳû�У����벻��һ��ͨ���̼��û�Ŷ��';
	}else{
		$outtype = 'msg';
		$msg_text = '��ã�������һ���� '.$oldshopnum.' �����̣�����<a href="'.$this_page.'&type=join">����</a>��Ϊһ��ͨ�̼ҡ�';
	}
}

if($businessgroupid){
	if(!submitcheck('joinsubmit')) {
	}else{
		$data = array();
		$data['businessname'] = addslashes(trim(getgpc('businessname')));
		if(DB::result_first("SELECT count(*) FROM ".DB::table('yiqixueba_yikatong_business')." WHERE businessname='".$data['businessname']."'")){
		}
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
		$data['jointime'] = time();
		if(!$data['businessname'])
			showmessage('�̼����Ʋ���Ϊ��');
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
		if(DB::result_first("SELECT count(*) FROM ".DB::table('yiqixueba_yikatong_business')." WHERE uid=".$_G['uid'])==0){
			DB::insert('yiqixueba_yikatong_business', $data);
		}
		showmessage(lang('plugin/yiqixueba', 'joinbusiness_rzstep2_succeed'), $this_page);

	}
}

if( $business_info &&!$business_info['status']){
	$outtype = 'msg';
	$msg_text = '�������������Ѿ��ύ�������ĵȴ�';
}

//dump($businessgroup_list);
//dump($base_setting['yiqixueba_yikatong_shop_url']);

	$joinbusiness_text = str_replace("&nbsp;","",$base_setting['yiqixueba_yikatong_joinbusiness']);
	$joinbusiness_text = trim(strip_tags($joinbusiness_text));
	$joinbusiness_text = $joinbusiness_text ? html_entity_decode($base_setting['yiqixueba_yikatong_joinbusiness']) :lang('plugin/yiqixueba','joinbusiness_text');

////�����̼�
if($_GET['type'] == 'joinbusiness'){
	//dump(strip_tags($base_setting['yiqixueba_yikatong_joinbusiness']));
	$joinbusiness_text = str_replace("&nbsp;","",$base_setting['yiqixueba_yikatong_joinbusiness']);
	$joinbusiness_text = trim(strip_tags($joinbusiness_text));
	$joinbusiness_text = $joinbusiness_text ? html_entity_decode($base_setting['yiqixueba_yikatong_joinbusiness']) :lang('plugin/yiqixueba','joinbusiness_text');

}
//dump($businessgroup_list);

//
function getbgrouplist(){
	global $_G;
	$businessgroup_list = array();
	$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_yikatong_businessgroup')." WHERE status = 1 order by businessgroupid asc");
	while($row = DB::fetch($query)) {
		$businessgroup_list[$row['businessgroupid']] = $row;
		$businessgroup_list[$row['businessgroupid']]['businessgroupname'] = $row['businessgroupname'];
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
			$businessgroup_list[$row['businessgroupid']]['businessgroupico'] = $businessgroupicohtml;

			$xiaofei = dunserialize($row['xiaofei']);
			$xiaofei_text = '';
			foreach ( $xflx_array as $xfk => $v ){
				if(in_array($v,$xiaofei)){
					$xiaofei_text .= lang('plugin/yiqixueba','xiaofei_'.$v).'&nbsp;&nbsp;';
				}
			}
			$businessgroup_list[$row['businessgroupid']]['xiaofei'] = $xiaofei_text;
			$businessgroup_list[$row['businessgroupid']]['dianzhang'] = dunserialize($row['dianzhang']);
			$businessgroup_list[$row['businessgroupid']]['caiwu'] = dunserialize($row['caiwu']);
			$businessgroup_list[$row['businessgroupid']]['shouyin'] = dunserialize($row['shouyin']);

		}else{
			$businessgroup_list[$row['businessgroupid']]['businessgroup_text'] = html_entity_decode($row['businessgroupdescription']);
		}
	}
	return $businessgroup_list;
}//end func
?>