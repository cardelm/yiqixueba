<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
if(getgpc('loginsubmit')=='yes'){
	$cardno = addslashes($_POST['cardno']);
	$cardpass = $_POST['cardpass'];
	
	$cika_info = DB::fetch_first("SELECT * FROM ".DB::table('brand_cikahaoma')." WHERE ID='".$cardno."'");
	$huiyuan_info = DB::fetch_first("SELECT * FROM ".DB::table('brand_hy')." WHERE hykh='".$cardno."'");

	if(!$cika_info) {
		showmessage('您输入的一卡通不存在或者未激活，请确认！');
	}else{
		$cardcount = DB::result_first("SELECT count(*) FROM ".DB::table('brand_hy')." WHERE hykh='".$cardno."'");
		
		if($cardcount ==0){
			if($cardpass!=$cika_info['cardpass']){
				showmessage('密码错误');
			}else{
				setcookie('cardno',$cardno);
				showmessage('一卡通登陆成功，请完善自己的资料','member.php?mod=register' , array(),array());
			}
		}else{
			$carduid = DB::result_first("SELECT hyid FROM ".DB::table('brand_hy')." WHERE hykh='".$cardno."'");
			$username = DB::result_first("SELECT username FROM ".DB::table('common_member')." WHERE uid='".$carduid."'");
			require_once libfile('function/member');
			$result = userlogin($username, getgpc('cardpass'), '', '', 'auto', $_G['clientip']);
			$uid = $result['ucresult']['uid'];
			if($result['status']>0) {
				setloginstatus($result['member'], $_GET['cookietime'] ? 2592000 : 0);
				checkfollowfeed();

				C::t('common_member_status')->update($_G['uid'], array('lastip' => $_G['clientip'], 'lastvisit' =>TIMESTAMP, 'lastactivity' => TIMESTAMP));
				
				$location = dreferer();
				$href = str_replace("'", "\'", $location);
				showmessage('location_login_succeed','member.php?mod=register' , array(),array());
			}else{
				showmessage('系统错误！'.$result['status']);
			}
		}
	}
}
if($_G['uid']==0&&getgpc('loginsubmit')!='yes'){
	include_once template('yktlogin' ,0,'./source/plugin/yikatong/template');
	//include_once template('shopadmin_'.$mod ,0,'./source/plugin/'.$plugin_config['plugin_name'].'/template/'.$plugin_config['template_name']);
}else{
	dheader("Location:member.php?mod=register");
}


?>