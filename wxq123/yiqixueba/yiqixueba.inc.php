<?php

/**
*	一起学吧平台程序
*	前台管理
*	文件名：yiqixueba.inc.php  创建时间：2013-6-1 15:17  杨文
*
*/

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
require_once DISCUZ_ROOT.'/source/plugin/yiqixueba/function.php';

$_G['disabledwidthauto'] = 0;

$submod = getgpc('submod');
$submods = array('main','brandlist','shoplist','shopdisplay','cpkdisplay','cpklist','joinbusiness','addgoods','addshop','gonggao','baidumap','ajax','tuisong','openweixin','api','shopdisplay_dianping','shopdisplay_liuyan','dianpinglist');
$submod = in_array($submod,$submods) ? $submod : $submods[0];

$mokuaiid = getgpc('mokuaiid');
$mokuai_info = $mokuaiid ? DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_mokuai')." WHERE mokuaiid=".$mokuaiid) : array();

$base_setting = array();
$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_setting'));
while($row = DB::fetch($query)) {
	$base_setting[$row['skey']] = $row['svalue'];
}
$sitekey = $base_setting['sitekey'];
$thistemplate = $base_setting['yiqixueba_brand_thistemplate'];

//$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_setting')." WHERE skey like '%_nav_menu'");
//while($row = DB::fetch($query)) {
//	$mokuai_name = '';
//	$nav = array();
//	$mokuai_name = str_replace("yiqixueba_","",$row['skey']);
//	$mokuai_name = str_replace("_nav_menu","",$mokuai_name);
//	$nav = DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_mokuai')." WHERE mokuainame='".$mokuai_name."'");
////	$_G['setting']['navs'][] = array(
//		'navname' => $nav['mokuaititle'],
//		'filename' => 'plugin.php?id=yiqixueba&mokuaiid='.$nav['mokuaiid'],
//		'available' => intval($row['svalue']),
//		'navid' => 'mn_'.$mokuai_name,
//		'level' => 0,
//		'nav' => 'id="mn_'.$mokuai_name.'" ><a href="plugin.php?id=yiqixueba&mokuaiid='.$nav['mokuaiid'].'" hidefocus="true" title="'.$mokuai_name.'"  >'.$nav['mokuaititle'].'<span>'.$mokuai_name.'</span></a',
//	);
//}
//
////$_G['mnid'] = 'mn_'.$mokuai_info['mokuainame'];

$template_file = in_array($submod,array('baidumap','ajax')) ? 'yiqixueba/default/'.$submod : 'yiqixueba/'.$thistemplate.'/'.$submod;

if (!file_exists(DISCUZ_ROOT.'source/plugin/yiqixueba/template/'.$template_file.'.htm')){
	copy(DISCUZ_ROOT.'source/plugin/yiqixueba/template/yiqixueba/'.$thistemplate.'/main.htm',DISCUZ_ROOT.'source/plugin/yiqixueba/template/'.$template_file.'.htm');
}



$mod_file = DISCUZ_ROOT.'source/plugin/yiqixueba/module/'.$submod.'.inc.php';
if (!file_exists($mod_file)){
	file_put_contents($mod_file, "<?php\n\n/**\n*\t一起学吧平台程序\n*\t文件名：".$submod.".inc.php  创建时间：".dgmdate(time(),'dt')."  杨文\n*\n*/\n\nif(!defined('IN_DISCUZ')) {\n\texit('Access Denied');\n}\ninclude template('yiqixueba:'.\$template_file);\n?>");
}


require_once $mod_file;


//include template('yiqixueba:'.$template_file);

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

//include template('yiqixueba:yiqixueba/'.$thistemplate.'/main');

?>