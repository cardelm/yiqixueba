<?php
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
	$plugin['ykt_credit'] = DB::result_first("SELECT value FROM ".DB::table('common_pluginvar')." WHERE variable='ykt_credit'");
	$usergriup = DB::result_first("SELECT value FROM ".DB::table('common_pluginvar')." WHERE variable='ykt_group'");

	showtableheader('会员列表');
	showsubtitle(array('会员信息', '年龄','email', '手机号码', '磁卡号', '余额', '归属'));
	$sql = '';
	if(getgpc('sjid')!='') {
		if(DB::result_first("SELECT count(*) FROM ".DB::table('yikatong_card')." WHERE shangjiaidid='".getgpc('sjid')."'")==1) {
			$sql = ' and shangjiaid='.getgpc('sjid');
		}
	}
	$perpage = 20;
	$start = ($page - 1) * $perpage;
	$sitecount = DB::result_first("SELECT count(*) FROM ".DB::table('common_member')." WHERE groupid='".$usergriup."'");
	$multi = multi($sitecount, $perpage, $page, ADMINSCRIPT."?action=plugins&identifier=yikatong&pmod=yktmember");
	$query = DB::query("SELECT * FROM ".DB::table('common_member')." WHERE groupid='".$usergriup."' order by uid asc limit ".$start.",".$perpage." ");
	while($row = DB::fetch($query)) {
		$info = DB::fetch_first("SELECT * FROM ".DB::table('yikatong_card')." WHERE uid='".$row['uid']."'");
		$memberinfo = DB::fetch_first("SELECT * FROM ".DB::table('common_member_profile')." WHERE uid='".$row['uid']."'");
		if(!$info){
			//DB::insert('yikatong_card', array('uid'=>$row['uid']));
		}
		$nowdate = getdate();
		$age = $memberinfo['birthyear']!=0?(intval($nowdate['year'])-intval($memberinfo['birthyear'])):'-';
		$yue =  DB::result_first("SELECT extcredits".$plugin['ykt_credit']." FROM ".DB::table('common_member_count')." WHERE uid='".$row['uid']."'");
		showtablerow('',array('style="width:80px;"','style="width:30px;"','style="width:200px;"','style="width:120px;"','style="width:120px;"','style="width:50px;"','style="width:30px;"'),array($row['username'],$age,$row['email'],$memberinfo['mobile'],$info['cardno'],$yue,DB::result_first("SELECT username FROM ".DB::table('common_member')." WHERE uid='".$info['shangjiaid']."'")));
	}
	//showsubmit('yktsjsubmit', 'submit', '', '', $multi);
	echo '<tr><td>'.$multi.'</td></tr>';
	showtablefooter();

	
?>