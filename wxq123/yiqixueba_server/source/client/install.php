<?php

/**
*	һ��ѧ��ƽ̨����
*	�����װ
*	�ļ�����install.php  ����ʱ�䣺2013-5-31 02:48  ����
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