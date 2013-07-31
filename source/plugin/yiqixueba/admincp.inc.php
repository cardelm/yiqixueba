<?php

/**
*
*	admincp.inc.php 2013-7-29 10:58
*	2013-7-29 14:51
*/

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

require_once DISCUZ_ROOT.'source/plugin/'.$plugin['directory'].'function.func.php';

$submod = getgpc('submod');


$admin_menu = $submenus = array();

/*当使用yiqixueba_main插件的时候，需要注释以下内容
$submenu_array = array('index','setting','pluginreg','mokuai');
$submod = $submod ? $submod : 'manpro_'.$submenu_array[0];
foreach( $submenu_array as $k=>$v ){
	$submenus[] = array(lang('plugin/yiqixueba','manpro_'.$v),'plugins&identifier=yiqixueba&pmod=admincp&submod=manpro_'.$v, $submod == 'manpro_'.$v);
}
$admin_menu[] = array(array('menu'=>in_array(str_replace("manpro_","",$submod),$submenu_array)?lang('plugin/yiqixueba',$submod):lang('plugin/yiqixueba','manpro'),'submenu'=>$submenus),in_array(str_replace("manpro_","",$submod),$submenu_array)|| empty($submod));
*/

$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_mokuai')." WHERE available=1 order by displayorder asc");
$menuk = 0;
while($row = DB::fetch($query)) {

	$setting = array();
	$modules = dunserialize($row['modules']);
	$setting = dunserialize($row['setting']);
	$submods = $submenus = array();
	$current_menu = '';
	$menukk = 0;
//	if(is_array($setting) &&  $menukk == 0 ){
//		$submod = $row['identifier'].'_setting';
//		$current_menu = 'setting';
//		$current_group = $row['identifier'];
//		$submods[] = $current_group.'_setting';
//		$submenus[] = array(lang(),'plugins&identifier=yiqixueba&pmod=admincp&submod='.$row['identifier'].'_setting',$submod == $current_group.'_setting');
//		$menukk++;
//	}
	foreach($modules as $k=>$v ){
		if($v['type']==3){
			//当使用yiqixueba_main插件的时候，需要使用以下内容
			if ( $menuk == 0 && $menukk == 0 && empty($submod) ){
				$submod = $row['identifier'].'_'.$v['name'];
			}
			//当使用yiqixueba_main插件的时候，需要使用以上内容
			if ($submod == $row['identifier'].'_'.$v['name']){
				$current_menu = $v['menu'];
				$current_group = $row['identifier'];
			}
			$submods[] = $current_group.'_'.$v['name'];
			$submenus[] = array($v['menu'],'plugins&identifier=yiqixueba&pmod=admincp&submod='.$row['identifier'].'_'.$v['name'],$submod == $current_group.'_'.$v['name']);
			$menukk++;
		}
	}

	if($menukk != 0){
		$admin_menu[] = array(array('menu'=>$current_menu  ? $current_menu  : $row['name'],'submenu'=>$submenus),$current_group == $row['identifier']);
	}else{
		if ($menuk == 0 && empty($submod)){
			$submod = $row['identifier'];
		}
		$admin_menu[] = array($row['name'],'plugins&identifier=yiqixueba&pmod=admincp&submod='.$row['identifier'],$submod == $row['identifier']);
	}
	$menuk++;
}

echo '<style>.floattopempty { height: 15px !important; height: auto; } </style>';
showsubmenu($plugin['name'].' '.$plugin['version'],$admin_menu);

$submod_file = get_page($submod);

if(file_exists($submod_file)){
	require($submod_file);
}


?>