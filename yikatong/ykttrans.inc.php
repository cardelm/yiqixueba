<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$type = getgpc('type');
$nowdate = getdate();

if($type=='login') {
	$transpass = getgpc('transpass');
	$cardno = getgpc('cardno');
	$carduid = DB::result_first("SELECT uid FROM ".DB::table('yikatong_card')." WHERE cardno='".$cardno."' and status = 1");
	if(!$carduid) {
		$errmsg =  '����һ��ͨ�����Ƿ���ȷ';
	}else{
		$cardusername = DB::result_first("SELECT username FROM ".DB::table('common_member')." WHERE uid='".$carduid."'");
		loaducenter();
		$ucresult = uc_user_login(addslashes($cardusername), $transpass);
		if($ucresult[0]<=0) {
			$errmsg =  '�������';
		}else{
			$usercredits = DB::result_first("SELECT extcredits".$_G['cache']['plugin']['yikatong']['ykt_credit']." FROM ".DB::table('common_member_count')." WHERE uid='".$carduid."'");
			$usergroup = DB::result_first("SELECT grouptitle FROM ".DB::table('common_usergroup')." WHERE groupid='".$_G['cache']['plugin']['yikatong']['ykt_group']."'");
			$errmsg =  "��½�ɹ�<br />".$cardusername."<br />".$usergroup."<br />".$usercredits.'<br />'.avatar($carduid,'small');
		}
	}
	echo $errmsg;
	//http://www.17xue8.cn:88/debug/plugin.php?id=yikatong:ykttrans&type=login&transpass=111111&cardno=12345678


}
if($type=='onlogin') {
	$wordpass = getgpc('wordpass');
	$username = getgpc('username');
	loaducenter();
	$ucresult = uc_user_login(addslashes($username), $wordpass);
	if($ucresult[0]<=0) {
		$errmsg =  '�������';
	}else{
		if(DB::result_first("SELECT groupid FROM ".DB::table('common_member')." WHERE uid='".$ucresult[0]."'")==$_G['cache']['plugin']['yikatong']['ykt_sjgroup']) {
			$usercredits = DB::result_first("SELECT extcredits".$_G['cache']['plugin']['yikatong']['ykt_credit']." FROM ".DB::table('common_member_count')." WHERE uid='".$ucresult[0]."'");
			$sjname = DB::result_first("SELECT shangjianame FROM ".DB::table('yikatong_shangjia')." WHERE uid='".$ucresult[0]."'");
			$usergroup = DB::result_first("SELECT grouptitle FROM ".DB::table('common_usergroup')." WHERE groupid='".$_G['cache']['plugin']['yikatong']['ykt_sjgroup']."'");
			$errmsg =  "��½�ɹ�<br />".$sjname."<br />".$username."<br />".$usergroup."<br />".$usercredits.'<br />'.avatar($carduid,'small');
		}else{
			$errmsg = 'Ȩ�޲���'.DB::result_first("SELECT groupid FROM ".DB::table('common_member')." WHERE uid='".$ucresult[0]."'").$_G['cache']['plugin']['yikatong']['ykt_sjgroup'];

		}
	}
	
	echo $errmsg;
	//http://www.17xue8.cn:88/debug/plugin.php?id=yikatong:ykttrans&type=onlogin&username=����&wordpass=wangqi

}
if($type=='transfer') {
	$transpass = getgpc('transpass');
	$cardno = getgpc('cardno');
	$transmun = intval(getgpc('transmun'));
	$touser = getgpc('touser');
	//$touser = iconv("UTF-8","gb2312",getgpc('touser'));
	//var_dump($touser);
	$transmsg = getgpc('transmsg');
	$password = getgpc('password');
	$code = getgpc('code');
	$carduid = DB::result_first("SELECT uid FROM ".DB::table('yikatong_card')." WHERE cardno='".$cardno."' and status = 1");
	$cardusername = DB::result_first("SELECT username FROM ".DB::table('common_member')." WHERE uid='".$carduid."'");
	$usercredits = DB::result_first("SELECT extcredits".$_G['cache']['plugin']['yikatong']['ykt_credit']." FROM ".DB::table('common_member_count')." WHERE uid='".$carduid."'");

	$touid = init($touser,$password);
	//var_dump($touser);
	$shangjia_info = DB::fetch_first("SELECT *  FROM ".DB::table('yikatong_shangjia')." WHERE uid='".$touid."'");
	$shangjiainfo = intval($shangjia_info['zongnum']*100);
	loaducenter();
	$ucresult = uc_user_login(addslashes($cardusername), $transpass);
	$errmsg = '';
	if($ucresult[0]<=0) {
		$errmsg =  '�������򿨺�����';
	}elseif($cardusername==$touser) {
		$errmsg = '�Լ����ܸ��Լ�ת��';
	}elseif($transmun <=0 ){
		$errmsg = 'ת����������Ϊ��ֵ��Ϊ��';
	}elseif(($usercredits-$transmun)<$_G['setting']['transfermincredits']) {
		$errmsg = '�˻�����';
	}elseif(!$touid) {
		$errmsg = 'ת���û�����';
	}else{
		$errmsg = chkyanzheng($touser,1,$code);
	}
	$netamount = floor($transmun * $shangjiainfo/100);
	if($errmsg == '') {
		updatemembercount($carduid, array($_G['cache']['plugin']['yikatong']['ykt_credit'] => -$transmun), 1, 'TFR', $touid);
		updatemembercount($touid, array($_G['cache']['plugin']['yikatong']['ykt_credit'] => $netamount), 1, 'RCV', $carduid);
		$data_trans['uid']=$carduid;
		$data_trans['touid']=$touid;
		$data_trans['transclass']='��Ա����';
		$data_trans['shangjia']=$touser;
		$data_trans['huiyuan']=$cardusername;
		$data_trans['transtime']=$_G['timestamp'];
		$data_trans['jine']=$transmun;
		$data_trans['beizhu']=$transmsg;
		$data_trans['status']=0;
		DB::insert('yikatong_trans', $data_trans);	
		$usercredits = DB::result_first("SELECT extcredits".$_G['cache']['plugin']['yikatong']['ykt_credit']." FROM ".DB::table('common_member_count')." WHERE uid='".$carduid."'");
		$sjcredits = DB::result_first("SELECT extcredits".$_G['cache']['plugin']['yikatong']['ykt_credit']." FROM ".DB::table('common_member_count')." WHERE uid='".$touid."'");
		//���ͻ���
		if(intval($shangjia_info['zengsong'])>0) {
			$old_zengsong = DB::result_first("SELECT extcredits".$_G['cache']['plugin']['yikatong']['ykt_zengsong']." FROM ".DB::table('common_member_count')." WHERE uid='".$carduid."'");
			DB::update('common_member_count', array('extcredits'.$_G['cache']['plugin']['yikatong']['ykt_zengsong']=>(intval($old_zengsong+intval($transmun/intval($shangjia_info['zengsong']))))),array('uid'=>$carduid));
		}
		//���ͻ���
		$yzdata['yanzhengma'] = '';
		$yzdata['yzip'] = '';
		$yzdata['yztime'] = '';
		$yzdata['yzclass'] = '';
		DB::update('yikatong_shangjia', $yzdata,array('uid'=>$shangjia_info['uid']));
		echo "ת�˳ɹ�<br />".$usercredits.'<br />'.$sjcredits.'<br />'.$transmun.'<br />'.$netamount;
	}else{
		echo $errmsg;
	}
}
//	//http://www.17xue8.cn:88/debug/plugin.php?id=yikatong:ykttrans&type=transfer&transpass=wq1314&cardno=88801001&transmun=100&touser=����&transmsg=����&code=3788&password=wangqi
if($type=='reg') {
	$username = getgpc('username');
	$usernamelen = dstrlen($username);
	$password = getgpc('password');
	$password2 = getgpc('password2');
	$birthyear = getgpc('birthyear');
	$birthmonth = getgpc('birthmonth');
	$birthday = getgpc('birthday');
	$relname = getgpc('relname');
	$idcard = getgpc('idcard');
	$email = strtolower(trim(getgpc('email')));;
	$cardno = getgpc('cardno');
	$cardpass = getgpc('cardpass');
	$movephone = getgpc('movephone');
	$num = getgpc('num');
	$sjname = getgpc('sjname');
	$sjpass = getgpc('sjpass');
	$shangjiaid = init($sjname,$sjpass);
	$cardinfo = DB::result_first("SELECT count(*) FROM ".DB::table('yikatong_card')." WHERE cardno='".$cardno."' and status = 0");
	$cardpa = DB::result_first("SELECT count(*) FROM ".DB::table('yikatong_card')." WHERE cardno='".$cardno."' and status = 0 and cardpass='".$cardpass."'");
	$pwlength = DB::result_first("SELECT svalue FROM ".DB::table('common_setting')." WHERE skey='pwlength'");
	$strongpw = DB::result_first("SELECT svalue FROM ".DB::table('common_setting')." WHERE skey='strongpw'");
	$ignorepassword = DB::result_first("SELECT svalue FROM ".DB::table('common_setting')." WHERE skey='ignorepassword'");
	loaducenter();
	$errmsg = '';
	if(!$shangjiaid) {
		$errmsg = '�̼���Ϣ����';
	}elseif($cardinfo==0) {
		$errmsg = '����һ��ͨ���ʺţ�';
	}elseif ($cardpa=='0'){
		$errmsg = '����һ��ͨ�ļ�����Կ��';
	}elseif ($shangjiaid=='0'){
		$errmsg = 'ϵͳ����';
	}elseif($username=='') {
		$errmsg = '�û�������Ϊ�գ�';
	}elseif($relname=='') {
		$errmsg = '����д��ʵ������';
	}elseif($idcard=='') {
		$errmsg = '���֤���';
	}elseif($usernamelen < 3) {
		$errmsg = '�û������ȱ������3λ��';
	}elseif($password!=$password2) {
		$errmsg = '�������벻һ����';
	} elseif($usernamelen > 15) {
		$errmsg = '�û������ȱ���С��15λ��';
	}elseif(uc_get_user(addslashes($username)) && DB::result_first("SELECT count(*) FROM ".DB::table('common_member')." WHERE username='".addslashes($username)."'")!=0) {
		$errmsg = '�û����ظ����뻻һ���û���';
	}elseif($pwlength) {
		if(strlen($password) < $pwlength) {
		$errmsg = '���볤�Ȳ���������'.$pwlength.'λ';
		}
	}elseif($strongpw) {
		$strongpw_str = array();
		if(in_array(1, $strongpw) && !preg_match("/\d+/", $_GET['password'])) {
			$strongpw_str[] = lang('member/template', 'strongpw_1');
		}
		if(in_array(2, $strongpw) && !preg_match("/[a-z]+/", $_GET['password'])) {
			$strongpw_str[] = lang('member/template', 'strongpw_2');
		}
		if(in_array(3, $strongpw) && !preg_match("/[A-Z]+/", $_GET['password'])) {
			$strongpw_str[] = lang('member/template', 'strongpw_3');
		}
		if(in_array(4, $strongpw) && !preg_match("/[^a-zA-z0-9]+/", $_GET['password'])) {
			$strongpw_str[] = lang('member/template', 'strongpw_4');
		}
		if($strongpw_str) {
			$errmsg = (lang('member/template', 'password_weak').implode(',', $strongpw_str));
		}
	}elseif(empty($ignorepassword)) {
		if($_GET['password'] !== $_GET['password2']) {
			$errmsg ='��Ǹ��������������벻һ��';
		}

		if(!$_GET['password'] || $_GET['password'] != addslashes($_GET['password'])) {
			$errmsg ='��Ǹ������ջ�����Ƿ��ַ�';
		}
		$password = $_GET['password'];
	} else {
		$password = md5(random(10));
	}
	$email = strtolower(trim($email));
	if(strlen($email) > 32) {
		$errmsg = 'Email ��ַ��Ч';
	}else{
		$ucresult = uc_user_checkemail($email);

		if($ucresult == -4) {
			$errmsg = 'Email ��ַ��Ч';
		} elseif($ucresult == -5) {
			$errmsg = '��Ǹ��Email ��������ʹ�õ���������';
		} elseif($ucresult == -6) {
			$errmsg = '�� Email ��ַ�ѱ�ע��';
		}
	}

	if($errmsg == '' ) {
		$uid = uc_user_register(addslashes($username), $password, $email, $questionid, $answer, $_G['clientip']);

		if($uid <= 0) {
			if($uid == -1) {
				showmessage('profile_username_illegal');
			} elseif($uid == -2) {
				showmessage('profile_username_protect');
			} elseif($uid == -3) {
				showmessage('profile_username_duplicate');
			} elseif($uid == -4) {
				showmessage('profile_email_illegal');
			} elseif($uid == -5) {
				showmessage('profile_email_domain_illegal');
			} elseif($uid == -6) {
				showmessage('profile_email_duplicate');
			} else {
				showmessage('undefined_action');
			}
		}else{
			$data_member['uid'] = $uid;
			$data_member['username'] = $username;
			$data_member['password'] = $password;
			$data_member['email'] = $email;
			$data_member['groupid'] = $_G['cache']['plugin']['yikatong']['ykt_group'];
			$data_member['regdate'] = $_G['timestamp'];
			$data_member['status'] = 0;
			$data_member['emailstatus'] = 0;
			$data_member['avatarstatus'] = 0;
			$data_member['videophotostatus'] = 0;
			$data_member['adminid'] = 0;
			$data_member['groupexpiry'] = 0;
			$data_member['extgroupids'] = '';
			$data_member['credits'] = 0;
			$data_member['notifysound'] = 0;
			$data_member['timeoffset'] = 9999;
			$data_member['newpm'] = 0;
			$data_member['newprompt'] = 0;
			$data_member['accessmasks'] = 0;
			$data_member['allowadmincp'] = 0;
			$data_member['onlyacceptfriendpm'] = 0;
			$data_member['conisbind'] = 0;
			DB::insert('common_member', $data_member);
			$data_member_profile['uid'] = $uid;
			$data_member_profile['birthyear'] = $birthyear;
			$data_member_profile['birthmonth'] = $birthmonth;
			$data_member_profile['birthday'] = $birthday;
			$data_member_profile['mobile'] = $movephone;
			$data_member_profile['realname'] = $relname;
			$data_member_profile['idcard'] = $idcard;
			DB::insert('common_member_profile', $data_member_profile);	
			$data_member_count['uid'] = $uid;
			$data_member_count["extcredits".$_G['cache']['plugin']['yikatong']['ykt_credit']] = $num;
			DB::insert('common_member_count', $data_member_count);
			$common_member_status['uid'] = $uid;
			$common_member_status['regip'] = $_G['clientip'];
			$common_member_status['lastip'] = $_G['clientip'];
			DB::insert('common_member_status', $common_member_status);
			$common_member_field_home['uid'] = $uid;
			DB::insert('common_member_field_home', $common_member_field_home);
			$common_member_field_forum['uid'] = $uid;
			DB::insert('common_member_field_forum', $common_member_field_forum);
			$data_card['uid']=$uid;
			$data_card['cardno']=$cardno;
			$data_card['cardpass']=$cardpass;
			$data_card['shangjiaid']=$shangjiaid;
			$data_card['status']=1;
			DB::update('yikatong_card ', $data_card,array('cardno'=>$cardno));
			////////////////////////
			$shangjia_info = DB::fetch_first("SELECT * FROM ".DB::table('yikatong_shangjia')." WHERE uid='".$shangjiaid."'");
			$members_arr = $shangjia_info['members']==''?array():dunserialize($shangjia_info['members']);
			$sharemembers_arr = $shangjia_info['sharemembers']==''?array():dunserialize($shangjia_info['sharemembers']);
			array_push($members_arr,$uid);
			$sharemember_id = array();
			$query = DB::query("SELECT * FROM ".DB::table('yikatong_card')." WHERE status ='1' and shangjiaid<>'".$shangjiaid."' order by uid asc");
			while($row = DB::fetch($query)) {
				if(!in_array($row['uid'],$sharemembers_arr)){
					$sharemember_id[] = $row['uid'];
				}

			}
			if(count($sharemember_id)>0){
				array_push($sharemembers_arr,$sharemember_id[0]);
				$jieshao_card_info = DB::fetch_first("SELECT * FROM ".DB::table('yikatong_card')." WHERE uid='".$sharemember_id[0]."'");
				$jieshao_member_info = DB::fetch_first("SELECT * FROM ".DB::table('common_member_profile')." WHERE uid='".$sharemember_id[0]."'");
				$age = $jieshao_member_info['birthyear']!=0?(intval($nowdate['year'])-intval($jieshao_member_info['birthyear'])):'-';
			}
			DB::update('yikatong_shangjia ', array('members'=>serialize($members_arr),'sharemembers'=>serialize($sharemembers_arr)),array('uid'=>$shangjiaid));
			
			/////////////////////////
			echo 'ע��ɹ���<br />���ܻ�Աid��'.(count($sharemember_id)>0?$sharemember_id[0]:0).'<br />����'.DB::result_first("SELECT username FROM ".DB::table('common_member')." WHERE uid='".$sharemember_id[0]."'").'<br />�ֻ�'.$jieshao_member_info['mobile'].'<br />����'.$jieshao_card_info['cardno'].'<br />����'.$age;
		}

	}else{
		echo $errmsg;
	}
//var_dump(lang('member/template', 'password_weak').implode(',', '�������'));

}
//http://www.17xue8.cn:88/debug/plugin.php?id=yikatong:ykttrans&type=reg&username=111111&password=12345678&password2=12345678&birthyear=1990&birthmonth=11&birthday=19&email=admin@123.cn&cardno=test&cardpass=test&movephone=test&num=1000&cardno=80012346&cardpass=tZ1SS9&sjname=xxx&relname=xxx&idcard=1111891238131293&sjpass=wangqi

