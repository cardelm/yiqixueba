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
	$tablepre = $_G['config']['db'][1]['tablepre'];

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
		$file_text = "<?php\n\n/**\n*\t".$plugin_info['name']."语言包\n*\t文件名：".$plugin_info['identifier'].".lang.php 创建时间：".dgmdate(time(),'dt')."  杨文\n*\n*/\n\n\$scriptlang['".$plugin_info['identifier']."'] = array(\n\t'' => '',\n\t'' => '',\n);\n\n\$templatelang['".$plugin_info['identifier']."'] = array(\n\t'' => '',\n\t'' => '',\n);\n\n\$installlang['".$plugin_info['identifier']."'] = array(\n\t'' => '',\n\t'' => '',\n);\n\n\$systemlang['".$plugin_info['identifier']."'] = array(\n\t'file' => array(\n\t\t'' => '',\n\t\t'' => '',\n\t),\n);\n\n\n?>";
		file_put_contents($github_lang_file,$_G['charset'] == 'utf-8' ? $file_text : diconv($file_text,"GBK", "UTF-8//IGNORE"));
	}
	$plugin_modules = dunserialize($plugin_info['modules']);
	foreach( $plugin_modules as $k=>$v ){
		if(in_array($v['type'],array(3))){
			//数据表
			$plugin_tablename = $tablepre.$plugin_info['identifier']."_".$v['name'];
			$dztables = array();
			$discuz_tables = fetchtablelist($tablepre.$plugin_info['identifier']);
			foreach($discuz_tables as $table) {
				$dztables[$table['Name']] = $table['Name'];
			}
			if(!in_array($plugin_tablename,$dztables)){
				$create_sql = "CREATE TABLE `".$plugin_tablename."` (\n`".$v['name']."id` mediumint(8) unsigned NOT NULL auto_increment,\n`".$v['name']."name` char(40) NOT NULL,\n`displayorder` mediumint(8) NOT NULL,\nPRIMARY KEY  (`".$v['name']."id`)\n)ENGINE=MyISAM;";
				runquery($create_sql);
			}
			//创建新的数据表结束
			$github_file = $plugin_dir.$v['name'].'.inc.php';
			if(!file_exists($github_file)){
				$file_text = "<?php\n\n/**\n*\t".$plugin_info['name']."-".$v['menu']."程序\n*\t文件名：".$v['name'].'.inc.php'." 创建时间：".dgmdate(time(),'dt')."  杨文\n*\n*/\n\nif(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {\n\texit('Access Denied');\n}\n\nrequire_once DISCUZ_ROOT.'source/plugin/".$plugin_info['directory']."function.func.php';\n\n".
				"\$this_page = substr(\$_SERVER['QUERY_STRING'],7,strlen(\$_SERVER['QUERY_STRING'])-7);\n".
				"stripos(\$this_page,'subac=') ? \$this_page = substr(\$this_page,0,stripos(\$this_page,'subac=')-1) : \$this_page;\n\n".
				"\$subac = getgpc('subac');\n".
				"\$subacs = array('".$v['name']."list','".$v['name']."edit');\n".
				"\$subac = in_array(\$subac,\$subacs) ? \$subac : \$subacs[0];\n\n".
				"\$".$v['name']."id = getgpc('".$v['name']."id');\n".
				"\$".$v['name']."_info = \$".$v['name']."id ? DB::fetch_first(\"SELECT * FROM \".DB::table('".$plugin_info['identifier']."_".$v['name']."').\" WHERE ".$v['name']."id=\".\$".$v['name']."id) : array();\n\n".
				"if(\$subac == '".$v['name']."list') {\n".
				"\tif(!submitcheck('submit')) {\n".
				"\t\tshowtips(lang('plugin/".$plugin_info['identifier']."','".$v['name']."_list_tips'));\n".
				"\t\tshowformheader(\$this_page.'&subac=".$v['name']."list');\n".
				"\t\tshowtableheader(lang('plugin/".$plugin_info['identifier']."','".$v['name']."_list'));\n".
				"\t\t\$query = DB::query(\"SELECT * FROM \".DB::table('".$plugin_info['identifier']."_".$v['name']."').\" order by displayorder asc\");\n".
				"\t\twhile(\$row = DB::fetch(\$query)) {\n".
				"\t\t\tshowtablerow('', array('class=\"td25\"', 'class=\"td23\"', 'class=\"td28\"'), array(\n".
				"\t\t\t\t\"<input class=\\\"checkbox\\\" type=\\\"checkbox\\\" name=\\\"delete[]\\\" value=\\\"\$row[".$v['name']."id]\\\">\",\n".
				"\t\t\t\t\$row['".$v['name']."name'],\n".
				"\t\t\t\t\"<input class=\\\"checkbox\\\" type=\\\"checkbox\\\" name=\\\"statusnew[\".\$row['".$v['name']."id'].\"]\\\" value=\\\"1\\\" \".(\$row['status'] > 0 ? 'checked' : '').\">\",\n".
				"\t\t\t\t\"<a href=\\\"\".ADMINSCRIPT.\"?action=\".\$this_page.\"&subac=".$v['name']."edit&".$v['name']."id=\$row[".$v['name']."id]\\\" class=\\\"act\\\">\".lang('plugin/".$plugin_info['identifier']."','edit').\"</a>\",\n".
				"\t\t\t));\n".
				"\t\t}\n".
				"\techo '<tr><td></td><td colspan=\"6\"><div><a href=\"'.ADMINSCRIPT.'?action='.\$this_page.'&subac=".$v['name']."edit\" class=\"addtr\">'.lang('plugin/".$plugin_info['identifier']."','add_".$v['name']."').'</a></div></td></tr>';\n".
				"\tshowsubmit('submit','submit','del');\n".
				"\tshowtablefooter();\n".
				"\tshowformfooter();\n".
				"\t}else{\n".
				"\t}\n".
				"}elseif(\$subac == '".$v['name']."edit') {\n".
				"\tif(!submitcheck('submit')) {\n".
				"\t\tshowtips(lang('plugin/".$plugin_info['identifier']."','".$v['name']."_edit_tips'));\n".
				"\t\tshowformheader(\$this_page.'&subac=".$v['name']."edit','enctype');\n".
				"\t\tshowtableheader(lang('plugin/".$plugin_info['identifier']."','".$v['name']."_edit'));\n".
				"\t\t\$".$v['name']."id ? showhiddenfields(array('".$v['name']."id'=>\$".$v['name']."id)) : '';\n".
				"\t\tshowsetting(lang('plugin/".$plugin_info['identifier']."','".$v['name']."name'),'".$v['name']."_info[".$v['name']."name]',\$".$v['name']."_info['".$v['name']."name'],'text','',0,lang('plugin/".$plugin_info['identifier']."','".$v['name']."name_comment'),'','',true);\n".
				"\t\tshowsubmit('submit');\n".
				"\t\tshowtablefooter();\n".
				"\t\tshowformfooter();\n".
				"\t}else{\n".
				"\t\tif(!htmlspecialchars(trim(\$_GET['".$v['name']."_info']['".$v['name']."name']))) {\n".
				"\t\t\tcpmsg(lang('plugin/".$plugin_info['identifier']."','".$v['name']."name_nonull'));\n".
				"\t\t}\n".
				"\t\t\$datas = \$_GET['".$v['name']."_info'];\n".
				"\t\tforeach ( \$datas as \$k=>\$v) {\n".
				"\t\t\t\$data[\$k] = htmlspecialchars(trim(\$v));\n".
				"\t\t\tif(!DB::result_first(\"describe \".DB::table('".$plugin_info['identifier']."_".$v['name']."').\" \".\$k)) {\n".
				"\t\t\t\t\$sql = \"alter table \".DB::table('".$plugin_info['identifier']."_".$v['name']."').\" add `\".\$k.\"` varchar(255) not Null;\";\n".
				"\t\t\t\trunquery(\$sql);\n".
				"\t\t\t}\n".
				"\t\t}\n".
				"\t\tif(\$".$v['name']."id) {\n".
				"\t\t\tDB::update('".$plugin_info['identifier']."_".$v['name']."',\$data,array('".$v['name']."id'=>\$".$v['name']."id));\n".
				"\t\t}else{\n".
				"\t\t\tDB::insert('".$plugin_info['identifier']."_".$v['name']."',\$data);\n".
				"\t\t}\n".
				"\t\tcpmsg(lang('plugin/".$plugin_info['identifier']."', '".$v['name']."_edit_succeed'), 'action='.\$this_page.'&subac=".$v['name']."list', 'succeed');\n".
				"\t}\n".
				"\t\n".
				"}\n".
				"?>";
				file_put_contents($github_file,$_G['charset'] == 'utf-8' ? $file_text : diconv($file_text,"GBK", "UTF-8//IGNORE"));
			}
		}
	}
}

