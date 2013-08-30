/*
Navicat MySQL Data Transfer

Source Server         : 本地
Source Server Version : 50045
Source Host           : localhost:3306
Source Database       : dz30

Target Server Type    : MYSQL
Target Server Version : 50045
File Encoding         : 65001

Date: 2013-08-30 18:12:59
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
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pre_yiqixueba_mokuai
-- ----------------------------
INSERT INTO `pre_yiqixueba_mokuai` VALUES ('1', '1', '0', '主程序', 'main', '整个插件的主程序', '0', '', '', '', 'a:3:{i:0;a:10:{s:4:\"name\";s:5:\"index\";s:4:\"menu\";s:12:\"平台首页\";s:3:\"url\";s:0:\"\";s:4:\"type\";i:3;s:7:\"adminid\";i:1;s:12:\"displayorder\";s:1:\"0\";s:8:\"navtitle\";s:0:\"\";s:7:\"navicon\";s:0:\"\";s:10:\"navsubname\";s:0:\"\";s:9:\"navsuburl\";s:0:\"\";}i:1;a:10:{s:4:\"name\";s:9:\"pluginreg\";s:4:\"menu\";s:12:\"平台注册\";s:3:\"url\";s:0:\"\";s:4:\"type\";i:3;s:7:\"adminid\";i:1;s:12:\"displayorder\";s:1:\"1\";s:8:\"navtitle\";s:0:\"\";s:7:\"navicon\";s:0:\"\";s:10:\"navsubname\";s:0:\"\";s:9:\"navsuburl\";s:0:\"\";}i:2;a:10:{s:4:\"name\";s:6:\"mokuai\";s:4:\"menu\";s:12:\"模块管理\";s:3:\"url\";s:0:\"\";s:4:\"type\";s:7:\"admincp\";s:7:\"adminid\";i:1;s:12:\"displayorder\";s:1:\"2\";s:8:\"navtitle\";s:0:\"\";s:7:\"navicon\";s:0:\"\";s:10:\"navsubname\";s:0:\"\";s:9:\"navsuburl\";s:0:\"\";}}', 'V1.0', 'a:3:{i:1;a:6:{s:12:\"displayorder\";s:1:\"1\";s:5:\"title\";s:7:\"测试1\";s:11:\"description\";s:15:\"测距库哈斯\";s:4:\"type\";s:4:\"text\";s:8:\"variable\";s:4:\"test\";s:5:\"extra\";s:0:\"\";}i:0;a:4:{s:12:\"displayorder\";s:1:\"2\";s:5:\"title\";s:5:\"gdfgd\";s:8:\"variable\";s:7:\"gdfgdfg\";s:4:\"type\";s:6:\"select\";}i:2;a:4:{s:12:\"displayorder\";s:1:\"3\";s:5:\"title\";s:6:\"你好\";s:8:\"variable\";s:5:\"jkdha\";s:4:\"type\";s:4:\"text\";}}', '1', '1376037107', '1377849241', 'f28a380ea9518ac0f0e2923d7b24bb6d');
INSERT INTO `pre_yiqixueba_mokuai` VALUES ('2', '1', '1', '服务端', 'server', '', '', '', 'yiqixueba_server/', 'www.17xue8.cn', 'a:4:{i:0;a:10:{s:4:\"name\";s:5:\"index\";s:4:\"menu\";s:12:\"后台首页\";s:3:\"url\";s:0:\"\";s:4:\"type\";s:1:\"3\";s:7:\"adminid\";s:1:\"0\";s:12:\"displayorder\";i:0;s:8:\"navtitle\";s:0:\"\";s:7:\"navicon\";s:0:\"\";s:10:\"navsubname\";s:0:\"\";s:9:\"navsuburl\";s:0:\"\";}i:1;a:10:{s:4:\"name\";s:9:\"sitegroup\";s:4:\"menu\";s:9:\"站长组\";s:3:\"url\";s:0:\"\";s:4:\"type\";s:1:\"3\";s:7:\"adminid\";s:1:\"0\";s:12:\"displayorder\";i:1;s:8:\"navtitle\";s:0:\"\";s:7:\"navicon\";s:0:\"\";s:10:\"navsubname\";s:0:\"\";s:9:\"navsuburl\";s:0:\"\";}i:2;a:10:{s:4:\"name\";s:4:\"site\";s:4:\"menu\";s:12:\"站长管理\";s:3:\"url\";s:0:\"\";s:4:\"type\";s:1:\"3\";s:7:\"adminid\";s:1:\"0\";s:12:\"displayorder\";i:2;s:8:\"navtitle\";s:0:\"\";s:7:\"navicon\";s:0:\"\";s:10:\"navsubname\";s:0:\"\";s:9:\"navsuburl\";s:0:\"\";}i:3;a:10:{s:4:\"name\";s:6:\"mokuai\";s:4:\"menu\";s:12:\"模块管理\";s:3:\"url\";s:0:\"\";s:4:\"type\";s:1:\"3\";s:7:\"adminid\";s:1:\"0\";s:12:\"displayorder\";i:3;s:8:\"navtitle\";s:0:\"\";s:7:\"navicon\";s:0:\"\";s:10:\"navsubname\";s:0:\"\";s:9:\"navsuburl\";s:0:\"\";}}', 'V2.0', 'a:0:{}', '0', '0', '0', 'ab8ec4b616b33e1b1221e17532609aed');
INSERT INTO `pre_yiqixueba_mokuai` VALUES ('4', '1', '0', '会员卡', 'carde', '卡益联盟（一卡通）', '500', '', '', '', 'a:1:{i:0;a:10:{s:4:\"name\";s:5:\"index\";s:4:\"menu\";s:15:\"会员卡首页\";s:3:\"url\";s:0:\"\";s:4:\"type\";i:3;s:7:\"adminid\";i:1;s:12:\"displayorder\";s:1:\"0\";s:8:\"navtitle\";s:0:\"\";s:7:\"navicon\";s:0:\"\";s:10:\"navsubname\";s:0:\"\";s:9:\"navsuburl\";s:0:\"\";}}', 'V1.0', '', '4', '1376893983', '1377062430', '766a835157220cc2879731d0e7ef7501');
INSERT INTO `pre_yiqixueba_mokuai` VALUES ('3', '1', '0', '商家联盟', 'shop', '联盟商家程序', '500', '', '', '', 'a:4:{i:0;a:10:{s:4:\"name\";s:5:\"index\";s:4:\"menu\";s:12:\"商家首页\";s:3:\"url\";s:0:\"\";s:4:\"type\";i:3;s:7:\"adminid\";i:1;s:12:\"displayorder\";s:1:\"0\";s:8:\"navtitle\";s:0:\"\";s:7:\"navicon\";s:0:\"\";s:10:\"navsubname\";s:0:\"\";s:9:\"navsuburl\";s:0:\"\";}i:1;a:10:{s:4:\"name\";s:9:\"shopgroup\";s:4:\"menu\";s:9:\"商家组\";s:3:\"url\";s:0:\"\";s:4:\"type\";i:3;s:7:\"adminid\";i:1;s:12:\"displayorder\";s:1:\"1\";s:8:\"navtitle\";s:0:\"\";s:7:\"navicon\";s:0:\"\";s:10:\"navsubname\";s:0:\"\";s:9:\"navsuburl\";s:0:\"\";}i:2;a:10:{s:4:\"name\";s:8:\"shoptype\";s:4:\"menu\";s:12:\"商家模型\";s:3:\"url\";s:0:\"\";s:4:\"type\";i:3;s:7:\"adminid\";i:1;s:12:\"displayorder\";s:1:\"2\";s:8:\"navtitle\";s:0:\"\";s:7:\"navicon\";s:0:\"\";s:10:\"navsubname\";s:0:\"\";s:9:\"navsuburl\";s:0:\"\";}i:3;a:10:{s:4:\"name\";s:8:\"shoplist\";s:4:\"menu\";s:12:\"商家管理\";s:3:\"url\";s:0:\"\";s:4:\"type\";i:3;s:7:\"adminid\";i:1;s:12:\"displayorder\";s:1:\"3\";s:8:\"navtitle\";s:0:\"\";s:7:\"navicon\";s:0:\"\";s:10:\"navsubname\";s:0:\"\";s:9:\"navsuburl\";s:0:\"\";}}', 'V1.0', '', '2', '1376899794', '1376893189', '5f2ceb2cbf55c086aa6162bf95b03940');
INSERT INTO `pre_yiqixueba_mokuai` VALUES ('5', '1', '0', '微信墙', 'weixin', '微信墙主程序', '500', '', '', '', 'a:1:{i:0;a:10:{s:4:\"name\";s:5:\"index\";s:4:\"menu\";s:15:\"微信墙首页\";s:3:\"url\";s:0:\"\";s:4:\"type\";s:7:\"admincp\";s:7:\"adminid\";i:1;s:12:\"displayorder\";s:1:\"0\";s:8:\"navtitle\";s:0:\"\";s:7:\"navicon\";s:0:\"\";s:10:\"navsubname\";s:0:\"\";s:9:\"navsuburl\";s:0:\"\";}}', 'V1.0', '', '5', '1377071393', '1377505550', '');

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
  `available` tinyint(1) NOT NULL default '0',
  `adminid` tinyint(1) unsigned NOT NULL default '0',
  `name` varchar(40) NOT NULL default '',
  `identifier` varchar(40) NOT NULL default '',
  `description` varchar(255) NOT NULL default '',
  `price` char(10) NOT NULL,
  `ico` char(50) NOT NULL,
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
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pre_yiqixueba_server_mokuai
-- ----------------------------
INSERT INTO `pre_yiqixueba_server_mokuai` VALUES ('1', '1', '0', '主程序', 'main', '整个插件的主程序', '0', 'cf/095225luqb7zfbzvfquiw9.jpg', '', '', '', 'a:3:{i:0;a:10:{s:4:\"name\";s:5:\"index\";s:4:\"menu\";s:12:\"平台首页\";s:3:\"url\";s:0:\"\";s:4:\"type\";i:3;s:7:\"adminid\";i:1;s:12:\"displayorder\";s:1:\"0\";s:8:\"navtitle\";s:0:\"\";s:7:\"navicon\";s:0:\"\";s:10:\"navsubname\";s:0:\"\";s:9:\"navsuburl\";s:0:\"\";}i:1;a:10:{s:4:\"name\";s:9:\"pluginreg\";s:4:\"menu\";s:12:\"平台注册\";s:3:\"url\";s:0:\"\";s:4:\"type\";i:3;s:7:\"adminid\";i:1;s:12:\"displayorder\";s:1:\"1\";s:8:\"navtitle\";s:0:\"\";s:7:\"navicon\";s:0:\"\";s:10:\"navsubname\";s:0:\"\";s:9:\"navsuburl\";s:0:\"\";}i:2;a:10:{s:4:\"name\";s:6:\"mokuai\";s:4:\"menu\";s:12:\"模块管理\";s:3:\"url\";s:0:\"\";s:4:\"type\";s:7:\"admincp\";s:7:\"adminid\";i:1;s:12:\"displayorder\";s:1:\"2\";s:8:\"navtitle\";s:0:\"\";s:7:\"navicon\";s:0:\"\";s:10:\"navsubname\";s:0:\"\";s:9:\"navsuburl\";s:0:\"\";}}', 'V1.0', '1', 'a:3:{i:1;a:6:{s:12:\"displayorder\";s:1:\"1\";s:5:\"title\";s:7:\"测试1\";s:11:\"description\";s:15:\"测距库哈斯\";s:4:\"type\";s:4:\"text\";s:8:\"variable\";s:4:\"test\";s:5:\"extra\";s:0:\"\";}i:0;a:4:{s:12:\"displayorder\";s:1:\"2\";s:5:\"title\";s:5:\"gdfgd\";s:8:\"variable\";s:7:\"gdfgdfg\";s:4:\"type\";s:6:\"select\";}i:2;a:4:{s:12:\"displayorder\";s:1:\"3\";s:5:\"title\";s:6:\"你好\";s:8:\"variable\";s:5:\"jkdha\";s:4:\"type\";s:4:\"text\";}}', '1', '1376037107', '1377222745');
INSERT INTO `pre_yiqixueba_server_mokuai` VALUES ('2', '1', '0', '服务端', 'server', '整个插件的服务端程序', '50000', 'cf/155954x5zq49i0ugh4yq5u.jpg', '', '', '', 'a:4:{i:0;a:10:{s:4:\"name\";s:5:\"index\";s:4:\"menu\";s:12:\"后台首页\";s:3:\"url\";s:0:\"\";s:4:\"type\";s:7:\"admincp\";s:7:\"adminid\";i:1;s:12:\"displayorder\";s:1:\"0\";s:8:\"navtitle\";s:0:\"\";s:7:\"navicon\";s:0:\"\";s:10:\"navsubname\";s:0:\"\";s:9:\"navsuburl\";s:0:\"\";}i:1;a:10:{s:4:\"name\";s:9:\"sitegroup\";s:4:\"menu\";s:9:\"站长组\";s:3:\"url\";s:0:\"\";s:4:\"type\";s:7:\"admincp\";s:7:\"adminid\";i:1;s:12:\"displayorder\";s:1:\"1\";s:8:\"navtitle\";s:0:\"\";s:7:\"navicon\";s:0:\"\";s:10:\"navsubname\";s:0:\"\";s:9:\"navsuburl\";s:0:\"\";}i:2;a:10:{s:4:\"name\";s:4:\"site\";s:4:\"menu\";s:12:\"站长管理\";s:3:\"url\";s:0:\"\";s:4:\"type\";s:7:\"admincp\";s:7:\"adminid\";i:1;s:12:\"displayorder\";s:1:\"2\";s:8:\"navtitle\";s:0:\"\";s:7:\"navicon\";s:0:\"\";s:10:\"navsubname\";s:0:\"\";s:9:\"navsuburl\";s:0:\"\";}i:3;a:10:{s:4:\"name\";s:6:\"mokuai\";s:4:\"menu\";s:12:\"模块管理\";s:3:\"url\";s:0:\"\";s:4:\"type\";s:7:\"admincp\";s:7:\"adminid\";i:1;s:12:\"displayorder\";s:1:\"3\";s:8:\"navtitle\";s:0:\"\";s:7:\"navicon\";s:0:\"\";s:10:\"navsubname\";s:0:\"\";s:9:\"navsuburl\";s:0:\"\";}}', 'V1.0', '1', '', '2', '1376037107', '1377244794');
INSERT INTO `pre_yiqixueba_server_mokuai` VALUES ('5', '1', '0', '微信墙', 'weixin', '微信墙主程序', '500', 'cf/164501blq7r7i2inr8g2uv.jpg', '', '', '', 'a:1:{i:0;a:10:{s:4:\"name\";s:5:\"index\";s:4:\"menu\";s:15:\"微信墙首页\";s:3:\"url\";s:0:\"\";s:4:\"type\";s:7:\"admincp\";s:7:\"adminid\";i:1;s:12:\"displayorder\";s:1:\"0\";s:8:\"navtitle\";s:0:\"\";s:7:\"navicon\";s:0:\"\";s:10:\"navsubname\";s:0:\"\";s:9:\"navsuburl\";s:0:\"\";}}', 'V1.0', '0', '', '5', '1377071393', '1377679501');
INSERT INTO `pre_yiqixueba_server_mokuai` VALUES ('3', '1', '0', '商家联盟', 'shop', '联盟商家程序', '500', '', '', '', '', 'a:4:{i:4;a:10:{s:4:\"name\";s:11:\"shopdisplay\";s:4:\"menu\";s:12:\"商家展示\";s:3:\"url\";s:0:\"\";s:4:\"type\";s:5:\"index\";s:7:\"adminid\";i:1;s:12:\"displayorder\";s:1:\"0\";s:8:\"navtitle\";s:0:\"\";s:7:\"navicon\";s:0:\"\";s:10:\"navsubname\";s:0:\"\";s:9:\"navsuburl\";s:0:\"\";}i:1;a:10:{s:4:\"name\";s:9:\"shopgroup\";s:4:\"menu\";s:9:\"商家组\";s:3:\"url\";s:0:\"\";s:4:\"type\";i:3;s:7:\"adminid\";i:1;s:12:\"displayorder\";s:1:\"1\";s:8:\"navtitle\";s:0:\"\";s:7:\"navicon\";s:0:\"\";s:10:\"navsubname\";s:0:\"\";s:9:\"navsuburl\";s:0:\"\";}i:2;a:10:{s:4:\"name\";s:8:\"shoptype\";s:4:\"menu\";s:12:\"商家模型\";s:3:\"url\";s:0:\"\";s:4:\"type\";s:7:\"admincp\";s:7:\"adminid\";i:1;s:12:\"displayorder\";s:1:\"2\";s:8:\"navtitle\";s:0:\"\";s:7:\"navicon\";s:0:\"\";s:10:\"navsubname\";s:0:\"\";s:9:\"navsuburl\";s:0:\"\";}i:3;a:10:{s:4:\"name\";s:8:\"shoplist\";s:4:\"menu\";s:12:\"商家管理\";s:3:\"url\";s:0:\"\";s:4:\"type\";s:7:\"admincp\";s:7:\"adminid\";i:1;s:12:\"displayorder\";s:1:\"3\";s:8:\"navtitle\";s:0:\"\";s:7:\"navicon\";s:0:\"\";s:10:\"navsubname\";s:0:\"\";s:9:\"navsuburl\";s:0:\"\";}}', 'V1.0', '1', '', '3', '1376037107', '1377066225');
INSERT INTO `pre_yiqixueba_server_mokuai` VALUES ('4', '1', '0', '会员卡', 'carde', '卡益联盟（一卡通）', '500', '', '', '', '', 'a:1:{i:0;a:10:{s:4:\"name\";s:5:\"index\";s:4:\"menu\";s:15:\"会员卡首页\";s:3:\"url\";s:0:\"\";s:4:\"type\";s:7:\"admincp\";s:7:\"adminid\";i:1;s:12:\"displayorder\";s:1:\"0\";s:8:\"navtitle\";s:0:\"\";s:7:\"navicon\";s:0:\"\";s:10:\"navsubname\";s:0:\"\";s:9:\"navsuburl\";s:0:\"\";}}', 'V1.0', '1', '', '4', '1376893983', '1377066284');
INSERT INTO `pre_yiqixueba_server_mokuai` VALUES ('6', '1', '0', '兄弟车友会', 'cheyouhui', '车友会', '1000', 'cf/151307bsoj24en0kisnx37.jpg', '', '', '', 'a:1:{i:0;a:10:{s:4:\"name\";s:5:\"index\";s:4:\"menu\";s:15:\"车友会首页\";s:3:\"url\";s:0:\"\";s:4:\"type\";s:7:\"admincp\";s:7:\"adminid\";i:1;s:12:\"displayorder\";s:1:\"0\";s:8:\"navtitle\";s:0:\"\";s:7:\"navicon\";s:0:\"\";s:10:\"navsubname\";s:0:\"\";s:9:\"navsuburl\";s:0:\"\";}}', 'V1.0', '0', '', '6', '1377673385', '1377678655');

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

-- ----------------------------
-- Table structure for `pre_yiqixueba_server_pages`
-- ----------------------------
DROP TABLE IF EXISTS `pre_yiqixueba_server_pages`;
CREATE TABLE `pre_yiqixueba_server_pages` (
  `pageid` smallint(3) unsigned NOT NULL auto_increment,
  `mokuaiid` smallint(3) NOT NULL,
  `type` char(20) NOT NULL,
  `identifier` char(20) NOT NULL,
  `name` char(20) NOT NULL,
  `description` text NOT NULL,
  `displayorder` smallint(3) NOT NULL,
  `available` smallint(3) NOT NULL,
  PRIMARY KEY  (`pageid`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pre_yiqixueba_server_pages
-- ----------------------------
INSERT INTO `pre_yiqixueba_server_pages` VALUES ('1', '1', 'admincp', 'index', '平台首页', '', '1', '0');
INSERT INTO `pre_yiqixueba_server_pages` VALUES ('2', '1', 'admincp', 'pluginreg', '平台注册', '', '0', '0');
INSERT INTO `pre_yiqixueba_server_pages` VALUES ('4', '2', 'admincp', 'index', '后台首页', '', '0', '0');
INSERT INTO `pre_yiqixueba_server_pages` VALUES ('5', '2', 'admincp', 'sitegroup', '站长组', '', '1', '0');
INSERT INTO `pre_yiqixueba_server_pages` VALUES ('6', '2', 'admincp', 'site', '站长管理', '', '2', '0');
INSERT INTO `pre_yiqixueba_server_pages` VALUES ('7', '2', 'admincp', 'mokuai', '模块管理', '', '3', '0');
INSERT INTO `pre_yiqixueba_server_pages` VALUES ('8', '1', 'admincp', 'mokuai', '模块管理', '', '2', '0');
INSERT INTO `pre_yiqixueba_server_pages` VALUES ('10', '3', 'admincp', 'shopgroup', '商家组', '', '1', '0');
INSERT INTO `pre_yiqixueba_server_pages` VALUES ('9', '3', 'admincp', 'index', '商家首页', '', '0', '0');
INSERT INTO `pre_yiqixueba_server_pages` VALUES ('11', '3', 'admincp', 'shoptype', '商家模型', '', '2', '0');
INSERT INTO `pre_yiqixueba_server_pages` VALUES ('12', '3', 'admincp', 'shoplist', '商家管理', '', '3', '0');
INSERT INTO `pre_yiqixueba_server_pages` VALUES ('13', '4', 'admincp', 'index', '会员卡首页', '', '0', '0');
INSERT INTO `pre_yiqixueba_server_pages` VALUES ('14', '5', 'admincp', 'index', '微信墙首页', '', '0', '0');

-- ----------------------------
-- Table structure for `pre_yiqixueba_server_site`
-- ----------------------------
DROP TABLE IF EXISTS `pre_yiqixueba_server_site`;
CREATE TABLE `pre_yiqixueba_server_site` (
  `siteid` mediumint(8) unsigned NOT NULL auto_increment,
  `sitegroup` smallint(3) NOT NULL,
  `siteurl` char(40) NOT NULL,
  `sitekey` char(32) NOT NULL,
  `salt` char(6) NOT NULL,
  `charset` char(10) NOT NULL,
  `clientip` char(20) NOT NULL,
  `version` char(255) NOT NULL,
  `displayorder` mediumint(8) NOT NULL,
  `installtime` int(10) NOT NULL,
  `uninstalltime` int(10) NOT NULL,
  PRIMARY KEY  (`siteid`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pre_yiqixueba_server_site
-- ----------------------------
INSERT INTO `pre_yiqixueba_server_site` VALUES ('1', '1', 'http://localhost/yiqixueba/dz3utf8/', '50dc90ccca1eed10a9b7e46078d2e787', 'B56i5q', 'utf-8', '127.0.0.1', 'X3-20130620-30000000', '0', '1375858133', '0');
INSERT INTO `pre_yiqixueba_server_site` VALUES ('2', '1', 'http://localhost/discuzdemo/dz3gbk/', '83675e079a45c74c2a84a1dab35e7058', 'fmY4BN', 'gbk', '127.0.0.1', 'X3-20130620-30000000', '0', '1377759007', '0');
INSERT INTO `pre_yiqixueba_server_site` VALUES ('3', '1', 'http://localhost/yiqixueba/dz3gbk/', 'a9c2e9d4c7f985c0d23e3896eb3ae57d', 'VAvNfd', 'gbk', '127.0.0.1', 'X3-20130620-30000000', '0', '1377823526', '0');

-- ----------------------------
-- Table structure for `pre_yiqixueba_server_sitegroup`
-- ----------------------------
DROP TABLE IF EXISTS `pre_yiqixueba_server_sitegroup`;
CREATE TABLE `pre_yiqixueba_server_sitegroup` (
  `sitegroupid` smallint(3) unsigned NOT NULL auto_increment,
  `sitegroupname` char(20) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `versions` text NOT NULL,
  `createtime` int(10) unsigned NOT NULL,
  `updatetime` int(10) NOT NULL,
  PRIMARY KEY  (`sitegroupid`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pre_yiqixueba_server_sitegroup
-- ----------------------------
INSERT INTO `pre_yiqixueba_server_sitegroup` VALUES ('1', '安装组', '1', 'a:1:{i:0;s:1:\"1\";}', '1377656493', '1377834232');
INSERT INTO `pre_yiqixueba_server_sitegroup` VALUES ('2', '调试组', '1', 'a:5:{i:0;s:1:\"1\";i:1;s:1:\"3\";i:2;s:1:\"4\";i:3;s:1:\"5\";i:4;s:1:\"6\";}', '1377670792', '1377835863');

-- ----------------------------
-- Table structure for `pre_yiqixueba_setting`
-- ----------------------------
DROP TABLE IF EXISTS `pre_yiqixueba_setting`;
CREATE TABLE `pre_yiqixueba_setting` (
  `skey` varchar(255) NOT NULL,
  `svalue` text NOT NULL,
  PRIMARY KEY  (`skey`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pre_yiqixueba_setting
-- ----------------------------
INSERT INTO `pre_yiqixueba_setting` VALUES ('sitekey', '50dc90ccca1eed10a9b7e46078d2e787');

-- ----------------------------
-- Table structure for `pre_yiqixueba_shop_group`
-- ----------------------------
DROP TABLE IF EXISTS `pre_yiqixueba_shop_group`;
CREATE TABLE `pre_yiqixueba_shop_group` (
  `groupid` smallint(6) unsigned NOT NULL auto_increment,
  `groupname` char(20) NOT NULL,
  PRIMARY KEY  (`groupid`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of pre_yiqixueba_shop_group
-- ----------------------------