if($type=='sjtomember'){
	$sjname = getgpc('sjname');
	$password = getgpc('password');
	$transmun = getgpc('transmun');
	$touser = getgpc('touser');
	$code = getgpc('code');
	//$toid = DB::result_first("SELECT uid FROM ".DB::table('common_member')." WHERE username='".addslashes($touser)."'");
	loaducenter();
	$ucresult = uc_user_login(addslashes($sjname), $password);
	$carduid = DB::result_first("SELECT uid FROM ".DB::table('common_member')." WHERE username='".addslashes($touser)."'");
	$sjcredits = DB::result_first("SELECT extcredits".$_G['cache']['plugin']['yikatong']['ykt_credit']." FROM ".DB::table('common_member_count')." WHERE uid='".$ucresult[0]."'");
	if($ucresult[0]<=0) {
		$errmsg =  '��û��Ȩ��';
	}elseif($carduid<=0||$carduid==null||empty($carduid)){
		$errmsg =  '��Ա������';
	}elseif($transmun <=0 ){
		$errmsg = 'ת����������Ϊ��ֵ��Ϊ��';
	}elseif(($sjcredits-$transmun)<$_G['setting']['transfermincredits']) {
		$errmsg = '�˻�����';
	}elseif(chkyanzheng($sjname,3,$code)!='') {
		$errmsg = chkyanzheng($sjname,3,$code);
	}else{
		updatemembercount($ucresult[0], array($_G['cache']['plugin']['yikatong']['ykt_credit'] => -$transmun), 1, 'TFR', $carduid);
		updatemembercount($carduid, array($_G['cache']['plugin']['yikatong']['ykt_credit'] => $transmun), 1, 'RCV', $ucresult[0]);
		$data_trans['uid']=$carduid;
		$data_trans['touid']=$ucresult[0];
		$data_trans['transclass']='�̼ҳ�ֵ';
		$data_trans['shangjia']=$sjname;
		$data_trans['huiyuan']=$touser;
		$data_trans['transtime']=$_G['timestamp'];
		$data_trans['jine']=$transmun;
		$data_trans['beizhu']=$transmsg;
		$data_trans['status']=0;
		DB::insert('yikatong_trans', $data_trans);	
		$usercredits = DB::result_first("SELECT extcredits".$_G['cache']['plugin']['yikatong']['ykt_credit']." FROM ".DB::table('common_member_count')." WHERE uid='".$carduid."'");
		$sjcredits = DB::result_first("SELECT extcredits".$_G['cache']['plugin']['yikatong']['ykt_credit']." FROM ".DB::table('common_member_count')." WHERE uid='".$ucresult[0]."'");
		$yzdata['yanzhengma'] = '';
		$yzdata['yzip'] = '';
		$yzdata['yztime'] = '';
		$yzdata['yzclass'] = '';
		DB::update('yikatong_shangjia', $yzdata,array('uid'=>$ucresult[0]));
		echo "ת�˳ɹ�<br />".$usercredits.'<br />'.$sjcredits.'<br />'.$transmun.'<br />'.$netamount;
	}
	echo $errmsg;
}
//http://www.17xue8.cn:88/debug/plugin.php?id=yikatong:ykttrans&type=sjtomember&sjname=����&password=wangqi&transmun=1000&touser=asdf&code=dsad

