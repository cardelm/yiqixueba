/*
Navicat MySQL Data Transfer

Source Server         : 17xueba
Source Server Version : 50045
Source Host           : 116.255.208.137:3306
Source Database       : xueba

Target Server Type    : MYSQL
Target Server Version : 50045
File Encoding         : 65001

Date: 2013-07-31 11:38:10
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `xueba_yiqixueba_apps`
-- ----------------------------
DROP TABLE IF EXISTS `xueba_yiqixueba_apps`;
CREATE TABLE `xueba_yiqixueba_apps` (
  `appid` mediumint(11) unsigned NOT NULL auto_increment,
  `apptype` varchar(255) NOT NULL,
  `appname` char(255) NOT NULL,
  `appidentifier` char(255) NOT NULL,
  `appver` char(255) NOT NULL,
  `dateline` int(11) unsigned NOT NULL,
  `installnum` mediumint(11) unsigned NOT NULL,
  `unstallnum` mediumint(11) unsigned NOT NULL,
  `status` int(6) NOT NULL,
  PRIMARY KEY  (`appid`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of xueba_yiqixueba_apps
-- ----------------------------
INSERT INTO `xueba_yiqixueba_apps` VALUES ('1', '插件', '商家联盟一卡通', 'yiqixueba_brand', 'v1.0', '1350992433', '0', '0', '0');
INSERT INTO `xueba_yiqixueba_apps` VALUES ('2', '插件', '会员卡绑定', 'yiqixueba_memberbind', 'v1.0', '1350992433', '2', '0', '1');
INSERT INTO `xueba_yiqixueba_apps` VALUES ('3', '插件', '一卡通', 'yikatong', 'V2.0', '1351106384', '26', '0', '1');
INSERT INTO `xueba_yiqixueba_apps` VALUES ('4', '插件', '推荐人', 'yiqixueba_tuijianren', 'V1.0', '1360156192', '0', '0', '1');

-- ----------------------------
-- Table structure for `xueba_yiqixueba_main_pageid`
-- ----------------------------
DROP TABLE IF EXISTS `xueba_yiqixueba_main_pageid`;
CREATE TABLE `xueba_yiqixueba_main_pageid` (
  `pageid` varchar(32) NOT NULL,
  `pagetype` smallint(3) NOT NULL,
  `submod` char(30) character set utf8 NOT NULL,
  `subop` char(30) character set utf8 NOT NULL,
  PRIMARY KEY  (`pageid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of xueba_yiqixueba_main_pageid
-- ----------------------------
INSERT INTO `xueba_yiqixueba_main_pageid` VALUES ('904f5dd671a04acbc2a45f408229fd59', '0', 'banji', 'index');
INSERT INTO `xueba_yiqixueba_main_pageid` VALUES ('f55171b381e92093b23f5ea0e7c7fc13', '0', 'member', 'index');
INSERT INTO `xueba_yiqixueba_main_pageid` VALUES ('69b53312ed6627465037a49de7e9bb55', '0', 'teacher', 'index');
INSERT INTO `xueba_yiqixueba_main_pageid` VALUES ('3dbba19c1e0e90c4ff2c2a5d3ff61c60', '0', 'parent', 'index');
INSERT INTO `xueba_yiqixueba_main_pageid` VALUES ('eeefc4880a2abf03bb2bce8497591c2e', '0', 'student', 'index');
INSERT INTO `xueba_yiqixueba_main_pageid` VALUES ('9ad37d50985a36dacdeb1a50f2f803e6', '0', 'brand', 'index');
INSERT INTO `xueba_yiqixueba_main_pageid` VALUES ('9cbb46a8d408972299280344990887f1', '0', 'fangchan', 'index');
INSERT INTO `xueba_yiqixueba_main_pageid` VALUES ('a2263da542d0800816f0564534df9652', '0', 'hr', 'index');
INSERT INTO `xueba_yiqixueba_main_pageid` VALUES ('dffdadf56bc2230ce2c2037509c42536', '0', 'newspaper', 'index');

-- ----------------------------
-- Table structure for `xueba_yiqixueba_main_setting`
-- ----------------------------
DROP TABLE IF EXISTS `xueba_yiqixueba_main_setting`;
CREATE TABLE `xueba_yiqixueba_main_setting` (
  `skey` varchar(255) character set utf8 NOT NULL,
  `svalue` text character set utf8 NOT NULL,
  PRIMARY KEY  (`skey`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of xueba_yiqixueba_main_setting
-- ----------------------------
INSERT INTO `xueba_yiqixueba_main_setting` VALUES ('apikey', '123456');
INSERT INTO `xueba_yiqixueba_main_setting` VALUES ('cutcity', '石家庄');
INSERT INTO `xueba_yiqixueba_main_setting` VALUES ('adminmenus', 'a:20:{i:0;a:7:{s:6:\"menuid\";s:1:\"1\";s:4:\"name\";s:4:\"main\";s:5:\"title\";s:12:\"系统设置\";s:4:\"type\";s:5:\"group\";s:5:\"level\";s:0:\"\";s:6:\"status\";s:1:\"1\";s:12:\"displayorder\";s:1:\"0\";}i:1;a:7:{s:6:\"menuid\";s:1:\"2\";s:4:\"name\";s:4:\"base\";s:5:\"title\";s:12:\"平台首页\";s:4:\"type\";s:1:\"1\";s:5:\"level\";s:0:\"\";s:6:\"status\";s:1:\"1\";s:12:\"displayorder\";s:1:\"0\";}i:2;a:7:{s:6:\"menuid\";s:1:\"6\";s:4:\"name\";s:3:\"reg\";s:5:\"title\";s:12:\"插件注册\";s:4:\"type\";s:1:\"1\";s:5:\"level\";s:0:\"\";s:6:\"status\";s:1:\"1\";s:12:\"displayorder\";s:1:\"1\";}i:3;a:7:{s:6:\"menuid\";s:1:\"9\";s:4:\"name\";s:8:\"chongzhi\";s:5:\"title\";s:12:\"帐号充值\";s:4:\"type\";s:1:\"1\";s:5:\"level\";s:0:\"\";s:6:\"status\";s:1:\"1\";s:12:\"displayorder\";s:1:\"2\";}i:4;a:7:{s:6:\"menuid\";s:1:\"4\";s:4:\"name\";s:6:\"mokuai\";s:5:\"title\";s:12:\"模块管理\";s:4:\"type\";s:5:\"group\";s:5:\"level\";s:0:\"\";s:6:\"status\";s:1:\"1\";s:12:\"displayorder\";s:1:\"1\";}i:5;a:7:{s:6:\"menuid\";s:1:\"7\";s:4:\"name\";s:4:\"list\";s:5:\"title\";s:12:\"模块列表\";s:4:\"type\";s:1:\"4\";s:5:\"level\";s:0:\"\";s:6:\"status\";s:1:\"1\";s:12:\"displayorder\";s:1:\"0\";}i:6;a:7:{s:6:\"menuid\";s:2:\"10\";s:4:\"name\";s:7:\"huodong\";s:5:\"title\";s:12:\"活动帖子\";s:4:\"type\";s:1:\"4\";s:5:\"level\";s:0:\"\";s:6:\"status\";s:1:\"1\";s:12:\"displayorder\";s:1:\"1\";}i:7;a:7:{s:6:\"menuid\";s:2:\"11\";s:4:\"name\";s:7:\"jiudian\";s:5:\"title\";s:12:\"迷你酒店\";s:4:\"type\";s:1:\"4\";s:5:\"level\";s:0:\"\";s:6:\"status\";s:1:\"1\";s:12:\"displayorder\";s:1:\"2\";}i:8;a:7:{s:6:\"menuid\";s:2:\"18\";s:4:\"name\";s:4:\"ztfd\";s:5:\"title\";s:12:\"赞同反对\";s:4:\"type\";s:1:\"4\";s:5:\"level\";s:0:\"\";s:6:\"status\";s:1:\"1\";s:12:\"displayorder\";s:1:\"3\";}i:9;a:7:{s:6:\"menuid\";s:1:\"8\";s:4:\"name\";s:7:\"install\";s:5:\"title\";s:12:\"安装模块\";s:4:\"type\";s:1:\"4\";s:5:\"level\";s:0:\"\";s:6:\"status\";s:1:\"1\";s:12:\"displayorder\";s:3:\"100\";}i:10;a:7:{s:6:\"menuid\";s:2:\"12\";s:4:\"name\";s:9:\"huiyuanka\";s:5:\"title\";s:9:\"会员卡\";s:4:\"type\";s:5:\"group\";s:5:\"level\";s:0:\"\";s:6:\"status\";s:1:\"1\";s:12:\"displayorder\";s:1:\"2\";}i:11;a:7:{s:6:\"menuid\";s:2:\"13\";s:4:\"name\";s:7:\"setting\";s:5:\"title\";s:12:\"基础设置\";s:4:\"type\";s:2:\"12\";s:5:\"level\";s:0:\"\";s:6:\"status\";s:1:\"1\";s:12:\"displayorder\";s:1:\"0\";}i:12;a:7:{s:6:\"menuid\";s:2:\"14\";s:4:\"name\";s:8:\"yikatong\";s:5:\"title\";s:9:\"一卡通\";s:4:\"type\";s:5:\"group\";s:5:\"level\";s:0:\"\";s:6:\"status\";s:1:\"1\";s:12:\"displayorder\";s:1:\"3\";}i:13;a:7:{s:6:\"menuid\";s:2:\"16\";s:4:\"name\";s:7:\"setting\";s:5:\"title\";s:12:\"基础设置\";s:4:\"type\";s:2:\"14\";s:5:\"level\";s:0:\"\";s:6:\"status\";s:1:\"1\";s:12:\"displayorder\";s:1:\"0\";}i:14;a:7:{s:6:\"menuid\";s:2:\"15\";s:4:\"name\";s:5:\"brand\";s:5:\"title\";s:12:\"联盟商家\";s:4:\"type\";s:5:\"group\";s:5:\"level\";s:0:\"\";s:6:\"status\";s:1:\"1\";s:12:\"displayorder\";s:1:\"4\";}i:15;a:7:{s:6:\"menuid\";s:2:\"17\";s:4:\"name\";s:7:\"setting\";s:5:\"title\";s:12:\"基础设置\";s:4:\"type\";s:2:\"15\";s:5:\"level\";s:0:\"\";s:6:\"status\";s:1:\"1\";s:12:\"displayorder\";s:1:\"0\";}i:16;a:7:{s:6:\"menuid\";s:2:\"19\";s:4:\"name\";s:4:\"sync\";s:5:\"title\";s:12:\"版本控制\";s:4:\"type\";s:5:\"group\";s:5:\"level\";s:0:\"\";s:6:\"status\";s:1:\"1\";s:12:\"displayorder\";s:1:\"5\";}i:17;a:7:{s:6:\"menuid\";s:2:\"22\";s:4:\"name\";s:9:\"myproject\";s:5:\"title\";s:12:\"我的项目\";s:4:\"type\";s:2:\"19\";s:5:\"level\";s:0:\"\";s:6:\"status\";s:1:\"1\";s:12:\"displayorder\";s:1:\"0\";}i:18;a:7:{s:6:\"menuid\";s:2:\"21\";s:4:\"name\";s:10:\"newproject\";s:5:\"title\";s:12:\"新建项目\";s:4:\"type\";s:2:\"19\";s:5:\"level\";s:0:\"\";s:6:\"status\";s:1:\"1\";s:12:\"displayorder\";s:1:\"1\";}i:19;a:7:{s:6:\"menuid\";s:2:\"20\";s:4:\"name\";s:13:\"searchproject\";s:5:\"title\";s:12:\"查找项目\";s:4:\"type\";s:2:\"19\";s:5:\"level\";s:0:\"\";s:6:\"status\";s:1:\"1\";s:12:\"displayorder\";s:1:\"2\";}}');

-- ----------------------------
-- Table structure for `xueba_yiqixueba_pluginlist`
-- ----------------------------
DROP TABLE IF EXISTS `xueba_yiqixueba_pluginlist`;
CREATE TABLE `xueba_yiqixueba_pluginlist` (
  `pid` mediumint(11) unsigned NOT NULL auto_increment,
  `pluginid` mediumint(11) unsigned NOT NULL,
  `pluginname` char(255) NOT NULL,
  `pluginidentifier` char(255) NOT NULL,
  `pluginver` char(255) NOT NULL,
  `site_version` char(255) NOT NULL,
  `site_release` char(255) NOT NULL,
  `site_timestamp` int(11) unsigned NOT NULL,
  `site_name` char(255) NOT NULL,
  `site_url` char(255) NOT NULL,
  `site_adminemail` char(255) NOT NULL,
  `site_username` char(255) NOT NULL,
  `site_tel` char(255) NOT NULL,
  `site_prov` char(50) NOT NULL,
  `site_city` char(50) NOT NULL,
  `site_dist` char(50) NOT NULL,
  `site_community` char(50) NOT NULL,
  `api_key` char(255) NOT NULL,
  `uninstall_timestamp` int(11) unsigned NOT NULL,
  `site_email` char(100) NOT NULL,
  `site_info` char(255) NOT NULL,
  `site_charset` char(255) NOT NULL,
  PRIMARY KEY  (`pid`)
) ENGINE=MyISAM AUTO_INCREMENT=173 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of xueba_yiqixueba_pluginlist
-- ----------------------------
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('55', '3', '', 'yikatong', 'V2.0', 'X2.5', '20120701', '1351853808', '', 'http://www.0570.la/', '150250000@qq.com', '', '18969455263', '浙江省', '衢州市', '0', '0', '34667ef26ad15e26d8ce6d1c709a9d83', '0', '', 'Microsoft-IIS/6.0www.0570.laD:\\wz\\www.0570.la5.2.11WINNT', 'gbk');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('12', '3', '一卡通', 'yikatong', 'V1.0', 'X2.5', '20120901', '1351491595', 'fsdfsdf', 'http://ykt.0570.la/', '150250000@qq.com', '3r234r', '32423423', '浙江省', '衢州市', '', '', '93b21f5f5666e8703aefb0b6c500b67c', '0', '423432@12.com', 'Microsoft-IIS/6.0ykt.0570.laD:\\wz\\wangqi5.2.11WINNT', 'gbk');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('14', '3', '一卡通', 'yikatong', 'V1.0', 'X2.5', '20120901', '1351565942', '', 'http://localhost/plugin/test/dz25gbk/', 'admin@admin.com', '', '13113890911', '', '', '', '', 'ce0be9f972214b2ee27f5ce9f1c0bab7', '0', '', 'Apache/2.2.6 (Win32) PHP/5.2.5localhostE:/Web/PHP/wamp/wwwwebmaster@localhost127.0.0.15.2.5WINNT', 'gbk');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('54', '3', '', 'yikatong', 'V1.0', 'X2.5', '20121101', '1351853746', '', 'http://www.wlmqol.com/', 'wlmqol@163.com', '', '18999956997', '新疆维吾尔自治区', '乌鲁木齐市', '0', '0', '57b5af9902cb487933a940dacbecbd2f', '0', '', 'Microsoft-IIS/6.0www.wlmqol.comd:\\wwwroot\\wlmqol\\wwwroot5.3.13WINNT', 'gbk');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('53', '3', '', 'yikatong', 'V1.0', 'X2.5', '20121101', '1351833206', '', 'http://www.wlmqol.com/', 'wlmqol@163.com', '', '18999956997', '新疆维吾尔自治区', '乌鲁木齐市', '0', '0', '57b5af9902cb487933a940dacbecbd2f', '0', '', 'Microsoft-IIS/6.0www.wlmqol.comd:\\wwwroot\\wlmqol\\wwwroot5.3.13WINNT', 'gbk');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('52', '3', '', 'yikatong', 'V1.0', 'X2.5', '20120901', '1351672022', '', 'http://www.bgwyw.com/', 'ytkjceo@163.com', '', '13101731888', '河南省', '郑州市', '0', '0', '9163d3c9cfbc120ba7ee528061f68867', '0', '', 'Microsoft-IIS/6.0www.bgwyw.comD:\\web\\www.918xinxi.com\\wymh5.2.1WINNT', 'gbk');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('51', '3', '', 'yikatong', 'V1.0', 'X2.5', '20120701', '1351679813', '', 'http://bbs.0570.la/', '150250000@qq.com', '', '15257048802', '浙江省', '衢州市', '0', '0', 'ea4b127d8e7350f2c8bd6f9bd86b3712', '0', '', 'Microsoft-IIS/6.0bbs.0570.laD:\\wz\\www.0570.la5.2.11WINNT', 'gbk');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('50', '3', '', 'yikatong', 'V1.0', 'X2.5', '20120901', '1351672022', '', 'http://www.bgwyw.com/', 'ytkjceo@163.com', '', '13101731888', '河南省', '郑州市', '0', '0', '9163d3c9cfbc120ba7ee528061f68867', '0', '', 'Microsoft-IIS/6.0www.bgwyw.comD:\\web\\www.918xinxi.com\\wymh5.2.1WINNT', 'gbk');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('49', '3', '', 'yikatong', 'V1.0', 'X2.5', '20120901', '1351672022', '', 'http://www.bgwyw.com/', 'ytkjceo@163.com', '', '13101731888', '河南省', '郑州市', '0', '0', '9163d3c9cfbc120ba7ee528061f68867', '0', '', 'Microsoft-IIS/6.0www.bgwyw.comD:\\web\\www.918xinxi.com\\wymh5.2.1WINNT', 'gbk');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('48', '3', '', 'yikatong', 'V1.0', 'X2.5', '20120901', '1351672022', '', 'http://www.bgwyw.com/', 'ytkjceo@163.com', '', '13101731888', '河南省', '郑州市', '0', '0', '9163d3c9cfbc120ba7ee528061f68867', '0', '', 'Microsoft-IIS/6.0www.bgwyw.comD:\\web\\www.918xinxi.com\\wymh5.2.1WINNT', 'gbk');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('47', '3', '', 'yikatong', 'V2.0', 'X2', '20120628', '1351664248', '', 'http://localhost/Test/dz20gbk/', 'admin@admin.com', '', '12345678901', '河北省', '石家庄市', '0', '0', '0044c1abd94de03bd806e185a124d3c3', '0', '', 'Apache/2.2.6 (Win32) PHP/5.2.5localhostC:/wamp/wwwwebmaster@localhost127.0.0.15.2.5WINNT', 'gbk');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('46', '3', '', 'yikatong', 'V1.0', 'X2', '20120628', '1351647664', '', 'http://localhost/plugin/test/dz20gbk/', 'admin@admin.com', '', '12345678901', '河北省', '廊坊市', '0', '0', '06bf079535cc0bbf082112baaef3768e', '0', '', 'Apache/2.2.6 (Win32) PHP/5.2.5localhostE:/Web/PHP/wamp/wwwwebmaster@localhost127.0.0.15.2.5WINNT', 'gbk');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('45', '3', '', 'yikatong', 'V1.0', 'X2.5', '20120901', '1351605164', '', 'http://127.0.0.1/', 'admin@admin.com', '', '15257048802', '广西壮族自治区', '玉林市', '0', '0', 'dda1de8a5365a5f40e892951c9def69b', '0', '', 'Apache/2.2.4 (Win32) PHP/5.2.4127.0.0.1C:/DedeAMPZ/WebRoot/Defaultadmin@myhost.com127.0.0.15.2.4WINNT', 'gbk');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('44', '3', '', 'yikatong', 'V1.0', 'X2.5', '20120901', '1351604919', '', 'http://127.0.0.1/', 'admin@admin.com', '', '15257048802', '浙江省', '衢州市', '0', '0', 'b544e2c08c2c111fd0716e945239da4f', '0', '', 'Apache/2.2.4 (Win32) PHP/5.2.4127.0.0.1D:/hand/DedeAMPZ/WebRoot/Defaultadmin@myhost.com127.0.0.15.2.4WINNT', 'gbk');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('43', '3', '', 'yikatong', 'V1.0', 'X2.5', '20120901', '1351601842', '', 'http://127.0.0.1/', 'admin@admin.com', '', '15257048802', '广西壮族自治区', '玉林市', '0', '0', 'dda1de8a5365a5f40e892951c9def69b', '0', '', 'Apache/2.2.4 (Win32) PHP/5.2.4127.0.0.1C:/DedeAMPZ/WebRoot/Defaultadmin@myhost.com127.0.0.15.2.4WINNT', 'gbk');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('42', '3', '', 'yikatong', 'V1.0', 'X2.5', '20120901', '1351601843', '', 'http://127.0.0.1/', 'admin@admin.com', '', '15257048802', '广西壮族自治区', '玉林市', '0', '0', 'dda1de8a5365a5f40e892951c9def69b', '0', '', 'Apache/2.2.4 (Win32) PHP/5.2.4127.0.0.1C:/DedeAMPZ/WebRoot/Defaultadmin@myhost.com127.0.0.15.2.4WINNT', 'gbk');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('41', '3', '', 'yikatong', 'V1.0', 'X2.5', '20120701', '1351600837', '', 'http://127.0.0.1/', 'admin@admin.com', '', '15257048802', '广西壮族自治区', '柳州市', '0', '0', 'dda1de8a5365a5f40e892951c9def69b', '0', '', 'Apache/2.2.4 (Win32) PHP/5.2.4127.0.0.1C:/DedeAMPZ/WebRoot/Defaultadmin@myhost.com127.0.0.15.2.4WINNT', 'gbk');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('40', '3', '', 'yikatong', 'V1.0', 'X2', '20120329', '1351600312', '', 'http://www.cz206.com/', '373844102@qq.com', '', '13905964506', '四川省', '成都市', '崇州市', '0', '4c12a46402ea4466c34f6c22d1646b14', '0', '', 'Microsoft-IIS/6.0www.cz206.comD:\\wwwroot5.2.16WINNT', 'gbk');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('39', '3', '', 'yikatong', 'V1.0', 'X2.5', '20120901', '1351588907', '', 'http://www.nnhlwh.com/', 'admin@admin.com', '', '18978986020', '广西壮族自治区', '南宁市', '0', '0', '81df6f378fc9a819ec1ef5d8a021868c', '0', '', 'Microsoft-IIS/6.0www.nnhlwh.comD:\\wwwroot\\test\\www.nnhlwh.com5.2.10WINNT', 'gbk');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('38', '3', '', 'yikatong', 'V1.0', 'X2.5', '20120901', '1351586081', '', 'http://bbs.0776zx.com/', 'admin@0776zx.com', '', '18677637327', '广西壮族自治区', '百色市', '平果县', '0', '30546e1bacbe7e9367333896c1c85abb', '0', '', 'nginxbbs.0776zx.com/home/ftp/1520/news_0776zx_bbs-20120326-NXS/bbs1.0776zx.com110.76.43.2035.2.17p1Linux', 'gbk');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('37', '3', '', 'yikatong', 'V1.0', 'X2.5', '20120701', '1351582661', '', 'http://localhost/Test/dz25gbk/', 'admin@admin.com', '', '11111111111', '河北省', '石家庄市', '0', '0', '0044c1abd94de03bd806e185a124d3c3', '0', '', 'Apache/2.2.6 (Win32) PHP/5.2.5localhostC:/wamp/wwwwebmaster@localhost127.0.0.15.2.5WINNT', 'gbk');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('36', '3', '', 'yikatong', 'V1.0', 'X2.5', '20120701', '1351582043', '', 'http://localhost/Test/dz25gbk/', 'admin@admin.com', '', '11111111111', '河北省', '石家庄市', '0', '0', '0044c1abd94de03bd806e185a124d3c3', '0', '', 'Apache/2.2.6 (Win32) PHP/5.2.5localhostC:/wamp/wwwwebmaster@localhost127.0.0.15.2.5WINNT', 'gbk');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('35', '3', '', 'yikatong', 'V1.0', 'X2.5', '20120701', '1351581430', '', 'http://localhost/Test/dz25gbk/', 'admin@admin.com', '', '11111111111', '河北省', '石家庄市', '0', '0', '0044c1abd94de03bd806e185a124d3c3', '0', '', 'Apache/2.2.6 (Win32) PHP/5.2.5localhostC:/wamp/wwwwebmaster@localhost127.0.0.15.2.5WINNT', 'gbk');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('56', '3', '', 'yikatong', 'V2.0', 'X2.5', '20120407', '1351925395', '', 'http://localhost/Test/dz25utf8/', 'admin@admin.com', '', '13313890911', '河北省', '石家庄市', '0', '0', '0044c1abd94de03bd806e185a124d3c3', '0', '', 'Apache/2.2.6 (Win32) PHP/5.2.5localhostC:/wamp/wwwwebmaster@localhost127.0.0.15.2.5WINNT', 'utf-8');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('57', '3', '', 'yikatong', 'V2.0', 'X2.5', '20121101', '1352092261', '', 'http://www.wlmqol.com/', 'wlmqol@163.com', '', '18999956997', '新疆维吾尔自治区', '乌鲁木齐市', '0', '0', '57b5af9902cb487933a940dacbecbd2f', '0', '', 'Microsoft-IIS/6.0www.wlmqol.comd:\\wwwroot\\wlmqol\\wwwroot5.3.13WINNT', 'gbk');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('58', '3', '', 'yikatong', 'V2.0', 'X2.5', '20121101', '1352265721', '', 'http://bbs.easebay.cn/', 'kefu@easebay.cn', '', '13853106111', '山东省', '济南市', '历下区', '建新街道', 'a466f17f11e329e1efb83064968b44f5', '0', '', 'Microsoft-IIS/6.0bbs.easebay.cn5.2.17WINNT', 'utf-8');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('59', '3', '', 'yikatong', 'V2.0', 'X2.5', '20121101', '1352265858', '', 'http://bbs.easebay.cn/', 'kefu@easebay.cn', '', '13853106111', '山东省', '济南市', '历下区', '建新街道', 'a466f17f11e329e1efb83064968b44f5', '0', '', 'Microsoft-IIS/6.0bbs.easebay.cn5.2.17WINNT', 'utf-8');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('60', '3', '', 'yikatong', 'V2.0', 'X2.5', '20121101', '1352277635', '', 'http://www.0776zx.com/', 'admin@0776zx.com', '', '18677637327', '广西壮族自治区', '百色市', '平果县', '0', 'eca9a1ecb92b9acb1e56db1b805c6b7e', '0', '', 'Microsoft-IIS/6.0www.0776zx.comD:\\Discuz_X2.5\\upload5.2.17WINNT', 'gbk');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('61', '3', '', 'yikatong', 'V2.0', 'X2.5', '20121101', '1352352095', '', 'http://www.0776zx.com/', 'admin@0776zx.com', '', '18677637327', '广西壮族自治区', '百色市', '平果县', '0', 'eca9a1ecb92b9acb1e56db1b805c6b7e', '0', '', 'Microsoft-IIS/6.0www.0776zx.comD:\\Discuz_X2.5\\upload5.2.17WINNT', 'gbk');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('62', '3', '', 'yikatong', 'V2.0', 'X2', '20120329', '1352359291', '', 'http://bbs.cz206.com/', '373844102@qq.com', '', '13905964506', '四川省', '成都市', '崇州市', '0', '6ee7d907b5f5e9f1088ab13e165d8d58', '0', '', 'Microsoft-IIS/6.0bbs.cz206.comD:\\wwwroot5.2.16WINNT', 'gbk');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('63', '3', '', 'yikatong', 'V2.0', 'X2.5', '20120407', '1352470797', '', 'http://www.0429sohu.com/', 'sohu0429@vip.qq.com', '', '15597698725', '辽宁省', '葫芦岛市', '0', '0', 'ed122b850ad94731b872693910b67e7c', '0', '', 'Microsoft-IIS/6.0www.0429sohu.comD:\\www5.2.17WINNT', 'gbk');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('64', '3', '', 'yikatong', 'V2.0', 'X2.5', '20120407', '1352520269', '', 'http://www.0429sohu.com/', 'sohu0429@vip.qq.com', '', '15597698725', '辽宁省', '葫芦岛市', '0', '0', 'ed122b850ad94731b872693910b67e7c', '0', '', 'Microsoft-IIS/6.0www.0429sohu.comD:\\www5.2.17WINNT', 'gbk');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('65', '3', '', 'yikatong', 'V2.0', 'X2.5', '20121101', '1352735514', '', 'http://www.91zlz.com/', 'quzhousheq@qq.com', '', '15257048802', '浙江省', '衢州市', '0', '0', 'f893044d849c91465fd32e67b816e608', '0', '', 'Microsoft-IIS/6.0www.91zlz.comD:\\wz\\91zlz5.2.11WINNT', 'gbk');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('66', '3', '', 'yikatong', 'V2.0', 'X2.5', '20121101', '1352772944', '', 'http://bbs.easebay.cn/', 'kefu@easebay.cn', '', '13853106111', '山东省', '济南市', '历下区', '建新街道', 'a466f17f11e329e1efb83064968b44f5', '0', '', 'Microsoft-IIS/6.0bbs.easebay.cn5.2.17WINNT', 'utf-8');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('67', '3', '', 'yikatong', 'V2.0', 'X2.5', '20121101', '1353064484', '', 'http://mall.datou88.com/', '1530353043@qq.com', '', '15257048802', '浙江省', '台州市', '0', '0', '44fd613a4453b94f999fb8b359ac9dae', '0', '', 'Microsoft-IIS/6.0mall.datou88.comD:\\wz\\hwb5.2.11WINNT', 'gbk');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('68', '3', '', 'yikatong', 'V2.0', 'X2.5', '20121101', '1353065489', '', 'http://mall.datou88.com/', '1530353043@qq.com', '', '15257048802', '浙江省', '台州市', '0', '0', '44fd613a4453b94f999fb8b359ac9dae', '0', '', 'Microsoft-IIS/6.0mall.datou88.comD:\\wz\\hwb5.2.11WINNT', 'gbk');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('69', '3', '', 'yikatong', 'V2.0', 'X2.5', '20121101', '1353074682', '', 'http://blog.xinbeiliu.com/', 'jalin_96@163.com', '', '13707751709', '广西壮族自治区', '玉林市', '北流市', '0', '367d1461e6485c48572dc8a3ee217e22', '0', '', 'Microsoft-IIS/6.0blog.xinbeiliu.comD:\\www\\xinbeiliu\\web5.2.10WINNT', 'gbk');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('70', '3', '', 'yikatong', 'V2.0', 'X2.5', '20120701', '1353121585', '', 'http://www.17xue8.cn:88/debug/', 'admin@admin.com', '', '13113890911', '河北省', '石家庄市', '0', '0', '2fcdf8bc0caa8a9c8d083b2e6d30eafb', '0', '', 'Apachewww.17xue8.cn/www/web/17xue8_cn/public_htmlyou@example.com116.255.208.1375.2.17p1Linux', 'gbk');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('71', '3', '', 'yikatong', 'V2.0', 'X2.5', '20120701', '1353136500', '', 'http://www.17xue8.cn:88/debug/', 'admin@admin.com', '', '13113890911', '河北省', '石家庄市', '0', '0', '2fcdf8bc0caa8a9c8d083b2e6d30eafb', '0', '', 'Apachewww.17xue8.cn/www/web/17xue8_cn/public_htmlyou@example.com116.255.208.1375.2.17p1Linux', 'gbk');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('72', '3', '', 'yikatong', 'V2.0', 'X2.5', '20121101', '1353136512', '', 'http://bbs.0570.la/', '150250000@qq.com', '', '15257048802', '浙江省', '衢州市', '0', '0', 'ea4b127d8e7350f2c8bd6f9bd86b3712', '0', '', 'Microsoft-IIS/6.0bbs.0570.laD:\\wz\\www.0570.la5.2.11WINNT', 'gbk');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('73', '3', '', 'yikatong', 'V2.0', 'X2.5', '20121101', '1353137890', '', 'http://bbs.0570.la/', '150250000@qq.com', '', '15257048802', '浙江省', '衢州市', '0', '0', 'ea4b127d8e7350f2c8bd6f9bd86b3712', '0', '', 'Microsoft-IIS/6.0bbs.0570.laD:\\wz\\www.0570.la5.2.11WINNT', 'gbk');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('74', '3', '', 'yikatong', 'V2.0', 'X2.5', '20121101', '1353343999', '', 'http://www.edshop.cn/bbs/', 'admin@admin.com', '', '18635577877', '山西省', '太原市', '小店区', '坞城街道', 'acff6467676ac956f9aea3cf2237945f', '0', '', 'Microsoft-IIS/6.0www.edshop.cnD:\\shop5.2.6WINNT', 'utf-8');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('75', '3', '', 'yikatong', 'V2.0', 'X2.5', '20120901', '1353345377', '', 'http://www.qionghai.net/', '1098020999@qq.com', '', '13307551513', '海南省', '琼海市', '0', '0', '850745518aa71a7dc5bb364a1adeb62a', '0', '', 'Microsoft-IIS/7.5www.qionghai.netD:\\wwwroot\\qionghai\\oo335.2.17WINNT', 'gbk');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('76', '3', '', 'yikatong', 'V2.0', 'X2.5', '20121101', '1353557006', '', 'http://www.edshop.cn/bbs/', 'admin@admin.com', '', '18635577877', '山西省', '太原市', '小店区', '坞城街道', 'acff6467676ac956f9aea3cf2237945f', '0', '', 'Microsoft-IIS/6.0www.edshop.cnD:\\shop5.2.6WINNT', 'utf-8');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('77', '3', '', 'yikatong', 'V2.0', 'X2.5', '20121101', '1353557225', '', 'http://www.edshop.cn/bbs/', 'admin@admin.com', '', '18635577877', '北京市', '海淀区', '中关村街道', '0', 'acff6467676ac956f9aea3cf2237945f', '0', '', 'Microsoft-IIS/6.0www.edshop.cnD:\\shop5.2.6WINNT', 'utf-8');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('78', '3', '', 'yikatong', 'V2.0', 'X2.5', '20121101', '1353563643', '', 'http://www.edshop.cn/bbs/', 'admin@admin.com', '', '18635577877', '山西省', '太原市', '小店区', '坞城街道', 'acff6467676ac956f9aea3cf2237945f', '0', '', 'Microsoft-IIS/6.0www.edshop.cnD:\\shop5.2.6WINNT', 'utf-8');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('79', '3', '', 'yikatong', 'V2.0', 'X2.5', '20121101', '1353652149', '', 'http://www.edshop.cn/bbs/', 'admin@admin.com', '', '18635577877', '北京市', '海淀区', '中关村街道', '0', 'acff6467676ac956f9aea3cf2237945f', '0', '', 'Microsoft-IIS/6.0www.edshop.cnD:\\shop5.2.6WINNT', 'utf-8');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('80', '3', '', 'yikatong', 'V2.0', 'X2.5', '20121101', '1353687409', '', 'http://www.edshop.cn/bbs/', 'admin@admin.com', '', '18635577877', '山西省', '太原市', '迎泽区', '0', 'acff6467676ac956f9aea3cf2237945f', '0', '', 'Microsoft-IIS/6.0www.edshop.cnD:\\shop5.2.6WINNT', 'utf-8');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('81', '3', '', 'yikatong', 'V2.0', 'X2.5', '20121101', '1353860289', '', 'http://www.edshop.cn/bbs/', 'admin@admin.com', '', '18635577877', '山西省', '太原市', '迎泽区', '迎泽街道', 'acff6467676ac956f9aea3cf2237945f', '0', '', 'Microsoft-IIS/6.0www.edshop.cnD:\\shop5.2.6WINNT', 'utf-8');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('82', '3', '', 'yikatong', 'V2.0', 'X2.5', '20121101', '1353992047', '', 'http://s-51600.gotocdn.com/', '130077076@qq.com', '', '15376001990', '山东省', '临沂市', '0', '0', 'a391399f4398c7776b3745892e33575e', '0', '', 'Microsoft-IIS/6.0s-51600.gotocdn.comd:\\wwwroot\\hocent\\wwwroot5.2.8WINNT', 'gbk');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('83', '3', '', 'yikatong', 'V2.0', 'X2.5', '20120701', '1354329324', '', 'http://www.17xue8.cn:88/debug/', 'admin@admin.com', '', '15163300343', '山东省', '日照市', '0', '0', '2fcdf8bc0caa8a9c8d083b2e6d30eafb', '0', '', 'Apachewww.17xue8.cn/www/web/17xue8_cn/public_htmlyou@example.com116.255.208.1375.2.17p1Linux', 'gbk');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('84', '3', '', 'yikatong', 'V2.0', 'X2.5', '20121101', '1354623010', '', 'http://www.wllt.cc/', 'nywllt@qq.com', '', '13782152211', '河南省', '南阳市', '0', '0', '7906372d056189b5440452f1df735d24', '0', '', 'Apache/2.2.3 (CentOS)www.wllt.cc/www/users/yhwcn.com/wllt[no address given]115.47.64.2465.2.10Linux', 'utf-8');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('85', '3', '', 'yikatong', 'V2.0', 'X2.5', '20120701', '1354635232', '', 'http://localhost/plugin/test/dz25utf8/', 'admin@admin.com', '', '13113890911', '河北省', '石家庄市', '0', '0', 'f05c6b26c178e3411ec825b04d36507c', '0', '', 'Apache/2.2.4 (Win32) PHP/5.2.4localhostE:/Web/DedeAmpDebug/DedeAMPZ/WebRoot/Defaultadmin@myhost.com127.0.0.15.2.0WINNT', 'utf-8');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('86', '3', '', 'yikatong', 'V2.0', 'X2.5', '20121101', '1354685370', '', 'http://www.wllt.cc/', 'nywllt@qq.com', '', '13782152211', '河南省', '南阳市', '0', '0', '7906372d056189b5440452f1df735d24', '0', '', 'Apache/2.2.3 (CentOS)www.wllt.cc/www/users/yhwcn.com/wllt[no address given]115.47.64.2465.2.10Linux', 'utf-8');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('87', '3', '', 'yikatong', 'V2.0', 'X2.5', '20121101', '1354730085', '', 'http://www.wllt.cc/', 'nywllt@qq.com', '', '13782152211', '河南省', '南阳市', '0', '0', '7906372d056189b5440452f1df735d24', '0', '', 'Apache/2.2.3 (CentOS)www.wllt.cc/www/users/yhwcn.com/wllt[no address given]115.47.64.2465.2.10Linux', 'gbk');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('88', '3', '', 'yikatong', 'V2.0', 'X2.5', '20121101', '1354801992', '', 'http://www.wlmqol.com/', 'wlmqol@163.com', '', '18999956997', '新疆维吾尔自治区', '乌鲁木齐市', '0', '0', '57b5af9902cb487933a940dacbecbd2f', '0', '', 'Microsoft-IIS/6.0www.wlmqol.comd:\\wwwroot\\wlmqol\\wwwroot5.3.13WINNT', 'gbk');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('89', '3', '', 'yikatong', 'V2.0', 'X2.5', '20121101', '1354803555', '', 'http://www.wllt.cc/', 'nywllt@qq.com', '', '13782152211', '河南省', '南阳市', '0', '0', '7906372d056189b5440452f1df735d24', '0', '', 'Apache/2.2.3 (CentOS)www.wllt.cc/www/users/yhwcn.com/wllt[no address given]115.47.64.2465.2.10Linux', 'utf-8');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('90', '3', '', 'yikatong', 'V2.0', 'X2.5', '20121101', '1354805426', '', 'http://www.sddheng.com/', 'admin@admin.com', '', '13890967927', '四川省', '宜宾市', '0', '0', '12886db10372bb893fce684e8256dac6', '0', '', 'Microsoft-IIS/6.0www.sddheng.comd:\\wwwroot\\yibin\\wwwroot5.2.8WINNT', 'gbk');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('91', '3', '', 'yikatong', 'V2.0', 'X2.5', '20121101', '1354891065', '', 'http://www.yhwcn.com/', '842988818@qq.com', '', '13782152211', '河南省', '南阳市', '0', '0', 'c97127dfff1659a514f8990e1919b6bf', '0', '', 'Microsoft-IIS/6.0www.yhwcn.comD:\\WorkSpace\\wllt5.2.5WINNT', 'gbk');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('92', '3', '', 'yikatong', 'V2.0', 'X2.5', '20121101', '1354970247', '', 'http://www.yhwcn.com/', '842988818@qq.com', '', '13782152211', '河南省', '南阳市', '0', '0', 'c97127dfff1659a514f8990e1919b6bf', '0', '', 'Microsoft-IIS/6.0www.yhwcn.comD:\\WorkSpace\\wllt5.2.5WINNT', 'gbk');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('93', '3', '', 'yikatong', 'V2.0', 'X2.5', '20121101', '1354970248', '', 'http://www.yhwcn.com/', '842988818@qq.com', '', '13782152211', '河南省', '南阳市', '0', '0', 'c97127dfff1659a514f8990e1919b6bf', '0', '', 'Microsoft-IIS/6.0www.yhwcn.comD:\\WorkSpace\\wllt5.2.5WINNT', 'gbk');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('94', '3', '', 'yikatong', 'V2.0', 'X2.5', '20121101', '1354970275', '', 'http://www.yhwcn.com/', '842988818@qq.com', '', '13782152211', '河南省', '南阳市', '0', '0', 'c97127dfff1659a514f8990e1919b6bf', '0', '', 'Microsoft-IIS/6.0www.yhwcn.comD:\\WorkSpace\\wllt5.2.5WINNT', 'gbk');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('95', '3', '', 'yikatong', 'V2.0', 'X2.5', '20121101', '1354970261', '', 'http://www.yhwcn.com/', '842988818@qq.com', '', '13782152211', '河南省', '南阳市', '0', '0', 'c97127dfff1659a514f8990e1919b6bf', '0', '', 'Microsoft-IIS/6.0www.yhwcn.comD:\\WorkSpace\\wllt5.2.5WINNT', 'gbk');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('96', '3', '', 'yikatong', 'V2.0', 'X2.5', '20121101', '1354970284', '', 'http://www.yhwcn.com/', '842988818@qq.com', '', '13782152211', '河南省', '南阳市', '0', '0', 'c97127dfff1659a514f8990e1919b6bf', '0', '', 'Microsoft-IIS/6.0www.yhwcn.comD:\\WorkSpace\\wllt5.2.5WINNT', 'gbk');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('97', '3', '', 'yikatong', 'V2.0', 'X2.5', '20121101', '1354970331', '', 'http://www.yhwcn.com/', '842988818@qq.com', '', '13782152211', '河南省', '南阳市', '0', '0', 'c97127dfff1659a514f8990e1919b6bf', '0', '', 'Microsoft-IIS/6.0www.yhwcn.comD:\\WorkSpace\\wllt5.2.5WINNT', 'gbk');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('98', '3', '', 'yikatong', 'V2.0', 'X2.5', '20121101', '1355015576', '', 'http://www.yhwcn.com/', '842988818@qq.com', '', '13782152211', '河南省', '南阳市', '0', '0', 'c97127dfff1659a514f8990e1919b6bf', '0', '', 'Microsoft-IIS/6.0www.yhwcn.comD:\\WorkSpace\\wllt5.2.5WINNT', 'gbk');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('99', '3', '', 'yikatong', 'V2.0', 'X2.5', '20121101', '1355202636', '', 'http://www.nnhlwh.com/', 'admin@admin.com', '', '13878182850', '广西壮族自治区', '南宁市', '0', '0', '81df6f378fc9a819ec1ef5d8a021868c', '0', '', 'Microsoft-IIS/6.0www.nnhlwh.comD:\\wwwroot\\test\\www.nnhlwh.com5.2.10WINNT', 'gbk');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('100', '3', '', 'yikatong', 'V2.0', 'X2.5', '20121101', '1355202627', '', 'http://www.nnhlwh.com/', 'admin@admin.com', '', '13878182850', '广西壮族自治区', '南宁市', '0', '0', '81df6f378fc9a819ec1ef5d8a021868c', '0', '', 'Microsoft-IIS/6.0www.nnhlwh.comD:\\wwwroot\\test\\www.nnhlwh.com5.2.10WINNT', 'gbk');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('101', '3', '', 'yikatong', 'V2.0', 'X2.5', '20121101', '1355578883', '', 'http://www.wlmqol.com/', 'wlmqol@163.com', '', '18999956997', '新疆维吾尔自治区', '乌鲁木齐市', '0', '0', 'ed0f56e932cbafe5d9cb15e70b24b8bd', '0', '', 'Microsoft-IIS/6.0www.wlmqol.comd:\\wwwroot\\wlmqol\\wwwroot5.2.8WINNT', 'gbk');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('102', '3', '', 'yikatong', 'V2.0', 'X2.5', '20121101', '1356095718', '', 'http://www.0570.la/', '150250000@qq.com', '', '15700002025', '浙江省', '衢州市', '0', '0', '34667ef26ad15e26d8ce6d1c709a9d83', '0', '', 'Microsoft-IIS/6.0www.0570.laD:\\wz\\www.0570.la5.2.11WINNT', 'gbk');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('103', '3', '', 'yikatong', 'V2.0', 'X2.5', '20120701', '1356096237', '', 'http://localhost/Test/dz25gbk/', 'admin@admin.com', '', '11111111111', '河北省', '石家庄市', '0', '0', '0044c1abd94de03bd806e185a124d3c3', '0', '', 'Apache/2.2.6 (Win32) PHP/5.2.5localhostC:/wamp/wwwwebmaster@localhost127.0.0.15.2.5WINNT', 'gbk');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('104', '3', '', 'yikatong', 'V2.0', 'X2.5', '20121101', '1356097705', '', 'http://www.0570.la/', '150250000@qq.com', '', '15700002025', '浙江省', '衢州市', '0', '0', '34667ef26ad15e26d8ce6d1c709a9d83', '0', '', 'Microsoft-IIS/6.0www.0570.laD:\\wz\\www.0570.la5.2.11WINNT', 'gbk');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('105', '3', '', 'yikatong', 'V2.0', 'X2.5', '20121101', '1356274014', '', 'http://www.edshop.cn/bbs/', 'admin@admin.com', '', '18635577877', '山西省', '太原市', '迎泽区', '迎泽街道', 'acff6467676ac956f9aea3cf2237945f', '0', '', 'Microsoft-IIS/6.0www.edshop.cnD:\\shop5.2.6WINNT', 'utf-8');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('106', '3', '', 'yikatong', 'V2.0', 'X2.5', '20120901', '1356275455', '', 'http://localhost/plugin/xueba/fenzhan_gbk/', 'admin@admin.com', '', '13113890911', '河北省', '石家庄市', '0', '0', 'f05c6b26c178e3411ec825b04d36507c', '0', '', 'Apache/2.2.4 (Win32) PHP/5.2.4localhostE:/Web/DedeAmpDebug/DedeAMPZ/WebRoot/Defaultadmin@myhost.com127.0.0.15.2.0WINNT', 'gbk');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('107', '3', '', 'yikatong', 'V2.0', 'X2.5', '20121101', '1356326563', '', 'http://www.edshop.cn/bbs/', 'admin@admin.com', '', '18635577877', '山西省', '太原市', '迎泽区', '迎泽街道', 'acff6467676ac956f9aea3cf2237945f', '0', '', 'Microsoft-IIS/6.0www.edshop.cnD:\\shop5.2.6WINNT', 'utf-8');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('108', '3', '', 'yikatong', 'V2.0', 'X2.5', '20121101', '1356329466', '', 'http://www.edshop.cn/bbs/', 'admin@admin.com', '', '15603462165', '上海市', '徐汇区', '龙华街道', '0', 'acff6467676ac956f9aea3cf2237945f', '0', '', 'Microsoft-IIS/6.0www.edshop.cnD:\\shop5.2.6WINNT', 'utf-8');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('109', '3', '', 'yikatong', 'V2.0', 'X2.5', '20121101', '1356329780', '', 'http://www.edshop.cn/bbs/', 'admin@admin.com', '', '15605550666', '北京市', '朝阳区', '0', '0', 'acff6467676ac956f9aea3cf2237945f', '0', '', 'Microsoft-IIS/6.0www.edshop.cnD:\\shop5.2.6WINNT', 'utf-8');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('110', '3', '', 'yikatong', 'V2.0', 'X2.5', '20121101', '1356331542', '', 'http://www.sihong.so/', 'admin@sihong.so', '', '15370557066', '0', '0', '0', '0', '8563ffb1637c99f48ac3953c25a1b4fd', '0', '', 'Microsoft-IIS/6.0www.sihong.sod:\\wwwroot\\shuiyue1985\\wwwroot5.2.8WINNT', 'gbk');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('111', '3', '', 'yikatong', 'V2.0', 'X2.5', '20121101', '1356525830', '', 'http://www.0570.la/', '150250000@qq.com', '', '15700002025', '浙江省', '衢州市', '0', '0', '34667ef26ad15e26d8ce6d1c709a9d83', '0', '', 'Microsoft-IIS/6.0www.0570.laD:\\wz\\www.0570.la5.2.11WINNT', 'gbk');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('112', '3', '', 'yikatong', 'V2.0', 'X2.5', '20121101', '1356618151', '', 'http://bbs.0570.la/', '150250000@qq.com', '', '15700002025', '浙江省', '衢州市', '0', '0', 'ea4b127d8e7350f2c8bd6f9bd86b3712', '0', '', 'Microsoft-IIS/6.0bbs.0570.laD:\\wz\\www.0570.la5.2.11WINNT', 'gbk');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('113', '3', '', 'yikatong', 'V2.0', 'X2.5', '20121101', '1356677302', '', 'http://localhost/plugin/xueba/dz25gbk/', 'admin@admin.com', '', '13113890911', '河北省', '石家庄市', '0', '0', '0044c1abd94de03bd806e185a124d3c3', '0', '', 'Apache/2.2.6 (Win32) PHP/5.2.5localhostC:/wamp/wwwwebmaster@localhost127.0.0.15.2.5WINNT', 'gbk');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('114', '3', '', 'yikatong', 'V2.0', 'X2.5', '20121101', '1357041584', '', 'http://localhost/plugin/xueba/fenzhan_gbk/', 'admin@admin.com', '', '13113890911', '河北省', '石家庄市', '0', '0', 'f05c6b26c178e3411ec825b04d36507c', '0', '', 'Apache/2.2.4 (Win32) PHP/5.2.4localhostE:/Web/DedeAmpDebug/DedeAMPZ/WebRoot/Defaultadmin@myhost.com127.0.0.15.2.0WINNT', 'gbk');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('115', '3', '', 'yikatong', 'V2.0', 'X2.5', '20121101', '1359428318', '', 'http://www.quchengwang.com/', '150250000@qq.com', '', '15257048802', '浙江省', '衢州市', '0', '0', '23e3be8110f9ea93336df68e53bd456f', '0', '', 'Microsoft-IIS/6.0www.quchengwang.comD:\\wz\\quchengwang5.2.11WINNT', 'gbk');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('116', '3', '', 'yikatong', 'V2.0', 'X2.5', '20121101', '1359539086', '', 'http://www.91zlz.com/', '150250000@qq.com', '', '15700002025', '浙江省', '衢州市', '0', '0', 'f893044d849c91465fd32e67b816e608', '0', '', 'Microsoft-IIS/6.0www.91zlz.comD:\\wz\\91zlz5.2.11WINNT', 'gbk');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('117', '3', '', 'yikatong', 'V2.0', 'X2.5', '20121101', '1359545241', '', 'http://www.91zlz.com/', '150250000@qq.com', '', '15700002025', '浙江省', '衢州市', '0', '0', 'f893044d849c91465fd32e67b816e608', '0', '', 'Microsoft-IIS/6.0www.91zlz.comD:\\wz\\91zlz5.2.11WINNT', 'gbk');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('118', '3', '', 'yikatong', 'V2.0', 'X2.5', '20120407', '1359597002', '', 'http://www.0429sohu.com/', 'sohu0429@vip.qq.com', '', '13274298991', '辽宁省', '葫芦岛市', '连山区', '化工街道', 'ed122b850ad94731b872693910b67e7c', '0', '', 'Microsoft-IIS/6.0www.0429sohu.comD:\\www5.2.17WINNT', 'gbk');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('119', '3', '', 'yikatong', 'V2.0', 'X2.5', '20121101', '1359610062', '', 'http://www.5xcity.com/nn/', 'admin@admin.com', '', '13878182850', '广西壮族自治区', '南宁市', '兴宁区', '0', 'cb61dd97bba1fc840c6004f188fca8e9', '0', '', 'Microsoft-IIS/6.0www.5xcity.comD:\\wwwroot\\mvmmall\\www.5xcity.com\\web5.2.10WINNT', 'gbk');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('120', '3', '', 'yikatong', 'V2.0', 'X2.5', '20121101', '1359639785', '', 'http://www.866516.com/', 'admin@admin.com', '', '15852261252', '江苏省', '徐州市', '0', '0', '69cee9e1b58d8c015fc8bbc22e15232a', '0', '', 'Microsoft-IIS/6.0www.866516.comD:\\wwwroot5.2.17WINNT', 'gbk');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('121', '3', '', 'yikatong', 'V2.0', 'X2.5', '20121101', '1359639795', '', 'http://www.866516.com/', 'admin@admin.com', '', '15852261252', '江苏省', '徐州市', '0', '0', '69cee9e1b58d8c015fc8bbc22e15232a', '0', '', 'Microsoft-IIS/6.0www.866516.comD:\\wwwroot5.2.17WINNT', 'gbk');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('122', '3', '', 'yikatong', 'V2.0', 'X2.5', '20120901', '1359640463', '', 'http://www.qionghai.net/', '1098020999@qq.com', '', '13379897799', '海南省', '琼海市', '琼海市', '0', '850745518aa71a7dc5bb364a1adeb62a', '0', '', 'Microsoft-IIS/7.5www.qionghai.netD:\\wwwroot\\qionghai\\oo335.2.17WINNT', 'gbk');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('123', '3', '', 'yikatong', 'V2.0', 'X2.5', '20121101', '1359690893', '', 'http://www.rz166.com/', 'znh1027@163.com', '', '15506331572', '山东省', '日照市', '东港区', '秦楼街道', '42fb6cded2cc2e11c5c856c99abd23bd', '0', '', 'Microsoft-IIS/6.0www.rz166.comd:\\web\\www.rz166.com\\wwwroot5.2.17WINNT', 'gbk');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('124', '3', '', 'yikatong', 'V2.0', 'X2.5', '20121101', '1359776204', '', 'http://www.yileku.com/', '87620633@qq.com', '', '15506331572', '山东省', '日照市', '东港区', '秦楼街道', 'cfa7fdd4d7e40bc14a71719ef6be3e7c', '0', '', 'Microsoft-IIS/6.0www.yileku.comd:\\web\\www.rz166.com\\wwwroot5.2.17WINNT', 'gbk');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('125', '3', '', 'yikatong', 'V2.0', 'X2.5', '20121101', '1359778411', '', 'http://www.yileku.com/', '87620633@qq.com', '', '15506331572', '山东省', '日照市', '0', '0', 'cfa7fdd4d7e40bc14a71719ef6be3e7c', '0', '', 'Microsoft-IIS/6.0www.yileku.comd:\\web\\www.rz166.com\\wwwroot5.2.17WINNT', 'gbk');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('126', '3', '', 'yikatong', 'V2.0', 'X2.5', '20121101', '1359857319', '', 'http://www.shlf.org/', '1970393792@qq.com', '', '15000145241', '上海市', '静安区', '南京西路街道', '0', 'c5ab8fbca82419294eb59da5ea163b23', '0', '', 'nginx/1.0.15www.123fch.com/var/www/www.fch123.com198.15.73.385.2.14Linux', 'gbk');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('127', '3', '', 'yikatong', 'V2.0', 'X2.5', '20121101', '1359867378', '', 'http://yichuan.co/', 'bindao11@qq.com', '', '13653899809', '河南省', '洛阳市', '伊川县', '城关镇', 'e0cb9b45a2b67f95dfb8c305ca1ba0f8', '0', '', 'Apacheyichuan.co/www/web/yichuan_co/public_htmlyou@example.com127.0.0.15.2.17p1Linux', 'gbk');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('128', '3', '', 'yikatong', 'V2.0', 'X2.5', '20121101', '1359868318', '', 'http://yichuan.co/', 'bindao11@qq.com', '', '13653899809', '河南省', '洛阳市', '伊川县', '0', 'e0cb9b45a2b67f95dfb8c305ca1ba0f8', '0', '', 'Apacheyichuan.co/www/web/yichuan_co/public_htmlyou@example.com127.0.0.15.2.17p1Linux', 'gbk');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('129', '3', '', 'yikatong', 'V2.0', 'X2.5', '20121101', '1359993843', '', 'http://localhost/plugin/xueba/fenzhan_gbk/', 'admin@admin.com', '', '12345678901', '河北省', '石家庄市', '0', '0', 'f05c6b26c178e3411ec825b04d36507c', '0', '', 'Apache/2.2.4 (Win32) PHP/5.2.4localhostE:/Web/DedeAmpDebug/DedeAMPZ/WebRoot/Defaultadmin@myhost.com127.0.0.15.2.0WINNT', 'gbk');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('130', '3', '', 'yikatong', 'V2.0', 'X2.5', '20130201', '1359965029', '', 'http://www.yongchuanzhe.com/', '413224887@qq.com', '', '13647607240', '重庆市', '永川市', '0', '0', '922c29a439e533cc77f4992f5f107944', '0', '', 'Microsoft-IIS/6.0www.yongchuanzhe.comC:\\web\\web5.2.17WINNT', 'gbk');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('131', '3', '', 'yikatong', 'V2.0', 'X2.5', '20130201', '1360048250', '', 'http://www.sihong.so/', '23470234@qq.com', '', '15370557066', '江苏省', '宿迁市', '泗洪县', '0', '8563ffb1637c99f48ac3953c25a1b4fd', '0', '', 'Microsoft-IIS/6.0www.sihong.sod:\\wwwroot\\shuiyue1985\\wwwroot5.2.8WINNT', 'gbk');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('132', '3', '', 'yikatong', 'V2.0', 'X2.5', '20120407', '1360125786', '', 'http://www.0429sohu.com/', 'sohu0429@vip.qq.com', '', '13274298991', '辽宁省', '葫芦岛市', '0', '0', 'ed122b850ad94731b872693910b67e7c', '0', '', 'Microsoft-IIS/6.0www.0429sohu.comD:\\www5.2.17WINNT', 'gbk');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('133', '3', '', 'yikatong', 'V1.0', 'X2.5', '20121101', '0', '', 'http://localhost/plugin/xueba/fenzhan_gbk/', 'admin@admin.com', '', '', '0', '0', '0', '0', '99ba20090d16ab13cb6d36c601ddffab', '0', '', '', 'gbk');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('134', '3', '', 'yikatong', 'V1.0', 'X2.5', '20121101', '0', '', 'http://localhost/plugin/xueba/fenzhan_gbk/', 'admin@admin.com', '', '', '0', '0', '0', '0', '99ba20090d16ab13cb6d36c601ddffab', '0', '', '', 'gbk');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('135', '4', '', 'yiqixueba_tuijianren', 'V1.0', 'X2.5', '20121101', '0', '', 'http://localhost/plugin/xueba/fenzhan_gbk/', 'admin@admin.com', '', '', '', '', '', '', 'f808f38763e6b0de96f16027c10ef6aa', '0', '', '', 'gbk');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('136', '4', '', 'yiqixueba_tuijianren', 'V1.0', 'X2.5', '20121101', '0', '', 'http://localhost/plugin/xueba/fenzhan_gbk/', 'admin@admin.com', '', '13113890911', '', '', '', '', 'f808f38763e6b0de96f16027c10ef6aa', '0', '', '', 'gbk');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('137', '4', '', 'yiqixueba_tuijianren', 'V1.0', 'X2.5', '20120701', '0', '', 'http://17xue8.cn:88/debug/', 'admin@admin.com', '', '12345678901', '', '', '', '', 'f808f38763e6b0de96f16027c10ef6aa', '0', '', '', 'gbk');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('138', '3', '', 'yikatong', 'V2.0', 'X2.5', '20120701', '1360251579', '', 'http://bbs.ekemall.net/', 'bglgc@qq.com', '', '18041416988', '辽宁省', '本溪市', '平山区', '站前街道', 'c4b2d5e85f7f68f57d5ec25be59fee82', '0', '', 'Microsoft-IIS/7.5bbs.ekemall.netD:\\taobenxi5.2.5WINNT', 'gbk');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('139', '4', '', 'yiqixueba_tuijianren', 'V1.0', 'X2.5', '20130201', '0', '', 'http://www.258mj.net/', 'kf@258mj.net', '', '15685736199', '', '', '', '', 'f808f38763e6b0de96f16027c10ef6aa', '0', '', '', 'gbk');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('140', '4', '', 'yiqixueba_tuijianren', 'V1.0', 'X2.5', '20121101', '0', '', 'http://www.258mj.net/wz/', 'kf@258mj.net', '', '15685736199', '', '', '', '', 'f808f38763e6b0de96f16027c10ef6aa', '0', '', '', 'gbk');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('141', '4', '', 'yiqixueba_tuijianren', 'V1.0', 'X2.5', '20120601', '0', '', 'http://127.0.0.1/', 'admin@admin.com', '', '15685736199', '', '', '', '', 'f808f38763e6b0de96f16027c10ef6aa', '0', '', '', 'gbk');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('142', '3', '', 'yikatong', 'V2.0', 'X2.5', '20130222', '1361778876', '', 'http://www.91zlz.com/', '150250000@qq.com', '', '15700002025', '浙江省', '衢州市', '0', '0', 'f893044d849c91465fd32e67b816e608', '0', '', 'Microsoft-IIS/6.0www.91zlz.comD:\\wz\\91zlz5.2.11WINNT', 'gbk');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('143', '3', '', 'yikatong', 'V2.0', 'X2.5', '20130222', '1363090182', '', 'http://www.bidewang.cc/', '842988818@qq.com', '', '13782152211', '河南省', '南阳市', '0', '0', '868c4cd6464d11aac52446f65aea3d32', '0', '', 'Microsoft-IIS/6.0www.bidewang.ccD:\\WorkSpace\\bidewang5.2.5WINNT', 'gbk');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('144', '3', '', 'yikatong', 'V2.0', 'X2.5', '20130222', '1363354169', '', 'http://www.bidewang.cc/', '842988818@qq.com', '', '13782152211', '河南省', '南阳市', '0', '0', '868c4cd6464d11aac52446f65aea3d32', '0', '', 'Microsoft-IIS/6.0www.bidewang.ccD:\\WorkSpace\\bidewang5.2.5WINNT', 'gbk');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('145', '3', '', 'yikatong', 'V2.0', 'X2.5', '20121101', '1363359192', '', 'http://bbs.0434qq.com/', 'jyemco@163.com', '', '18643493886', '吉林省', '四平市', '0', '0', 'bca7f8dacc429adb1ee93dbf26b48a8b', '0', '', 'Microsoft-IIS/6.0bbs.0434qq.comD:\\wwwroot\\wwwroot5.2.5WINNT', 'gbk');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('146', '3', '', 'yikatong', 'V2.0', 'X2.5', '20130222', '1363592608', '', 'http://www.cangnanlt.com/', 'admin@cangnanlt.com', '', '18058871160', '浙江省', '温州市', '苍南县', '灵溪镇', '5bdf100ab6ada2b6d564ef3db5dc7637', '0', '', 'Microsoft-IIS/6.0www.cangnanlt.comD:\\zhiroc5.2.17WINNT', 'gbk');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('147', '3', '', 'yikatong', 'V2.0', 'X2.5', '20130222', '1364177446', '', 'http://www.bidewang.cc/', 'admin@bidewang.cc', '', '13782152211', '河南省', '南阳市', '0', '0', '868c4cd6464d11aac52446f65aea3d32', '0', '', 'Microsoft-IIS/6.0www.bidewang.ccD:\\WorkSpace\\bidewang5.2.5WINNT', 'gbk');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('148', '3', '', 'yikatong', 'V2.0', 'X2.5', '20130222', '1364188250', '', 'http://www.qhdbaobao.com/', '44349336@QQ.com', '', '13091388077', '河北省', '秦皇岛市', '0', '0', '13c3fd81efe8124e052d0496b6dab31a', '0', '', 'Microsoft-IIS/6.0www.qhdbaobao.comD:\\wwwroot\\qhdbaobao\\htdocs5.2.17WINNT', 'gbk');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('149', '3', '', 'yikatong', 'V2.0', 'X2.5', '20130222', '1364463756', '', 'http://lt.bidewang.cc/', 'admin@bidewang.cc', '', '13782152211', '河南省', '南阳市', '0', '0', 'ebaed2876bcd7c53e83e1e574adb3b30', '0', '', 'Microsoft-IIS/6.0lt.bidewang.ccD:\\WorkSpace\\ceshi5.2.5WINNT', 'gbk');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('150', '3', '', 'yikatong', 'V2.0', 'X2.5', '20130222', '1364872473', '', 'http://www.yileku.com/', '417693131@qq.com', '', '18063310010', '山东省', '日照市', '0', '0', 'cfa7fdd4d7e40bc14a71719ef6be3e7c', '0', '', 'Microsoft-IIS/6.0www.yileku.comd:\\web\\www.rz166.com\\wwwroot5.2.17WINNT', 'gbk');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('151', '3', '', 'yikatong', 'V2.0', 'X2.5', '20130222', '1364909089', '', 'http://www.yileku.com/', '417693131@qq.com', '', '18063310010', '山东省', '日照市', '0', '0', 'cfa7fdd4d7e40bc14a71719ef6be3e7c', '0', '', 'Microsoft-IIS/6.0www.yileku.comd:\\web\\www.rz166.com\\wwwroot5.2.17WINNT', 'gbk');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('152', '3', '', 'yikatong', 'V2.0', 'X2.5', '20130222', '1364910151', '', 'http://www.yileku.com/', '417693131@qq.com', '', '15257048802', '上海市', '长宁区', '0', '0', 'cfa7fdd4d7e40bc14a71719ef6be3e7c', '0', '', 'Microsoft-IIS/6.0www.yileku.comd:\\web\\www.rz166.com\\wwwroot5.2.17WINNT', 'gbk');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('153', '3', '', 'yikatong', 'V2.0', 'X2.5', '20130201', '1365059967', '', 'http://bbs.mile114.com/', '330993942@qq.com', '', '15257048802', '云南省', '丽江市', '0', '0', '39ea5590c3b05423187a29b79a8972a0', '0', '', 'Microsoft-IIS/6.0bbs.mile114.comD:\\wwwwork\\bbs5.2.6WINNT', 'gbk');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('154', '3', '', 'yikatong', 'V2.0', 'X2.5', '20130222', '1365467676', '', 'http://lt.bidewang.cc/', 'admin@bidewang.cc', '', '13782152211', '河南省', '南阳市', '0', '0', 'ebaed2876bcd7c53e83e1e574adb3b30', '0', '', 'Microsoft-IIS/6.0lt.bidewang.ccD:\\WorkSpace\\ceshi5.2.5WINNT', 'gbk');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('155', '3', '', 'yikatong', 'V2.0', 'X2.5', '20130201', '1366269822', '', 'http://bbs.mile114.com/', '330993942@qq.com', '', '13529671589', '云南省', '红河哈尼族彝族自治州', '弥勒县', '0', '39ea5590c3b05423187a29b79a8972a0', '0', '', 'Microsoft-IIS/6.0bbs.mile114.comD:\\wwwwork\\bbs5.2.6WINNT', 'gbk');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('156', '3', '', 'yikatong', 'V2.0', 'X2.5', '20121101', '1366885620', '', 'http://www.pingshanba.cn/bbs/', 'daozi@dishiroom.com', '', '15632322939', '河北省', '石家庄市', '平山县', '0', '3a4621f34e1b404f6f2ad096526a252f', '0', '', 'Microsoft-IIS/6.0www.pingshanba.cnD:\\wwwroot\\pingshan\\web5.2.6WINNT', 'gbk');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('157', '3', '', 'yikatong', 'V2.0', 'X2.5', '20121101', '1367293808', '', 'http://www.pingshanba.cn/bbs/', 'daozi@dishiroom.com', '', '15632322939', '河北省', '石家庄市', '0', '0', '3a4621f34e1b404f6f2ad096526a252f', '0', '', 'Microsoft-IIS/6.0www.pingshanba.cnD:\\wwwroot\\pingshan\\web5.2.6WINNT', 'gbk');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('158', '3', '', 'yikatong', 'V2.0', 'X2.5', '20120901', '1368162749', '', 'http://whzd012395.chinaw3.com/', 'cysqshw@126.com', '', '15700002025', '北京市', '延庆县', '0', '0', 'dde8db0376d8aee0a18f5b4f8d6d2120', '0', '', 'Microsoft-IIS/7.5whzd012395.chinaw3.comD:\\WorkSpace5.2.5WINNT', 'gbk');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('159', '3', '', 'yikatong', 'V2.0', 'X2.5', '20120901', '1368164047', '', 'http://whzd012395.chinaw3.com/', 'cysqshw@126.com', '', '18701077500', '北京市', '房山区', '长阳镇', '0', 'dde8db0376d8aee0a18f5b4f8d6d2120', '0', '', 'Microsoft-IIS/7.5whzd012395.chinaw3.comD:\\WorkSpace5.2.5WINNT', 'gbk');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('160', '3', '', 'yikatong', 'V2.0', 'X2.5', '20120518', '1368590157', '', 'http://nabel.130dns.com/', 'admin@admin.com', '', '13807324298', '湖南省', '湘潭市', '0', '0', 'f4177897984ee38050fc382e0a9c723d', '0', '', 'Microsoft-IIS/6.0nabel.130dns.comD:\\web5.2.17WINNT', 'gbk');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('161', '3', '', 'yikatong', 'V2.0', 'X2.5', '20120518', '1368590418', '', 'http://nabel.130dns.com/', 'admin@admin.com', '', '13807324298', '湖南省', '湘潭市', '0', '0', 'f4177897984ee38050fc382e0a9c723d', '0', '', 'Microsoft-IIS/6.0nabel.130dns.comD:\\web5.2.17WINNT', 'gbk');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('162', '3', '', 'yikatong', 'V2.0', 'X2.5', '20120901', '1368699683', '', 'http://whzd012395.chinaw3.com/', 'cysqshw@126.com', '', '18701077500', '北京市', '房山区', '长阳镇', '0', 'dde8db0376d8aee0a18f5b4f8d6d2120', '0', '', 'Microsoft-IIS/7.5whzd012395.chinaw3.comD:\\WorkSpace5.2.5WINNT', 'gbk');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('163', '3', '', 'yikatong', 'V2.0', 'X2.5', '20130426', '1369144821', '', 'http://www.yongchuanzhe.com/', '413224887@qq.com', '', '15257048802', '重庆市', '石柱土家族自治县', '0', '0', '18b3c3499080fa7b3e0a411b9e8e881f', '0', '', 'Microsoft-IIS/6.0www.yongchuanzhe.comD:\\', 'gbk');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('164', '3', '', 'yikatong', 'V2.0', 'X2.5', '20130426', '1369274427', '', 'http://www.yongchuanzhe.com/', '413224887@qq.com', '', '15700002025', '浙江省', '丽水市', '0', '0', '18b3c3499080fa7b3e0a411b9e8e881f', '0', '', 'Microsoft-IIS/6.0www.yongchuanzhe.comD:\\', 'gbk');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('165', '3', '', 'yikatong', 'V2.0', 'X2.5', '20120901', '1369827423', '', 'http://www.cysqshw.com/', 'cysqshw@126.com', '', '18701077500', '北京市', '房山区', '长阳镇', '0', '30aa4c914de654a4129ec0fb24ed9d82', '0', '', 'Microsoft-IIS/7.5www.cysqshw.comD:\\WorkSpace5.2.5WINNT', 'gbk');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('166', '3', '', 'yikatong', 'V2.0', 'X2.5', '20121101', '1370228741', '', 'http://www.quchengwang.com/', '150250000@qq.com', '', '15071753751', '浙江省', '衢州市', '0', '0', '23e3be8110f9ea93336df68e53bd456f', '0', '', 'Microsoft-IIS/6.0www.quchengwang.comD:\\wz\\quchengwang5.2.11WINNT', 'gbk');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('167', '3', '', 'yikatong', 'V2.0', 'X2.5', '20130426', '1370411186', '', 'http://xtsjlm.com/', 'admin@xtsjlm.com', '', '13807324298', '湖南省', '湘潭市', '岳塘区', '双马镇', 'ecdb5cd5b9b3cd77914397014b7e2030', '0', '', 'Microsoft-IIS/6.0xtsjlm.comD:\\web5.2.17WINNT', 'gbk');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('168', '3', '', 'yikatong', 'V2.0', 'X2.5', '20130426', '1370412647', '', 'http://www.xtsjlm.com/', 'admin@xtsjlm.com', '', '13807324298', '湖南省', '湘潭市', '0', '0', '3bece5b8aaa85b0f6fb8d53fc1d78111', '0', '', 'Microsoft-IIS/6.0www.xtsjlm.comD:\\web5.2.17WINNT', 'gbk');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('169', '3', '', 'yikatong', 'V2.0', 'X2.5', '20130426', '1370412713', '', 'http://www.xtsjlm.com/', 'admin@xtsjlm.com', '', '13807324298', '湖南省', '湘潭市', '0', '0', '3bece5b8aaa85b0f6fb8d53fc1d78111', '0', '', 'Microsoft-IIS/6.0www.xtsjlm.comD:\\web5.2.17WINNT', 'gbk');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('170', '3', '', 'yikatong', 'V2.0', 'X2.5', '20130426', '1371386776', '', 'http://www.cysqshw.com/', 'cysqshw@126.com', '', '13811173979', '0', '0', '0', '0', '30aa4c914de654a4129ec0fb24ed9d82', '0', '', 'Microsoft-IIS/7.5www.cysqshw.comD:\\WorkSpace5.2.5WINNT', 'gbk');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('171', '3', '', 'yikatong', 'V2.0', 'X2.5', '20130426', '1371568144', '', 'http://www.cysqshw.com/', 'cysqshw@126.com', '', '13811173949', '北京市', '房山区', '0', '0', '30aa4c914de654a4129ec0fb24ed9d82', '0', '', 'Microsoft-IIS/7.5www.cysqshw.comD:\\WorkSpace5.2.5WINNT', 'gbk');
INSERT INTO `xueba_yiqixueba_pluginlist` VALUES ('172', '3', '', 'yikatong', 'V2.0', 'X2.5', '20121101', '1371626244', '', 'http://www.quchengwang.com/', '150250000@qq.com', '', '13711111111', '北京市', '延庆县', '沈家营镇', '0', '23e3be8110f9ea93336df68e53bd456f', '0', '', 'Microsoft-IIS/6.0www.quchengwang.comD:\\wz\\quchengwang5.2.11WINNT', 'gbk');

-- ----------------------------
-- Table structure for `xueba_yiqixueba_server_admincpmenu`
-- ----------------------------
DROP TABLE IF EXISTS `xueba_yiqixueba_server_admincpmenu`;
CREATE TABLE `xueba_yiqixueba_server_admincpmenu` (
  `menuid` smallint(6) unsigned NOT NULL auto_increment,
  `name` char(30) NOT NULL,
  `title` char(30) NOT NULL,
  `type` char(30) NOT NULL,
  `level` char(30) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `displayorder` smallint(6) NOT NULL,
  PRIMARY KEY  (`menuid`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=utf8 COMMENT='后台菜单';

-- ----------------------------
-- Records of xueba_yiqixueba_server_admincpmenu
-- ----------------------------
INSERT INTO `xueba_yiqixueba_server_admincpmenu` VALUES ('1', 'main', '系统设置', 'group', '', '1', '0');
INSERT INTO `xueba_yiqixueba_server_admincpmenu` VALUES ('2', 'base', '平台首页', '1', '', '1', '0');
INSERT INTO `xueba_yiqixueba_server_admincpmenu` VALUES ('4', 'mokuai', '模块管理', 'group', '', '1', '1');
INSERT INTO `xueba_yiqixueba_server_admincpmenu` VALUES ('6', 'reg', '插件注册', '1', '', '1', '1');
INSERT INTO `xueba_yiqixueba_server_admincpmenu` VALUES ('7', 'list', '模块列表', '4', '', '1', '0');
INSERT INTO `xueba_yiqixueba_server_admincpmenu` VALUES ('8', 'install', '安装模块', '4', '', '1', '100');
INSERT INTO `xueba_yiqixueba_server_admincpmenu` VALUES ('9', 'chongzhi', '帐号充值', '1', '', '1', '2');
INSERT INTO `xueba_yiqixueba_server_admincpmenu` VALUES ('10', 'huodong', '活动帖子', '4', '', '1', '1');
INSERT INTO `xueba_yiqixueba_server_admincpmenu` VALUES ('11', 'jiudian', '迷你酒店', '4', '', '1', '2');
INSERT INTO `xueba_yiqixueba_server_admincpmenu` VALUES ('12', 'huiyuanka', '会员卡', 'group', '', '1', '2');
INSERT INTO `xueba_yiqixueba_server_admincpmenu` VALUES ('13', 'setting', '基础设置', '12', '', '1', '0');
INSERT INTO `xueba_yiqixueba_server_admincpmenu` VALUES ('14', 'yikatong', '一卡通', 'group', '', '1', '3');
INSERT INTO `xueba_yiqixueba_server_admincpmenu` VALUES ('15', 'brand', '联盟商家', 'group', '', '1', '4');
INSERT INTO `xueba_yiqixueba_server_admincpmenu` VALUES ('16', 'setting', '基础设置', '14', '', '1', '0');
INSERT INTO `xueba_yiqixueba_server_admincpmenu` VALUES ('17', 'setting', '基础设置', '15', '', '1', '0');
INSERT INTO `xueba_yiqixueba_server_admincpmenu` VALUES ('18', 'ztfd', '赞同反对', '4', '', '1', '3');
INSERT INTO `xueba_yiqixueba_server_admincpmenu` VALUES ('19', 'sync', '版本控制', 'group', '', '1', '5');
INSERT INTO `xueba_yiqixueba_server_admincpmenu` VALUES ('20', 'searchproject', '查找项目', '19', '', '1', '2');
INSERT INTO `xueba_yiqixueba_server_admincpmenu` VALUES ('21', 'newproject', '新建项目', '19', '', '1', '1');
INSERT INTO `xueba_yiqixueba_server_admincpmenu` VALUES ('22', 'myproject', '我的项目', '19', '', '1', '0');

-- ----------------------------
-- Table structure for `xueba_yiqixueba_server_funclist`
-- ----------------------------
DROP TABLE IF EXISTS `xueba_yiqixueba_server_funclist`;
CREATE TABLE `xueba_yiqixueba_server_funclist` (
  `funcid` mediumint(11) unsigned NOT NULL auto_increment,
  `functype` tinyint(1) NOT NULL,
  `funcfile` char(50) NOT NULL,
  `funcname` char(50) NOT NULL,
  `functitle` char(50) NOT NULL,
  `description` varchar(255) NOT NULL,
  `funcparameters` varchar(255) NOT NULL,
  `functags` varchar(255) NOT NULL,
  `funcusage` varchar(255) NOT NULL,
  `funcexamples` varchar(255) NOT NULL,
  `funccode` text NOT NULL,
  `funccelated` varchar(255) NOT NULL,
  PRIMARY KEY  (`funcname`,`funcid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of xueba_yiqixueba_server_funclist
-- ----------------------------
INSERT INTO `xueba_yiqixueba_server_funclist` VALUES ('1', '2', 'dataquery', 'getapi', '标识', '士大夫三大', '参数', '', '作用', '产生抵触', '', '相关');
INSERT INTO `xueba_yiqixueba_server_funclist` VALUES ('1', '1', 'function_core', '15', '系统错误', '调用discuz_error类的system_error方法', '', '', '判断系统错误', '', 'function system_error($message, $show = true, $save = true, $halt = true) {\r\n	discuz_error::system_error($message, $show, $save, $halt);\r\n}', '');
INSERT INTO `xueba_yiqixueba_server_funclist` VALUES ('1', '1', 'function_core', '19', 'session升级', '', '', '', '升级session', '', 'function updatesession() {\r\n	return C::app()-&gt;session-&gt;updatesession();\r\n}', '');

-- ----------------------------
-- Table structure for `xueba_yiqixueba_server_hook`
-- ----------------------------
DROP TABLE IF EXISTS `xueba_yiqixueba_server_hook`;
CREATE TABLE `xueba_yiqixueba_server_hook` (
  `hookid` mediumint(11) unsigned NOT NULL auto_increment,
  `curscript` char(50) NOT NULL,
  `curmodule` char(100) NOT NULL,
  `output` tinyint(1) NOT NULL,
  `mokuaiid` smallint(6) NOT NULL,
  `code` text NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY  (`hookid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of xueba_yiqixueba_server_hook
-- ----------------------------
INSERT INTO `xueba_yiqixueba_server_hook` VALUES ('1', 'forum', 'viewthread_postbottom', '1', '5', 'bdfgsdg', '1');

-- ----------------------------
-- Table structure for `xueba_yiqixueba_server_mokuai`
-- ----------------------------
DROP TABLE IF EXISTS `xueba_yiqixueba_server_mokuai`;
CREATE TABLE `xueba_yiqixueba_server_mokuai` (
  `mokuaiid` smallint(6) unsigned NOT NULL auto_increment,
  `mokuainame` char(30) character set utf8 NOT NULL,
  `mokuaititle` char(30) character set utf8 NOT NULL,
  `status` tinyint(1) NOT NULL,
  `description` varchar(255) character set utf8 NOT NULL,
  `price` int(10) NOT NULL,
  `mokuaivars` text character set utf8 NOT NULL,
  `version` varchar(20) character set utf8 NOT NULL,
  `modules` text character set utf8 NOT NULL,
  `copyright` varchar(100) character set utf8 NOT NULL,
  `mokuaiadmin` text character set utf8 NOT NULL,
  `mokuaihook` text character set utf8 NOT NULL,
  `mokuaiajax` text character set utf8 NOT NULL,
  `mokuaiapi` text character set utf8 NOT NULL,
  `mokuaifunc` text character set utf8,
  PRIMARY KEY  (`mokuaiid`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of xueba_yiqixueba_server_mokuai
-- ----------------------------
INSERT INTO `xueba_yiqixueba_server_mokuai` VALUES ('1', 'main', '主程序', '0', '一起学吧主程序', '0', '', 'V1.0', '', '17xue8.cn', '', '', '', '', null);
INSERT INTO `xueba_yiqixueba_server_mokuai` VALUES ('2', 'jiudian', '酒店迷你网页', '1', '王琦曾经搞的插件', '30000', '', 'V1.0', 'a:1:{i:0;a:10:{s:4:\"name\";s:5:\"admin\";s:4:\"menu\";s:12:\"后台管理\";s:3:\"url\";s:0:\"\";s:4:\"type\";s:1:\"3\";s:7:\"adminid\";s:1:\"0\";s:12:\"displayorder\";i:0;s:8:\"navtitle\";s:0:\"\";s:7:\"navicon\";s:0:\"\";s:10:\"navsubname\";s:0:\"\";s:9:\"navsuburl\";s:0:\"\";}}', '17xue8.cn', '', '', '', '', null);
INSERT INTO `xueba_yiqixueba_server_mokuai` VALUES ('3', 'yikatong', '一卡通', '1', '', '50000', '', 'V1.0', '', '17xue8.cn', '', '', '', '', null);
INSERT INTO `xueba_yiqixueba_server_mokuai` VALUES ('4', 'huiyuanka', '会员卡', '1', '会员卡', '50000', '', 'V1.0', 'a:2:{i:0;a:10:{s:4:\"name\";s:5:\"asdas\";s:4:\"menu\";s:7:\"dasdsad\";s:3:\"url\";s:0:\"\";s:4:\"type\";s:1:\"3\";s:7:\"adminid\";s:1:\"0\";s:12:\"displayorder\";i:0;s:8:\"navtitle\";s:0:\"\";s:7:\"navicon\";s:0:\"\";s:10:\"navsubname\";s:0:\"\";s:9:\"navsuburl\";s:0:\"\";}i:1;a:10:{s:4:\"name\";s:5:\"sadsa\";s:4:\"menu\";s:5:\"sadsa\";s:3:\"url\";s:0:\"\";s:4:\"type\";s:2:\"11\";s:7:\"adminid\";s:1:\"0\";s:12:\"displayorder\";i:0;s:8:\"navtitle\";s:0:\"\";s:7:\"navicon\";s:0:\"\";s:10:\"navsubname\";s:0:\"\";s:9:\"navsuburl\";s:0:\"\";}}', '17xue8.cn', '', '', '', '', null);
INSERT INTO `xueba_yiqixueba_server_mokuai` VALUES ('5', 'huodong', '活动有效期', '1', '网生定制', '15000', '', 'V1.0', '', '17xue8.cn', '', '', '', '', null);
INSERT INTO `xueba_yiqixueba_server_mokuai` VALUES ('6', 'makeplugin', '插件魔王', '1', '插件生成器', '0', 'a:2:{i:0;a:4:{s:12:\"displayorder\";s:1:\"0\";s:5:\"title\";s:5:\"fsdaf\";s:8:\"variable\";s:6:\"fsdfsd\";s:4:\"type\";s:7:\"selects\";}i:1;a:4:{s:12:\"displayorder\";s:1:\"0\";s:5:\"title\";s:6:\"测试\";s:8:\"variable\";s:5:\"ceshi\";s:4:\"type\";s:14:\"group_textarea\";}}', 'V1.0', 'a:1:{i:0;a:10:{s:4:\"name\";s:7:\"admincp\";s:4:\"menu\";s:12:\"后台管理\";s:3:\"url\";s:0:\"\";s:4:\"type\";s:1:\"3\";s:7:\"adminid\";s:1:\"0\";s:12:\"displayorder\";i:0;s:8:\"navtitle\";s:0:\"\";s:7:\"navicon\";s:0:\"\";s:10:\"navsubname\";s:0:\"\";s:9:\"navsuburl\";s:0:\"\";}}', '17xue8.cn', '', '', '', '', null);
INSERT INTO `xueba_yiqixueba_server_mokuai` VALUES ('7', 'dataquery', '数据查询', '1', '网友“飞翔的猪”定制的开班信息查询插件，5月1日前完成', '50000', 'a:2:{i:0;a:5:{s:8:\"mokuaiid\";s:1:\"7\";s:12:\"displayorder\";s:1:\"0\";s:5:\"title\";s:10:\"usergroups\";s:8:\"variable\";s:24:\"允许使用的影虎组\";s:4:\"type\";s:6:\"groups\";}i:1;a:5:{s:8:\"mokuaiid\";s:1:\"7\";s:12:\"displayorder\";s:1:\"0\";s:5:\"title\";s:12:\"测试一下\";s:8:\"variable\";s:8:\"testname\";s:4:\"type\";s:7:\"selects\";}}', 'V1.0', 'a:1:{i:0;a:10:{s:4:\"name\";s:7:\"admincp\";s:4:\"menu\";s:12:\"后台设置\";s:3:\"url\";s:0:\"\";s:4:\"type\";s:1:\"3\";s:7:\"adminid\";s:1:\"0\";s:12:\"displayorder\";i:0;s:8:\"navtitle\";s:0:\"\";s:7:\"navicon\";s:0:\"\";s:10:\"navsubname\";s:0:\"\";s:9:\"navsuburl\";s:0:\"\";}}', '17xue8.cn', '', '', '', '', null);
INSERT INTO `xueba_yiqixueba_server_mokuai` VALUES ('8', 'cardelm', '卡益联盟', '0', '原一卡通', '0', '', 'v1.0', '', 'cardelm', '', '', '', '', null);

-- ----------------------------
-- Table structure for `xueba_yiqixueba_server_mokuai_codepart`
-- ----------------------------
DROP TABLE IF EXISTS `xueba_yiqixueba_server_mokuai_codepart`;
CREATE TABLE `xueba_yiqixueba_server_mokuai_codepart` (
  `cpid` mediumint(11) unsigned NOT NULL auto_increment,
  `type` char(30) NOT NULL,
  `zhushi` varchar(30) NOT NULL,
  `key` varchar(255) NOT NULL,
  `value` text NOT NULL,
  PRIMARY KEY  (`cpid`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of xueba_yiqixueba_server_mokuai_codepart
-- ----------------------------
INSERT INTO `xueba_yiqixueba_server_mokuai_codepart` VALUES ('1', 'mokuaiadmin', '注释', 'PHP', '&lt;?php\r\n\r\nif(!defined(\'IN_DISCUZ\') || !defined(\'IN_ADMINCP\')) {\r\n	exit(\'Access Denied\');\r\n}\r\n\r\n?&gt;');
INSERT INTO `xueba_yiqixueba_server_mokuai_codepart` VALUES ('21', 'mokuaiindex', '注释', 'array2xml', 'require_once libfile(\'class/xml\');\r\n	$filename = $action.\'.xml\';\r\n	$plugin_export = array2xml($out_data, 1);\r\n	ob_end_clean();\r\n	dheader(\'Expires: Mon, 26 Jul 1997 05:00:00 GMT\');\r\n	dheader(\'Last-Modified: \'.gmdate(\'D, d M Y H:i:s\').\' GMT\');\r\n	dheader(\'Cache-Control: no-cache, must-revalidate\');\r\n	dheader(\'Pragma: no-cache\');\r\n	dheader(\'Content-Encoding: none\');\r\n	dheader(\'Content-Length: \'.strlen($plugin_export));\r\n	dheader(\'Content-Disposition: attachment; filename=\'.$filename);\r\n	dheader(\'Content-Type: text/xml\');\r\n	echo $plugin_export;\r\n	define(\'FOOTERDISABLED\' , 1);\r\n	exit();');
INSERT INTO `xueba_yiqixueba_server_mokuai_codepart` VALUES ('4', 'mokuaiadmin', '注释', '表单1', 'if(!submitcheck(\'submit\')) {\r\n		showformheader(&quot;yiqixueba&amp;operation=mokuai&amp;submod=mokuaicode&amp;edittype=&quot;.$edittype.&quot;&amp;mokuaiid=&quot;.$mokuaiid);\r\n		showtableheader(\'mokuaicode\');\r\n		showsubmit(\'submit\');\r\n		showtablefooter();\r\n		showformfooter();\r\n	}else{\r\n	}');
INSERT INTO `xueba_yiqixueba_server_mokuai_codepart` VALUES ('19', 'mokuaitemp', '注释', '只能汉字', '&lt;input type=&quot;text&quot; onkeyup=&quot;value=value.replace(/[^\\u4E00-\\u9FA5]/g,\\\'\\\')&quot; onbeforepaste=&quot;clipboardData.setData(\\\'text\\\',clipboardData.getData(\\\'text\\\').replace(/[^\\u4E00-\\u9FA5]/g,\\\'\\\'))&quot; name=&quot;pagetitle&quot;  size=&quot;30&quot; value=&quot;&quot;&gt;');
INSERT INTO `xueba_yiqixueba_server_mokuai_codepart` VALUES ('20', 'mokuaitemp', '注释', '英文数字', '&lt;input onkeyup=&quot;value=value.replace(/[\\W]/g,\\\'\\\') &quot;onbeforepaste=&quot;clipboardData.setData(\\\'text\\\',clipboardData.getData(\\\'text\\\').replace(/[^\\d]/g,\\\'\\\'))&quot; type=&quot;text&quot; name=&quot;pagename&quot;  size=&quot;30&quot; value=&quot;&quot;&gt;');
INSERT INTO `xueba_yiqixueba_server_mokuai_codepart` VALUES ('18', 'mokuaiadmin', '注释', '后台头', '&lt;?php\r\n\r\nif(!defined(\'IN_DISCUZ\') || !defined(\'IN_ADMINCP\')) {\r\n	exit(\'Access Denied\');\r\n}\r\n\r\n\r\n?&gt;');

-- ----------------------------
-- Table structure for `xueba_yiqixueba_server_mokuai_page`
-- ----------------------------
DROP TABLE IF EXISTS `xueba_yiqixueba_server_mokuai_page`;
CREATE TABLE `xueba_yiqixueba_server_mokuai_page` (
  `pageid` mediumint(11) unsigned NOT NULL auto_increment,
  `mokuaiid` mediumint(11) NOT NULL,
  `pagetype` varchar(50) NOT NULL,
  `pagename` varchar(255) NOT NULL,
  `pagetitle` varchar(255) NOT NULL,
  `pageusage` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `first` char(32) NOT NULL,
  `second` char(32) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `rules` text NOT NULL,
  `createtime` int(10) unsigned NOT NULL,
  `pagecode` text NOT NULL,
  `synccode` text NOT NULL,
  PRIMARY KEY  (`pageid`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of xueba_yiqixueba_server_mokuai_page
-- ----------------------------
INSERT INTO `xueba_yiqixueba_server_mokuai_page` VALUES ('9', '1', 'mokuaiadmin', 'mokuaiadmin', '模块管理', '主程序后台管理模块', '对模块进行管理', '', '', '0', '', '1367085456', '&lt;?php\r\n\r\nif(!defined(‘IN_DISCUZ‘) || !defined(‘IN_ADMINCP‘)) {\r\n	exit(‘Access Denied‘);\r\n}\r\n\r\nif(!submitcheck(‘submit‘)) {\r\n		showformheader(&quot;yiqixueba&amp;operation=mokuai&amp;submod=mokuaicode&amp;edittype=&quot;.$edittype.&quot;&amp;mokuaiid=&quot;.$mokuaiid);\r\n		showtableheader(‘mokuaicode‘);\r\n		showsubmit(‘submit‘);\r\n		showtablefooter();\r\n		showformfooter();\r\n	}else{\r\n	}\r\n?&gt;', '');
INSERT INTO `xueba_yiqixueba_server_mokuai_page` VALUES ('10', '1', 'mokuaiapi', 'getsiteupdate', '升级状态', '获取站长是否需要升级', '客户端得到站点是否需要升级', 'c2s', '', '0', '', '1367110246', '$out_data[\'update\'] = DB::result_first(&quot;SELECT updatezt FROM &quot;.DB::table(\'yiqixueba_server_site\').&quot; WHERE site_url=\'&quot;.$data[\'siteurl\'].&quot;\'&quot;);', '');
INSERT INTO `xueba_yiqixueba_server_mokuai_page` VALUES ('11', '1', 'mokuaiapi', 'getsiteinfo', '站点信息', '得到站点的站点信息', '', 'c2s', '', '0', '', '1367110479', '$out_data = DB::fetch_first(&quot;SELECT * FROM &quot;.DB::table(\'yiqixueba_server_site\').&quot; WHERE site_url = \'&quot;.$data[\'siteurl\'].&quot;\' and status = 1&quot;);', '');
INSERT INTO `xueba_yiqixueba_server_mokuai_page` VALUES ('12', '1', 'mokuaiapi', 'install', '安装插件', '站点安装', '', 'c2s', '', '0', '', '1367111028', 'if(DB::result_first(&quot;SELECT count(*) FROM &quot;.DB::table(\'yiqixueba_server_site\').&quot; WHERE site_url=\'&quot;.$data[\'siteurl\'].&quot;\'&quot;)==0){\r\n}', '');
INSERT INTO `xueba_yiqixueba_server_mokuai_page` VALUES ('13', '1', 'mokuaifabu', 'admincp', '后台主程序', '后台的控制器', '此文件是后台的控制程序', 'gen', '', '0', '', '1367116626', '', '');
INSERT INTO `xueba_yiqixueba_server_mokuai_page` VALUES ('14', '1', 'mokuaifabu', 'yiqixueba', '插件主程序', '插件钩子的控制器', '', 'gen', '', '0', '', '1367116730', '', '');
INSERT INTO `xueba_yiqixueba_server_mokuai_page` VALUES ('15', '1', 'mokuaifabu', 'install', '安装程序', '', '', 'gen', '', '0', '', '1367116808', '', '');
INSERT INTO `xueba_yiqixueba_server_mokuai_page` VALUES ('16', '1', 'mokuaifabu', 'api', 'API接口程序', '', '', 'gen', '', '0', '', '1367116886', '', '');
INSERT INTO `xueba_yiqixueba_server_mokuai_page` VALUES ('17', '1', 'mokuaiadmin', 'index', '平台首页', '平台的欢迎页面', '', '', '', '0', '', '1367118457', '', '');
INSERT INTO `xueba_yiqixueba_server_mokuai_page` VALUES ('18', '1', 'mokuaifunc', 'make_mokuai_xml', '生成XML', '用于生成XML文件', '', 'mokuaiid,pluginname', '', '0', '', '1367130533', 'global $_G;\r\nrequire_once libfile(\'class/xml\');\r\n$mokuai_info = DB::fetch_first(&quot;SELECT * FROM &quot;.DB::table(\'yiqixueba_server_mokuai\').&quot; WHERE mokuaiid=&quot;.$mokuaiid);\r\n\r\n$plugin_base_dir = DISCUZ_ROOT.\'source/plugin/yiqixueba_\'.$mokuai_info[\'mokuainame\'];\r\n$xml_file = $plugin_base_dir.\'/discuz_plugin_yiqixueba_\'.$mokuai_info[\'mokuainame\'].\'.xml\';\r\n$install_file = $plugin_base_dir.\'/install.php\';\r\n\r\nif(!file_exists($plugin_base_dir)){\r\n	mkdir($plugin_base_dir);\r\n}\r\n\r\n$pluginarray = $mokuaiarray = array();\r\n$mokuaiarray[\'available\'] = 1;\r\n$mokuaiarray[\'adminid\'] = 1;\r\n$mokuaiarray[\'name\'] = $mokuai_info[\'mokuaititle\'];\r\n$mokuaiarray[\'identifier\'] = \'yiqixueba_\'.$mokuai_info[\'mokuainame\'];\r\n$mokuaiarray[\'description\'] = $mokuai_info[\'description\'];\r\n$mokuaiarray[\'datatables\'] = \'\';\r\n$mokuaiarray[\'directory\'] = \'yiqixueba_\'.$mokuai_info[\'mokuainame\'].\'/\';\r\n$mokuaiarray[\'copyright\'] = \'17xue8.cn\';\r\n$mokuaiarray[\'version\'] = $mokuai_info[\'version\'];\r\n$pluginarray[\'plugin\'] = $mokuaiarray;\r\n$pluginarray[\'version\'] = strip_tags($_G[\'setting\'][\'version\']);\r\n$pluginarray[\'installfile\'] = \'install.php\';\r\n$root = array(\r\n	\'Title\' =&gt; \'Discuz! Plugin\',\r\n	\'Version\' =&gt; $_G[\'setting\'][\'version\'],\r\n	\'Time\' =&gt; dgmdate(TIMESTAMP, \'Y-m-d H:i\'),\r\n	\'From\' =&gt; $_G[\'setting\'][\'bbname\'].\' (\'.$_G[\'siteurl\'].\')\',\r\n	\'Data\' =&gt; exportarray($pluginarray, 1)\r\n);\r\n$plugin_export = array2xml($root, 1);\r\nfile_put_contents($xml_file,$plugin_export);\r\nif(file_exists($xml_file)){\r\n	return true;\r\n}else{\r\n	return false;\r\n}', '');
INSERT INTO `xueba_yiqixueba_server_mokuai_page` VALUES ('19', '8', 'mokuaiadmin', 'test', '测试', '测试一下', '', '', '', '0', '', '1371899011', '&lt;?php\r\n\r\nif(!defined(‘IN_DISCUZ‘) || !defined(‘IN_ADMINCP‘)) {\r\n	exit(‘Access Denied‘);\r\n}\r\n\r\n\r\n?&gt;', '');

-- ----------------------------
-- Table structure for `xueba_yiqixueba_server_project`
-- ----------------------------
DROP TABLE IF EXISTS `xueba_yiqixueba_server_project`;
CREATE TABLE `xueba_yiqixueba_server_project` (
  `projectid` smallint(6) unsigned NOT NULL auto_increment,
  `name` char(50) NOT NULL,
  `title` varchar(255) NOT NULL,
  `description` text NOT NULL,
  `projecttype` tinyint(1) NOT NULL,
  `typeid` smallint(6) NOT NULL,
  `directory` varchar(255) NOT NULL,
  `createuser` mediumint(11) NOT NULL,
  `createtime` int(10) unsigned NOT NULL,
  `open` tinyint(1) NOT NULL,
  PRIMARY KEY  (`projectid`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of xueba_yiqixueba_server_project
-- ----------------------------
INSERT INTO `xueba_yiqixueba_server_project` VALUES ('1', 'yiqixueba', '一起学吧', '', '0', '13', 'yiqixueba/', '2', '1366745255', '0');
INSERT INTO `xueba_yiqixueba_server_project` VALUES ('2', 'yiqixueba', '模版', '满', '1', '5', './template/xueba', '2', '1366746443', '0');

-- ----------------------------
-- Table structure for `xueba_yiqixueba_server_project_prem`
-- ----------------------------
DROP TABLE IF EXISTS `xueba_yiqixueba_server_project_prem`;
CREATE TABLE `xueba_yiqixueba_server_project_prem` (
  `premid` mediumint(11) unsigned NOT NULL auto_increment,
  `userid` mediumint(11) NOT NULL,
  `projectid` smallint(6) NOT NULL,
  PRIMARY KEY  (`premid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of xueba_yiqixueba_server_project_prem
-- ----------------------------

-- ----------------------------
-- Table structure for `xueba_yiqixueba_server_site`
-- ----------------------------
DROP TABLE IF EXISTS `xueba_yiqixueba_server_site`;
CREATE TABLE `xueba_yiqixueba_server_site` (
  `siteid` mediumint(8) unsigned NOT NULL auto_increment,
  `site_url` varchar(255) NOT NULL,
  `api_key` varchar(32) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `temp_key` varchar(32) NOT NULL,
  `salt` char(6) NOT NULL,
  `groupid` smallint(3) NOT NULL,
  `updatezt` tinyint(1) NOT NULL,
  `mokuais` text NOT NULL,
  `youxiaoqi` int(10) unsigned NOT NULL,
  `province` varchar(255) character set utf8 NOT NULL,
  `city` varchar(255) character set utf8 NOT NULL,
  `dist` varchar(255) character set utf8 NOT NULL,
  `community` varchar(255) character set utf8 NOT NULL,
  `credits` mediumint(11) NOT NULL,
  PRIMARY KEY  (`siteid`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of xueba_yiqixueba_server_site
-- ----------------------------
INSERT INTO `xueba_yiqixueba_server_site` VALUES ('1', 'http://debug.17xue8.cn/', '9d6afc2737beb9b7816680d62f53ea27', '1', '2e2336347152bd2e822aa9bbe4fdc3b9', 'ZqWT5r', '2', '1', 'a:7:{i:0;s:1:\"1\";i:1;s:1:\"2\";i:2;s:1:\"3\";i:3;s:1:\"4\";i:4;s:1:\"5\";i:5;s:1:\"6\";i:6;s:1:\"7\";}', '1419264000', '河北省', '石家庄市', '', '', '100');
INSERT INTO `xueba_yiqixueba_server_site` VALUES ('2', 'http://www.17xue8.cn/', 'a05b4e8d4e24e6b4c33793f9ed0d1e78', '1', '66996553defd7b089d826092b0a0b341', 'UCU3Q9', '2', '0', 'a:1:{i:0;s:1:\"1\";}', '1398700800', '', '', '', '', '0');
INSERT INTO `xueba_yiqixueba_server_site` VALUES ('3', 'http://www.cardelm.com', '2e491129139e248bfd05a783f0d6df1c', '1', '9a03e5d08e471f9198cc164fb45ce037', 'ozcPSA', '2', '0', 'a:2:{i:0;s:1:\"1\";i:1;s:1:\"2\";}', '1403452800', '河北省', '石家庄市', '', '', '0');

-- ----------------------------
-- Table structure for `xueba_yiqixueba_server_sitegroup`
-- ----------------------------
DROP TABLE IF EXISTS `xueba_yiqixueba_server_sitegroup`;
CREATE TABLE `xueba_yiqixueba_server_sitegroup` (
  `sitegroupid` smallint(3) unsigned NOT NULL auto_increment,
  `name` char(30) character set utf8 NOT NULL,
  `status` tinyint(1) NOT NULL,
  `mokuais` text NOT NULL,
  `youxiaoqi` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`sitegroupid`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of xueba_yiqixueba_server_sitegroup
-- ----------------------------
INSERT INTO `xueba_yiqixueba_server_sitegroup` VALUES ('1', '安装组', '1', 'a:1:{i:0;s:1:\"1\";}', '1398182400');
INSERT INTO `xueba_yiqixueba_server_sitegroup` VALUES ('2', '测试组', '1', 'a:5:{i:0;s:1:\"1\";i:1;s:1:\"2\";i:2;s:1:\"3\";i:3;s:1:\"4\";i:4;s:1:\"5\";}', '1398096000');
INSERT INTO `xueba_yiqixueba_server_sitegroup` VALUES ('3', '注册组', '1', 'a:1:{i:0;s:1:\"1\";}', '1398182400');

-- ----------------------------
-- Table structure for `xueba_yiqixueba_server_sync`
-- ----------------------------
DROP TABLE IF EXISTS `xueba_yiqixueba_server_sync`;
CREATE TABLE `xueba_yiqixueba_server_sync` (
  `syncid` mediumint(11) unsigned NOT NULL auto_increment,
  `synctype` smallint(6) NOT NULL,
  `author` mediumint(11) NOT NULL,
  `syncname` varchar(255) NOT NULL,
  `syncdescription` text NOT NULL,
  `mokuaiidid` mediumint(11) NOT NULL,
  `pagetype` varchar(50) NOT NULL,
  `filename` varchar(255) NOT NULL,
  `filesize` int(10) unsigned NOT NULL,
  `fileatime` int(10) unsigned NOT NULL,
  `syncconments` text NOT NULL,
  `synccode` text NOT NULL,
  PRIMARY KEY  (`syncid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;

-- ----------------------------
-- Records of xueba_yiqixueba_server_sync
-- ----------------------------
