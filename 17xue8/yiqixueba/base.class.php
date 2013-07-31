<?php


if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
//
class plugin_yiqixueba_base {
	function yiqixueba_init() {
		global $_G;
		$siteinfo = array();
		$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_main_setting'));
		while($row = DB::fetch($query)) {
			$siteinfo[$row['skey']] = $row['svalue'];
		}
		setglobal('siteinfo',$siteinfo);
	}//end func
}//end class
?>