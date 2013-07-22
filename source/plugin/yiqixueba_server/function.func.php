<?php

update_github();
//采用递归方式，自动更新discuz文件
function update_github($path=''){
	global $_G;
	clearstatcache();
	if($path=='')
		$path = 'C:\GitHub\yiqixueba';//本地的GitHub的discuz文件夹

	$out_path = substr(DISCUZ_ROOT,0,-1).str_replace("C:\GitHub\yiqixueba","",$path);//本地的wamp的discuz文件夹

	if ($handle = opendir($path)) {
		while (false !== ($file = readdir($handle))) {

			if ($file != "." && $file != ".." && substr($file,0,1) != ".") {
				if (is_dir($path."/".$file)) {
					if (!is_dir($out_path."/".$file)){
						dmkdir($out_path."/".$file);
					}
					update_github($path."/".$file);
				}else{
					if (filemtime($path."/".$file)  > filemtime($out_path."/".$file)){//GitHub文件修改时间大于wamp时
						file_put_contents ($out_path."/".$file,$_G['charset'] == 'utf-8' && stripos($file,'.lang.php') ? file_get_contents($path."/".$file) : diconv(file_get_contents($path."/".$file),"UTF-8", "GBK//IGNORE"));
					}
				}
			}
		}
	}
}//func end

//在github中自动生成yiqixueba_为开头的插件的文件
function make_plugin($pluginid){
	global $_G;
	$plugin_info = DB::fetch_first("SELECT * FROM ".DB::table('common_plugin')." WHERE pluginid=".$pluginid);
	$github_dir = "C:\GitHub\yiqixueba";
	$plugin_dir = $github_dir.'/source/plugin/'.$plugin_info['directory'];
	if(!is_dir($plugin_dir)){
		dmkdir($plugin_dir);
	}
	$github_func_file =  $plugin_dir.'function.func.php';
	if(!file_exists($github_func_file)){
		$file_text = "<?php\n\n/**\n*\t".$plugin_info['name']."函数集程序\n*\t文件名：function.func.php 创建时间：".dgmdate(time(),'dt')."  杨文\n*\n*/\n\nif(!defined('IN_DISCUZ')) {\n\texit('Access Denied');\n}\n\n?>";
		file_put_contents($github_func_file,$_G['charset'] == 'utf-8' ? $file_text : diconv($file_text,"GBK", "UTF-8//IGNORE"));
	}
	$github_lang_file =  $github_dir.'/data/plugindata/'.$plugin_info['identifier'].'.lang.php';
	if(!file_exists($github_lang_file)){
		$file_text = "<?php\n\n/**\n*\t".$plugin_info['name']."语言包\n*\t文件名：".$plugin_info['identifier'].".lang.php 创建时间：".dgmdate(time(),'dt')."  杨文\n*\n*/\n\n\$scriptlang['".$plugin_info['identifier']."'] = array(\n\t'' => '',\n\t'' => '',\n);\n\n\$templatelang['".$plugin_info['identifier']."'] = array(\n\t'' => '',\n\t'' => '',\n);\n\n\$installlang['".$plugin_info['identifier']."'] = array(\n\t'' => '',\n\t'' => '',\n);\n\n\$systemlang['".$plugin_info['identifier']."'] = array(\n\t'file' => array(\n\t\t'' => '',\n\t\t'' => '',\n);\n\n\n?>";
		file_put_contents($github_lang_file,$_G['charset'] == 'utf-8' ? $file_text : diconv($file_text,"GBK", "UTF-8//IGNORE"));
	}
	$plugin_modules = dunserialize($plugin_info['modules']);
	foreach( $plugin_modules as $k=>$v ){
		if(in_array($v['type'],array(1,3))){
		$plugin_tablename = $plugin_info['identifier']."_".$v['name'];
			$github_file = $plugin_dir.$v['name'].'.inc.php';
			if(!file_exists($github_file)){
				$file_text = "<?php\n\n/**\n*\t".$plugin_info['name']."-".$v['menu']."程序\n*\t文件名：".$v['name'].'.inc.php'." 创建时间：".dgmdate(time(),'dt')."  杨文\n*\n*/\n\nif(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {\n\texit('Access Denied');\n}\n\nrequire_once DISCUZ_ROOT.'source/plugin/".$plugin_info['directory']."function.func.php';\n?>";
				file_put_contents($github_file,$_G['charset'] == 'utf-8' ? $file_text : diconv($file_text,"GBK", "UTF-8//IGNORE"));
			}
			dump($plugin_tablename);
		}
	}
}
if(!function_exists('createtable')){
	function createtable($sql) {

		$type = strtoupper(preg_replace("/^\s*CREATE TABLE\s+.+\s+\(.+?\).*(ENGINE|TYPE)\s*=\s*([a-z]+?).*$/isU", "\\2", $sql));
		$type = in_array($type, array('MYISAM', 'HEAP', 'MEMORY')) ? $type : 'MYISAM';
		return preg_replace("/^\s*(CREATE TABLE\s+.+\s+\(.+?\)).*$/isU", "\\1", $sql).
		(mysql_get_server_info() > '4.1' ? " ENGINE=$type DEFAULT CHARSET=".DBCHARSET : " TYPE=$type");
	}
}

// 浏览器友好的变量输出
if(!function_exists('dump')){
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
}
?>