if($type=='userinfo'){
	$sjname = getgpc('sjname');
	$password = getgpc('password');
	loaducenter();
	$ucresult = uc_user_login(addslashes($sjname), $password);
	if($ucresult[0]<=0) {
		$errmsg =  '��û��Ȩ�޻��˺ź�����������飡';
	}else{
		$shangjia_info = DB::fetch_first("SELECT * FROM ".DB::table('yikatong_shangjia')." WHERE uid='".$ucresult[0]."'");
		$members_arr = $shangjia_info['members']==''?array():dunserialize($shangjia_info['members']);
		$sharemembers_arr = $shangjia_info['sharemembers']==''?array():dunserialize($shangjia_info['sharemembers']);
		$userinfo_arr = array_merge($members_arr,$sharemembers_arr);
		foreach ($userinfo_arr  as $uids ){
			$user_info = DB::fetch_first("SELECT * FROM ".DB::table('yikatong_card')." WHERE uid='".$uids."'");
			$member_info = DB::fetch_first("SELECT * FROM ".DB::table('common_member_profile')." WHERE uid='".$uids."'");
			echo ''.$user_info['cardno'].'|'.$member_info['realname'].'|'.($member_info['birthyear']!=0?(intval($nowdate['year'])-intval($member_info['birthyear'])):'-').'|'.$member_info['mobile'].'<br />';
			//var_dump($member_info);
		}
			
	}

}
//http://www.17xue8.cn:88/debug/plugin.php?id=yikatong:ykttrans&type=userinfo&sjname=����&password=wangqi
if($type=='chunzeng'){
	$cardno = getgpc('cardno');
	$cardpass = getgpc('cardpass');
	$sjname = getgpc('sjname');
	$password = getgpc('password');
	$transmun = getgpc('transmun');
	$code = getgpc('code');
	$msg = getgpc('msg');

	$carduid = DB::result_first("SELECT uid FROM ".DB::table('yikatong_card')." WHERE cardno='".$cardno."' and status = 1");
	$cardusername = DB::result_first("SELECT username FROM ".DB::table('common_member')." WHERE uid='".$carduid."'");

	$sjid = DB::result_first("SELECT uid FROM ".DB::table('common_member')." WHERE username='".addslashes($sjname)."'");

	loaducenter();
	$ucresult = uc_user_login(addslashes($cardusername), $cardpass);
	$ucresultsj = uc_user_login(addslashes($sjname), $password);
	$errmsg = '';
	if($ucresult[0]<=0) {
		$errmsg =  '���Ż��߻�Ա����';
	}elseif($ucresultsj[0]<=0) {
		$errmsg =  '�����̼�����';
	}elseif(chkyanzheng($sjname,2,$code)!='') {
		$errmsg = chkyanzheng($sjname,2,$code);
	}else{
		$shangjia_info = DB::fetch_first("SELECT * FROM ".DB::table('yikatong_shangjia')." WHERE uid='".$ucresultsj[0]."'");
		$shangjia_jifen = DB::result_first("SELECT extcredits".$_G['cache']['plugin']['yikatong']['ykt_jifen']." FROM ".DB::table('common_member_count')." WHERE uid='".$ucresultsj[0]."'");
		$card_jifen = DB::result_first("SELECT extcredits".$_G['cache']['plugin']['yikatong']['ykt_jifen']." FROM ".DB::table('common_member_count')." WHERE uid='".$ucresult[0]."'");
		if($shangjia_jifen<intval($transmun/intval($shangjia_info['chunjifen']))) {
			$errmsg =  '�����̼ҵĻ����Ѿ����㣡';
		}else{
			DB::update('common_member_count', array('extcredits'.$_G['cache']['plugin']['yikatong']['ykt_jifen']=>(intval($shangjia_jifen-intval($transmun/intval($shangjia_info['chunjifen']))))),array('uid'=>$ucresultsj[0]));//�̼Ҽ���
			DB::update('common_member_count', array('extcredits'.$_G['cache']['plugin']['yikatong']['ykt_jifen']=>(intval($card_jifen+intval($transmun/intval($shangjia_info['chunjifen']))))),array('uid'=>$ucresult[0]));//��Ա����
			$yzdata['yanzhengma'] = '';
			$yzdata['yzip'] = '';
			$yzdata['yztime'] = '';
			$yzdata['yzclass'] = '';
			DB::update('yikatong_shangjia', $yzdata,array('uid'=>$ucresultsj[0]));//д��֤�댡��
			//���ͻ��ּ�¼
			$logdata['memberid'] = $ucresult[0];
			$logdata['shangjiaid'] = $ucresultsj[0];
			$logdata['msg'] = $msg;
			$logdata['logtime'] = $_G['timestamp'];
			echo '�������ͳɹ���';
		}
	}
	if($errmsg!='') {
		echo $errmsg;
	}

}
//http://www.17xue8.cn:88/debug/plugin.php?id=yikatong:ykttrans&type=chunzeng&cardno=80000002&cardpass=111111&sjname=����&password=wangqi&transmun=100&msg=��ע����


