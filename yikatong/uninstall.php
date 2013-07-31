<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
DB::delete('forum_forum',array('name'=>'一卡通专区'));
DB::delete('forum_forum',array('name'=>'商品板块'));
DB::delete('forum_threadtype',array('name'=>'一卡通商品'));
$dirname = dirname(__FILE__);
require $dirname.'./../../../config/config_global.php';

$sql = <<<EOF

DROP TABLE IF EXISTS `pre_yikatong_card`;
DROP TABLE IF EXISTS `pre_yikatong_shangjia`;
DROP TABLE IF EXISTS `pre_yikatong_zengsonglog`;
DROP TABLE IF EXISTS `pre_yikatong_trans`;

EOF;

$sql = str_replace("per_",$_config['db']['1']['tablepre'],$sql);

runquery($sql);

$finish = TRUE;
?>