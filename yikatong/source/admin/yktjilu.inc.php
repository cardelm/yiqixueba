<?php
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
if(!submitcheck('submit')) {
	$xiaofeileixin_array = array('1'=>'�ֽ�����','2'=>'�������','3'=>'��������','5'=>'��������');
	$search_xflx = '<select name="xflx"><option value="0">��ѡ��</option>';
	foreach ( $xiaofeileixin_array as $xk=>$xv){
		$search_xflx .= '<option value="'.$xk.'" '.($_POST['xflx']==$xk?' selected':'').'>'.$xv.'</option>';
	}
	$search_xflx .= '</select>';
	$starttime = $_POST['starttime'] ? $_POST['starttime'] : dgmdate(time(), 'd');
	$endtime = $_POST['$endtime'] ? $_POST['$endtime'] : dgmdate(time(), 'd');
	showtips('<li>��¼��ѯ</li>');
	showformheader('plugins&identifier=yikatong&pmod=admin&baction=yktjilu&bmenu=yikatong');
	echo '<script type="text/javascript" src="static/js/calendar.js"></script>';
	echo '�����ţ�<input type="text" name="ddh" value="'.$_GET['ddh'].'" class="txt" />&nbsp;&nbsp;�����̼ң�<input type="text" name="sssj"  value="'.$_GET['sssj'].'" class="txt" />&nbsp;&nbsp;�������ͣ�'.$search_xflx;
	showsetting('����ʱ��',array('starttime', 'endtime'), array($starttime, $endtime),'daterange','','');
	echo '&nbsp;&nbsp;<input type="submit" class="btn" value="'.cplang('search').'"  />';
	showtableheader('��¼��ѯ�б�');
	showsubtitle(array('������', '��Ա����', '���׽��',  '��������','�����̼�','����ʱ��','��������','���ײ�Ʒ'));
	$where = '';
	if($_POST['sssj']){
		$where .= "and sssj like '%".trim($_POST['sssj'])."%' ";
	}
	if($_POST['ddh']){
		$where .= "and ddh = '".trim($_POST['ddh'])."' ";
	}
	if($_POST['xflx']){
		$where .= "and xflx = '".trim($_POST['xflx'])."' ";
	}
	if($_POST['starttime'] != $_POST['endtime']){
		$where .= "and jysj BETWEEN  '".$_POST['starttime']." 00:00:00' and '".$_POST['endtime']." 23:59:59' ";
	}
	$where = substr($where,3);
	if(trim($where)!=''){
		$where = " WHERE ".$where;
	}
	$perpage = 10;
	$start = ($page - 1) * $perpage;
	$sitecount = DB::result_first("SELECT count(*) FROM ".DB::table('brand_xfjl').$where);
	$multi = multi($sitecount, $perpage, $page, ADMINSCRIPT."?action=plugins&identifier=yikatong&pmod=admin&baction=yktjilu&bmenu=yikatong");
	$query = DB::query("SELECT * FROM ".DB::table('brand_xfjl').$where." order by jysj desc limit ".$start.",".$perpage." ");
	while($row = DB::fetch($query)) {
		showtablerow('',array('style="width:160px;"','style="width:120px;"','style="width:60px;"','style="width:60px;"','style="width:120px;"','style="width:150px;"','style="width:60px;"',''),
			array(
			$row['ddh'],
			$row['hykh'],
			$row['jg']*$row['js'],
			$row['rangli']*100,
			$row['sssj'],
			$row['jysj'],
			$xiaofeileixin_array[$row['xflx']],
			$row['spmc']
			));
	}
	$where = trim($where)==''? ' where ':($where.' and ');
	$p1 = DB::result_first("SELECT sum(jg*js) FROM ".DB::table('brand_xfjl').$where." xflx=1");
	$p2 = DB::result_first("SELECT sum(jg*js) FROM ".DB::table('brand_xfjl').$where." xflx=2");
	$p3 = DB::result_first("SELECT sum(jg*js) FROM ".DB::table('brand_xfjl').$where." xflx=3");
	$p5 = DB::result_first("SELECT sum(jg*js) FROM ".DB::table('brand_xfjl').$where." xflx=5");
	
	echo '<tr class="hover"><td colspan="15" class="y">�ֽ��ף� '.($p1+$p5).'  ���ף� '.$p2.'  ���ֽ��ף�'.$p3.'</td></tr>';
	showsubmit('submit', 'submit', '','', $multi);
	showtablefooter();
	showformfooter();
}else{

}
?>