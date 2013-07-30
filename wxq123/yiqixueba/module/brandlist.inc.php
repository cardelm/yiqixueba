<?php

/**
*	一起学吧平台程序
*	文件名：brandlist.inc.php  创建时间：2013-6-12 23:02  杨文
*
*/

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
$_CITY['name'] = '石家庄';
if ($mokuai_info['upmokuai']){
	$sortid = intval(getgpc('sortid'));
	$upmokuai_info = DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_mokuai')." WHERE mokuainame='".$mokuai_info['upmokuai']."'");
	$total = DB::result_first("SELECT count(*) FROM ".DB::table('yiqixueba_brand_shop')." WHERE upmokuai = ".$mokuai_info['mokuaiid']);
	$sortlist = array();
	$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_brand_shopsort')." WHERE upmokuai = ".$mokuai_info['mokuaiid']." and sortlevel=1 order by displayorder asc");
	while($row = DB::fetch($query)) {
		$sortlist[] = $row;
	}
	if($sortid){
		$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_brand_shop')." WHERE shopsort = ".$sortid." order by shoprecommend asc");
	}else{
		$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_brand_shop')."  WHERE upmokuai = ".$mokuai_info['mokuaiid']." order by shoprecommend asc");
	}
	$shoplist = array();
	$k = 0;
	while($row = DB::fetch($query)) {
		$shoplist[$k] = $row;
		$shoplogo = '';
		if($row['shoplogo']!='') {
			$shoplogo = str_replace('{STATICURL}', STATICURL, $row['shoplogo']);
			if(!preg_match("/^".preg_quote(STATICURL, '/')."/i", $mokuaiico) && !(($valueparse = parse_url($shoplogo)) && isset($valueparse['host']))) {
				$shoplogo = $_G['setting']['attachurl'].'common/'.$row['shoplogo'].'?'.random(6);

			}
		}
		$shoplogo = $shoplogo ? $shoplogo : 'source/plugin/yiqixueba/template/yiqixueba/default/style/image/noshoplogo.jpg';
		$shoplist[$k]['shoplogo'] = $shoplogo;
		$k++;
	}
	//dump($shoplist);
	include template('yiqixueba:yiqixueba/'.$thistemplate.'/shoplist');
}else{
	$$mainnav = array();
	$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_mokuai')."  WHERE upmokuai='brand' order by displayorder asc");
	$k = 0;
	while($row = DB::fetch($query)) {
		$mainnav[$row['mokuaiid']] = $row;
		$query1 = DB::query("SELECT * FROM ".DB::table('yiqixueba_brand_shopsort')." WHERE upmokuai = ".$row['mokuaiid']." and sortlevel=1 order by displayorder asc");
		while($row1 = DB::fetch($query1)) {
			$mainnav[$row['mokuaiid']]['subnav'][$k] = $row1;
		}

		$query2 = DB::query("SELECT * FROM ".DB::table('yiqixueba_brand_shop')." WHERE upmokuai=".$row['mokuaiid']." and status = 1 order by shoprecommend asc  limit 0, 10");

		while($row2 = DB::fetch($query2)) {
			$mainnav[$row['mokuaiid']]['shop'][$k] = $row2;
			$shoplogo = '';
			if($row2['shoplogo']!='') {
				$shoplogo = str_replace('{STATICURL}', STATICURL, $row2['shoplogo']);
				if(!preg_match("/^".preg_quote(STATICURL, '/')."/i", $mokuaiico) && !(($valueparse = parse_url($shoplogo)) && isset($valueparse['host']))) {
					$shoplogo = $_G['setting']['attachurl'].'common/'.$row2['shoplogo'].'?'.random(6);
					$shoplogo = '<img src="'.$shoplogo.'" width="80" height="60"/>';
				}
			}
			$shoplogo = $shoplogo ? $shoplogo : '<img src="source/plugin/yiqixueba/template/yiqixueba/default/style/image/noshoplogo.jpg" width="80" height="60"/>';
			$mainnav[$row['mokuaiid']]['shop'][$k]['shoplogo'] = $shoplogo;
			$k++;
		}

	}
	include template('yiqixueba:'.$template_file);
}

?>