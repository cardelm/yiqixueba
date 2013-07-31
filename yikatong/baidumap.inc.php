<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
if($_GET['tt']=='viewmap'){
	include template('yikatong:baidumap/viewmap');
}else{
	include template('yikatong:text');
}
?>