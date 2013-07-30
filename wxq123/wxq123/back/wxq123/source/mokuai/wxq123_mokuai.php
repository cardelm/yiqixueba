<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$mokuaiid = getgpc('mokuaiid');
if ($mokuaiid){
	$mokuai_info = DB::fetch_first("SELECT * FROM ".DB::table('wxq123_mokuai')." WHERE mokuaiid=".$mokuaiid);
	$source_name = $mokuai_info['mokuainame'].'_index';
}else{
	$source_name = 'wxq123_index';
}
$source_file = DISCUZ_ROOT.'source/plugin/wxq123/source/mokuai/'.$source_name.'.php';
$template_file = DISCUZ_ROOT.'source/plugin/wxq123/template/mokuai/'.$source_name.'.htm';
if (!file_exists($source_file)){
	file_put_contents($source_file,"<?php\n\nif(!defined('IN_DISCUZ')) {\n\texit('Access Denied');\n}\n\ninclude_once template('diy:'.\$source_name,0,'./source/plugin/wxq123/template/mokuai');\n?>");
}
if (!file_exists($template_file)){
	file_put_contents($template_file,"<!--{template common/header}-->\n<!--{template common/footer}-->\n");
}
require_once($source_file);
?>