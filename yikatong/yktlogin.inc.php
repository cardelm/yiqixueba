<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
if(getgpc('loginsubmit')=='yes'){
	if($_G['cache']['plugin']['yikatong']['ykt_status']) {
		if(DB::result_first("SELECT count(*) FROM ".DB::table('yikatong_card')." WHERE cardno='".getgpc('cardno')."' and status = 1")==0) {
			showmessage('您输入的一卡通不存在或者未激活，请确认！');
		}else{
			$carduid = DB::result_first("SELECT uid FROM ".DB::table('yikatong_card')." WHERE cardno='".getgpc('cardno')."'");
			$username = DB::result_first("SELECT username FROM ".DB::table('common_member')." WHERE uid='".$carduid."'");
			require_once libfile('function/member');
			$result = userlogin($username, getgpc('cardpass'), '', '', 'auto', $_G['clientip']);
			//$result = userlogin('admin', 'yw19680625', '', '', 'auto', $_G['clientip']);
			$uid = $result['ucresult']['uid'];
			if($result['status']>0) {
			
				setloginstatus($result['member'], $_GET['cookietime'] ? 2592000 : 0);
				checkfollowfeed();

				C::t('common_member_status')->update($_G['uid'], array('lastip' => $_G['clientip'], 'lastvisit' =>TIMESTAMP, 'lastactivity' => TIMESTAMP));
				//$ucsynlogin = uc_user_synlogin($_G['uid']);
				$location = dreferer();
				$href = str_replace("'", "\'", $location);
				showmessage('location_login_succeed',$location , array(),array()
//					array(
//						'showid' => 'succeedmessage',
//						'extrajs' => '<script type="text/javascript">'.
//							'setTimeout("window.location.href =\''.$href.'\';", 3000);'.
//							'$(\'succeedmessage_href\').href = \''.$href.'\';'.
//							'$(\'main_message\').style.display = \'none\';'.
//							'$(\'main_succeed\').style.display = \'\';'.
//							'$(\'succeedlocation\').innerHTML = \''.lang('message', $loginmessage, $param).'\';</script>'.$ucsynlogin,
//						'striptags' => false,
//						'showdialog' => true
//					)
				);
			}else{
				showmessage('系统错误！');
			}

//			var_dump($uid);
//var_dump($result['status']);
//var_dump($result['member']);
		}
//	showmessage('绑定成功');
//var_dump(DB::result_first("SELECT count(*) FROM ".DB::table('yikatong_card')." WHERE cardno='".getgpc('cardno')."' and status = 1"));
	}
	
}
if($_G['uid']==0&&getgpc('loginsubmit')!='yes'){
	include template('yikatong:yktlogin');
}


?>