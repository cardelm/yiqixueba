<?php

/**
*	卡益联盟服务端函数集
*	文件名function.func.php 创建时间2013-7-26 14:39 杨文
*	修改时间：2013-7-26 14:55 杨文
*/



update_github();
//用于github同步的程序并更新修改时间
function update_github($path=''){
	global $_G;
	clearstatcache();
	if($path=='')
		$path = 'C:\GitHub\yiqixueba';//本地的GitHub文件夹

	$out_path = substr(DISCUZ_ROOT,0,-1).str_replace("C:\GitHub\yiqixueba","",$path);////本地的wamp的discuz文件夹

	if ($handle = opendir($path)) {
		while (false !== ($file = readdir($handle))) {

			if ($file != "." && $file != ".." && substr($file,0,1) != ".") {
				if (is_dir($path."/".$file)) {
					if (!is_dir($out_path."/".$file)){
						dmkdir($out_path."/".$file);
					}
					update_github($path."/".$file);
				}else{
					if (filemtime($path."/".$file)  > filemtime($out_path."/".$file)){////GitHub文件修改时间大于wamp时
						if(substr($file,-4)=='.php'){//只修改文件扩展名为php的
							$old_row_text = $new_row_text = array();
							$file_text = file_get_contents($path."/".$file);
							$old_row_text = explode("\n",$file_text);
							$chuangjian_text =  "*\t文件名：".$file." 创建时间：".dgmdate(time(),'dt')."  杨文\r";
							$zhushi_text =  "*\t修改时间：".dgmdate(time(),'dt')." 杨文\r";
							if(stripos($old_row_text[2],"/**\r")===false &&  stripos($old_row_text[6],"*/\r")===false){
								$new_row_text[0] = "<?php\r";
								$new_row_text[1] = "\r";
								$new_row_text[2] = "/**\r";
								$new_row_text[3] = "*\t\r";
								$new_row_text[4] = $_G['charset'] == 'utf-8' ? $chuangjian_text : diconv($chuangjian_text,"GBK", "UTF-8//IGNORE");
								$new_row_text[5] = $_G['charset'] == 'utf-8' ? $zhushi_text : diconv($zhushi_text,"GBK", "UTF-8//IGNORE");
								$new_row_text[6] = "*/\r";
								$new_row_text[7] = "\r";
								for($i=1;$i<count($old_row_text) ;$i++ ){
									$new_row_text[] = $old_row_text[$i];
								}

							}else{
								$old_row_text[5] = $_G['charset'] == 'utf-8' ? $zhushi_text : diconv($zhushi_text,"GBK", "UTF-8//IGNORE");
								for($i=0;$i<count($old_row_text) ;$i++ ){
									$new_row_text[] = $old_row_text[$i];
								}
							}
							file_put_contents ($path."/".$file,implode("\n",$new_row_text));
						}
						$write_text = $_G['charset'] == 'utf-8' && stripos($file,'.lang.php') ? file_get_contents($path."/".$file) : diconv(file_get_contents($path."/".$file),"UTF-8", "GBK//IGNORE");
						file_put_contents ($out_path."/".$file,$write_text);
					}
				}
			}
		}
	}
}//func end

