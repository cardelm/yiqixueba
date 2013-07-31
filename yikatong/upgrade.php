<?php
/**
 *      [Discuz!] (C)2012-2099 YiQiXueBa.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: yiqixueba.php 24411 2012-10-17 05:09:03Z yangwen $
 */

 if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
file_put_contents(DISCUZ_ROOT.'weixinapi.php',file_get_contents(dirname(__FILE__).'\data\copy\weixinapi.php'));
file_put_contents(DISCUZ_ROOT.'source\class\magic\magic_zijian.php',file_get_contents(dirname(__FILE__).'\data\copy\source\class\magic\magic_zijian.php'));
unlink(dirname(__FILE__).'\data\copy\weixinapi.php');
unlink(dirname(__FILE__).'\data\copy\source\class\magic\magic_zijian.php');

$sql = file_get_contents(dirname(__FILE__).'/data/upgrade.sql');
unlink(dirname(__FILE__).'/data/upgrade.sql');

$sql = str_replace("per_",$_G['config']['db']['1']['tablepre'],$sql);

runquery($sql);

$finish = TRUE;

?>