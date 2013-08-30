<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
require_once DISCUZ_ROOT.'source/plugin/yiqixueba/function.func.php';

dump(function_exists(update_github));
$sitekey = DB::result_first("SELECT svalue FROM ".DB::table('yiqixueba_setting')." WHERE skey='sitekey'");
dump($sitekey);
$mod = getgpc('mod');
$submod = getgpc('submod');

//ะ่าชตวยผ
if(!$_G['uid']) {
	showmessage('login_before_enter_home', null, array(), array('showmsg' => true, 'login' => 1));
}
$navtitle = lang('plugin/yiqixueba','member');

$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_mokuai')." WHERE available=1 order by displayorder asc");
$menuk = 0;
while($row = DB::fetch($query)) {
}
?>