/*
Navicat MySQL Data Transfer

Source Server         : 本地
Source Server Version : 50045
Source Host           : localhost:3306
Source Database       : dz30

Target Server Type    : MYSQL
Target Server Version : 50045
File Encoding         : 65001

Date: 2013-08-22 16:39:31
*/

SET FOREIGN_KEY_CHECKS=0;

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
  `price` char(10) NOT NULL,
  `datatables` varchar(255) NOT NULL default '',
  `directory` varchar(100) NOT NULL default '',
  `copyright` varchar(100) NOT NULL default '',
  `modules` text NOT NULL,
  `version` varchar(20) NOT NULL default '',
  `setting` text NOT NULL,
  `displayorder` smallint(6) NOT NULL,
  `createtime` int(10) unsigned NOT NULL,
  `updatetime` int(10) unsigned NOT NULL,
  `mokuaikey` char(32) NOT NULL,
  PRIMARY KEY  (`mokuaiid`),
  UNIQUE KEY `identifier` (`identifier`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pre_yiqixueba_mokuai
-- ----------------------------
INSERT INTO `pre_yiqixueba_mokuai` VALUES ('1', '1', '1', '主程序', 'main', '', '', '', 'yiqixueba_main/', 'www.17xue8.cn', 'a:3:{i:0;a:10:{s:4:\"name\";s:5:\"index\";s:4:\"menu\";s:12:\"平台首页\";s:3:\"url\";s:0:\"\";s:4:\"type\";s:1:\"3\";s:7:\"adminid\";s:1:\"0\";s:12:\"displayorder\";i:0;s:8:\"navtitle\";s:0:\"\";s:7:\"navicon\";s:0:\"\";s:10:\"navsubname\";s:0:\"\";s:9:\"navsuburl\";s:0:\"\";}i:1;a:10:{s:4:\"name\";s:9:\"pluginreg\";s:4:\"menu\";s:12:\"平台注册\";s:3:\"url\";s:0:\"\";s:4:\"type\";s:1:\"3\";s:7:\"adminid\";s:1:\"0\";s:12:\"displayorder\";i:1;s:8:\"navtitle\";s:0:\"\";s:7:\"navicon\";s:0:\"\";s:10:\"navsubname\";s:0:\"\";s:9:\"navsuburl\";s:0:\"\";}i:2;a:10:{s:4:\"name\";s:6:\"mokuai\";s:4:\"menu\";s:12:\"模块管理\";s:3:\"url\";s:0:\"\";s:4:\"type\";s:1:\"3\";s:7:\"adminid\";s:1:\"0\";s:12:\"displayorder\";i:2;s:8:\"navtitle\";s:0:\"\";s:7:\"navicon\";s:0:\"\";s:10:\"navsubname\";s:0:\"\";s:9:\"navsuburl\";s:0:\"\";}}', 'V2.0', 'a:0:{}', '1', '0', '0', 'f28a380ea9518ac0f0e2923d7b24bb6d');
INSERT INTO `pre_yiqixueba_mokuai` VALUES ('2', '1', '1', '服务端', 'server', '', '', '', 'yiqixueba_server/', 'www.17xue8.cn', 'a:4:{i:0;a:10:{s:4:\"name\";s:5:\"index\";s:4:\"menu\";s:12:\"后台首页\";s:3:\"url\";s:0:\"\";s:4:\"type\";s:1:\"3\";s:7:\"adminid\";s:1:\"0\";s:12:\"displayorder\";i:0;s:8:\"navtitle\";s:0:\"\";s:7:\"navicon\";s:0:\"\";s:10:\"navsubname\";s:0:\"\";s:9:\"navsuburl\";s:0:\"\";}i:1;a:10:{s:4:\"name\";s:9:\"sitegroup\";s:4:\"menu\";s:9:\"站长组\";s:3:\"url\";s:0:\"\";s:4:\"type\";s:1:\"3\";s:7:\"adminid\";s:1:\"0\";s:12:\"displayorder\";i:1;s:8:\"navtitle\";s:0:\"\";s:7:\"navicon\";s:0:\"\";s:10:\"navsubname\";s:0:\"\";s:9:\"navsuburl\";s:0:\"\";}i:2;a:10:{s:4:\"name\";s:4:\"site\";s:4:\"menu\";s:12:\"站长管理\";s:3:\"url\";s:0:\"\";s:4:\"type\";s:1:\"3\";s:7:\"adminid\";s:1:\"0\";s:12:\"displayorder\";i:2;s:8:\"navtitle\";s:0:\"\";s:7:\"navicon\";s:0:\"\";s:10:\"navsubname\";s:0:\"\";s:9:\"navsuburl\";s:0:\"\";}i:3;a:10:{s:4:\"name\";s:6:\"mokuai\";s:4:\"menu\";s:12:\"模块管理\";s:3:\"url\";s:0:\"\";s:4:\"type\";s:1:\"3\";s:7:\"adminid\";s:1:\"0\";s:12:\"displayorder\";i:3;s:8:\"navtitle\";s:0:\"\";s:7:\"navicon\";s:0:\"\";s:10:\"navsubname\";s:0:\"\";s:9:\"navsuburl\";s:0:\"\";}}', 'V2.0', 'a:0:{}', '0', '0', '0', 'ab8ec4b616b33e1b1221e17532609aed');
INSERT INTO `pre_yiqixueba_mokuai` VALUES ('4', '1', '0', '会员卡', 'carde', '卡益联盟（一卡通）', '500', '', '', '', 'a:1:{i:0;a:10:{s:4:\"name\";s:5:\"index\";s:4:\"menu\";s:15:\"会员卡首页\";s:3:\"url\";s:0:\"\";s:4:\"type\";i:3;s:7:\"adminid\";i:1;s:12:\"displayorder\";s:1:\"0\";s:8:\"navtitle\";s:0:\"\";s:7:\"navicon\";s:0:\"\";s:10:\"navsubname\";s:0:\"\";s:9:\"navsuburl\";s:0:\"\";}}', 'V1.0', '', '4', '1376893983', '1377062430', '766a835157220cc2879731d0e7ef7501');
INSERT INTO `pre_yiqixueba_mokuai` VALUES ('3', '1', '0', '商家联盟', 'shop', '联盟商家程序', '500', '', '', '', 'a:4:{i:0;a:10:{s:4:\"name\";s:5:\"index\";s:4:\"menu\";s:12:\"商家首页\";s:3:\"url\";s:0:\"\";s:4:\"type\";i:3;s:7:\"adminid\";i:1;s:12:\"displayorder\";s:1:\"0\";s:8:\"navtitle\";s:0:\"\";s:7:\"navicon\";s:0:\"\";s:10:\"navsubname\";s:0:\"\";s:9:\"navsuburl\";s:0:\"\";}i:1;a:10:{s:4:\"name\";s:9:\"shopgroup\";s:4:\"menu\";s:9:\"商家组\";s:3:\"url\";s:0:\"\";s:4:\"type\";i:3;s:7:\"adminid\";i:1;s:12:\"displayorder\";s:1:\"1\";s:8:\"navtitle\";s:0:\"\";s:7:\"navicon\";s:0:\"\";s:10:\"navsubname\";s:0:\"\";s:9:\"navsuburl\";s:0:\"\";}i:2;a:10:{s:4:\"name\";s:8:\"shoptype\";s:4:\"menu\";s:12:\"商家模型\";s:3:\"url\";s:0:\"\";s:4:\"type\";i:3;s:7:\"adminid\";i:1;s:12:\"displayorder\";s:1:\"2\";s:8:\"navtitle\";s:0:\"\";s:7:\"navicon\";s:0:\"\";s:10:\"navsubname\";s:0:\"\";s:9:\"navsuburl\";s:0:\"\";}i:3;a:10:{s:4:\"name\";s:8:\"shoplist\";s:4:\"menu\";s:12:\"商家管理\";s:3:\"url\";s:0:\"\";s:4:\"type\";i:3;s:7:\"adminid\";i:1;s:12:\"displayorder\";s:1:\"3\";s:8:\"navtitle\";s:0:\"\";s:7:\"navicon\";s:0:\"\";s:10:\"navsubname\";s:0:\"\";s:9:\"navsuburl\";s:0:\"\";}}', 'V1.0', '', '2', '1376899794', '1376893189', '5f2ceb2cbf55c086aa6162bf95b03940');
INSERT INTO `pre_yiqixueba_mokuai` VALUES ('5', '1', '0', '微信墙', 'weixin', '微信墙主程序', '500', '', '', '', 'a:1:{i:0;a:10:{s:4:\"name\";s:5:\"index\";s:4:\"menu\";s:15:\"微信墙首页\";s:3:\"url\";s:0:\"\";s:4:\"type\";i:3;s:7:\"adminid\";i:1;s:12:\"displayorder\";s:1:\"0\";s:8:\"navtitle\";s:0:\"\";s:7:\"navicon\";s:0:\"\";s:10:\"navsubname\";s:0:\"\";s:9:\"navsuburl\";s:0:\"\";}}', 'V1.0', '', '5', '1377071393', '1377071868', '');

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
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

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
  `price` char(10) NOT NULL,
  `datatables` varchar(255) NOT NULL default '',
  `directory` varchar(100) NOT NULL default '',
  `copyright` varchar(100) NOT NULL default '',
  `modules` text NOT NULL,
  `version` varchar(20) NOT NULL default '',
  `currentversion` tinyint(1) NOT NULL default '0',
  `setting` text NOT NULL,
  `displayorder` smallint(6) NOT NULL,
  `createtime` int(10) NOT NULL,
  `updatetime` int(10) NOT NULL,
  PRIMARY KEY  (`mokuaiid`)
) ENGINE=MyISAM AUTO_INCREMENT=6 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pre_yiqixueba_server_mokuai
-- ----------------------------
INSERT INTO `pre_yiqixueba_server_mokuai` VALUES ('1', '0', '1', '0', '主程序', 'main', '整个插件的主程序', '0', '', '', '', 'a:3:{i:0;a:10:{s:4:\"name\";s:5:\"index\";s:4:\"menu\";s:12:\"平台首页\";s:3:\"url\";s:0:\"\";s:4:\"type\";i:3;s:7:\"adminid\";i:1;s:12:\"displayorder\";s:1:\"0\";s:8:\"navtitle\";s:0:\"\";s:7:\"navicon\";s:0:\"\";s:10:\"navsubname\";s:0:\"\";s:9:\"navsuburl\";s:0:\"\";}i:1;a:10:{s:4:\"name\";s:9:\"pluginreg\";s:4:\"menu\";s:12:\"平台注册\";s:3:\"url\";s:0:\"\";s:4:\"type\";i:3;s:7:\"adminid\";i:1;s:12:\"displayorder\";s:1:\"1\";s:8:\"navtitle\";s:0:\"\";s:7:\"navicon\";s:0:\"\";s:10:\"navsubname\";s:0:\"\";s:9:\"navsuburl\";s:0:\"\";}i:2;a:10:{s:4:\"name\";s:6:\"mokuai\";s:4:\"menu\";s:12:\"模块管理\";s:3:\"url\";s:0:\"\";s:4:\"type\";i:3;s:7:\"adminid\";i:1;s:12:\"displayorder\";s:1:\"2\";s:8:\"navtitle\";s:0:\"\";s:7:\"navicon\";s:0:\"\";s:10:\"navsubname\";s:0:\"\";s:9:\"navsuburl\";s:0:\"\";}}', 'V1.0', '1', '', '1', '1376037107', '1376877122');
INSERT INTO `pre_yiqixueba_server_mokuai` VALUES ('2', '0', '1', '0', '服务端', 'server', '整个插件的服务端程序', '50000', '', '', '', 'a:0:{}', 'V1.0', '1', '', '2', '1376037107', '1376876867');
INSERT INTO `pre_yiqixueba_server_mokuai` VALUES ('5', '0', '1', '0', '微信墙', 'weixin', '微信墙主程序', '500', '', '', '', 'a:1:{i:0;a:10:{s:4:\"name\";s:5:\"index\";s:4:\"menu\";s:15:\"微信墙首页\";s:3:\"url\";s:0:\"\";s:4:\"type\";i:3;s:7:\"adminid\";i:1;s:12:\"displayorder\";s:1:\"0\";s:8:\"navtitle\";s:0:\"\";s:7:\"navicon\";s:0:\"\";s:10:\"navsubname\";s:0:\"\";s:9:\"navsuburl\";s:0:\"\";}}', 'V1.0', '0', '', '5', '1377071393', '1377071851');
INSERT INTO `pre_yiqixueba_server_mokuai` VALUES ('3', '0', '1', '0', '商家联盟', 'shop', '联盟商家程序', '500', '', '', '', 'a:4:{i:0;a:10:{s:4:\"name\";s:5:\"index\";s:4:\"menu\";s:12:\"商家首页\";s:3:\"url\";s:0:\"\";s:4:\"type\";i:3;s:7:\"adminid\";i:1;s:12:\"displayorder\";s:1:\"0\";s:8:\"navtitle\";s:0:\"\";s:7:\"navicon\";s:0:\"\";s:10:\"navsubname\";s:0:\"\";s:9:\"navsuburl\";s:0:\"\";}i:1;a:10:{s:4:\"name\";s:9:\"shopgroup\";s:4:\"menu\";s:9:\"商家组\";s:3:\"url\";s:0:\"\";s:4:\"type\";i:3;s:7:\"adminid\";i:1;s:12:\"displayorder\";s:1:\"1\";s:8:\"navtitle\";s:0:\"\";s:7:\"navicon\";s:0:\"\";s:10:\"navsubname\";s:0:\"\";s:9:\"navsuburl\";s:0:\"\";}i:2;a:10:{s:4:\"name\";s:8:\"shoptype\";s:4:\"menu\";s:12:\"商家模型\";s:3:\"url\";s:0:\"\";s:4:\"type\";i:3;s:7:\"adminid\";i:1;s:12:\"displayorder\";s:1:\"2\";s:8:\"navtitle\";s:0:\"\";s:7:\"navicon\";s:0:\"\";s:10:\"navsubname\";s:0:\"\";s:9:\"navsuburl\";s:0:\"\";}i:3;a:10:{s:4:\"name\";s:8:\"shoplist\";s:4:\"menu\";s:12:\"商家管理\";s:3:\"url\";s:0:\"\";s:4:\"type\";i:3;s:7:\"adminid\";i:1;s:12:\"displayorder\";s:1:\"3\";s:8:\"navtitle\";s:0:\"\";s:7:\"navicon\";s:0:\"\";s:10:\"navsubname\";s:0:\"\";s:9:\"navsuburl\";s:0:\"\";}}', 'V1.0', '1', '', '3', '1376037107', '1377066225');
INSERT INTO `pre_yiqixueba_server_mokuai` VALUES ('4', '0', '1', '0', '会员卡', 'carde', '卡益联盟（一卡通）', '500', '', '', '', 'a:1:{i:0;a:10:{s:4:\"name\";s:5:\"index\";s:4:\"menu\";s:15:\"会员卡首页\";s:3:\"url\";s:0:\"\";s:4:\"type\";i:3;s:7:\"adminid\";i:1;s:12:\"displayorder\";s:1:\"0\";s:8:\"navtitle\";s:0:\"\";s:7:\"navicon\";s:0:\"\";s:10:\"navsubname\";s:0:\"\";s:9:\"navsuburl\";s:0:\"\";}}', 'V1.0', '1', '', '4', '1376893983', '1377066284');

-- ----------------------------
-- Table structure for `pre_yiqixueba_server_mokuaisetting`
-- ----------------------------
DROP TABLE IF EXISTS `pre_yiqixueba_server_mokuaisetting`;
CREATE TABLE `pre_yiqixueba_server_mokuaisetting` (
  `mokuaisettingid` smallint(6) NOT NULL auto_increment,
  `mokuaiid` smallint(6) NOT NULL,
  `identifier` char(20) NOT NULL,
  `name` char(10) NOT NULL,
  `displayorder` smallint(6) NOT NULL,
  PRIMARY KEY  (`mokuaisettingid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pre_yiqixueba_server_mokuaisetting
-- ----------------------------
