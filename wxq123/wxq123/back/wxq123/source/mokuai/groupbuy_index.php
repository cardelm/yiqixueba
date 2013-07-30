<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}


//http://tuan.baidu.com/allsite.php
$query = DB::query("SELECT * FROM ".DB::table('wxq123_site')." where stauts = 1 order by displayorder asc limit 0,20");
while($row = DB::fetch($query)) {
	$siteinfo = $row;
	$topgroupbuys[] = array(
		'link'=>$siteinfo['siteid'],
		'url'=> 'http://chart.apis.google.com/chart?chs=83x83&cht=qr&chld=1|0&chl='.urlencode('http://www.17xue8.cn/weixin='.$siteinfo['siteid']),
		'shibiecode'=>$siteinfo['shibiecode'],
		'title'=>$siteinfo['siteshortname'],
	);
}
$categorys = dunserialize(DB::result_first("SELECT category FROM ".DB::table('wxq123_mokuai')." WHERE mokuaiid='".$mokuaiid."'"));
foreach ( $categorys as $k=>$v ) {
	$query = DB::query("SELECT * FROM ".DB::table('wxq123_site')." where stauts = 1 order by displayorder asc limit 0,6");
	while($row = DB::fetch($query)) {
		$goodsinfo = $row;
		$goods[$k][] = array(
			'link'=>$goodsinfo['siteid'],
			'url'=> 'http://chart.apis.google.com/chart?chs=276x276&cht=qr&chld=1|0&chl='.urlencode('http://www.17xue8.cn/weixin='.$siteinfo['siteid']),
			'shibiecode'=>$goodsinfo['shibiecode'],
			'title'=>$goodsinfo['siteshortname'],
		);
	}
}
include_once template('diy:'.$source_name,0,'./source/plugin/wxq123/template/mokuai');
?>