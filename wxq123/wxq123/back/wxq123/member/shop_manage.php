<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
//var_dump(explode("\t",($_G['member']['extgroupids'])));
//

function getmokuaibyuid() {
	global $_G;
	$mokuais = dunserialize(DB::result_first("SELECT shopmokuais FROM ".DB::table('wxq123_shop')." WHERE uid=".$_G['uid']));
	return $mokuais;
}//end func
?>