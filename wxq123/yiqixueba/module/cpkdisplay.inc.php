<?php

/**
*	一起学吧平台程序
*	文件名：cpkdisplay.inc.php  创建时间：2013-6-17 02:08  杨文
*
*/

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
$cpkid = intval(getgpc('cpkid'));
$cpk_info = DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_brand_chanpinku')." WHERE chanpinkuid=".$cpkid);
$logo = '';
if($cpk_info['logo']!='') {
	$logo = str_replace('{STATICURL}', STATICURL, $cpk_info['logo']);
	if(!preg_match("/^".preg_quote(STATICURL, '/')."/i", $logo) && !(($valueparse = parse_url($logo)) && isset($valueparse['host']))) {
		$logo = $_G['setting']['attachurl'].'common/'.$cpk_info['logo'].'?'.random(6);
	}
	$logo = $logo ? $logo : 'source/plugin/yiqixueba/template/yiqixueba/default/style/image/nogoodslogo.jpg';
}

include template('yiqixueba:'.$template_file);
?>