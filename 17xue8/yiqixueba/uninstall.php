<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
$sql = file_get_contents(dirname(__FILE__).'/data/uninstall.sql');
runquery($sql);
$finish = TRUE;
?>
