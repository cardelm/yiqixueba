<?php

/**
*	一起学吧平台程序
*	文件名：base_reg.inc.php  创建时间：2013-6-4 09:36  杨文
*
*/

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
$this_page = 'plugins&identifier=yiqixueba&pmod=admin&submod=reg';

$subac = getgpc('subac');
$subacs = array('reglist','regedit');
$subac = in_array($subac,$subacs) ? $subac : $subacs[0];

$regid = getgpc('regid');
$reg_info = $regid ? DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_reg')." WHERE regid=".$regid) : array();

if(!submitcheck('submit')) {
	//$district_select = '';
	$district_select = api_indata('getserverdist',$indata);
	//dump($district_array);
	showtips(lang('plugin/yiqixueba','reg_edit_tips'));
	showformheader($this_page.'&subac=regedit','enctype');
	showtableheader(lang('plugin/yiqixueba','reg_edit'));
	$regid ? showhiddenfields(array('regid'=>$regid)) : '';
	showsetting(lang('plugin/yiqixueba','realname'),'reg_info[realname]',$reg_info['realname'],'text','',0,lang('plugin/yiqixueba','realname_comment'),'','',true);
	showsetting(lang('plugin/yiqixueba','phone'),'reg_info[phone]',$reg_info['phone'],'text','',0,lang('plugin/yiqixueba','phone_comment'),'','',true);
	showsetting(lang('plugin/yiqixueba','address'),'reg_info[address]',$reg_info['address'],'text','',0,lang('plugin/yiqixueba','address_comment'),'','',true);
	showsetting(lang('plugin/yiqixueba','regdistrict'),'','',$district_select,'',0,lang('plugin/yiqixueba','regdistrict_comment'),'','',true);
	showsetting(lang('plugin/yiqixueba','jianyi'),'jianyi','','textarea','',0,lang('plugin/yiqixueba','jianyi_comment'),'','',true);
	showsubmit('submit');
	showtablefooter();
	showformfooter();
}else{
	if(!htmlspecialchars(trim($_GET['reg_info']['realname']))) {
		cpmsg(lang('plugin/yiqixueba','regname_nonull'));
	}
	$datas = $_GET['reg_info'];
	foreach ( $datas as $k=>$v) {
		$data[$k] = htmlspecialchars(trim($v));
		if(!DB::result_first("describe ".DB::table('yiqixueba_reg')." ".$k)) {
			$sql = "alter table ".DB::table('yiqixueba_reg')." add `".$k."` varchar(255) not Null;";
			runquery($sql);
		}
	}
	if($regid) {
		DB::update('yiqixueba_reg',$data,array('regid'=>$regid));
	}else{
		DB::insert('yiqixueba_reg',$data);
	}
	cpmsg(lang('plugin/yiqixueba', 'reg_edit_succeed'), 'action='.$this_page.'&subac=reglist', 'succeed');
}

?>