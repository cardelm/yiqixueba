/*
Navicat MySQL Data Transfer

Source Server         : 本地
Source Server Version : 50045
Source Host           : localhost:3306
Source Database       : dz3gbk

Target Server Type    : MYSQL
Target Server Version : 50045
File Encoding         : 65001

Date: 2013-07-30 16:54:48
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `pre_common_plugin`
-- ----------------------------
DROP TABLE IF EXISTS `pre_common_plugin`;
CREATE TABLE `pre_common_plugin` (
  `pluginid` smallint(6) unsigned NOT NULL auto_increment,
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
  PRIMARY KEY  (`pluginid`),
  UNIQUE KEY `identifier` (`identifier`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=gbk;

-- ----------------------------
-- Records of pre_common_plugin
-- ----------------------------
INSERT INTO `pre_common_plugin` VALUES ('1', '0', '1', 'QQ互联', 'qqconnect', '', '', 'qqconnect/', 'Comsenz Inc.', 'a:6:{i:0;a:10:{s:4:\"name\";s:7:\"connect\";s:4:\"menu\";s:0:\"\";s:3:\"url\";s:0:\"\";s:4:\"type\";s:2:\"11\";s:7:\"adminid\";s:1:\"0\";s:12:\"displayorder\";s:1:\"0\";s:8:\"navtitle\";s:0:\"\";s:7:\"navicon\";s:0:\"\";s:10:\"navsubname\";s:0:\"\";s:9:\"navsuburl\";s:0:\"\";}i:1;a:10:{s:4:\"name\";s:7:\"spacecp\";s:4:\"menu\";s:6:\"QQ绑定\";s:3:\"url\";s:0:\"\";s:4:\"type\";s:1:\"7\";s:7:\"adminid\";s:1:\"0\";s:12:\"displayorder\";s:1:\"1\";s:8:\"navtitle\";s:0:\"\";s:7:\"navicon\";s:0:\"\";s:10:\"navsubname\";s:0:\"\";s:9:\"navsuburl\";s:0:\"\";}i:2;a:10:{s:4:\"name\";s:6:\"qqshow\";s:4:\"menu\";s:4:\"QQ秀\";s:3:\"url\";s:0:\"\";s:4:\"type\";s:1:\"7\";s:7:\"adminid\";s:1:\"0\";s:12:\"displayorder\";s:1:\"2\";s:8:\"navtitle\";s:0:\"\";s:7:\"navicon\";s:0:\"\";s:10:\"navsubname\";s:0:\"\";s:9:\"navsuburl\";s:0:\"\";}i:3;a:10:{s:4:\"name\";s:7:\"connect\";s:4:\"menu\";s:0:\"\";s:3:\"url\";s:0:\"\";s:4:\"type\";s:2:\"28\";s:7:\"adminid\";s:1:\"0\";s:12:\"displayorder\";s:1:\"0\";s:8:\"navtitle\";s:0:\"\";s:7:\"navicon\";s:0:\"\";s:10:\"navsubname\";s:0:\"\";s:9:\"navsuburl\";s:0:\"\";}s:6:\"system\";i:2;s:5:\"extra\";a:2:{s:11:\"installtype\";s:0:\"\";s:10:\"langexists\";i:1;}}', '1.17');
INSERT INTO `pre_common_plugin` VALUES ('2', '0', '1', '腾讯分析', 'cloudstat', '', '', 'cloudstat/', 'Comsenz Inc.', 'a:4:{i:0;a:10:{s:4:\"name\";s:9:\"cloudstat\";s:4:\"menu\";s:0:\"\";s:3:\"url\";s:0:\"\";s:4:\"type\";s:2:\"28\";s:7:\"adminid\";s:1:\"0\";s:12:\"displayorder\";s:1:\"0\";s:8:\"navtitle\";s:0:\"\";s:7:\"navicon\";s:0:\"\";s:10:\"navsubname\";s:0:\"\";s:9:\"navsuburl\";s:0:\"\";}i:1;a:10:{s:4:\"name\";s:9:\"cloudstat\";s:4:\"menu\";s:0:\"\";s:3:\"url\";s:0:\"\";s:4:\"type\";s:2:\"11\";s:7:\"adminid\";s:1:\"0\";s:12:\"displayorder\";s:1:\"0\";s:8:\"navtitle\";s:0:\"\";s:7:\"navicon\";s:0:\"\";s:10:\"navsubname\";s:0:\"\";s:9:\"navsuburl\";s:0:\"\";}s:6:\"system\";i:2;s:5:\"extra\";a:1:{s:11:\"installtype\";s:0:\"\";}}', '1.06');
INSERT INTO `pre_common_plugin` VALUES ('3', '0', '1', 'SOSO表情', 'soso_smilies', '', '', 'soso_smilies/', 'Comsenz Inc.', 'a:4:{i:0;a:10:{s:4:\"name\";s:4:\"soso\";s:4:\"menu\";s:0:\"\";s:3:\"url\";s:0:\"\";s:4:\"type\";s:2:\"28\";s:7:\"adminid\";s:1:\"0\";s:12:\"displayorder\";s:1:\"0\";s:8:\"navtitle\";s:0:\"\";s:7:\"navicon\";s:0:\"\";s:10:\"navsubname\";s:0:\"\";s:9:\"navsuburl\";s:0:\"\";}i:1;a:10:{s:4:\"name\";s:4:\"soso\";s:4:\"menu\";s:0:\"\";s:3:\"url\";s:0:\"\";s:4:\"type\";s:2:\"11\";s:7:\"adminid\";s:1:\"0\";s:12:\"displayorder\";s:1:\"0\";s:8:\"navtitle\";s:0:\"\";s:7:\"navicon\";s:0:\"\";s:10:\"navsubname\";s:0:\"\";s:9:\"navsuburl\";s:0:\"\";}s:6:\"system\";i:2;s:5:\"extra\";a:1:{s:11:\"installtype\";s:0:\"\";}}', '1.3');
INSERT INTO `pre_common_plugin` VALUES ('4', '0', '1', '纵横搜索', 'cloudsearch', '', '', 'cloudsearch/', 'Comsenz Inc.', 'a:4:{i:0;a:10:{s:4:\"name\";s:6:\"search\";s:4:\"menu\";s:0:\"\";s:3:\"url\";s:0:\"\";s:4:\"type\";s:2:\"11\";s:7:\"adminid\";s:1:\"0\";s:12:\"displayorder\";s:1:\"0\";s:8:\"navtitle\";s:0:\"\";s:7:\"navicon\";s:0:\"\";s:10:\"navsubname\";s:0:\"\";s:9:\"navsuburl\";s:0:\"\";}i:1;a:10:{s:4:\"name\";s:10:\"search_wap\";s:4:\"menu\";s:0:\"\";s:3:\"url\";s:0:\"\";s:4:\"type\";s:2:\"28\";s:7:\"adminid\";s:1:\"0\";s:12:\"displayorder\";s:1:\"0\";s:8:\"navtitle\";s:0:\"\";s:7:\"navicon\";s:0:\"\";s:10:\"navsubname\";s:0:\"\";s:9:\"navsuburl\";s:0:\"\";}s:6:\"system\";i:2;s:5:\"extra\";a:2:{s:11:\"installtype\";s:0:\"\";s:10:\"langexists\";i:1;}}', '1.07');
INSERT INTO `pre_common_plugin` VALUES ('5', '0', '1', '社区QQ群', 'qqgroup', '', '', 'qqgroup/', 'Comsenz Inc.', 'a:3:{i:0;a:10:{s:4:\"name\";s:7:\"qqgroup\";s:4:\"menu\";s:0:\"\";s:3:\"url\";s:0:\"\";s:4:\"type\";s:2:\"11\";s:7:\"adminid\";s:1:\"0\";s:12:\"displayorder\";s:1:\"0\";s:8:\"navtitle\";s:0:\"\";s:7:\"navicon\";s:0:\"\";s:10:\"navsubname\";s:0:\"\";s:9:\"navsuburl\";s:0:\"\";}s:6:\"system\";i:2;s:5:\"extra\";a:2:{s:11:\"installtype\";s:0:\"\";s:10:\"langexists\";i:1;}}', '1.03');
INSERT INTO `pre_common_plugin` VALUES ('6', '0', '1', '防水墙', 'security', '', '', 'security/', 'Comsenz Inc.', 'a:4:{i:0;a:10:{s:4:\"name\";s:8:\"security\";s:4:\"menu\";s:0:\"\";s:3:\"url\";s:0:\"\";s:4:\"type\";s:2:\"28\";s:7:\"adminid\";s:1:\"0\";s:12:\"displayorder\";s:1:\"1\";s:8:\"navtitle\";s:0:\"\";s:7:\"navicon\";s:0:\"\";s:10:\"navsubname\";s:0:\"\";s:9:\"navsuburl\";s:0:\"\";}i:1;a:10:{s:4:\"name\";s:8:\"security\";s:4:\"menu\";s:0:\"\";s:3:\"url\";s:0:\"\";s:4:\"type\";s:2:\"11\";s:7:\"adminid\";s:1:\"0\";s:12:\"displayorder\";s:1:\"2\";s:8:\"navtitle\";s:0:\"\";s:7:\"navicon\";s:0:\"\";s:10:\"navsubname\";s:0:\"\";s:9:\"navsuburl\";s:0:\"\";}s:6:\"system\";i:2;s:5:\"extra\";a:2:{s:11:\"installtype\";s:0:\"\";s:10:\"langexists\";i:1;}}', '1.11');
INSERT INTO `pre_common_plugin` VALUES ('7', '0', '1', '旋风存储', 'xf_storage', '', '', 'xf_storage/', 'Comsenz Inc.', 'a:3:{i:0;a:10:{s:4:\"name\";s:10:\"xf_storage\";s:4:\"menu\";s:0:\"\";s:3:\"url\";s:0:\"\";s:4:\"type\";s:2:\"11\";s:7:\"adminid\";s:1:\"0\";s:12:\"displayorder\";s:1:\"0\";s:8:\"navtitle\";s:0:\"\";s:7:\"navicon\";s:0:\"\";s:10:\"navsubname\";s:0:\"\";s:9:\"navsuburl\";s:0:\"\";}s:6:\"system\";i:2;s:5:\"extra\";a:2:{s:11:\"installtype\";s:0:\"\";s:10:\"langexists\";i:1;}}', '1.04');
INSERT INTO `pre_common_plugin` VALUES ('8', '1', '1', '手机客户端', 'mobile', '', '', 'mobile/', 'Comsenz Inc.', 'a:4:{i:0;a:10:{s:4:\"name\";s:6:\"mobile\";s:4:\"menu\";s:0:\"\";s:3:\"url\";s:0:\"\";s:4:\"type\";s:2:\"28\";s:7:\"adminid\";s:1:\"0\";s:12:\"displayorder\";s:1:\"0\";s:8:\"navtitle\";s:0:\"\";s:7:\"navicon\";s:0:\"\";s:10:\"navsubname\";s:0:\"\";s:9:\"navsuburl\";s:0:\"\";}i:1;a:10:{s:4:\"name\";s:6:\"mobile\";s:4:\"menu\";s:0:\"\";s:3:\"url\";s:0:\"\";s:4:\"type\";s:2:\"11\";s:7:\"adminid\";s:1:\"0\";s:12:\"displayorder\";s:1:\"0\";s:8:\"navtitle\";s:0:\"\";s:7:\"navicon\";s:0:\"\";s:10:\"navsubname\";s:0:\"\";s:9:\"navsuburl\";s:0:\"\";}s:6:\"system\";i:2;s:5:\"extra\";a:2:{s:11:\"installtype\";s:0:\"\";s:10:\"langexists\";i:1;}}', '1.1');
INSERT INTO `pre_common_plugin` VALUES ('9', '1', '1', '电脑管家网址保镖', 'pcmgr_url_safeguard', '', '', 'pcmgr_url_safeguard/', 'Tencent', 'a:3:{i:0;a:10:{s:4:\"name\";s:19:\"pcmgr_url_safeguard\";s:4:\"menu\";s:0:\"\";s:3:\"url\";s:0:\"\";s:4:\"type\";s:2:\"11\";s:7:\"adminid\";s:1:\"0\";s:12:\"displayorder\";s:1:\"0\";s:8:\"navtitle\";s:0:\"\";s:7:\"navicon\";s:0:\"\";s:10:\"navsubname\";s:0:\"\";s:9:\"navsuburl\";s:0:\"\";}s:6:\"system\";i:1;s:5:\"extra\";a:1:{s:11:\"installtype\";s:0:\"\";}}', '1.1');
INSERT INTO `pre_common_plugin` VALUES ('13', '1', '1', '一起学吧服务端', 'yiqixueba_server', '', '', 'yiqixueba_server/', 'www.17xue8.cn', 'a:4:{i:0;a:10:{s:4:\"name\";s:6:\"mokuai\";s:4:\"menu\";s:8:\"模块管理\";s:3:\"url\";s:0:\"\";s:4:\"type\";s:1:\"3\";s:7:\"adminid\";s:1:\"0\";s:12:\"displayorder\";i:0;s:8:\"navtitle\";s:0:\"\";s:7:\"navicon\";s:0:\"\";s:10:\"navsubname\";s:0:\"\";s:9:\"navsuburl\";s:0:\"\";}i:1;a:10:{s:4:\"name\";s:9:\"sitegroup\";s:4:\"menu\";s:6:\"站长组\";s:3:\"url\";s:0:\"\";s:4:\"type\";s:1:\"3\";s:7:\"adminid\";s:1:\"0\";s:12:\"displayorder\";i:1;s:8:\"navtitle\";s:0:\"\";s:7:\"navicon\";s:0:\"\";s:10:\"navsubname\";s:0:\"\";s:9:\"navsuburl\";s:0:\"\";}i:2;a:10:{s:4:\"name\";s:4:\"site\";s:4:\"menu\";s:8:\"站长管理\";s:3:\"url\";s:0:\"\";s:4:\"type\";s:1:\"3\";s:7:\"adminid\";s:1:\"0\";s:12:\"displayorder\";i:2;s:8:\"navtitle\";s:0:\"\";s:7:\"navicon\";s:0:\"\";s:10:\"navsubname\";s:0:\"\";s:9:\"navsuburl\";s:0:\"\";}s:5:\"extra\";a:1:{s:10:\"langexists\";s:1:\"1\";}}', 'V2.0');
INSERT INTO `pre_common_plugin` VALUES ('14', '0', '1', '商家展示', 'yiqixueba_shop', '', '', 'yiqixueba_shop/', 'www.17xue8.cn', 'a:6:{i:0;a:10:{s:4:\"name\";s:9:\"shopindex\";s:4:\"menu\";s:8:\"商家展示\";s:3:\"url\";s:0:\"\";s:4:\"type\";s:1:\"1\";s:7:\"adminid\";s:1:\"0\";s:12:\"displayorder\";i:0;s:8:\"navtitle\";s:0:\"\";s:7:\"navicon\";s:0:\"\";s:10:\"navsubname\";s:0:\"\";s:9:\"navsuburl\";s:0:\"\";}i:1;a:10:{s:4:\"name\";s:9:\"shopgroup\";s:4:\"menu\";s:6:\"商家组\";s:3:\"url\";s:0:\"\";s:4:\"type\";s:1:\"3\";s:7:\"adminid\";s:1:\"0\";s:12:\"displayorder\";i:0;s:8:\"navtitle\";s:0:\"\";s:7:\"navicon\";s:0:\"\";s:10:\"navsubname\";s:0:\"\";s:9:\"navsuburl\";s:0:\"\";}i:2;a:10:{s:4:\"name\";s:8:\"shopcats\";s:4:\"menu\";s:8:\"商家分类\";s:3:\"url\";s:0:\"\";s:4:\"type\";s:1:\"3\";s:7:\"adminid\";s:1:\"0\";s:12:\"displayorder\";i:1;s:8:\"navtitle\";s:0:\"\";s:7:\"navicon\";s:0:\"\";s:10:\"navsubname\";s:0:\"\";s:9:\"navsuburl\";s:0:\"\";}i:3;a:10:{s:4:\"name\";s:8:\"shoplist\";s:4:\"menu\";s:8:\"商家管理\";s:3:\"url\";s:0:\"\";s:4:\"type\";s:1:\"3\";s:7:\"adminid\";s:1:\"0\";s:12:\"displayorder\";i:2;s:8:\"navtitle\";s:0:\"\";s:7:\"navicon\";s:0:\"\";s:10:\"navsubname\";s:0:\"\";s:9:\"navsuburl\";s:0:\"\";}i:4;a:10:{s:4:\"name\";s:10:\"shopmoxing\";s:4:\"menu\";s:8:\"商家模型\";s:3:\"url\";s:0:\"\";s:4:\"type\";s:1:\"3\";s:7:\"adminid\";s:1:\"0\";s:12:\"displayorder\";i:3;s:8:\"navtitle\";s:0:\"\";s:7:\"navicon\";s:0:\"\";s:10:\"navsubname\";s:0:\"\";s:9:\"navsuburl\";s:0:\"\";}s:5:\"extra\";a:1:{s:10:\"langexists\";s:1:\"1\";}}', 'V2.0');
INSERT INTO `pre_common_plugin` VALUES ('15', '1', '1', '微信墙', 'yiqixueba_wxq', '', '', 'yiqixueba_wxq/', 'www.wxq123.com', 'a:1:{s:5:\"extra\";a:1:{s:10:\"langexists\";s:1:\"1\";}}', 'V2.0');
INSERT INTO `pre_common_plugin` VALUES ('16', '1', '0', '一起学吧', 'yiqixueba', '', '', 'yiqixueba/', 'www.17xue8.cn', 'a:2:{i:0;a:10:{s:4:\"name\";s:9:\"yiqixueba\";s:4:\"menu\";s:0:\"\";s:3:\"url\";s:0:\"\";s:4:\"type\";s:2:\"11\";s:7:\"adminid\";s:1:\"0\";s:12:\"displayorder\";i:0;s:8:\"navtitle\";s:0:\"\";s:7:\"navicon\";s:0:\"\";s:10:\"navsubname\";s:0:\"\";s:9:\"navsuburl\";s:0:\"\";}i:1;a:10:{s:4:\"name\";s:7:\"admincp\";s:4:\"menu\";s:8:\"后台控制\";s:3:\"url\";s:0:\"\";s:4:\"type\";s:1:\"3\";s:7:\"adminid\";s:1:\"0\";s:12:\"displayorder\";i:0;s:8:\"navtitle\";s:0:\"\";s:7:\"navicon\";s:0:\"\";s:10:\"navsubname\";s:0:\"\";s:9:\"navsuburl\";s:0:\"\";}}', 'V2.0');
INSERT INTO `pre_common_plugin` VALUES ('18', '1', '1', '瀑布流图文', 'yiqixueba_pbl', '将论坛列表使用瀑布流的方式显示', '', 'yiqixueba_pbl/', '一起学吧', 'a:4:{i:0;a:10:{s:4:\"name\";s:13:\"yiqixueba_pbl\";s:4:\"menu\";s:0:\"\";s:3:\"url\";s:0:\"\";s:4:\"type\";s:2:\"11\";s:7:\"adminid\";s:1:\"0\";s:12:\"displayorder\";s:1:\"0\";s:8:\"navtitle\";s:0:\"\";s:7:\"navicon\";s:0:\"\";s:10:\"navsubname\";s:0:\"\";s:9:\"navsuburl\";s:0:\"\";}i:1;a:10:{s:4:\"name\";s:13:\"yiqixueba_pbl\";s:4:\"menu\";s:10:\"瀑布流图文\";s:3:\"url\";s:41:\"plugin.php?id=yiqixueba_pbl:yiqixueba_pbl\";s:4:\"type\";s:1:\"1\";s:7:\"adminid\";s:1:\"0\";s:12:\"displayorder\";s:1:\"0\";s:8:\"navtitle\";s:0:\"\";s:7:\"navicon\";s:0:\"\";s:10:\"navsubname\";s:0:\"\";s:9:\"navsuburl\";s:0:\"\";}i:2;a:10:{s:4:\"name\";s:10:\"buildthumb\";s:4:\"menu\";s:10:\"重建缩略图\";s:3:\"url\";s:0:\"\";s:4:\"type\";s:1:\"3\";s:7:\"adminid\";s:1:\"0\";s:12:\"displayorder\";s:1:\"0\";s:8:\"navtitle\";s:0:\"\";s:7:\"navicon\";s:0:\"\";s:10:\"navsubname\";s:0:\"\";s:9:\"navsuburl\";s:0:\"\";}s:5:\"extra\";a:2:{s:11:\"installtype\";s:0:\"\";s:10:\"langexists\";i:1;}}', 'V1.0');
INSERT INTO `pre_common_plugin` VALUES ('17', '0', '1', '平台主程序', 'yiqixueba_mainpro', '', '', 'yiqixueba_mainpro/', 'www.17xue8.cn', 'a:4:{i:0;a:10:{s:4:\"name\";s:5:\"index\";s:4:\"menu\";s:8:\"平台首页\";s:3:\"url\";s:0:\"\";s:4:\"type\";s:1:\"3\";s:7:\"adminid\";s:1:\"0\";s:12:\"displayorder\";i:0;s:8:\"navtitle\";s:0:\"\";s:7:\"navicon\";s:0:\"\";s:10:\"navsubname\";s:0:\"\";s:9:\"navsuburl\";s:0:\"\";}i:1;a:10:{s:4:\"name\";s:9:\"pluginreg\";s:4:\"menu\";s:8:\"平台注册\";s:3:\"url\";s:0:\"\";s:4:\"type\";s:1:\"3\";s:7:\"adminid\";s:1:\"0\";s:12:\"displayorder\";i:1;s:8:\"navtitle\";s:0:\"\";s:7:\"navicon\";s:0:\"\";s:10:\"navsubname\";s:0:\"\";s:9:\"navsuburl\";s:0:\"\";}i:2;a:10:{s:4:\"name\";s:6:\"mokuai\";s:4:\"menu\";s:8:\"模块管理\";s:3:\"url\";s:0:\"\";s:4:\"type\";s:1:\"3\";s:7:\"adminid\";s:1:\"0\";s:12:\"displayorder\";i:2;s:8:\"navtitle\";s:0:\"\";s:7:\"navicon\";s:0:\"\";s:10:\"navsubname\";s:0:\"\";s:9:\"navsuburl\";s:0:\"\";}s:5:\"extra\";a:1:{s:10:\"langexists\";s:1:\"1\";}}', 'V2.0');
INSERT INTO `pre_common_plugin` VALUES ('19', '1', '1', '推荐人', 'yiqixueba_tuijianren', '', '', 'yiqixueba_tuijianren/', 'YiQiXueBa', 'a:4:{i:0;a:10:{s:4:\"name\";s:7:\"admincp\";s:4:\"menu\";s:8:\"插件注册\";s:3:\"url\";s:0:\"\";s:4:\"type\";s:1:\"3\";s:7:\"adminid\";s:1:\"0\";s:12:\"displayorder\";s:1:\"0\";s:8:\"navtitle\";s:0:\"\";s:7:\"navicon\";s:0:\"\";s:10:\"navsubname\";s:0:\"\";s:9:\"navsuburl\";s:0:\"\";}i:1;a:10:{s:4:\"name\";s:10:\"tuijianren\";s:4:\"menu\";s:0:\"\";s:3:\"url\";s:0:\"\";s:4:\"type\";s:2:\"11\";s:7:\"adminid\";s:1:\"0\";s:12:\"displayorder\";s:1:\"0\";s:8:\"navtitle\";s:0:\"\";s:7:\"navicon\";s:0:\"\";s:10:\"navsubname\";s:0:\"\";s:9:\"navsuburl\";s:0:\"\";}i:2;a:10:{s:4:\"name\";s:7:\"tjrlist\";s:4:\"menu\";s:8:\"我的推广\";s:3:\"url\";s:0:\"\";s:4:\"type\";s:1:\"7\";s:7:\"adminid\";s:1:\"0\";s:12:\"displayorder\";s:1:\"0\";s:8:\"navtitle\";s:0:\"\";s:7:\"navicon\";s:0:\"\";s:10:\"navsubname\";s:0:\"\";s:9:\"navsuburl\";s:0:\"\";}s:5:\"extra\";a:2:{s:11:\"installtype\";s:0:\"\";s:10:\"langexists\";i:1;}}', 'V1.0');

-- ----------------------------
-- Table structure for `pre_common_pluginvar`
-- ----------------------------
DROP TABLE IF EXISTS `pre_common_pluginvar`;
CREATE TABLE `pre_common_pluginvar` (
  `pluginvarid` mediumint(8) unsigned NOT NULL auto_increment,
  `pluginid` smallint(6) unsigned NOT NULL default '0',
  `displayorder` tinyint(3) NOT NULL default '0',
  `title` varchar(100) NOT NULL default '',
  `description` varchar(255) NOT NULL default '',
  `variable` varchar(40) NOT NULL default '',
  `type` varchar(20) NOT NULL default 'text',
  `value` text NOT NULL,
  `extra` text NOT NULL,
  PRIMARY KEY  (`pluginvarid`),
  KEY `pluginid` (`pluginid`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=gbk;

-- ----------------------------
-- Records of pre_common_pluginvar
-- ----------------------------
INSERT INTO `pre_common_pluginvar` VALUES ('1', '14', '0', '选用模板', '', 'shoptemplate', 'text', 'default', '');
INSERT INTO `pre_common_pluginvar` VALUES ('2', '18', '0', '导航模式', '1、顶部版块主题分类导航加左上主题分类导航：这种适合需要顶部导航的网站，版块最多选择6个，最适宜选择6个\r\n2、左上版块和主题分类导航：适合只在左上侧显示导航的网站，版块没有限制\r\n3、无导航：适合一个版块不需要导航的网站\r\n4、按照分区、板块、主题逐步筛选方式进行导 ...', 'navmode', 'select', '4', '1=顶部版块主题分类导航加左上主题分类导航\r\n2=左上版块和主题分类导航\r\n3=无导航\r\n4=新建自定义导航');
INSERT INTO `pre_common_pluginvar` VALUES ('3', '18', '1', '指定使用版块', '', 'forumidlist', 'forums', 'a:1:{i:0;s:1:\"2\";}', '');
INSERT INTO `pre_common_pluginvar` VALUES ('4', '18', '2', '是否启用主题分类', '', 'usetypeid', 'radio', '1', '');
INSERT INTO `pre_common_pluginvar` VALUES ('5', '18', '3', '默认排序方式', '', 'defaultorderby', 'select', '1', '1=发表时间\r\n2=回复时间\r\n3=查看数量\r\n4=回复数量\r\n5=随机');
INSERT INTO `pre_common_pluginvar` VALUES ('6', '18', '4', '主题帖内容字数', '', 'lengthforpost', 'number', '100', '');
INSERT INTO `pre_common_pluginvar` VALUES ('7', '18', '5', '只调有图主题', '', 'onlypic', 'radio', '1', '');
INSERT INTO `pre_common_pluginvar` VALUES ('8', '18', '6', '每次加载主题数', '', 'eachload', 'number', '6', '');
INSERT INTO `pre_common_pluginvar` VALUES ('9', '18', '7', '每页加载次数', '', 'loadsperpage', 'number', '4', '');
INSERT INTO `pre_common_pluginvar` VALUES ('10', '18', '8', '封面图片宽度', '', 'picwidth', 'number', '212', '');
INSERT INTO `pre_common_pluginvar` VALUES ('11', '18', '9', '封面图片最大高度', '', 'picmaxheight', 'number', '640', '');
INSERT INTO `pre_common_pluginvar` VALUES ('12', '18', '10', '是否采用缩略图', '', 'usethumb', 'radio', '1', '');
INSERT INTO `pre_common_pluginvar` VALUES ('13', '18', '11', '生成缩略图宽度', '', 'thumbwidth', 'number', '300', '');
INSERT INTO `pre_common_pluginvar` VALUES ('14', '18', '12', '生成缩略图高度', '', 'thumbheight', 'number', '800', '');
INSERT INTO `pre_common_pluginvar` VALUES ('15', '18', '13', '页面标题', 'SEO标题', 'navtitle', 'text', '瀑布流图文', '');
INSERT INTO `pre_common_pluginvar` VALUES ('16', '18', '14', '页面关键字', 'SEO关键字', 'metakeywords', 'textarea', '瀑布流', '');
INSERT INTO `pre_common_pluginvar` VALUES ('17', '18', '15', '页面描述', 'SEO描述', 'metadescription', 'textarea', '将选定版块的主题以瀑布流的方式呈现在一个页面中', '');

-- ----------------------------
-- Table structure for `pre_yiqixueba_mainpro_index`
-- ----------------------------
DROP TABLE IF EXISTS `pre_yiqixueba_mainpro_index`;
CREATE TABLE `pre_yiqixueba_mainpro_index` (
  `indexid` mediumint(8) unsigned NOT NULL auto_increment,
  `indexname` char(40) NOT NULL,
  `displayorder` mediumint(8) NOT NULL,
  PRIMARY KEY  (`indexid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

-- ----------------------------
-- Records of pre_yiqixueba_mainpro_index
-- ----------------------------

-- ----------------------------
-- Table structure for `pre_yiqixueba_mainpro_mokuai`
-- ----------------------------
DROP TABLE IF EXISTS `pre_yiqixueba_mainpro_mokuai`;
CREATE TABLE `pre_yiqixueba_mainpro_mokuai` (
  `mokuaiid` mediumint(8) unsigned NOT NULL auto_increment,
  `mokuainame` char(40) NOT NULL,
  `displayorder` mediumint(8) NOT NULL,
  PRIMARY KEY  (`mokuaiid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

-- ----------------------------
-- Records of pre_yiqixueba_mainpro_mokuai
-- ----------------------------

-- ----------------------------
-- Table structure for `pre_yiqixueba_mainpro_pluginreg`
-- ----------------------------
DROP TABLE IF EXISTS `pre_yiqixueba_mainpro_pluginreg`;
CREATE TABLE `pre_yiqixueba_mainpro_pluginreg` (
  `pluginregid` mediumint(8) unsigned NOT NULL auto_increment,
  `pluginregname` char(40) NOT NULL,
  `displayorder` mediumint(8) NOT NULL,
  PRIMARY KEY  (`pluginregid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

-- ----------------------------
-- Records of pre_yiqixueba_mainpro_pluginreg
-- ----------------------------

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
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=gbk;

-- ----------------------------
-- Records of pre_yiqixueba_mokuai
-- ----------------------------
INSERT INTO `pre_yiqixueba_mokuai` VALUES ('1', '14', '1', '1', '商家展示', 'shop', '', '', 'yiqixueba_shop/', 'www.17xue8.cn', 'a:6:{i:0;a:10:{s:4:\"name\";s:9:\"shopindex\";s:4:\"menu\";s:8:\"商家展示\";s:3:\"url\";s:0:\"\";s:4:\"type\";s:1:\"1\";s:7:\"adminid\";s:1:\"0\";s:12:\"displayorder\";i:0;s:8:\"navtitle\";s:0:\"\";s:7:\"navicon\";s:0:\"\";s:10:\"navsubname\";s:0:\"\";s:9:\"navsuburl\";s:0:\"\";}i:1;a:10:{s:4:\"name\";s:9:\"shopgroup\";s:4:\"menu\";s:6:\"商家组\";s:3:\"url\";s:0:\"\";s:4:\"type\";s:1:\"3\";s:7:\"adminid\";s:1:\"0\";s:12:\"displayorder\";i:0;s:8:\"navtitle\";s:0:\"\";s:7:\"navicon\";s:0:\"\";s:10:\"navsubname\";s:0:\"\";s:9:\"navsuburl\";s:0:\"\";}i:2;a:10:{s:4:\"name\";s:8:\"shopcats\";s:4:\"menu\";s:8:\"商家分类\";s:3:\"url\";s:0:\"\";s:4:\"type\";s:1:\"3\";s:7:\"adminid\";s:1:\"0\";s:12:\"displayorder\";i:1;s:8:\"navtitle\";s:0:\"\";s:7:\"navicon\";s:0:\"\";s:10:\"navsubname\";s:0:\"\";s:9:\"navsuburl\";s:0:\"\";}i:3;a:10:{s:4:\"name\";s:8:\"shoplist\";s:4:\"menu\";s:8:\"商家管理\";s:3:\"url\";s:0:\"\";s:4:\"type\";s:1:\"3\";s:7:\"adminid\";s:1:\"0\";s:12:\"displayorder\";i:2;s:8:\"navtitle\";s:0:\"\";s:7:\"navicon\";s:0:\"\";s:10:\"navsubname\";s:0:\"\";s:9:\"navsuburl\";s:0:\"\";}i:4;a:10:{s:4:\"name\";s:10:\"shopmoxing\";s:4:\"menu\";s:8:\"商家模型\";s:3:\"url\";s:0:\"\";s:4:\"type\";s:1:\"3\";s:7:\"adminid\";s:1:\"0\";s:12:\"displayorder\";i:3;s:8:\"navtitle\";s:0:\"\";s:7:\"navicon\";s:0:\"\";s:10:\"navsubname\";s:0:\"\";s:9:\"navsuburl\";s:0:\"\";}s:5:\"extra\";a:1:{s:10:\"langexists\";s:1:\"1\";}}', 'V2.0', 'a:1:{i:0;a:9:{s:11:\"pluginvarid\";s:1:\"1\";s:8:\"pluginid\";s:2:\"14\";s:12:\"displayorder\";s:1:\"0\";s:5:\"title\";s:8:\"选用模板\";s:11:\"description\";s:0:\"\";s:8:\"variable\";s:12:\"shoptemplate\";s:4:\"type\";s:4:\"text\";s:5:\"value\";s:7:\"default\";s:5:\"extra\";s:0:\"\";}}', '1');
INSERT INTO `pre_yiqixueba_mokuai` VALUES ('2', '15', '1', '1', '微信墙', 'wxq', '', '', 'yiqixueba_wxq/', 'www.wxq123.com', 'a:1:{s:5:\"extra\";a:1:{s:10:\"langexists\";s:1:\"1\";}}', 'V2.0', 'a:0:{}', '2');
INSERT INTO `pre_yiqixueba_mokuai` VALUES ('3', '17', '1', '1', '平台主程序', 'mainpro', '', '', 'yiqixueba_mainpro/', 'www.17xue8.cn', 'a:4:{i:0;a:10:{s:4:\"name\";s:5:\"index\";s:4:\"menu\";s:8:\"平台首页\";s:3:\"url\";s:0:\"\";s:4:\"type\";s:1:\"3\";s:7:\"adminid\";s:1:\"0\";s:12:\"displayorder\";i:0;s:8:\"navtitle\";s:0:\"\";s:7:\"navicon\";s:0:\"\";s:10:\"navsubname\";s:0:\"\";s:9:\"navsuburl\";s:0:\"\";}i:1;a:10:{s:4:\"name\";s:9:\"pluginreg\";s:4:\"menu\";s:8:\"平台注册\";s:3:\"url\";s:0:\"\";s:4:\"type\";s:1:\"3\";s:7:\"adminid\";s:1:\"0\";s:12:\"displayorder\";i:1;s:8:\"navtitle\";s:0:\"\";s:7:\"navicon\";s:0:\"\";s:10:\"navsubname\";s:0:\"\";s:9:\"navsuburl\";s:0:\"\";}i:2;a:10:{s:4:\"name\";s:6:\"mokuai\";s:4:\"menu\";s:8:\"模块管理\";s:3:\"url\";s:0:\"\";s:4:\"type\";s:1:\"3\";s:7:\"adminid\";s:1:\"0\";s:12:\"displayorder\";i:2;s:8:\"navtitle\";s:0:\"\";s:7:\"navicon\";s:0:\"\";s:10:\"navsubname\";s:0:\"\";s:9:\"navsuburl\";s:0:\"\";}s:5:\"extra\";a:1:{s:10:\"langexists\";s:1:\"1\";}}', 'V2.0', 'a:0:{}', '0');

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
-- Table structure for `pre_yiqixueba_pbl_buildthumb`
-- ----------------------------
DROP TABLE IF EXISTS `pre_yiqixueba_pbl_buildthumb`;
CREATE TABLE `pre_yiqixueba_pbl_buildthumb` (
  `buildthumbid` mediumint(8) unsigned NOT NULL auto_increment,
  `buildthumbname` char(40) NOT NULL,
  `displayorder` mediumint(8) NOT NULL,
  PRIMARY KEY  (`buildthumbid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

-- ----------------------------
-- Records of pre_yiqixueba_pbl_buildthumb
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
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=gbk;

-- ----------------------------
-- Records of pre_yiqixueba_server_mokuai
-- ----------------------------
INSERT INTO `pre_yiqixueba_server_mokuai` VALUES ('1', '14', '1', '1', '商家展示', 'shop', '', '', 'yiqixueba_shop/', 'www.17xue8.cn', 'a:6:{i:0;a:10:{s:4:\"name\";s:9:\"shopindex\";s:4:\"menu\";s:8:\"商家展示\";s:3:\"url\";s:0:\"\";s:4:\"type\";s:1:\"1\";s:7:\"adminid\";s:1:\"0\";s:12:\"displayorder\";i:0;s:8:\"navtitle\";s:0:\"\";s:7:\"navicon\";s:0:\"\";s:10:\"navsubname\";s:0:\"\";s:9:\"navsuburl\";s:0:\"\";}i:1;a:10:{s:4:\"name\";s:9:\"shopgroup\";s:4:\"menu\";s:6:\"商家组\";s:3:\"url\";s:0:\"\";s:4:\"type\";s:1:\"3\";s:7:\"adminid\";s:1:\"0\";s:12:\"displayorder\";i:0;s:8:\"navtitle\";s:0:\"\";s:7:\"navicon\";s:0:\"\";s:10:\"navsubname\";s:0:\"\";s:9:\"navsuburl\";s:0:\"\";}i:2;a:10:{s:4:\"name\";s:8:\"shopcats\";s:4:\"menu\";s:8:\"商家分类\";s:3:\"url\";s:0:\"\";s:4:\"type\";s:1:\"3\";s:7:\"adminid\";s:1:\"0\";s:12:\"displayorder\";i:1;s:8:\"navtitle\";s:0:\"\";s:7:\"navicon\";s:0:\"\";s:10:\"navsubname\";s:0:\"\";s:9:\"navsuburl\";s:0:\"\";}i:3;a:10:{s:4:\"name\";s:8:\"shoplist\";s:4:\"menu\";s:8:\"商家管理\";s:3:\"url\";s:0:\"\";s:4:\"type\";s:1:\"3\";s:7:\"adminid\";s:1:\"0\";s:12:\"displayorder\";i:2;s:8:\"navtitle\";s:0:\"\";s:7:\"navicon\";s:0:\"\";s:10:\"navsubname\";s:0:\"\";s:9:\"navsuburl\";s:0:\"\";}i:4;a:10:{s:4:\"name\";s:10:\"shopmoxing\";s:4:\"menu\";s:8:\"商家模型\";s:3:\"url\";s:0:\"\";s:4:\"type\";s:1:\"3\";s:7:\"adminid\";s:1:\"0\";s:12:\"displayorder\";i:3;s:8:\"navtitle\";s:0:\"\";s:7:\"navicon\";s:0:\"\";s:10:\"navsubname\";s:0:\"\";s:9:\"navsuburl\";s:0:\"\";}s:5:\"extra\";a:1:{s:10:\"langexists\";s:1:\"1\";}}', 'V2.0', 'a:1:{i:0;a:9:{s:11:\"pluginvarid\";s:1:\"1\";s:8:\"pluginid\";s:2:\"14\";s:12:\"displayorder\";s:1:\"0\";s:5:\"title\";s:8:\"选用模板\";s:11:\"description\";s:0:\"\";s:8:\"variable\";s:12:\"shoptemplate\";s:4:\"type\";s:4:\"text\";s:5:\"value\";s:7:\"default\";s:5:\"extra\";s:0:\"\";}}', '0');
INSERT INTO `pre_yiqixueba_server_mokuai` VALUES ('2', '15', '1', '1', '微信墙', 'wxq', '', '', 'yiqixueba_wxq/', 'www.wxq123.com', 'a:1:{s:5:\"extra\";a:1:{s:10:\"langexists\";s:1:\"1\";}}', 'V2.0', 'a:0:{}', '0');
INSERT INTO `pre_yiqixueba_server_mokuai` VALUES ('3', '17', '1', '1', '平台主程序', 'mainpro', '', '', 'yiqixueba_mainpro/', 'www.17xue8.cn', 'a:4:{i:0;a:10:{s:4:\"name\";s:5:\"index\";s:4:\"menu\";s:8:\"平台首页\";s:3:\"url\";s:0:\"\";s:4:\"type\";s:1:\"3\";s:7:\"adminid\";s:1:\"0\";s:12:\"displayorder\";i:0;s:8:\"navtitle\";s:0:\"\";s:7:\"navicon\";s:0:\"\";s:10:\"navsubname\";s:0:\"\";s:9:\"navsuburl\";s:0:\"\";}i:1;a:10:{s:4:\"name\";s:9:\"pluginreg\";s:4:\"menu\";s:8:\"平台注册\";s:3:\"url\";s:0:\"\";s:4:\"type\";s:1:\"3\";s:7:\"adminid\";s:1:\"0\";s:12:\"displayorder\";i:1;s:8:\"navtitle\";s:0:\"\";s:7:\"navicon\";s:0:\"\";s:10:\"navsubname\";s:0:\"\";s:9:\"navsuburl\";s:0:\"\";}i:2;a:10:{s:4:\"name\";s:6:\"mokuai\";s:4:\"menu\";s:8:\"模块管理\";s:3:\"url\";s:0:\"\";s:4:\"type\";s:1:\"3\";s:7:\"adminid\";s:1:\"0\";s:12:\"displayorder\";i:2;s:8:\"navtitle\";s:0:\"\";s:7:\"navicon\";s:0:\"\";s:10:\"navsubname\";s:0:\"\";s:9:\"navsuburl\";s:0:\"\";}s:5:\"extra\";a:1:{s:10:\"langexists\";s:1:\"1\";}}', 'V2.0', 'a:0:{}', '0');
INSERT INTO `pre_yiqixueba_server_mokuai` VALUES ('4', '13', '1', '1', '一起学吧服务端', 'server', '', '', 'yiqixueba_server/', 'www.17xue8.cn', 'a:4:{i:0;a:10:{s:4:\"name\";s:6:\"mokuai\";s:4:\"menu\";s:8:\"模块管理\";s:3:\"url\";s:0:\"\";s:4:\"type\";s:1:\"3\";s:7:\"adminid\";s:1:\"0\";s:12:\"displayorder\";i:0;s:8:\"navtitle\";s:0:\"\";s:7:\"navicon\";s:0:\"\";s:10:\"navsubname\";s:0:\"\";s:9:\"navsuburl\";s:0:\"\";}i:1;a:10:{s:4:\"name\";s:9:\"sitegroup\";s:4:\"menu\";s:6:\"站长组\";s:3:\"url\";s:0:\"\";s:4:\"type\";s:1:\"3\";s:7:\"adminid\";s:1:\"0\";s:12:\"displayorder\";i:1;s:8:\"navtitle\";s:0:\"\";s:7:\"navicon\";s:0:\"\";s:10:\"navsubname\";s:0:\"\";s:9:\"navsuburl\";s:0:\"\";}i:2;a:10:{s:4:\"name\";s:4:\"site\";s:4:\"menu\";s:8:\"站长管理\";s:3:\"url\";s:0:\"\";s:4:\"type\";s:1:\"3\";s:7:\"adminid\";s:1:\"0\";s:12:\"displayorder\";i:2;s:8:\"navtitle\";s:0:\"\";s:7:\"navicon\";s:0:\"\";s:10:\"navsubname\";s:0:\"\";s:9:\"navsuburl\";s:0:\"\";}s:5:\"extra\";a:1:{s:10:\"langexists\";s:1:\"1\";}}', 'V2.0', 'a:0:{}', '0');
INSERT INTO `pre_yiqixueba_server_mokuai` VALUES ('5', '18', '1', '1', '瀑布流图文', 'pbl', '将论坛列表使用瀑布流的方式显示', '', 'yiqixueba_pbl/', '一起学吧', 'a:4:{i:0;a:10:{s:4:\"name\";s:13:\"yiqixueba_pbl\";s:4:\"menu\";s:0:\"\";s:3:\"url\";s:0:\"\";s:4:\"type\";s:2:\"11\";s:7:\"adminid\";s:1:\"0\";s:12:\"displayorder\";s:1:\"0\";s:8:\"navtitle\";s:0:\"\";s:7:\"navicon\";s:0:\"\";s:10:\"navsubname\";s:0:\"\";s:9:\"navsuburl\";s:0:\"\";}i:1;a:10:{s:4:\"name\";s:13:\"yiqixueba_pbl\";s:4:\"menu\";s:10:\"瀑布流图文\";s:3:\"url\";s:41:\"plugin.php?id=yiqixueba_pbl:yiqixueba_pbl\";s:4:\"type\";s:1:\"1\";s:7:\"adminid\";s:1:\"0\";s:12:\"displayorder\";s:1:\"0\";s:8:\"navtitle\";s:0:\"\";s:7:\"navicon\";s:0:\"\";s:10:\"navsubname\";s:0:\"\";s:9:\"navsuburl\";s:0:\"\";}i:2;a:10:{s:4:\"name\";s:10:\"buildthumb\";s:4:\"menu\";s:10:\"重建缩略图\";s:3:\"url\";s:0:\"\";s:4:\"type\";s:1:\"3\";s:7:\"adminid\";s:1:\"0\";s:12:\"displayorder\";s:1:\"0\";s:8:\"navtitle\";s:0:\"\";s:7:\"navicon\";s:0:\"\";s:10:\"navsubname\";s:0:\"\";s:9:\"navsuburl\";s:0:\"\";}s:5:\"extra\";a:2:{s:11:\"installtype\";s:0:\"\";s:10:\"langexists\";i:1;}}', 'V1.0', 'a:16:{i:0;a:9:{s:11:\"pluginvarid\";s:1:\"2\";s:8:\"pluginid\";s:2:\"18\";s:12:\"displayorder\";s:1:\"0\";s:5:\"title\";s:8:\"导航模式\";s:11:\"description\";s:260:\"1、顶部版块主题分类导航加左上主题分类导航：这种适合需要顶部导航的网站，版块最多选择6个，最适宜选择6个\r\n2、左上版块和主题分类导航：适合只在左上侧显示导航的网站，版块没有限制\r\n3、无导航：适合一个版块不需要导航的网站\r\n4、按照分区、板块、主题逐步筛选方式进行导 ...\";s:8:\"variable\";s:7:\"navmode\";s:4:\"type\";s:6:\"select\";s:5:\"value\";s:1:\"4\";s:5:\"extra\";s:94:\"1=顶部版块主题分类导航加左上主题分类导航\r\n2=左上版块和主题分类导航\r\n3=无导航\r\n4=新建自定义导航\";}i:1;a:9:{s:11:\"pluginvarid\";s:1:\"3\";s:8:\"pluginid\";s:2:\"18\";s:12:\"displayorder\";s:1:\"1\";s:5:\"title\";s:12:\"指定使用版块\";s:11:\"description\";s:0:\"\";s:8:\"variable\";s:11:\"forumidlist\";s:4:\"type\";s:6:\"forums\";s:5:\"value\";s:18:\"a:1:{i:0;s:1:\"2\";}\";s:5:\"extra\";s:0:\"\";}i:2;a:9:{s:11:\"pluginvarid\";s:1:\"4\";s:8:\"pluginid\";s:2:\"18\";s:12:\"displayorder\";s:1:\"2\";s:5:\"title\";s:16:\"是否启用主题分类\";s:11:\"description\";s:0:\"\";s:8:\"variable\";s:9:\"usetypeid\";s:4:\"type\";s:5:\"radio\";s:5:\"value\";s:1:\"1\";s:5:\"extra\";s:0:\"\";}i:3;a:9:{s:11:\"pluginvarid\";s:1:\"5\";s:8:\"pluginid\";s:2:\"18\";s:12:\"displayorder\";s:1:\"3\";s:5:\"title\";s:12:\"默认排序方式\";s:11:\"description\";s:0:\"\";s:8:\"variable\";s:14:\"defaultorderby\";s:4:\"type\";s:6:\"select\";s:5:\"value\";s:1:\"1\";s:5:\"extra\";s:54:\"1=发表时间\r\n2=回复时间\r\n3=查看数量\r\n4=回复数量\r\n5=随机\";}i:4;a:9:{s:11:\"pluginvarid\";s:1:\"6\";s:8:\"pluginid\";s:2:\"18\";s:12:\"displayorder\";s:1:\"4\";s:5:\"title\";s:14:\"主题帖内容字数\";s:11:\"description\";s:0:\"\";s:8:\"variable\";s:13:\"lengthforpost\";s:4:\"type\";s:6:\"number\";s:5:\"value\";s:3:\"100\";s:5:\"extra\";s:0:\"\";}i:5;a:9:{s:11:\"pluginvarid\";s:1:\"7\";s:8:\"pluginid\";s:2:\"18\";s:12:\"displayorder\";s:1:\"5\";s:5:\"title\";s:12:\"只调有图主题\";s:11:\"description\";s:0:\"\";s:8:\"variable\";s:7:\"onlypic\";s:4:\"type\";s:5:\"radio\";s:5:\"value\";s:1:\"1\";s:5:\"extra\";s:0:\"\";}i:6;a:9:{s:11:\"pluginvarid\";s:1:\"8\";s:8:\"pluginid\";s:2:\"18\";s:12:\"displayorder\";s:1:\"6\";s:5:\"title\";s:14:\"每次加载主题数\";s:11:\"description\";s:0:\"\";s:8:\"variable\";s:8:\"eachload\";s:4:\"type\";s:6:\"number\";s:5:\"value\";s:1:\"6\";s:5:\"extra\";s:0:\"\";}i:7;a:9:{s:11:\"pluginvarid\";s:1:\"9\";s:8:\"pluginid\";s:2:\"18\";s:12:\"displayorder\";s:1:\"7\";s:5:\"title\";s:12:\"每页加载次数\";s:11:\"description\";s:0:\"\";s:8:\"variable\";s:12:\"loadsperpage\";s:4:\"type\";s:6:\"number\";s:5:\"value\";s:1:\"4\";s:5:\"extra\";s:0:\"\";}i:8;a:9:{s:11:\"pluginvarid\";s:2:\"10\";s:8:\"pluginid\";s:2:\"18\";s:12:\"displayorder\";s:1:\"8\";s:5:\"title\";s:12:\"封面图片宽度\";s:11:\"description\";s:0:\"\";s:8:\"variable\";s:8:\"picwidth\";s:4:\"type\";s:6:\"number\";s:5:\"value\";s:3:\"212\";s:5:\"extra\";s:0:\"\";}i:9;a:9:{s:11:\"pluginvarid\";s:2:\"11\";s:8:\"pluginid\";s:2:\"18\";s:12:\"displayorder\";s:1:\"9\";s:5:\"title\";s:16:\"封面图片最大高度\";s:11:\"description\";s:0:\"\";s:8:\"variable\";s:12:\"picmaxheight\";s:4:\"type\";s:6:\"number\";s:5:\"value\";s:3:\"640\";s:5:\"extra\";s:0:\"\";}i:10;a:9:{s:11:\"pluginvarid\";s:2:\"12\";s:8:\"pluginid\";s:2:\"18\";s:12:\"displayorder\";s:2:\"10\";s:5:\"title\";s:14:\"是否采用缩略图\";s:11:\"description\";s:0:\"\";s:8:\"variable\";s:8:\"usethumb\";s:4:\"type\";s:5:\"radio\";s:5:\"value\";s:1:\"1\";s:5:\"extra\";s:0:\"\";}i:11;a:9:{s:11:\"pluginvarid\";s:2:\"13\";s:8:\"pluginid\";s:2:\"18\";s:12:\"displayorder\";s:2:\"11\";s:5:\"title\";s:14:\"生成缩略图宽度\";s:11:\"description\";s:0:\"\";s:8:\"variable\";s:10:\"thumbwidth\";s:4:\"type\";s:6:\"number\";s:5:\"value\";s:3:\"300\";s:5:\"extra\";s:0:\"\";}i:12;a:9:{s:11:\"pluginvarid\";s:2:\"14\";s:8:\"pluginid\";s:2:\"18\";s:12:\"displayorder\";s:2:\"12\";s:5:\"title\";s:14:\"生成缩略图高度\";s:11:\"description\";s:0:\"\";s:8:\"variable\";s:11:\"thumbheight\";s:4:\"type\";s:6:\"number\";s:5:\"value\";s:3:\"800\";s:5:\"extra\";s:0:\"\";}i:13;a:9:{s:11:\"pluginvarid\";s:2:\"15\";s:8:\"pluginid\";s:2:\"18\";s:12:\"displayorder\";s:2:\"13\";s:5:\"title\";s:8:\"页面标题\";s:11:\"description\";s:7:\"SEO标题\";s:8:\"variable\";s:8:\"navtitle\";s:4:\"type\";s:4:\"text\";s:5:\"value\";s:10:\"瀑布流图文\";s:5:\"extra\";s:0:\"\";}i:14;a:9:{s:11:\"pluginvarid\";s:2:\"16\";s:8:\"pluginid\";s:2:\"18\";s:12:\"displayorder\";s:2:\"14\";s:5:\"title\";s:10:\"页面关键字\";s:11:\"description\";s:9:\"SEO关键字\";s:8:\"variable\";s:12:\"metakeywords\";s:4:\"type\";s:8:\"textarea\";s:5:\"value\";s:6:\"瀑布流\";s:5:\"extra\";s:0:\"\";}i:15;a:9:{s:11:\"pluginvarid\";s:2:\"17\";s:8:\"pluginid\";s:2:\"18\";s:12:\"displayorder\";s:2:\"15\";s:5:\"title\";s:8:\"页面描述\";s:11:\"description\";s:7:\"SEO描述\";s:8:\"variable\";s:15:\"metadescription\";s:4:\"type\";s:8:\"textarea\";s:5:\"value\";s:46:\"将选定版块的主题以瀑布流的方式呈现在一个页面中\";s:5:\"extra\";s:0:\"\";}}', '0');
INSERT INTO `pre_yiqixueba_server_mokuai` VALUES ('6', '19', '1', '1', '推荐人', 'tuijianren', '', '', 'yiqixueba_tuijianren/', 'YiQiXueBa', 'a:4:{i:0;a:10:{s:4:\"name\";s:7:\"admincp\";s:4:\"menu\";s:8:\"插件注册\";s:3:\"url\";s:0:\"\";s:4:\"type\";s:1:\"3\";s:7:\"adminid\";s:1:\"0\";s:12:\"displayorder\";s:1:\"0\";s:8:\"navtitle\";s:0:\"\";s:7:\"navicon\";s:0:\"\";s:10:\"navsubname\";s:0:\"\";s:9:\"navsuburl\";s:0:\"\";}i:1;a:10:{s:4:\"name\";s:10:\"tuijianren\";s:4:\"menu\";s:0:\"\";s:3:\"url\";s:0:\"\";s:4:\"type\";s:2:\"11\";s:7:\"adminid\";s:1:\"0\";s:12:\"displayorder\";s:1:\"0\";s:8:\"navtitle\";s:0:\"\";s:7:\"navicon\";s:0:\"\";s:10:\"navsubname\";s:0:\"\";s:9:\"navsuburl\";s:0:\"\";}i:2;a:10:{s:4:\"name\";s:7:\"tjrlist\";s:4:\"menu\";s:8:\"我的推广\";s:3:\"url\";s:0:\"\";s:4:\"type\";s:1:\"7\";s:7:\"adminid\";s:1:\"0\";s:12:\"displayorder\";s:1:\"0\";s:8:\"navtitle\";s:0:\"\";s:7:\"navicon\";s:0:\"\";s:10:\"navsubname\";s:0:\"\";s:9:\"navsuburl\";s:0:\"\";}s:5:\"extra\";a:2:{s:11:\"installtype\";s:0:\"\";s:10:\"langexists\";i:1;}}', 'V1.0', 'a:0:{}', '0');

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

-- ----------------------------
-- Table structure for `pre_yiqixueba_tjrlist`
-- ----------------------------
DROP TABLE IF EXISTS `pre_yiqixueba_tjrlist`;
CREATE TABLE `pre_yiqixueba_tjrlist` (
  `id` mediumint(11) unsigned NOT NULL auto_increment,
  `uid` mediumint(11) unsigned NOT NULL,
  `tjuid` mediumint(11) unsigned NOT NULL,
  `regtime` int(10) unsigned default NULL,
  `usergroup` mediumint(11) unsigned default NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=gbk;

-- ----------------------------
-- Records of pre_yiqixueba_tjrlist
-- ----------------------------
INSERT INTO `pre_yiqixueba_tjrlist` VALUES ('1', '1', '0', '1375167890', null);

-- ----------------------------
-- Table structure for `pre_yiqixueba_tuijianren_admincp`
-- ----------------------------
DROP TABLE IF EXISTS `pre_yiqixueba_tuijianren_admincp`;
CREATE TABLE `pre_yiqixueba_tuijianren_admincp` (
  `admincpid` mediumint(8) unsigned NOT NULL auto_increment,
  `admincpname` char(40) NOT NULL,
  `displayorder` mediumint(8) NOT NULL,
  PRIMARY KEY  (`admincpid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

-- ----------------------------
-- Records of pre_yiqixueba_tuijianren_admincp
-- ----------------------------

-- ----------------------------
-- Table structure for `pre_yiqixueba_tuijianren_setting`
-- ----------------------------
DROP TABLE IF EXISTS `pre_yiqixueba_tuijianren_setting`;
CREATE TABLE `pre_yiqixueba_tuijianren_setting` (
  `skey` varchar(255) NOT NULL,
  `svalue` text NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

-- ----------------------------
-- Records of pre_yiqixueba_tuijianren_setting
-- ----------------------------