if($type=='gethtml'){
	$sjid = init(getgpc('sjname'),getgpc('password'));
	if($sjid) {
		$jsdata = DB::result_first("SELECT jsdate FROM ".DB::table('yikatong_shangjia')." WHERE uid='".$sjid."'");
		if($jsdata== '0' || $jsdata=='') {
			$file = 'http://17xue8.cn/api.php?mod=js&bid=25';
			$charset = 'utf-8';
		}else{
			$file = $_G['siteurl'].'api.php?mod=js&bid='.$jsdata;
			require DISCUZ_ROOT.'config/config_global.php';
			$charset = $_config['output']['charset'];
		}
		if($charset == 'gbk') {
			$file_con = file_get_contents($file);
		}else{
			$file_con =  iconv("UTF-8","GBK",file_get_contents($file));
		}

		$html .= '<link rel="stylesheet" type="text/css" href="'.$_G['siteurl'].substr($_G["cache"]["style_default"]['directory'],2,strlen($_G["cache"]["style_default"]['directory'])).'/common/common.css" />';
		//$html .= '<div class="block move-span dxb_bc">';
		$html .= $file_con;
		//$html .= '</div>';
		$html = str_replace("document.write('","",$html);
		$html = str_replace("\\n","",$html);
		$html = str_replace("');","",$html);
		echo $html;
	}else{
		echo '���¼';
	}
}
//http://www.17xue8.cn:88/debug/plugin.php?id=yikatong:ykttrans&type=gethtml&sjname=����&password=wangqi
//
if($type=='vel'){
	echo "1.03<br />".$_G['cache']['plugin']['yikatong']['ykt_vel'];
}
//http://www.17xue8.cn:88/debug/plugin.php?id=yikatong:ykttrans&type=vel


