<?php
/**
 *      [Discuz!] (C)2012-2099 YiQiXueBa.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: yktmember.inc.php 24411 2012-09-17 05:09:03Z yangwen $
 */
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
if(!submitcheck('submit')) {
	showtips('<li>��Ա����</li>');
	showformheader('plugins&identifier=yikatong&pmod=admin&baction=yktmember&bmenu=yikatong');
	echo '<div style="height:30px;line-height:30px;">&nbsp;&nbsp;��Ա�ʺţ�<input type="text" name="hyzh" class="txt" value="'.$_POST['hyzh'].'" />&nbsp;&nbsp;�ſ����룺<input type="text" name="ckhm" class="txt" value="'.$_POST['ckhm'].'" />&nbsp;&nbsp;�������̣�<input type="text" name="ssdp" class="txt" value="'.$_POST['ssdp'].'" />&nbsp;&nbsp;<input type="submit" class="btn" name="srchsubmit" value="'.cplang('search').'" onclick="return srchforum()" /></div>';	showtableheader('��Ա�б�');
	showsubtitle(array('��Ա', '����','email', '�ֻ�����', '�ſ���', '���', '����'));
	$hblx = DB::result_first("SELECT value FROM ".DB::table('brand_settings')." WHERE variable='yikatong_jiaoyijifen'");
	$where = '';
	if($_POST['hyzh']){
		$where .= "and zhanghao like '%".trim($_POST['hyzh'])."%' ";
	}
	if($_POST['ckhm']){
		$where .= "and hykh = '".trim($_POST['ckhm'])."' ";
	}
	if($_POST['ssdp']){
		$where .= "and sjmc like '%".trim($_POST['ssdp'])."%' ";
	}
	$where = substr($where,3);
	if(trim($where)!=''){
		$where = " WHERE ".$where;
	}
	$perpage = 20;
	$start = ($page - 1) * $perpage;
	$sitecount = DB::result_first("SELECT count(*) FROM ".DB::table('brand_hy').$where);
	$multi = multi($sitecount, $perpage, $page, ADMINSCRIPT."?action=plugins&identifier=yikatong&pmod=yktmember");
	$query = DB::query("SELECT * FROM ".DB::table('brand_hy').$where." order by zcsj desc limit ".$start.",".$perpage." ");
	
	while($row = DB::fetch($query)) {
		$info = DB::fetch_first("SELECT * FROM ".DB::table('common_member')." WHERE uid='".$row['hyid']."'");
		$memberinfo = DB::fetch_first("SELECT * FROM ".DB::table('common_member_profile')." WHERE uid='".$row['hyid']."'");
		showtablerow('',array('style="width:100px;"','style="width:120px;"','style="width:200px;"','style="width:100px;"','style="width:120px;"','style="width:50px;"',''),
			array(
			$row['zhanghao'],
			$memberinfo['birthyear'].'��'.$memberinfo['birthmonth'].'��'.$memberinfo['birthday'].'��',$info['email'],
			$memberinfo['mobile'],
			$row['hykh'],
			DB::result_first("SELECT extcredits".$hblx." FROM ".DB::table('common_member_count')." WHERE uid=".$row['hyid']),
			$row['sjmc'],
			));
	}
	showsubmit('submit', 'submit', '','', $multi);
	showtablefooter();
	showformfooter();
}else{
}
	
?>