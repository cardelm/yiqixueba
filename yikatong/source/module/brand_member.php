<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$op = $_GET['op'];
$oparray = array('index','xiaofei','chongzhi');

$op = !in_array($op,$oparray)?'index':$op;
if($_G['uid']==0) {
	showmessage('需要登录', '', array(), array('login' => true));
}
if(DB::result_first("SELECT count(*) FROM ".DB::table('brand_hy')." WHERE hyid=".$_G['uid'])==0) {
	showmessage('您还不是一卡通会员','home.php?mod=spacecp&ac=plugin&id=yikatong:yktbind');
}
if($op=='index') {
	$sql = "SELECT";
	$sql .= " T1.hykh AS kahao,";
	$sql .= " T4.extcredits6 AS jine,";
	$sql .= " T3.gender AS xingbei,";
	$sql .= " T2.username AS username,";
	$sql .= " T3.realname AS xingming,";
	$sql .= " T3.mobile AS shouji,";
	$sql .= " T2.email AS email,";
	$sql .= " T3.address AS zhuzhi,";
	$sql .= " T3.idcard AS shenfenzheng,";
	$sql .= " concat(T3.birthyear,'年',T3.birthmonth,'月',T3.birthday,'日') AS shengri";
	$sql .= " FROM ";
	$sql .= DB::table('brand_hy')." AS T1,";
	$sql .= DB::table('common_member')." AS T2,";
	$sql .= DB::table('common_member_profile')." AS T3,";
	$sql .= DB::table('common_member_count')." AS T4";
	$sql .= " WHERE T1.hyid =".$_G['uid'];
	$sql .= " and T2.uid =".$_G['uid'];
	$sql .= " and T3.uid =".$_G['uid'];
	$sql .= " and T4.uid = ".$_G['uid'];
	//$sql .= " and T1.uid = T3.uid";
	$member_info = DB::fetch_first($sql);
	$jinep =$member_info['jine'];
	$member_info['jine'] = "￥".substr($jinep,0,strlen($jinep)-2).'.'.substr($jinep,-2);
	//dump($sql);
}elseif($op=='xiaofei'){

	//var_dump($_POST);
	$goods_sortid = DB::result_first("SELECT value FROM ".DB::table('brand_settings')." WHERE variable='goods_zidingyi'");
	$goods_fid = DB::result_first("SELECT value FROM ".DB::table('brand_settings')." WHERE variable='goods_forum'");
	$shop_sortid = DB::result_first("SELECT value FROM ".DB::table('brand_settings')." WHERE variable='shop_zidingyi'");
	$shop_fid = DB::result_first("SELECT value FROM ".DB::table('brand_settings')." WHERE variable='shop_forum'");

	//var_dump(DB::fetch_first("SELECT * FROM ".DB::table('brand_xfjl')));
	$xflx_array = array('不限','现金消费','余额消费','积分消费','企业消费','快速消费');

	$xiaofeileixin_array = array('1'=>'现金消费','2'=>'余额消费','3'=>'积分消费','5'=>'快速消费');
	$search_xflx = '<select name="xflx"><option value="0">请选择</option>';
	foreach ( $xiaofeileixin_array as $xk=>$xv){
		$search_xflx .= '<option value="'.$xk.'" '.($_POST['xflx']==$xk?' selected':'').'>'.$xv.'</option>';
	}
	$search_xflx .= '</select>';
	$zt_array = array('买单','撤单');

	$xiaofei_info = array();
	
	$where = '';
	if($_POST['starttime'] && $_POST['endtime']){
		$where .= " and jysj BETWEEN  '".$_POST['starttime']." 00:00:00' and '".$_POST['endtime']." 23:59:59' ";
	}
	if($_POST['xflx']){
		$where .= " and xflx = '".trim($_POST['xflx'])."' ";
	}
	if($_POST['sssj']){
		$where .= " and sssj like '%".trim($_POST['sssj'])."%' ";
	}




	$page = $_GET['page']?$_GET['page']:1;
	$perpage = 10;
	$start = ($page - 1) * $perpage;
	$sitecount = DB::result_first("SELECT count(*) FROM ".DB::table('brand_xfjl')." WHERE hyuid=".$_G['uid']." ".$where);
	$multi = multi($sitecount, $perpage, $page, "plugin.php?id=yikatong:brand&mod=member&op=xiaofei");
	$query = DB::query("SELECT * FROM ".DB::table('brand_xfjl')." WHERE hyuid=".$_G['uid']." ".$where." order by jysj desc limit ".$start.",".$perpage." ");
	$xiaofeijilu = array();
	$key = 0;
	while($row = DB::fetch($query)) {
		$xiaofeijilu[$key] = $row;
		if($row['xflx']== '5'){
			$xiaofeijilu[$key]['img'] = 'template/yktfanghd/style/images/ksxf.jpg';
		}else{
			$img_url_info = dunserialize(DB::result_first("SELECT value FROM ".DB::table('forum_typeoptionvar')." WHERE tid=".$row['sptid']." and optionid=".DB::result_first("SELECT optionid FROM ".DB::table('forum_typeoption')." WHERE identifier='ykt_sptp'")));
			$xiaofeijilu[$key]['img'] = $img_url_info['url'];
		}
		$xiaofeijilu[$key]['xflx'] = $xflx_array[$row['xflx']];
		$xiaofeijilu[$key]['zt'] = $zt_array[$row['zt']];
		$xiaofeijilu[$key]['jifen'] = $row['rangli']*100;
		$xiaofeijilu[$key]['jine'] = $row['jg']*$row['js'];
		$key++;
	}
	$xflu_num = count($xiaofeijilu);
	$p1 = 100*(DB::result_first("SELECT sum(rangli) FROM ".DB::table('brand_xfjl')." WHERE hyuid=".$_G['uid']." ".$where." order by jysj desc limit ".$start.",".$perpage." "));
	$p2 = DB::result_first("SELECT sum(jieshen) FROM ".DB::table('brand_xfjl')." WHERE hyuid=".$_G['uid']." ".$where." order by jysj desc limit ".$start.",".$perpage." ");





}elseif($op=='chongzhi'){
	//var_dump(DB::fetch_first("SELECT * FROM ".DB::table('brand_hycz')));

	$chongzhi_info = array();
	$page = $_GET['page']?$_GET['page']:1;
	$perpage = 10;
	$start = ($page - 1) * $perpage;
	//$sitecount = DB::result_first("SELECT count(*) FROM ".DB::table('brand_hycz')." WHERE hyuid=".$_G['uid']);
	$multi = multi($sitecount, $perpage, $page, "plugin.php?id=yikatong:brand&mod=member&op=chongzhi");
	$query = DB::query("SELECT * FROM ".DB::table('brand_hycz')." WHERE hyuid=".$_G['uid']." order by blsj desc limit ".$start.",".$perpage." ");
	$xk = 0;
	while($row = DB::fetch($query)) {
		$chongzhi_info[$xk]['shijian'] = $row['blsj'];
		$chongzhi_info[$xk]['jine'] = $row['czje'];
		$chongzhi_info[$xk]['zhanghao'] = $row['blr'];
		$chongzhi_info[$xk]['kahao'] = $row['hykh'];
		$chongzhi_info[$xk]['shop'] = $row['blmd'];
		//$chongzhi_info[$xk]['shop'] = DB::result_first("SELECT subject FROM ".DB::table('brand_shopitems')." WHERE itemid=".$row['itemid']);
		$xk++;
	}
}

include_once template('diy:member_'.$op,0,'./source/plugin/'.$plugin_config['plugin_name'].'/template/base');
?>