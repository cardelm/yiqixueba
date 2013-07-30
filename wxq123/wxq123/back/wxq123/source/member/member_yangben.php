<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
$subction = getgpc('subction');
$subctions = array('index');
$subction = in_array($subction,$subctions)?$subction:$subctions[0];

foreach ( $subctions as $v) {
	$lang_subction[$subop.'_'.$v] = lang('plugin/wxq123',$subop.'_'.$v);
}
//以上为自动生成






//以下为自动生成
$template_file = 'source/plugin/wxq123/template/member/'.$subop.'_'.$subction.'.htm';

if(!file_exists($template_file)) {
	file_put_contents($template_file,file_get_contents('source/plugin/wxq123/template/member/yangben.htm'));
}
include_once template('diy:'.$subop.'_'.$subction,0,'./source/plugin/wxq123/template/member');
?>