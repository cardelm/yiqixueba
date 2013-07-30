<?php

/**
*	一起学吧平台程序
*	文件名：yktdianzhu_yktdianyuan.php  创建时间：2013-6-17 12:43  杨文
*
*/

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$subtype = getgpc('subtype');

$dianyuanid = intval(getgpc('dianyuanid'));
$dianyuan_info = $dianyuanid ? DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_yikatong_shopdianyuan')." WHERE dianyuanid=".$dianyuanid) : array();

//店铺情况
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
$dytypeoption = '<option value="0">请选择</option><option value="1" '.($dianyuan_info['dytype']==1 ? ' selected':'').'>信息员</option><option value="2" '.($dianyuan_info['dytype']==2 ? ' selected':'').'>财务员</option><option value="3" '.($dianyuan_info['dytype']==3 ? ' selected':'').'>店长</option>';

if($subtype == 'adddianyuan'){
	if(!submitcheck('adddianyuansubmit')) {
		//权限处理
		$dianyuan_info['dyquanxian'] = dunserialize($dianyuan_info['dyquanxian']);
		if($dianyuan_info['dytype'] == 1){
			$dyquanxianname = array('view','banli','zhuxiao','buban');
			$dyquanxiantitle = array('查看消费记录','办理会员卡','注销会员卡','补办会员卡');
		}elseif($dianyuan_info['dytype'] == 1){
			$dyquanxianname = array('view','banli','zhuxiao','buban');
			$dyquanxiantitle = array('查看消费记录','办理会员卡','注销会员卡','补办会员卡');
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
			showmessage('请选择店铺');
		}
		if(!$data['dyusername']&&!$dianyuanid){
			showmessage('请填写店员的用户名');
		}
		if(!$data['dyname']){
			showmessage('请填写店员的姓名');
		}
		if(!$data['dytype']){
			showmessage('请选择店员的类型');
		}
		if(!$data['dyquanxian']){
			showmessage('请选择店员的具体权限');
		}
		if($dianyuanid){
			DB::update('yiqixueba_yikatong_shopdianyuan', $data,array('dianyuanid'=>$dianyuanid));
			showmessage('店员编辑成功，请等待审核', 'plugin.php?id=yiqixueba:manage&man=yktdianzhu&subman=yktdianyuan');
		}else{
			DB::insert('yiqixueba_yikatong_shopdianyuan', $data);
			showmessage('店员添加成功，请等待审核', 'plugin.php?id=yiqixueba:manage&man=yktdianzhu&subman=yktdianyuan');
		}
	}
}else{
	$sexarray = array('保密','男','女');
	$typearray = array('请选择','信息员','财务员','店长');
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