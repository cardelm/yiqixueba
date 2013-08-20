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
?>