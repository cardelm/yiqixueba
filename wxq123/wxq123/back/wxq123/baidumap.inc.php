<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
if($_GET['tt']=='viewmap'){
	include template('wxq123:baidumap/viewmap');
}else{
	include template('wxq123:baidumap');
}
?>