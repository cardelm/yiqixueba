<?php
/**
 *      一起学吧客户端程序
 *		后台控制程序
 *      $Id: admin.php 2013-05-28 22:27:03Z yangwen $
 */
require_once DISCUZ_ROOT.'/source/plugin/yiqixueba/function.php';
require_once DISCUZ_ROOT.'/source/plugin/yiqixueba/install.php';
require_once DISCUZ_ROOT.'/source/plugin/yiqixueba/lang.php';

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
////////////////
//if ($sock = fsockopen('http://www.wxq123.com', 80)){
//   fputs($sock, "HEAD /something.html HTTP/1.0\r\n\r\n");
//
//   while(!feof($sock)) {
//       echo fgets($sock);
//    }
//}

/////////////////////////
$submod = getgpc('submod');

//读取客户端的设置
$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_setting'));
while($row = DB::fetch($query)) {
	$plugin_setting[$row['skey']] = $row['svalue'];
}
$sitekey = $plugin_setting['sitekey'];
//var_dump($sitekey);
$indata = array();
$admin_menu_temp = api_indata('getadminmenu',$indata);
//var_dump($admin_menu_temp);
if($debug) {
	$admin_menu = api_indata('getadminmenu',$indata);
}else{
	$admin_menu = array();
	$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_menu')." WHERE menutype='admin' and upid = 0 order by displayorder asc");
	$k = 0;
	while($row = DB::fetch($query)) {

		$next_num = DB::result_first("SELECT count(*) FROM ".DB::table('yiqixueba_menu')." WHERE upid=".$row['menuid']);
		if ($next_num){
			$submods = $submenus = array();
			$kk = 0;
			$query1 = DB::query("SELECT * FROM ".DB::table('yiqixueba_menu')." WHERE upid=".$row['menuid']." order by displayorder asc");
			$current_menu = '';
			while($row1 = DB::fetch($query1)) {
				if ( $k == 0 && $kk == 0 && empty($submod) ){
					$submod = $row['menuname'].'_'.$row1['menuname'];
				}
				if ($submod == $row['menuname'].'_'.$row1['menuname']){
					$current_menu = $row1['menutitle'];
					$current_group = $row['menuname'];
				}
				$submods[] = $current_group.'_'.$row1['menuname'];
				$submenus[] = array($row1['menutitle'],'plugins&identifier=yiqixueba&pmod=admin&submod='.$row['menuname'].'_'.$row1['menuname'],$submod == $current_group.'_'.$row1['menuname']);
				$kk++;
			}
			$admin_menu[] = array(array('menu'=>$current_menu  ? $current_menu  : $row['menutitle'],'submenu'=>$submenus),$current_group == $row['menuname']);
		}else{
			if ($k == 0 && empty($submod)){
				$submod = $row['menuname'];
			}
			$admin_menu[] = array($row['menutitle'],'plugins&identifier=yiqixueba&pmod=admin&submod='.$row['menuname'],$submod == $row['menuname']);
		}
		$k++;
	}

	//$plugin_setting = array();
	echo '<style>.floattopempty { height: 15px !important; height: auto; } </style>';
	showsubmenu($plugin['name'].' '.$plugin['version'],$admin_menu);

	$dir_array = array('admin','module','template','manage','page');
	foreach ( $dir_array as $k=>$v) {
		$dir = DISCUZ_ROOT.'source/plugin/yiqixueba/'.$v;
		if(!is_dir($dir)) {
			dmkdir($dir);
		}
	}
	$submod_file = DISCUZ_ROOT.'source/plugin/yiqixueba/admin/'.$submod.'.inc.php';
	if (!file_exists($submod_file)){
		$mysubmod = str_replace($current_group."_","",$submod);
		file_put_contents($submod_file, "<?php\n\n/**\n*\t一起学吧平台程序\n*\t文件名：".$submod.".inc.php  创建时间：".dgmdate(time(),'dt')."  杨文\n*\n*/\n\nif(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {\n\texit('Access Denied');\n}\n\$this_page = 'plugins&identifier=yiqixueba&pmod=admin&submod=".$submod."';\n\n".
		"\$subac = getgpc('subac');\n".
		"\$subacs = array('".$mysubmod."list','".$mysubmod."edit');\n".
		"\$subac = in_array(\$subac,\$subacs) ? \$subac : \$subacs[0];\n\n".
		"\$".$mysubmod."id = getgpc('".$mysubmod."id');\n".
		"\$".$mysubmod."_info = \$".$mysubmod."id ? DB::fetch_first(\"SELECT * FROM \".DB::table('yiqixueba_".$submod."').\" WHERE ".$mysubmod."id=\".\$".$mysubmod."id) : array();\n\n".
		"if(\$subac == '".$mysubmod."list') {\n".
		"\tif(!submitcheck('submit')) {\n".
		"\t\tshowtips(lang('plugin/yiqixueba','".$mysubmod."_list_tips'));\n".
		"\t\tshowformheader(\$this_page.'&subac=".$mysubmod."list');\n".
		"\t\tshowtableheader(lang('plugin/yiqixueba','".$mysubmod."_list'));\n".
		"\t\tshowsubtitle(array('', lang('plugin/yiqixueba','".$mysubmod."name'),lang('plugin/yiqixueba','shopnum'), lang('plugin/yiqixueba','".$mysubmod."quanxian'), lang('plugin/yiqixueba','status'), ''));\n".
		"\t\t//\$query = DB::query(\"SELECT * FROM \".DB::table('yiqixueba_".$submod."').\" order by ".$mysubmod."id asc\");\n".
		"\t\t//while(\$row = DB::fetch(\$query)) {\n".
		"\t\t\tshowtablerow('', array('class=\"td25\"','class=\"td23\"', 'class=\"td23\"', 'class=\"td23\"','class=\"td25\"',''), array(\n".
		"\t\t\t\t\"<input class=\\\"checkbox\\\" type=\\\"checkbox\\\" name=\\\"delete[]\\\" value=\\\"\$row[".$mysubmod."id]\\\">\",\n".
		"\t\t\t\$row['".$mysubmod."name'],\n".
		"\t\t\t\$row['".$mysubmod."name'],\n".
		"\t\t\t\$row['".$mysubmod."name'],\n".
		"\t\t\t\"<input class=\\\"checkbox\\\" type=\\\"checkbox\\\" name=\\\"statusnew[\".\$row['".$mysubmod."id'].\"]\\\" value=\\\"1\\\" \".(\$row['status'] > 0 ? 'checked' : '').\">\",\n".
		"\t\t\t\t\"<a href=\\\"\".ADMINSCRIPT.\"?action=\".\$this_page.\"&subac=".$mysubmod."edit&".$mysubmod."id=\$row[".$mysubmod."id]\\\" class=\\\"act\\\">\".lang('plugin/yiqixueba','edit').\"</a>\",\n".
		"\t\t\t));\n".
		"\t\t//}\n".
		"\t\techo '<tr><td></td><td colspan=\"6\"><div><a href=\"'.ADMINSCRIPT.'?action='.\$this_page.'&subac=".$mysubmod."edit\" class=\"addtr\">'.lang('plugin/yiqixueba','add_".$mysubmod."').'</a></div></td></tr>';\n".
		"\t\tshowsubmit('submit','submit','del');\n".
		"\t\tshowtablefooter();\n".
		"\t\tshowformfooter();\n".
		"\t}else{\n".
		"\t}\n".
		"}elseif(\$subac == '".$mysubmod."edit') {\n".
		"\tif(!submitcheck('submit')) {\n".
		"\t\tshowtips(lang('plugin/yiqixueba','".$mysubmod."_edit_tips'));\n".
		"\t\tshowformheader(\$this_page.'&subac=".$mysubmod."edit','enctype');\n".
		"\t\tshowtableheader(lang('plugin/yiqixueba','".$mysubmod."_edit'));\n".
		"\t\t\$".$mysubmod."id ? showhiddenfields(array('".$mysubmod."id'=>\$".$mysubmod."id)) : '';\n".
		"\t\tshowsetting(lang('plugin/yiqixueba','".$mysubmod."name'),'".$mysubmod."_info[".$mysubmod."name]',\$".$mysubmod."_info['".$mysubmod."name'],'text','',0,lang('plugin/yiqixueba','".$mysubmod."name_comment'),'','',true);\n".
		"\t\tshowsubmit('submit');\n".
		"\t\tshowtablefooter();\n".
		"\t\tshowformfooter();\n".
		"\t}else{\n".
		"\t\tif(!htmlspecialchars(trim(\$_GET['".$mysubmod."_info']['".$mysubmod."name']))) {\n".
		"\t\t\tcpmsg(lang('plugin/yiqixueba','".$mysubmod."name_nonull'));\n".
		"\t\t}\n".
		"\t\t\$datas = \$_GET['".$mysubmod."_info'];\n".
		"\t\tforeach ( \$datas as \$k=>\$v) {\n".
		"\t\t\t\$data[\$k] = htmlspecialchars(trim(\$v));\n".
		"\t\t\tif(!DB::result_first(\"describe \".DB::table('yiqixueba_".$submod."').\" \".\$k)) {\n".
		"\t\t\t\t\$sql = \"alter table \".DB::table('yiqixueba_".$submod."').\" add `\".\$k.\"` varchar(255) not Null;\";\n".
		"\t\t\t\trunquery(\$sql);\n".
		"\t\t\t}\n".
		"\t\t}\n".
		"\t\tif(\$".$mysubmod."id) {\n".
		"\t\t\tDB::update('yiqixueba_".$submod."',\$data,array('".$mysubmod."id'=>\$".$mysubmod."id));\n".
		"\t\t}else{\n".
		"\t\t\tDB::insert('yiqixueba_".$submod."',\$data);\n".
		"\t\t}\n".
		"\t\tcpmsg(lang('plugin/yiqixueba', '".$mysubmod."_edit_succeed'), 'action='.\$this_page.'&subac=".$mysubmod."list', 'succeed');\n".
		"\t}\n".
		"}\n".
		"\n".
		"?>");
	}
	require_once $submod_file;
}


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
//升级模块商家信息
function update_shopinfo($mokuai){
	$mokuai_setting = get_mokuai_setting($mokuai);
	$mokuai_fields = dunserialize($mokuai_setting['yiqixueba_'.$mokuai.'_fields']);
	if(!$mokuai_fields['shopid']){
		return false;
	}else{
		$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_'.$mokuai.'_shop'));
		while($row = DB::fetch($query)) {
			$updata = array();
			foreach ( $mokuai_fields as $k => $v ){
				if($k!='shopid'){
					$updata[$k] = DB::result_first("SELECT ".$v." FROM ".DB::table($mokuai_setting['yiqixueba_'.$mokuai.'_shop_table'])." WHERE shopid=".$row['oldshopid']);
				}
			}
			DB::update('yiqixueba_'.$mokuai.'_shop', $updata,array('shopid'=>$row['shopid']));
		}
	}
}//end func
//
function get_mokuai_setting($mokuai){
	$mokuai_setting = array();
	$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_setting')." WHERE skey like 'yiqixueba_".$mokuai."%'");
	while($row = DB::fetch($query)) {
		$mokuai_setting[$row['skey']] = $row['svalue'];
	}
	return $mokuai_setting;
}//end func
?>
