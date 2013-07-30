<?php

/**
*	一起学吧平台程序
*	文件名：main.inc.php  创建时间：2013-6-16 12:37  杨文
*
*/

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$tuisong = dunserialize($base_setting['index_tuisong']);
$tuisong = $tuisong ? $tuisong : array();
//幻灯片图片
$slideshowshops = array();
foreach ( $tuisong['huandeng'] as $k => $v ){
	$row = DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_brand_shop')." WHERE shopid=".$v);
	$shoplogo = '';
	if($row['shoplogo']!='') {
		$shoplogo = str_replace('{STATICURL}', STATICURL, $row['shoplogo']);
		if(!preg_match("/^".preg_quote(STATICURL, '/')."/i", $mokuaiico) && !(($valueparse = parse_url($shoplogo)) && isset($valueparse['host']))) {
			$shoplogo = $_G['setting']['attachurl'].'common/'.$row['shoplogo'].'?'.random(6);
		}
		$shoplogohtml = '<img src="'.$shoplogo.'" width="300" height="200"/>';
	}
	$shoplogo = $shoplogo ? $shoplogo : 'source/plugin/yiqixueba/template/yiqixueba/default/style/image/noshoplogo.jpg';
	$shoplogohtml = $shoplogo ? $shoplogohtml : '<img src="source/plugin/yiqixueba/template/yiqixueba/default/style/image/noshoplogo.jpg" width="300" height="200"/>';
	$slideshowshops[$k]['shoplogohtml'] = $shoplogohtml;
	$slideshowshops[$k]['shoplogo'] = $shoplogo;
	$slideshowshops[$k]['shopid'] = $row['shopid'];
	$slideshowshops[$k]['shopname'] = $row['shopname'];
}
//头条

