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
//api_api_indata
function api_indata($apiaction,$indata=array()){
	global $_G,$indata,$sitekey;
	if(fsockopen('www.wxq123.com', 80)){
		$indata['sitekey'] = $sitekey;
		$indata['siteurl'] = $_G['siteurl'];
		if($_G['charset']=='gbk') {
			foreach ( $indata as $k=>$v) {
				//$indata[$k] = diconv($v,$_G['charset'],'utf8');
			}
		}
		$indata = serialize($indata);
		$indata = base64_encode($indata);
		$api_url = 'http://www.wxq123.com/plugin.php?id=yiqixueba_server:api&apiaction='.$apiaction.'&indata='.$indata.'&sign='.md5(md5($indata));
		$xml = @file_get_contents($api_url);
		require_once libfile('class/xml');
		$outdata = is_array(xml2array($xml)) ? xml2array($xml) : $xml;
		return $outdata;
	}else{
		return false;
	}
}//end func
//
function get_page($submod){
	$submod_array = explode("_",$submod);
	$submod_file = DISCUZ_ROOT.'source/plugin/yiqixueba_'.$submod_array[0].'/'.$submod_array[1].'.inc.php';
	return $submod_file;
}//end func
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