//得到插件的文件内容的语言包数组
function get_plugin_lang($plugin_file){
	global  $scriptlang,$templatelang,$installlang,$systemlang,$plugin_info,$_G;
	$github_dir = "C:\GitHub\yiqixueba";
	$lang_file = $github_dir.'/data/plugindata/'.$plugin_info['identifier'].'.lang.php';
	require_once $lang_file;
	$plugin_lang = array();
	$file_text = file_get_contents($plugin_file);
	$temp_array1 = explode("lang('plugin/".$plugin_info['identifier']."','",$file_text);
	foreach($temp_array1 as $k=>$v ){
		if($k){
			$temp_array2 = explode("')",$v);
				$plugin_lang[] = array('en'=>$temp_array2[0],'cn'=>($_G['charset'] == 'utf-8' ? $scriptlang[$plugin_info['identifier']][$temp_array2[0]] : diconv($scriptlang[$plugin_info['identifier']][$temp_array2[0]],"UTF-8", "GBK//IGNORE")));
		}
	}
	return $plugin_lang;
}//func end
//采用递归的方式读取插件目录下的文件列表，并以数组形式输出
function get_plugin_file($path){
	global $_G,$pluginfile_array;
	clearstatcache();
	if ($handle = opendir($path)) {
		while (false !== ($file = readdir($handle))) {

			if ($file != "." && $file != ".." && $file != "index.html" && substr($file,0,1) != "." ) {
				if (is_dir($path.$file)) {
					get_plugin_file($path.$file);
				}else{
					$pluginfile_array[] = array('file'=>$path.$file);
				}
			}
		}
	}
	return $pluginfile_array;
}
//写入脚本语言包
function write_scriptlang_file($pluginid,$script_lang){
	global $scriptlang,$templatelang,$installlang,$systemlang,$_G;
	$github_dir = "C:\GitHub\yiqixueba";
	$plugin_info = DB::fetch_first("SELECT * FROM ".DB::table('common_plugin')." WHERE pluginid=".$pluginid);
	$lang_file = $github_dir.'/data/plugindata/'.$plugin_info['identifier'].'.lang.php';
	$file_text = file_get_contents($lang_file);
	$old_row_text = explode("\n",$file_text);
	foreach($old_row_text as $k=>$v ){
		if(stripos($v,$plugin_info['identifier'].'.lang.php')){
			$edit_h = $k;
		}
	}
	for($i=0;$i<$edit_h+3 ; $i++){
		$new_row_array[$i] = $old_row_text[$i];
		if($i==$edit_h+1){
			$edit_text = "*\t修改时间：".dgmdate(time(),'dt');
			$new_row_array[$i] = $_G['charset'] == 'utf-8' ? $edit_text : diconv($edit_text,"GBK", "UTF-8//IGNORE");
		}
	}
	$new_row_text = implode("\n",$new_row_array);
	$new_row_text .= "\n";
	$new_row_text .= "\$scriptlang['".$plugin_info['identifier']."'] = array(\n";
	foreach($script_lang as $k=>$v ){
		$new_row_text .= $v ? "\t'".$k."' => '".($_G['charset'] == 'utf-8' ? $v : diconv($v,"GBK", "UTF-8//IGNORE"))."',\n" : "";
	}
	$new_row_text .= ");\n\n";
	$new_row_text .= "\$templatelang['".$plugin_info['identifier']."'] = array(\n";
	foreach($templatelang as $k=>$v ){
		$new_row_text .=  $v ? "\t'".$k."' => '".($_G['charset'] == 'utf-8' ? $v : diconv($v,"GBK", "UTF-8//IGNORE"))."',\n" : "";
	}
	$new_row_text .= ");\n\n";
	$new_row_text .= "\$installlang['".$plugin_info['identifier']."'] = array(\n";
	foreach($installlang as $k=>$v ){
		$new_row_text .=  $v ? "\t'".$k."' => '".($_G['charset'] == 'utf-8' ? $v : diconv($v,"GBK", "UTF-8//IGNORE"))."',\n" : "";
	}
	$new_row_text .= ");\n\n";
	//$new_row_text .= "\$systemlang['".$plugin_info['identifier']."'] = array(\n";
	//foreach($systemlang as $k=>$v ){
		//$new_row_text .= "\t'file' => array(\n";
		//foreach($v as $k1=>$v1 ){
			//$new_row_text .=  $v ? "\t\t'".$k1."' => '".($_G['charset'] == 'utf-8' ? $v1 : diconv($v1,"GBK", "UTF-8//IGNORE"))."',\n" : "";
		//}
		//$new_row_text .= "\t),\n";
	//}
	//$new_row_text .= ");\n\n";
	$new_row_text .= "?>";
	file_put_contents($lang_file,$new_row_text);
	return ;
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