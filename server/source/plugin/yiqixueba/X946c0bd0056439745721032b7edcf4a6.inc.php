<?php

/**
*
*	admincp.inc.php 2013-7-29 10:58
*	2013-7-29 14:51
*/

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

require_once DISCUZ_ROOT.'source/plugin/'.$plugin['directory'].DB::result_first("SELECT svalue FROM ".DB::table('yiqixueba_setting')." WHERE skey='mod_function'").'.inc.php';
require_once DISCUZ_ROOT.'source/plugin/'.$plugin['directory'].'install.php';

$admincp_file = DB::result_first("SELECT svalue FROM ".DB::table('yiqixueba_setting')." WHERE skey='mod_admincp'");

$submod = getgpc('submod');
$admin_menu = $submenus = array();

$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_mokuai')." WHERE available=1 order by displayorder asc");
$menuk = 0;
while($row = DB::fetch($query)) {

	$modules = $setting = array();
	$modules = dunserialize($row['modules']);
	$setting = dunserialize($row['setting']);
	$submods = $submenus = array();
	$current_menu = '';
	$menukk = 0;
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
			$submenus[] = array($v['menu'],'plugins&identifier=yiqixueba&pmod='.$admincp_file.'&submod='.$row['identifier'].'_'.$v['name'],$submod == $current_group.'_'.$v['name']);
			$menukk++;
		}
	}

	if($menukk != 0){
		$admin_menu[] = array(array('menu'=>$current_menu  ? $current_menu  : $row['name'],'submenu'=>$submenus),$current_group == $row['identifier']);
	}else{
		if ($menuk == 0 && empty($submod)){
			$submod = $row['identifier'];
		}
		$admin_menu[] = array($row['name'],'plugins&identifier=yiqixueba&pmod='.$admincp_file.'&submod='.$row['identifier'],$submod == $row['identifier']);
	}
	$menuk++;
}

//echo '<style>.floattopempty { height: 15px !important; height: auto; } </style>';
showsubmenu($plugin['name'].' '.$plugin['version'],$admin_menu);

$submod_array = explode("_",$submod);
$mokuai_id = DB::result_first("SELECT mokuaiid FROM ".DB::table('yiqixueba_mokuai')." WHERE identifier='".$submod_array[0]."'");
$mokuai_file = DISCUZ_ROOT.'source/plugin/yiqixueba/mokuai/'.$mokuai_id.'/page/admincp_'.$submod_array[1].'.php';

$submod_file = DISCUZ_ROOT.'source/plugin/yiqixueba/source/'.md5($submod.$sitekey).'.php';

if(file_exists($mokuai_file)){
	file_put_contents($submod_file,file_get_contents($mokuai_file));
}
if(file_exists($submod_file)){
	require($submod_file);
}else{
	exit('Access Denied');
}


?>