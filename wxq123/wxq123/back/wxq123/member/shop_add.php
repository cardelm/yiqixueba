<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
//参数设置
$tablename[] = 'wxq123_threadtype';
$where[] = " WHERE classid = 0 AND available = 1 ORDER BY displayorder ASC";
$tablename[] = 'wxq123_typeoption';
$where[] = "";
//参数设置
$options = $htmls = array();

$query = DB::query("SELECT * FROM ".DB::table($tablename[0]).$where[0]);
while($row = DB::fetch($query)) {
	$option_info = DB::fetch_first("SELECT * FROM ".DB::table($tablename[1]).$where[1]." WHERE optionid = ".$row['optionid']);
	$options[] = array(
		'identifier' => $option_info['identifier'],
		'title' => $option_info['title'],
		'type' => $option_info['type'],
		'description' => $option_info['description'],
		'unchangeable' => $row['unchangeable'],
		'required' => $row['required'],
	);
}

if ($_POST){
	foreach ($options as $k=>$v){
		if (in_array($v['type'],array('text'))){
			$data[$v['identifier']] = getgpc($v['identifier']);
		}elseif ($v['type'] == 'baidu'){
			$data[$v['identifier']] = serialize(array(getgpc('baidu_x'),getgpc('baidu_y')));
		}elseif ($v['type'] == 'baidu'){
		}

	}

	var_dump($data);
}
$htmls = getoptionhtml($options,array());

//
function getoptionhtml($options,$value) {
	$return = array();
	foreach ( $options as $k=>$v) {
		if($v['type'] == 'number') {
			$return[$v['identifier']] = '<input type="text" name="'.$v['identifier'].'" class="px">';
		}elseif($v['type'] == 'text') {
			$return[$v['identifier']] = '<input type="text" name="'.$v['identifier'].'" class="px">';
		}elseif($v['type'] == 'radio') {
			$return[$v['identifier']] = '<input type="radio" name="'.$v['identifier'].'">';
		}elseif($v['type'] == 'checkbox') {
			$return[$v['identifier']] = '<input type="checkbox" name="">';
		}elseif($v['type'] == 'textarea') {
			$return[$v['identifier']] = '<TEXTAREA name="" rows="" cols="">'.$v['identifier'].'</TEXTAREA>';
		}elseif($v['type'] == 'select') {
			$return[$v['identifier']] = '<SELECT name="'.$v['identifier'].'"><OPTION value="" selected><OPTION value=""></SELECT>';
		}elseif($v['type'] == 'calendar') {
			$return[$v['identifier']] = '<script type="text/javascript" src="'.$_G['setting']['jspath'].'calendar.js?'.VERHASH.'"></script><input type="text" name="'.$v['identifier'].'"  onchange="checkoption(\''.$v['identifier'].'\', \''.$v['required'].'\', \''.$v['type'].'\')" value="'.$v['value'].'" onclick="showcalendar(event, this, false)">';
		}elseif($v['type'] == 'email') {
			$return[$v['identifier']] = '<input type="text" name="'.$v['identifier'].'">';
		}elseif($v['type'] == 'url') {
			$return[$v['identifier']] = '<input type="text" name="'.$v['identifier'].'">';
		}elseif($v['type'] == 'image') {
			$return[$v['identifier']] = '<button type="button" class="pn" onclick="uploadWindow(function (aid, url){sortaid_'.$v['identifier'].'_upload(aid, url)})"><em>'.($v['value']?lang('plugin/wxq123', 'update'):lang('plugin/wxq123', 'upload')).'</em></button>';
		}elseif($v['type'] == 'range') {
			$return[$v['identifier']] = '';
		}elseif($v['type'] == 'baidu') {
			$return[$v['identifier']] = '<input type="hidden" name="baidu_x" id="baidu_x" value="'.$baidus['x'].'"><input type="hidden" name="baidu_y" id="baidu_y" value="'.$baidus['y'].'"><iframe id="baidumapboa" src="plugin.php?id=wxq123:baidumap" width="600" height="400" frameborder="0" ></iframe>';
		}elseif($v['type'] == 'editarea') {
			$return[$v['identifier']] = '';
		}elseif($v['type'] == 'district') {
			$return[$v['identifier']] = '';
		}

	}
	return $return;
}//end func











?>