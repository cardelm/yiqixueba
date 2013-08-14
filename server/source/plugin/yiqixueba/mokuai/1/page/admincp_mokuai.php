<?php
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

$this_page = substr($_SERVER['QUERY_STRING'],7,strlen($_SERVER['QUERY_STRING'])-7);
stripos($this_page,'subop=') ? $this_page = substr($this_page,0,stripos($this_page,'subop=')-1) : $this_page;

$subop = getgpc('subop');
$subops = array('mokuailist','mokuaiedit');
$subop = in_array($subop,$subops) ? $subop : $subops[0];

dump($sitekey);
dump($server_siteurl);

$mokuai_array = api_indata('mokuaiinfo',array());

dump($mokuai_array);
dump($subop);

if($subop == 'mokuailist') {
}elseif($subop == 'mokuaiedit'){
}

?>