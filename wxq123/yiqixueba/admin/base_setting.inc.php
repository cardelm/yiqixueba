<?php

/**
*	一起学吧平台程序
*	文件名：base_setting.inc.php  创建时间：2013-6-8 13:08  杨文
*
*/

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
$this_page = 'plugins&identifier=yiqixueba&pmod=admin&submod=base_setting';

$base_setting = array();
$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_setting'));
while($row = DB::fetch($query)) {
	$base_setting[$row['skey']] = $row['svalue'];
}

$templates = array();
$temp_dir = DISCUZ_ROOT.'source/plugin/yiqixueba/template/yiqixueba';
if ($handle = opendir($temp_dir)) {
	while (false !== ($file = readdir($handle))) {
		if ($file != "." && $file != "..") {
			if (is_dir($temp_dir."/".$file)) {
				$templates[] = $file;
			}
		}
	}
}

$temp_select = '<select name="base_setting[thistemplate]">';
foreach ($templates as $k=>$v){
	$temp_select .= '<option value="'.$v.'" '.($base_setting['thistemplate'] == $v ? ' selected':'').'>'.lang('plugin/yiqixueba','temp_'.$v).'</option>';
}
$temp_select .= '</select>';
if(!submitcheck('submit')) {
	showtips(lang('plugin/yiqixueba','base_setting_tips'));
	showformheader($this_page,'enctype');
	showtableheader(lang('plugin/yiqixueba','base_setting'));
	showsetting(lang('plugin/yiqixueba','thistemplate'),'','',$temp_select,'',0,lang('plugin/yiqixueba','thistemplate_comment'),'','',true);
	showsubmit('submit');
	showtablefooter();
	showformfooter();
}else{
	$datas = $_GET['base_setting'];
	foreach ($datas as $k=>$v){
		if (DB::result_first("SELECT count(*) FROM ".DB::table('yiqixueba_setting')." WHERE skey='".$k."'")==0){
			DB::insert('yiqixueba_setting',array('skey'=>$k,'svalue'=>$v));
		}else{
			DB::update('yiqixueba_setting',array('svalue'=>$v),array('skey'=>$k));
		}
	}
	cpmsg(lang('plugin/yiqixueba', 'base_setting_succeed'), 'action='.$this_page, 'succeed');
}


?>