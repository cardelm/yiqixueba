<?php
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
//require_once DISCUZ_ROOT.'/source/plugin/yiqixueba_wxq123/install.php';

$submod = getgpc('submod');

$admin_menu = array();
$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_wxq123_adminmenu')." WHERE upid = 0 order by displayorder asc");
$k = 0;
while($row = DB::fetch($query)) {
	$next_num = DB::result_first("SELECT count(*) FROM ".DB::table('yiqixueba_wxq123_adminmenu')." WHERE upid=".$row['menuid']);
	if ($next_num){
		$submods = $submenus = array();
		$kk = 0;
		$query1 = DB::query("SELECT * FROM ".DB::table('yiqixueba_wxq123_adminmenu')." WHERE upid=".$row['menuid']." order by displayorder asc");
		$current_menu = '';
		while($row1 = DB::fetch($query1)) {
			if ( $k == 0 && $kk == 0 && empty($submod) ){
				$submod = $row1['menuname'];
			}
			$submods[] = $row1['menuname'];
			$submenus[] = array($row1['menutitle'],'plugins&identifier=yiqixueba_wxq123&pmod=admin&submod='.$row1['menuname'],$submod == $row1['menuname']);
			if ($submod == $row1['menuname']){
				$current_menu = $row1['menutitle'];
			}
			$kk++;
		}
		$admin_menu[] = array(array('menu'=>$current_menu  ? $current_menu  : $row['menutitle'],'submenu'=>$submenus),in_array($submod,$submods));
	}else{
		if ($k == 0 && empty($submod)){
			$submod = $row['menuname'];
		}
		$admin_menu[] = array($row['menutitle'],'plugins&identifier=yiqixueba_wxq123&pmod=admin&submod='.$row['menuname'],$submod == $row['menuname']);
	}
	$k++;
}

$plugin_setting = array();
$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_wxq123_setting'));
while($row = DB::fetch($query)) {
	$plugin_setting[$row['skey']] = $row['svalue'];
}
echo '<style>.floattopempty { height: 15px !important; height: auto; } </style>';
showsubmenu($plugin['name'].' '.$plugin['version'],$admin_menu);

$submod_file = DISCUZ_ROOT.'source/plugin/yiqixueba_wxq123/admin/'.$submod.'.inc.php';
if (!file_exists($submod_file)){
	file_put_contents($submod_file, "<?php\n\n/**\n*\t一起学吧平台程序\n*\t文件名：".$submod.".inc.php  创建时间：".dgmdate(time(),'dt')."  杨文\n*\n*/\n\nif(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {\n\texit('Access Denied');\n}\n\$this_page = 'plugins&identifier=yiqixueba_wxq123&pmod=admin&submod=".$submod."';\necho 'This Is ".$submod."';\n?>");
}
require_once $submod_file;
?>