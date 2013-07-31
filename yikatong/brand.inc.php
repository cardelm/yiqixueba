<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
require_once dirname(__FILE__).'/config.php';
require_once dirname(__FILE__).'/source/function/function_main.php';

$mod = $_GET['mod'];

$modarray = array('index','member','groupbuy','notice','consume','album','street','goodsearch','attend','store','ajax','viewcomment','sitenotice','map','share','weixinapi');

$mod = !in_array($mod,$modarray) ? 'index' : $mod;

$navtitle = 'Ʒ�ƿռ�';


require dirname(__FILE__).'/source/module/brand_'.$mod.'.php';


?>