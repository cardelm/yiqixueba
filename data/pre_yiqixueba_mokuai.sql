/*
Navicat MySQL Data Transfer

Source Server         : 本地
Source Server Version : 50045
Source Host           : localhost:3306
Source Database       : dz3gbk

Target Server Type    : MYSQL
Target Server Version : 50045
File Encoding         : 65001

Date: 2013-07-29 16:01:40
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `pre_yiqixueba_mokuai`
-- ----------------------------
DROP TABLE IF EXISTS `pre_yiqixueba_mokuai`;
CREATE TABLE `pre_yiqixueba_mokuai` (
  `mokuaiid` smallint(6) unsigned NOT NULL auto_increment,
  `pluginid` smallint(6) NOT NULL,
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
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=gbk;

-- ----------------------------
-- Records of pre_yiqixueba_mokuai
-- ----------------------------
INSERT INTO `pre_yiqixueba_mokuai` VALUES ('1', '14', '1', '1', '商家展示', 'shop', '', '', 'yiqixueba_shop/', 'www.17xue8.cn', 'a:6:{i:0;a:10:{s:4:\"name\";s:9:\"shopindex\";s:4:\"menu\";s:8:\"商家展示\";s:3:\"url\";s:0:\"\";s:4:\"type\";s:1:\"1\";s:7:\"adminid\";s:1:\"0\";s:12:\"displayorder\";i:0;s:8:\"navtitle\";s:0:\"\";s:7:\"navicon\";s:0:\"\";s:10:\"navsubname\";s:0:\"\";s:9:\"navsuburl\";s:0:\"\";}i:1;a:10:{s:4:\"name\";s:9:\"shopgroup\";s:4:\"menu\";s:6:\"商家组\";s:3:\"url\";s:0:\"\";s:4:\"type\";s:1:\"3\";s:7:\"adminid\";s:1:\"0\";s:12:\"displayorder\";i:0;s:8:\"navtitle\";s:0:\"\";s:7:\"navicon\";s:0:\"\";s:10:\"navsubname\";s:0:\"\";s:9:\"navsuburl\";s:0:\"\";}i:2;a:10:{s:4:\"name\";s:8:\"shopcats\";s:4:\"menu\";s:8:\"商家分类\";s:3:\"url\";s:0:\"\";s:4:\"type\";s:1:\"3\";s:7:\"adminid\";s:1:\"0\";s:12:\"displayorder\";i:1;s:8:\"navtitle\";s:0:\"\";s:7:\"navicon\";s:0:\"\";s:10:\"navsubname\";s:0:\"\";s:9:\"navsuburl\";s:0:\"\";}i:3;a:10:{s:4:\"name\";s:8:\"shoplist\";s:4:\"menu\";s:8:\"商家管理\";s:3:\"url\";s:0:\"\";s:4:\"type\";s:1:\"3\";s:7:\"adminid\";s:1:\"0\";s:12:\"displayorder\";i:2;s:8:\"navtitle\";s:0:\"\";s:7:\"navicon\";s:0:\"\";s:10:\"navsubname\";s:0:\"\";s:9:\"navsuburl\";s:0:\"\";}i:4;a:10:{s:4:\"name\";s:10:\"shopmoxing\";s:4:\"menu\";s:8:\"商家模型\";s:3:\"url\";s:0:\"\";s:4:\"type\";s:1:\"3\";s:7:\"adminid\";s:1:\"0\";s:12:\"displayorder\";i:3;s:8:\"navtitle\";s:0:\"\";s:7:\"navicon\";s:0:\"\";s:10:\"navsubname\";s:0:\"\";s:9:\"navsuburl\";s:0:\"\";}s:5:\"extra\";a:1:{s:10:\"langexists\";s:1:\"1\";}}', 'V2.0', 'a:1:{i:0;a:9:{s:11:\"pluginvarid\";s:1:\"1\";s:8:\"pluginid\";s:2:\"14\";s:12:\"displayorder\";s:1:\"0\";s:5:\"title\";s:8:\"选用模板\";s:11:\"description\";s:0:\"\";s:8:\"variable\";s:12:\"shoptemplate\";s:4:\"type\";s:4:\"text\";s:5:\"value\";s:7:\"default\";s:5:\"extra\";s:0:\"\";}}', '0');
INSERT INTO `pre_yiqixueba_mokuai` VALUES ('2', '15', '1', '1', '微信墙', 'wxq', '', '', 'yiqixueba_wxq/', 'www.wxq123.com', 'a:1:{s:5:\"extra\";a:1:{s:10:\"langexists\";s:1:\"1\";}}', 'V2.0', 'a:0:{}', '0');

-- ----------------------------
-- Table structure for `pre_yiqixueba_pages`
-- ----------------------------
DROP TABLE IF EXISTS `pre_yiqixueba_pages`;
CREATE TABLE `pre_yiqixueba_pages` (
  `pageid` char(33) NOT NULL,
  `mokuai` char(20) NOT NULL,
  `pagetype` char(20) NOT NULL,
  `module` char(20) NOT NULL,
  `submod` char(20) NOT NULL,
  PRIMARY KEY  (`pageid`)
) ENGINE=InnoDB DEFAULT CHARSET=gbk;

-- ----------------------------
-- Records of pre_yiqixueba_pages
-- ----------------------------

-- ----------------------------
-- Table structure for `pre_yiqixueba_server_mokuai`
-- ----------------------------
DROP TABLE IF EXISTS `pre_yiqixueba_server_mokuai`;
CREATE TABLE `pre_yiqixueba_server_mokuai` (
  `mokuaiid` smallint(6) unsigned NOT NULL auto_increment,
  `pluginid` smallint(6) NOT NULL,
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
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=gbk;

-- ----------------------------
-- Records of pre_yiqixueba_server_mokuai
-- ----------------------------
INSERT INTO `pre_yiqixueba_server_mokuai` VALUES ('1', '14', '1', '1', '商家展示', 'shop', '', '', 'yiqixueba_shop/', 'www.17xue8.cn', 'a:6:{i:0;a:10:{s:4:\"name\";s:9:\"shopindex\";s:4:\"menu\";s:8:\"商家展示\";s:3:\"url\";s:0:\"\";s:4:\"type\";s:1:\"1\";s:7:\"adminid\";s:1:\"0\";s:12:\"displayorder\";i:0;s:8:\"navtitle\";s:0:\"\";s:7:\"navicon\";s:0:\"\";s:10:\"navsubname\";s:0:\"\";s:9:\"navsuburl\";s:0:\"\";}i:1;a:10:{s:4:\"name\";s:9:\"shopgroup\";s:4:\"menu\";s:6:\"商家组\";s:3:\"url\";s:0:\"\";s:4:\"type\";s:1:\"3\";s:7:\"adminid\";s:1:\"0\";s:12:\"displayorder\";i:0;s:8:\"navtitle\";s:0:\"\";s:7:\"navicon\";s:0:\"\";s:10:\"navsubname\";s:0:\"\";s:9:\"navsuburl\";s:0:\"\";}i:2;a:10:{s:4:\"name\";s:8:\"shopcats\";s:4:\"menu\";s:8:\"商家分类\";s:3:\"url\";s:0:\"\";s:4:\"type\";s:1:\"3\";s:7:\"adminid\";s:1:\"0\";s:12:\"displayorder\";i:1;s:8:\"navtitle\";s:0:\"\";s:7:\"navicon\";s:0:\"\";s:10:\"navsubname\";s:0:\"\";s:9:\"navsuburl\";s:0:\"\";}i:3;a:10:{s:4:\"name\";s:8:\"shoplist\";s:4:\"menu\";s:8:\"商家管理\";s:3:\"url\";s:0:\"\";s:4:\"type\";s:1:\"3\";s:7:\"adminid\";s:1:\"0\";s:12:\"displayorder\";i:2;s:8:\"navtitle\";s:0:\"\";s:7:\"navicon\";s:0:\"\";s:10:\"navsubname\";s:0:\"\";s:9:\"navsuburl\";s:0:\"\";}i:4;a:10:{s:4:\"name\";s:10:\"shopmoxing\";s:4:\"menu\";s:8:\"商家模型\";s:3:\"url\";s:0:\"\";s:4:\"type\";s:1:\"3\";s:7:\"adminid\";s:1:\"0\";s:12:\"displayorder\";i:3;s:8:\"navtitle\";s:0:\"\";s:7:\"navicon\";s:0:\"\";s:10:\"navsubname\";s:0:\"\";s:9:\"navsuburl\";s:0:\"\";}s:5:\"extra\";a:1:{s:10:\"langexists\";s:1:\"1\";}}', 'V2.0', 'a:1:{i:0;a:9:{s:11:\"pluginvarid\";s:1:\"1\";s:8:\"pluginid\";s:2:\"14\";s:12:\"displayorder\";s:1:\"0\";s:5:\"title\";s:8:\"选用模板\";s:11:\"description\";s:0:\"\";s:8:\"variable\";s:12:\"shoptemplate\";s:4:\"type\";s:4:\"text\";s:5:\"value\";s:7:\"default\";s:5:\"extra\";s:0:\"\";}}', '0');
INSERT INTO `pre_yiqixueba_server_mokuai` VALUES ('2', '15', '1', '1', '微信墙', 'wxq', '', '', 'yiqixueba_wxq/', 'www.wxq123.com', 'a:1:{s:5:\"extra\";a:1:{s:10:\"langexists\";s:1:\"1\";}}', 'V2.0', 'a:0:{}', '0');

-- ----------------------------
-- Table structure for `pre_yiqixueba_server_site`
-- ----------------------------
DROP TABLE IF EXISTS `pre_yiqixueba_server_site`;
CREATE TABLE `pre_yiqixueba_server_site` (
  `siteid` mediumint(8) unsigned NOT NULL auto_increment,
  `sitename` char(40) NOT NULL,
  `displayorder` mediumint(8) NOT NULL,
  `installtime` int(10) NOT NULL,
  PRIMARY KEY  (`siteid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

-- ----------------------------
-- Records of pre_yiqixueba_server_site
-- ----------------------------

-- ----------------------------
-- Table structure for `pre_yiqixueba_server_sitegroup`
-- ----------------------------
DROP TABLE IF EXISTS `pre_yiqixueba_server_sitegroup`;
CREATE TABLE `pre_yiqixueba_server_sitegroup` (
  `sitegroupid` smallint(3) unsigned NOT NULL auto_increment,
  `sitegroupname` char(20) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `mokuaitest` varchar(255) NOT NULL,
  PRIMARY KEY  (`sitegroupid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=gbk;

-- ----------------------------
-- Records of pre_yiqixueba_server_sitegroup
-- ----------------------------
INSERT INTO `pre_yiqixueba_server_sitegroup` VALUES ('1', '测试组', '0', '0');

-- ----------------------------
-- Table structure for `pre_yiqixueba_shop_shopcats`
-- ----------------------------
DROP TABLE IF EXISTS `pre_yiqixueba_shop_shopcats`;
CREATE TABLE `pre_yiqixueba_shop_shopcats` (
  `shopcatsid` mediumint(8) unsigned NOT NULL auto_increment,
  `shopcatsname` char(40) NOT NULL,
  `displayorder` mediumint(8) NOT NULL,
  PRIMARY KEY  (`shopcatsid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=gbk;

-- ----------------------------
-- Records of pre_yiqixueba_shop_shopcats
-- ----------------------------
INSERT INTO `pre_yiqixueba_shop_shopcats` VALUES ('1', '测试1', '0');

-- ----------------------------
-- Table structure for `pre_yiqixueba_shop_shopgroup`
-- ----------------------------
DROP TABLE IF EXISTS `pre_yiqixueba_shop_shopgroup`;
CREATE TABLE `pre_yiqixueba_shop_shopgroup` (
  `shopgroupid` mediumint(8) unsigned NOT NULL auto_increment,
  `shopgroupname` char(40) NOT NULL,
  `displayorder` mediumint(8) NOT NULL,
  PRIMARY KEY  (`shopgroupid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

-- ----------------------------
-- Records of pre_yiqixueba_shop_shopgroup
-- ----------------------------

-- ----------------------------
-- Table structure for `pre_yiqixueba_shop_shoplist`
-- ----------------------------
DROP TABLE IF EXISTS `pre_yiqixueba_shop_shoplist`;
CREATE TABLE `pre_yiqixueba_shop_shoplist` (
  `shoplistid` mediumint(8) unsigned NOT NULL auto_increment,
  `shoplistname` char(40) NOT NULL,
  `displayorder` mediumint(8) NOT NULL,
  `shoplistico` varchar(255) NOT NULL,
  PRIMARY KEY  (`shoplistid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=gbk;

-- ----------------------------
-- Records of pre_yiqixueba_shop_shoplist
-- ----------------------------
INSERT INTO `pre_yiqixueba_shop_shoplist` VALUES ('1', '撒打算', '0', '');

-- ----------------------------
-- Table structure for `pre_yiqixueba_shop_shopmoxing`
-- ----------------------------
DROP TABLE IF EXISTS `pre_yiqixueba_shop_shopmoxing`;
CREATE TABLE `pre_yiqixueba_shop_shopmoxing` (
  `shopmoxingid` mediumint(8) unsigned NOT NULL auto_increment,
  `shopmoxingname` char(40) NOT NULL,
  `displayorder` mediumint(8) NOT NULL,
  `shopmoxingtitle` varchar(255) NOT NULL,
  `shopmoxingico` varchar(255) NOT NULL,
  `shopmoxingvar` text NOT NULL,
  PRIMARY KEY  (`shopmoxingid`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=gbk;

-- ----------------------------
-- Records of pre_yiqixueba_shop_shopmoxing
-- ----------------------------
INSERT INTO `pre_yiqixueba_shop_shopmoxing` VALUES ('1', '测试', '0', '', '', '');
INSERT INTO `pre_yiqixueba_shop_shopmoxing` VALUES ('2', '哈哈', '0', '', '', '');

-- ----------------------------
-- Table structure for `pre_yiqixueba_shop_shopmoxingvar`
-- ----------------------------
DROP TABLE IF EXISTS `pre_yiqixueba_shop_shopmoxingvar`;
CREATE TABLE `pre_yiqixueba_shop_shopmoxingvar` (
  `shopmoxingvarid` mediumint(8) unsigned NOT NULL auto_increment,
  `shopmoxingid` mediumint(8) NOT NULL,
  `displayorder` mediumint(8) NOT NULL,
  `title` char(20) NOT NULL,
  `variable` char(20) NOT NULL,
  `type` varchar(50) NOT NULL,
  PRIMARY KEY  (`shopmoxingvarid`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=gbk;

-- ----------------------------
-- Records of pre_yiqixueba_shop_shopmoxingvar
-- ----------------------------
INSERT INTO `pre_yiqixueba_shop_shopmoxingvar` VALUES ('1', '1', '0', '测试', 'dasdas', 'text');
INSERT INTO `pre_yiqixueba_shop_shopmoxingvar` VALUES ('2', '1', '0', '发生地方', 'dwqqw', 'select');
