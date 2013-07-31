<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$bind_status = DB::result_first("SELECT count(*) FROM ".DB::table('brand_hy')." WHERE hyid='".$_G['uid']."'");
if($bind_status==0){
	if(submitcheck('yikatongsubmit')) {
		$message = '';
		if(DB::result_first("SELECT count(*) FROM ".DB::table('brand_hy')." WHERE hykh='".addslashes(getgpc('cardno'))."'")==1) {
			$message .= '您输入的一卡通已经激活，请确认！';
		}
		if(DB::result_first("SELECT count(*) FROM ".DB::table('brand_cikahaoma')." WHERE ID='".addslashes($_GET['cardno'])."'")==0) {
			$message .= '您输入的一卡通不存在，请确认！';
		}
		if(DB::result_first("SELECT count(*) FROM ".DB::table('brand_cikahaoma')." WHERE ID='".addslashes($_GET['cardno'])."' and cardpass = '".trim($_GET['cardpass'])."'")==0) {
			$message .= '您输入的激活密钥不正确，请确认！';
		}
		loaducenter();
		$ucresult = uc_user_login(addslashes($_G['username']), $_GET['transpass']);
		list($tmp['uid']) = $ucresult;
		if($tmp['uid'] <= 0) {
			showmessage('登陆密码错误！');
		}

		if($message=='') {
			$jflx1 = DB::result_first("SELECT value FROM ".DB::table('brand_settings')." WHERE variable='yikatong_zengsongjifen'");
			$jflx2 = DB::result_first("SELECT value FROM ".DB::table('brand_settings')." WHERE variable='yikatong_jiaoyijifen'");
			$card_info = DB::fetch_first("SELECT * FROM ".DB::table('brand_cikahaoma')." WHERE ID='".addslashes($_GET['cardno'])."'");
			DB::insert('brand_hy', array('hyid'=>$_G['uid'],'hykh'=>addslashes(getgpc('cardno')),'zcsj'=>dgmdate(time(),'dt'),'sjid'=>intval($card_info['itemid'])));
			DB::update('common_member_count',array('extcredits'.$jflx1=>intval($card_info['jine']),'extcredits'.$jflx2=>intval($card_info['jifen'])),array('uid'=>$_G['uid']));
			DB::insert('brand_hycz', array('hyuid'=>$_G['uid'],'blr'=>$_G['username'],'hykh'=>addslashes(getgpc('cardno')),'blsj'=>dgmdate(time(),'dt'),'czje'=>intval($card_info['jine']),'sjuid'=>intval($card_info['itemid'])));
			showmessage('您输入的一卡通绑定成功！','home.php?mod=spacecp&ac=plugin&id=yikatong:yktbind');
		}else{			
			showmessage($message);
		}
	}
}else{
	$bind_card_info = DB::fetch_first("SELECT * FROM ".DB::table('brand_hy')." WHERE hyid='".$_G['uid']."'");
	$cardno_info = $bind_card_info['hykh'];
}
?>