function chkyanzheng($shangjianame,$yzclass,$code){
	global $_G;
	$errmsg = '';
	$userid = DB::result_first("SELECT uid FROM ".DB::table('common_member')." WHERE username='".addslashes($shangjianame)."'");
	$yanzheng_info = DB::fetch_first("SELECT * FROM ".DB::table('yikatong_shangjia')." WHERE uid='".$userid."' and yzclass = '".$yzclass."'");
	//var_dump($yanzheng_info);
	if(!$yanzheng_info){
		$errmsg =  '�̼���Ϣ����';
	}else{
		if($_G['clientip']!=$yanzheng_info['yzip']){
			$errmsg =  'IP��ַ����';
		}
		if(intval($_G['timestamp'])>(intval($yanzheng_info['yztime'])+300)){
			$errmsg =  '������ʱ��';
		}
		if($code!=$yanzheng_info['yanzhengma']){
			$errmsg =  '��֤��������ݿ�'.$yanzheng_info['yanzhengma'].'����'.$code;
		}
	}
	return 	$errmsg;

}//end func

//
function init($sjname,$sjpass) {
	if(!function_exists('uc_user_login')) {
		loaducenter();
	}
	$ucresult = uc_user_login(addslashes($sjname), $sjpass);
	if($ucresult[0]<=0) {
		return false;
	}elseif( DB::fetch_first("SELECT count(*) FROM ".DB::table('common_member')." WHERE uid='".$ucresult[0]."' and groupid = '".$_G['cache']['plugin']['yikatong']['ykt_sjgroup']."'")==0) {
		return false;
	}else{
		return $ucresult[0];
	}

}//end func


?>