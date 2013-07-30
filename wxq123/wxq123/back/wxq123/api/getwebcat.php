<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
$query = DB::query("SELECT * FROM ".DB::table('wxq123_mokuai')." where status = 1 order by mokuaiid asc");
while($row = DB::fetch($query)) {
	$outdata[] = array('catid'=>$row['mokuaiid'],'catname'=>$row['mokuaititle']);
}
?>