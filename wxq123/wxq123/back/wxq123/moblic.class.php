<?php


if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class mobileplugin_wxq123 {
	//
	function global_footer_mobile() {
		return ;
	}//end func
	//
	function global_header_mobile() {
		dheader("Location: ./plugin.php?id=wxq123:moblic");
		//include template('wxq123:test');
		//exit();

		return ;
	}//end func
	//
	function global_nav_extra(){
		global $mokuaiid;
		$return = '<ul>';
		$query = DB::query("SELECT * FROM ".DB::table('wxq123_mokuai')." WHERE status = 1 order by displayorder asc");
		while($row = DB::fetch($query)) {
			$return .= '<li '.($mokuaiid==$row['mokuaiid'] ? ' class="a"' : '').'><a href="plugin.php?id=wxq123&mokuaiid='.$row['mokuaiid'].'">'.$row['mokuaititle'].'</a></li>';
		}
		$return .= '</ul>';
		return $return;
	}//end func

}

?>