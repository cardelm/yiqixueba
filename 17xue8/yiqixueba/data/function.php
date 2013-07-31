<?php

//
function getsiteinfo() {
	$return = array();
	$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_main_setting'));
	while($row = DB::fetch($query)) {
		$return[$row['skey']] = $row['svalue']; 
	}
	return $return;
	
}//end func
//
function doaction($action,$values) {
	$actions = array('readfile','writefile','delfile','','','','','','');

	if(!in_array($action,$actions)) 
		return false;
	
	if($action == 'writefile') {

	}elseif($action == 'delfile'){
		unlink(DISCUZ_ROOT.$values['delfilename']);
	}
}//end func
?>