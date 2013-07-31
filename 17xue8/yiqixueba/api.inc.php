<?php


if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
require_once dirname(__FILE__).'/yiqixueba.func.php';
$submod = getgpc('submod');
$subop = getgpc('subop');

$pagefile = getpageid($submod,$subop,2);
if(file_exists($pagefile)) {
	require $pagefile;
}

 
?>