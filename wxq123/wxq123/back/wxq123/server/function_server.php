<?php
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

 function rmdirs($srcdir) {
	$dir = @opendir($srcdir);
	while($entry = @readdir($dir)) {
		$file = $srcdir.$entry;
		if($entry != '.' && $entry != '..') {
			if(is_dir($file)) {
				rmdirs($file.'/');
			} else {
				@unlink($file);
			}
		}
	}
	closedir($dir);
	rmdir($srcdir);
}
//
function read_file($srcdir) {
	$dir = @opendir($srcdir);
	$k = 0;
	while($entry = @readdir($dir)) {
		$file = $srcdir.$entry;
		if($entry != '.' && $entry != '..') {
			$file_info[$k]['filename'] = $entry;
			$file_info[$k] = file($file);
			$k++;
		}
	}
	return $file_info;
}//end func
?>