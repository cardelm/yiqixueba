<?php


if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$moblic_nav = array();
foreach ( dunserialize(DB::result_first("SELECT modules FROM ".DB::table('common_plugin')." WHERE identifier='wxq123'")) as $v) {
	if($v['type']==1) {
		$moblic_nav[] = array('mokuaiid'=>0,'title'=>$v['menu']);
	}
}
$query = DB::query("SELECT * FROM ".DB::table('wxq123_mokuai')." WHERE status = 1 order by displayorder asc");
while($row = DB::fetch($query)) {
	$moblic_nav[] = array('mokuaiid'=>$row['mokuaiid'],'title'=>$row['mokuaititle']);
}
var_dump($_GET);
var_dump($_POST);
$uri = $_SERVER['REQUEST_URI'];
var_dump(substr($_GET['sukey'], 0 , 32));
var_dump($uri);
include template('wxq123:test');
?>