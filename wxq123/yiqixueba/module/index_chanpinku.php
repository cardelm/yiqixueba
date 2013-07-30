<?php
/**
*	一起学吧平台程序
*	文件名：index_chanpinku.php  创建时间：2013-6-26 02:00  杨文
*
*/

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$chanpinkulists = array();
$query_chanpinku = DB::query("SELECT * FROM ".DB::table('yiqixueba_brand_chanpinku')." WHERE chanpinkustatus = 0 order by createtime asc limit 0,6");
$cpk_k = 0;
while($row_chanpinku = DB::fetch($query_chanpinku)) {
	$chanpinkulists[$cpk_k] = $row_chanpinku;
		$logo = '';
		if($row_chanpinku['logo']!='') {
			$logo = str_replace('{STATICURL}', STATICURL, $row_chanpinku['logo']);
			if(!preg_match("/^".preg_quote(STATICURL, '/')."/i", $logo) && !(($valueparse = parse_url($logo)) && isset($valueparse['host']))) {
				$logo = $_G['setting']['attachurl'].'common/'.$row_chanpinku['logo'].'?'.random(6);
			}
			$logo = '<img src="'.$logo.'" width="80" height="60"/>';
		}
		$logo = $logo ? $logo : '<img src="source/plugin/yiqixueba/template/yiqixueba/default/style/image/nogoodslogo.jpg" width="80" height="60"/>';
		$chanpinkulists[$cpk_k]['logo'] = $logo;
		$cpk_k++;
}
$chanpinkunum = count($chanpinkulists);
//dump($chanpinkulists);

?>