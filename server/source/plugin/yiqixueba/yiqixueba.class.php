<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class plugin_yiqixueba {

	//
	function global_usernav_extra1(){
		return '<span class="pipe">|</span><a href="plugin.php?id=yiqixueba:member">'.lang('plugin/yiqixueba','member').'</a> ';
	}//end func
}

?>