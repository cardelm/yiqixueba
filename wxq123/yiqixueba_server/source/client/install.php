<?php

/**
*	一起学吧平台程序
*	插件安装
*	文件名：install.php  创建时间：2013-5-31 02:48  杨文
*
*/

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$sql =  <<<EOF 
DROP TABLE IF EXISTS wxq_yiqixueba_client_setting;
CREATE TABLE `wxq_yiqixueba_client_setting` (
  `skey` varchar(255) character set gbk NOT NULL,
  `svalue` text character set gbk NOT NULL,
  PRIMARY KEY  (`skey`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;


EOF;
echo "jkdhashd";




?>