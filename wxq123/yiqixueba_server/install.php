<?php
/**
 *      一起学吧服务端程序
 *		只在设计时使用
 *      $Id: install.php 2013-05-28 22:45:03Z yangwen $
 */


$sql = <<<EOF

DROP TABLE IF EXISTS `wxq_yiqixueba_server_site`;
CREATE TABLE `wxq_yiqixueba_server_site` (
  `siteid` mediumint(8) unsigned NOT NULL auto_increment,
  `siteurl` char(50) NOT NULL,
  `charset` char(10) NOT NULL,
  `clientip` char(15) NOT NULL,
  `version` char(50) NOT NULL,
  `installtime` int(10) unsigned NOT NULL,
  `upgradetime` int(10) unsigned NOT NULL,
  `uninstalltime` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`siteid`)
) ENGINE=MyISAM;

DROP TABLE IF EXISTS `wxq_yiqixueba_server_mokuai_group`;
CREATE TABLE `wxq_yiqixueba_server_mokuai_group` (
  `groupid` smallint(6) unsigned NOT NULL auto_increment,
  `mokuainame` char(40) NOT NULL,
  `mokuaititle` char(40) NOT NULL,
  `displayorder` smallint(6) NOT NULL,
  `mokuaiico` varchar(255) NOT NULL,
  PRIMARY KEY  (`groupid`)
) ENGINE=MyISAM;

DROP TABLE IF EXISTS `wxq_yiqixueba_server_mokuai`;
CREATE TABLE `wxq_yiqixueba_server_mokuai` (
	`mokuaiid` smallint(6) unsigned NOT NULL auto_increment,
	`groupid` smallint(6) NOT NULL,
	`versionname` char(50) NOT NULL,
	`mokuaidescription` varchar(255) NOT NULL,
	`mokuaipice` int(10) NOT NULL,
	`displayorder` smallint(6) NOT NULL,
	`status` tinyint(1) NOT NULL,
	PRIMARY KEY  (`mokuaiid`)
) ENGINE=MyISAM;

DROP TABLE IF EXISTS `wxq_yiqixueba_server_page`;
CREATE TABLE `wxq_yiqixueba_server_page` (
	`pageid` mediumint(8) unsigned NOT NULL auto_increment,
	`mokuaiid` smallint(6) NOT NULL,
	`pagetype` char(10) NOT NULL,
	`filename` char(50) NOT NULL,
	`filetitle` char(50) NOT NULL,
	`menu` char(50) NOT NULL,
	`pagedescription` varchar(255) NOT NULL,
	`displayorder` smallint(6) NOT NULL,
	`status` tinyint(1) NOT NULL,
	PRIMARY KEY  (`pageid`)
) ENGINE=MyISAM;

EOF;
//runquery($sql);
//$finish = TRUE;
//$sql = "alter table ".DB::table('yiqixueba_server_page')." add `filetitle` char(50) not Null;";
//runquery($sql);

?>