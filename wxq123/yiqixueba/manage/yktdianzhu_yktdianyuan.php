<?php

/**
*	һ��ѧ��ƽ̨����
*	�ļ�����yktdianzhu_yktdianyuan.php  ����ʱ�䣺2013-6-17 12:43  ����
*
*/

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$subtype = getgpc('subtype');

$dianyuanid = intval(getgpc('dianyuanid'));
$dianyuan_info = $dianyuanid ? DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_yikatong_shopdianyuan')." WHERE dianyuanid=".$dianyuanid) : array();

//�������
$fields = dunserialize($base_setting['yiqixueba_yikatong_fields']);

$myshopoption = '';
$myshoplist = $myshop_in = array();
$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_yikatong_shop')." WHERE uid = ".$_G['uid']." order by shopid asc");
$k = 0;
while($row = DB::fetch($query)) {
	$myshoplist[$k]['shopid'] = $row['shopid'];
	$myshoplist[$k]['shopname'] = DB::result_first("SELECT ".$fields['shopname']." FROM ".DB::table($base_setting['yiqixueba_yikatong_shop_table'])." WHERE ".$fields['shopid']."=".$row['oldshopid']);
	$myshopoption .= '<option value="'.$row['shopid'].'" '.($dianyuan_info['shopid'] ==$row['shopid'] ? ' selected' : '').'>'.$myshoplist[$k]['shopname'].'</option>';
	$myshop_in[] =  $row['shopid'];
	$k++;
}
$myshop_num = count($myshoplist);
///////////////////////////

$dytypeoption = '';
$dytypeoption = '<option value="0">��ѡ��</option><option value="1" '.($dianyuan_info['dytype']==1 ? ' selected':'').'>��ϢԱ</option><option value="2" '.($dianyuan_info['dytype']==2 ? ' selected':'').'>����Ա</option><option value="3" '.($dianyuan_info['dytype']==3 ? ' selected':'').'>�곤</option>';

if($subtype == 'adddianyuan'){
	if(!submitcheck('adddianyuansubmit')) {
		//Ȩ�޴���
		$dianyuan_info['dyquanxian'] = dunserialize($dianyuan_info['dyquanxian']);
		if($dianyuan_info['dytype'] == 1){
			$dyquanxianname = array('view','banli','zhuxiao','buban');
			$dyquanxiantitle = array('�鿴���Ѽ�¼','�����Ա��','ע����Ա��','�����Ա��');
		}elseif($dianyuan_info['dytype'] == 1){
			$dyquanxianname = array('view','banli','zhuxiao','buban');
			$dyquanxiantitle = array('�鿴���Ѽ�¼','�����Ա��','ע����Ա��','�����Ա��');
		}
		foreach($dyquanxianname as $k=>$v ){
			$dyquanxian .= '<input type="checkbox" name="dyquanxian[]" value="'.$v.'" '.(in_array($v,$dianyuan_info['dyquanxian']) ? ' checked="checked"' :'').'>'.$dyquanxiantitle[$k].'&nbsp;&nbsp;';
		}
		/////////////////////

	}else{
		$data = array();
		$data['shopid'] = intval(getgpc('shopid'));
		$data['dyusername'] = trim(getgpc('dyusername'));
		$dypass = trim(getgpc('dypass'));
		$data['dyname'] = trim(getgpc('dyname'));
		$data['dyphone'] = trim(getgpc('dyphone'));
		$data['dysex'] = intval(getgpc('dysex'));
		$data['dytype'] = trim(getgpc('dytype'));
		$data['dyquanxian'] = serialize(getgpc('dyquanxian'));
		$data['status'] = intval(getgpc('status'));

		if(!$data['shopid']){
			showmessage('��ѡ�����');
		}
		if(!$data['dyusername']&&!$dianyuanid){
			showmessage('����д��Ա���û���');
		}
		if(!$data['dyname']){
			showmessage('����д��Ա������');
		}
		if(!$data['dytype']){
			showmessage('��ѡ���Ա������');
		}
		if(!$data['dyquanxian']){
			showmessage('��ѡ���Ա�ľ���Ȩ��');
		}
		if($dianyuanid){
			DB::update('yiqixueba_yikatong_shopdianyuan', $data,array('dianyuanid'=>$dianyuanid));
			showmessage('��Ա�༭�ɹ�����ȴ����', 'plugin.php?id=yiqixueba:manage&man=yktdianzhu&subman=yktdianyuan');
		}else{
			DB::insert('yiqixueba_yikatong_shopdianyuan', $data);
			showmessage('��Ա��ӳɹ�����ȴ����', 'plugin.php?id=yiqixueba:manage&man=yktdianzhu&subman=yktdianyuan');
		}
	}
}else{
	$sexarray = array('����','��','Ů');
	$typearray = array('��ѡ��','��ϢԱ','����Ա','�곤');
	$dianyuanlist = array();
	$myshop_in_text = implode(",",$myshop_in);
	$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_yikatong_shopdianyuan')." WHERE shopid IN (".$myshop_in_text.") order by dianyuanid desc");
	$k = 0;
	while($row = DB::fetch($query)) {
		$dianyuanlist[$k] = $row;
		$dianyuanlist[$k]['dyshopname'] =DB::result_first("SELECT ".$fields['shopname']." FROM ".DB::table($base_setting['yiqixueba_yikatong_shop_table'])." WHERE ".$fields['shopid']."=".intval(DB::result_first("SELECT oldshopid FROM ".DB::table('yiqixueba_yikatong_shop')." WHERE shopid=".$row['shopid'])));
		$dianyuanlist[$k]['dysex'] =$sexarray[$row['dysex']];
		$dianyuanlist[$k]['dytype'] =$typearray[$row['dytype']];
		$k++;
	}
	$dianyuan_num = count($dianyuanlist);
}
?>