<?php
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
if(DB::result_first("SELECT count(*) FROM ".DB::table('common_pluginvar')." WHERE variable like 'ykt_%'")>0){
	DB::delete('common_pluginvar',"variable like 'ykt_%'");
	require_once DISCUZ_ROOT.'source/plugin/yikatong/install.php';
}

	showtips('<li>��¼��ѯ</li>');
	showtableheader('��¼��ѯ�б�');
	showsubtitle(array('״̬', '�����̼�','ʱ��', '��Ա', '���', '��ע'));
	$perpage = 20;
	$start = ($page - 1) * $perpage;
	$sitecount = DB::result_first("SELECT count(*) FROM ".DB::table('yikatong_trans')." WHERE status='0'");
	$multi = multi($sitecount, $perpage, $page, ADMINSCRIPT."?action=plugins&identifier=yikatong&pmod=yktjilu");
	$query = DB::query("SELECT * FROM ".DB::table('yikatong_trans')." WHERE status='0' order by id asc limit ".$start.",".$perpage." ");
	while($row = DB::fetch($query)) {
		showtablerow('',array('style="width:60px;"','style="width:120px;"','style="width:120px;"','style="width:60px;"','style="width:40px;"',''),array($row['transclass'],$row['shangjia'],dgmdate($row['transtime'],'dt'),$row['huiyuan'],$row['jine'],$row['beizhu']));
	}
	//showsubmit('yktsjsubmit', 'submit', '', '', $multi);
	echo '<tr><td>'.$multi.'</td></tr>';
	showtablefooter();



?>