<?php

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
require_once dirname(__FILE__).'/data/function.php';
$data['siteurl'] = $_G['siteurl'];
$data['clientip'] = $_G['clientip'];
$data = serialize($data);
$data = base64_encode($data);

$submod = $_GET['submod']; 
$subaction = $_GET['subaction']; 


$site_info = getsiteinfo();
$submenus = dunserialize($site_info['adminmenus']);

if($submenus) {
	$submenup = array();
	$mi = 0;
	foreach ( $submenus as $mk=>$mv) {
		$submod = !$submod && $mi ==0 ? $mv['name'] : $submod;
		$dangqian_menu = '';
		if( $mv['type']=='group') {
			$endmenu = array();
			$smi = 0;
			foreach ( $submenus as $smk=>$smv) {
				if(intval($smv['type'])==intval($mv['menuid'])) {
					$subaction = !$subaction && $smi ==0 ? $smv['name'] : $subaction;
					$endmenu[$smi] =array($smv['title'],'plugins&identifier=yiqixueba&pmod=admincp&submod='.$mv['name'].'&subaction='.$smv['name'],($submod == $smv['name'] && $subaction==$smv['name']));
					if($submod == $mv['name'] && $subaction==$smv['name']) {
						$dangqian_menu = $smv['title'];
					}
					$smi++;
				}
			}
			$dangqian_menu = $dangqian_menu ? $dangqian_menu : $mv['title'];
			$submenup[] = array(array('menu'=>$dangqian_menu,'submenu'=>$endmenu),$submod==$mv['name']);
		}elseif($mv['type']=='menu') {
			$dangqian_menu = $dangqian_menu ? $dangqian_menu : $mv['title'];
			$submenup[] = array($dangqian_menu,'plugins&identifier=yiqixueba&pmod=admincp&submod='.$mv['name'],$submod==$mv['name']);
		}
		$mi++;
	}
	
	shownav('plugin', $plugin['name']);
	showsubmenu($plugin['name'].' '.$plugin['version'], $submenup, '<a href="'.$_G['siteurl'].'plugin.php?id=yiqixueba:brand" target="_blank" class="bold" style="float:right;padding-right:40px;">'.$plugin['name'].'</a>');
}
?>