<?php
/**
*	一起学吧平台程序
*	文件名：index_dianping.php  创建时间：2013-6-28 11:15  杨文
*
*/

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$dianpinglists = array();
$dianpinglists = array();
$query_dianping = DB::query("SELECT * FROM ".DB::table('yiqixueba_brand_dianping')." WHERE status = 1 order by displayorder asc limit 0,6");
$dp_k = 0;
while($row_dianping = DB::fetch($query_dianping)) {
	$dianpinglists[$dp_k] = $row_dianping;
		$logo = '';
		if($row_dianping['logo']!='') {
			$logo = str_replace('{STATICURL}', STATICURL, $row_dianping['logo']);
			if(!preg_match("/^".preg_quote(STATICURL, '/')."/i", $logo) && !(($valueparse = parse_url($logo)) && isset($valueparse['host']))) {
				$logo = $_G['setting']['attachurl'].'common/'.$row_dianping['logo'].'?'.random(6);
			}
			$logo = '<img src="'.$logo.'" width="80" height="60"/>';
		}
		$logo = $logo ? $logo : '<img src="source/plugin/yiqixueba/template/yiqixueba/default/style/image/nogoodslogo.jpg" width="80" height="60"/>';
		$dp_k++;
	$dianpinglists[$dp_k]['logo'] = $logo;
}
$dianpingnum = count($dianpinglists);