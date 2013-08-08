-- ----------------------------
-- Table structure for `pre_yiqixueba_setting`
-- ----------------------------
DROP TABLE IF EXISTS `pre_yiqixueba_setting`;
CREATE TABLE `pre_yiqixueba_setting` (
  `skey` varchar(255) NOT NULL,
  `svalue` text NOT NULL,
  PRIMARY KEY  (`skey`)
) ENGINE=MyISAM;

-- ----------------------------
-- Table structure for `pre_yiqixueba_pages`
-- ----------------------------
DROP TABLE IF EXISTS `pre_yiqixueba_pages`;
CREATE TABLE `pre_yiqixueba_pages` (
  `pageid` char(33) NOT NULL,
  `type` char(20) NOT NULL,
  `mod` char(20) NOT NULL,
  `submod` char(20) NOT NULL,
  PRIMARY KEY  (`pageid`)
) ENGINE=MyISAM;

-- ----------------------------
-- Table structure for `pre_yiqixueba_mokuai`
-- ----------------------------
DROP TABLE IF EXISTS `pre_yiqixueba_mokuai`;
CREATE TABLE `pre_yiqixueba_mokuai` (
  `mokuaiid` smallint(6) unsigned NOT NULL auto_increment,
  `available` tinyint(1) NOT NULL default '0',
  `adminid` tinyint(1) unsigned NOT NULL default '0',
  `name` varchar(40) NOT NULL default '',
  `identifier` varchar(40) NOT NULL default '',
  `description` varchar(255) NOT NULL default '',
  `datatables` varchar(255) NOT NULL default '',
  `directory` varchar(100) NOT NULL default '',
  `copyright` varchar(100) NOT NULL default '',
  `modules` text NOT NULL,
  `version` varchar(20) NOT NULL default '',
  `setting` text NOT NULL,
  `displayorder` smallint(6) NOT NULL,
  PRIMARY KEY  (`mokuaiid`),
  UNIQUE KEY `identifier` (`identifier`)
) ENGINE=MyISAM;

-- ----------------------------
-- Records of pre_yiqixueba_mokuai
-- ----------------------------
INSERT INTO `pre_yiqixueba_mokuai` VALUES ('1', '1', '1', '主程序', 'main', '', '', 'yiqixueba_main/', 'www.17xue8.cn', 'a:3:{i:0;a:10:{s:4:\"name\";s:5:\"index\";s:4:\"menu\";s:12:\"平台首页\";s:3:\"url\";s:0:\"\";s:4:\"type\";s:1:\"3\";s:7:\"adminid\";s:1:\"0\";s:12:\"displayorder\";i:0;s:8:\"navtitle\";s:0:\"\";s:7:\"navicon\";s:0:\"\";s:10:\"navsubname\";s:0:\"\";s:9:\"navsuburl\";s:0:\"\";}i:1;a:10:{s:4:\"name\";s:9:\"pluginreg\";s:4:\"menu\";s:12:\"平台注册\";s:3:\"url\";s:0:\"\";s:4:\"type\";s:1:\"3\";s:7:\"adminid\";s:1:\"0\";s:12:\"displayorder\";i:1;s:8:\"navtitle\";s:0:\"\";s:7:\"navicon\";s:0:\"\";s:10:\"navsubname\";s:0:\"\";s:9:\"navsuburl\";s:0:\"\";}i:2;a:10:{s:4:\"name\";s:6:\"mokuai\";s:4:\"menu\";s:12:\"模块管理\";s:3:\"url\";s:0:\"\";s:4:\"type\";s:1:\"3\";s:7:\"adminid\";s:1:\"0\";s:12:\"displayorder\";i:2;s:8:\"navtitle\";s:0:\"\";s:7:\"navicon\";s:0:\"\";s:10:\"navsubname\";s:0:\"\";s:9:\"navsuburl\";s:0:\"\";}}', 'V2.0', 'a:0:{}', '1');