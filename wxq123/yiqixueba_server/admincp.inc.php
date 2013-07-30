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


$admin_menu = array();
$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_server_menu')." WHERE upid = 0 and menutype='admin' order by displayorder asc");
$k = 0;
while($row = DB::fetch($query)) {
	$next_num = DB::result_first("SELECT count(*) FROM ".DB::table('yiqixueba_server_menu')." WHERE upid=".$row['menuid']);
	if ($next_num){
		$submods = $submenus = array();
		$kk = 0;
		$query1 = DB::query("SELECT * FROM ".DB::table('yiqixueba_server_menu')." WHERE upid=".$row['menuid']." order by displayorder asc");
		$current_menu = '';
		while($row1 = DB::fetch($query1)) {
			if ( $k == 0 && $kk == 0 && empty($submod) ){
				$submod = $row1['menuname'];
			}
			$submods[] = $row1['menuname'];
			$submenus[] = array($row1['menutitle'],'plugins&identifier=yiqixueba_server&pmod=admincp&submod='.$row1['menuname'],$submod == $row1['menuname']);
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
		$admin_menu[] = array($row['menutitle'],'plugins&identifier=yiqixueba_server&pmod=admincp&submod='.$row['menuname'],$submod == $row['menuname']);
	}
	$k++;
}

$dir = DISCUZ_ROOT.'source/plugin/yiqixueba_server/client';
if(!is_dir($dir)) {
	dmkdir($dir);
}
$dir_array = array('admin','module','template');
foreach ( $dir_array as $k=>$v) {
	$dir = DISCUZ_ROOT.'source/plugin/yiqixueba_server/client/'.$v;
	if(!is_dir($dir)) {
		dmkdir($dir);
	}
}

echo '<style>.floattopempty { height: 15px !important; height: auto; } </style>';
showsubmenu($plugin['name'].' '.$plugin['version'],$admin_menu);

$submod_file = DISCUZ_ROOT.'source/plugin/yiqixueba_server/client/admin/'.$submod.'.inc.php';
if (!file_exists($submod_file)){
	file_put_contents($submod_file, "<?php\n\n/**\n*\t一起学吧平台程序\n*\t文件名：".$submod.".inc.php  创建时间：".dgmdate(time(),'dt')."  杨文\n*\n*/\n\nif(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {\n\texit('Access Denied');\n}\n\$this_page = 'plugins&identifier=yiqixueba_server&pmod=admincp&submod=".$submod."';\necho 'This Is ".$submod."';\n?>");
}
require_once $submod_file;
// 浏览器友好的变量输出
function dump($var, $echo=true,$label=null, $strict=true){
    $label = ($label===null) ? '' : rtrim($label) . ' ';
    if(!$strict) {
        if (ini_get('html_errors')) {
            $output = print_r($var, true);
            $output = "<pre>".$label.htmlspecialchars($output,ENT_QUOTES)."</pre>";
        } else {
            $output = $label . " : " . print_r($var, true);
        }
    }else {
        ob_start();
        var_dump($var);
        $output = ob_get_clean();
        if(!extension_loaded('xdebug')) {
            $output = preg_replace("/\]\=\>\n(\s+)/m", "] => ", $output);
            $output = '<pre>'. $label. htmlspecialchars($output, ENT_QUOTES). '</pre>';
        }
    }
    if ($echo) {
        echo($output);
        return null;
    }else
        return $output;
}

?>