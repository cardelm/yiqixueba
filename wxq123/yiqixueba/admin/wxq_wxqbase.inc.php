<?php

/**
*	一起学吧平台程序
*	文件名：wxq_wxqbase.inc.php  创建时间：2013-6-4 09:37  杨文
*
*/

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
$this_page = 'plugins&identifier=yiqixueba&pmod=admin&submod=wxqbase';

$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_wxq123_setting'));
while($row = DB::fetch($query)) {
	$wxq123_setting[$row['skey']] = $row['svalue'];
}

if(!submitcheck('submit')) {
	if($wxq123_setting['weixinimg']!='') {
		$weixinimg = str_replace('{STATICURL}', STATICURL, $wxq123_setting['weixinimg']);
		if(!preg_match("/^".preg_quote(STATICURL, '/')."/i", $weixinimg) && !(($valueparse = parse_url($weixinimg)) && isset($valueparse['host']))) {
			$weixinimg = $_G['setting']['attachurl'].'common/'.$wxq123_setting['weixinimg'].'?'.random(6);
		}
		$weixinimghtml = '<br /><label><input type="checkbox" class="checkbox" name="delete" value="yes" /> '.$lang['del'].'</label><br /><img src="'.$weixinimg.'" width="80" height="80"/>';
	}
	showtips(lang('plugin/yiqixueba','wxq123_setting_tips'));
	showformheader($this_page,'enctype');
	showtableheader(lang('plugin/yiqixueba','wxq123_setting'));
	showsetting(lang('plugin/yiqixueba','shibiema'),'','','http://www.wxq123.com/weixin/?id='.$wxq123_setting['shibiema'],'',0,$wxq123_setting['shibiema'].lang('plugin/yiqixueba','shibiema_comment'),'','',true);
	showsetting(lang('plugin/yiqixueba','token'),'','',$wxq123_setting['token'],'',0,lang('plugin/yiqixueba','token_comment'),'','',true);
	showsetting(lang('plugin/yiqixueba','weixinimg'),'weixinimg',$wxq123_setting['weixinimg'],'filetext','',0,lang('plugin/yiqixueba','weixinimg_comment').$weixinimghtml,'','',true);
	showsetting(lang('plugin/yiqixueba','firsttype'),array('firsttype',array(array('text',lang('plugin/yiqixueba','wxtext')),array('music',lang('plugin/yiqixueba','wxmusic')),array('news',lang('plugin/yiqixueba','wxnews')))),$wxq123_setting['weixinimg'],'select','',0,lang('plugin/yiqixueba','firsttype_comment').$weixinimghtml,'','',true);
	showsetting(lang('plugin/yiqixueba','userreg'),'userreg',$wxq123_setting['userreg'],'radio','',0,lang('plugin/yiqixueba','userreg_comment'),'','',true);
	showtablefooter();
	showtableheader(lang('plugin/yiqixueba','wxq123_data_setting'));
	showsetting(lang('plugin/yiqixueba','shop_tablename'),'setting[shop_tablename]',$wxq123_setting['shop_tablename'],'text','',0,lang('plugin/yiqixueba','shop_tablename_comment'),'','',true);
	showsetting(lang('plugin/yiqixueba','shop_shopid'),'setting[shop_shopid]',$wxq123_setting['shop_shopid'],'text','',0,lang('plugin/yiqixueba','shop_shopid_comment'),'','',true);
	showsetting(lang('plugin/yiqixueba','shop_shopname'),'setting[shop_shopname]',$wxq123_setting['shop_shopname'],'text','',0,lang('plugin/yiqixueba','shop_shopname_comment'),'','',true);
	showsetting(lang('plugin/yiqixueba','shop_condition'),'setting[shop_condition]',$wxq123_setting['shop_condition'],'text','',0,lang('plugin/yiqixueba','shop_condition_comment'),'','',true);
	showtablefooter();
	showtableheader(lang('plugin/yiqixueba','wxq123_base_setting'));
	showsetting(lang('plugin/yiqixueba','regsetp1tips'),'setting[regsetp1tips]',$wxq123_setting['regsetp1tips'],'textarea','',0,lang('plugin/yiqixueba','regsetp1tips_comment'),'','',true);
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
	$setting_data['weixinimg'] = $weixinimg;
	if(is_array($setting_data)) {
		foreach ( $setting_data as $key=>$value) {
			if(DB::result_first("SELECT count(*) FROM ".DB::table('yiqixueba_wxq123_setting')." WHERE skey='".$key."'")==0) {
				DB::insert('yiqixueba_wxq123_setting',array('skey'=>$key,'svalue'=>$value));
			}else{
				DB::update('yiqixueba_wxq123_setting',array('svalue'=>$value),array('skey'=>$key));
			}
		}
	}
	cpmsg(lang('plugin/yiqixueba', 'wxq123_setting_succeed'), 'action='.$this_page, 'succeed');
}

?>