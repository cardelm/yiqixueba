<?php
/**
 *      一起学吧服务端程序
 *		后台控制程序
 *      $Id: admincp.php 2013-05-28 22:27:03Z yangwen $
 */


if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

require_once DISCUZ_ROOT.'/source/plugin/yiqixueba_server/install.php';

$submod = addslashes($_GET['submod']);
$submod_array = array('server','client','yikatong','shop','wxq123');
$submods['server'] = array('basesetting','mokuai','site','mainpro','member');
$submods['client'] = array('setting','mokuailist','clientinstall');
$submods['yikatong'] = array('ysetting','shopsetting','goodssetting','shopadmin','goodsadmin','cardsetting','cardadmin','ymember');
$submods['shop'] = array('ssetting','shopedit','goodsedit');
$submods['wxq123'] = array('wsetting','wshopsetting','wshopfenlei','wshopfenlei');
$submod = $submod ? $submod : $submods['server'][0];
foreach ( $submod_array as $kk=>$vv) {
	$menu_server[$vv] = array();
	foreach ( $submods[$vv] as $k=>$v) {
		$menu_server[$vv][] = array(lang('plugin/yiqixueba_server',$vv.'_'.$v),'plugins&identifier=yiqixueba_server&pmod=admincp&submod='.$v,$submod == $v);
	}
	$current_menu[$vv] = in_array($submod,$submods[$vv]) ? lang('plugin/yiqixueba_server',$vv.'_'.$submod) : lang('plugin/yiqixueba_server',$vv);
	$menus[] = array(array('menu'=>$current_menu[$vv],'submenu' => $menu_server[$vv]), in_array($submod,$submods[$vv])||$kk==0&&empty($submod));
	if (in_array($submod,$submods[$vv])){
		$current_group = $vv;
	}
}


echo '<style>.floattopempty { height: 18px !important; height: auto; } </style>';
showsubmenu($plugin['name'].' '.$plugin['version'].'--'.lang('plugin/yiqixueba_server','current_group').lang('plugin/yiqixueba_server',$current_group),$menus);

$dir = DISCUZ_ROOT.'source/plugin/yiqixueba_server/source/'.$current_group;
if(!is_dir($dir)) {
	dmkdir($dir);
}
$filename = $dir.'/'.$submod.'.php';
if(!file_exists($filename)) {
	file_put_contents($filename, "<?php\n\n/**\n*\t一起学吧平台程序\n*\t".lang('plugin/yiqixueba_server',$current_group.'_'.$submod)."\n*\t文件名：".$submod.".php  创建时间：".dgmdate(time(),'dt')."  杨文\n*\n*/\n\nif(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {\n\texit('Access Denied');\n}\n\$this_page = 'plugins&identifier=yiqixueba_server&pmod=admincp&submod=".$submod."';\necho 'This Is ".$submod."';\n?>");
}
require_once $filename;


//$pp = array('yikatong','shop','wxq123');
//foreach ($pp as $k=>$v){
//	//rmdirs(DISCUZ_ROOT.'source/plugin/'.$v);
//	$dir = DISCUZ_ROOT.'source/plugin/yiqixueba_'.$v;
//	dmkdir($dir);
//	$file_admin = DISCUZ_ROOT.'source/plugin/yiqixueba_'.$v.'/admin.inc.php';
//	$file_class = DISCUZ_ROOT.'source/plugin/yiqixueba_'.$v.'/'.$v.'.class.php';
//	$file_lang = DISCUZ_ROOT.'data/plugindata/yiqixueba_'.$v.'.lang.php';
//	$file_install = DISCUZ_ROOT.'source/plugin/yiqixueba_'.$v.'/install.php';
//	file_put_contents($file_admin,"<?php\nif(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {\n\t	exit('Access Denied');\n}\n?>");
//	file_put_contents($file_class,"<?php\nif(!defined('IN_DISCUZ')) {\n\texit('Access Denied');\n}\n\nclass plugin_yiqixueba_".$v." {\n\n}\n?>");
//	file_put_contents($file_lang,"<?php\n\$scriptlang['yiqixueba_".$v."'] = array(\n\t'' => '',\n);\n\$templatelang['yiqixueba_".$v."'] = array(\n\t'' => '',\n);\n\$installlang['yiqixueba_".$v."'] = array(\n\t'' => '',\n);\n\$systemlang['yiqixueba_".$v."'] = array(\n\t'file' => array(\n\t\t'' => '',\n),\n);\n?>");
//	file_put_contents($file_install,"<?php\nif(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {\n\t	exit('Access Denied');\n}\n?>");
//	dmkdir($dir.'/template');
//	dmkdir($dir.'/admin');
//	dmkdir($dir.'/module');
//}

function rmdirs($srcdir) {
	$dir = @opendir($srcdir);
	while($entry = @readdir($dir)) {
		$file = $srcdir.$entry;
		if($entry != '.' && $entry != '..') {
			if(is_dir($file)) {
				rmdirs($file.'/');
			} else {
				@unlink($file);
			}
		}
	}
	closedir($dir);
	rmdir($srcdir);
}

?>