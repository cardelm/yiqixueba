<?php


if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

$submod = getgpc('submod');
$submods = array('mokuailist','groupedit','designmokuai','editmokuai','viewmokuai','adminedit','moduleedit','templateedit','shop','setting','goods');
$submod = in_array($submod,$submods) ? $submod : $submods[0];
var_dump('dasd');

?>