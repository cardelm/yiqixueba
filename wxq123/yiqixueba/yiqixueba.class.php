<?php


if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class plugin_yiqixueba {
	//
	function global_cpnav_extra1(){
		return '石家庄';
	}//end func
	//
	function global_usernav_extra4(){
		global $_G;
		$return = '<a href="plugin.php?id=yiqixueba:manage">'.lang('plugin/yiqixueba','membercenter').'</a> <span class="pipe">|</span>';
		return $return;

	}//end func
	//
	function  global_login_extra(){

//		$return = '<div class="fastlg_fm y" style="margin-right: 10px; padding-right: 10px"><p><a href="http://www.wxq123.com/connect.php?mod=login&op=init&referer=plugin.php%3Fid%3Dyiqixueba%3Amanage%26man%3Dshop%26subman%3Dshopedit&statfrom=login_simple"><img src="static/image/common/qq_login.gif" class="vm" alt="QQ登录" /></a></p><p class="hm xg1" style="padding-top: 2px;">只需一步，快速开始</p></div>';
//		return $return;
	}//end func
	//
	function global_nav_extra(){
		global $mokuaiid;
		return $return;
	}//end func
	//
	function global_footer(){
		global $_G,$mokuai_info;
//		if($_G['adminid']==1){
//			$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_setting')." WHERE skey like '%_nav_menu'");
//			while($row = DB::fetch($query)) {
//				$mokuai_name = '';
//				$nav = array();
//				$mokuai_name = str_replace("yiqixueba_","",$row['skey']);
//				$mokuai_name = str_replace("_nav_menu","",$mokuai_name);
//				$nav = DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_mokuai')." WHERE mokuainame='".$mokuai_name."'");
//				$_G['setting']['navs'][] = array(
//					'navname' => $nav['mokuaititle'],
//					'filename' => 'plugin.php?id=yiqixueba&mokuaiid='.$nav['mokuaiid'],
//					'available' => intval($row['svalue']),
//					'navid' => 'mn_'.$mokuai_name,
//					'level' => 0,
//					'nav' => 'id="mn_'.$mokuai_name.'" ><a href="plugin.php?id=yiqixueba&mokuaiid='.$nav['mokuaiid'].'" hidefocus="true" title="'.$mokuai_name.'"  >'.$nav['mokuaititle'].'<span>'.$mokuai_name.'</span></a',
//				);
//			}
//			$_G['mnid'] = 'mn_'.$mokuai_info['mokuainame'];
//		}
		return ;
	}//end func

}


class plugin_yiqixueba_member extends plugin_yiqixueba {
	function logging_input_output(){
		//return 'dajshdhas';
	}


}


?>