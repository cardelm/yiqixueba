<?php


if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class plugin_wxq123 {
	//
	function global_usernav_extra4(){
		global $_G;
		$return = '';
		if($_G['groupid'] == $_G['cache']['plugin']['wxq123']['sitegroup'] || $_G['groupid'] == $_G['cache']['plugin']['wxq123']['shopgroup'] || $_G['groupid'] == $_G['cache']['plugin']['wxq123']['weixingroup']){
			$return = '<a href="plugin.php?id=wxq123:member">'.lang('plugin/wxq123','member_center').'</a> <span class="pipe">|</span>';
		}else{
			$return = '<a href="plugin.php?id=wxq123:member">'.lang('plugin/wxq123','member_center').'</a> <span class="pipe">|</span>';
		}
		return $return;

	}//end func
	//
	function global_nav_extra(){
		global $mokuaiid;
		$return = '<ul>';
		$query = DB::query("SELECT * FROM ".DB::table('wxq123_mokuai')." WHERE status = 1 order by displayorder asc");
		while($row = DB::fetch($query)) {
			$return .= '<li '.($mokuaiid==$row['mokuaiid'] ? ' class="a"' : '').'><a href="plugin.php?id=wxq123&mokuaiid='.$row['mokuaiid'].'">'.$row['mokuaititle'].'</a></li>';
		}
		$return .= '</ul>';
		return $return;
	}//end func
	//
	function global_login_extra() {
		$data['wxtype'] = 'login';
		$data['wxcode'] = random(6);
		$urlToEncode="http://www.17xue8.cn?plugin.php&id=wxq123:moblic";
		$chl = urlencode($urlToEncode);
		//return '<div class="y" style="margin-right: 10px; padding-right: 10px"><img src="http://chart.apis.google.com/chart?chs=60x60&cht=qr&chld=1|0&chl='.$chl.'" alt="QR code" widhtHeight="60" widhtHeight="60" /></div>';
	}//end func
	//
	function  global_footer(){
		if(!file_exists(DISCUZ_ROOT.'source/plugin/wxq123/source/wxq123/'.CURSCRIPT.'_'.CURMODULE.'.php')) {
			file_put_contents(DISCUZ_ROOT.'source/plugin/wxq123/source/wxq123/'.CURSCRIPT.'_'.CURMODULE.'.php',"<?php\n/**\n*\t[szbs!] (C)2012-2099 szbs Inc.\n*\tThis is NOT a freeware, use is subject to license terms\n*\n*\t\$Id: ".CURSCRIPT."_".CURMODULE.".php ".date('Y-m-d H:i:s')." YangWen \$\n*/\n\nif(!defined('IN_DISCUZ')) {\n\t	exit('Access Denied');\n}\n\$return = CURSCRIPT.'-'.CURMODULE;\n\n?>");
		}
		//require_once DISCUZ_ROOT.'source/plugin/wxq123/source/wxq123/'.CURSCRIPT.'_'.CURMODULE.'.php';
		return $return;
	}//end func
}

//
class plugin_wxq123_forum extends plugin_wxq123 {
	//
	function post_top_output() {
		global $_G,$navigation,$lang,$specialextra,$special;
		if($_G['fid'] == $_G['cache']['plugin']['wxq123']['shopforum']) {
			$navigation = '';
			//$lang['post_newthread'] = '';
		}
		//var_dump($_G['forum']['threadsorts']);
		//return 'kg'.$special;
	}//end func
	//
	function post_top() {
		global $lang;

		return ;
	}//end func
}//end class
?>