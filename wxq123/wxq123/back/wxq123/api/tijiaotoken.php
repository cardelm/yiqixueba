<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

DB::update('wxq123_shibiema',array('token'=>$apidata['token']),array('shibiema'=>$apidata['shibiema']));
$outdata['token'] = $apidata['token'];
?>