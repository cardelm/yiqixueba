<?php

/**
*	一起学吧平台程序
*	文件名：brand_goods.php  创建时间：2013-6-24 15:14  杨文
*
*/

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$this_page = 'plugin.php?id=yiqixueba:manage&man=brand&subman=goods';

$goodstype = trim(getgpc('goodstype'));

$goodstype_list = array();
$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_mokuai')." WHERE upmokuai = 'brand' AND status = 1 order by displayorder asc");
while($row = DB::fetch($query)) {
	$goodstype_list[] = $row;
}
$goodstypenum = count($goodstype_list);
if($goodstype){
	$goodstype_info = DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_mokuai')." WHERE mokuainame='".$goodstype."'");
	$mokuai_file = DISCUZ_ROOT.'source/plugin/yiqixueba/manage/brand_goods_'.$goodstype.'.php';
	if(!file_exists($mokuai_file)){
		file_put_contents($mokuai_file,"<?php\n\n/**\n*\t一起学吧平台程序\n*\t文件名：brand_".$goodstype.".php  创建时间：".dgmdate(time(),'dt')."  杨文\n*\n*/\n\nif(!defined('IN_DISCUZ')) {\n\texit('Access Denied');\n}\n\n\$this_page = 'plugin.php?id=yiqixueba:manage&man=".$man."&subman=".$subman."&goodstype=".$goodstype."';\n\n\$".$goodstype."_list = array();\n//\$query = DB::query(\"SELECT * FROM \".DB::table('yiqixueba_brand_".$goodstype."').\" WHERE status = 1 order by displayorder asc\");\nwhile(\$row = DB::fetch(\$query)) {\n\t\$".$goodstype."_list[] = \$row;\n}");
	}
	require_once $mokuai_file;
	$mokuai_temp_name = 'yiqixueba:manage/brand_'.$goodstype;
	$mokuai_temp_file = DISCUZ_ROOT.'source/plugin/yiqixueba/template/manage/brand_'.$goodstype.'.htm';
	if(!file_exists($mokuai_temp_file)){
		file_put_contents($mokuai_temp_file,"<div class=\"bmw mtw\">\n\t<div class=\"hm bm_h\"><h2 class=\"mbm xs2\">".$goodstype_info['mokuaititle']."管理</h2></div>\n\t<div class=\"bm_c\">{\$_G['username']}，你好，{\$msg_text}</div>\n\t<div class=\"exfm\" style=\"margin-top: 0;\">\n\t\n\t</div>\n\t<table summary=\"".$goodstype_info['mokuaititle']."管理\" cellspacing=\"0\" cellpadding=\"0\" class=\"dt bm mtm\">\n\t\t<caption><h2 class=\"mbm xs2\"><a href=\"{\$this_page}&goodstype=".$goodstype."&type=edit".$goodstype."\" class=\"xi2 xs1 xw0 y\">添加".$goodstype_info['mokuaititle']."&raquo;</a>".$goodstype_info['mokuaititle']."列表</h2></caption>\n\t\t<tr>\n\t\t\t<th width=\"140\" class=\"hm\">".$goodstype_info['mokuaititle']."</th>\n\n\t\t</tr>\n\t\t<!--{if \$".$goodstype."num}-->\n\t\t\t<!--{loop \$".$goodstype."_list \$".$goodstype."list}-->\n\t\t\t\t<tr>\n\t\t\t<td class=\"hm\">{\$".$goodstype."list[".$goodstype."name]}</td>\n\n\t\t</tr>\n\t\t<!--{/loop}-->\n\t\t<!--{else}-->\n\t\t\t<tr><td colspan=\"4\"><p class=\"emp\">目前没有任何".$goodstype_info['mokuaititle']."</p></td></tr>\n\t<!--{/if}-->\n</table>\n</div>");
	}
}
