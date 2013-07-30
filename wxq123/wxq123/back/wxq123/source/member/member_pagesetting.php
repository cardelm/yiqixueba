<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
$subction = getgpc('subction');
$subac = getgpc('subac');
$subctions = array('weblist','mobliclist','weixinlist');
$subction = in_array($subction,$subctions)?$subction:$subctions[0];
$subacs = array('webedit','moblicedit','weixinedit');
$subac = in_array($subac,$subacs)?$subac:'';
foreach ( $subctions as $v) {
	$lang_subction[$subop.'_'.$v] = lang('plugin/wxq123',$subop.'_'.$v);
}
//以上为自动生成





//以下为自动生成
if($subac) {
	$template_file = 'source/plugin/wxq123/template/member/'.$subop.'_'.$subac.'.htm';
}else{
	$template_file = 'source/plugin/wxq123/template/member/'.$subop.'_'.$subction.'.htm';
}

if(!file_exists($template_file)) {
	file_put_contents($template_file,file_get_contents('source/plugin/wxq123/template/member/yangben.htm'));
}
if($subac) {
	include_once template('diy:'.$subop.'_'.$subac,0,'./source/plugin/wxq123/template/member');
}else{
	include_once template('diy:'.$subop.'_'.$subction,0,'./source/plugin/wxq123/template/member');
}
?>