$row = DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_brand_shop')." WHERE shopid=".intval($tuisong['toutiao'][0]));
$toutiao['title'] = $row['shopname'];
$toutiao['conment'] = cutstr($row['shopintroduction'], 90);
$toutiao['shopid'] = $row['shopid'];
//首页文本
$wenbenshops = array();
foreach ( $tuisong['wenben'] as $k => $v ){
	$row = DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_brand_shop')." WHERE shopid=".$v);
	$shoplogo = '';
	if($row['shoplogo']!='') {
		$shoplogo = str_replace('{STATICURL}', STATICURL, $row['shoplogo']);
		if(!preg_match("/^".preg_quote(STATICURL, '/')."/i", $mokuaiico) && !(($valueparse = parse_url($shoplogo)) && isset($valueparse['host']))) {
			$shoplogo = $_G['setting']['attachurl'].'common/'.$row['shoplogo'].'?'.random(6);
		}
		$shoplogohtml = '<img src="'.$shoplogo.'" width="300" height="200"/>';
	}
	$shoplogo = $shoplogo ? $shoplogo : 'source/plugin/yiqixueba/template/yiqixueba/default/style/image/noshoplogo.jpg';
	$shoplogohtml = $shoplogo ? $shoplogohtml : '<img src="source/plugin/yiqixueba/template/yiqixueba/default/style/image/noshoplogo.jpg" width="300" height="200"/>';
	$wenbenshops[$k]['shoplogohtml'] = $shoplogohtml;
	$wenbenshops[$k]['shoplogo'] = $shoplogo;
	$wenbenshops[$k]['shopid'] = $row['shopid'];
	$wenbenshops[$k]['shopname'] = $row['shopname'];
}//首页图文
$tuwenshops = array();
foreach ( $tuisong['tuwen'] as $k => $v ){
	$row = DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_brand_shop')." WHERE shopid=".$v);
	$shoplogo = '';
	if($row['shoplogo']!='') {
		$shoplogo = str_replace('{STATICURL}', STATICURL, $row['shoplogo']);
		if(!preg_match("/^".preg_quote(STATICURL, '/')."/i", $mokuaiico) && !(($valueparse = parse_url($shoplogo)) && isset($valueparse['host']))) {
			$shoplogo = $_G['setting']['attachurl'].'common/'.$row['shoplogo'].'?'.random(6);
		}
		$shoplogohtml = '<img src="'.$shoplogo.'" width="90" height="60"/>';
	}
	$shoplogo = $shoplogo ? $shoplogo : 'source/plugin/yiqixueba/template/yiqixueba/default/style/image/noshoplogo.jpg';
	$shoplogohtml = $shoplogo ? $shoplogohtml : '<img src="source/plugin/yiqixueba/template/yiqixueba/default/style/image/noshoplogo.jpg" width="300" height="200"/>';
	$tuwenshops[$k]['shoplogohtml'] = $shoplogohtml;
	$tuwenshops[$k]['shoplogo'] = $shoplogo;
	$tuwenshops[$k]['shopid'] = $row['shopid'];
	$tuwenshops[$k]['shopname'] = $row['shopname'];
}
//按钮图片
//处理按钮图片
$botton = $bottonhtml = array();
for($i=1;$i<5 ;$i++ ){
	$botton[$i-1] = '';
	if($base_setting['yiqixueba_brand_botton'.$i]!='') {
		$botton[$i-1] = str_replace('{STATICURL}', STATICURL, $base_setting['yiqixueba_brand_botton'.$i]);
		if(!preg_match("/^".preg_quote(STATICURL, '/')."/i", $botton[$i-1]) && !(($valueparse = parse_url($botton[$i-1])) && isset($valueparse['host']))) {
			$botton[$i-1] = $_G['setting']['attachurl'].'common/'.$base_setting['yiqixueba_brand_botton'.$i].'?'.random(6);
		}
	}else{
		$botton[$i-1] = 'source/plugin/yiqixueba/template/yiqixueba/default/style/image/button00'.$i.'.jpg';
	}
	$bottonhtml[$i-1] = '<img src="'.$botton[$i-1].'" width="145" height="30"/>';

}
//公告列表
$gonggaolist = array();
$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_brand_gonggao')." WHERE youxiaoqi > ".time()." AND status = 1 order by displayorder desc limit 0,4");
while($row = DB::fetch($query)) {
	$gonggaolist[] = $row;
}
//分类列表
$sort_list = array();
$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_brand_shopsort')." WHERE sortlevel = 1 order by displayorder asc");
$kk = 0 ;
while($row = DB::fetch($query)) {
	$sort_list[] = $row;
	$query1 = DB::query("SELECT * FROM ".DB::table('yiqixueba_brand_shop')." WHERE shopsort = ".$row['shopsortid']." order by shopid asc");
	while($row1 = DB::fetch($query1)) {
		$shop_sort_list[$kk]['shopname']=$row['shopname'];
		$kk++;
	}
}
//dump($sort_list);
//模块列表
$mokuailists = array();
$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_mokuai')." WHERE upmokuai = 'brand' order by displayorder asc");
while($row = DB::fetch($query)) {
	$mokuailists[] = $row;
	$sql = "DROP TABLE IF EXISTS `wxq_yiqixueba_brand_".$row['mokuainame']."`;\nCREATE TABLE `wxq_yiqixueba_brand_".$row['mokuainame']."` (\n\t`".$row['mokuainame']."id` mediumint(8) unsigned NOT NULL auto_increment,\n\t`".$row['mokuainame']."name` char(40) NOT NULL,\n\t`displayorder` mediumint(8) NOT NULL,\n\t`status` tinyint(1) NOT NULL,\n\tPRIMARY KEY  (`".$row['mokuainame']."id`)\n) ENGINE=MyISAM;";

	$mokuai_index_file = DISCUZ_ROOT.'source/plugin/yiqixueba/module/index_'.$row['mokuainame'].'.php';
	//dump($mokuai_index_file);
	if(!file_exists($mokuai_index_file)){
		file_put_contents($mokuai_index_file,"<?php\n/**\n*	一起学吧平台程序\n*	文件名：index_".$row['mokuainame'].".php  创建时间：".dgmdate(time(),'dt')."  杨文\n*\n*/\n\nif(!defined('IN_DISCUZ')) {\n\texit('Access Denied');\n}\n\n\$".$row['mokuainame']."lists = array();\n\$".$row['mokuainame']."lists = array();\n\$query_".$row['mokuainame']." = DB::query(\"SELECT * FROM \".DB::table('yiqixueba_brand_".$row['mokuainame']."').\" WHERE status = 1 order by displayorder asc limit 0,6\");\n\t\nwhile(\$row_".$row['mokuainame']." = DB::fetch(\$query_".$row['mokuainame'].")) {\n\t\$".$row['mokuainame']."lists[] = \$row_".$row['mokuainame'].";\n}\n\$".$row['mokuainame']."num = count(\$".$row['mokuainame']."lists);");
	}
	//dump(file_exists($mokuai_index_file));
	if(file_exists($mokuai_index_file)){
		//dump($mokuai_index_file);
		require_once $mokuai_index_file;
	}
	$temp_index_name = 'yiqixueba:yiqixueba/'.$thistemplate.'/index_'.$row['mokuainame'];
	$temp_index_file = DISCUZ_ROOT.'source/plugin/yiqixueba/template/yiqixueba/'.$thistemplate.'/index_'.$row['mokuainame'].'.htm';
	//dump($temp_index_file);
	if(!file_exists($temp_index_file)){
		file_put_contents($temp_index_file,"");
	}
}
//$thistemplate
include template('yiqixueba:'.$template_file);
?>