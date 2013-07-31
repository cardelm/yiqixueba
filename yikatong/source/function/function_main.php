<?php
/**
 *      [yikatong!] (C)2012-2099 YiQiXueBa.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: function_main.php 24411 2012-09-17 05:09:03Z yangwen $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
//
function changtext($data,$in_charset='GBK',$out_charset='utf-8'){
	if(is_array($data)){
		foreach ( $data as $key=>$value ){
			$outdata[$key] = iconv($in_charset, $out_charset, $value);
		}
	}else{
		$outdata = iconv($in_charset, $out_charset, $data);
	}
	return $outdata;

}

//
function urlsubmit($data,$type) {
		$sitestr = serialize($data);

		$sitestr=base64_encode($sitestr);

		$reg_url = 'http://www.17xue8.cn/xueba.php?mod=api&type='.$type.'&charset='.$install_data['site_charset'].'&data='.$sitestr.'&sign='.md5(md5($sitestr));

		$output_text = file_get_contents($reg_url);

		$output_arr = unserialize($output_text);
		return $output_arr;
}//end func

//
function appapi_chk() {
	global $_G;
	$get_key_data['pluginidentifier']='yikatong';
	$get_key_data['site_url']=$_G['siteurl'];
	$sitestr = serialize($get_key_data);
	$sitestr=base64_encode($sitestr);
	$reg_url = 'http://www.17xue8.cn/plugincp.php?mod=getkey&data='.$sitestr.'&sign='.md5(md5($sitestr));
	$api_key_url = file_get_contents($reg_url);
	$output_arr = unserialize($api_key_url);
	$api_key = DB::result_first("SELECT svalue FROM ".DB::table('common_setting')." WHERE skey='yikatong_api_key'");
	if($output_arr['api_key']==$api_key&&$output_arr['api_key']!=false) {
		return true;
	}
	return false;

}//end func





//
function getCategories_1($tablename) {
	$categories = array();
	$query = DB::query("SELECT * FROM ".DB::table($tablename)." WHERE  level = 0 and type='shop' order by displayorder asc");
	while($row = DB::fetch($query)) {
		$categories[]=$row;
	}
	return $categories;
}//end func
//
function getCategories_2($tablename,$fuid='') {
	$categories = array();
	$query = DB::query("SELECT * FROM ".DB::table($tablename)." WHERE  upid = 0 and type='shop' order by displayorder asc");
	$key = 0;
	while($row = DB::fetch($query)) {
		$categories[$key]=$row;
		$query1 = DB::query("SELECT * FROM ".DB::table($tablename)." WHERE  type='shop' and upid=".$row['catid']." order by displayorder asc");
		$key1 = 0;
		while($row1 = DB::fetch($query1)) {
			$categories[$key]['subcat'][$key1]=$row1;
			$categories[$key]['subcat'][$key1]['subcatid']=$row1['catid'];
			$key1++;
		}
		$key++;
	}
	return $categories;
}//end func


//
function getDzdata() {
	$dztables = array();
	$discuz_tables = fetchtablelist('pre_');
	foreach($discuz_tables as $table) {
		$dztables[$table['Name']] = $table['Name'];
	}
	return $dztables;
}//end func




function fetchtablelist($tablepre = '') {
	global $db;
	$arr = explode('.', $tablepre);
	$dbname = $arr[1] ? $arr[0] : '';
	$tablepre = str_replace('_', '\_', $tablepre);
	$sqladd = $dbname ? " FROM $dbname LIKE '$arr[1]%'" : "LIKE '$tablepre%'";
	$tables = $table = array();
	$query = DB::query("SHOW TABLE STATUS $sqladd");
	while($table = DB::fetch($query)) {
		$table['Name'] = ($dbname ? "$dbname." : '').$table['Name'];
		$tables[] = $table;
	}
	return $tables;
}



//
function createPlugin($pluginname){
	//$pluginpath = DISCUZ_ROOT.'./source/plugin';
	//$file_start_text = "<?php\n\n/**\n *\t[Discuz!] (C)2012-2099 YiQiXueBa\n *\tThis is NOT a freeware, use is subject to license terms\n *\n *\t\$Id: ".$filename." ".date('Y-m-d H:i:s')." ".$zuozhe." \$\n*/\n\n";

}//end func



//更新程序调试阶段用
function file_chk($path='') {
	clearstatcache();
	if($path=='') 
		$path = DISCUZ_ROOT.'source/plugin/yiqixueba_exam/template/default';
		if ($handle = opendir($path)) {
		while (false !== ($file = readdir($handle))) {
			if ($file != "." && $file != "..") {
				if (is_dir($path."/".$file)) {
					file_chk($path."/".$file); 
				}else{
					if(substr($file,-7)=='tpl.php'){
						rename($path."/".$file,$path."/".str_replace('tpl.php','htm',$file)) ;
						echo str_replace('tpl.php','htm',$file).'<br>';
					}
				}
			}
		}
	}
	return ;
}


?>