<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
$subction = getgpc('subction');
$subctions = array('index');
$subction = in_array($subction,$subctions)?$subction:$subctions[0];
foreach ( $subctions as $v) {
	$lang_subction[$v] = lang('plugin/wxq123',$v);
}
//����Ϊ�Զ�����






//����Ϊ�Զ�����
$template_file = 'source/plugin/wxq123/template/member/'.$subop.'_'.$subction.'.htm';

if(!file_exists($template_file)) {
	file_put_contents($template_file,file_get_contents('source/plugin/wxq123/template/member/baseinfo_index.htm'));
}
include_once template('diy:'.$subop.'_'.$subction,0,'./source/plugin/wxq123/template/member');
?>