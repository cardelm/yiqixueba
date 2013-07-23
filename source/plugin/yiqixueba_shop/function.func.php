<?php

/**
*	商家展示函数集程序
*	文件名：function.func.php 创建时间：2013-7-23 09:16  杨文
*
*/

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
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