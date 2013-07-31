<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
$data['siteurl'] = $_G['siteurl'];
$data['clientip'] = $_G['clientip'];
$data = serialize($data);
$data = base64_encode($data);
$sql = file_get_contents(dirname(__FILE__).'/data/install.sql');
runquery($sql);
$finish = TRUE;
?>
