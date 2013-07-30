<?php


if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
require_once DISCUZ_ROOT.'source/plugin/wxq123/source/function/function_wxq123.php';

if(!$_G['uid']) {
	showmessage('jksahkdjhsa', '', array(), array('login' => true));
}
$query = DB::query("SELECT * FROM ".DB::table('wxq123_setting'));
while($row = DB::fetch($query)) {
	$wxq123_setting[$row['skey']] = $row['svalue'];
}

$submod = addslashes(getgpc('submod'));
$submods = array('base','myweb','myshop','mygoods','myweixin','mylog');
$submod = in_array($submod,$submods) ? $submod : $submods[0];

foreach ( $submods as $v) {
	$lang_submods[$v] = lang('plugin/wxq123',$v);
}

if(file_exists(DISCUZ_ROOT.'source/plugin/wxq123/source/member/member_'.$submod.'.php')) {

	require_once DISCUZ_ROOT.'source/plugin/wxq123/source/member/member_'.$submod.'.php';

	if(file_exists(DISCUZ_ROOT.'source/plugin/wxq123/source/member/'.$submod.'_'.$subac.'.php')) {
		require_once DISCUZ_ROOT.'source/plugin/wxq123/source/member/'.$submod.'_'.$subac.'.php';
	}

	$submenu = in_array($submenu,$submenus) ? $submenu : $submenus[0];

	foreach ( $submenus as $v) {
		$lang_submenu[$submod.'_'.$v] = lang('plugin/wxq123',$submod.'_'.$v);
	}


	if(file_exists(DISCUZ_ROOT.'source/plugin/wxq123/template/member/'.$submod.'_'.$subac.'.htm')) {
		include_once template('diy:'.$submod.'_'.$subac,0,'./source/plugin/wxq123/template/member');
	}else{
		include_once template('diy:member_err',0,'./source/plugin/wxq123/template/member');
	}
}else{
	include_once template('diy:member_err',0,'./source/plugin/wxq123/template/member');
}
?>