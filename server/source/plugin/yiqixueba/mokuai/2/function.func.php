<?php
update_github();
//用于github同步的程序并更新edittime
function update_github($path=''){
	global $_G;
	clearstatcache();
	$utf8_files = array('install.php');
	$input_path = $_G['charset'] == 'utf-8' ? 'C:\GitHub\yiqixueba\server' : 'C:\GitHub\yiqixueba\client';//本地的GitHub文件夹
	if($path=='')
		$path = $input_path;

	$out_path = substr(DISCUZ_ROOT,0,-1).str_replace($input_path,"",$path);////本地的wamp的discuz文件夹

	if ($handle = opendir($path)) {
		while (false !== ($file = readdir($handle))) {

			if ($file != "." && $file != ".." && substr($file,0,1) != ".") {
				if (is_dir($path."/".$file)) {
					if (!is_dir($out_path."/".$file)){
						dmkdir($out_path."/".$file);
					}
					update_github($path."/".$file);
				}else{
					if (filemtime($path."/".$file)  > filemtime($out_path."/".$file)){////GitHub文件edittime大于wamp时
						$write_text = ($_G['charset'] == 'utf-8' && stripos($file,'.lang.php') || $_G['charset'] == 'utf-8' && in_array($file,$utf8_files)) ? file_get_contents($path."/".$file) : diconv(file_get_contents($path."/".$file),"UTF-8", "GBK//IGNORE");
						file_put_contents ($out_path."/".$file,$write_text);
					}
				}
			}
		}
	}
}//func end



//浏览器友好的变量输出
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
//
function make_mokuai($mokuaiid,$type=''){
	$mokuai_info = DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_server_mokuai')." WHERE mokuaiid=".$mokuaiid);
	$mokuai_dir = 'C:\GitHub\yiqixueba\server\source\plugin\yiqixueba\mokuai/'.$mokuaiid;
	if(!is_dir($mokuai_dir)){
		dmkdir($mokuai_dir);
	}
	if(!is_dir($mokuai_dir.'/page')){
		dmkdir($mokuai_dir.'/page');
	}
	$base_files = array('function.func.php','api.inc.php','install.php','uninstall.php');
	foreach($base_files as $k=>$v ){
		if(!file_exists($mokuai_dir.'/'.$v)){
			file_put_contents ($mokuai_dir.'/'.$v,"<?php\n\n?>");
		}
	}
	$modules_array = dunserialize($mokuai_info['modules']);
	foreach($modules_array as $k=>$v ){
		if($v['type'] == 3){
			$page_file = 'admincp_'.$v['name'];
		}
		if(!file_exists($mokuai_dir.'/page/'.$page_file.'.php')){
			file_put_contents ($mokuai_dir.'/page/'.$page_file.'.php',"<?php\nif(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {\n\texit('Access Denied');\n}\n\n\$this_page = substr(\$_SERVER['QUERY_STRING'],7,strlen(\$_SERVER['QUERY_STRING'])-7);\nstripos(\$this_page,'subop=') ? \$this_page = substr(\$this_page,0,stripos(\$this_page,'subop=')-1) : \$this_page;\n\n\$subop = getgpc('subop');\n\$subops = array('list','edit');\n\$subop = in_array(\$subop,\$subops) ? \$subop : \$subops[0];\n?>");
		}
	}
}







//
function refresh_plugin($plugininfo){
	//$mokuai_dir = DISCUZ_ROOT.'source/plugin/yiqixueba_server/mokuai/'.;
	$mokuai_info = $mokuai_setting = array();
	$mokuai_info = $plugininfo;
	$mokuai_info['identifier'] = str_replace("yiqixueba_","",$plugininfo['identifier']);
	$query = DB::query("SELECT * FROM ".DB::table('common_pluginvar')." WHERE pluginid = ".$plugininfo['pluginid']." order by displayorder asc");
	while($row = DB::fetch($query)) {
		$mokuai_setting[] = $row;
	}
	$mokuai_info['setting'] = serialize($mokuai_setting);

	if(DB::result_first("SELECT count(*) FROM ".DB::table('yiqixueba_server_mokuai')." WHERE identifier='".$mokuai_info['identifier']."' AND version ='".$plugininfo['version']."'")==0){
		$mokuai_info['available'] = 1;
		$mokuai_info['createtime'] = time();
		DB::insert('yiqixueba_server_mokuai', $mokuai_info);
	}else{
		$mokuai_info['updatetime'] = time();
		unset($mokuai_info['available']);
		DB::update('yiqixueba_server_mokuai', $mokuai_info,array('identifier'=>$mokuai_info['identifier'],'version'=>$plugininfo['version']));
	}
}//end func

?>