//生成从github上的模块目录和文件，只针对插件名称中含有yiqixueba_的插件
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
		$file_text = "<?php\n\n/**\n*\t".$plugin_info['name']."模块函数集\n*\t文件名：function.func.php 创建时间：".dgmdate(time(),'dt')."  杨文\n*\n*/\n\nif(!defined('IN_DISCUZ')) {\n\texit('Access Denied');\n}\n\n?>";
		file_put_contents($github_func_file,$_G['charset'] == 'utf-8' ? $file_text : diconv($file_text,"GBK", "UTF-8//IGNORE"));
	}
	$github_lang_file =  $github_dir.'/data/plugindata/'.$plugin_info['identifier'].'.lang.php';
	if(!file_exists($github_lang_file)){
		$file_text = "<?php\n\n/**\n*\t".$plugin_info['name']."语言包程序\n*\t文件名：".$plugin_info['identifier'].".lang.php 创建时间：".dgmdate(time(),'dt')."  杨文\n*\n*/\n\n\$scriptlang['".$plugin_info['identifier']."'] = array(\n\t'' => '',\n\t'' => '',\n);\n\n\$templatelang['".$plugin_info['identifier']."'] = array(\n\t'' => '',\n\t'' => '',\n);\n\n\$installlang['".$plugin_info['identifier']."'] = array(\n\t'' => '',\n\t'' => '',\n);\n\n\$systemlang['".$plugin_info['identifier']."'] = array(\n\t'file' => array(\n\t\t'' => '',\n\t\t'' => '',\n\t),\n);\n\n\n?>";
		file_put_contents($github_lang_file,$_G['charset'] == 'utf-8' ? $file_text : diconv($file_text,"GBK", "UTF-8//IGNORE"));
	}
	$plugin_modules = dunserialize($plugin_info['modules']);
	foreach( $plugin_modules as $k=>$v ){
		if(in_array($v['type'],array(3))){
			//后台文件
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
			//生成后台通用文件
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
				"\t\tshowsubtitle(array('', lang('plugin/".$plugin_info['identifier']."','ico'),lang('plugin/".$plugin_info['identifier']."','".$v['name']."name'), lang('plugin/".$plugin_info['identifier']."','displayorder'), lang('plugin/".$plugin_info['identifier']."','status'), ''));\n".
				"\t\t\$query = DB::query(\"SELECT * FROM \".DB::table('".$plugin_info['identifier']."_".$v['name']."').\" order by displayorder asc\");\n".
				"\t\twhile(\$row = DB::fetch(\$query)) {\n".
				"\t\t\t\$".$v['name']."ico = '';\n".
				"\t\t\tif(\$row['".$v['name']."ico']!='') {\n".
				"\t\t\t\t\$".$v['name']."ico = str_replace('{STATICURL}', STATICURL, \$row['".$v['name']."ico']);\n".
				"\t\t\t\tif(!preg_match(\"/^\".preg_quote(STATICURL, '/').\"/i\", \$".$v['name']."ico) && !((\$valueparse = parse_url(\$".$v['name']."ico)) && isset(\$valueparse['host']))) {\n".
				"\t\t\t\t\t\$".$v['name']."ico = \$_G['setting']['attachurl'].'common/'.\$row['".$v['name']."ico'].'?'.random(6);\n".
				"\t\t\t\t}\n".
				"\t\t\t}\n".
				"\t\t\tshowtablerow('', array('class=\"td25\"','style=\"width:45px\"', 'class=\"td23\"', 'class=\"td28\"'), array(\n".
				"\t\t\t\t\"<input class=\\\"checkbox\\\" type=\\\"checkbox\\\" name=\\\"delete[]\\\" value=\\\"\$row[".$v['name']."id]\\\">\",\n".
				"\t\t\t\t\$".$v['name']."ico ?'<img src=\"'.\$".$v['name']."ico.'\" width=\"40\" height=\"40\" align=\"left\" style=\"margin-right:5px\" />' : '',\n".
				"\t\t\t\t\$row['".$v['name']."name'],\n".
				"\t\t\t\t\"<input type=\\\"text\\\" name=\\\"displayordernew[\".\$row['".$v['name']."id'].\"]\\\" value=\\\"\".\$row['displayorder'].\"\\\"  size=\\\"2\\\">\",\n".
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
				"\t\tif(\$".$v['name']."_info['".$v['name']."ico']!='') {\n".
				"\t\t\t\$".$v['name']."ico = str_replace('{STATICURL}', STATICURL, \$".$v['name']."_info['".$v['name']."ico']);\n".
				"\t\t\tif(!preg_match(\"/^\".preg_quote(STATICURL, '/').\"/i\", \$".$v['name']."ico) && !((\$valueparse = parse_url(\$".$v['name']."ico)) && isset(\$valueparse['host']))) {\n".
				"\t\t\t\t\$".$v['name']."ico = \$_G['setting']['attachurl'].'common/'.\$".$v['name']."_info['".$v['name']."ico'].'?'.random(6);\n".
				"\t\t\t\t\$".$v['name']."icohtml = '<br /><label><input type=\"checkbox\" class=\"checkbox\" name=\"delete1\" value=\"yes\" /> '.\$lang['del'].'</label><br /><img src=\"'.\$".$v['name']."ico.'\" width=\"40\" height=\"40\"/>';\n".
				"\t\t\t}\n".
				"\t\t}\n".
				"\t\tshowtips(lang('plugin/".$plugin_info['identifier']."','".$v['name']."_edit_tips'));\n".
				"\t\tshowformheader(\$this_page.'&subac=".$v['name']."edit','enctype');\n".
				"\t\tshowtableheader(lang('plugin/".$plugin_info['identifier']."','".$v['name']."_edit'));\n".
				"\t\t\$".$v['name']."id ? showhiddenfields(array('".$v['name']."id'=>\$".$v['name']."id)) : '';\n".
				"\t\tshowsetting(lang('plugin/".$plugin_info['identifier']."','".$v['name']."ico'),'".$v['name']."ico',\$".$v['name']."_info['".$v['name']."ico'],'filetext','',0,lang('plugin/".$plugin_info['identifier']."','".$v['name']."ico_comment').\$".$v['name']."icohtml,'','',true);\n".
				"\t\tshowsetting(lang('plugin/".$plugin_info['identifier']."','".$v['name']."name'),'".$v['name']."_info[".$v['name']."name]',\$".$v['name']."_info['".$v['name']."name'],'text','',0,lang('plugin/".$plugin_info['identifier']."','".$v['name']."name_comment'),'','',true);\n".
				"\t\tshowsubmit('submit');\n".
				"\t\tshowtablefooter();\n".
				"\t\tshowformfooter();\n".
				"\t}else{\n".
				"\t\tif(!htmlspecialchars(trim(\$_GET['".$v['name']."_info']['".$v['name']."name']))) {\n".
				"\t\t\tcpmsg(lang('plugin/".$plugin_info['identifier']."','".$v['name']."name_nonull'));\n".
				"\t\t}\n".
				"\t\t\$".$v['name']."ico = addslashes(\$_POST['".$v['name']."ico']);\n".
				"\t\tif(\$_FILES['".$v['name']."ico']) {\n".
				"\t\t\t\$upload = new discuz_upload();\n".
				"\t\t\tif(\$upload->init(\$_FILES['".$v['name']."ico'], 'common') && \$upload->save()) {\n".
				"\t\t\t\t\$".$v['name']."ico = \$upload->attach['attachment'];\n".
				"\t\t\t}\n".
				"\t\t}\n".
				"\t\tif(\$_POST['delete1'] && addslashes(\$_POST['".$v['name']."ico'])) {\n".
				"\t\t\t\$valueparse = parse_url(addslashes(\$_POST['".$v['name']."ico']));\n".
				"\t\t\tif(!isset(\$valueparse['host']) && !strexists(addslashes(\$_POST['".$v['name']."ico']), '{STATICURL}')) {\n".
				"\t\t\t\t@unlink(\$_G['setting']['attachurl'].'temp/'.addslashes(\$_POST['".$v['name']."ico']));\n".
				"\t\t\t}\n".
				"\t\t\t\$".$v['name']."ico = '';\n".
				"\t\t}\n".
				"\t\t\$datas = \$_GET['".$v['name']."_info'];\n".
				"\t\t\$datas['".$v['name']."ico'] = \$".$v['name']."ico;\n".
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

//得到指定模块的语言包数组
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
//得到模块的文件列表数组
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
//写语言包文件
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
			$edit_text = "*\t创建时间：".dgmdate(time(),'dt');
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