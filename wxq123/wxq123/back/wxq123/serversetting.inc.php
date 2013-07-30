<?php

/**
 *      [17xue8.cn] (C)2013-2099 杨文.
 *      这不是免费的。
 *
 */

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

$submod = getgpc('submod');
$submods = array('base');
$submod = in_array($submod,$submods) ? $submod : $submods[0];

//总站基本设置
if($submod == 'base') {
	if(!submitcheck('submit')) {
		if($wxq123_setting['weixinimg']!='') {
			$weixinimg = str_replace('{STATICURL}', STATICURL, $wxq123_setting['weixinimg']);
			if(!preg_match("/^".preg_quote(STATICURL, '/')."/i", $weixinimg) && !(($valueparse = parse_url($weixinimg)) && isset($valueparse['host']))) {
				$weixinimg = $_G['setting']['attachurl'].'common/'.$wxq123_setting['weixinimg'].'?'.random(6);
			}
			$weixinimghtml = '<br /><label><input type="checkbox" class="checkbox" name="delete" value="yes" /> '.$lang['del'].'</label><br /><img src="'.$weixinimg.'" width="80" height="80"/>';
		}
		showtips(lang('plugin/wxq123','wxq123_server_setting_tips'));
		showformheader("plugins&identifier=wxq123&pmod=adminsetting",'enctype');
		showtableheader(lang('plugin/wxq123','wxq123_server_setting'));
		showsetting(lang('plugin/wxq123','shibiema'),'','','text','',0,lang('plugin/wxq123','shibiema_comment'),'','',true);
		showsetting(lang('plugin/wxq123','token'),'','',$wxq123_setting['token'],'',0,lang('plugin/wxq123','token_comment'),'','',true);
		showsetting(lang('plugin/wxq123','weixinimg'),'weixinimg',$wxq123_setting['weixinimg'],'filetext','',0,lang('plugin/wxq123','weixinimg_comment').$weixinimghtml,'','',true);
		showtablefooter();
		showtableheader(lang('plugin/wxq123','wxq123_base_setting'));
		showsetting(lang('plugin/wxq123','regsetp1tips'),'setting[regsetp1tips]',$wxq123_setting['regsetp1tips'],'textarea','',0,lang('plugin/wxq123','regsetp1tips_comment'),'','',true);
		showsubmit('submit');
		showtablefooter();
		showformfooter();
	}else{
		$setting_data = $_GET['setting'];
		$weixinimg = addslashes($_POST['weixinimg']);
		if($_FILES['weixinimg']) {
			$upload = new discuz_upload();
			if($upload->init($_FILES['weixinimg'], 'common') && $upload->save()) {
				$weixinimg = $upload->attach['attachment'];
			}
		}
		if($_POST['delete'] && addslashes($_POST['weixinimg'])) {
			$valueparse = parse_url(addslashes($_POST['weixinimg']));
			if(!isset($valueparse['host']) && !strexists(addslashes($_POST['weixinimg']), '{STATICURL}')) {
				@unlink($_G['setting']['attachurl'].'temp/'.addslashes($_POST['weixinimg']));
			}
			$weixinimg = '';
		}
		$setting_data['weixinimg'] = $weixinimg;
		if(is_array($setting_data)) {
			foreach ( $setting_data as $key=>$value) {
				if(DB::result_first("SELECT count(*) FROM ".DB::table('wxq123_setting')." WHERE skey='".$key."'")==0) {
					DB::insert('wxq123_setting',array('skey'=>$key,'svalue'=>$value));
				}else{
					DB::update('wxq123_setting',array('svalue'=>$value),array('skey'=>$key));
				}
			}
		}
		cpmsg(lang('plugin/wxq123', 'wxq123_setting_succeed'), 'action=plugins&identifier=wxq123&pmod=adminsetting', 'succeed');
	}
}

?>