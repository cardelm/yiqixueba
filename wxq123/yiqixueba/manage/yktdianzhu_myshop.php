<?php

/**
*	һ��ѧ��ƽ̨����
*	�ļ�����yktdianzhu_myshop.php  ����ʱ�䣺2013-6-17 10:14  ����
*
*/

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

//�ж��û��Ƿ���һ��ͨ�̼�
$yktdianzhu = DB::result_first("SELECT count(*) FROM ".DB::table('yiqixueba_yikatong_business')." WHERE uid=".$_G['uid']);

$shopid = intval(getgpc('shopid'));

$fields = dunserialize($base_setting['yiqixueba_yikatong_fields']);

//�õ��̼��������
$shopgroups = array();
$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_yikatong_shoptype')." WHERE status = 1 order by shoptypeid asc");
while($row = DB::fetch($query)) {
	$shopgroups[ $row['shoptypeid']] = $row['shoptypename'];
}
//dump($shopgroups);
$myshoplist = array();
$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_yikatong_shop')." WHERE uid = ".$_G['uid']." order by shopid asc");
$k = 0;
while($row = DB::fetch($query)) {
	$myshoplist[$k]['shopid'] = $row['shopid'];
	$myshoplist[$k]['shopname'] = DB::result_first("SELECT ".$fields['shopname']." FROM ".DB::table($base_setting['yiqixueba_yikatong_shop_table'])." WHERE ".$fields['shopid']."=".$row['oldshopid']);
	$myshoplist[$k]['shopurl'] = str_replace("{shopid}",$row['oldshopid'],$base_setting['yiqixueba_yikatong_shop_url']);
	$myshoplist[$k]['shopgroup'] = $shopgroups[$row['shopgroup']];
	$myshoplist[$k]['status'] = $row['status'] ? '����' :'�����';
	$k++;
	//dump($row);

}
$myshop_num = count($myshoplist);
if($myshop_num==1){
	$shopid = $myshoplist['shopid'];
}

if($shopid){
	$shop_info = DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_brand_shop')." WHERE shopid=".$shopid);
}
?>
