<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
require_once DISCUZ_ROOT.'source/plugin/yiqixueba/function.func.php';

$sitekey = DB::result_first("SELECT svalue FROM ".DB::table('yiqixueba_setting')." WHERE skey='sitekey'");
$submod = getgpc('submod');

$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_mokuai')." WHERE available=1 order by displayorder asc");
while($row = DB::fetch($query)) {
	$modules = $setting = array();
	$setting = dunserialize($row['setting']);
	$modules = dunserialize($row['modules']);
	dump($modules);
	foreach($modules as $k=>$v ){
		if($v['type']==1){
		}
	}

}
?>