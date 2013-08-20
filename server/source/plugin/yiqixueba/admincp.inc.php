<?php
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
$sitekey = DB::result_first("SELECT svalue FROM ".DB::table('yiqixueba_setting')." WHERE skey='sitekey'");
$submod = getgpc('submod');
$admin_menu = $submenus = array();
$admincp_file = 'admincp';

$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_mokuai')." WHERE available=1 order by displayorder asc");
$menuk = 0;
while($row = DB::fetch($query)) {
	$function_file = DISCUZ_ROOT.'source/plugin/yiqixueba/source/'.md5($row['mokuaikey'].'function').'.php';
	////////////////debug//////////////////////
	$server_mokuaiid = DB::result_first("SELECT mokuaiid FROM ".DB::table('yiqixueba_server_mokuai')." WHERE identifier='".$row['identifier']."' AND currentversion = 1");
	if($server_mokuaiid && file_exists(DISCUZ_ROOT.'source/plugin/yiqixueba/mokuai/'.$server_mokuaiid.'/function.func.php')){
		file_put_contents($function_file,file_get_contents(DISCUZ_ROOT.'source/plugin/yiqixueba/mokuai/'.$server_mokuaiid.'/function.func.php'));
	}
	////////////////debug//////////////////////
	if(file_exists($function_file)){
		require_once $function_file;
	}
	$modules = $setting = array();
	$setting = dunserialize($row['setting']);
	$modules = dunserialize($row['modules']);

	$submods = $submenus = array();
	$current_menu = '';
	$menukk = 0;
	//这里增加有参数的部分
	if($setting){
	}
	foreach($modules as $k=>$v ){
		if($v['type']==3){
			if ( $menuk == 0 && $menukk == 0 && empty($submod) ){
				$submod = $row['identifier'].'_'.$v['name'];
			}
			if ($submod == $row['identifier'].'_'.$v['name']){
				$current_menu = $v['menu'];
				$current_group = $row['identifier'];
				$submod_file = DISCUZ_ROOT.'source/plugin/yiqixueba/source/'.md5($submod.$row['mokuaikey']).'.php';
				////////////////debug//////////////////////
				$mokuai_file = DISCUZ_ROOT.'source/plugin/yiqixueba/mokuai/'.$server_mokuaiid.'/page/admincp_'.$v['name'].'.php';
				if($server_mokuaiid && file_exists($mokuai_file)){
					file_put_contents($submod_file,file_get_contents($mokuai_file));
				}
				////////////////debug//////////////////////
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
echo '<style>.floattopempty { height: 15px !important; height: auto; } </style>';
showsubmenu($plugin['name'].' '.$plugin['version'],$admin_menu);



if(file_exists($submod_file)){
	require($submod_file);
}else{
	exit('Access Denied');
}


?>