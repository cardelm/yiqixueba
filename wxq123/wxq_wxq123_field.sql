/*
Navicat MySQL Data Transfer

Source Server         : wxq123
Source Server Version : 50045
Source Host           : 116.255.208.137:3306
Source Database       : wxq123

Target Server Type    : MYSQL
Target Server Version : 50045
File Encoding         : 65001

Date: 2013-07-30 16:16:38
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `wxq_wxq123_field`
-- ----------------------------
DROP TABLE IF EXISTS `wxq_wxq123_field`;
CREATE TABLE `wxq_wxq123_field` (
  `optionid` smallint(6) unsigned NOT NULL auto_increment,
  `classid` smallint(6) unsigned NOT NULL default '0',
  `displayorder` tinyint(3) NOT NULL default '0',
  `expiration` tinyint(1) NOT NULL,
  `protect` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL default '',
  `description` varchar(255) NOT NULL default '',
  `identifier` varchar(255) NOT NULL default '',
  `type` varchar(255) NOT NULL default '',
  `unit` varchar(255) NOT NULL,
  `rules` mediumtext NOT NULL,
  `permprompt` mediumtext NOT NULL,
  `system` tinyint(1) NOT NULL,
  `display` tinyint(1) NOT NULL,
  PRIMARY KEY  (`optionid`),
  KEY `classid` (`classid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

-- ----------------------------
-- Records of wxq_wxq123_field
-- ----------------------------

-- ----------------------------
-- Table structure for `wxq_wxq123_func`
-- ----------------------------
DROP TABLE IF EXISTS `wxq_wxq123_func`;
CREATE TABLE `wxq_wxq123_func` (
  `funcid` mediumint(8) unsigned NOT NULL auto_increment,
  `funcname` char(20) NOT NULL,
  `functitle` char(20) NOT NULL,
  `funckey` char(255) NOT NULL,
  `funcintype` char(10) NOT NULL,
  `funclevel` smallint(3) NOT NULL,
  `funcfwid` mediumint(8) NOT NULL,
  `funcdescription` text NOT NULL,
  `funcconents` text NOT NULL,
  `funcsetting` text NOT NULL,
  `outtype` tinyint(1) NOT NULL,
  `outcontent` text NOT NULL,
  `status` tinyint(4) NOT NULL,
  PRIMARY KEY  (`funcid`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=gbk;

-- ----------------------------
-- Records of wxq_wxq123_func
-- ----------------------------
INSERT INTO `wxq_wxq123_func` VALUES ('1', 'firstevent', '首次关注', 'subscribe', '', '0', '0', '首次关注时的回复内容', '', '', '0', '', '0');
INSERT INTO `wxq_wxq123_func` VALUES ('2', 'firstevent1', '首次关注（无号）', 'subscribe', '', '0', '0', '当一个用户，自己没有微信公共帐号，生成二维码的内容', '', '', '0', '', '0');

-- ----------------------------
-- Table structure for `wxq_wxq123_goods`
-- ----------------------------
DROP TABLE IF EXISTS `wxq_wxq123_goods`;
CREATE TABLE `wxq_wxq123_goods` (
  `goodsid` mediumint(8) unsigned NOT NULL auto_increment,
  PRIMARY KEY  (`goodsid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of wxq_wxq123_goods
-- ----------------------------

-- ----------------------------
-- Table structure for `wxq_wxq123_member`
-- ----------------------------
DROP TABLE IF EXISTS `wxq_wxq123_member`;
CREATE TABLE `wxq_wxq123_member` (
  `memberid` mediumint(8) unsigned NOT NULL auto_increment,
  `wid` varchar(50) NOT NULL,
  `uid` mediumint(8) unsigned NOT NULL,
  `wxqgroup` smallint(3) NOT NULL,
  `moblic` char(15) NOT NULL,
  `regtime` int(10) unsigned NOT NULL,
  `mokuai` text NOT NULL,
  `sitemanage` text NOT NULL,
  `siteuser` text NOT NULL,
  `shopmanage` text NOT NULL,
  `shopdianyuan` text NOT NULL,
  PRIMARY KEY  (`memberid`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=gbk;

-- ----------------------------
-- Records of wxq_wxq123_member
-- ----------------------------
INSERT INTO `wxq_wxq123_member` VALUES ('1', 'oJGqcjlfli2uWB8wiYRmZ8tiwlKQ', '0', '3', '', '1368330144', '', '', '', '', '');
INSERT INTO `wxq_wxq123_member` VALUES ('2', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', '0', '0', '', '1368284568', '', '', '', '', '');
INSERT INTO `wxq_wxq123_member` VALUES ('3', '', '1', '3', '', '0', '', '', 'a:1:{i:0;s:3:\"127\";}', 'a:1:{i:0;s:3:\"130\";}', '');

-- ----------------------------
-- Table structure for `wxq_wxq123_mokuai`
-- ----------------------------
DROP TABLE IF EXISTS `wxq_wxq123_mokuai`;
CREATE TABLE `wxq_wxq123_mokuai` (
  `mokuaiid` smallint(6) unsigned NOT NULL auto_increment,
  `mokuainame` char(40) character set gbk NOT NULL,
  `mokuaititle` char(40) character set gbk NOT NULL,
  `mokuaidescription` varchar(255) character set gbk NOT NULL,
  `mokuaiico` varchar(255) character set gbk NOT NULL,
  `mokuaipice` int(10) unsigned NOT NULL,
  `wxsearch` char(20) character set gbk NOT NULL,
  `urluser` tinyint(1) NOT NULL,
  `shopuser` tinyint(1) NOT NULL,
  `goodsclass` varchar(255) character set gbk NOT NULL,
  `displayorder` smallint(6) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `category` text character set gbk,
  PRIMARY KEY  (`mokuaiid`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of wxq_wxq123_mokuai
-- ----------------------------
INSERT INTO `wxq_wxq123_mokuai` VALUES ('1', 'groupbuy', '微团购', '微团购的简单描述', '132205y136b1apb7ppa65p.jpg', '500', 'wg', '1', '1', '', '1', '1', 'a:2:{i:0;s:5:\"美食\r\";i:1;s:4:\"娱乐\";}');
INSERT INTO `wxq_wxq123_mokuai` VALUES ('9', 'weishop', '微生活', '目前所能想到的有微考试、微建材', '', '200', 'ws', '0', '0', '', '9', '1', '');
INSERT INTO `wxq_wxq123_mokuai` VALUES ('5', 'yingyuan', '微影院', '微电影的简单描述', '132236a344opr64h0gophg.jpg', '500', 'wy', '0', '1', 'a:3:{i:0;s:5:\"影讯\r\";i:1;s:5:\"影院\r\";i:2;s:4:\"场次\";}', '2', '1', '');
INSERT INTO `wxq_wxq123_mokuai` VALUES ('6', 'weifangchan', '微房产', '出租、整租、出售、新房、二手', '132308d8bg1dy10b183ggx.jpg', '1200', 'wf', '0', '0', '', '3', '1', '');
INSERT INTO `wxq_wxq123_mokuai` VALUES ('7', 'weizhaopin', '微招聘', '招聘', '132334jkxqvj1qv55eqqb8.jpg', '700', 'wz', '0', '0', '', '4', '1', '');
INSERT INTO `wxq_wxq123_mokuai` VALUES ('8', 'weiqiche', '微汽车', '新车、二手车', '132400hak3zf57kzwkka33.jpg', '2000', 'wq', '0', '0', '', '5', '1', '');
INSERT INTO `wxq_wxq123_mokuai` VALUES ('10', 'weikuaican', '微美食', '外卖、宅急送、快餐、美食等', '', '300', 'wk', '0', '0', '', '6', '1', '');
INSERT INTO `wxq_wxq123_mokuai` VALUES ('11', 'weiyouhuiquan', '微优惠', '优惠券、促销、电子卡', '', '500', 'wh', '0', '0', '', '7', '1', '');
INSERT INTO `wxq_wxq123_mokuai` VALUES ('12', 'weidongman', '微动漫', '漫画、动漫等', '', '300', 'wd', '0', '0', '', '10', '1', '');
INSERT INTO `wxq_wxq123_mokuai` VALUES ('13', 'daohang', '微导航', '站点二维码导航类网站用', '', '300', '', '1', '0', '', '0', '1', '');
INSERT INTO `wxq_wxq123_mokuai` VALUES ('14', 'huiyuanka', '会员卡', '会员卡', '', '500', '', '0', '0', '', '0', '0', '');
INSERT INTO `wxq_wxq123_mokuai` VALUES ('15', 'yikatong', '一卡通', '', '', '1500', '', '0', '0', '', '0', '0', '');

-- ----------------------------
-- Table structure for `wxq_wxq123_mokuaioption`
-- ----------------------------
DROP TABLE IF EXISTS `wxq_wxq123_mokuaioption`;
CREATE TABLE `wxq_wxq123_mokuaioption` (
  `moid` mediumint(8) unsigned NOT NULL auto_increment,
  `mokuaiid` smallint(6) NOT NULL,
  `optionid` smallint(6) NOT NULL,
  `displayorder` tinyint(3) NOT NULL,
  `available` tinyint(1) NOT NULL,
  `required` tinyint(1) NOT NULL,
  `unchangeable` tinyint(1) NOT NULL,
  `formsearch` tinyint(1) NOT NULL,
  `fontsearch` tinyint(1) NOT NULL,
  `show` tinyint(1) NOT NULL,
  `system` tinyint(1) NOT NULL,
  `hide` tinyint(1) NOT NULL,
  PRIMARY KEY  (`moid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

-- ----------------------------
-- Records of wxq_wxq123_mokuaioption
-- ----------------------------

-- ----------------------------
-- Table structure for `wxq_wxq123_pages`
-- ----------------------------
DROP TABLE IF EXISTS `wxq_wxq123_pages`;
CREATE TABLE `wxq_wxq123_pages` (
  `pageid` mediumint(8) unsigned NOT NULL auto_increment,
  `pageclass` smallint(3) NOT NULL,
  `mokuai` smallint(3) NOT NULL,
  `weizhi` smallint(3) NOT NULL,
  `wid` mediumint(8) NOT NULL,
  `usertype` smallint(3) NOT NULL,
  `userid` mediumint(8) NOT NULL,
  `rule` text NOT NULL,
  `stauts` tinyint(1) NOT NULL,
  PRIMARY KEY  (`pageid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of wxq_wxq123_pages
-- ----------------------------

-- ----------------------------
-- Table structure for `wxq_wxq123_server_company`
-- ----------------------------
DROP TABLE IF EXISTS `wxq_wxq123_server_company`;
CREATE TABLE `wxq_wxq123_server_company` (
  `wxid` char(15) character set gbk NOT NULL,
  `shibiema` char(6) character set gbk NOT NULL,
  `token` char(8) character set gbk NOT NULL,
  `sitesbm` char(4) character set gbk NOT NULL,
  `comyid` mediumint(8) NOT NULL,
  `regtime` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`wxid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of wxq_wxq123_server_company
-- ----------------------------

-- ----------------------------
-- Table structure for `wxq_wxq123_server_log`
-- ----------------------------
DROP TABLE IF EXISTS `wxq_wxq123_server_log`;
CREATE TABLE `wxq_wxq123_server_log` (
  `shibiema` char(8) character set gbk NOT NULL,
  `wxid` char(32) character set gbk NOT NULL,
  `wxuser` char(32) character set gbk NOT NULL,
  `inputtype` tinyint(1) NOT NULL,
  `time` int(10) unsigned NOT NULL,
  `content` varchar(255) character set gbk NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of wxq_wxq123_server_log
-- ----------------------------

-- ----------------------------
-- Table structure for `wxq_wxq123_server_member`
-- ----------------------------
DROP TABLE IF EXISTS `wxq_wxq123_server_member`;
CREATE TABLE `wxq_wxq123_server_member` (
  `wxid` char(32) character set gbk NOT NULL,
  `shibiema` char(7) character set gbk NOT NULL,
  `siteid` mediumint(8) NOT NULL,
  `siteuid` mediumint(8) NOT NULL,
  `regtime` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`wxid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of wxq_wxq123_server_member
-- ----------------------------

-- ----------------------------
-- Table structure for `wxq_wxq123_server_mokuai`
-- ----------------------------
DROP TABLE IF EXISTS `wxq_wxq123_server_mokuai`;
CREATE TABLE `wxq_wxq123_server_mokuai` (
  `mokuaiid` mediumint(6) unsigned NOT NULL auto_increment,
  `groupid` smallint(6) unsigned NOT NULL,
  `versionname` char(40) character set gbk NOT NULL,
  `mokuaidescription` varchar(255) character set gbk NOT NULL,
  `mokuaiico` varchar(255) character set gbk NOT NULL,
  `mokuaipice` int(10) unsigned NOT NULL,
  `displayorder` smallint(6) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `category` text character set gbk,
  PRIMARY KEY  (`mokuaiid`)
) ENGINE=MyISAM AUTO_INCREMENT=36 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of wxq_wxq123_server_mokuai
-- ----------------------------
INSERT INTO `wxq_wxq123_server_mokuai` VALUES ('35', '19', 'V1.0', '', '', '1500', '0', '0', null);
INSERT INTO `wxq_wxq123_server_mokuai` VALUES ('28', '16', 'V1.0', '团购的微信功能', '', '500', '2', '0', '');
INSERT INTO `wxq_wxq123_server_mokuai` VALUES ('34', '18', 'V1.0', '', '', '100', '0', '0', null);

-- ----------------------------
-- Table structure for `wxq_wxq123_server_mokuai_group`
-- ----------------------------
DROP TABLE IF EXISTS `wxq_wxq123_server_mokuai_group`;
CREATE TABLE `wxq_wxq123_server_mokuai_group` (
  `groupid` smallint(6) unsigned NOT NULL auto_increment,
  `mokuainame` char(40) character set gbk NOT NULL,
  `mokuaititle` char(40) character set gbk NOT NULL,
  `displayorder` smallint(6) NOT NULL,
  `mokuaiico` varchar(255) character set gbk NOT NULL,
  PRIMARY KEY  (`groupid`)
) ENGINE=MyISAM AUTO_INCREMENT=20 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of wxq_wxq123_server_mokuai_group
-- ----------------------------
INSERT INTO `wxq_wxq123_server_mokuai_group` VALUES ('16', 'groupbuy', '微团购', '2', '');
INSERT INTO `wxq_wxq123_server_mokuai_group` VALUES ('18', 'zhaopin', '微招聘', '0', '');
INSERT INTO `wxq_wxq123_server_mokuai_group` VALUES ('19', 'yikatong', '一卡通', '1', '');

-- ----------------------------
-- Table structure for `wxq_wxq123_server_mokuai_page`
-- ----------------------------
DROP TABLE IF EXISTS `wxq_wxq123_server_mokuai_page`;
CREATE TABLE `wxq_wxq123_server_mokuai_page` (
  `pageid` mediumint(8) NOT NULL,
  `mokuaiid` mediumint(8) NOT NULL,
  `filename` char(20) NOT NULL,
  `menu` char(20) NOT NULL,
  `type` tinyint(1) NOT NULL,
  `description` text character set gbk NOT NULL,
  `status` tinyint(1) NOT NULL,
  `displayorder` mediumint(8) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of wxq_wxq123_server_mokuai_page
-- ----------------------------

-- ----------------------------
-- Table structure for `wxq_wxq123_server_setting`
-- ----------------------------
DROP TABLE IF EXISTS `wxq_wxq123_server_setting`;
CREATE TABLE `wxq_wxq123_server_setting` (
  `skey` varchar(255) character set gbk NOT NULL,
  `svalue` text character set gbk NOT NULL,
  PRIMARY KEY  (`skey`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of wxq_wxq123_server_setting
-- ----------------------------

-- ----------------------------
-- Table structure for `wxq_wxq123_server_site`
-- ----------------------------
DROP TABLE IF EXISTS `wxq_wxq123_server_site`;
CREATE TABLE `wxq_wxq123_server_site` (
  `siteid` mediumint(8) unsigned NOT NULL auto_increment,
  `siteurl` char(100) character set gbk NOT NULL,
  `searchurl` char(100) character set gbk NOT NULL,
  `charset` char(20) character set gbk NOT NULL,
  `clientip` char(15) character set gbk NOT NULL,
  `sitekey` char(32) character set gbk NOT NULL,
  `salt` char(6) character set gbk NOT NULL,
  `installtime` int(10) unsigned NOT NULL,
  `updatetime` int(10) unsigned NOT NULL,
  `tijiaotime` int(10) unsigned NOT NULL,
  `status` tinyint(1) NOT NULL,
  `wxid` char(15) character set gbk NOT NULL,
  `shibiema` char(4) character set gbk NOT NULL,
  `token` char(6) character set gbk NOT NULL,
  `prov` char(20) character set gbk NOT NULL,
  `city` char(20) character set gbk NOT NULL,
  `dist` char(20) character set gbk NOT NULL,
  `groupexpiry` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`siteid`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of wxq_wxq123_server_site
-- ----------------------------
INSERT INTO `wxq_wxq123_server_site` VALUES ('8', 'http://www.wxq123.com/', 'wxq123.com/', 'gbk', '118.186.165.27', '76993849ffe48378157fae7e454f4ca7', 'E0P253', '1369277028', '1369463545', '1369417644', '0', '', '0502', 'cIC3N0', '河北省', '石家庄市', '', '1398182400');
INSERT INTO `wxq_wxq123_server_site` VALUES ('7', 'http://www.cardelm.com/', 'cardelm.com/', 'gbk', '124.236.192.64', 'a34f38f785a20c7740d6fe056a217c33', 'Y0rxpz', '1369275268', '1369553171', '0', '0', '', '2685', 'KsuuPD', '河北省', '石家庄市', '平山县', '0');
INSERT INTO `wxq_wxq123_server_site` VALUES ('9', 'http://localhost/cardelm/', 'localhost/cardelm/', 'gbk', '127.0.0.1', 'bda8148e225cf37abb93841e0652bd52', 'PfWUOp', '1369403485', '1369403485', '0', '0', '', '6165', 'nU82gt', '', '', '', '0');

-- ----------------------------
-- Table structure for `wxq_wxq123_server_site_mokuai`
-- ----------------------------
DROP TABLE IF EXISTS `wxq_wxq123_server_site_mokuai`;
CREATE TABLE `wxq_wxq123_server_site_mokuai` (
  `smid` mediumint(8) NOT NULL,
  `mokuaiid` smallint(3) NOT NULL,
  `siteid` mediumint(8) NOT NULL,
  `smkey` char(32) character set gbk NOT NULL,
  `salt` char(6) character set gbk NOT NULL,
  `validity` int(10) unsigned NOT NULL,
  `sitesetting` text character set gbk
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of wxq_wxq123_server_site_mokuai
-- ----------------------------
INSERT INTO `wxq_wxq123_server_site_mokuai` VALUES ('0', '5', '8', '', '', '0', null);
INSERT INTO `wxq_wxq123_server_site_mokuai` VALUES ('0', '13', '8', '', '', '0', null);
INSERT INTO `wxq_wxq123_server_site_mokuai` VALUES ('0', '7', '8', '', '', '0', null);
INSERT INTO `wxq_wxq123_server_site_mokuai` VALUES ('0', '1', '8', '', '', '0', null);
INSERT INTO `wxq_wxq123_server_site_mokuai` VALUES ('0', '13', '7', '', '', '0', null);
INSERT INTO `wxq_wxq123_server_site_mokuai` VALUES ('0', '5', '7', '', '', '0', null);
INSERT INTO `wxq_wxq123_server_site_mokuai` VALUES ('0', '1', '7', '', '', '0', null);
INSERT INTO `wxq_wxq123_server_site_mokuai` VALUES ('0', '6', '7', '', '', '0', null);
INSERT INTO `wxq_wxq123_server_site_mokuai` VALUES ('0', '7', '7', '', '', '0', null);
INSERT INTO `wxq_wxq123_server_site_mokuai` VALUES ('0', '6', '8', '', '', '0', null);
INSERT INTO `wxq_wxq123_server_site_mokuai` VALUES ('0', '11', '8', '', '', '0', null);
INSERT INTO `wxq_wxq123_server_site_mokuai` VALUES ('0', '9', '8', '', '', '0', null);
INSERT INTO `wxq_wxq123_server_site_mokuai` VALUES ('0', '12', '8', '', '', '0', null);

-- ----------------------------
-- Table structure for `wxq_wxq123_setting`
-- ----------------------------
DROP TABLE IF EXISTS `wxq_wxq123_setting`;
CREATE TABLE `wxq_wxq123_setting` (
  `skey` varchar(255) NOT NULL,
  `svalue` text NOT NULL,
  PRIMARY KEY  (`skey`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of wxq_wxq123_setting
-- ----------------------------
INSERT INTO `wxq_wxq123_setting` VALUES ('sitekey', '76993849ffe48378157fae7e454f4ca7');
INSERT INTO `wxq_wxq123_setting` VALUES ('shibiema', '0502');
INSERT INTO `wxq_wxq123_setting` VALUES ('token', 'cIC3N0');

-- ----------------------------
-- Table structure for `wxq_wxq123_shibiema`
-- ----------------------------
DROP TABLE IF EXISTS `wxq_wxq123_shibiema`;
CREATE TABLE `wxq_wxq123_shibiema` (
  `shibiema` char(8) character set gbk NOT NULL,
  `siteid` mediumint(8) NOT NULL,
  `usertype` char(20) character set gbk NOT NULL,
  `memberid` mediumint(8) NOT NULL,
  `token` char(32) character set gbk NOT NULL,
  `weixinhao` char(32) character set gbk NOT NULL,
  PRIMARY KEY  (`shibiema`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of wxq_wxq123_shibiema
-- ----------------------------
INSERT INTO `wxq_wxq123_shibiema` VALUES ('48628592', '2', 'site', '0', 'www', '');
INSERT INTO `wxq_wxq123_shibiema` VALUES ('06661262', '6', 'site', '0', '', '');

-- ----------------------------
-- Table structure for `wxq_wxq123_shop`
-- ----------------------------
DROP TABLE IF EXISTS `wxq_wxq123_shop`;
CREATE TABLE `wxq_wxq123_shop` (
  `shopid` mediumint(8) unsigned NOT NULL auto_increment,
  `uids` text NOT NULL,
  `manageuids` text NOT NULL,
  `shopname` varchar(255) NOT NULL,
  `shopshortname` varchar(20) NOT NULL,
  `shoplogo` varchar(255) NOT NULL,
  `shopphone` varchar(15) NOT NULL,
  `shopaddress` varchar(255) NOT NULL,
  `shopmokuais` text NOT NULL,
  `shoplianxiren` char(40) NOT NULL,
  `shopbaidu` varchar(255) NOT NULL,
  `groupexpiry` int(10) unsigned NOT NULL,
  `stauts` tinyint(1) NOT NULL,
  `token` char(32) NOT NULL,
  `weixinhao` char(32) NOT NULL,
  `weixinpass` char(32) NOT NULL,
  `weixinimage` varchar(255) NOT NULL,
  `shopmember` text NOT NULL,
  `m_groupbuy` tinyint(1) NOT NULL,
  `m_yingyuan` tinyint(1) NOT NULL,
  `shopweixinhao` char(40) NOT NULL,
  `shopweixinpass` char(40) NOT NULL,
  PRIMARY KEY  (`shopid`)
) ENGINE=MyISAM AUTO_INCREMENT=131 DEFAULT CHARSET=gbk;

-- ----------------------------
-- Records of wxq_wxq123_shop
-- ----------------------------
INSERT INTO `wxq_wxq123_shop` VALUES ('130', '', '', 'ceshi', 'ceshi', '', '', '', '', '', 'a:2:{s:1:\"x\";s:10:\"116.331398\";s:1:\"y\";s:9:\"39.897445\";}', '1400515200', '1', 'p8vOvZ', '', '', '', 'a:2:{s:10:\"shopmanage\";a:1:{i:0;s:6:\"wxq123\";}s:12:\"shopdianyuan\";s:0:\"\";}', '1', '0', '', '');

-- ----------------------------
-- Table structure for `wxq_wxq123_shop_count`
-- ----------------------------
DROP TABLE IF EXISTS `wxq_wxq123_shop_count`;
CREATE TABLE `wxq_wxq123_shop_count` (
  `pmid` mediumint(8) unsigned NOT NULL auto_increment,
  `weizhiid` smallint(6) NOT NULL,
  `mokuaiid` smallint(6) NOT NULL,
  `shopid` mediumint(8) NOT NULL,
  `jingjiazhi` int(10) NOT NULL,
  PRIMARY KEY  (`pmid`)
) ENGINE=MyISAM AUTO_INCREMENT=61 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of wxq_wxq123_shop_count
-- ----------------------------
INSERT INTO `wxq_wxq123_shop_count` VALUES ('1', '0', '1', '3', '0');
INSERT INTO `wxq_wxq123_shop_count` VALUES ('2', '0', '5', '3', '0');
INSERT INTO `wxq_wxq123_shop_count` VALUES ('3', '0', '6', '3', '0');
INSERT INTO `wxq_wxq123_shop_count` VALUES ('4', '0', '7', '3', '0');
INSERT INTO `wxq_wxq123_shop_count` VALUES ('5', '0', '8', '3', '0');
INSERT INTO `wxq_wxq123_shop_count` VALUES ('6', '0', '1', '1', '0');
INSERT INTO `wxq_wxq123_shop_count` VALUES ('7', '0', '1', '4', '0');
INSERT INTO `wxq_wxq123_shop_count` VALUES ('8', '0', '1', '2', '0');
INSERT INTO `wxq_wxq123_shop_count` VALUES ('9', '0', '5', '2', '0');
INSERT INTO `wxq_wxq123_shop_count` VALUES ('10', '0', '6', '2', '0');
INSERT INTO `wxq_wxq123_shop_count` VALUES ('11', '0', '7', '2', '0');
INSERT INTO `wxq_wxq123_shop_count` VALUES ('12', '0', '8', '2', '0');
INSERT INTO `wxq_wxq123_shop_count` VALUES ('20', '0', '1', '44', '0');
INSERT INTO `wxq_wxq123_shop_count` VALUES ('19', '0', '1', '15', '0');
INSERT INTO `wxq_wxq123_shop_count` VALUES ('18', '0', '1', '22', '0');
INSERT INTO `wxq_wxq123_shop_count` VALUES ('17', '0', '1', '9', '0');
INSERT INTO `wxq_wxq123_shop_count` VALUES ('21', '0', '1', '43', '0');
INSERT INTO `wxq_wxq123_shop_count` VALUES ('22', '0', '1', '42', '0');
INSERT INTO `wxq_wxq123_shop_count` VALUES ('23', '0', '1', '41', '0');
INSERT INTO `wxq_wxq123_shop_count` VALUES ('24', '0', '1', '40', '0');
INSERT INTO `wxq_wxq123_shop_count` VALUES ('25', '0', '1', '39', '0');
INSERT INTO `wxq_wxq123_shop_count` VALUES ('26', '0', '1', '38', '0');
INSERT INTO `wxq_wxq123_shop_count` VALUES ('27', '0', '1', '37', '0');
INSERT INTO `wxq_wxq123_shop_count` VALUES ('28', '0', '1', '36', '0');
INSERT INTO `wxq_wxq123_shop_count` VALUES ('29', '0', '1', '35', '0');
INSERT INTO `wxq_wxq123_shop_count` VALUES ('30', '0', '1', '34', '0');
INSERT INTO `wxq_wxq123_shop_count` VALUES ('31', '0', '1', '33', '0');
INSERT INTO `wxq_wxq123_shop_count` VALUES ('32', '0', '1', '32', '0');
INSERT INTO `wxq_wxq123_shop_count` VALUES ('33', '0', '1', '31', '0');
INSERT INTO `wxq_wxq123_shop_count` VALUES ('34', '0', '1', '30', '0');
INSERT INTO `wxq_wxq123_shop_count` VALUES ('35', '0', '1', '29', '0');
INSERT INTO `wxq_wxq123_shop_count` VALUES ('36', '0', '1', '28', '0');
INSERT INTO `wxq_wxq123_shop_count` VALUES ('37', '0', '1', '27', '0');
INSERT INTO `wxq_wxq123_shop_count` VALUES ('38', '0', '1', '26', '0');
INSERT INTO `wxq_wxq123_shop_count` VALUES ('39', '0', '1', '25', '0');
INSERT INTO `wxq_wxq123_shop_count` VALUES ('40', '0', '1', '24', '0');
INSERT INTO `wxq_wxq123_shop_count` VALUES ('41', '0', '1', '23', '0');
INSERT INTO `wxq_wxq123_shop_count` VALUES ('42', '0', '1', '21', '0');
INSERT INTO `wxq_wxq123_shop_count` VALUES ('43', '0', '1', '20', '0');
INSERT INTO `wxq_wxq123_shop_count` VALUES ('44', '0', '1', '19', '0');
INSERT INTO `wxq_wxq123_shop_count` VALUES ('45', '0', '1', '18', '0');
INSERT INTO `wxq_wxq123_shop_count` VALUES ('46', '0', '1', '17', '0');
INSERT INTO `wxq_wxq123_shop_count` VALUES ('47', '0', '1', '16', '0');
INSERT INTO `wxq_wxq123_shop_count` VALUES ('48', '0', '1', '14', '0');
INSERT INTO `wxq_wxq123_shop_count` VALUES ('49', '0', '1', '13', '0');
INSERT INTO `wxq_wxq123_shop_count` VALUES ('50', '0', '1', '12', '0');
INSERT INTO `wxq_wxq123_shop_count` VALUES ('51', '0', '1', '11', '0');
INSERT INTO `wxq_wxq123_shop_count` VALUES ('52', '0', '1', '10', '0');
INSERT INTO `wxq_wxq123_shop_count` VALUES ('53', '0', '1', '8', '0');
INSERT INTO `wxq_wxq123_shop_count` VALUES ('54', '0', '1', '7', '0');
INSERT INTO `wxq_wxq123_shop_count` VALUES ('55', '0', '1', '6', '0');
INSERT INTO `wxq_wxq123_shop_count` VALUES ('56', '0', '1', '5', '0');
INSERT INTO `wxq_wxq123_shop_count` VALUES ('57', '0', '5', '1', '0');
INSERT INTO `wxq_wxq123_shop_count` VALUES ('58', '0', '6', '1', '0');
INSERT INTO `wxq_wxq123_shop_count` VALUES ('59', '0', '7', '1', '0');
INSERT INTO `wxq_wxq123_shop_count` VALUES ('60', '0', '8', '1', '0');

-- ----------------------------
-- Table structure for `wxq_wxq123_shop_member`
-- ----------------------------
DROP TABLE IF EXISTS `wxq_wxq123_shop_member`;
CREATE TABLE `wxq_wxq123_shop_member` (
  `smid` mediumint(8) unsigned NOT NULL auto_increment,
  `uid` mediumint(8) NOT NULL,
  `shopids` text character set gbk NOT NULL,
  `manageshopids` text character set gbk NOT NULL,
  PRIMARY KEY  (`smid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of wxq_wxq123_shop_member
-- ----------------------------

-- ----------------------------
-- Table structure for `wxq_wxq123_site`
-- ----------------------------
DROP TABLE IF EXISTS `wxq_wxq123_site`;
CREATE TABLE `wxq_wxq123_site` (
  `siteid` mediumint(8) unsigned NOT NULL auto_increment,
  `sitename` char(100) character set gbk NOT NULL,
  `siteshortname` char(40) character set gbk NOT NULL,
  `sitelogo` char(40) character set gbk NOT NULL,
  `sitemember` text NOT NULL,
  `shibiecode` char(6) character set gbk NOT NULL,
  `siteurl` char(100) NOT NULL,
  `sitephone` char(40) character set gbk NOT NULL,
  `siteaddress` char(100) character set gbk NOT NULL,
  `sitelianxiren` char(20) character set gbk NOT NULL,
  `groupexpiry` int(10) unsigned NOT NULL,
  `m_groupbuy` tinyint(1) NOT NULL,
  `token` char(6) character set gbk NOT NULL,
  `weixinimage` char(20) character set gbk NOT NULL,
  `siteweixinhao` char(20) character set gbk NOT NULL,
  `siteweixinpass` char(32) character set gbk NOT NULL,
  `stauts` tinyint(1) NOT NULL,
  `displayorder` mediumint(8) NOT NULL,
  `m_daohang` tinyint(1) NOT NULL,
  PRIMARY KEY  (`siteid`)
) ENGINE=MyISAM AUTO_INCREMENT=128 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of wxq_wxq123_site
-- ----------------------------
INSERT INTO `wxq_wxq123_site` VALUES ('1', '美团网', '美团网', '', '', 't77qtu', '', '', '', '', '1400256000', '1', 'j2XznJ', '', '', '', '1', '0', '0');
INSERT INTO `wxq_wxq123_site` VALUES ('2', '糯米网', '糯米网', '', '', 'e8S2Rm', '', '', '', '', '1400256000', '1', '', '', '', '', '1', '0', '0');
INSERT INTO `wxq_wxq123_site` VALUES ('3', '窝窝团', '窝窝团', '', '', 'D66gsR', '', '', '', '', '1400256000', '1', '', '', '', '', '1', '0', '0');
INSERT INTO `wxq_wxq123_site` VALUES ('4', '高朋团购', '高朋团购', '', '', 'L116rJ', '', '', '', '', '1400256000', '1', '', '', '', '', '1', '0', '0');
INSERT INTO `wxq_wxq123_site` VALUES ('5', '大众点评', '大众点评', '', '', 'k6aI0I', '', '', '', '', '1400256000', '1', '', '', '', '', '1', '0', '0');
INSERT INTO `wxq_wxq123_site` VALUES ('6', 'QQ团购', 'QQ团购', '', '', 'IzHzqh', '', '', '', '', '1400256000', '1', '', '', '', '', '1', '0', '0');
INSERT INTO `wxq_wxq123_site` VALUES ('7', '拉手网', '拉手网', '', '', 'M854S1', '', '', '', '', '1400256000', '1', '', '', '', '', '1', '0', '0');
INSERT INTO `wxq_wxq123_site` VALUES ('8', '58团购', '58团购', 'cf/161920ex0kpcjr11f1zm5c.gif', '', 'Oc6ccT', 'http://t.58.com/sjz/', '', '', '', '1400256000', '1', 'mKPCBo', '', '', '', '1', '0', '0');
INSERT INTO `wxq_wxq123_site` VALUES ('9', '嘀嗒团', '嘀嗒团', '', '', 'tIKRyE', 'http://shijiazhuang.didatuan.com/', '', '', '', '1400256000', '1', 'bF3GGs', '', '', '', '1', '0', '0');
INSERT INTO `wxq_wxq123_site` VALUES ('10', '去哪儿网', '去哪儿网', '', '', 'FSNNSB', 'http://tuan.qunar.com/', '', '', '', '1400256000', '1', 'k09j2Y', '', '', '', '1', '0', '0');
INSERT INTO `wxq_wxq123_site` VALUES ('11', '团购王', '团购王', 'cf/162240fqh28j0wp2uprii1.jpg', '', 'cJjZ1w', 'http://www.go.cn/', '', '', '', '1400256000', '1', 'ewWdd9', '', '', '', '1', '0', '0');
INSERT INTO `wxq_wxq123_site` VALUES ('12', '聚齐网', '聚齐网', 'cf/162142emszn9nfswmw9hvl.png', '', 'Zp5SJD', 'http://www.juqi.com/shijiazhuang/', '', '', '', '1400256000', '1', 'JgfZ7f', '', '', '', '1', '0', '0');
INSERT INTO `wxq_wxq123_site` VALUES ('13', '聚美优品', '聚美优品', 'cf/164900n93ntv4d4symsj8m.jpg', '', 'ZDDmAc', 'http://bj.jumei.com/', '', '', '', '1400256000', '1', 'T0gSj9', '', '', '', '1', '0', '0');
INSERT INTO `wxq_wxq123_site` VALUES ('14', '万众团', '万众团', 'cf/162447rraf7utpoudosadd.png', '', 'BiI3V1', 'http://www.wanzhongtuan.com/', '', '', '', '1400256000', '1', 'uCWE9s', '', '', '', '1', '0', '0');
INSERT INTO `wxq_wxq123_site` VALUES ('15', '品质团', '品质团', 'cf/162027r2r8m5y5ygzjpr72.gif', '', 'GKK88f', 'http://shijiazhuang.pztuan.com/', '', '', '', '1400256000', '1', 'G65Vd5', '', '', '', '1', '0', '0');
INSERT INTO `wxq_wxq123_site` VALUES ('16', '猛买网', '猛买网', '', '', 'aOCJq3', 'http://www.mengmai.com/', '400-6705-365', '', '', '1400256000', '1', 'NRi0OS', '', '', '', '1', '0', '0');
INSERT INTO `wxq_wxq123_site` VALUES ('17', '热度团', '热度团', '', '', 'Jy5zbu', 'http://www.redutuan.com/shijiazhuang', '', '', '', '1400256000', '1', 'IoO8LL', '', '', '', '1', '0', '0');
INSERT INTO `wxq_wxq123_site` VALUES ('18', '亲亲网', '亲亲网', 'cf/163955gq62qqky7z6j4d0b.gif', '', 'C4ttBX', 'http://www.qinqin.net/', '4000-500-775', '', '', '1400256000', '1', 'IuexVn', '', '', '', '1', '0', '0');
INSERT INTO `wxq_wxq123_site` VALUES ('19', '260团', '260团', '', '', 'EI3Lv2', 'http://www.260tuan.com/index.aspx', '4000-123-107', '', '', '1400256000', '1', 'PdG56m', '', '', '', '1', '0', '0');
INSERT INTO `wxq_wxq123_site` VALUES ('20', '麦兜团', '麦兜团', 'cf/160911ltz4f7bfzfamb3tm.png', '', 'XAASB5', 'http://shijiazhuang.maidoutuan.com/', '4006-516-520', '', '', '1400256000', '1', 'HmbUhb', '', '', '', '1', '0', '0');
INSERT INTO `wxq_wxq123_site` VALUES ('21', '红绣团', '红绣团', 'cf/161354kt8olz3o3owxk8ox.png', '', 'Dh4QOT', 'http://www.hongxiutuan.net/', '010-51656597', '', '', '1400256000', '1', 'Khiar8', '', '', '', '1', '0', '0');
INSERT INTO `wxq_wxq123_site` VALUES ('22', '爱丽团', '爱丽团', 'cf/164525hkv3zv4phhphi3xd.gif', '', 'PzxpJ7', 'http://tuan.27.cn/shijiazhuang', '400-000-2727   010-58103818', '', '', '1400256000', '1', 'IuflC9', '', '', '', '1', '0', '0');
INSERT INTO `wxq_wxq123_site` VALUES ('23', '绿野团', '绿野团', 'cf/155901b4c2orrlzip2r5ip.png', '', 'D92tez', 'http://www.lvye.com/shijiazhuang/', '', '', '', '1400256000', '1', 'zLttWP', '', '', '', '1', '0', '0');
INSERT INTO `wxq_wxq123_site` VALUES ('24', '优优团', '优优团', 'cf/160115tcxkeeztvoyutua6.gif', '', 'W3z9ti', 'http://www.51uutuan.com/shijiazhuang', '4000-1234-30', '', '', '1400256000', '1', 'Hw2vpp', '', '', '', '1', '0', '0');
INSERT INTO `wxq_wxq123_site` VALUES ('25', '一起呀', '一起呀', '', '', 'OX75xn', 'http://www.17ya.com/', '', '', '', '1400256000', '1', 'rI4BEC', '', '', '', '1', '0', '0');
INSERT INTO `wxq_wxq123_site` VALUES ('26', '阿窝团', '阿窝团', '', '', 'v7RZdQ', 'http://www.awotuan.com/', '18989481463   400-005-1617', '', '', '1400256000', '1', 'DaQDbG', '', '', '', '1', '0', '0');
INSERT INTO `wxq_wxq123_site` VALUES ('27', '维客尚品', '维客尚品', '', '', 'JL309V', 'http://www.wkol.cn/', '400-808-6768', '', '', '1400256000', '1', 'WINGln', '', '', '', '1', '0', '0');
INSERT INTO `wxq_wxq123_site` VALUES ('28', '团委会', '团委会', 'cf/154851nuuu11wcww31arnc.png', '', 'BWCi7J', 'http://shijiazhuang.tuanweihui.com/', '', '', '', '1400256000', '1', 'J111CM', '', '', '', '1', '0', '0');
INSERT INTO `wxq_wxq123_site` VALUES ('29', '犀利团', '犀利团', '', '', 'Q7NCj6', '', '', '', '', '1400256000', '1', '', '', '', '', '1', '0', '0');
INSERT INTO `wxq_wxq123_site` VALUES ('30', '赶团网', '赶团网', 'cf/155029edd2xtfzbttgqf79.gif', '', 'BSZ9R5', 'http://www.gantuan.com/', '', '', '', '1400256000', '1', 'qizUpM', '', '', '', '1', '0', '0');
INSERT INTO `wxq_wxq123_site` VALUES ('31', 'like团', 'like团', '', '', 'EjiiJ6', 'http://www.liketuan.com/changecity.html', '', '', '', '1400256000', '1', 'PvB1nn', '', '', '', '1', '0', '0');
INSERT INTO `wxq_wxq123_site` VALUES ('32', '天秀团', '天秀团', 'cf/154608grua138q5h1yquhh.png', '', 'yj2Gow', 'http://tuan.tx29.com/', '', '', '', '1400256000', '1', 'iPX38I', '', '', '', '1', '0', '0');
INSERT INTO `wxq_wxq123_site` VALUES ('33', '77座', '77座', '', '', 'lL8szC', 'http://www.77zuo.com/', '', '', '', '1400256000', '1', 'lPm8gZ', '', '', '', '1', '0', '0');
INSERT INTO `wxq_wxq123_site` VALUES ('34', '千品网', '千品网', 'cf/154308stsmtvz0f0t0t12p.jpg', '', 'GB6enB', 'http://www.qianpin.com/', '', '', '', '1400256000', '1', 'CN8YRT', '', '', '', '1', '0', '0');
INSERT INTO `wxq_wxq123_site` VALUES ('35', '知我药妆', '知我药妆', '', '', 'sMgY9h', 'http://www.zhiwo.com/', '', '', '', '1400256000', '1', 'S2keGm', '', '', '', '1', '0', '0');
INSERT INTO `wxq_wxq123_site` VALUES ('36', '麦圈网', '麦圈网', 'cf/153406tsko16r3e971e53y.jpg', '', 'A060t2', 'http://www.much001.com/', '', '', '', '1400256000', '1', 'J4n0X6', '', '', '', '1', '0', '0');
INSERT INTO `wxq_wxq123_site` VALUES ('37', '米奇网', '米奇网', 'cf/152929akk0hkszelkkmxjl.bmp', '', 'TJIcJU', 'http://www.miqi.cn/', '4000-800-777', '', '', '1400256000', '1', 'XnoUl1', '', '', '', '1', '0', '0');
INSERT INTO `wxq_wxq123_site` VALUES ('38', '拼团网', '拼团网', '', '', 'v31H03', 'http://www.pintuan.com/', '', '', '', '1400256000', '1', 'awWc5h', '', '', '', '1', '0', '0');
INSERT INTO `wxq_wxq123_site` VALUES ('39', '秀团网', '秀团网', '', '', 'XWBCH7', 'http://tuan.xiu.com/', '', '', '', '1400256000', '1', 'ls5MxC', '', '', '', '1', '0', '0');
INSERT INTO `wxq_wxq123_site` VALUES ('40', '好易订团', '好易订团', '', '', 'qSARu5', '', '', '', '', '1400256000', '1', '', '', '', '', '1', '0', '0');
INSERT INTO `wxq_wxq123_site` VALUES ('41', '奶粉团', '奶粉团', '', '', 'xKs329', 'http://www.nftuan.com/', '400-699-2004', '', '', '1400256000', '1', 'Z8lnv0', '', '', '', '1', '0', '0');
INSERT INTO `wxq_wxq123_site` VALUES ('42', '饭统-饭团', '饭统-饭团', 'cf/165301cqof55534z84bnow.gif', '', 'AYzQYi', 'http://www.fantong.com/shijiazhuang-groupon/', '', '', '', '1400342400', '1', 'z9vrvZ', '', '', '', '1', '0', '0');
INSERT INTO `wxq_wxq123_site` VALUES ('43', '可可团', '可可团', 'cf/165635xzgzg60wvxlhvzfw.png', '', 'A8ow40', 'http://www.cocotuan.com/', '', '', '', '1400342400', '1', 'vH80hn', '', '', '', '1', '0', '0');
INSERT INTO `wxq_wxq123_site` VALUES ('44', '粉团网', '粉团网', '', '', 'zSXCec', 'http://www.fentuan.com/', '', '', '', '1400342400', '1', 'WEzMF4', '', '', '', '1', '0', '0');
INSERT INTO `wxq_wxq123_site` VALUES ('45', '喜团网', '喜团网', 'cf/165205cz7j7rlwwlwj4jaj.jpg', '', 'B4mBmM', 'http://www.xituan.com/c-shijiazhuang/', '400-705-505', '', '', '1400342400', '1', 'ClAkD0', '', '', '', '1', '0', '0');
INSERT INTO `wxq_wxq123_site` VALUES ('46', '新团网', '新团网', 'cf/165045dfjpcznfuib3sfme.gif', '', 'bhf2yq', 'http://www.361tuan.com/shijiazhuang.html', '4000-123-361', '', '', '1400342400', '1', 'jDzFFF', '', '', '', '1', '0', '0');
INSERT INTO `wxq_wxq123_site` VALUES ('47', '酒仙网', '酒仙网', 'cf/164939usrsdzstsgdhtzih.jpg', '', 'i9T05G', 'http://www.jiuxian.com/tuan.php', '', '', '', '1400342400', '1', 'pr8G7F', '', '', '', '1', '0', '0');
INSERT INTO `wxq_wxq123_site` VALUES ('48', '八佰拍', '八佰拍', '', '', 'htp40B', '', '', '', '', '1400342400', '1', '', '', '', '', '1', '0', '0');
INSERT INTO `wxq_wxq123_site` VALUES ('49', '草莓派团购', '草莓派团购', 'cf/162528k44j9dgbcrsouo9n.gif', '', 'ox4x4M', 'http://groupon.caomeipai.com/', '', '', '', '1400342400', '1', 'ZNgsEO', '', '', '', '1', '0', '0');
INSERT INTO `wxq_wxq123_site` VALUES ('50', 'Z团', 'Z团', '', '', 'FGtBrg', 'http://tuan.zol.com/', '400-678-0068', '', '', '1400342400', '1', 'WUG58a', '', '', '', '1', '0', '0');
INSERT INTO `wxq_wxq123_site` VALUES ('51', '艺龙团购', '艺龙团购', '', '', 'BA2ClQ', 'http://tuan.elong.com/', '400-606-5678', '', '', '1400342400', '1', 'nXZM5T', '', '', '', '1', '0', '0');
INSERT INTO `wxq_wxq123_site` VALUES ('52', '聚乐淘', '聚乐淘', 'cf/164217f8xvqd1qjjj1kzxn.gif', '', 'w7s7G2', 'http://juletao.bj100.com/', '400-621-2001', '', '', '1400342400', '1', 'XaHYhf', '', '', '', '1', '0', '0');
INSERT INTO `wxq_wxq123_site` VALUES ('53', 'NALA团购', 'NALA团购', '', '', 'q9m4K4', '', '', '', '', '1400342400', '1', '', '', '', '', '1', '0', '0');
INSERT INTO `wxq_wxq123_site` VALUES ('54', '同程网团购', '同程网团购', 'cf/163330v65zhoiq3hi75g67.png', '', 'tkl8Kf', 'http://tuan.17u.cn/', '4007-777-777', '', '', '1400342400', '1', 'Q27P2Q', '', '', '', '1', '0', '0');
INSERT INTO `wxq_wxq123_site` VALUES ('55', '爱团网', '爱团网', '', '', 'mXnl74', 'http://www.aituan.com/', '', '', '', '1400342400', '1', 'lmHk2o', '', '', '', '1', '0', '0');
INSERT INTO `wxq_wxq123_site` VALUES ('56', '爽团', '爽团', '', '', 'y8CFi8', 'http://www.shuangtuan.com/shijiazhuang', '400-088-5858', '', '', '1400342400', '1', 'BGTjN7', '', '', '', '1', '0', '0');
INSERT INTO `wxq_wxq123_site` VALUES ('57', '12580团', '12580团', 'cf/152138h76yr7bb7i7yiheq.gif', '', 'M4qT8d', 'http://tuan.12580777.com/', '12580', '', '', '1400342400', '1', 'fP9qHp', '', '', '', '1', '0', '0');
INSERT INTO `wxq_wxq123_site` VALUES ('58', '特特团', '特特团', '', '', 'X0kgC0', '', '', '', '', '1400342400', '1', '', '', '', '', '1', '0', '0');
INSERT INTO `wxq_wxq123_site` VALUES ('59', '巧顾网', '巧顾网', '', '', 'V775Zy', 'http://tuan.qiaogu.com/', '', '', '', '1400342400', '1', 'm1d0uf', '', '', '', '1', '0', '0');
INSERT INTO `wxq_wxq123_site` VALUES ('60', 'YOKA优享', 'YOKA优享', '', '', 't6mX67', 'http://tuan.yoka.com/', '400-6966-000', '', '', '1400342400', '1', 'ZThAw3', '', '', '', '1', '0', '0');
INSERT INTO `wxq_wxq123_site` VALUES ('61', '5173团', '5173团', 'cf/134622gz4ttkpkjsbkx4jj.gif', '', 'JZJ11L', 'http://www.5173tuan.com/', '400-616-5173', '', '', '1400342400', '1', 'Mz0Ts3', '', '', '', '1', '0', '0');
INSERT INTO `wxq_wxq123_site` VALUES ('62', '爱拼团', '爱拼团', 'cf/135039fyrt319yur1t31ci.gif', '', 'Y6wRQA', 'http://www.aipintuan.com/shijiazhuang', '400-696-0223', '', '', '1400342400', '1', 'K71L8H', '', '', '', '1', '0', '0');
INSERT INTO `wxq_wxq123_site` VALUES ('63', '悠兔团', '悠兔团', 'cf/162814jn9gnnfnfeguog9e.jpg', '', 'jIaz1u', 'http://www.yoututuan.com/', '010-52857085', '', '', '1400342400', '1', 'aBt7AA', '', '', '', '1', '0', '0');
INSERT INTO `wxq_wxq123_site` VALUES ('64', '好特会', '好特会', 'cf/163148inq1cn4nqlgnrn2q.jpg', '', 'oKz4K1', 'http://www.haotehui.com/tuangou.jhtml', '400-020-8000', '', '', '1400342400', '1', 'sQQHpN', '', '', '', '1', '0', '0');
INSERT INTO `wxq_wxq123_site` VALUES ('65', '优美集', '优美集', '', '', 'ptEuhi', '', '', '', '', '1400342400', '1', '', '', '', '', '1', '0', '0');
INSERT INTO `wxq_wxq123_site` VALUES ('66', '婚团网', '婚团网', 'cf/163451ys8lksks5xq4y68z.gif', '', 'cj1SBL', 'http://www.d8wed.com/shijiazhuang', '4000-131410', '', '', '1400342400', '1', 'CIAizw', '', '', '', '1', '0', '0');
INSERT INTO `wxq_wxq123_site` VALUES ('67', '一点优惠', '一点优惠', 'cf/134856dcdk8hqqzgon8cqq.jpg', '', 'IrpRqq', 'http://www.ydyouhui.com/', '400-600-0005', '', '', '1400342400', '1', 'sIBcDI', '', '', '', '1', '0', '0');
INSERT INTO `wxq_wxq123_site` VALUES ('68', '星期八团游网', '星期八团游网', '', '', 'p1y2cS', '', '', '', '', '1400342400', '1', '', '', '', '', '1', '0', '0');
INSERT INTO `wxq_wxq123_site` VALUES ('69', '买好网', '买好网', 'cf/131502l64zzgk1r4gz6nan.png', '', 'Jh9wGZ', 'http://shijiazhuang.tuanu.com/', '', '', '', '1400342400', '1', 'y9st1T', '', '', '', '1', '0', '0');
INSERT INTO `wxq_wxq123_site` VALUES ('70', '友团', '友团', 'cf/161820tsosy40s0rv9pqlq.jpg', '', 'pFwbeo', 'http://www.youtuan.so/', '400-010-169', '', '', '1400342400', '1', 'Md131p', '', '', '', '1', '0', '0');
INSERT INTO `wxq_wxq123_site` VALUES ('71', '好划算', '好划算', '', '', 'Y11U9P', '', '', '', '', '1400342400', '1', '', '', '', '', '1', '0', '0');
INSERT INTO `wxq_wxq123_site` VALUES ('72', '团友网', '团友网', 'cf/151743egww7dmidywrwz7o.png', '', 'dldCu4', 'http://shijiazhuang.tuanu.com/', '', '', '', '1400342400', '1', 'IEWUEE', '', '', '', '1', '0', '0');
INSERT INTO `wxq_wxq123_site` VALUES ('73', '酷兜', '酷兜', '', '', 'XErPA4', '', '', '', '', '1400342400', '1', '', '', '', '', '1', '0', '0');
INSERT INTO `wxq_wxq123_site` VALUES ('74', '淘街客', '淘街客', 'cf/115857lnu991n0y9gzn1o2.gif', '', 's5v6LS', 'http://taojieke.com/', '', '', '', '1400342400', '1', 'HukPp8', '', '', '', '1', '0', '0');
INSERT INTO `wxq_wxq123_site` VALUES ('75', '可乐街', '可乐街', '', '', 'nfeN0F', '', '', '', '', '1400342400', '1', '', '', '', '', '1', '0', '0');
INSERT INTO `wxq_wxq123_site` VALUES ('76', '聚耐团', '聚耐团', '', '', 'k7Wrr6', '', '', '', '', '1400342400', '1', '', '', '', '', '1', '0', '0');
INSERT INTO `wxq_wxq123_site` VALUES ('77', '一客网', '一客网', '', '', 'OTtTr9', '', '', '', '', '1400342400', '1', '', '', '', '', '1', '0', '0');
INSERT INTO `wxq_wxq123_site` VALUES ('78', '哪拍网', '哪拍网', '', '', 's7hqh0', '', '', '', '', '1400342400', '1', '', '', '', '', '1', '0', '0');
INSERT INTO `wxq_wxq123_site` VALUES ('79', '团好网', '团好网', 'cf/133411cozsnnvcapbvs51n.gif', '', 'HEI3E4', 'http://www.tuanok.com/', '4006-333-515', '', '', '1400342400', '1', 'YxYGx6', '', '', '', '1', '0', '0');
INSERT INTO `wxq_wxq123_site` VALUES ('80', '今日美丽', '今日美丽', 'cf/120759yzqvc8qxgc6vganc.jpg', '', 'rg3lTM', 'http://www.tnice.com/?utm_source=SI000003&amp;amp;utm_medium=cps&amp;amp;utm_term=&amp;amp;utm_conte', '4007-568-568', '', '', '1400342400', '1', 'mVhWwv', '', '', '', '1', '0', '0');
INSERT INTO `wxq_wxq123_site` VALUES ('81', '联合购买网', '联合购买网', '', '', 'mQaFvb', 'http://www.cobuy.net/shijiazhuang', '400-6677-567', '', '', '1400342400', '1', 'G4d9h4', '', '', '', '1', '0', '0');
INSERT INTO `wxq_wxq123_site` VALUES ('82', '网团', '网团', '', '', 'UvWLW0', 'http://www.comtuan.com/index.php', '', '', '', '1400342400', '1', 'YGp225', '', '', '', '1', '0', '0');
INSERT INTO `wxq_wxq123_site` VALUES ('83', '地团网', '地团网', 'cf/132907icy7zn4kvmvzi0jw.jpg', '', 'LKnKAa', 'http://www.dituan.cn/', '400-059-0791', '', '', '1400342400', '1', 'vsR4m9', '', '', '', '1', '0', '0');
INSERT INTO `wxq_wxq123_site` VALUES ('84', '奶粉团', '奶粉团', 'cf/132723yhghxg7n4dznendz.jpg', '', 'EMvFON', 'http://www.nftuan.com/', '400-699-2004', '', '', '1400342400', '1', 'dyG58q', '', '', '', '1', '0', '0');
INSERT INTO `wxq_wxq123_site` VALUES ('85', '步淘网', '步淘网', '', '', 'YjMGxg', 'http://www.butao.com/', '', '', '', '1400342400', '1', 'EWBIo3', '', '', '', '1', '0', '0');
INSERT INTO `wxq_wxq123_site` VALUES ('86', '优乐网', '优乐网', 'cf/132435oh0shdqimzkrwhom.jpg', '', 'hh41Xh', 'http://www.92youle.com/team/937.html', '400-707-0092', '', '', '1400342400', '1', 'EmE7Mq', '', '', '', '1', '0', '0');
INSERT INTO `wxq_wxq123_site` VALUES ('87', '世团网', '世团网', 'cf/133240axhs88fx4fx0hs8r.jpg', '', 'H2EIq3', 'http://www.worldtgw.com/UserControls/tuanmore6.aspx', '', '', '', '1400342400', '1', 'kyMZ2z', '', '', '', '1', '0', '0');
INSERT INTO `wxq_wxq123_site` VALUES ('88', '365选1团', '365选1团', '', '', 'ES9eeb', '', '', '', '', '1400342400', '1', '', '', '', '', '1', '0', '0');
INSERT INTO `wxq_wxq123_site` VALUES ('89', '爱团购网', '爱团购网', '', '', 'guapBj', '', '', '', '', '1400342400', '1', '', '', '', '', '1', '0', '0');
INSERT INTO `wxq_wxq123_site` VALUES ('90', '抢GO网', '抢GO网', '', '', 'jFDmp3', '', '', '', '', '1400342400', '1', '', '', '', '', '1', '0', '0');
INSERT INTO `wxq_wxq123_site` VALUES ('91', '17团购网', '17团购网', '', '', 'cSB7i1', '', '', '', '', '1400342400', '1', '', '', '', '', '1', '0', '0');
INSERT INTO `wxq_wxq123_site` VALUES ('92', '赛团', '赛团', '', '', 'XS2Rot', '', '', '', '', '1400342400', '1', '', '', '', '', '1', '0', '0');
INSERT INTO `wxq_wxq123_site` VALUES ('93', '丐帮团', '丐帮团', 'cf/115618xkm68v8gmv7k5g9g.gif', '', 'P6cc3B', 'http://www.gaibangtuan.com/', '', '', '', '1400342400', '1', 'FS830H', '', '', '', '1', '0', '0');
INSERT INTO `wxq_wxq123_site` VALUES ('94', '淮团网', '淮团网', 'cf/114453hyzpohhhu1hfuggw.gif', '', 'Iim2Tg', 'http://www.huaituan.com/sjz/', '400-876-0554', '', '', '1400342400', '1', 'S2ugsz', '', '', '', '1', '0', '0');
INSERT INTO `wxq_wxq123_site` VALUES ('95', '拼一回', '拼一回', '', '', 'bT877B', 'http://www.schoolunion.cn/', '400-0980-600   010-83537679', '', '', '1400342400', '1', 'I8W1ok', '', '', '', '1', '0', '0');
INSERT INTO `wxq_wxq123_site` VALUES ('96', '途顺网', '途顺网', 'cf/132106alnkl4un7puu4ssi.jpg', '', 'q5M2eE', 'http://www.tusee.com/shi_jia_zhuang', '4008--107--668', '', '', '1400342400', '1', 'RkQsSr', '', '', '', '1', '0', '0');
INSERT INTO `wxq_wxq123_site` VALUES ('97', '团票吧', '团票吧', 'cf/113323jnc9izczibfen41z.gif', '', 'gyRGe4', 'http://www.tuanpiao8.com/city.php?ename=shijiazhuang', '4000-288-332', '', '', '1400342400', '1', 'Qk3okO', '', '', '', '1', '0', '0');
INSERT INTO `wxq_wxq123_site` VALUES ('98', '5号团', '5号团', 'cf/113105sjzxrjkazn7332bb.jpg', '', 'KsYjaW', 'http://www.j05.com/', '400-015-0006', '', '', '1400342400', '1', 'aeA6NP', '', '', '', '1', '0', '0');
INSERT INTO `wxq_wxq123_site` VALUES ('99', '校团网', '校团网', 'cf/113612xmffssno2fcsnmgf.jpg', '', 'lJ0V3z', 'http://www.schoolunion.cn/', '', '', '', '1400342400', '1', 'fir6Yi', '', '', '', '1', '0', '0');
INSERT INTO `wxq_wxq123_site` VALUES ('100', '百度团购', '百度团购', '', '', 'Q6DPk6', '', '', '', '', '1400342400', '1', '', '', '', '', '1', '0', '0');
INSERT INTO `wxq_wxq123_site` VALUES ('101', '爱乐活', '爱乐活', '', '', 'lC55Bl', '', '', '', '', '1400342400', '1', '', '', '', '', '1', '0', '0');
INSERT INTO `wxq_wxq123_site` VALUES ('102', '聚万众', '聚万众', '', '', 'wfx5I3', '', '', '', '', '1400342400', '1', '', '', '', '', '1', '0', '0');
INSERT INTO `wxq_wxq123_site` VALUES ('103', '自然团', '自然团', '', '', 'nsksZI', '', '', '', '', '1400342400', '1', '', '', '', '', '1', '0', '0');
INSERT INTO `wxq_wxq123_site` VALUES ('104', '原产团', '原产团', '', '', 'COCXOn', 'http://www.yuanchantuan.com/', '400-036-38-36', '', '', '1400342400', '1', 'TOhKGw', '', '', '', '1', '0', '0');
INSERT INTO `wxq_wxq123_site` VALUES ('105', '食团', '食团', '', '', 'Lzufnd', '', '', '', '', '1400342400', '1', '', '', '', '', '1', '0', '0');
INSERT INTO `wxq_wxq123_site` VALUES ('106', '玲珑团', '玲珑团', 'cf/112822qtitz7jc68j6p8ri.jpg', '', 'XfT4B6', 'http://www.linglongtuan.com/', '4006-345-229', '', '', '1400342400', '1', 'YRKsuv', '', '', '', '1', '0', '0');
INSERT INTO `wxq_wxq123_site` VALUES ('107', '生活800', '生活800', '', '', 'N8kj8N', '', '', '', '', '1400342400', '1', '', '', '', '', '1', '0', '0');
INSERT INTO `wxq_wxq123_site` VALUES ('108', '清团网', '清团网', 'cf/083001oe1bqzbqdmppeqmp.png', '', 'iw353Z', 'http://www.tsingtuan.com/', '400-601-3975', '', '', '1400342400', '1', 'q73B26', '', '', '', '1', '0', '0');
INSERT INTO `wxq_wxq123_site` VALUES ('109', '健康团', '健康团', '', '', 'Nx0846', 'http://www.120mai.com/', '', '', '', '1400342400', '1', 'X00YOx', '', '', '', '1', '0', '0');
INSERT INTO `wxq_wxq123_site` VALUES ('110', '麻吉网', '麻吉网', '', '', 'Vj6PeS', '', '', '', '', '1400342400', '1', '', '', '', '', '1', '0', '0');
INSERT INTO `wxq_wxq123_site` VALUES ('111', '私房团', '私房团', '', '', 'S4H1j1', '', '', '', '', '1400342400', '1', '', '', '', '', '1', '0', '0');
INSERT INTO `wxq_wxq123_site` VALUES ('112', '家纺团', '家纺团', '', '', 'ne73Fy', 'http://www.jiafangtuan.com/', '400-0571-876', '', '', '1400342400', '1', 'gdbNmk', '', '', '', '1', '0', '0');
INSERT INTO `wxq_wxq123_site` VALUES ('113', '百酷团', '百酷团', '', '', 'X0cWGy', 'http://www.baikutuan.com/index.aspx', '', '', '', '1400342400', '1', 'PZq7vA', '', '', '', '1', '0', '0');
INSERT INTO `wxq_wxq123_site` VALUES ('114', '团客网', '团客网', 'cf/104018qnl5cl6z64ncin3u.gif', '', 'Xp505D', 'http://www.tuank.cn/shijiazhuang', '', '', '', '1400342400', '1', 'HxL6sz', '', '', '', '1', '0', '0');
INSERT INTO `wxq_wxq123_site` VALUES ('115', '趣天下', '趣天下', '', '', 'i4UUzQ', '', '', '', '', '1400342400', '1', '', '', '', '', '1', '0', '0');
INSERT INTO `wxq_wxq123_site` VALUES ('116', '5团', '5团', 'cf/102931dpsmzbrnqgnnrl6p.png', '', 'Z69Z53', 'http://shijiazhuang.5tuan.com/', '400-677-1550', '', '', '1400342400', '1', 'hz575w', '', '', '', '1', '0', '0');
INSERT INTO `wxq_wxq123_site` VALUES ('117', '秀购网', '秀购网', '', '', 'UzmZUs', 'http://www.xiugou.com/index.html', '4000-235-555', '', '', '1400342400', '1', 'dQREmw', '', '', '', '1', '0', '0');
INSERT INTO `wxq_wxq123_site` VALUES ('118', '新蛋团', '新蛋团', 'cf/103707hwrsb2mtosoiy2yf.png', '', 'h3odH1', 'http://tuan.newegg.com.cn/', '', '', '', '1400342400', '1', 'F3PjU5', '', '', '', '1', '0', '0');
INSERT INTO `wxq_wxq123_site` VALUES ('119', '青团网', '青团网', '', '', 'q34aDA', '', '', '', '', '1400342400', '1', '', '', '', '', '1', '0', '0');
INSERT INTO `wxq_wxq123_site` VALUES ('120', '派乐族', '派乐族', '', '', 'x2GMW9', 'http://www.pailezu.com/', '15314632015  400-0988-789', '', '', '1400342400', '1', 'Pw7N75', '', '', '', '1', '0', '0');
INSERT INTO `wxq_wxq123_site` VALUES ('121', '聚秀团', '聚秀团', '', '', 'n21NC8', '', '', '', '', '1400342400', '1', '', '', '', '', '1', '0', '0');
INSERT INTO `wxq_wxq123_site` VALUES ('122', '凹凸团', '凹凸团', 'cf/161657emlz1663txja6sxt.jpg', '', 'iZdPVr', 'http://www.aotutuan.com/', '', '', '', '1400342400', '1', 'HCGG0t', '', '', '', '1', '0', '0');
INSERT INTO `wxq_wxq123_site` VALUES ('123', '正品SOSO', '正品SOSO', '', '', 'v05V97', 'http://www.zpsoso.com/', '', '', '', '1400342400', '1', 'baUxpR', '', '', '', '1', '0', '0');
INSERT INTO `wxq_wxq123_site` VALUES ('124', '满座网', '满座网', 'cf/160101pb77l9g7xlxm3lm2.jpg', '', 'pPFgS7', 'http://shijiazhuang.manzuo.com/', '', '', '', '1400342400', '1', 'M8EMvK', '', '', '', '1', '0', '0');
INSERT INTO `wxq_wxq123_site` VALUES ('125', '百优团', '百优团', 'cf/121035ndvuebzqgu5i6odu.gif', '', 'i4p2pj', 'http://www.baiyotuan.com/', '', '', '', '1400342400', '1', 'KTF2ep', '', '', '', '1', '0', '0');
INSERT INTO `wxq_wxq123_site` VALUES ('126', '百易团', '百易团', 'cf/121748tsnfx2nxxcxxcrfi.png', '', 'f06iaP', 'http://www.baiyituan.cn/', '', '', '', '1400256000', '1', 'aeC8Md', '', '', '', '1', '0', '0');
INSERT INTO `wxq_wxq123_site` VALUES ('127', '一起学吧', '一起学吧', 'cf/112159oi5545808o0ewqkz.png', 'a:2:{s:10:\"sitemanage\";s:0:\"\";s:8:\"siteuser\";a:1:{i:0;s:6:\"wxq123\";}}', 'gxEizN', 'http://www.17xue8.cn', '', '', '', '0', '1', 'weixin', '', '', '', '1', '0', '0');

-- ----------------------------
-- Table structure for `wxq_wxq123_sitekey`
-- ----------------------------
DROP TABLE IF EXISTS `wxq_wxq123_sitekey`;
CREATE TABLE `wxq_wxq123_sitekey` (
  `siteid` mediumint(8) unsigned NOT NULL auto_increment,
  `siteurl` char(100) character set gbk NOT NULL,
  `charset` char(20) character set gbk NOT NULL,
  `clientip` char(15) character set gbk NOT NULL,
  `sitekey` char(32) character set gbk NOT NULL,
  `salt` char(6) character set gbk NOT NULL,
  `installtime` int(10) unsigned NOT NULL,
  `updatetime` int(10) unsigned NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY  (`siteid`)
) ENGINE=MyISAM AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of wxq_wxq123_sitekey
-- ----------------------------
INSERT INTO `wxq_wxq123_sitekey` VALUES ('2', 'cardelm.com/', 'gbk', '118.186.165.23', '16783f632980fba0291bff39a6b96ab9', 'KFYIWY', '1369202388', '1369247797', '0');
INSERT INTO `wxq_wxq123_sitekey` VALUES ('6', 'wxq123.com/', 'gbk', '118.186.165.23', '8a71a62921452e2e349cee3ffbfa769a', 'de6YLn', '1369247735', '1369247735', '0');

-- ----------------------------
-- Table structure for `wxq_wxq123_table`
-- ----------------------------
DROP TABLE IF EXISTS `wxq_wxq123_table`;
CREATE TABLE `wxq_wxq123_table` (
  `tableid` smallint(6) unsigned NOT NULL auto_increment,
  `classid` smallint(6) unsigned NOT NULL default '0',
  `displayorder` tinyint(3) NOT NULL default '0',
  `expiration` tinyint(1) NOT NULL,
  `protect` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL default '',
  `description` varchar(255) NOT NULL default '',
  `identifier` varchar(255) NOT NULL default '',
  `type` varchar(255) NOT NULL default '',
  `unit` varchar(255) NOT NULL,
  `rules` mediumtext NOT NULL,
  `permprompt` mediumtext NOT NULL,
  `system` tinyint(1) NOT NULL,
  `display` tinyint(1) NOT NULL,
  PRIMARY KEY  (`tableid`),
  KEY `classid` USING BTREE (`classid`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=gbk;

-- ----------------------------
-- Records of wxq_wxq123_table
-- ----------------------------
INSERT INTO `wxq_wxq123_table` VALUES ('8', '1', '2', '0', 'a:2:{s:9:\"usergroup\";s:0:\"\";s:6:\"verify\";s:0:\"\";}', '商家logo', '', 'brandlogo', 'image', '', 'a:3:{s:8:\"maxwidth\";s:0:\"\";s:9:\"maxheight\";s:0:\"\";s:9:\"inputsize\";s:0:\"\";}', '', '1', '1');
INSERT INTO `wxq_wxq123_table` VALUES ('21', '2', '0', '0', 'a:2:{s:9:\"usergroup\";s:0:\"\";s:6:\"verify\";s:0:\"\";}', '商品分类', 'sdfsdf', 'goodstype', 'select', '', 'a:2:{s:7:\"choices\";s:0:\"\";s:9:\"inputsize\";s:0:\"\";}', '', '0', '1');
INSERT INTO `wxq_wxq123_table` VALUES ('10', '1', '3', '0', 'a:3:{s:6:\"status\";s:1:\"0\";s:9:\"usergroup\";s:0:\"\";s:6:\"verify\";s:0:\"\";}', '商家电话', '', 'brandphone', 'calendar', '', 'a:1:{s:9:\"inputsize\";s:0:\"\";}', '', '1', '1');
INSERT INTO `wxq_wxq123_table` VALUES ('11', '1', '4', '0', 'a:4:{s:6:\"status\";s:1:\"1\";s:4:\"mode\";s:1:\"1\";s:9:\"usergroup\";s:0:\"\";s:6:\"verify\";s:0:\"\";}', '商家地址', '', 'brandaddress', 'text', '', 'a:4:{s:9:\"maxlength\";s:0:\"\";s:9:\"inputsize\";s:0:\"\";s:7:\"profile\";s:7:\"address\";s:12:\"defaultvalue\";s:0:\"\";}', '', '1', '1');
INSERT INTO `wxq_wxq123_table` VALUES ('12', '1', '5', '0', 'a:4:{s:6:\"status\";s:1:\"1\";s:4:\"mode\";s:1:\"1\";s:9:\"usergroup\";s:1:\"1\";s:6:\"verify\";s:0:\"\";}', '商家QQ', '', 'brandqq', 'text', '', 'a:4:{s:9:\"maxlength\";s:0:\"\";s:9:\"inputsize\";s:0:\"\";s:7:\"profile\";s:2:\"qq\";s:12:\"defaultvalue\";s:0:\"\";}', '', '1', '1');
INSERT INTO `wxq_wxq123_table` VALUES ('13', '2', '0', '0', 'a:2:{s:9:\"usergroup\";s:0:\"\";s:6:\"verify\";s:0:\"\";}', '商家ID', '', 'shopid', 'number', '', 'a:4:{s:6:\"maxnum\";s:0:\"\";s:6:\"minnum\";s:0:\"\";s:9:\"inputsize\";s:0:\"\";s:12:\"defaultvalue\";s:0:\"\";}', '', '1', '0');
INSERT INTO `wxq_wxq123_table` VALUES ('14', '1', '6', '0', 'a:2:{s:9:\"usergroup\";s:0:\"\";s:6:\"verify\";s:0:\"\";}', '商家位置', '', 'brandditu', 'baidu', '', 'a:4:{s:4:\"city\";s:0:\"\";s:5:\"width\";s:3:\"400\";s:6:\"height\";s:3:\"300\";s:4:\"bili\";s:2:\"12\";}', '', '1', '1');
INSERT INTO `wxq_wxq123_table` VALUES ('15', '1', '7', '0', 'a:2:{s:9:\"usergroup\";s:0:\"\";s:6:\"verify\";s:0:\"\";}', '商家微信', '', 'brandweixin', 'image', '', 'a:3:{s:8:\"maxwidth\";s:0:\"\";s:9:\"maxheight\";s:0:\"\";s:9:\"inputsize\";s:0:\"\";}', '', '1', '1');
INSERT INTO `wxq_wxq123_table` VALUES ('16', '1', '8', '0', 'a:2:{s:9:\"usergroup\";s:0:\"\";s:6:\"verify\";s:0:\"\";}', '微信标识', '6位数字', 'shopweixinboshi', 'text', '', 'a:4:{s:9:\"maxlength\";s:0:\"\";s:9:\"inputsize\";s:0:\"\";s:7:\"profile\";s:0:\"\";s:12:\"defaultvalue\";s:0:\"\";}', '', '0', '1');
INSERT INTO `wxq_wxq123_table` VALUES ('17', '2', '0', '0', 'a:2:{s:9:\"usergroup\";s:0:\"\";s:6:\"verify\";s:0:\"\";}', '商品名称', '', 'goodsname', 'text', '', 'a:4:{s:9:\"maxlength\";s:0:\"\";s:9:\"inputsize\";s:0:\"\";s:7:\"profile\";s:0:\"\";s:12:\"defaultvalue\";s:0:\"\";}', '', '0', '1');
INSERT INTO `wxq_wxq123_table` VALUES ('18', '2', '0', '0', 'a:2:{s:9:\"usergroup\";s:0:\"\";s:6:\"verify\";s:0:\"\";}', '商品单价', '', 'goodsprice', 'number', '', 'a:4:{s:6:\"maxnum\";s:0:\"\";s:6:\"minnum\";s:0:\"\";s:9:\"inputsize\";s:0:\"\";s:12:\"defaultvalue\";s:0:\"\";}', '', '0', '1');
INSERT INTO `wxq_wxq123_table` VALUES ('19', '1', '0', '0', 'a:3:{s:6:\"status\";s:1:\"0\";s:9:\"usergroup\";s:0:\"\";s:6:\"verify\";s:0:\"\";}', '商家名称', '填写店铺的全称', 'shopname', 'text', '', 'a:4:{s:9:\"maxlength\";s:0:\"\";s:9:\"inputsize\";s:0:\"\";s:7:\"profile\";s:0:\"\";s:12:\"defaultvalue\";s:0:\"\";}', '', '1', '1');
INSERT INTO `wxq_wxq123_table` VALUES ('1', '0', '0', '0', '', '商家类', '', 'shop', '', '', '', '', '0', '0');
INSERT INTO `wxq_wxq123_table` VALUES ('2', '0', '1', '0', '', '通用商品类', '', '', '', '', '', '', '0', '0');
INSERT INTO `wxq_wxq123_table` VALUES ('20', '1', '1', '0', '', '商家缩写', '', 'shopsuoxie', 'text', '', '', '', '0', '0');

-- ----------------------------
-- Table structure for `wxq_wxq123_threadtype`
-- ----------------------------
DROP TABLE IF EXISTS `wxq_wxq123_threadtype`;
CREATE TABLE `wxq_wxq123_threadtype` (
  `typeid` smallint(6) unsigned NOT NULL auto_increment,
  `classid` smallint(6) NOT NULL,
  `mokuaiid` smallint(6) unsigned NOT NULL default '0',
  `optionid` mediumint(8) NOT NULL,
  `available` tinyint(1) unsigned NOT NULL default '0',
  `required` tinyint(1) NOT NULL,
  `unchangeable` tinyint(1) NOT NULL,
  `searchform` tinyint(1) NOT NULL,
  `searchfont` tinyint(1) NOT NULL,
  `weixinshow` tinyint(1) NOT NULL,
  `displayorder` smallint(6) NOT NULL default '0',
  PRIMARY KEY  (`typeid`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=gbk;

-- ----------------------------
-- Records of wxq_wxq123_threadtype
-- ----------------------------
INSERT INTO `wxq_wxq123_threadtype` VALUES ('1', '0', '1', '15', '1', '1', '1', '0', '0', '1', '5');
INSERT INTO `wxq_wxq123_threadtype` VALUES ('2', '0', '1', '14', '1', '1', '0', '1', '0', '0', '7');
INSERT INTO `wxq_wxq123_threadtype` VALUES ('3', '0', '1', '12', '1', '0', '0', '0', '0', '0', '4');
INSERT INTO `wxq_wxq123_threadtype` VALUES ('4', '0', '1', '11', '1', '1', '0', '1', '0', '0', '3');
INSERT INTO `wxq_wxq123_threadtype` VALUES ('5', '0', '1', '10', '1', '1', '0', '0', '0', '0', '2');
INSERT INTO `wxq_wxq123_threadtype` VALUES ('6', '0', '1', '8', '1', '1', '0', '0', '1', '0', '1');
INSERT INTO `wxq_wxq123_threadtype` VALUES ('7', '0', '1', '15', '0', '1', '1', '0', '0', '1', '5');
INSERT INTO `wxq_wxq123_threadtype` VALUES ('8', '0', '1', '14', '0', '1', '0', '1', '0', '0', '7');
INSERT INTO `wxq_wxq123_threadtype` VALUES ('9', '0', '1', '12', '0', '0', '0', '0', '0', '0', '4');
INSERT INTO `wxq_wxq123_threadtype` VALUES ('10', '0', '1', '11', '0', '1', '0', '1', '0', '0', '3');
INSERT INTO `wxq_wxq123_threadtype` VALUES ('11', '0', '1', '10', '0', '1', '0', '0', '0', '0', '2');
INSERT INTO `wxq_wxq123_threadtype` VALUES ('12', '0', '1', '8', '0', '1', '0', '0', '1', '0', '1');
INSERT INTO `wxq_wxq123_threadtype` VALUES ('13', '0', '1', '15', '0', '1', '1', '0', '0', '1', '5');
INSERT INTO `wxq_wxq123_threadtype` VALUES ('14', '0', '1', '14', '0', '1', '0', '1', '0', '0', '7');
INSERT INTO `wxq_wxq123_threadtype` VALUES ('15', '0', '1', '12', '0', '0', '0', '0', '0', '0', '4');
INSERT INTO `wxq_wxq123_threadtype` VALUES ('16', '0', '1', '11', '0', '1', '0', '1', '0', '0', '3');
INSERT INTO `wxq_wxq123_threadtype` VALUES ('17', '0', '1', '10', '0', '1', '0', '0', '0', '0', '2');
INSERT INTO `wxq_wxq123_threadtype` VALUES ('18', '0', '1', '8', '0', '1', '0', '0', '1', '0', '1');
INSERT INTO `wxq_wxq123_threadtype` VALUES ('19', '0', '1', '16', '1', '1', '1', '0', '0', '0', '6');
INSERT INTO `wxq_wxq123_threadtype` VALUES ('20', '0', '1', '19', '1', '0', '0', '0', '0', '0', '0');

-- ----------------------------
-- Table structure for `wxq_wxq123_typeoption`
-- ----------------------------
DROP TABLE IF EXISTS `wxq_wxq123_typeoption`;
CREATE TABLE `wxq_wxq123_typeoption` (
  `optionid` smallint(6) unsigned NOT NULL auto_increment,
  `classid` smallint(6) unsigned NOT NULL default '0',
  `displayorder` tinyint(3) NOT NULL default '0',
  `expiration` tinyint(1) NOT NULL,
  `protect` varchar(255) NOT NULL,
  `title` varchar(255) NOT NULL default '',
  `description` varchar(255) NOT NULL default '',
  `identifier` varchar(255) NOT NULL default '',
  `type` varchar(255) NOT NULL default '',
  `unit` varchar(255) NOT NULL,
  `rules` mediumtext NOT NULL,
  `permprompt` mediumtext NOT NULL,
  `system` tinyint(1) NOT NULL,
  `display` tinyint(1) NOT NULL,
  PRIMARY KEY  (`optionid`),
  KEY `classid` (`classid`)
) ENGINE=MyISAM AUTO_INCREMENT=22 DEFAULT CHARSET=gbk;

-- ----------------------------
-- Records of wxq_wxq123_typeoption
-- ----------------------------
INSERT INTO `wxq_wxq123_typeoption` VALUES ('8', '1', '2', '0', 'a:2:{s:9:\"usergroup\";s:0:\"\";s:6:\"verify\";s:0:\"\";}', '商家logo', '', 'brandlogo', 'image', '', 'a:3:{s:8:\"maxwidth\";s:0:\"\";s:9:\"maxheight\";s:0:\"\";s:9:\"inputsize\";s:0:\"\";}', '', '1', '1');
INSERT INTO `wxq_wxq123_typeoption` VALUES ('21', '2', '0', '0', 'a:2:{s:9:\"usergroup\";s:0:\"\";s:6:\"verify\";s:0:\"\";}', '商品分类', 'sdfsdf', 'goodstype', 'select', '', 'a:2:{s:7:\"choices\";s:0:\"\";s:9:\"inputsize\";s:0:\"\";}', '', '0', '1');
INSERT INTO `wxq_wxq123_typeoption` VALUES ('10', '1', '3', '0', 'a:3:{s:6:\"status\";s:1:\"0\";s:9:\"usergroup\";s:0:\"\";s:6:\"verify\";s:0:\"\";}', '商家电话', '', 'brandphone', 'calendar', '', 'a:1:{s:9:\"inputsize\";s:0:\"\";}', '', '1', '1');
INSERT INTO `wxq_wxq123_typeoption` VALUES ('11', '1', '4', '0', 'a:4:{s:6:\"status\";s:1:\"1\";s:4:\"mode\";s:1:\"1\";s:9:\"usergroup\";s:0:\"\";s:6:\"verify\";s:0:\"\";}', '商家地址', '', 'brandaddress', 'text', '', 'a:4:{s:9:\"maxlength\";s:0:\"\";s:9:\"inputsize\";s:0:\"\";s:7:\"profile\";s:7:\"address\";s:12:\"defaultvalue\";s:0:\"\";}', '', '1', '1');
INSERT INTO `wxq_wxq123_typeoption` VALUES ('12', '1', '5', '0', 'a:4:{s:6:\"status\";s:1:\"1\";s:4:\"mode\";s:1:\"1\";s:9:\"usergroup\";s:1:\"1\";s:6:\"verify\";s:0:\"\";}', '商家QQ', '', 'brandqq', 'text', '', 'a:4:{s:9:\"maxlength\";s:0:\"\";s:9:\"inputsize\";s:0:\"\";s:7:\"profile\";s:2:\"qq\";s:12:\"defaultvalue\";s:0:\"\";}', '', '1', '1');
INSERT INTO `wxq_wxq123_typeoption` VALUES ('13', '2', '0', '0', 'a:2:{s:9:\"usergroup\";s:0:\"\";s:6:\"verify\";s:0:\"\";}', '商家ID', '', 'shopid', 'number', '', 'a:4:{s:6:\"maxnum\";s:0:\"\";s:6:\"minnum\";s:0:\"\";s:9:\"inputsize\";s:0:\"\";s:12:\"defaultvalue\";s:0:\"\";}', '', '1', '0');
INSERT INTO `wxq_wxq123_typeoption` VALUES ('14', '1', '6', '0', 'a:2:{s:9:\"usergroup\";s:0:\"\";s:6:\"verify\";s:0:\"\";}', '商家位置', '', 'brandditu', 'baidu', '', 'a:4:{s:4:\"city\";s:0:\"\";s:5:\"width\";s:3:\"400\";s:6:\"height\";s:3:\"300\";s:4:\"bili\";s:2:\"12\";}', '', '1', '1');
INSERT INTO `wxq_wxq123_typeoption` VALUES ('15', '1', '7', '0', 'a:2:{s:9:\"usergroup\";s:0:\"\";s:6:\"verify\";s:0:\"\";}', '商家微信', '', 'brandweixin', 'image', '', 'a:3:{s:8:\"maxwidth\";s:0:\"\";s:9:\"maxheight\";s:0:\"\";s:9:\"inputsize\";s:0:\"\";}', '', '1', '1');
INSERT INTO `wxq_wxq123_typeoption` VALUES ('16', '1', '8', '0', 'a:2:{s:9:\"usergroup\";s:0:\"\";s:6:\"verify\";s:0:\"\";}', '微信标识', '6位数字', 'shopweixinboshi', 'text', '', 'a:4:{s:9:\"maxlength\";s:0:\"\";s:9:\"inputsize\";s:0:\"\";s:7:\"profile\";s:0:\"\";s:12:\"defaultvalue\";s:0:\"\";}', '', '0', '1');
INSERT INTO `wxq_wxq123_typeoption` VALUES ('17', '2', '0', '0', 'a:2:{s:9:\"usergroup\";s:0:\"\";s:6:\"verify\";s:0:\"\";}', '商品名称', '', 'goodsname', 'text', '', 'a:4:{s:9:\"maxlength\";s:0:\"\";s:9:\"inputsize\";s:0:\"\";s:7:\"profile\";s:0:\"\";s:12:\"defaultvalue\";s:0:\"\";}', '', '0', '1');
INSERT INTO `wxq_wxq123_typeoption` VALUES ('18', '2', '0', '0', 'a:2:{s:9:\"usergroup\";s:0:\"\";s:6:\"verify\";s:0:\"\";}', '商品单价', '', 'goodsprice', 'number', '', 'a:4:{s:6:\"maxnum\";s:0:\"\";s:6:\"minnum\";s:0:\"\";s:9:\"inputsize\";s:0:\"\";s:12:\"defaultvalue\";s:0:\"\";}', '', '0', '1');
INSERT INTO `wxq_wxq123_typeoption` VALUES ('19', '1', '0', '0', 'a:3:{s:6:\"status\";s:1:\"0\";s:9:\"usergroup\";s:0:\"\";s:6:\"verify\";s:0:\"\";}', '商家名称', '填写店铺的全称', 'shopname', 'text', '', 'a:4:{s:9:\"maxlength\";s:0:\"\";s:9:\"inputsize\";s:0:\"\";s:7:\"profile\";s:0:\"\";s:12:\"defaultvalue\";s:0:\"\";}', '', '1', '1');
INSERT INTO `wxq_wxq123_typeoption` VALUES ('1', '0', '0', '0', '', '商家类', '', 'shop', '', '', '', '', '0', '0');
INSERT INTO `wxq_wxq123_typeoption` VALUES ('2', '0', '1', '0', '', '通用商品类', '', '', '', '', '', '', '0', '0');
INSERT INTO `wxq_wxq123_typeoption` VALUES ('20', '1', '1', '0', '', '商家缩写', '', 'shopsuoxie', 'text', '', '', '', '0', '0');

-- ----------------------------
-- Table structure for `wxq_wxq123_ver28_setting`
-- ----------------------------
DROP TABLE IF EXISTS `wxq_wxq123_ver28_setting`;
CREATE TABLE `wxq_wxq123_ver28_setting` (
  `skey` varchar(255) NOT NULL,
  `svalue` text NOT NULL,
  PRIMARY KEY  (`skey`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of wxq_wxq123_ver28_setting
-- ----------------------------

-- ----------------------------
-- Table structure for `wxq_wxq123_weixin_temp`
-- ----------------------------
DROP TABLE IF EXISTS `wxq_wxq123_weixin_temp`;
CREATE TABLE `wxq_wxq123_weixin_temp` (
  `id` mediumint(8) unsigned NOT NULL auto_increment,
  `time` int(10) unsigned NOT NULL,
  `postxml` text NOT NULL,
  `type` char(20) NOT NULL,
  `fromusername` char(255) NOT NULL,
  `tousername` char(255) default NULL,
  `inputtype` char(255) NOT NULL,
  `get` text,
  `post` text,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=275 DEFAULT CHARSET=gbk;

-- ----------------------------
-- Records of wxq_wxq123_weixin_temp
-- ----------------------------
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('32', '1368325215', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368325226&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[绂诲紑]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5876912095961809007&lt;/MsgId&gt;\n&lt;/xml&gt;', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('31', '1368290894', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368290905&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[鐪嬭?]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5876764688389242989&lt;/MsgId&gt;\n&lt;/xml&gt;', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('30', '1368289279', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368289290&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[娌?]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5876757752017059947&lt;/MsgId&gt;\n&lt;/xml&gt;', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('4', '1368250145', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368250154&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[image]]&gt;&lt;/MsgType&gt;\n&lt;PicUrl&gt;&lt;![CDATA[http://mmsns.qpic.cn/mmsns/gKRmRIXBphzyTTysBS1joLxBjWyW1pDNy1YcZjicP3LibryIyMGDvVMg/0]]&gt;&lt;/PicUrl&gt;\n&lt;MsgId&gt;5876589664176963656&lt;/MsgId&gt;\n&lt;MediaId&gt;&lt;![CDATA[oqrYLiwf7yo5ruAzwCr87RjlbeX0J4MGPuplWhj2zQtHXBISJAEhiV9AxHDm0fuE]]&gt;&lt;/MediaId&gt;\n&lt;/xml&gt;', 'image', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('5', '1368250244', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368250254&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[video]]&gt;&lt;/MsgType&gt;\n&lt;MediaId&gt;&lt;![CDATA[oQK5ycLlivczsj1LUAq5lhDNqwLLVGzRMLj-S3C1PbmsV-DPg29rheuwgoXdo5Dm]]&gt;&lt;/MediaId&gt;\n&lt;ThumbMediaId&gt;&lt;![CDATA[sViAraR2tJkXJxoa2TX46dW6Q0e8sTOZ6-j7X1YbefrVVjD9kV-X8e8Ie4-Tycz-]]&gt;&lt;/ThumbMediaId&gt;\n&lt;MsgId&gt;5876590093673693257&lt;/MsgId&gt;\n&lt;/xml&gt;', 'video', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('6', '1368250266', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368250275&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[location]]&gt;&lt;/MsgType&gt;\n&lt;Location_X&gt;38.064110&lt;/Location_X&gt;\n&lt;Location_Y&gt;114.480003&lt;/Location_Y&gt;\n&lt;Scale&gt;20&lt;/Scale&gt;\n&lt;Label&gt;&lt;![CDATA[]]&gt;&lt;/Label&gt;\n&lt;MsgId&gt;5876590183868006474&lt;/MsgId&gt;\n&lt;/xml&gt;', 'location', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('7', '1368250331', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368250341&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[/:,@!]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5876590467335848011&lt;/MsgId&gt;\n&lt;/xml&gt;', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('8', '1368251306', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368251316&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[鐨勫惂]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5876594654928961612&lt;/MsgId&gt;\n&lt;/xml&gt;', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('9', '1368253662', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjnxmZ2EsV0S8-INb7X-gm6Q]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368253672&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[event]]&gt;&lt;/MsgType&gt;\n&lt;Event&gt;&lt;![CDATA[subscribe]]&gt;&lt;/Event&gt;\n&lt;EventKey&gt;&lt;![CDATA[]]&gt;&lt;/EventKey&gt;\n&lt;/xml&gt;', 'event', 'oCHHbjnxmZ2EsV0S8-INb7X-gm6Q', 'gh_46cfe935a631', '', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('10', '1368253678', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjnxmZ2EsV0S8-INb7X-gm6Q]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368253688&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[gg]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5876604842591387726&lt;/MsgId&gt;\n&lt;/xml&gt;', 'text', 'oCHHbjnxmZ2EsV0S8-INb7X-gm6Q', 'gh_46cfe935a631', '', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('11', '1368254894', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368254904&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[event]]&gt;&lt;/MsgType&gt;\n&lt;Event&gt;&lt;![CDATA[unsubscribe]]&gt;&lt;/Event&gt;\n&lt;EventKey&gt;&lt;![CDATA[]]&gt;&lt;/EventKey&gt;\n&lt;/xml&gt;', 'event', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('12', '1368265489', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368265498&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[event]]&gt;&lt;/MsgType&gt;\n&lt;Event&gt;&lt;![CDATA[subscribe]]&gt;&lt;/Event&gt;\n&lt;EventKey&gt;&lt;![CDATA[]]&gt;&lt;/EventKey&gt;\n&lt;/xml&gt;', 'event', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('13', '1368265507', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368265518&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[鍛靛懙]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5876655652054499408&lt;/MsgId&gt;\n&lt;/xml&gt;', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('14', '1368265560', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368265570&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[绂诲紑]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5876655875392798801&lt;/MsgId&gt;\n&lt;/xml&gt;', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('15', '1368265598', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368265609&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[鎶奭]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5876656042896523346&lt;/MsgId&gt;\n&lt;/xml&gt;', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('16', '1368265701', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368265711&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[鍝﹀摝]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5876656480983187540&lt;/MsgId&gt;\n&lt;/xml&gt;', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('17', '1368265728', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368265738&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[浜哴]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5876656596947304533&lt;/MsgId&gt;\n&lt;/xml&gt;', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('18', '1368265775', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368265785&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[鍛靛懙]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5876656798810767446&lt;/MsgId&gt;\n&lt;/xml&gt;', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('19', '1368265858', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368265868&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[绂诲紑]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5876657155293053016&lt;/MsgId&gt;\n&lt;/xml&gt;', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('20', '1368265879', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368265889&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[1]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5876657245487366234&lt;/MsgId&gt;\n&lt;/xml&gt;', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('21', '1368265927', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368265937&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[event]]&gt;&lt;/MsgType&gt;\n&lt;Event&gt;&lt;![CDATA[unsubscribe]]&gt;&lt;/Event&gt;\n&lt;EventKey&gt;&lt;![CDATA[]]&gt;&lt;/EventKey&gt;\n&lt;/xml&gt;', 'event', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('22', '1368265942', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368265952&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[event]]&gt;&lt;/MsgType&gt;\n&lt;Event&gt;&lt;![CDATA[subscribe]]&gt;&lt;/Event&gt;\n&lt;EventKey&gt;&lt;![CDATA[]]&gt;&lt;/EventKey&gt;\n&lt;/xml&gt;', 'event', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('23', '1368265980', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368265990&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[event]]&gt;&lt;/MsgType&gt;\n&lt;Event&gt;&lt;![CDATA[unsubscribe]]&gt;&lt;/Event&gt;\n&lt;EventKey&gt;&lt;![CDATA[]]&gt;&lt;/EventKey&gt;\n&lt;/xml&gt;', 'event', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('24', '1368265992', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368266002&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[event]]&gt;&lt;/MsgType&gt;\n&lt;Event&gt;&lt;![CDATA[subscribe]]&gt;&lt;/Event&gt;\n&lt;EventKey&gt;&lt;![CDATA[]]&gt;&lt;/EventKey&gt;\n&lt;/xml&gt;', 'event', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('25', '1368283810', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368283819&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[鍟婂晩]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5876734254250983517&lt;/MsgId&gt;\n&lt;/xml&gt;', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('26', '1368284352', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368284362&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[鍦焆]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5876736586418225251&lt;/MsgId&gt;\n&lt;/xml&gt;', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('27', '1368284568', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368284578&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[鍙?', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('28', '1368284972', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368284982&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[閲宂]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5876739249297948775&lt;/MsgId&gt;\n&lt;/xml&gt;', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('29', '1368284984', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368284995&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[1]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5876739305132523625&lt;/MsgId&gt;\n&lt;/xml&gt;', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('33', '1368325250', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368325262&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[鍛靛懙]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5876912250580631665&lt;/MsgId&gt;\n&lt;/xml&gt;', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('34', '1368325319', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368325331&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[鎶奭]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5876912546933375091&lt;/MsgId&gt;\n&lt;/xml&gt;', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('35', '1368325393', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368325405&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[鍛靛懙]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5876912864760954997&lt;/MsgId&gt;\n&lt;/xml&gt;', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('36', '1368325437', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368325449&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[鍛靛懙]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5876913053739516023&lt;/MsgId&gt;\n&lt;/xml&gt;', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('37', '1368325600', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368325612&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[绂诲紑]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5876913753819185273&lt;/MsgId&gt;\n&lt;/xml&gt;', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('38', '1368326088', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368326099&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[鎶奭]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5876915845468258427&lt;/MsgId&gt;\n&lt;/xml&gt;', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('39', '1368326182', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368326194&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[绂诲紑]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5876916253490151548&lt;/MsgId&gt;\n&lt;/xml&gt;', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('40', '1368326314', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368326326&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[绂诲紑]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5876916820425834621&lt;/MsgId&gt;\n&lt;/xml&gt;', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('41', '1368326339', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368326351&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[鍛靛懙]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5876916927800017023&lt;/MsgId&gt;\n&lt;/xml&gt;', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('42', '1368326405', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368326416&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[鐨刔]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5876917206972891264&lt;/MsgId&gt;\n&lt;/xml&gt;', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('43', '1368326638', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368326650&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[绂诲紑]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5876918211995238529&lt;/MsgId&gt;\n&lt;/xml&gt;', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('44', '1368326681', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368326692&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[鍛靛懙]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5876918392383864962&lt;/MsgId&gt;\n&lt;/xml&gt;', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('45', '1368326880', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368326891&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[鍛靛懙]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5876919247082356867&lt;/MsgId&gt;\n&lt;/xml&gt;', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('46', '1368326947', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368326958&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[浜嬪疄]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5876919534845165700&lt;/MsgId&gt;\n&lt;/xml&gt;', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('47', '1368327006', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368327017&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[鍜屽摜]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5876919788248236165&lt;/MsgId&gt;\n&lt;/xml&gt;', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('48', '1368327733', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368327745&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[浜嬪疄]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5876922914984427654&lt;/MsgId&gt;\n&lt;/xml&gt;', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('49', '1368327975', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368327987&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[绐乚]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5876923954366513287&lt;/MsgId&gt;\n&lt;/xml&gt;', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('50', '1368328000', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368328011&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[绂诲紑]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5876924057445728392&lt;/MsgId&gt;\n&lt;/xml&gt;', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('51', '1368328076', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368328088&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[閮戝窞]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5876924388158210185&lt;/MsgId&gt;\n&lt;/xml&gt;', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('52', '1368328224', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368328236&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[绂诲紑]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5876925023813369994&lt;/MsgId&gt;\n&lt;/xml&gt;', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('53', '1368328261', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368328273&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[鍛靛懙]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5876925182727159947&lt;/MsgId&gt;\n&lt;/xml&gt;', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('54', '1368328404', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368328416&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[event]]&gt;&lt;/MsgType&gt;\n&lt;Event&gt;&lt;![CDATA[unsubscribe]]&gt;&lt;/Event&gt;\n&lt;EventKey&gt;&lt;![CDATA[]]&gt;&lt;/EventKey&gt;\n&lt;/xml&gt;', 'event', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('55', '1368328425', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368328437&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[event]]&gt;&lt;/MsgType&gt;\n&lt;Event&gt;&lt;![CDATA[subscribe]]&gt;&lt;/Event&gt;\n&lt;EventKey&gt;&lt;![CDATA[]]&gt;&lt;/EventKey&gt;\n&lt;/xml&gt;', 'event', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('56', '1368328492', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368328504&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[/::@]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5876926174864605324&lt;/MsgId&gt;\n&lt;/xml&gt;', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('57', '1368329864', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368329876&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[鐨刔]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5876932067559735437&lt;/MsgId&gt;\n&lt;/xml&gt;', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('58', '1368330144', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_0b4e4c24dc8b]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oJGqcjlfli2uWB8wiYRmZ8tiwlKQ]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368330155&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[绂诲紑]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5876933265955611058&lt;/MsgId&gt;\n&lt;/xml&gt;', 'text', 'oJGqcjlfli2uWB8wiYRmZ8tiwlKQ', 'gh_0b4e4c24dc8b', '', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('59', '1368330187', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_0b4e4c24dc8b]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oJGqcjlfli2uWB8wiYRmZ8tiwlKQ]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368330198&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[鍛靛懙]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5876933450639204787&lt;/MsgId&gt;\n&lt;/xml&gt;', 'text', 'oJGqcjlfli2uWB8wiYRmZ8tiwlKQ', 'gh_0b4e4c24dc8b', '', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('60', '1368337694', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368337706&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[鑾玗]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5876965697153663118&lt;/MsgId&gt;\n&lt;/xml&gt;', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('61', '1368337953', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368337965&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[绂诲紑]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5876966809550192783&lt;/MsgId&gt;\n&lt;/xml&gt;', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('62', '1368338044', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368338056&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[鍛靛懙]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5876967200392216720&lt;/MsgId&gt;\n&lt;/xml&gt;', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('63', '1368338089', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368338101&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[绐乚]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5876967393665745041&lt;/MsgId&gt;\n&lt;/xml&gt;', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('64', '1368339440', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368339452&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[鍛靛懙]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5876973196166561938&lt;/MsgId&gt;\n&lt;/xml&gt;', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('65', '1368341186', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368341198&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[绂诲紑]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5876980695179460755&lt;/MsgId&gt;\n&lt;/xml&gt;', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('66', '1368341406', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368341418&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[鎶奭]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5876981640072265876&lt;/MsgId&gt;\n&lt;/xml&gt;', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('67', '1368341487', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368341499&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[绂诲紑]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5876981987964616853&lt;/MsgId&gt;\n&lt;/xml&gt;', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('68', '1368343008', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368343020&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[鍛靛懙]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5876988520609874070&lt;/MsgId&gt;\n&lt;/xml&gt;', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('69', '1368343065', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368343077&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[绂诲紑]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5876988765423009943&lt;/MsgId&gt;\n&lt;/xml&gt;', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('70', '1368343385', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368343397&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[location]]&gt;&lt;/MsgType&gt;\n&lt;Location_X&gt;38.064262&lt;/Location_X&gt;\n&lt;Location_Y&gt;114.480087&lt;/Location_Y&gt;\n&lt;Scale&gt;20&lt;/Scale&gt;\n&lt;Label&gt;&lt;![CDATA[]]&gt;&lt;/Label&gt;\n&lt;MsgId&gt;5876990139812544664&lt;/MsgId&gt;\n&lt;/xml&gt;', 'location', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('71', '1368343903', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368343915&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[/::P]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5876992364605603993&lt;/MsgId&gt;\n&lt;/xml&gt;', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('72', '1368343971', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368343983&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[鎴戝湪璺?笂锛岄┈涓婂埌銆俔]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5876992656663380122&lt;/MsgId&gt;\n&lt;/xml&gt;', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('73', '1368344029', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368344041&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[鍛礭]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5876992905771483291&lt;/MsgId&gt;\n&lt;/xml&gt;', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('74', '1368344041', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368344053&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[濂界殑锛岃阿璋?紒]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5876992957311090844&lt;/MsgId&gt;\n&lt;/xml&gt;', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('75', '1368344186', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368344198&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[绂诲紑]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5876993580081348765&lt;/MsgId&gt;\n&lt;/xml&gt;', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('76', '1368344210', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368344222&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[鍝﹀摝]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5876993683160563870&lt;/MsgId&gt;\n&lt;/xml&gt;', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('77', '1368344278', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368344290&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[绐乚]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5876993975218339999&lt;/MsgId&gt;\n&lt;/xml&gt;', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('78', '1368344315', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368344327&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[:-P]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5876994134132129952&lt;/MsgId&gt;\n&lt;/xml&gt;', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('79', '1368344502', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368344514&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[鑰僝]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5876994937291014305&lt;/MsgId&gt;\n&lt;/xml&gt;', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('80', '1368344581', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368344593&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[绂诲紑]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5876995276593430690&lt;/MsgId&gt;\n&lt;/xml&gt;', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('81', '1368344650', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368344662&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[鍟婂晩]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5876995572946174115&lt;/MsgId&gt;\n&lt;/xml&gt;', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('82', '1368344719', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368344731&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[绂诲紑]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5876995869298917540&lt;/MsgId&gt;\n&lt;/xml&gt;', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('83', '1368344807', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368344819&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[绂诲紑]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5876996247256039589&lt;/MsgId&gt;\n&lt;/xml&gt;', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('84', '1368345286', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368345298&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[绂诲紑]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5876998304545374374&lt;/MsgId&gt;\n&lt;/xml&gt;', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('85', '1368345372', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368345384&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[/::)]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5876998673912561831&lt;/MsgId&gt;\n&lt;/xml&gt;', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('86', '1368345390', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_0b4e4c24dc8b]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oJGqcjlfli2uWB8wiYRmZ8tiwlKQ]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368345402&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[image]]&gt;&lt;/MsgType&gt;\n&lt;PicUrl&gt;&lt;![CDATA[http://mmsns.qpic.cn/mmsns/gKRmRIXBphx4KH3GdI8L8G0Tjiboia3tVEle1yQJogjsiaRl2JDIJVLUg/0]]&gt;&lt;/PicUrl&gt;\n&lt;MsgId&gt;5876998751321973172&lt;/MsgId&gt;\n&lt;MediaId&gt;&lt;![CDATA[gXnaBU_lOYfDBqadAn_4IU-v6fncSIbELiBkSP-T2JfPCbMPlh62SALmmgShsB-3]]&gt;&lt;/MediaId&gt;\n&lt;/xml&gt;', 'image', 'oJGqcjlfli2uWB8wiYRmZ8tiwlKQ', 'gh_0b4e4c24dc8b', '', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('87', '1368345470', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368345483&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[鍛靛懙]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5876999099114324136&lt;/MsgId&gt;\n&lt;/xml&gt;', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('88', '1368346240', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368346252&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[绠＄悊]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5877002401944174761&lt;/MsgId&gt;\n&lt;/xml&gt;', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('89', '1368373966', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_0b4e4c24dc8b]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oJGqcjlfli2uWB8wiYRmZ8tiwlKQ]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368373978&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[鍟婂晩]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5877121484307423669&lt;/MsgId&gt;\n&lt;/xml&gt;', 'text', 'oJGqcjlfli2uWB8wiYRmZ8tiwlKQ', 'gh_0b4e4c24dc8b', '', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('90', '1368456518', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368456518&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[鍛靛懙]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5877475990808035498&lt;/MsgId&gt;\n&lt;/xml&gt;', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('91', '1368667629', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368667632&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[绂诲紑]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5878382718533763243&lt;/MsgId&gt;\n&lt;/xml&gt;', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('92', '1368667718', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368667722&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[绂诲紑]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5878383105080819884&lt;/MsgId&gt;\n&lt;/xml&gt;', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('93', '1368670169', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_0b4e4c24dc8b]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oJGqcjlfli2uWB8wiYRmZ8tiwlKQ]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368670173&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[鍛靛懙]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5878393632145662390&lt;/MsgId&gt;\n&lt;/xml&gt;', 'text', 'oJGqcjlfli2uWB8wiYRmZ8tiwlKQ', 'gh_0b4e4c24dc8b', '', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('94', '1368675968', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368675973&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[鍛靛懙]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5878418542855979181&lt;/MsgId&gt;\n&lt;/xml&gt;', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('95', '1368675978', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368675983&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[鍛靛懙]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5878418585805652142&lt;/MsgId&gt;\n&lt;/xml&gt;', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('96', '1368797772', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368797780&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[鍛靛懙]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5878941699937403055&lt;/MsgId&gt;\n&lt;/xml&gt;', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('97', '1368797846', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368797854&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[鍛靛懙]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5878942017764982960&lt;/MsgId&gt;\n&lt;/xml&gt;', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('98', '1368797854', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368797862&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[鍝﹀摝]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5878942052124721329&lt;/MsgId&gt;\n&lt;/xml&gt;', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('99', '1368797879', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368797888&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[dd]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5878942163793871026&lt;/MsgId&gt;\n&lt;/xml&gt;', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('100', '1368797947', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368797955&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[gg]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5878942451556679859&lt;/MsgId&gt;\n&lt;/xml&gt;1', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('101', '1368798123', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368798131&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[hh]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5878943207470923956&lt;/MsgId&gt;\n&lt;/xml&gt;1', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('102', '1368798130', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368798138&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[jj]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5878943237535695029&lt;/MsgId&gt;\n&lt;/xml&gt;1', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('103', '1368798202', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368798210&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[we]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5878943546773340342&lt;/MsgId&gt;\n&lt;/xml&gt;1', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('104', '1368798211', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368798219&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[uu]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5878943585428046007&lt;/MsgId&gt;\n&lt;/xml&gt;1', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('105', '1368798862', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368798870&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[hh]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5878946381451755704&lt;/MsgId&gt;\n&lt;/xml&gt;1', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('106', '1368799107', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368799116&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[gg]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5878947438013710521&lt;/MsgId&gt;\n&lt;/xml&gt;1', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('107', '1368799165', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368799174&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[gg]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5878947687121813690&lt;/MsgId&gt;\n&lt;/xml&gt;1', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('108', '1368799174', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368799182&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[ff]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5878947721481552059&lt;/MsgId&gt;\n&lt;/xml&gt;1', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('109', '1368799207', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368799215&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[yu]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5878947863215472828&lt;/MsgId&gt;\n&lt;/xml&gt;1', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('110', '1368799244', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368799252&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[gg]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5878948022129262781&lt;/MsgId&gt;\n&lt;/xml&gt;1', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('111', '1368799272', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368799280&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[ff]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5878948142388347070&lt;/MsgId&gt;\n&lt;/xml&gt;1', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('112', '1368799928', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368799936&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[gg]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5878950959886893248&lt;/MsgId&gt;\n&lt;/xml&gt;1', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', 'login', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('113', '1368800243', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368800251&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[event]]&gt;&lt;/MsgType&gt;\n&lt;Event&gt;&lt;![CDATA[unsubscribe]]&gt;&lt;/Event&gt;\n&lt;EventKey&gt;&lt;![CDATA[]]&gt;&lt;/EventKey&gt;\n&lt;/xml&gt;', 'event', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', 'login', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('114', '1368800468', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368800476&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[event]]&gt;&lt;/MsgType&gt;\n&lt;Event&gt;&lt;![CDATA[subscribe]]&gt;&lt;/Event&gt;\n&lt;EventKey&gt;&lt;![CDATA[]]&gt;&lt;/EventKey&gt;\n&lt;/xml&gt;', 'event', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', 'login', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('115', '1368800639', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368800647&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[鍥颁簡]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5878954013608640706&lt;/MsgId&gt;\n&lt;/xml&gt;1', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', 'groupbuy', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('116', '1368800760', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368800768&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[event]]&gt;&lt;/MsgType&gt;\n&lt;Event&gt;&lt;![CDATA[unsubscribe]]&gt;&lt;/Event&gt;\n&lt;EventKey&gt;&lt;![CDATA[]]&gt;&lt;/EventKey&gt;\n&lt;/xml&gt;', 'event', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', 'groupbuy', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('117', '1368800788', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368800797&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[event]]&gt;&lt;/MsgType&gt;\n&lt;Event&gt;&lt;![CDATA[subscribe]]&gt;&lt;/Event&gt;\n&lt;EventKey&gt;&lt;![CDATA[]]&gt;&lt;/EventKey&gt;\n&lt;/xml&gt;', 'event', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', 'groupbuy', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('118', '1368801492', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368801500&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[鐪嬭?]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5878957677215744196&lt;/MsgId&gt;\n&lt;/xml&gt;1', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('119', '1368802898', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368802907&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[event]]&gt;&lt;/MsgType&gt;\n&lt;Event&gt;&lt;![CDATA[unsubscribe]]&gt;&lt;/Event&gt;\n&lt;EventKey&gt;&lt;![CDATA[]]&gt;&lt;/EventKey&gt;\n&lt;/xml&gt;', 'event', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('120', '1368803047', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368803056&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[event]]&gt;&lt;/MsgType&gt;\n&lt;Event&gt;&lt;![CDATA[subscribe]]&gt;&lt;/Event&gt;\n&lt;EventKey&gt;&lt;![CDATA[]]&gt;&lt;/EventKey&gt;\n&lt;/xml&gt;', 'event', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('121', '1368803178', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368803186&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[event]]&gt;&lt;/MsgType&gt;\n&lt;Event&gt;&lt;![CDATA[unsubscribe]]&gt;&lt;/Event&gt;\n&lt;EventKey&gt;&lt;![CDATA[]]&gt;&lt;/EventKey&gt;\n&lt;/xml&gt;', 'event', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('122', '1368803193', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368803201&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[event]]&gt;&lt;/MsgType&gt;\n&lt;Event&gt;&lt;![CDATA[subscribe]]&gt;&lt;/Event&gt;\n&lt;EventKey&gt;&lt;![CDATA[]]&gt;&lt;/EventKey&gt;\n&lt;/xml&gt;', 'event', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('123', '1368806692', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368806700&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[event]]&gt;&lt;/MsgType&gt;\n&lt;Event&gt;&lt;![CDATA[unsubscribe]]&gt;&lt;/Event&gt;\n&lt;EventKey&gt;&lt;![CDATA[]]&gt;&lt;/EventKey&gt;\n&lt;/xml&gt;', 'event', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('124', '1368806743', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368806751&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[event]]&gt;&lt;/MsgType&gt;\n&lt;Event&gt;&lt;![CDATA[subscribe]]&gt;&lt;/Event&gt;\n&lt;EventKey&gt;&lt;![CDATA[]]&gt;&lt;/EventKey&gt;\n&lt;/xml&gt;', 'event', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('125', '1368806932', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368806940&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[event]]&gt;&lt;/MsgType&gt;\n&lt;Event&gt;&lt;![CDATA[unsubscribe]]&gt;&lt;/Event&gt;\n&lt;EventKey&gt;&lt;![CDATA[]]&gt;&lt;/EventKey&gt;\n&lt;/xml&gt;', 'event', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('126', '1368806955', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368806963&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[event]]&gt;&lt;/MsgType&gt;\n&lt;Event&gt;&lt;![CDATA[subscribe]]&gt;&lt;/Event&gt;\n&lt;EventKey&gt;&lt;![CDATA[]]&gt;&lt;/EventKey&gt;\n&lt;/xml&gt;', 'event', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('127', '1368807123', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368807131&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[event]]&gt;&lt;/MsgType&gt;\n&lt;Event&gt;&lt;![CDATA[unsubscribe]]&gt;&lt;/Event&gt;\n&lt;EventKey&gt;&lt;![CDATA[]]&gt;&lt;/EventKey&gt;\n&lt;/xml&gt;', 'event', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('128', '1368807158', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368807166&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[event]]&gt;&lt;/MsgType&gt;\n&lt;Event&gt;&lt;![CDATA[subscribe]]&gt;&lt;/Event&gt;\n&lt;EventKey&gt;&lt;![CDATA[]]&gt;&lt;/EventKey&gt;\n&lt;/xml&gt;', 'event', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('129', '1368807257', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368807265&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[鍙?', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('130', '1368807807', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_0b4e4c24dc8b]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oJGqcjlfli2uWB8wiYRmZ8tiwlKQ]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368807815&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[:-P]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5878984800034218423&lt;/MsgId&gt;\n&lt;/xml&gt;1', 'text', 'oJGqcjlfli2uWB8wiYRmZ8tiwlKQ', 'gh_0b4e4c24dc8b', '', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('131', '1368808261', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368808270&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[绂诲紑]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5878986754144338125&lt;/MsgId&gt;\n&lt;/xml&gt;1', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('132', '1368814858', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368814866&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[鍛礭]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5879015083748622543&lt;/MsgId&gt;\n&lt;/xml&gt;1', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('133', '1368814932', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368814940&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[鍛靛懙]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5879015401576202449&lt;/MsgId&gt;\n&lt;/xml&gt;1', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('134', '1368815087', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_0b4e4c24dc8b]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oJGqcjlfli2uWB8wiYRmZ8tiwlKQ]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368815095&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[fsdafsdf]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5879016067396133305&lt;/MsgId&gt;\n&lt;/xml&gt;1', 'text', 'oJGqcjlfli2uWB8wiYRmZ8tiwlKQ', 'gh_0b4e4c24dc8b', '', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('135', '1368815112', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_0b4e4c24dc8b]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oJGqcjlfli2uWB8wiYRmZ8tiwlKQ]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368815120&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[fsdafsdf]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5879016174770315707&lt;/MsgId&gt;\n&lt;/xml&gt;1', 'text', 'oJGqcjlfli2uWB8wiYRmZ8tiwlKQ', 'gh_0b4e4c24dc8b', '', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('136', '1368816670', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368816678&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[tt]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5879022866229362899&lt;/MsgId&gt;\n&lt;/xml&gt;1', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('137', '1368816718', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368816726&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[ff]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5879023072387793108&lt;/MsgId&gt;\n&lt;/xml&gt;1', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('138', '1368817292', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368817300&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[ff]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5879025537699021014&lt;/MsgId&gt;\n&lt;/xml&gt;1', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('139', '1368817329', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368817337&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[tt]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5879025696612810967&lt;/MsgId&gt;\n&lt;/xml&gt;1', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('140', '1368817399', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368817408&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[rr]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5879026001555488984&lt;/MsgId&gt;\n&lt;/xml&gt;1', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('141', '1368817455', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368817464&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[ee]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5879026242073657561&lt;/MsgId&gt;\n&lt;/xml&gt;1', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('142', '1368817560', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368817568&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[ff]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5879026688750256346&lt;/MsgId&gt;\n&lt;/xml&gt;1', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('143', '1368817880', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368817889&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[ww]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5879028067434758363&lt;/MsgId&gt;\n&lt;/xml&gt;1', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', null, null);
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('144', '1368819606', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368819615&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[event]]&gt;&lt;/MsgType&gt;\n&lt;Event&gt;&lt;![CDATA[unsubscribe]]&gt;&lt;/Event&gt;\n&lt;EventKey&gt;&lt;![CDATA[]]&gt;&lt;/EventKey&gt;\n&lt;/xml&gt;', 'event', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', 'N;', 'kong');
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('145', '1368819924', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368819932&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[event]]&gt;&lt;/MsgType&gt;\n&lt;Event&gt;&lt;![CDATA[subscribe]]&gt;&lt;/Event&gt;\n&lt;EventKey&gt;&lt;![CDATA[]]&gt;&lt;/EventKey&gt;\n&lt;/xml&gt;', 'event', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', 'N;', 'kong');
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('146', '1368820020', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368820029&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[event]]&gt;&lt;/MsgType&gt;\n&lt;Event&gt;&lt;![CDATA[unsubscribe]]&gt;&lt;/Event&gt;\n&lt;EventKey&gt;&lt;![CDATA[]]&gt;&lt;/EventKey&gt;\n&lt;/xml&gt;', 'event', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', '', 'kong');
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('147', '1368820041', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368820049&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[event]]&gt;&lt;/MsgType&gt;\n&lt;Event&gt;&lt;![CDATA[subscribe]]&gt;&lt;/Event&gt;\n&lt;EventKey&gt;&lt;![CDATA[]]&gt;&lt;/EventKey&gt;\n&lt;/xml&gt;', 'event', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', '', 'kong');
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('148', '1368820143', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368820152&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[/::B]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5879037786945749214&lt;/MsgId&gt;\n&lt;/xml&gt;1', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', '', 'kong');
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('149', '1368822139', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368822148&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[dd]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5879046359700472031&lt;/MsgId&gt;\n&lt;/xml&gt;1', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', '', 'kong');
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('150', '1368822259', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368822268&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[e]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5879046875096547552&lt;/MsgId&gt;\n&lt;/xml&gt;1', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', '', 'kong');
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('151', '1368822406', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368822415&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[event]]&gt;&lt;/MsgType&gt;\n&lt;Event&gt;&lt;![CDATA[unsubscribe]]&gt;&lt;/Event&gt;\n&lt;EventKey&gt;&lt;![CDATA[]]&gt;&lt;/EventKey&gt;\n&lt;/xml&gt;', 'event', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', '', 'kong');
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('152', '1368822434', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368822443&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[event]]&gt;&lt;/MsgType&gt;\n&lt;Event&gt;&lt;![CDATA[subscribe]]&gt;&lt;/Event&gt;\n&lt;EventKey&gt;&lt;![CDATA[]]&gt;&lt;/EventKey&gt;\n&lt;/xml&gt;', 'event', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', '', 'kong');
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('153', '1368822464', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368822473&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[dd]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5879047755564843234&lt;/MsgId&gt;\n&lt;/xml&gt;1', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', '', 'kong');
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('154', '1368823686', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368823695&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[uy]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5879053004014878947&lt;/MsgId&gt;\n&lt;/xml&gt;1', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', 'a:4:{s:2:\"id\";s:13:\"wxq123:weixin\";s:9:\"signature\";s:40:\"91eeeb9c8d05e245e26c54b9e6138267b5042da8\";s:9:\"timestamp\";s:10:\"1368823695\";s:5:\"nonce\";s:10:\"1368494296\";}', 'kong');
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('155', '1368823748', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368823756&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[gf]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5879053266007884004&lt;/MsgId&gt;\n&lt;/xml&gt;1', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', 'a:4:{s:2:\"id\";s:13:\"wxq123:weixin\";s:9:\"signature\";s:40:\"12121f23d30c1fa0e4e941222ca87beba101ed2e\";s:9:\"timestamp\";s:10:\"1368823756\";s:5:\"nonce\";s:10:\"1369242532\";}', 'kong');
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('156', '1368824587', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368824596&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[event]]&gt;&lt;/MsgType&gt;\n&lt;Event&gt;&lt;![CDATA[unsubscribe]]&gt;&lt;/Event&gt;\n&lt;EventKey&gt;&lt;![CDATA[]]&gt;&lt;/EventKey&gt;\n&lt;/xml&gt;', 'event', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', 'a:4:{s:2:\"id\";s:13:\"wxq123:weixin\";s:9:\"signature\";s:40:\"ed75c5f54c7052dd5289027304f41655c48f8c59\";s:9:\"timestamp\";s:10:\"1368824596\";s:5:\"nonce\";s:10:\"1368839305\";}', 'kong');
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('157', '1368824611', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368824619&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[event]]&gt;&lt;/MsgType&gt;\n&lt;Event&gt;&lt;![CDATA[subscribe]]&gt;&lt;/Event&gt;\n&lt;EventKey&gt;&lt;![CDATA[]]&gt;&lt;/EventKey&gt;\n&lt;/xml&gt;', 'event', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', 'a:4:{s:2:\"id\";s:13:\"wxq123:weixin\";s:9:\"signature\";s:40:\"c3024dce8b1f802ab42da645779d4c700ac7a342\";s:9:\"timestamp\";s:10:\"1368824619\";s:5:\"nonce\";s:10:\"1369079080\";}', 'kong');
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('158', '1368824869', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1368824878&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[gf]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5879058084961190118&lt;/MsgId&gt;\n&lt;/xml&gt;1', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', 'a:4:{s:2:\"id\";s:13:\"wxq123:weixin\";s:9:\"signature\";s:40:\"c4efdc6ff6c1bd4a0f427caba623c3cb41dcb78d\";s:9:\"timestamp\";s:10:\"1368824878\";s:5:\"nonce\";s:10:\"1369390031\";}', 'kong');
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('159', '1369018607', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1369018619&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[鍟婂晩]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5879890196220084455&lt;/MsgId&gt;\n&lt;/xml&gt;1', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', 'a:4:{s:2:\"id\";s:13:\"wxq123:weixin\";s:9:\"signature\";s:40:\"4ea3aa17b9226a8bb2ba8e5e709e06ed687b7b8c\";s:9:\"timestamp\";s:10:\"1369018619\";s:5:\"nonce\";s:10:\"1368619677\";}', 'kong');
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('160', '1369120596', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1369120611&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[鍛靛懙]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5880328248524538088&lt;/MsgId&gt;\n&lt;/xml&gt;1', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', 'a:3:{s:9:\"signature\";s:40:\"d02afab3c7225ecd9729f6d03187148b9da62876\";s:9:\"timestamp\";s:10:\"1369120611\";s:5:\"nonce\";s:10:\"1369371897\";}', 'kong');
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('161', '1369120726', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1369120741&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[鍙?', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', 'a:3:{s:9:\"signature\";s:40:\"f537519352b2c0524a67d67a190c15c953e852f0\";s:9:\"timestamp\";s:10:\"1369120741\";s:5:\"nonce\";s:10:\"1368501698\";}', 'kong');
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('162', '1369407913', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1369407913&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[114]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5881562201218613482&lt;/MsgId&gt;\n&lt;/xml&gt;1', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', 'a:4:{s:3:\"sbm\";s:4:\"0502\";s:9:\"signature\";s:40:\"c220e37f265917b30b730b66de83e4f2004c3fa4\";s:9:\"timestamp\";s:10:\"1369407913\";s:5:\"nonce\";s:10:\"1369113872\";}', 'kong');
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('163', '1369408093', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1369408092&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[voice]]&gt;&lt;/MsgType&gt;\n&lt;MediaId&gt;&lt;![CDATA[8Kp00VTXjWD6In9BFYhKgLI8-1n1lQ6v6GXc-JWOS_4uPBG3MLZt8AXfai58YBwv]]&gt;&lt;/MediaId&gt;\n&lt;Format&gt;&lt;![CDATA[amr]]&gt;&lt;/Format&gt;\n&lt;MsgId&gt;5881562970017759467&lt;/MsgId&gt;\n&lt;/xml&gt;', 'voice', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', 'a:4:{s:3:\"sbm\";s:4:\"0502\";s:9:\"signature\";s:40:\"db0f460e133d2eef2d8f6671ad7b935fa1bd6788\";s:9:\"timestamp\";s:10:\"1369408092\";s:5:\"nonce\";s:10:\"1368552425\";}', 'kong');
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('164', '1369408148', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1369408147&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[image]]&gt;&lt;/MsgType&gt;\n&lt;PicUrl&gt;&lt;![CDATA[http://mmsns.qpic.cn/mmsns/gKRmRIXBphzTDhNN7BdhM1IJhlh912x2A1JKmcjZ4ibjWPn8boKxAUQ/0]]&gt;&lt;/PicUrl&gt;\n&lt;MsgId&gt;5881563206240960749&lt;/MsgId&gt;\n&lt;MediaId&gt;&lt;![CDATA[4iTB_IX8SWbLmjJfwpgprfPhVZJb0kbEmWzvuanVQiaP-9Pey_7OfvKy9K-rkruE]]&gt;&lt;/MediaId&gt;\n&lt;/xml&gt;1', 'image', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', 'a:4:{s:3:\"sbm\";s:4:\"0502\";s:9:\"signature\";s:40:\"6640f5e9b9431a496d0fed58072aeabcebf429d4\";s:9:\"timestamp\";s:10:\"1369408148\";s:5:\"nonce\";s:10:\"1369290916\";}', 'kong');
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('165', '1369408216', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1369408216&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[image]]&gt;&lt;/MsgType&gt;\n&lt;PicUrl&gt;&lt;![CDATA[http://mmsns.qpic.cn/mmsns/gKRmRIXBphzTDhNN7BdhM1IJhlh912x2FEibl5TeEQIk1TjS8AOOyhw/0]]&gt;&lt;/PicUrl&gt;\n&lt;MsgId&gt;5881563502593704174&lt;/MsgId&gt;\n&lt;MediaId&gt;&lt;![CDATA[gI2-hT3hNhK1eYkfJThRJKsTnW7sZiB5MI5-SO6DW6bfBbgbFhokU_KjwA6aJdeY]]&gt;&lt;/MediaId&gt;\n&lt;/xml&gt;1', 'image', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', 'a:4:{s:3:\"sbm\";s:4:\"0502\";s:9:\"signature\";s:40:\"f8272b652f151a5bff5971d07bccb1f3f0c7b601\";s:9:\"timestamp\";s:10:\"1369408216\";s:5:\"nonce\";s:10:\"1369115737\";}', 'kong');
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('166', '1369408232', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1369408232&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[voice]]&gt;&lt;/MsgType&gt;\n&lt;MediaId&gt;&lt;![CDATA[SqnfG2DMjJ64cwbwbxJtaoMweWcUvtub-FQbs9YVkFzXlm2XB4W_yk2E9yRVX0M2]]&gt;&lt;/MediaId&gt;\n&lt;Format&gt;&lt;![CDATA[amr]]&gt;&lt;/Format&gt;\n&lt;MsgId&gt;5881563571313180911&lt;/MsgId&gt;\n&lt;/xml&gt;', 'voice', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', 'a:4:{s:3:\"sbm\";s:4:\"0502\";s:9:\"signature\";s:40:\"b02a3fb5b526a14361e70e86539eeade9472fc78\";s:9:\"timestamp\";s:10:\"1369408232\";s:5:\"nonce\";s:10:\"1369138967\";}', 'kong');
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('167', '1369408296', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1369408296&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[ :114]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5881563846191087857&lt;/MsgId&gt;\n&lt;/xml&gt;1', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', 'a:4:{s:3:\"sbm\";s:4:\"0502\";s:9:\"signature\";s:40:\"0154591159091c117b93a2cadb48c57a263ac1ac\";s:9:\"timestamp\";s:10:\"1369408296\";s:5:\"nonce\";s:10:\"1368904555\";}', 'kong');
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('168', '1369408319', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1369408319&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[114/]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5881563944975335666&lt;/MsgId&gt;\n&lt;/xml&gt;1', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', 'a:4:{s:3:\"sbm\";s:4:\"0502\";s:9:\"signature\";s:40:\"8bae62a04f1a25eedfd9554711326570c1727ba5\";s:9:\"timestamp\";s:10:\"1369408319\";s:5:\"nonce\";s:10:\"1368582751\";}', 'kong');
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('169', '1369408365', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1369408365&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[http://www.wxq123.com]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5881564142543831283&lt;/MsgId&gt;\n&lt;/xml&gt;1', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', 'a:4:{s:3:\"sbm\";s:4:\"0502\";s:9:\"signature\";s:40:\"9b37f30123d46b405295a1ab70b6a06d6caafc05\";s:9:\"timestamp\";s:10:\"1369408365\";s:5:\"nonce\";s:10:\"1368594421\";}', 'kong');
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('170', '1369409327', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1369409327&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[鍥㈣喘銆俔]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5881568274302370036&lt;/MsgId&gt;\n&lt;/xml&gt;1', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', 'a:4:{s:3:\"sbm\";s:4:\"0502\";s:9:\"signature\";s:40:\"1cfbe55a470c07534c2c1f38ca185e7750664ef1\";s:9:\"timestamp\";s:10:\"1369409327\";s:5:\"nonce\";s:10:\"1369261194\";}', 'kong');
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('171', '1369409967', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1369409966&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[voice]]&gt;&lt;/MsgType&gt;\n&lt;MediaId&gt;&lt;![CDATA[V-PN0NNzj_vINhvVbpKkfyJExVGeI-PSvTg3ui4Fcb02Mdjz6kuTP5yBHqcqBY1R]]&gt;&lt;/MediaId&gt;\n&lt;Format&gt;&lt;![CDATA[amr]]&gt;&lt;/Format&gt;\n&lt;MsgId&gt;5881571018786472181&lt;/MsgId&gt;\n&lt;/xml&gt;', 'voice', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', 'a:4:{s:3:\"sbm\";s:4:\"0502\";s:9:\"signature\";s:40:\"a1263116fad0e2bc5c14ae4642dcb37cb9f33a21\";s:9:\"timestamp\";s:10:\"1369409966\";s:5:\"nonce\";s:10:\"1368602078\";}', 'kong');
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('172', '1369410171', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1369410171&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[璇曡瘯鐪嬨', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', 'a:4:{s:3:\"sbm\";s:4:\"0502\";s:9:\"signature\";s:40:\"26b879482acd19b10fd8e777979a22c62358808b\";s:9:\"timestamp\";s:10:\"1369410171\";s:5:\"nonce\";s:10:\"1369414930\";}', 'kong');
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('173', '1369410198', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1369410198&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[w]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5881572015218884856&lt;/MsgId&gt;\n&lt;/xml&gt;1', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', 'a:4:{s:3:\"sbm\";s:4:\"0502\";s:9:\"signature\";s:40:\"de348e79056f7087f971edf8fb9cba11edbb6029\";s:9:\"timestamp\";s:10:\"1369410198\";s:5:\"nonce\";s:10:\"1369344526\";}', 'kong');
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('174', '1369416887', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1369416887&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[event]]&gt;&lt;/MsgType&gt;\n&lt;Event&gt;&lt;![CDATA[unsubscribe]]&gt;&lt;/Event&gt;\n&lt;EventKey&gt;&lt;![CDATA[]]&gt;&lt;/EventKey&gt;\n&lt;/xml&gt;1', 'event', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', 'a:4:{s:3:\"sbm\";s:4:\"0502\";s:9:\"signature\";s:40:\"6bbbb4c23f467bf1584f20f60e26e22fc9495738\";s:9:\"timestamp\";s:10:\"1369416887\";s:5:\"nonce\";s:10:\"1368860750\";}', 'kong');
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('175', '1369416919', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1369416919&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[event]]&gt;&lt;/MsgType&gt;\n&lt;Event&gt;&lt;![CDATA[subscribe]]&gt;&lt;/Event&gt;\n&lt;EventKey&gt;&lt;![CDATA[]]&gt;&lt;/EventKey&gt;\n&lt;/xml&gt;1', 'event', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', 'a:4:{s:3:\"sbm\";s:4:\"0502\";s:9:\"signature\";s:40:\"f554b4a5f383f01455124a3a443783ec89f3a6bd\";s:9:\"timestamp\";s:10:\"1369416919\";s:5:\"nonce\";s:10:\"1369273157\";}', 'kong');
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('176', '1369449092', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1369449091&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[114]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5881739059381928185&lt;/MsgId&gt;\n&lt;/xml&gt;1', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', 'a:4:{s:3:\"sbm\";s:4:\"0502\";s:9:\"signature\";s:40:\"48d59bbde3e3cf96e060459e701f838d0a9ea9c9\";s:9:\"timestamp\";s:10:\"1369449091\";s:5:\"nonce\";s:10:\"1369872523\";}', 'kong');
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('177', '1369449130', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1369449130&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[/::~]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5881739226885652730&lt;/MsgId&gt;\n&lt;/xml&gt;1', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', 'a:4:{s:3:\"sbm\";s:4:\"0502\";s:9:\"signature\";s:40:\"7c6e648d1933e13f4be11ae49fc8815c959dcb95\";s:9:\"timestamp\";s:10:\"1369449130\";s:5:\"nonce\";s:10:\"1370257978\";}', 'kong');
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('178', '1369449170', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1369449170&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[g]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5881739398684344571&lt;/MsgId&gt;\n&lt;/xml&gt;1', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', 'a:4:{s:3:\"sbm\";s:4:\"0502\";s:9:\"signature\";s:40:\"7dd973fb771f0be81b93a21bfd9d4fe96058b1dc\";s:9:\"timestamp\";s:10:\"1369449170\";s:5:\"nonce\";s:10:\"1370060539\";}', 'kong');
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('179', '1369449203', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1369449203&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[j]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5881739540418265340&lt;/MsgId&gt;\n&lt;/xml&gt;1', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', 'a:4:{s:3:\"sbm\";s:4:\"0502\";s:9:\"signature\";s:40:\"c130465b66b299c59954e693b86fb157197eab87\";s:9:\"timestamp\";s:10:\"1369449203\";s:5:\"nonce\";s:10:\"1370402443\";}', 'kong');
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('180', '1369449244', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1369449245&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[u]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5881739720806891773&lt;/MsgId&gt;\n&lt;/xml&gt;1', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', 'a:4:{s:3:\"sbm\";s:4:\"0502\";s:9:\"signature\";s:40:\"e5922ffce0aa9b8cc528a3faaee69deec9d47025\";s:9:\"timestamp\";s:10:\"1369449245\";s:5:\"nonce\";s:10:\"1369481573\";}', 'kong');
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('181', '1369449308', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1369449309&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[y]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5881739995684798718&lt;/MsgId&gt;\n&lt;/xml&gt;1', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', 'a:4:{s:3:\"sbm\";s:4:\"0502\";s:9:\"signature\";s:40:\"d62fc51918cc6ccf864aa9fe841b8386c44dc4a6\";s:9:\"timestamp\";s:10:\"1369449309\";s:5:\"nonce\";s:10:\"1369593738\";}', 'kong');
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('182', '1369449330', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1369449330&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[u]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5881740085879111935&lt;/MsgId&gt;\n&lt;/xml&gt;1', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', 'a:4:{s:3:\"sbm\";s:4:\"0502\";s:9:\"signature\";s:40:\"c6df2c69b8e9fc2523030a74075033397c3f7574\";s:9:\"timestamp\";s:10:\"1369449330\";s:5:\"nonce\";s:10:\"1370333552\";}', 'kong');
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('183', '1369449535', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1369449535&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[/::|]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5881740966347407616&lt;/MsgId&gt;\n&lt;/xml&gt;1', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', 'a:4:{s:3:\"sbm\";s:4:\"0502\";s:9:\"signature\";s:40:\"66eca53530b56506a6b1d648744c4183370033bb\";s:9:\"timestamp\";s:10:\"1369449535\";s:5:\"nonce\";s:10:\"1370191455\";}', 'kong');
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('184', '1369449568', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1369449568&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[z]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5881741108081328385&lt;/MsgId&gt;\n&lt;/xml&gt;1', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', 'a:4:{s:3:\"sbm\";s:4:\"0502\";s:9:\"signature\";s:40:\"f485700a3fab95fec5dc105b7a75b284cadde5bb\";s:9:\"timestamp\";s:10:\"1369449568\";s:5:\"nonce\";s:10:\"1370239099\";}', 'kong');
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('185', '1369449597', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1369449597&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[g]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5881741232635379970&lt;/MsgId&gt;\n&lt;/xml&gt;1', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', 'a:4:{s:3:\"sbm\";s:4:\"0502\";s:9:\"signature\";s:40:\"aac0984554194a89ff843607cc9b496d19ccadf0\";s:9:\"timestamp\";s:10:\"1369449597\";s:5:\"nonce\";s:10:\"1370208024\";}', 'kong');
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('186', '1369449635', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1369449636&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[t]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5881741400139104516&lt;/MsgId&gt;\n&lt;/xml&gt;1', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', 'a:4:{s:3:\"sbm\";s:4:\"0502\";s:9:\"signature\";s:40:\"50e1fade284cb247febce14c6ed3e20fefd4304b\";s:9:\"timestamp\";s:10:\"1369449636\";s:5:\"nonce\";s:10:\"1369514650\";}', 'kong');
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('187', '1369449691', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1369449692&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[t]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5881741640657273094&lt;/MsgId&gt;\n&lt;/xml&gt;1', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', 'a:4:{s:3:\"sbm\";s:4:\"0502\";s:9:\"signature\";s:40:\"550e28d276a3b44bc35c104b8eacea81b4e8c198\";s:9:\"timestamp\";s:10:\"1369449692\";s:5:\"nonce\";s:10:\"1369609165\";}', 'kong');
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('188', '1369449735', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1369449735&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[y]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5881741825340866823&lt;/MsgId&gt;\n&lt;/xml&gt;1', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', 'a:4:{s:3:\"sbm\";s:4:\"0502\";s:9:\"signature\";s:40:\"2e77fb25eb85d28e5670617cc6c60368d9563587\";s:9:\"timestamp\";s:10:\"1369449735\";s:5:\"nonce\";s:10:\"1369782418\";}', 'kong');
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('189', '1369449760', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1369449760&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[r]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5881741932715049224&lt;/MsgId&gt;\n&lt;/xml&gt;1', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', 'a:4:{s:3:\"sbm\";s:4:\"0502\";s:9:\"signature\";s:40:\"1c9173a710e8e1dc7447e316c56c7866561310b0\";s:9:\"timestamp\";s:10:\"1369449760\";s:5:\"nonce\";s:10:\"1369839087\";}', 'kong');
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('190', '1369449817', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1369449817&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[y]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5881742177528185097&lt;/MsgId&gt;\n&lt;/xml&gt;1', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', 'a:4:{s:3:\"sbm\";s:4:\"0502\";s:9:\"signature\";s:40:\"6a385d6549dfbae6ea0060c60315da4a4fffd55f\";s:9:\"timestamp\";s:10:\"1369449817\";s:5:\"nonce\";s:10:\"1369797181\";}', 'kong');
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('191', '1369450005', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1369450005&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[g]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5881742984982036746&lt;/MsgId&gt;\n&lt;/xml&gt;1', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', 'a:4:{s:3:\"sbm\";s:4:\"0502\";s:9:\"signature\";s:40:\"e58582fa8536124995e125a7dde2aa042ed583a9\";s:9:\"timestamp\";s:10:\"1369450005\";s:5:\"nonce\";s:10:\"1370278242\";}', 'kong');
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('192', '1369450053', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1369450053&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[a]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5881743191140466955&lt;/MsgId&gt;\n&lt;/xml&gt;1', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', 'a:4:{s:3:\"sbm\";s:4:\"0502\";s:9:\"signature\";s:40:\"f0d654fe5ae8c9532c9a615f0142da952ae5b9eb\";s:9:\"timestamp\";s:10:\"1369450053\";s:5:\"nonce\";s:10:\"1369717653\";}', 'kong');
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('193', '1369450083', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1369450083&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[f]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5881743319989485837&lt;/MsgId&gt;\n&lt;/xml&gt;1', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', 'a:4:{s:3:\"sbm\";s:4:\"0502\";s:9:\"signature\";s:40:\"9256dd0d44476bcd9ce2d1c11def601b6a6ecfc8\";s:9:\"timestamp\";s:10:\"1369450083\";s:5:\"nonce\";s:10:\"1369845271\";}', 'kong');
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('194', '1369450165', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1369450165&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[f]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5881743672176804111&lt;/MsgId&gt;\n&lt;/xml&gt;1', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', 'a:4:{s:3:\"sbm\";s:4:\"0502\";s:9:\"signature\";s:40:\"c530f1051278cd80c6ae65968ad6ff873fe13630\";s:9:\"timestamp\";s:10:\"1369450165\";s:5:\"nonce\";s:10:\"1369990398\";}', 'kong');
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('195', '1369450264', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1369450262&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[d]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5881744088788631824&lt;/MsgId&gt;\n&lt;/xml&gt;1', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', 'a:4:{s:3:\"sbm\";s:4:\"0502\";s:9:\"signature\";s:40:\"e5c9d39eae7ae9c150946b17cacf1916d762c93f\";s:9:\"timestamp\";s:10:\"1369450262\";s:5:\"nonce\";s:10:\"1370143970\";}', 'kong');
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('196', '1369450333', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1369450334&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[g]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5881744398026277137&lt;/MsgId&gt;\n&lt;/xml&gt;1', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', 'a:4:{s:3:\"sbm\";s:4:\"0502\";s:9:\"signature\";s:40:\"3558324505c84a8d4697717ea5e07a0e7f196033\";s:9:\"timestamp\";s:10:\"1369450334\";s:5:\"nonce\";s:10:\"1369563462\";}', 'kong');
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('197', '1369450410', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1369450410&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[y]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5881744724443791635&lt;/MsgId&gt;\n&lt;/xml&gt;1', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', 'a:4:{s:3:\"sbm\";s:4:\"0502\";s:9:\"signature\";s:40:\"be6dab4b62450f46ff8d969b4fe252151463dfb0\";s:9:\"timestamp\";s:10:\"1369450410\";s:5:\"nonce\";s:10:\"1370101854\";}', 'kong');
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('198', '1369450428', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1369450428&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[g]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5881744801753202965&lt;/MsgId&gt;\n&lt;/xml&gt;1', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', 'a:4:{s:3:\"sbm\";s:4:\"0502\";s:9:\"signature\";s:40:\"e322cc2efb56ac29cdf1f695cbc63e7bfc959232\";s:9:\"timestamp\";s:10:\"1369450428\";s:5:\"nonce\";s:10:\"1370223948\";}', 'kong');
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('199', '1369451285', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1369451285&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[鎶奭]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5881748482540175638&lt;/MsgId&gt;\n&lt;/xml&gt;1', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', 'a:4:{s:3:\"sbm\";s:4:\"0502\";s:9:\"signature\";s:40:\"9afe3af43b9e5d6fbc02d2b4a443e4e25632ae27\";s:9:\"timestamp\";s:10:\"1369451285\";s:5:\"nonce\";s:10:\"1370200689\";}', 'kong');
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('200', '1369451286', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1369451286&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[浠朷]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5881748486835142935&lt;/MsgId&gt;\n&lt;/xml&gt;1', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', 'a:4:{s:3:\"sbm\";s:4:\"0502\";s:9:\"signature\";s:40:\"d878b15884176a9794173c2d35374b8cd556ff2b\";s:9:\"timestamp\";s:10:\"1369451286\";s:5:\"nonce\";s:10:\"1370276348\";}', 'kong');
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('201', '1369451320', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1369451320&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[绂籡]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5881748632864031002&lt;/MsgId&gt;\n&lt;/xml&gt;1', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', 'a:4:{s:3:\"sbm\";s:4:\"0502\";s:9:\"signature\";s:40:\"15d143a05ab29310ca47b076bfc700207bec817d\";s:9:\"timestamp\";s:10:\"1369451320\";s:5:\"nonce\";s:10:\"1369819055\";}', 'kong');
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('202', '1369451446', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1369451446&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[鎶奭]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5881749174029910300&lt;/MsgId&gt;\n&lt;/xml&gt;1', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', 'a:4:{s:3:\"sbm\";s:4:\"0502\";s:9:\"signature\";s:40:\"643e477243d2bf544a96aad2ea91da94197c7324\";s:9:\"timestamp\";s:10:\"1369451446\";s:5:\"nonce\";s:10:\"1370221922\";}', 'kong');
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('203', '1369451507', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1369451508&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[鎶奭]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5881749440317882653&lt;/MsgId&gt;\n&lt;/xml&gt;1', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', 'a:4:{s:3:\"sbm\";s:4:\"0502\";s:9:\"signature\";s:40:\"7040dd9ab2933f0a9566aec7ad6700989cd300c4\";s:9:\"timestamp\";s:10:\"1369451508\";s:5:\"nonce\";s:10:\"1369592989\";}', 'kong');
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('204', '1369451541', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1369451541&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[鎶奭]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5881749582051803422&lt;/MsgId&gt;\n&lt;/xml&gt;1', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', 'a:4:{s:3:\"sbm\";s:4:\"0502\";s:9:\"signature\";s:40:\"1bae2e43c9d3e1c52158dcfdd889e6878af67664\";s:9:\"timestamp\";s:10:\"1369451541\";s:5:\"nonce\";s:10:\"1369994663\";}', 'kong');
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('205', '1369451584', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1369451585&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[鐨刔]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5881749771030364447&lt;/MsgId&gt;\n&lt;/xml&gt;1', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', 'a:4:{s:3:\"sbm\";s:4:\"0502\";s:9:\"signature\";s:40:\"6144824df11c1e17ad3afa8412a083efcbf27a9e\";s:9:\"timestamp\";s:10:\"1369451585\";s:5:\"nonce\";s:10:\"1369622216\";}', 'kong');
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('206', '1369451607', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1369451608&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[鐨刔]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5881749869814612257&lt;/MsgId&gt;\n&lt;/xml&gt;1', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', 'a:4:{s:3:\"sbm\";s:4:\"0502\";s:9:\"signature\";s:40:\"699ca9dea96782e526147372acdee32a968eced8\";s:9:\"timestamp\";s:10:\"1369451608\";s:5:\"nonce\";s:10:\"1369793914\";}', 'kong');
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('207', '1369451635', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1369451635&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[鑰僝]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5881749985778729251&lt;/MsgId&gt;\n&lt;/xml&gt;1', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', 'a:4:{s:3:\"sbm\";s:4:\"0502\";s:9:\"signature\";s:40:\"db1ff913df72c87bb2a72127c7aac2940d76c169\";s:9:\"timestamp\";s:10:\"1369451635\";s:5:\"nonce\";s:10:\"1370352404\";}', 'kong');
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('208', '1369451661', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1369451661&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[鍛礭]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5881750097447878949&lt;/MsgId&gt;\n&lt;/xml&gt;1', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', 'a:4:{s:3:\"sbm\";s:4:\"0502\";s:9:\"signature\";s:40:\"9f1edf6f2d35b465178b58243d960186e831115d\";s:9:\"timestamp\";s:10:\"1369451661\";s:5:\"nonce\";s:10:\"1369837304\";}', 'kong');
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('209', '1369451689', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1369451689&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[瀵筣]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5881750217706963239&lt;/MsgId&gt;\n&lt;/xml&gt;1', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', 'a:4:{s:3:\"sbm\";s:4:\"0502\";s:9:\"signature\";s:40:\"45c88ffdb6cdd227f3e128415f3a06ecce37c63b\";s:9:\"timestamp\";s:10:\"1369451689\";s:5:\"nonce\";s:10:\"1369923546\";}', 'kong');
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('210', '1369451749', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1369451749&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[浜哴]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5881750475405001001&lt;/MsgId&gt;\n&lt;/xml&gt;1', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', 'a:4:{s:3:\"sbm\";s:4:\"0502\";s:9:\"signature\";s:40:\"d420637ea17d84d88600bdd0301db71e191f88ee\";s:9:\"timestamp\";s:10:\"1369451749\";s:5:\"nonce\";s:10:\"1369933801\";}', 'kong');
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('211', '1369451790', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1369451790&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[鍦焆]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5881750651498660139&lt;/MsgId&gt;\n&lt;/xml&gt;1', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', 'a:4:{s:3:\"sbm\";s:4:\"0502\";s:9:\"signature\";s:40:\"97172ff76afb672684ac20d712b9a58de901ad9f\";s:9:\"timestamp\";s:10:\"1369451790\";s:5:\"nonce\";s:10:\"1370368526\";}', 'kong');
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('212', '1369451980', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1369451980&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[鍥颁簡]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5881751467542446381&lt;/MsgId&gt;\n&lt;/xml&gt;1', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', 'a:4:{s:3:\"sbm\";s:4:\"0502\";s:9:\"signature\";s:40:\"75d63c6dab6694541c32044e93db69a61bc44b42\";s:9:\"timestamp\";s:10:\"1369451980\";s:5:\"nonce\";s:10:\"1370411249\";}', 'kong');
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('213', '1369452065', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1369452066&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[鍛礭]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5881751836909633839&lt;/MsgId&gt;\n&lt;/xml&gt;1', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', 'a:4:{s:3:\"sbm\";s:4:\"0502\";s:9:\"signature\";s:40:\"cde6512dad008d60e6209af8672f6ec16c13919c\";s:9:\"timestamp\";s:10:\"1369452066\";s:5:\"nonce\";s:10:\"1369529057\";}', 'kong');
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('214', '1369452169', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1369452169&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[浣燷]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5881752279291265328&lt;/MsgId&gt;\n&lt;/xml&gt;1', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', 'a:4:{s:3:\"sbm\";s:4:\"0502\";s:9:\"signature\";s:40:\"ae6e1b4042a941556bd3afdd5ec0ecf6c1fb3dd8\";s:9:\"timestamp\";s:10:\"1369452169\";s:5:\"nonce\";s:10:\"1369885200\";}', 'kong');
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('215', '1369452196', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1369452196&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[鍝?]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5881752395255382321&lt;/MsgId&gt;\n&lt;/xml&gt;1', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', 'a:4:{s:3:\"sbm\";s:4:\"0502\";s:9:\"signature\";s:40:\"5a5e2da541c182ffb7391a75bf7ab4fdee5e6fc5\";s:9:\"timestamp\";s:10:\"1369452196\";s:5:\"nonce\";s:10:\"1369610198\";}', 'kong');
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('216', '1369452245', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1369452245&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[鍝?]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5881752605708779826&lt;/MsgId&gt;\n&lt;/xml&gt;1', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', 'a:4:{s:3:\"sbm\";s:4:\"0502\";s:9:\"signature\";s:40:\"2ed64764a7061956b6c4e0de5eb919a35817ffa4\";s:9:\"timestamp\";s:10:\"1369452245\";s:5:\"nonce\";s:10:\"1370420217\";}', 'kong');
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('217', '1369452289', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1369452289&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[鍦╙]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5881752794687340851&lt;/MsgId&gt;\n&lt;/xml&gt;1', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', 'a:4:{s:3:\"sbm\";s:4:\"0502\";s:9:\"signature\";s:40:\"1f8a0d94d83b2a080bd76dfe37c2b657d8a8adca\";s:9:\"timestamp\";s:10:\"1369452289\";s:5:\"nonce\";s:10:\"1370332049\";}', 'kong');
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('218', '1369452324', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1369452324&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[绂籡]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5881752945011196213&lt;/MsgId&gt;\n&lt;/xml&gt;1', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', 'a:4:{s:3:\"sbm\";s:4:\"0502\";s:9:\"signature\";s:40:\"b71dcb7d9a32350334d7fd7bf68fcd8ac58929ea\";s:9:\"timestamp\";s:10:\"1369452324\";s:5:\"nonce\";s:10:\"1370047885\";}', 'kong');
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('219', '1369452394', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1369452394&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[鍛礭]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5881753245658906934&lt;/MsgId&gt;\n&lt;/xml&gt;1', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', 'a:4:{s:3:\"sbm\";s:4:\"0502\";s:9:\"signature\";s:40:\"1498ded919df9b72a1e0bc660321e56212d4fb71\";s:9:\"timestamp\";s:10:\"1369452394\";s:5:\"nonce\";s:10:\"1370112495\";}', 'kong');
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('220', '1369452415', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1369452416&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[鍥颁簡]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5881753340148187447&lt;/MsgId&gt;\n&lt;/xml&gt;1', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', 'a:4:{s:3:\"sbm\";s:4:\"0502\";s:9:\"signature\";s:40:\"ad55fc3c4aa9b400946c5207272a962dd95543d3\";s:9:\"timestamp\";s:10:\"1369452416\";s:5:\"nonce\";s:10:\"1369743008\";}', 'kong');
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('221', '1369452483', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1369452484&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[绂籡]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5881753632205963577&lt;/MsgId&gt;\n&lt;/xml&gt;1', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', 'a:4:{s:3:\"sbm\";s:4:\"0502\";s:9:\"signature\";s:40:\"dd07dfc324cffc2d17a5c044850bd2fcbf57ea42\";s:9:\"timestamp\";s:10:\"1369452484\";s:5:\"nonce\";s:10:\"1369655494\";}', 'kong');
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('222', '1369452541', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1369452541&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[浜哴]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5881753877019099451&lt;/MsgId&gt;\n&lt;/xml&gt;1', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', 'a:4:{s:3:\"sbm\";s:4:\"0502\";s:9:\"signature\";s:40:\"07bed72c27837b6a218329c0fc7e6500031301e9\";s:9:\"timestamp\";s:10:\"1369452541\";s:5:\"nonce\";s:10:\"1370422004\";}', 'kong');
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('223', '1369452583', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1369452583&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[鍜宂]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5881754057407725885&lt;/MsgId&gt;\n&lt;/xml&gt;1', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', 'a:4:{s:3:\"sbm\";s:4:\"0502\";s:9:\"signature\";s:40:\"16d3f21242b9cc9b972ffa7f608b44b9946c6a3e\";s:9:\"timestamp\";s:10:\"1369452583\";s:5:\"nonce\";s:10:\"1369715015\";}', 'kong');
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('224', '1369452779', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1369452780&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[鑰僝]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5881754903516283199&lt;/MsgId&gt;\n&lt;/xml&gt;1', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', 'a:4:{s:3:\"sbm\";s:4:\"0502\";s:9:\"signature\";s:40:\"7e03028cf123e39bc2867a909a9abc548d6609af\";s:9:\"timestamp\";s:10:\"1369452780\";s:5:\"nonce\";s:10:\"1369474562\";}', 'kong');
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('225', '1369452819', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1369452820&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[鍝?]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5881755075314975041&lt;/MsgId&gt;\n&lt;/xml&gt;1', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', 'a:4:{s:3:\"sbm\";s:4:\"0502\";s:9:\"signature\";s:40:\"1a7040a2117a13fb93b96de710daa9f9c3589388\";s:9:\"timestamp\";s:10:\"1369452820\";s:5:\"nonce\";s:10:\"1369506295\";}', 'kong');
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('226', '1369452846', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1369452846&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[閲宂]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5881755186984124739&lt;/MsgId&gt;\n&lt;/xml&gt;1', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', 'a:4:{s:3:\"sbm\";s:4:\"0502\";s:9:\"signature\";s:40:\"1424922a9091f0ac2b5d5c37f0eb22c365255fd0\";s:9:\"timestamp\";s:10:\"1369452846\";s:5:\"nonce\";s:10:\"1370377429\";}', 'kong');
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('227', '1369452878', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1369452878&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[閲宂]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5881755324423078212&lt;/MsgId&gt;\n&lt;/xml&gt;1', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', 'a:4:{s:3:\"sbm\";s:4:\"0502\";s:9:\"signature\";s:40:\"c7a758e18e887e8ebdf2ce87f8d300db2e2be656\";s:9:\"timestamp\";s:10:\"1369452878\";s:5:\"nonce\";s:10:\"1370391844\";}', 'kong');
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('228', '1369452918', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1369452919&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[绂籡]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5881755500516737349&lt;/MsgId&gt;\n&lt;/xml&gt;1', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', 'a:4:{s:3:\"sbm\";s:4:\"0502\";s:9:\"signature\";s:40:\"eb169ea2c9b1888d7ca979cb37ec97fc16048b22\";s:9:\"timestamp\";s:10:\"1369452919\";s:5:\"nonce\";s:10:\"1369464227\";}', 'kong');
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('229', '1369453054', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1369453055&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[閲宂]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5881756084632289606&lt;/MsgId&gt;\n&lt;/xml&gt;1', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', 'a:4:{s:3:\"sbm\";s:4:\"0502\";s:9:\"signature\";s:40:\"a8ad8243f2640c4f41cf7ce5ee2498a9b98a1b43\";s:9:\"timestamp\";s:10:\"1369453055\";s:5:\"nonce\";s:10:\"1369442042\";}', 'kong');
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('230', '1369453093', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1369453094&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[鍝?]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5881756252136014151&lt;/MsgId&gt;\n&lt;/xml&gt;1', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', 'a:4:{s:3:\"sbm\";s:4:\"0502\";s:9:\"signature\";s:40:\"daaf306a05a3d2779b6b600baa2542542716385d\";s:9:\"timestamp\";s:10:\"1369453094\";s:5:\"nonce\";s:10:\"1369610401\";}', 'kong');
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('231', '1369453174', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1369453174&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[鑰僝]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5881756595733397832&lt;/MsgId&gt;\n&lt;/xml&gt;1', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', 'a:4:{s:3:\"sbm\";s:4:\"0502\";s:9:\"signature\";s:40:\"209d12e84bb9c3f8258d506bd05746127a22fd13\";s:9:\"timestamp\";s:10:\"1369453174\";s:5:\"nonce\";s:10:\"1370217892\";}', 'kong');
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('232', '1369453624', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1369453624&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[绂籡]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5881758528468681034&lt;/MsgId&gt;\n&lt;/xml&gt;1', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', 'a:4:{s:3:\"sbm\";s:4:\"0502\";s:9:\"signature\";s:40:\"6c51423996f542f9b29509d1e62e91f2d276767d\";s:9:\"timestamp\";s:10:\"1369453624\";s:5:\"nonce\";s:10:\"1369687690\";}', 'kong');
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('233', '1369453654', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1369453655&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[鎯砞]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5881758661612667212&lt;/MsgId&gt;\n&lt;/xml&gt;1', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', 'a:4:{s:3:\"sbm\";s:4:\"0502\";s:9:\"signature\";s:40:\"717fb7fc7d4c370fa42dc7cc526621116f5e3c86\";s:9:\"timestamp\";s:10:\"1369453655\";s:5:\"nonce\";s:10:\"1369513527\";}', 'kong');
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('234', '1369453845', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1369453845&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[鍒癩]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5881759477656453455&lt;/MsgId&gt;\n&lt;/xml&gt;1', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', 'a:4:{s:3:\"sbm\";s:4:\"0502\";s:9:\"signature\";s:40:\"ebfb55309b7d8380e9fe92c6040a00fc610d5ff1\";s:9:\"timestamp\";s:10:\"1369453845\";s:5:\"nonce\";s:10:\"1370236646\";}', 'kong');
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('235', '1369453912', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1369453912&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[娌?]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5881759765419262289&lt;/MsgId&gt;\n&lt;/xml&gt;1', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', 'a:4:{s:3:\"sbm\";s:4:\"0502\";s:9:\"signature\";s:40:\"a02caeaced28a7e82484ab244c7d055a879d7891\";s:9:\"timestamp\";s:10:\"1369453912\";s:5:\"nonce\";s:10:\"1370212186\";}', 'kong');
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('236', '1369453977', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1369453977&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[鍒癩]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5881760044592136531&lt;/MsgId&gt;\n&lt;/xml&gt;1', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', 'a:4:{s:3:\"sbm\";s:4:\"0502\";s:9:\"signature\";s:40:\"9ba0683a78eaa54c214f677378ad133b52a11944\";s:9:\"timestamp\";s:10:\"1369453977\";s:5:\"nonce\";s:10:\"1370046897\";}', 'kong');
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('237', '1369454013', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1369454013&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[浣燷]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5881760199210959189&lt;/MsgId&gt;\n&lt;/xml&gt;1', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', 'a:4:{s:3:\"sbm\";s:4:\"0502\";s:9:\"signature\";s:40:\"8addf2a54a9733623afa953e9d0bee009c900284\";s:9:\"timestamp\";s:10:\"1369454013\";s:5:\"nonce\";s:10:\"1369852816\";}', 'kong');
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('238', '1369454155', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1369454155&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[鑰僝]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5881760809096315223&lt;/MsgId&gt;\n&lt;/xml&gt;1', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', 'a:4:{s:3:\"sbm\";s:4:\"0502\";s:9:\"signature\";s:40:\"04fc9ee5f041116c8c0ff2334770c3a2f0da97dc\";s:9:\"timestamp\";s:10:\"1369454155\";s:5:\"nonce\";s:10:\"1370335991\";}', 'kong');
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('239', '1369454351', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1369454352&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[閲宂]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5881761655204872536&lt;/MsgId&gt;\n&lt;/xml&gt;1', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', 'a:4:{s:3:\"sbm\";s:4:\"0502\";s:9:\"signature\";s:40:\"3aa4e1c9b0421221f404bcf33153269eca7334f1\";s:9:\"timestamp\";s:10:\"1369454352\";s:5:\"nonce\";s:10:\"1369551241\";}', 'kong');
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('240', '1369456274', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1369456274&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[绂籡]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5881769910132015449&lt;/MsgId&gt;\n&lt;/xml&gt;1', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', 'a:4:{s:3:\"sbm\";s:4:\"0502\";s:9:\"signature\";s:40:\"ac0134d7610b65f5ee8d06e536410ed2493cc386\";s:9:\"timestamp\";s:10:\"1369456274\";s:5:\"nonce\";s:10:\"1369640575\";}', 'kong');
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('241', '1369456352', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1369456352&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[鑰僝]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5881770245139464538&lt;/MsgId&gt;\n&lt;/xml&gt;1', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', 'a:4:{s:3:\"sbm\";s:4:\"0502\";s:9:\"signature\";s:40:\"723c14266e66c745a9ce17ee248af56c5476b1e9\";s:9:\"timestamp\";s:10:\"1369456352\";s:5:\"nonce\";s:10:\"1370166272\";}', 'kong');
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('242', '1369456754', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1369456754&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[锛焆]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5881771971716317535&lt;/MsgId&gt;\n&lt;/xml&gt;1', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', 'a:4:{s:3:\"sbm\";s:4:\"0502\";s:9:\"signature\";s:40:\"49ec4957ecdb68c71578666217c15a23d9cb19a1\";s:9:\"timestamp\";s:10:\"1369456754\";s:5:\"nonce\";s:10:\"1369904753\";}', 'kong');
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('243', '1369456770', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1369456771&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[鍖梋]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5881772044730761568&lt;/MsgId&gt;\n&lt;/xml&gt;1', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', 'a:4:{s:3:\"sbm\";s:4:\"0502\";s:9:\"signature\";s:40:\"56e23571e4f4fff47ab3b3d1e81dda3067d5bb66\";s:9:\"timestamp\";s:10:\"1369456771\";s:5:\"nonce\";s:10:\"1369520064\";}', 'kong');
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('244', '1369456786', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1369456786&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[鍛?]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5881772109155271009&lt;/MsgId&gt;\n&lt;/xml&gt;1', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', 'a:4:{s:3:\"sbm\";s:4:\"0502\";s:9:\"signature\";s:40:\"fc68a5180abc3b095395a9d805bee8896d167cb2\";s:9:\"timestamp\";s:10:\"1369456786\";s:5:\"nonce\";s:10:\"1369937591\";}', 'kong');
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('245', '1369456823', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1369456823&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[閲宂]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5881772268069060963&lt;/MsgId&gt;\n&lt;/xml&gt;1', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', 'a:4:{s:3:\"sbm\";s:4:\"0502\";s:9:\"signature\";s:40:\"d22ab4cb914eb67e83a783f689e3b5201b2133a5\";s:9:\"timestamp\";s:10:\"1369456823\";s:5:\"nonce\";s:10:\"1369924139\";}', 'kong');
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('246', '1369456994', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1369456995&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[鍝﹀摝]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5881773006803435876&lt;/MsgId&gt;\n&lt;/xml&gt;1', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', 'a:4:{s:3:\"sbm\";s:4:\"0502\";s:9:\"signature\";s:40:\"13fecfc94ce5b85c13dfdc38da288490c066e870\";s:9:\"timestamp\";s:10:\"1369456995\";s:5:\"nonce\";s:10:\"1369708522\";}', 'kong');
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('247', '1369973530', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1369973537&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[鍥颁簡]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5883991537800446310&lt;/MsgId&gt;\n&lt;/xml&gt;1', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', 'a:4:{s:3:\"sbm\";s:4:\"0502\";s:9:\"signature\";s:40:\"94d2994c7fb9768041ffed07cc36fc02a33493e0\";s:9:\"timestamp\";s:10:\"1369973537\";s:5:\"nonce\";s:10:\"1369671832\";}', 'kong');
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('248', '1370064198', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1370064207&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[鍥颁簡]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5884380962485174631&lt;/MsgId&gt;\n&lt;/xml&gt;1', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', 'a:4:{s:3:\"sbm\";s:4:\"0502\";s:9:\"signature\";s:40:\"7628a6bc11332013e33def67f62c30cbfeb33de8\";s:9:\"timestamp\";s:10:\"1370064207\";s:5:\"nonce\";s:10:\"1369671879\";}', 'kong');
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('249', '1370193624', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1370193623&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[鍥颁簡]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5884936799972753768&lt;/MsgId&gt;\n&lt;/xml&gt;1', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', 'a:4:{s:3:\"sbm\";s:4:\"0502\";s:9:\"signature\";s:40:\"3776c578176178246ec264cce9acc6cc666b72ea\";s:9:\"timestamp\";s:10:\"1370193623\";s:5:\"nonce\";s:10:\"1369465615\";}', 'kong');
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('250', '1370310961', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1370310962&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[鍝﹀摝]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5885440767140299113&lt;/MsgId&gt;\n&lt;/xml&gt;1', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', 'a:4:{s:3:\"sbm\";s:4:\"0502\";s:9:\"signature\";s:40:\"ad793f46b513cdaea04b66a3e4f33ad2f22856b8\";s:9:\"timestamp\";s:10:\"1370310962\";s:5:\"nonce\";s:10:\"1369522711\";}', 'kong');
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('251', '1370578373', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1370578371&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[閮戝窞]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5886589280049955178&lt;/MsgId&gt;\n&lt;/xml&gt;1', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', 'a:4:{s:3:\"sbm\";s:4:\"0502\";s:9:\"signature\";s:40:\"5270531cb11a4d52ab82d65f50f3d95437573021\";s:9:\"timestamp\";s:10:\"1370578371\";s:5:\"nonce\";s:10:\"1370541346\";}', 'kong');
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('252', '1370778459', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjokaBzp2TzVw_Mz9X98BPQk]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1370778432&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[event]]&gt;&lt;/MsgType&gt;\n&lt;Event&gt;&lt;![CDATA[subscribe]]&gt;&lt;/Event&gt;\n&lt;EventKey&gt;&lt;![CDATA[]]&gt;&lt;/EventKey&gt;\n&lt;/xml&gt;1', 'event', 'oCHHbjokaBzp2TzVw_Mz9X98BPQk', 'gh_46cfe935a631', '', 'a:4:{s:3:\"sbm\";s:4:\"0502\";s:9:\"signature\";s:40:\"33d9e42138468bf1f3187995c67038e482b8d26a\";s:9:\"timestamp\";s:10:\"1370778432\";s:5:\"nonce\";s:10:\"1371051976\";}', 'kong');
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('253', '1371143490', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjpVDHTddEOH-WsK1ox-gPE8]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1371143452&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[event]]&gt;&lt;/MsgType&gt;\n&lt;Event&gt;&lt;![CDATA[subscribe]]&gt;&lt;/Event&gt;\n&lt;EventKey&gt;&lt;![CDATA[]]&gt;&lt;/EventKey&gt;\n&lt;/xml&gt;1', 'event', 'oCHHbjpVDHTddEOH-WsK1ox-gPE8', 'gh_46cfe935a631', '', 'a:4:{s:3:\"sbm\";s:4:\"0502\";s:9:\"signature\";s:40:\"c1df908b0504f40841ee837813b21f4abfc8fbda\";s:9:\"timestamp\";s:10:\"1371143452\";s:5:\"nonce\";s:10:\"1370492097\";}', 'kong');
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('254', '1371143516', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjpVDHTddEOH-WsK1ox-gPE8]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1371143480&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[涓', 'text', 'oCHHbjpVDHTddEOH-WsK1ox-gPE8', 'gh_46cfe935a631', '', 'a:4:{s:3:\"sbm\";s:4:\"0502\";s:9:\"signature\";s:40:\"2dcb6d56472f7b66840e24ef3bc1971109e0ffd3\";s:9:\"timestamp\";s:10:\"1371143480\";s:5:\"nonce\";s:10:\"1371198140\";}', 'kong');
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('255', '1371143562', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjpVDHTddEOH-WsK1ox-gPE8]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1371143525&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[娴嬭瘯鍟嗗?]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5889016597997158764&lt;/MsgId&gt;\n&lt;/xml&gt;1', 'text', 'oCHHbjpVDHTddEOH-WsK1ox-gPE8', 'gh_46cfe935a631', '', 'a:4:{s:3:\"sbm\";s:4:\"0502\";s:9:\"signature\";s:40:\"c0cedfc2830ca5a944f565cbcecebe44928a3805\";s:9:\"timestamp\";s:10:\"1371143525\";s:5:\"nonce\";s:10:\"1370878512\";}', 'kong');
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('256', '1371143616', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjpVDHTddEOH-WsK1ox-gPE8]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1371143579&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[11]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5889016829925392749&lt;/MsgId&gt;\n&lt;/xml&gt;1', 'text', 'oCHHbjpVDHTddEOH-WsK1ox-gPE8', 'gh_46cfe935a631', '', 'a:4:{s:3:\"sbm\";s:4:\"0502\";s:9:\"signature\";s:40:\"3466212c7b010d98ea1cc34b6e222dde184502cd\";s:9:\"timestamp\";s:10:\"1371143579\";s:5:\"nonce\";s:10:\"1371148363\";}', 'kong');
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('257', '1371319862', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjpVDHTddEOH-WsK1ox-gPE8]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1371319812&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[1]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5889773744896868718&lt;/MsgId&gt;\n&lt;/xml&gt;1', 'text', 'oCHHbjpVDHTddEOH-WsK1ox-gPE8', 'gh_46cfe935a631', '', 'a:4:{s:3:\"sbm\";s:4:\"0502\";s:9:\"signature\";s:40:\"666acf4e399180703ebd368dfc4683f02015c8d9\";s:9:\"timestamp\";s:10:\"1371319812\";s:5:\"nonce\";s:10:\"1370764521\";}', 'kong');
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('258', '1371319868', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjpVDHTddEOH-WsK1ox-gPE8]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1371319818&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[2]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5889773770666672495&lt;/MsgId&gt;\n&lt;/xml&gt;1', 'text', 'oCHHbjpVDHTddEOH-WsK1ox-gPE8', 'gh_46cfe935a631', '', 'a:4:{s:3:\"sbm\";s:4:\"0502\";s:9:\"signature\";s:40:\"8e8f789829c81058fffd20c1452fe47e4e5989fb\";s:9:\"timestamp\";s:10:\"1371319818\";s:5:\"nonce\";s:10:\"1370825129\";}', 'kong');
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('259', '1371378236', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjpVDHTddEOH-WsK1ox-gPE8]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1371378176&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[1]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5890024416368132464&lt;/MsgId&gt;\n&lt;/xml&gt;1', 'text', 'oCHHbjpVDHTddEOH-WsK1ox-gPE8', 'gh_46cfe935a631', '', 'a:4:{s:3:\"sbm\";s:4:\"0502\";s:9:\"signature\";s:40:\"824603d53666edf26bb570f3b32721061d3bae3d\";s:9:\"timestamp\";s:10:\"1371378176\";s:5:\"nonce\";s:10:\"1370991011\";}', 'kong');
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('260', '1371414490', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjpVDHTddEOH-WsK1ox-gPE8]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1371414428&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[a]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5890180117522547057&lt;/MsgId&gt;\n&lt;/xml&gt;1', 'text', 'oCHHbjpVDHTddEOH-WsK1ox-gPE8', 'gh_46cfe935a631', '', 'a:4:{s:3:\"sbm\";s:4:\"0502\";s:9:\"signature\";s:40:\"8bfe451ffad3157ebdc6a863eb0c7b6867cdf086\";s:9:\"timestamp\";s:10:\"1371414428\";s:5:\"nonce\";s:10:\"1371320768\";}', 'kong');
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('261', '1371543201', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjpVDHTddEOH-WsK1ox-gPE8]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1371543216&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[bnn]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5890733257770664306&lt;/MsgId&gt;\n&lt;/xml&gt;1', 'text', 'oCHHbjpVDHTddEOH-WsK1ox-gPE8', 'gh_46cfe935a631', '', 'a:4:{s:3:\"sbm\";s:4:\"0502\";s:9:\"signature\";s:40:\"ce93942810ba796d79975ab0855e5b7883900806\";s:9:\"timestamp\";s:10:\"1371543216\";s:5:\"nonce\";s:10:\"1372323818\";}', 'kong');
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('262', '1371650857', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjpVDHTddEOH-WsK1ox-gPE8]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1371650866&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[aaa]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5891195611000078707&lt;/MsgId&gt;\n&lt;/xml&gt;1', 'text', 'oCHHbjpVDHTddEOH-WsK1ox-gPE8', 'gh_46cfe935a631', '', 'a:4:{s:3:\"sbm\";s:4:\"0502\";s:9:\"signature\";s:40:\"e44b7bf6107fef29bbf9956500b8893cfdf7b035\";s:9:\"timestamp\";s:10:\"1371650866\";s:5:\"nonce\";s:10:\"1372450804\";}', 'kong');
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('263', '1371834578', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjpVDHTddEOH-WsK1ox-gPE8]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1371834571&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[鍘诲幓鍘诲幓]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5891984617967190388&lt;/MsgId&gt;\n&lt;/xml&gt;1', 'text', 'oCHHbjpVDHTddEOH-WsK1ox-gPE8', 'gh_46cfe935a631', '', 'a:4:{s:3:\"sbm\";s:4:\"0502\";s:9:\"signature\";s:40:\"ab4d30660be7cc5a5540723e07f25006eb0ced8f\";s:9:\"timestamp\";s:10:\"1371834571\";s:5:\"nonce\";s:10:\"1371755275\";}', 'kong');
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('264', '1372603002', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1372602986&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[鍥颁簡]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5895284935261946229&lt;/MsgId&gt;\n&lt;/xml&gt;1', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', 'a:4:{s:3:\"sbm\";s:4:\"2812\";s:9:\"signature\";s:40:\"304dcdeb4e2f3fc419dd122dec9b4e6571b3506b\";s:9:\"timestamp\";s:10:\"1372602986\";s:5:\"nonce\";s:10:\"1373215588\";}', 'kong');
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('265', '1372646089', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1372646070&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[鍥颁簡]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5895469979632927094&lt;/MsgId&gt;\n&lt;/xml&gt;1', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', 'a:4:{s:3:\"sbm\";s:4:\"2812\";s:9:\"signature\";s:40:\"9cf5565f2af9191f7da3b8313d2e82f176d1ada7\";s:9:\"timestamp\";s:10:\"1372646070\";s:5:\"nonce\";s:10:\"1373173353\";}', 'kong');
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('266', '1372647087', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1372647068&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[鍥颁簡]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5895474266010288503&lt;/MsgId&gt;\n&lt;/xml&gt;1', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', 'a:4:{s:3:\"sbm\";s:4:\"2812\";s:9:\"signature\";s:40:\"da7a521e5c88cc9b7696d79a122c7389016f20e5\";s:9:\"timestamp\";s:10:\"1372647068\";s:5:\"nonce\";s:10:\"1373332244\";}', 'kong');
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('267', '1372656228', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjm4dmHEPVm7vZTXJ5O6kSxg]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1372656208&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[鍛靛懙]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5895513522011373944&lt;/MsgId&gt;\n&lt;/xml&gt;1', 'text', 'oCHHbjm4dmHEPVm7vZTXJ5O6kSxg', 'gh_46cfe935a631', '', 'a:4:{s:3:\"sbm\";s:4:\"2812\";s:9:\"signature\";s:40:\"4a0a7fb416d0592605ba3261685ae769ff89b57f\";s:9:\"timestamp\";s:10:\"1372656208\";s:5:\"nonce\";s:10:\"1373237298\";}', 'kong');
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('268', '1372663234', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjpVDHTddEOH-WsK1ox-gPE8]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1372663214&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[a]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5895543612552249721&lt;/MsgId&gt;\n&lt;/xml&gt;1', 'text', 'oCHHbjpVDHTddEOH-WsK1ox-gPE8', 'gh_46cfe935a631', '', 'a:4:{s:3:\"sbm\";s:4:\"2812\";s:9:\"signature\";s:40:\"68061cb1c01dc400d4cf67bc12cd6e815769b37e\";s:9:\"timestamp\";s:10:\"1372663214\";s:5:\"nonce\";s:10:\"1373367769\";}', 'kong');
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('269', '1372814887', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjo2XxyNF9TX7WPtXBmsQsNc]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1372814894&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[event]]&gt;&lt;/MsgType&gt;\n&lt;Event&gt;&lt;![CDATA[subscribe]]&gt;&lt;/Event&gt;\n&lt;EventKey&gt;&lt;![CDATA[]]&gt;&lt;/EventKey&gt;\n&lt;/xml&gt;1', 'event', 'oCHHbjo2XxyNF9TX7WPtXBmsQsNc', 'gh_46cfe935a631', '', 'a:4:{s:3:\"sbm\";s:4:\"2812\";s:9:\"signature\";s:40:\"1634b8c701507c5b9bc9cf891b4c2f84b8ee44a1\";s:9:\"timestamp\";s:10:\"1372814894\";s:5:\"nonce\";s:10:\"1372717460\";}', 'kong');
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('270', '1372814899', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjo2XxyNF9TX7WPtXBmsQsNc]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1372814906&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[event]]&gt;&lt;/MsgType&gt;\n&lt;Event&gt;&lt;![CDATA[unsubscribe]]&gt;&lt;/Event&gt;\n&lt;EventKey&gt;&lt;![CDATA[]]&gt;&lt;/EventKey&gt;\n&lt;/xml&gt;1', 'event', 'oCHHbjo2XxyNF9TX7WPtXBmsQsNc', 'gh_46cfe935a631', '', 'a:4:{s:3:\"sbm\";s:4:\"2812\";s:9:\"signature\";s:40:\"228b792e4cd95ce400229b4fb2f4f8c6af1f3b65\";s:9:\"timestamp\";s:10:\"1372814906\";s:5:\"nonce\";s:10:\"1372901960\";}', 'kong');
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('271', '1373650553', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjpVDHTddEOH-WsK1ox-gPE8]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1373650540&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[text]]&gt;&lt;/MsgType&gt;\n&lt;Content&gt;&lt;![CDATA[娴嬭瘯]]&gt;&lt;/Content&gt;\n&lt;MsgId&gt;5899784145432740218&lt;/MsgId&gt;\n&lt;/xml&gt;1', 'text', 'oCHHbjpVDHTddEOH-WsK1ox-gPE8', 'gh_46cfe935a631', '', 'a:4:{s:3:\"sbm\";s:4:\"2812\";s:9:\"signature\";s:40:\"62fa5c29eecb8be787395f4a494df9d99cfdbb3c\";s:9:\"timestamp\";s:10:\"1373650540\";s:5:\"nonce\";s:10:\"1374312170\";}', 'kong');
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('272', '1373740347', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjpVDHTddEOH-WsK1ox-gPE8]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1373740329&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[location]]&gt;&lt;/MsgType&gt;\n&lt;Location_X&gt;27.508899&lt;/Location_X&gt;\n&lt;Location_Y&gt;120.402509&lt;/Location_Y&gt;\n&lt;Scale&gt;15&lt;/Scale&gt;\n&lt;Label&gt;&lt;![CDATA[涓?浗娴欐睙鐪佹俯宸炲競鑻嶅崡鍘垮缓鍏翠笢璺', 'location', 'oCHHbjpVDHTddEOH-WsK1ox-gPE8', 'gh_46cfe935a631', '', 'a:4:{s:3:\"sbm\";s:4:\"2812\";s:9:\"signature\";s:40:\"c454545aa0092ab85072526a8807bf47e6b9480e\";s:9:\"timestamp\";s:10:\"1373740329\";s:5:\"nonce\";s:10:\"1374639677\";}', 'kong');
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('273', '1374251350', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjnT0Vf4TRCrd31MG6bh9x_k]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1374251289&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[event]]&gt;&lt;/MsgType&gt;\n&lt;Event&gt;&lt;![CDATA[subscribe]]&gt;&lt;/Event&gt;\n&lt;EventKey&gt;&lt;![CDATA[]]&gt;&lt;/EventKey&gt;\n&lt;/xml&gt;1', 'event', 'oCHHbjnT0Vf4TRCrd31MG6bh9x_k', 'gh_46cfe935a631', '', 'a:4:{s:3:\"sbm\";s:4:\"2812\";s:9:\"signature\";s:40:\"957142468b9398e0982036c737cde8b6da76842c\";s:9:\"timestamp\";s:10:\"1374251289\";s:5:\"nonce\";s:10:\"1374527758\";}', 'kong');
INSERT INTO `wxq_wxq123_weixin_temp` VALUES ('274', '1374312244', '&lt;xml&gt;&lt;ToUserName&gt;&lt;![CDATA[gh_46cfe935a631]]&gt;&lt;/ToUserName&gt;\n&lt;FromUserName&gt;&lt;![CDATA[oCHHbjnT0Vf4TRCrd31MG6bh9x_k]]&gt;&lt;/FromUserName&gt;\n&lt;CreateTime&gt;1374312234&lt;/CreateTime&gt;\n&lt;MsgType&gt;&lt;![CDATA[event]]&gt;&lt;/MsgType&gt;\n&lt;Event&gt;&lt;![CDATA[unsubscribe]]&gt;&lt;/Event&gt;\n&lt;EventKey&gt;&lt;![CDATA[]]&gt;&lt;/EventKey&gt;\n&lt;/xml&gt;1', 'event', 'oCHHbjnT0Vf4TRCrd31MG6bh9x_k', 'gh_46cfe935a631', '', 'a:4:{s:3:\"sbm\";s:4:\"2812\";s:9:\"signature\";s:40:\"f8d953297bf51ae4246ea9cf89597c4c58edde6a\";s:9:\"timestamp\";s:10:\"1374312234\";s:5:\"nonce\";s:10:\"1374526538\";}', 'kong');

-- ----------------------------
-- Table structure for `wxq_yiqixueba_adminmenu`
-- ----------------------------
DROP TABLE IF EXISTS `wxq_yiqixueba_adminmenu`;
CREATE TABLE `wxq_yiqixueba_adminmenu` (
  `menuid` smallint(6) unsigned NOT NULL auto_increment,
  `upid` smallint(6) NOT NULL,
  `menuname` char(50) character set gbk NOT NULL,
  `menutitle` char(50) character set gbk NOT NULL,
  `displayorder` smallint(6) NOT NULL,
  PRIMARY KEY  (`menuid`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of wxq_yiqixueba_adminmenu
-- ----------------------------
INSERT INTO `wxq_yiqixueba_adminmenu` VALUES ('1', '0', 'base', '基础设置', '0');
INSERT INTO `wxq_yiqixueba_adminmenu` VALUES ('2', '1', 'reg', '插件注册', '2');
INSERT INTO `wxq_yiqixueba_adminmenu` VALUES ('3', '1', 'base', '基础设置', '1');
INSERT INTO `wxq_yiqixueba_adminmenu` VALUES ('4', '0', 'member', '会员管理', '5');
INSERT INTO `wxq_yiqixueba_adminmenu` VALUES ('5', '4', 'mkcard', '生成卡', '1');
INSERT INTO `wxq_yiqixueba_adminmenu` VALUES ('6', '4', 'cardadmin', '管理卡', '2');
INSERT INTO `wxq_yiqixueba_adminmenu` VALUES ('7', '4', 'cardcat', '卡分类', '0');
INSERT INTO `wxq_yiqixueba_adminmenu` VALUES ('8', '1', 'index', '系统首页', '0');
INSERT INTO `wxq_yiqixueba_adminmenu` VALUES ('9', '0', 'shop', '商家管理', '1');
INSERT INTO `wxq_yiqixueba_adminmenu` VALUES ('10', '9', 'shopsetting', '商家设置', '0');
INSERT INTO `wxq_yiqixueba_adminmenu` VALUES ('11', '9', 'shopadmin', '商家管理', '2');
INSERT INTO `wxq_yiqixueba_adminmenu` VALUES ('12', '9', 'shoptype', '商家组', '1');

-- ----------------------------
-- Table structure for `wxq_yiqixueba_brand_business`
-- ----------------------------
DROP TABLE IF EXISTS `wxq_yiqixueba_brand_business`;
CREATE TABLE `wxq_yiqixueba_brand_business` (
  `businessid` mediumint(8) unsigned NOT NULL auto_increment,
  `businessgroupid` smallint(3) NOT NULL,
  `relname` char(10) character set gbk NOT NULL,
  `businessname` char(40) character set gbk NOT NULL,
  `sex` tinyint(1) NOT NULL,
  `phone` char(15) character set gbk NOT NULL,
  `address` char(100) character set gbk NOT NULL,
  `birthday` int(10) unsigned NOT NULL,
  `gerenphoto` char(100) character set gbk NOT NULL,
  `shenfenno` char(20) NOT NULL,
  `shenfenphoto` char(100) character set gbk NOT NULL,
  `businesssummary` varchar(255) character set gbk NOT NULL,
  `contractimage` varchar(255) character set gbk NOT NULL,
  `status` tinyint(1) NOT NULL,
  `uid` mediumint(8) unsigned NOT NULL,
  `cardtype` smallint(3) NOT NULL,
  `cardnum` int(10) unsigned NOT NULL,
  `shopid` mediumint(8) unsigned NOT NULL,
  `jointime` int(11) NOT NULL,
  PRIMARY KEY  (`businessid`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of wxq_yiqixueba_brand_business
-- ----------------------------
INSERT INTO `wxq_yiqixueba_brand_business` VALUES ('7', '0', '杨文', '', '1', '13113890911', '河北省石家庄市新华区', '0', '', '131106196806050972', '', '', '', '0', '1', '0', '0', '14', '1372661101');
INSERT INTO `wxq_yiqixueba_brand_business` VALUES ('8', '0', '杨文', '', '1', '11111', '1等我去打球', '141408000', '', '111111111111111111', '', '', '', '0', '1', '0', '0', '15', '1372694040');

-- ----------------------------
-- Table structure for `wxq_yiqixueba_brand_businessgroup`
-- ----------------------------
DROP TABLE IF EXISTS `wxq_yiqixueba_brand_businessgroup`;
CREATE TABLE `wxq_yiqixueba_brand_businessgroup` (
  `businessgroupid` smallint(6) unsigned NOT NULL auto_increment,
  `businessgroupname` char(50) character set gbk NOT NULL,
  `inshoufei` int(10) unsigned NOT NULL,
  `inshoufeiqixian` int(10) unsigned NOT NULL,
  `businessgroupdescription` varchar(255) character set gbk NOT NULL,
  `cardfeiyong` int(10) NOT NULL,
  `cardpice` int(10) unsigned NOT NULL,
  `status` tinyint(1) NOT NULL,
  `businessgroupico` varchar(255) character set gbk NOT NULL,
  `xiaofei` varchar(255) character set gbk NOT NULL,
  `zhanghaoyue` int(10) NOT NULL,
  `zhanghaojifen` int(10) NOT NULL,
  `xiaofeitypeshenhe` tinyint(1) NOT NULL,
  `dianyuanshenhe` tinyint(1) NOT NULL,
  `dianzhang` varchar(255) character set gbk NOT NULL,
  `caiwu` varchar(255) character set gbk NOT NULL,
  `shouyin` varchar(255) character set gbk NOT NULL,
  `enfendian` tinyint(1) NOT NULL,
  `enbusinessnum` int(10) NOT NULL,
  `contractsample` char(100) character set gbk NOT NULL,
  `isbusiness` varchar(255) NOT NULL,
  PRIMARY KEY  (`businessgroupid`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of wxq_yiqixueba_brand_businessgroup
-- ----------------------------
INSERT INTO `wxq_yiqixueba_brand_businessgroup` VALUES ('1', '普通商家组', '0', '0', '', '0', '0', '1', 'cf/003437byyv45vaz4ayswaf.jpg', 'N;', '0', '0', '1', '0', 'N;', 'N;', 'N;', '0', '1', '', '0');
INSERT INTO `wxq_yiqixueba_brand_businessgroup` VALUES ('2', 'VIP商家组', '0', '0', '', '0', '0', '1', 'cf/114407howwu77uu1o5uz5z.png', 'a:6:{i:0;s:4:\"jici\";i:1;s:7:\"shijian\";i:2;s:7:\"liangka\";i:3;s:7:\"xianjin\";i:4;s:3:\"yue\";i:5;s:5:\"jifen\";}', '0', '0', '0', '0', 'N;', 'N;', 'N;', '1', '1', '', '');

-- ----------------------------
-- Table structure for `wxq_yiqixueba_brand_chanpinku`
-- ----------------------------
DROP TABLE IF EXISTS `wxq_yiqixueba_brand_chanpinku`;
CREATE TABLE `wxq_yiqixueba_brand_chanpinku` (
  `chanpinkuid` mediumint(8) unsigned NOT NULL auto_increment,
  `chanpinkuname` varchar(255) NOT NULL,
  `pice` varchar(255) NOT NULL,
  `logo` varchar(255) NOT NULL,
  `information` varchar(255) NOT NULL,
  `cats` char(40) NOT NULL,
  `chanpinkunum` int(11) NOT NULL,
  `createtime` int(11) NOT NULL,
  `chanpinkustatus` tinyint(1) NOT NULL,
  `ttt` text NOT NULL,
  `shopid` mediumint(8) NOT NULL,
  PRIMARY KEY  (`chanpinkuid`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=gbk;

-- ----------------------------
-- Records of wxq_yiqixueba_brand_chanpinku
-- ----------------------------

-- ----------------------------
-- Table structure for `wxq_yiqixueba_brand_dianping`
-- ----------------------------
DROP TABLE IF EXISTS `wxq_yiqixueba_brand_dianping`;
CREATE TABLE `wxq_yiqixueba_brand_dianping` (
  `dianpingid` mediumint(8) unsigned NOT NULL auto_increment,
  `dianpingtype` smallint(3) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `displayorder` mediumint(8) NOT NULL,
  PRIMARY KEY  (`dianpingid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of wxq_yiqixueba_brand_dianping
-- ----------------------------

-- ----------------------------
-- Table structure for `wxq_yiqixueba_brand_dianping_shop`
-- ----------------------------
DROP TABLE IF EXISTS `wxq_yiqixueba_brand_dianping_shop`;
CREATE TABLE `wxq_yiqixueba_brand_dianping_shop` (
  `dianpingid` mediumint(8) unsigned NOT NULL auto_increment,
  `shopid` mediumint(8) NOT NULL,
  `chanpinid` mediumint(8) NOT NULL,
  `uid` mediumint(8) NOT NULL,
  `zongti` smallint(3) NOT NULL,
  `pingfen` text NOT NULL,
  `dingpingtime` int(10) unsigned NOT NULL,
  `dianpingtitle` char(40) NOT NULL,
  `dianpingneirong` text NOT NULL,
  `status` tinyint(1) NOT NULL,
  `defen` text NOT NULL,
  PRIMARY KEY  (`dianpingid`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=gbk;

-- ----------------------------
-- Records of wxq_yiqixueba_brand_dianping_shop
-- ----------------------------
INSERT INTO `wxq_yiqixueba_brand_dianping_shop` VALUES ('1', '15', '0', '1', '5', '4|4|5|3|4', '1372747500', 'wedwed', 'dwedweq', '0', '4|4|5|3|4');
INSERT INTO `wxq_yiqixueba_brand_dianping_shop` VALUES ('2', '14', '0', '1', '5', '5|5|5|5|5', '1372777962', '这个店不错', '物美价廉', '0', '9|9|10|8|9');
INSERT INTO `wxq_yiqixueba_brand_dianping_shop` VALUES ('3', '14', '0', '3', '5', '5|5|5|5|5', '1373626735', '为什么不能点评', '为什么这样不能点评啊', '0', '14|14|15|13|14');

-- ----------------------------
-- Table structure for `wxq_yiqixueba_brand_dianyuan`
-- ----------------------------
DROP TABLE IF EXISTS `wxq_yiqixueba_brand_dianyuan`;
CREATE TABLE `wxq_yiqixueba_brand_dianyuan` (
  `dianyuanid` mediumint(8) unsigned NOT NULL auto_increment,
  `shopid` mediumint(8) NOT NULL,
  `dyusername` char(40) character set gbk NOT NULL,
  `dyname` char(40) character set gbk NOT NULL,
  `dysex` tinyint(1) NOT NULL,
  `dyphone` char(20) character set gbk NOT NULL,
  `dytype` smallint(3) NOT NULL,
  `dyquanxian` text character set gbk NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY  (`dianyuanid`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of wxq_yiqixueba_brand_dianyuan
-- ----------------------------
INSERT INTO `wxq_yiqixueba_brand_dianyuan` VALUES ('1', '15', 'luyane', '测试人员', '2', '1234567', '1', 'a:4:{i:0;s:4:\"view\";i:1;s:5:\"banli\";i:2;s:7:\"zhuxiao\";i:3;s:5:\"buban\";}', '0');
INSERT INTO `wxq_yiqixueba_brand_dianyuan` VALUES ('2', '16', 'luyane', '哈哈', '2', '1234567', '2', 'a:4:{i:0;s:4:\"view\";i:1;s:5:\"banli\";i:2;s:7:\"zhuxiao\";i:3;s:5:\"buban\";}', '0');

-- ----------------------------
-- Table structure for `wxq_yiqixueba_brand_gonggao`
-- ----------------------------
DROP TABLE IF EXISTS `wxq_yiqixueba_brand_gonggao`;
CREATE TABLE `wxq_yiqixueba_brand_gonggao` (
  `gonggaoid` smallint(6) unsigned NOT NULL auto_increment,
  `gonggaoname` char(40) character set gbk NOT NULL,
  `gonggaotext` text character set gbk NOT NULL,
  `youxiaoqi` int(10) unsigned NOT NULL,
  `createtime` int(10) unsigned NOT NULL,
  `displayorder` smallint(6) NOT NULL,
  `status` tinyint(1) default NULL,
  PRIMARY KEY  (`gonggaoid`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of wxq_yiqixueba_brand_gonggao
-- ----------------------------
INSERT INTO `wxq_yiqixueba_brand_gonggao` VALUES ('1', '撒旦风格撒旦', '中新网衡水6月23日电(记者 崔志平) 就媒体报道<a href=\"http://news.sina.com.cn/c/2013-06-22/151727470778.shtml\" target=\"_blank\">河北衡水“城管持板砖打人”</a>一事，河北省衡水市官方23日晚透露，对着装参与打架斗殴的该市城管工作人员郭强给予调离城管执法队伍处分。目前，公安机关已经介入。\r\n<p>\r\n	　　日前，一段关于“衡水城管持板砖打人”的视频在网上流传。经媒体报道后，该事件引起社会各界的高度关注。\r\n</p>\r\n<p>\r\n	　　衡水市官方说，针对6月20日媒体反映衡水市城管工作人员郭强打人一事进行了详细调查，经研究做出处理：郭强在上班期间，着装参与打架斗殴，虽与城管执法无关，但给城管队伍造成了恶劣影响，给予调离城管执法队伍处分。由主管城管执法的局长看望对方当事人，并在全市城管系统深入开展纪律作风大整顿。\r\n</p>\r\n<p>\r\n	　　据公安部门透露，16秒视频为部分视频，城管工作人员郭强及饭店老板周某因互相斗殴，均已受伤住院，公安机关已经介入并进入司法程序。(完)\r\n</p>', '1375200000', '1372692793', '0', '1');
INSERT INTO `wxq_yiqixueba_brand_gonggao` VALUES ('2', '测试公告二', '啊傻傻的发呆', '1372521600', '1372009343', '0', '1');

-- ----------------------------
-- Table structure for `wxq_yiqixueba_brand_member`
-- ----------------------------
DROP TABLE IF EXISTS `wxq_yiqixueba_brand_member`;
CREATE TABLE `wxq_yiqixueba_brand_member` (
  `uid` mediumint(8) NOT NULL,
  `group` char(20) character set gbk NOT NULL,
  `yikatong_business_array` text character set gbk NOT NULL,
  `yikatong_dianzhang_array` text character set gbk NOT NULL,
  `yikatong_caiwu_array` text character set gbk NOT NULL,
  `yikatong_shouyin_array` text character set gbk NOT NULL,
  `yikatong_kaxiaoshou_array` text character set gbk NOT NULL,
  `yikatong_shop_array` text character set gbk NOT NULL,
  `yikatong_goods_array` text character set gbk NOT NULL,
  PRIMARY KEY  (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of wxq_yiqixueba_brand_member
-- ----------------------------
INSERT INTO `wxq_yiqixueba_brand_member` VALUES ('1', '', '', '', '', '', '', '', '');

-- ----------------------------
-- Table structure for `wxq_yiqixueba_brand_shop`
-- ----------------------------
DROP TABLE IF EXISTS `wxq_yiqixueba_brand_shop`;
CREATE TABLE `wxq_yiqixueba_brand_shop` (
  `shopid` mediumint(8) unsigned NOT NULL auto_increment,
  `shopname` char(50) character set gbk NOT NULL,
  `shopalias` char(40) character set gbk NOT NULL,
  `shopvideo` varchar(255) character set gbk NOT NULL,
  `shoplocation` char(40) character set gbk NOT NULL,
  `dist` char(50) character set gbk NOT NULL,
  `comy` char(50) character set gbk NOT NULL,
  `shopintroduction` varchar(255) character set gbk NOT NULL,
  `shopinformation` text character set gbk NOT NULL,
  `shoprecommend` smallint(3) NOT NULL,
  `shoplevel` smallint(3) NOT NULL,
  `uid` mediumint(8) NOT NULL,
  `shopdianyuan` text character set gbk NOT NULL,
  `createtime` int(10) unsigned NOT NULL,
  `renlingtime` int(10) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `shopsort` smallint(3) NOT NULL,
  `shoplogo` varchar(100) character set gbk NOT NULL,
  `address` varchar(100) character set gbk NOT NULL,
  `phone` varchar(20) character set gbk NOT NULL,
  `lianxiren` varchar(20) character set gbk NOT NULL,
  `qq` varchar(20) character set gbk NOT NULL,
  `upmokuai` varchar(255) NOT NULL,
  `businessid` mediumint(8) unsigned NOT NULL,
  `upshopid` mediumint(8) unsigned NOT NULL,
  PRIMARY KEY  (`shopid`)
) ENGINE=MyISAM AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of wxq_yiqixueba_brand_shop
-- ----------------------------
INSERT INTO `wxq_yiqixueba_brand_shop` VALUES ('14', '测试商家', '', '', '114.483458,38.021108', '新华区', '石岗街道', '这里是商铺的简介，这里是商铺的简介，这里是商铺的简介，这里是商铺的简介，这里是商铺的简介，这里是商铺的简介，这里是商铺的简介，这里是商铺的简介，这里是商铺的简介，这里是商铺的简介，这里是商铺的简介，这里是商铺的简介，这里是商铺的简介，这里是商铺的简介，这里是商铺的简介，这里是商铺的简介，', '&lt;p align=&quot;center&quot;&gt;\r\n	&lt;span style=&quot;font-size:32px;&quot;&gt;&lt;strong&gt;是的放松地方&lt;/strong&gt;&lt;/span&gt;\r\n&lt;/p&gt;', '0', '0', '1', '', '1372782664', '1372660901', '0', '7', 'cf/144141eeeaj8jyjz8iqmma.jpg', '河北省石家庄市新华区', '13113890911', '杨文', '1234567', '0', '0', '0');
INSERT INTO `wxq_yiqixueba_brand_shop` VALUES ('15', '我的分店', '', '', '116.318462,39.891799', '桥东区', '休门街道', '', '', '0', '0', '1', '', '1372785052', '0', '0', '6', 'cf/235146la6xvkdia6dm6kkd.jpg', '', '', '', '', '0', '0', '0');

-- ----------------------------
-- Table structure for `wxq_yiqixueba_brand_shopsort`
-- ----------------------------
DROP TABLE IF EXISTS `wxq_yiqixueba_brand_shopsort`;
CREATE TABLE `wxq_yiqixueba_brand_shopsort` (
  `shopsortid` smallint(6) unsigned NOT NULL auto_increment,
  `upmokuai` smallint(6) NOT NULL,
  `sortname` char(20) character set gbk NOT NULL,
  `sorttitle` char(20) character set gbk NOT NULL,
  `sortlevel` smallint(6) NOT NULL,
  `sortupid` smallint(6) NOT NULL,
  `displayorder` smallint(6) NOT NULL,
  `upids` text character set gbk NOT NULL,
  PRIMARY KEY  (`shopsortid`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of wxq_yiqixueba_brand_shopsort
-- ----------------------------
INSERT INTO `wxq_yiqixueba_brand_shopsort` VALUES ('1', '11', 'meishi', '美食', '1', '0', '0', '0');
INSERT INTO `wxq_yiqixueba_brand_shopsort` VALUES ('2', '11', 'test', '测试', '2', '1', '0', '0-1');
INSERT INTO `wxq_yiqixueba_brand_shopsort` VALUES ('5', '11', 'ceshi1', '测试1', '1', '0', '2', '0');
INSERT INTO `wxq_yiqixueba_brand_shopsort` VALUES ('6', '11', 'ceshi2', '测试2', '2', '5', '0', '0-5');
INSERT INTO `wxq_yiqixueba_brand_shopsort` VALUES ('7', '11', 'ceshi3', '测试3', '3', '6', '0', '0-5-6');
INSERT INTO `wxq_yiqixueba_brand_shopsort` VALUES ('8', '11', 'dalei1', '大类1', '1', '0', '1', '0');
INSERT INTO `wxq_yiqixueba_brand_shopsort` VALUES ('9', '0', 'asjdh', '撒打算', '4', '7', '0', '0-5-6-7');

-- ----------------------------
-- Table structure for `wxq_yiqixueba_brand_sort`
-- ----------------------------
DROP TABLE IF EXISTS `wxq_yiqixueba_brand_sort`;
CREATE TABLE `wxq_yiqixueba_brand_sort` (
  `sortid` smallint(6) unsigned NOT NULL auto_increment,
  `mokuaiid` smallint(6) NOT NULL,
  `sortname` char(20) character set gbk NOT NULL,
  `sorttitle` char(20) character set gbk NOT NULL,
  `sortlevel` smallint(6) NOT NULL,
  `sortupid` smallint(6) NOT NULL,
  `displayorder` smallint(6) NOT NULL,
  `upids` text character set gbk NOT NULL,
  `oldsortid` char(10) character set gbk NOT NULL,
  PRIMARY KEY  (`sortid`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of wxq_yiqixueba_brand_sort
-- ----------------------------
INSERT INTO `wxq_yiqixueba_brand_sort` VALUES ('1', '16', 'meishi', '美食', '1', '0', '0', '0', '');
INSERT INTO `wxq_yiqixueba_brand_sort` VALUES ('2', '16', 'chuancai', '川菜', '2', '1', '0', '0-1', '');
INSERT INTO `wxq_yiqixueba_brand_sort` VALUES ('5', '16', 'ceshi1', '测试1', '1', '0', '2', '0', '');
INSERT INTO `wxq_yiqixueba_brand_sort` VALUES ('6', '16', 'ceshi2', '测试2', '2', '5', '0', '0-5', '');
INSERT INTO `wxq_yiqixueba_brand_sort` VALUES ('8', '16', 'dalei1', '大类1', '1', '0', '1', '0', '');

-- ----------------------------
-- Table structure for `wxq_yiqixueba_brand_tuangou`
-- ----------------------------
DROP TABLE IF EXISTS `wxq_yiqixueba_brand_tuangou`;
CREATE TABLE `wxq_yiqixueba_brand_tuangou` (
  `dianpingid` mediumint(8) unsigned NOT NULL auto_increment,
  `dianpingtype` smallint(3) NOT NULL,
  PRIMARY KEY  (`dianpingid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of wxq_yiqixueba_brand_tuangou
-- ----------------------------

-- ----------------------------
-- Table structure for `wxq_yiqixueba_brand_zhuti`
-- ----------------------------
DROP TABLE IF EXISTS `wxq_yiqixueba_brand_zhuti`;
CREATE TABLE `wxq_yiqixueba_brand_zhuti` (
  `zhutiid` mediumint(8) unsigned NOT NULL auto_increment,
  `zhutiname` char(40) NOT NULL,
  `displayorder` mediumint(8) NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY  (`zhutiid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of wxq_yiqixueba_brand_zhuti
-- ----------------------------

-- ----------------------------
-- Table structure for `wxq_yiqixueba_cardcat`
-- ----------------------------
DROP TABLE IF EXISTS `wxq_yiqixueba_cardcat`;
CREATE TABLE `wxq_yiqixueba_cardcat` (
  `cardcatid` smallint(6) unsigned NOT NULL auto_increment,
  `cardcatname` char(50) character set gbk NOT NULL,
  `cardcatdescription` varchar(255) character set gbk NOT NULL,
  `cardpice` int(10) unsigned NOT NULL,
  `status` tinyint(1) NOT NULL,
  `cardcatico` varchar(255) character set gbk NOT NULL,
  `cardtype` varchar(255) NOT NULL,
  `cardjine` varchar(255) NOT NULL,
  `cardyouxiaoqi` varchar(255) NOT NULL,
  `cardjifen` varchar(255) NOT NULL,
  `cardkaishi` varchar(255) NOT NULL,
  `cardqingling` varchar(255) NOT NULL,
  PRIMARY KEY  (`cardcatid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of wxq_yiqixueba_cardcat
-- ----------------------------
INSERT INTO `wxq_yiqixueba_cardcat` VALUES ('1', '普通卡', '最普通的会员卡', '0', '1', 'cf/214916s8nm9bv9vpcczvjm.gif', 'benwangka', '0', '1402243200', '0', '1370793600', '1388505600');

-- ----------------------------
-- Table structure for `wxq_yiqixueba_client_setting`
-- ----------------------------
DROP TABLE IF EXISTS `wxq_yiqixueba_client_setting`;
CREATE TABLE `wxq_yiqixueba_client_setting` (
  `skey` varchar(255) character set gbk NOT NULL,
  `svalue` text character set gbk NOT NULL,
  PRIMARY KEY  (`skey`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of wxq_yiqixueba_client_setting
-- ----------------------------
INSERT INTO `wxq_yiqixueba_client_setting` VALUES ('mokuai_shop_shopfenlei', '1=美食\r\n1.1=川菜\r\n1.1.1=麻辣烫');
INSERT INTO `wxq_yiqixueba_client_setting` VALUES ('shop', '');

-- ----------------------------
-- Table structure for `wxq_yiqixueba_goods_goodssort`
-- ----------------------------
DROP TABLE IF EXISTS `wxq_yiqixueba_goods_goodssort`;
CREATE TABLE `wxq_yiqixueba_goods_goodssort` (
  `shopsortid` smallint(6) unsigned NOT NULL auto_increment,
  `upmokuai` smallint(6) NOT NULL,
  `sortname` char(20) character set gbk NOT NULL,
  `sorttitle` char(20) character set gbk NOT NULL,
  `sortlevel` smallint(6) NOT NULL,
  `sortupid` smallint(6) NOT NULL,
  `displayorder` smallint(6) NOT NULL,
  `upids` text character set gbk NOT NULL,
  PRIMARY KEY  (`shopsortid`)
) ENGINE=MyISAM AUTO_INCREMENT=14 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of wxq_yiqixueba_goods_goodssort
-- ----------------------------
INSERT INTO `wxq_yiqixueba_goods_goodssort` VALUES ('1', '11', 'meishi', '美食', '1', '0', '0', '0');
INSERT INTO `wxq_yiqixueba_goods_goodssort` VALUES ('2', '11', 'test', '测试', '2', '1', '2', '0-1');
INSERT INTO `wxq_yiqixueba_goods_goodssort` VALUES ('5', '11', 'ceshi1', '测试1', '1', '0', '2', '0');
INSERT INTO `wxq_yiqixueba_goods_goodssort` VALUES ('6', '11', 'ceshi2', '测试2', '2', '5', '0', '0-5');
INSERT INTO `wxq_yiqixueba_goods_goodssort` VALUES ('7', '11', 'ceshi3', '测试3', '3', '6', '0', '0-5-6');
INSERT INTO `wxq_yiqixueba_goods_goodssort` VALUES ('8', '11', 'dalei1', '大类1', '1', '0', '1', '0');
INSERT INTO `wxq_yiqixueba_goods_goodssort` VALUES ('9', '0', 'asjdh', '撒打算', '4', '7', '0', '0-5-6-7');
INSERT INTO `wxq_yiqixueba_goods_goodssort` VALUES ('10', '0', 'testl5', '5级分类', '5', '9', '0', '0-5-6-7-9');
INSERT INTO `wxq_yiqixueba_goods_goodssort` VALUES ('11', '0', 'test22', '2级分类', '2', '8', '0', '0-8');
INSERT INTO `wxq_yiqixueba_goods_goodssort` VALUES ('12', '0', 'mshi1', '美食下1', '2', '1', '0', '0-1');
INSERT INTO `wxq_yiqixueba_goods_goodssort` VALUES ('13', '0', 'mshi2', '美食下2', '2', '1', '1', '0-1');

-- ----------------------------
-- Table structure for `wxq_yiqixueba_member`
-- ----------------------------
DROP TABLE IF EXISTS `wxq_yiqixueba_member`;
CREATE TABLE `wxq_yiqixueba_member` (
  `uid` mediumint(8) NOT NULL,
  `brand` char(20) character set gbk NOT NULL,
  `yikatong` char(20) character set gbk NOT NULL,
  `wxq123` char(20) character set gbk NOT NULL,
  `yikatong_business_array` text character set gbk NOT NULL,
  `yikatong_dianzhang_array` text character set gbk NOT NULL,
  `yikatong_caiwu_array` text character set gbk NOT NULL,
  `yikatong_shouyin_array` text character set gbk NOT NULL,
  `yikatong_kaxiaoshou_array` text character set gbk NOT NULL,
  `yikatong_shop_array` text character set gbk NOT NULL,
  `yikatong_goods_array` text character set gbk NOT NULL,
  PRIMARY KEY  (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of wxq_yiqixueba_member
-- ----------------------------
INSERT INTO `wxq_yiqixueba_member` VALUES ('1', '', '', '', '', '', '', '', '', '', '');

-- ----------------------------
-- Table structure for `wxq_yiqixueba_menu`
-- ----------------------------
DROP TABLE IF EXISTS `wxq_yiqixueba_menu`;
CREATE TABLE `wxq_yiqixueba_menu` (
  `menuid` smallint(6) unsigned NOT NULL auto_increment,
  `mokuaiid` smallint(6) unsigned zerofill NOT NULL,
  `menutype` char(20) character set gbk NOT NULL,
  `upid` smallint(6) NOT NULL,
  `menuname` char(50) character set gbk NOT NULL,
  `menutitle` char(50) character set gbk NOT NULL,
  `displayorder` smallint(6) NOT NULL,
  `rules` text character set gbk NOT NULL,
  `sourcecode` text character set gbk NOT NULL,
  PRIMARY KEY  (`menuid`)
) ENGINE=MyISAM AUTO_INCREMENT=86 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of wxq_yiqixueba_menu
-- ----------------------------
INSERT INTO `wxq_yiqixueba_menu` VALUES ('1', '000000', 'admin', '0', 'base', '基础设置', '0', '', '');
INSERT INTO `wxq_yiqixueba_menu` VALUES ('2', '000000', 'admin', '1', 'reg', '插件注册', '2', '', '');
INSERT INTO `wxq_yiqixueba_menu` VALUES ('3', '000000', 'admin', '1', 'setting', '基础设置', '1', 'a:3:{s:9:\"tablename\";s:0:\"\";s:9:\"fieldname\";s:0:\"\";s:11:\"otheroption\";N;}', '');
INSERT INTO `wxq_yiqixueba_menu` VALUES ('4', '000000', 'admin', '0', 'yikatong', '一卡通', '3', '', '');
INSERT INTO `wxq_yiqixueba_menu` VALUES ('6', '000000', 'admin', '4', 'cardadmin', '管理卡', '5', '', '');
INSERT INTO `wxq_yiqixueba_menu` VALUES ('8', '000000', 'admin', '1', 'index', '系统首页', '0', '', '');
INSERT INTO `wxq_yiqixueba_menu` VALUES ('9', '000000', 'admin', '0', 'brand', '联盟商家', '1', 'a:3:{s:9:\"tablename\";s:0:\"\";s:9:\"fieldname\";s:0:\"\";s:11:\"otheroption\";N;}', '');
INSERT INTO `wxq_yiqixueba_menu` VALUES ('10', '000000', 'admin', '9', 'setting', '商家设置', '0', 'a:3:{s:9:\"tablename\";s:0:\"\";s:9:\"fieldname\";s:0:\"\";s:11:\"otheroption\";N;}', '');
INSERT INTO `wxq_yiqixueba_menu` VALUES ('11', '000000', 'admin', '9', 'shop', '商铺管理', '5', 'a:3:{s:9:\"tablename\";s:0:\"\";s:9:\"fieldname\";s:0:\"\";s:11:\"otheroption\";N;}', '');
INSERT INTO `wxq_yiqixueba_menu` VALUES ('12', '000000', 'admin', '4', 'businessgroup', '商家组', '2', 'a:3:{s:9:\"tablename\";s:0:\"\";s:9:\"fieldname\";s:0:\"\";s:11:\"otheroption\";N;}', '');
INSERT INTO `wxq_yiqixueba_menu` VALUES ('13', '000000', 'admin', '1', 'mokuai', '模块管理', '3', '', '');
INSERT INTO `wxq_yiqixueba_menu` VALUES ('14', '000000', 'admin', '9', 'goods', '商品管理', '6', '', '');
INSERT INTO `wxq_yiqixueba_menu` VALUES ('16', '000000', 'admin', '0', 'wxq123', '微信墙123', '4', 'a:3:{s:9:\"tablename\";s:0:\"\";s:9:\"fieldname\";s:0:\"\";s:11:\"otheroption\";N;}', '');
INSERT INTO `wxq_yiqixueba_menu` VALUES ('18', '000000', 'admin', '16', 'setting', '基础设置', '0', 'a:3:{s:9:\"tablename\";s:0:\"\";s:9:\"fieldname\";s:0:\"\";s:11:\"otheroption\";N;}', '');
INSERT INTO `wxq_yiqixueba_menu` VALUES ('68', '000000', 'manage', '40', 'base', '基本信息', '1', 'a:5:{i:0;a:6:{s:6:\"fenzhi\";s:0:\"\";s:9:\"tablename\";s:19:\"yiqixueba_yikatong_\";s:7:\"zhujian\";s:0:\"\";s:6:\"ismake\";s:1:\"0\";s:8:\"pagetype\";s:1:\"2\";s:5:\"field\";s:22:\"shopid|店铺编号|text|0\";}i:1;a:6:{s:6:\"fenzhi\";s:7:\"youshop\";s:9:\"tablename\";s:23:\"yiqixueba_yikatong_shop\";s:7:\"zhujian\";s:6:\"shopid\";s:6:\"ismake\";s:1:\"0\";s:8:\"pagetype\";s:1:\"1\";s:5:\"field\";s:22:\"shopid|店铺编号|text|0\";}i:2;a:6:{s:6:\"fenzhi\";s:0:\"\";s:9:\"tablename\";s:19:\"yiqixueba_yikatong_\";s:7:\"zhujian\";s:0:\"\";s:6:\"ismake\";s:1:\"0\";s:8:\"pagetype\";s:0:\"\";s:5:\"field\";s:0:\"\";}i:3;a:6:{s:6:\"fenzhi\";s:0:\"\";s:9:\"tablename\";s:19:\"yiqixueba_yikatong_\";s:7:\"zhujian\";s:0:\"\";s:6:\"ismake\";s:1:\"0\";s:8:\"pagetype\";s:0:\"\";s:5:\"field\";s:0:\"\";}i:4;a:6:{s:6:\"fenzhi\";s:0:\"\";s:9:\"tablename\";s:19:\"yiqixueba_yikatong_\";s:7:\"zhujian\";s:0:\"\";s:6:\"ismake\";s:1:\"0\";s:8:\"pagetype\";s:0:\"\";s:5:\"field\";s:0:\"\";}}', '');
INSERT INTO `wxq_yiqixueba_menu` VALUES ('22', '000000', 'manage', '0', 'brand', '联盟商家', '1', '', '');
INSERT INTO `wxq_yiqixueba_menu` VALUES ('24', '000000', 'manage', '22', 'shopinfo', '店铺信息', '2', '', '');
INSERT INTO `wxq_yiqixueba_menu` VALUES ('25', '000000', 'manage', '22', 'shopedit', '人员管理', '3', '', '');
INSERT INTO `wxq_yiqixueba_menu` VALUES ('26', '000000', 'manage', '22', 'myshop', '我的店铺', '1', '', '');
INSERT INTO `wxq_yiqixueba_menu` VALUES ('27', '000000', 'admin', '9', 'shopsort', '分类设置', '4', 'a:3:{s:9:\"tablename\";s:0:\"\";s:9:\"fieldname\";s:0:\"\";s:11:\"otheroption\";N;}', '');
INSERT INTO `wxq_yiqixueba_menu` VALUES ('29', '000000', 'admin', '4', 'setting', '基础设置', '1', 'a:3:{s:9:\"tablename\";s:0:\"\";s:9:\"fieldname\";s:0:\"\";s:11:\"otheroption\";N;}', '');
INSERT INTO `wxq_yiqixueba_menu` VALUES ('32', '000000', 'module', '0', 'shop', '商家', '0', '', '');
INSERT INTO `wxq_yiqixueba_menu` VALUES ('37', '000000', 'manage', '21', 'baseinfo', '个人信息', '0', '', '');
INSERT INTO `wxq_yiqixueba_menu` VALUES ('38', '000000', 'manage', '21', 'bindyikatong', '一卡通绑定', '0', '', '');
INSERT INTO `wxq_yiqixueba_menu` VALUES ('39', '000000', 'manage', '21', 'bindweixin', '微信绑定', '0', '', '');
INSERT INTO `wxq_yiqixueba_menu` VALUES ('40', '000000', 'manage', '0', 'yikatong', '一卡通', '4', '', '');
INSERT INTO `wxq_yiqixueba_menu` VALUES ('41', '000000', 'manage', '0', 'wxq123', '微信墙123', '5', '', '');
INSERT INTO `wxq_yiqixueba_menu` VALUES ('42', '000000', 'manage', '40', 'shuaka', '刷卡消费', '2', '', '');
INSERT INTO `wxq_yiqixueba_menu` VALUES ('43', '000000', 'manage', '40', 'newka', '办理新卡', '4', '', '');
INSERT INTO `wxq_yiqixueba_menu` VALUES ('44', '000000', 'manage', '40', 'guashibuban', '挂失补办', '5', '', '');
INSERT INTO `wxq_yiqixueba_menu` VALUES ('45', '000000', 'manage', '40', 'kahuiyuan', '会员查询', '3', '', '');
INSERT INTO `wxq_yiqixueba_menu` VALUES ('46', '000000', 'manage', '40', 'kaxiaofei', '消费记录', '6', '', '');
INSERT INTO `wxq_yiqixueba_menu` VALUES ('47', '000000', 'manage', '41', 'weixinsetting', '微信设置', '1', '', '');
INSERT INTO `wxq_yiqixueba_menu` VALUES ('48', '000000', 'manage', '41', 'weixinhuiyuan', '会员查询', '2', '', '');
INSERT INTO `wxq_yiqixueba_menu` VALUES ('49', '000000', 'manage', '41', 'weixinchaxun', '微信查询', '3', '', '');
INSERT INTO `wxq_yiqixueba_menu` VALUES ('50', '000000', 'manage', '41', 'weixinxiaofei', '消费记录', '4', '', '');
INSERT INTO `wxq_yiqixueba_menu` VALUES ('51', '000000', 'manage', '23', 'goodslist', '商品列表', '0', '', '');
INSERT INTO `wxq_yiqixueba_menu` VALUES ('84', '000000', 'admin', '82', 'goodssort', '商品分类', '1', 'a:3:{s:9:\"tablename\";s:0:\"\";s:9:\"fieldname\";s:0:\"\";s:11:\"otheroption\";N;}', '');
INSERT INTO `wxq_yiqixueba_menu` VALUES ('54', '000000', 'admin', '9', 'member', '用户管理', '7', 'a:3:{s:9:\"tablename\";s:0:\"\";s:9:\"fieldname\";s:0:\"\";s:11:\"otheroption\";N;}', '');
INSERT INTO `wxq_yiqixueba_menu` VALUES ('72', '000000', 'manage', '40', 'xiaofei', '会员消费', '0', 'a:5:{s:9:\"tablename\";s:23:\"yiqixueba_yikatong_card\";s:7:\"zhujian\";s:6:\"cardid\";s:6:\"ismake\";s:1:\"0\";s:8:\"pagetype\";s:1:\"2\";s:5:\"field\";s:18:\"cardno|卡号|text|0\";}', '');
INSERT INTO `wxq_yiqixueba_menu` VALUES ('83', '000000', 'admin', '82', 'setting', '基础设置', '0', 'a:3:{s:9:\"tablename\";s:0:\"\";s:9:\"fieldname\";s:0:\"\";s:11:\"otheroption\";N;}', '');
INSERT INTO `wxq_yiqixueba_menu` VALUES ('85', '000000', 'admin', '82', 'goods', '商品管理', '2', 'a:3:{s:9:\"tablename\";s:0:\"\";s:9:\"fieldname\";s:0:\"\";s:11:\"otheroption\";N;}', '');
INSERT INTO `wxq_yiqixueba_menu` VALUES ('58', '000000', 'admin', '4', 'goods', '商品管理', '4', 'a:3:{s:9:\"tablename\";s:0:\"\";s:9:\"fieldname\";s:0:\"\";s:11:\"otheroption\";N;}', '');
INSERT INTO `wxq_yiqixueba_menu` VALUES ('67', '000000', 'manage', '40', 'system', '系统管理', '7', '', '');
INSERT INTO `wxq_yiqixueba_menu` VALUES ('63', '000000', 'manage', '62', 'myshop', '我的店铺', '0', '', '');
INSERT INTO `wxq_yiqixueba_menu` VALUES ('64', '000000', 'manage', '62', 'yktdianyuan', '店员管理', '0', '', '');
INSERT INTO `wxq_yiqixueba_menu` VALUES ('65', '000000', 'manage', '62', 'yktgoods', '商品管理', '0', '', '');
INSERT INTO `wxq_yiqixueba_menu` VALUES ('69', '000000', 'manage', '22', 'base', '基本信息', '0', '', '');
INSERT INTO `wxq_yiqixueba_menu` VALUES ('70', '000000', 'manage', '41', 'base', '基本信息', '0', '', '');
INSERT INTO `wxq_yiqixueba_menu` VALUES ('73', '000000', 'manage', '40', 'business', '商家管理', '0', 'a:5:{i:0;a:6:{s:6:\"fenzhi\";s:21:\"oldshopnum|有老的店铺\";s:9:\"tablename\";s:23:\"yiqixueba_yikatong_shop\";s:7:\"zhujian\";s:6:\"shopid\";s:6:\"ismake\";s:1:\"0\";s:8:\"pagetype\";s:1:\"1\";s:5:\"field\";s:29:\"shopname|店铺名称|text|1|text\";}i:1;a:6:{s:6:\"fenzhi\";s:0:\"\";s:9:\"tablename\";s:19:\"yiqixueba_yikatong_\";s:7:\"zhujian\";s:0:\"\";s:6:\"ismake\";s:1:\"0\";s:8:\"pagetype\";s:0:\"\";s:5:\"field\";s:0:\"\";}i:2;a:6:{s:6:\"fenzhi\";s:0:\"\";s:9:\"tablename\";s:19:\"yiqixueba_yikatong_\";s:7:\"zhujian\";s:0:\"\";s:6:\"ismake\";s:1:\"0\";s:8:\"pagetype\";s:0:\"\";s:5:\"field\";s:0:\"\";}i:3;a:6:{s:6:\"fenzhi\";s:0:\"\";s:9:\"tablename\";s:19:\"yiqixueba_yikatong_\";s:7:\"zhujian\";s:0:\"\";s:6:\"ismake\";s:1:\"0\";s:8:\"pagetype\";s:0:\"\";s:5:\"field\";s:0:\"\";}i:4;a:6:{s:6:\"fenzhi\";s:0:\"\";s:9:\"tablename\";s:19:\"yiqixueba_yikatong_\";s:7:\"zhujian\";s:0:\"\";s:6:\"ismake\";s:1:\"0\";s:8:\"pagetype\";s:0:\"\";s:5:\"field\";s:0:\"\";}}', '');
INSERT INTO `wxq_yiqixueba_menu` VALUES ('74', '000000', 'admin', '9', 'businessgroup', '商家组', '1', 'a:3:{s:9:\"tablename\";s:0:\"\";s:9:\"fieldname\";s:0:\"\";s:11:\"otheroption\";N;}', '');
INSERT INTO `wxq_yiqixueba_menu` VALUES ('79', '000000', 'admin', '4', 'shop', '商铺管理', '3', 'a:3:{s:9:\"tablename\";s:0:\"\";s:9:\"fieldname\";s:0:\"\";s:11:\"otheroption\";N;}', '');
INSERT INTO `wxq_yiqixueba_menu` VALUES ('80', '000000', 'admin', '16', 'member', '微信会员', '0', 'a:3:{s:9:\"tablename\";s:0:\"\";s:9:\"fieldname\";s:0:\"\";s:11:\"otheroption\";N;}', '');
INSERT INTO `wxq_yiqixueba_menu` VALUES ('82', '000000', 'admin', '0', 'goods', '商品管理', '2', 'a:3:{s:9:\"tablename\";s:0:\"\";s:9:\"fieldname\";s:0:\"\";s:11:\"otheroption\";N;}', '');
INSERT INTO `wxq_yiqixueba_menu` VALUES ('81', '000000', 'admin', '16', 'jilu', '微信记录', '0', 'a:3:{s:9:\"tablename\";s:0:\"\";s:9:\"fieldname\";s:0:\"\";s:11:\"otheroption\";N;}', '');
INSERT INTO `wxq_yiqixueba_menu` VALUES ('78', '000000', 'admin', '9', 'gonggao', '公告设置', '0', 'a:3:{s:9:\"tablename\";s:0:\"\";s:9:\"fieldname\";s:0:\"\";s:11:\"otheroption\";N;}', '');

-- ----------------------------
-- Table structure for `wxq_yiqixueba_mokuai`
-- ----------------------------
DROP TABLE IF EXISTS `wxq_yiqixueba_mokuai`;
CREATE TABLE `wxq_yiqixueba_mokuai` (
  `mokuaiid` mediumint(8) unsigned NOT NULL auto_increment,
  `mokuainame` char(20) NOT NULL,
  `mokuaititle` char(20) NOT NULL,
  `mokuaiver` char(50) NOT NULL,
  `mokuaidescription` varchar(255) NOT NULL,
  `displayorder` smallint(6) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `installtime` int(10) unsigned NOT NULL,
  `mokuaipice` int(10) NOT NULL,
  `upmokuai` char(40) NOT NULL,
  `manage` text NOT NULL,
  PRIMARY KEY  (`mokuaiid`,`status`)
) ENGINE=MyISAM AUTO_INCREMENT=23 DEFAULT CHARSET=gbk;

-- ----------------------------
-- Records of wxq_yiqixueba_mokuai
-- ----------------------------
INSERT INTO `wxq_yiqixueba_mokuai` VALUES ('6', 'yikatong', '一卡通', 'V1.0', '在一起学吧平台插件上的一卡通模块', '0', '1', '1370764554', '1000', '', '');
INSERT INTO `wxq_yiqixueba_mokuai` VALUES ('8', 'brand', '联盟商家', 'V1.0', '', '0', '1', '1370764601', '500', '', '');
INSERT INTO `wxq_yiqixueba_mokuai` VALUES ('11', 'chanpinku', '产品库', 'V1.0', '', '0', '1', '1370785694', '200', 'brand', '');
INSERT INTO `wxq_yiqixueba_mokuai` VALUES ('22', 'wxq123', '微信墙123', 'V1.0', '', '0', '1', '1370764554', '0', '', '');
INSERT INTO `wxq_yiqixueba_mokuai` VALUES ('14', 'dianping', '点评', 'V1.0', '', '0', '1', '1371135687', '200', 'brand', '');
INSERT INTO `wxq_yiqixueba_mokuai` VALUES ('16', 'weituangou', '微团购', 'V1.0', '', '0', '1', '1371171885', '0', 'wxq123', '');
INSERT INTO `wxq_yiqixueba_mokuai` VALUES ('17', 'weishop', '微商家', 'V1.0', '', '0', '1', '1371171900', '0', 'wxq123', '');

-- ----------------------------
-- Table structure for `wxq_yiqixueba_mokuai_page`
-- ----------------------------
DROP TABLE IF EXISTS `wxq_yiqixueba_mokuai_page`;
CREATE TABLE `wxq_yiqixueba_mokuai_page` (
  `pageid` char(32) NOT NULL,
  `type` smallint(6) NOT NULL,
  `mokuaiid` mediumint(8) NOT NULL,
  `displayorder` smallint(6) NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY  (`pageid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

-- ----------------------------
-- Records of wxq_yiqixueba_mokuai_page
-- ----------------------------
INSERT INTO `wxq_yiqixueba_mokuai_page` VALUES ('sadsa', '0', '0', '1', '1');

-- ----------------------------
-- Table structure for `wxq_yiqixueba_page`
-- ----------------------------
DROP TABLE IF EXISTS `wxq_yiqixueba_page`;
CREATE TABLE `wxq_yiqixueba_page` (
  `pageid` smallint(6) unsigned NOT NULL auto_increment,
  `mokuaiid` smallint(6) NOT NULL,
  `pagetype` char(20) NOT NULL,
  `upid` smallint(6) NOT NULL,
  `pagename` char(20) NOT NULL,
  `pagetitle` char(20) NOT NULL,
  `displayorder` smallint(6) NOT NULL,
  PRIMARY KEY  (`pageid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of wxq_yiqixueba_page
-- ----------------------------

-- ----------------------------
-- Table structure for `wxq_yiqixueba_server_code`
-- ----------------------------
DROP TABLE IF EXISTS `wxq_yiqixueba_server_code`;
CREATE TABLE `wxq_yiqixueba_server_code` (
  `codeid` mediumint(8) unsigned NOT NULL auto_increment,
  `codetype` char(40) character set gbk NOT NULL,
  `codename` char(40) character set gbk NOT NULL,
  `codetitle` char(40) character set gbk NOT NULL,
  `codecontent` text character set gbk NOT NULL,
  `codedescription` varchar(255) character set gbk NOT NULL,
  PRIMARY KEY  (`codeid`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of wxq_yiqixueba_server_code
-- ----------------------------
INSERT INTO `wxq_yiqixueba_server_code` VALUES ('1', 'admin', 'setting', '设置页面', 'if(!submitcheck(\'submit\')) {\r\n}else{\r\n}', '测试一下');
INSERT INTO `wxq_yiqixueba_server_code` VALUES ('2', 'admin', 'datalist', '数据列表', 'if(!submitcheck(\'submit\')) {\r\n}else{\r\n}', '');

-- ----------------------------
-- Table structure for `wxq_yiqixueba_server_fenzhi`
-- ----------------------------
DROP TABLE IF EXISTS `wxq_yiqixueba_server_fenzhi`;
CREATE TABLE `wxq_yiqixueba_server_fenzhi` (
  `fenzhiid` mediumint(8) unsigned NOT NULL auto_increment,
  `fenzhitype` char(40) character set gbk NOT NULL,
  `fenzhiname` char(40) character set gbk NOT NULL,
  `fenzhititle` char(40) character set gbk NOT NULL,
  `fenzhicontent` text character set gbk NOT NULL,
  `fenzhidescription` varchar(255) character set gbk NOT NULL COMMENT 'ooo',
  PRIMARY KEY  (`fenzhiid`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of wxq_yiqixueba_server_fenzhi
-- ----------------------------
INSERT INTO `wxq_yiqixueba_server_fenzhi` VALUES ('1', 'admin', 'setting', '设置页面', 'if(!submitcheck(\'submit\')) {\r\n}else{\r\n}', '测试一下');
INSERT INTO `wxq_yiqixueba_server_fenzhi` VALUES ('2', 'admin', 'datalist', '数据列表', 'if(!submitcheck(\'submit\')) {\r\n}else{\r\n}', '');

-- ----------------------------
-- Table structure for `wxq_yiqixueba_server_menu`
-- ----------------------------
DROP TABLE IF EXISTS `wxq_yiqixueba_server_menu`;
CREATE TABLE `wxq_yiqixueba_server_menu` (
  `menuid` smallint(6) unsigned NOT NULL auto_increment,
  `mokuaitype` char(20) character set gbk NOT NULL,
  `menutype` char(20) NOT NULL,
  `upid` smallint(6) NOT NULL,
  `menuname` char(50) character set gbk NOT NULL,
  `menutitle` char(50) character set gbk NOT NULL,
  `displayorder` smallint(6) NOT NULL,
  `rules` text NOT NULL,
  `sourcecode` text NOT NULL,
  PRIMARY KEY  (`menuid`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of wxq_yiqixueba_server_menu
-- ----------------------------
INSERT INTO `wxq_yiqixueba_server_menu` VALUES ('1', 'server', 'admin', '0', 'server', '总站管理', '0', 'a:3:{s:9:\"tablename\";s:0:\"\";s:9:\"fieldname\";s:0:\"\";s:11:\"otheroption\";N;}', '');
INSERT INTO `wxq_yiqixueba_server_menu` VALUES ('2', 'server', 'admin', '1', 'basesetting', '基础设置', '1', '', '');
INSERT INTO `wxq_yiqixueba_server_menu` VALUES ('3', 'server', 'admin', '1', 'mokuai', '模块管理', '2', '', '');
INSERT INTO `wxq_yiqixueba_server_menu` VALUES ('4', 'server', 'admin', '1', 'site', '站长管理', '4', '', '');
INSERT INTO `wxq_yiqixueba_server_menu` VALUES ('5', 'server', 'admin', '1', 'index', '系统首页', '0', 'a:3:{s:9:\"tablename\";s:9:\"gdsfgsdfg\";s:9:\"fieldname\";s:6:\"gewter\";s:11:\"otheroption\";a:2:{s:8:\"datalist\";s:1:\"1\";s:7:\"prepage\";s:1:\"1\";}}', '');
INSERT INTO `wxq_yiqixueba_server_menu` VALUES ('6', 'server', 'admin', '0', 'pro', '程序设计', '1', '', '');
INSERT INTO `wxq_yiqixueba_server_menu` VALUES ('7', 'server', 'admin', '6', 'prosetting', '程序设置', '0', '', '');
INSERT INTO `wxq_yiqixueba_server_menu` VALUES ('8', 'server', 'admin', '6', 'proadmin', '程序管理', '1', '', '');
INSERT INTO `wxq_yiqixueba_server_menu` VALUES ('9', 'server', 'admin', '1', 'menu', '菜单管理', '5', '', '');
INSERT INTO `wxq_yiqixueba_server_menu` VALUES ('10', 'server', 'admin', '1', 'sitegroup', '战长组', '3', '', '');
INSERT INTO `wxq_yiqixueba_server_menu` VALUES ('11', '', '', '21', 'shopadmin', '商家管理', '2', '', '');
INSERT INTO `wxq_yiqixueba_server_menu` VALUES ('12', '', '', '21', 'shoptype', '商家组', '1', '', '');
INSERT INTO `wxq_yiqixueba_server_menu` VALUES ('13', '', '', '21', 'site', '站长管理', '1', '', '');
INSERT INTO `wxq_yiqixueba_server_menu` VALUES ('14', '', '', '21', 'site', '站长管理', '0', '', '');
INSERT INTO `wxq_yiqixueba_server_menu` VALUES ('15', '', 'api', '0', 'capi', '客户端到服务器', '0', '', '');
INSERT INTO `wxq_yiqixueba_server_menu` VALUES ('16', '', 'api', '0', 'sapi', '服务器到客户端', '0', '', '');
INSERT INTO `wxq_yiqixueba_server_menu` VALUES ('17', '', 'api', '15', 'install', '插件安装', '0', '', '');

-- ----------------------------
-- Table structure for `wxq_yiqixueba_server_mokuai`
-- ----------------------------
DROP TABLE IF EXISTS `wxq_yiqixueba_server_mokuai`;
CREATE TABLE `wxq_yiqixueba_server_mokuai` (
  `mokuaiid` mediumint(6) unsigned NOT NULL auto_increment,
  `mokuainame` char(40) NOT NULL,
  `mokuaititle` char(40) NOT NULL,
  `displayorder` smallint(6) NOT NULL,
  `mokuaiico` varchar(255) NOT NULL,
  `upid` smallint(6) NOT NULL,
  `level` smallint(3) NOT NULL,
  `mokuaidescription` varchar(255) NOT NULL,
  `mokuaiver` mediumint(6) NOT NULL,
  PRIMARY KEY  (`mokuaiid`)
) ENGINE=MyISAM AUTO_INCREMENT=24 DEFAULT CHARSET=gbk;

-- ----------------------------
-- Records of wxq_yiqixueba_server_mokuai
-- ----------------------------
INSERT INTO `wxq_yiqixueba_server_mokuai` VALUES ('1', 'yikatong', '一卡通', '3', 'cf/103433ois5g5lhimgmm5i4.jpg', '4', '2', '', '1');
INSERT INTO `wxq_yiqixueba_server_mokuai` VALUES ('2', 'brand', '联盟商家', '2', 'cf/141043wz4dp5e8lxxkke4t.jpg', '4', '2', '', '2');
INSERT INTO `wxq_yiqixueba_server_mokuai` VALUES ('3', 'wxq123', '微信墙123', '4', 'cf/103522oekkwso8krkxmdsz.jpg', '4', '2', '', '3');
INSERT INTO `wxq_yiqixueba_server_mokuai` VALUES ('4', 'yiqixueba', '一起学吧平台', '1', '', '5', '1', '这是一起学吧的基础平台的程序', '4');
INSERT INTO `wxq_yiqixueba_server_mokuai` VALUES ('5', 'yiqixueba_server', '一起学吧服务端', '0', '', '0', '0', '', '5');
INSERT INTO `wxq_yiqixueba_server_mokuai` VALUES ('6', 'zixun', '资讯', '5', '', '2', '3', '', '7');
INSERT INTO `wxq_yiqixueba_server_mokuai` VALUES ('8', 'dianping', '点评', '7', '', '2', '3', '', '9');
INSERT INTO `wxq_yiqixueba_server_mokuai` VALUES ('9', 'chanpinku', '产品库', '8', '', '2', '3', '', '10');
INSERT INTO `wxq_yiqixueba_server_mokuai` VALUES ('10', 'lipin', '礼品', '9', '', '2', '3', '', '11');
INSERT INTO `wxq_yiqixueba_server_mokuai` VALUES ('11', 'youhuiquan', '优惠券', '10', '', '2', '3', '', '12');
INSERT INTO `wxq_yiqixueba_server_mokuai` VALUES ('12', 'tuangou', '团购', '11', '', '2', '3', '', '13');
INSERT INTO `wxq_yiqixueba_server_mokuai` VALUES ('13', 'fenleixinxi', '分类信息', '12', '', '2', '3', '', '14');
INSERT INTO `wxq_yiqixueba_server_mokuai` VALUES ('14', 'huodong', '活动', '13', '', '2', '3', '', '15');
INSERT INTO `wxq_yiqixueba_server_mokuai` VALUES ('15', 'wenda', '问答', '14', '', '2', '3', '', '16');
INSERT INTO `wxq_yiqixueba_server_mokuai` VALUES ('23', 'cardelm', '卡益联盟', '0', 'cf/175307fyo6i2byzfnqj2ni.png', '4', '2', '', '27');

-- ----------------------------
-- Table structure for `wxq_yiqixueba_server_mokuai_copy`
-- ----------------------------
DROP TABLE IF EXISTS `wxq_yiqixueba_server_mokuai_copy`;
CREATE TABLE `wxq_yiqixueba_server_mokuai_copy` (
  `mokuaiid` smallint(6) unsigned NOT NULL auto_increment,
  `groupid` smallint(6) NOT NULL,
  `versionname` char(50) NOT NULL,
  `mokuaidescription` varchar(255) NOT NULL,
  `mokuaipice` int(10) NOT NULL,
  `displayorder` smallint(6) NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY  (`mokuaiid`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=gbk;

-- ----------------------------
-- Records of wxq_yiqixueba_server_mokuai_copy
-- ----------------------------
INSERT INTO `wxq_yiqixueba_server_mokuai_copy` VALUES ('1', '1', 'V1.0', '在一起学吧平台插件上的一卡通模块', '1000', '0', '1');
INSERT INTO `wxq_yiqixueba_server_mokuai_copy` VALUES ('2', '2', 'V1.0', '', '500', '0', '1');
INSERT INTO `wxq_yiqixueba_server_mokuai_copy` VALUES ('3', '3', 'V1.0', '', '500', '0', '1');
INSERT INTO `wxq_yiqixueba_server_mokuai_copy` VALUES ('4', '4', 'V1.0', '整个程序的主程序', '0', '0', '1');
INSERT INTO `wxq_yiqixueba_server_mokuai_copy` VALUES ('5', '5', 'V1.0', '服务端程序', '0', '0', '1');
INSERT INTO `wxq_yiqixueba_server_mokuai_copy` VALUES ('7', '6', 'V1.0', '', '200', '0', '1');
INSERT INTO `wxq_yiqixueba_server_mokuai_copy` VALUES ('8', '7', 'V1.0', '', '200', '0', '1');
INSERT INTO `wxq_yiqixueba_server_mokuai_copy` VALUES ('9', '8', 'V1.0', '', '200', '0', '1');
INSERT INTO `wxq_yiqixueba_server_mokuai_copy` VALUES ('10', '9', 'V1.0', '', '200', '0', '1');
INSERT INTO `wxq_yiqixueba_server_mokuai_copy` VALUES ('11', '10', 'V1.0', '', '200', '0', '1');
INSERT INTO `wxq_yiqixueba_server_mokuai_copy` VALUES ('12', '11', 'V1.0', '', '200', '0', '1');
INSERT INTO `wxq_yiqixueba_server_mokuai_copy` VALUES ('13', '12', 'V1.0', '', '500', '0', '1');
INSERT INTO `wxq_yiqixueba_server_mokuai_copy` VALUES ('14', '13', 'V1.0', '', '200', '0', '1');
INSERT INTO `wxq_yiqixueba_server_mokuai_copy` VALUES ('15', '14', 'V1.0', '', '200', '0', '1');
INSERT INTO `wxq_yiqixueba_server_mokuai_copy` VALUES ('16', '15', 'V1.0', '', '200', '0', '1');
INSERT INTO `wxq_yiqixueba_server_mokuai_copy` VALUES ('17', '16', 'V1.0', '', '500', '0', '1');

-- ----------------------------
-- Table structure for `wxq_yiqixueba_server_mokuai_copy1`
-- ----------------------------
DROP TABLE IF EXISTS `wxq_yiqixueba_server_mokuai_copy1`;
CREATE TABLE `wxq_yiqixueba_server_mokuai_copy1` (
  `mokuaiid` smallint(6) unsigned NOT NULL auto_increment,
  `mokuainame` char(40) NOT NULL,
  `mokuaititle` char(40) NOT NULL,
  `displayorder` smallint(6) NOT NULL,
  `mokuaiico` varchar(255) NOT NULL,
  `upid` smallint(6) NOT NULL,
  `level` smallint(3) NOT NULL,
  `version` char(20) NOT NULL,
  `mokuaidescription` varchar(255) NOT NULL,
  `mokuaipice` int(10) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `upmokuai` char(40) NOT NULL,
  PRIMARY KEY  (`mokuaiid`)
) ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=gbk;

-- ----------------------------
-- Records of wxq_yiqixueba_server_mokuai_copy1
-- ----------------------------
INSERT INTO `wxq_yiqixueba_server_mokuai_copy1` VALUES ('1', 'yikatong', '一卡通', '3', 'cf/103433ois5g5lhimgmm5i4.jpg', '4', '2', '', '', '0', '0', 'yiqixueba');
INSERT INTO `wxq_yiqixueba_server_mokuai_copy1` VALUES ('2', 'brand', '联盟商家', '2', '', '4', '2', '', '', '0', '0', 'yiqixueba');
INSERT INTO `wxq_yiqixueba_server_mokuai_copy1` VALUES ('3', 'wxq123', '微信墙123', '4', 'cf/103522oekkwso8krkxmdsz.jpg', '4', '2', '', '', '0', '0', 'yiqixueba');
INSERT INTO `wxq_yiqixueba_server_mokuai_copy1` VALUES ('4', 'yiqixueba', '一起学吧平台', '1', '', '0', '0', '', '', '0', '0', '');
INSERT INTO `wxq_yiqixueba_server_mokuai_copy1` VALUES ('5', 'yiqixueba_server', '一起学吧服务端', '0', '', '0', '0', '', '', '0', '0', '');
INSERT INTO `wxq_yiqixueba_server_mokuai_copy1` VALUES ('6', 'zixun', '资讯', '5', '', '2', '3', '', '', '0', '0', 'brand');
INSERT INTO `wxq_yiqixueba_server_mokuai_copy1` VALUES ('7', 'zhuti', '主题', '6', '', '2', '3', '', '', '0', '0', 'brand');
INSERT INTO `wxq_yiqixueba_server_mokuai_copy1` VALUES ('8', 'dianping', '点评', '7', '', '2', '3', '', '', '0', '0', 'brand');
INSERT INTO `wxq_yiqixueba_server_mokuai_copy1` VALUES ('9', 'chanpinku', '产品库', '8', '', '2', '3', '', '', '0', '0', 'brand');
INSERT INTO `wxq_yiqixueba_server_mokuai_copy1` VALUES ('10', 'lipin', '礼品', '9', '', '2', '3', '', '', '0', '0', 'brand');
INSERT INTO `wxq_yiqixueba_server_mokuai_copy1` VALUES ('11', 'youhuiquan', '优惠券', '10', '', '2', '3', '', '', '0', '0', 'brand');
INSERT INTO `wxq_yiqixueba_server_mokuai_copy1` VALUES ('12', 'tuangou', '团购', '11', '', '2', '3', '', '', '0', '0', 'brand');
INSERT INTO `wxq_yiqixueba_server_mokuai_copy1` VALUES ('13', 'fenleixinxi', '分类信息', '12', '', '2', '3', '', '', '0', '0', 'brand');
INSERT INTO `wxq_yiqixueba_server_mokuai_copy1` VALUES ('14', 'huodong', '活动', '13', '', '2', '3', '', '', '0', '0', 'brand');
INSERT INTO `wxq_yiqixueba_server_mokuai_copy1` VALUES ('15', 'wenda', '问答', '14', '', '2', '3', '', '', '0', '0', 'brand');
INSERT INTO `wxq_yiqixueba_server_mokuai_copy1` VALUES ('16', 'ykttuangou', '卡团购', '15', '', '1', '3', '', '', '0', '0', 'yikatong');

-- ----------------------------
-- Table structure for `wxq_yiqixueba_server_mokuaiver`
-- ----------------------------
DROP TABLE IF EXISTS `wxq_yiqixueba_server_mokuaiver`;
CREATE TABLE `wxq_yiqixueba_server_mokuaiver` (
  `verid` smallint(6) unsigned NOT NULL auto_increment,
  `mokuaiid` smallint(6) NOT NULL,
  `versionname` char(50) NOT NULL,
  `mokuaidescription` varchar(255) NOT NULL,
  `mokuaipice` int(10) NOT NULL,
  `displayorder` smallint(6) NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY  (`verid`)
) ENGINE=MyISAM AUTO_INCREMENT=36 DEFAULT CHARSET=gbk;

-- ----------------------------
-- Records of wxq_yiqixueba_server_mokuaiver
-- ----------------------------
INSERT INTO `wxq_yiqixueba_server_mokuaiver` VALUES ('1', '1', 'V1.0', '在一起学吧平台插件上的一卡通模块', '1000', '200', '1');
INSERT INTO `wxq_yiqixueba_server_mokuaiver` VALUES ('2', '2', 'V1.0', '', '500', '100', '1');
INSERT INTO `wxq_yiqixueba_server_mokuaiver` VALUES ('3', '3', 'V1.0', '', '500', '300', '1');
INSERT INTO `wxq_yiqixueba_server_mokuaiver` VALUES ('4', '4', 'V1.0', '整个程序的主程序', '0', '10', '1');
INSERT INTO `wxq_yiqixueba_server_mokuaiver` VALUES ('5', '5', 'V1.0', '服务端程序', '0', '0', '1');
INSERT INTO `wxq_yiqixueba_server_mokuaiver` VALUES ('7', '6', 'V1.0', '', '200', '114', '1');
INSERT INTO `wxq_yiqixueba_server_mokuaiver` VALUES ('9', '8', 'V1.0', '', '200', '112', '1');
INSERT INTO `wxq_yiqixueba_server_mokuaiver` VALUES ('10', '9', 'V1.0', '', '200', '111', '1');
INSERT INTO `wxq_yiqixueba_server_mokuaiver` VALUES ('11', '10', 'V1.0', '', '200', '110', '1');
INSERT INTO `wxq_yiqixueba_server_mokuaiver` VALUES ('12', '11', 'V1.0', '', '200', '109', '1');
INSERT INTO `wxq_yiqixueba_server_mokuaiver` VALUES ('13', '12', 'V1.0', '', '500', '108', '1');
INSERT INTO `wxq_yiqixueba_server_mokuaiver` VALUES ('14', '13', 'V1.0', '', '200', '107', '1');
INSERT INTO `wxq_yiqixueba_server_mokuaiver` VALUES ('15', '14', 'V1.0', '', '0', '106', '1');
INSERT INTO `wxq_yiqixueba_server_mokuaiver` VALUES ('16', '15', 'V1.0', '', '0', '105', '1');
INSERT INTO `wxq_yiqixueba_server_mokuaiver` VALUES ('22', '1', 'V2.0', '测试', '0', '0', '0');
INSERT INTO `wxq_yiqixueba_server_mokuaiver` VALUES ('27', '23', 'V1.0', '', '200', '0', '0');

-- ----------------------------
-- Table structure for `wxq_yiqixueba_server_page`
-- ----------------------------
DROP TABLE IF EXISTS `wxq_yiqixueba_server_page`;
CREATE TABLE `wxq_yiqixueba_server_page` (
  `pageid` mediumint(8) unsigned NOT NULL auto_increment,
  `mokuai` char(20) NOT NULL,
  `mokuaiver` smallint(6) default NULL,
  `pagetype` char(10) NOT NULL,
  `menu` char(50) NOT NULL,
  `pagename` char(50) NOT NULL,
  `pagetitle` char(50) NOT NULL,
  `pagedescription` varchar(255) NOT NULL,
  `displayorder` smallint(6) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `ruls` text NOT NULL,
  `pagecontents` text NOT NULL,
  PRIMARY KEY  (`pageid`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=gbk;

-- ----------------------------
-- Records of wxq_yiqixueba_server_page
-- ----------------------------
INSERT INTO `wxq_yiqixueba_server_page` VALUES ('9', 'ver4', '18', 'admin', '', 'index', '系统首页', '系统首页，类似桌面，即时消息、提醒等', '0', '1', '', '');
INSERT INTO `wxq_yiqixueba_server_page` VALUES ('6', 'ver5', '18', 'admin', '', 'index', '系统首页', '', '2', '1', '', '');
INSERT INTO `wxq_yiqixueba_server_page` VALUES ('8', 'ver5', '18', 'admin', '', 'setting', '系统设置', '', '1', '1', '', '');
INSERT INTO `wxq_yiqixueba_server_page` VALUES ('10', 'ver4', '18', 'admin', '', 'setting', '系统设置', '', '1', '1', '', '');
INSERT INTO `wxq_yiqixueba_server_page` VALUES ('11', 'ver4', '18', 'admin', '', 'reg', '插件注册', '', '2', '1', '', '');
INSERT INTO `wxq_yiqixueba_server_page` VALUES ('12', 'ver4', '18', 'admin', '', 'mokuai', '模块管理', '核心页面', '3', '1', '', '');

-- ----------------------------
-- Table structure for `wxq_yiqixueba_server_page_adminac`
-- ----------------------------
DROP TABLE IF EXISTS `wxq_yiqixueba_server_page_adminac`;
CREATE TABLE `wxq_yiqixueba_server_page_adminac` (
  `adminacid` mediumint(8) unsigned NOT NULL auto_increment,
  `pageid` smallint(6) NOT NULL,
  `adminactype` char(10) character set gbk NOT NULL,
  `adminacname` char(20) character set gbk NOT NULL,
  `adminactitle` char(20) character set gbk NOT NULL,
  `displayorder` smallint(6) NOT NULL,
  `adminacrule` text character set gbk,
  PRIMARY KEY  (`adminacid`)
) ENGINE=MyISAM AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of wxq_yiqixueba_server_page_adminac
-- ----------------------------
INSERT INTO `wxq_yiqixueba_server_page_adminac` VALUES ('1', '9', 'setting', 'datalist', '数据列表', '0', null);
INSERT INTO `wxq_yiqixueba_server_page_adminac` VALUES ('2', '9', 'datalist', 'listtext', '列表测试', '0', 'a:10:{s:9:\"page_tips\";s:4:\"测试\";s:10:\"globallink\";s:0:\"\";s:11:\"searchfield\";s:0:\"\";s:9:\"tablename\";s:3:\"fff\";s:9:\"fieldinfo\";s:0:\"\";s:10:\"listheader\";s:0:\"\";s:8:\"listinfo\";s:0:\"\";s:8:\"listlink\";s:4:\"发放\";s:7:\"prepage\";s:1:\"1\";s:7:\"listdel\";s:1:\"1\";}');
INSERT INTO `wxq_yiqixueba_server_page_adminac` VALUES ('3', '12', 'datalist', 'mokuailist', '模块列表', '0', null);

-- ----------------------------
-- Table structure for `wxq_yiqixueba_server_page_copy`
-- ----------------------------
DROP TABLE IF EXISTS `wxq_yiqixueba_server_page_copy`;
CREATE TABLE `wxq_yiqixueba_server_page_copy` (
  `pageid` mediumint(8) unsigned NOT NULL auto_increment,
  `mokuai` char(20) NOT NULL,
  `pagetype` char(10) NOT NULL,
  `menu` char(50) NOT NULL,
  `filename` char(50) NOT NULL,
  `filetitle` char(50) NOT NULL,
  `pagedescription` varchar(255) NOT NULL,
  `displayorder` smallint(6) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `ruls` text NOT NULL,
  `pagecontents` text NOT NULL,
  PRIMARY KEY  (`pageid`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=gbk;

-- ----------------------------
-- Records of wxq_yiqixueba_server_page_copy
-- ----------------------------
INSERT INTO `wxq_yiqixueba_server_page_copy` VALUES ('1', '2', 'admin', '商家管理', 'shopsort', '商家分类', '分类设置', '0', '1', '', 'echo &quot;haha1&quot;;\r\nvar_dump(\'jhdsag\');');
INSERT INTO `wxq_yiqixueba_server_page_copy` VALUES ('2', '1', 'api', '', '', '模块安装', '', '0', '0', '', '');
INSERT INTO `wxq_yiqixueba_server_page_copy` VALUES ('3', 'client', 'admin', '基础设置', 'base', '基础设置', '', '0', '0', '', '');
INSERT INTO `wxq_yiqixueba_server_page_copy` VALUES ('9', 'ver4', 'admin', '', 'index', '系统首页', '系统首页，类似桌面，即时消息、提醒等', '0', '0', '', '');
INSERT INTO `wxq_yiqixueba_server_page_copy` VALUES ('5', 'server', 'admin', '', '', '系统首页', '', '0', '0', '', '');
INSERT INTO `wxq_yiqixueba_server_page_copy` VALUES ('6', 'ver5', 'admin', '', 'index', '系统首页', '', '0', '0', '', '');
INSERT INTO `wxq_yiqixueba_server_page_copy` VALUES ('8', 'ver5', 'admin', '', 'setting', '系统设置', '', '1', '0', '', '');
INSERT INTO `wxq_yiqixueba_server_page_copy` VALUES ('10', 'ver4', 'admin', '', 'setting', '系统设置', '', '1', '0', '', '');
INSERT INTO `wxq_yiqixueba_server_page_copy` VALUES ('11', 'ver4', 'admin', '', 'reg', '插件注册', '', '2', '0', '', '');
INSERT INTO `wxq_yiqixueba_server_page_copy` VALUES ('12', 'ver4', 'admin', '', 'mokuai', '模块管理', '核心页面', '3', '0', '', '');

-- ----------------------------
-- Table structure for `wxq_yiqixueba_server_site`
-- ----------------------------
DROP TABLE IF EXISTS `wxq_yiqixueba_server_site`;
CREATE TABLE `wxq_yiqixueba_server_site` (
  `siteid` mediumint(8) unsigned NOT NULL auto_increment,
  `sitegroupid` smallint(3) NOT NULL,
  `siteurl` varchar(255) NOT NULL,
  `salt` char(6) NOT NULL,
  `sitekey` char(32) NOT NULL,
  `searchurl` varchar(255) NOT NULL,
  `charset` char(10) NOT NULL,
  `clientip` char(15) NOT NULL,
  `version` char(50) NOT NULL,
  `installtime` int(10) unsigned NOT NULL,
  `updatetime` int(10) unsigned NOT NULL,
  `uninstalltime` int(10) unsigned NOT NULL,
  `regtime` int(10) NOT NULL,
  `realname` char(20) NOT NULL,
  `phone` char(80) NOT NULL,
  `address` char(100) NOT NULL,
  `jianyi` varchar(255) NOT NULL,
  `prov` char(30) NOT NULL,
  `city` char(30) NOT NULL,
  `dist` char(30) NOT NULL,
  `groupexpiry` int(10) unsigned NOT NULL,
  `status` tinyint(1) NOT NULL,
  `mokuais` text NOT NULL,
  `shibiema` char(4) NOT NULL,
  `token` char(6) NOT NULL,
  PRIMARY KEY  (`siteid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=gbk;

-- ----------------------------
-- Records of wxq_yiqixueba_server_site
-- ----------------------------
INSERT INTO `wxq_yiqixueba_server_site` VALUES ('1', '2', 'http://www.wxq123.com/', 'FC189G', 'ce33719144dd5eee020b4af8bcc7c2c6', 'http://wxq123.com/', 'gbk', '', '', '0', '1372615250', '0', '0', '杨文', '13113890911', '河北省石家庄市新苑南区', '', '河北省', '石家庄市', '', '1401379200', '1', 'a:5:{i:0;s:0:\"\";i:1;s:2:\"10\";i:2;s:2:\"11\";i:3;s:0:\"\";i:4;s:0:\"\";}', '2812', 'M8W6c8');

-- ----------------------------
-- Table structure for `wxq_yiqixueba_server_sitegroup`
-- ----------------------------
DROP TABLE IF EXISTS `wxq_yiqixueba_server_sitegroup`;
CREATE TABLE `wxq_yiqixueba_server_sitegroup` (
  `sitegroupid` smallint(3) unsigned NOT NULL auto_increment,
  `sitegroupname` char(20) character set gbk NOT NULL,
  `mokuais` text character set gbk NOT NULL,
  PRIMARY KEY  (`sitegroupid`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of wxq_yiqixueba_server_sitegroup
-- ----------------------------
INSERT INTO `wxq_yiqixueba_server_sitegroup` VALUES ('1', '测试组', 'a:8:{i:0;s:1:\"4\";i:1;s:1:\"2\";i:2;s:1:\"1\";i:3;s:1:\"3\";i:4;s:1:\"9\";i:5;s:2:\"11\";i:6;s:2:\"12\";i:7;s:2:\"16\";}');
INSERT INTO `wxq_yiqixueba_server_sitegroup` VALUES ('2', '安装组', 'a:20:{i:0;s:0:\"\";i:1;s:0:\"\";i:2;s:0:\"\";i:3;s:0:\"\";i:4;s:0:\"\";i:5;s:0:\"\";i:6;s:0:\"\";i:7;s:0:\"\";i:8;s:0:\"\";i:9;s:0:\"\";i:10;s:0:\"\";i:11;s:0:\"\";i:12;s:0:\"\";i:13;s:0:\"\";i:14;s:0:\"\";i:15;s:0:\"\";i:16;s:0:\"\";i:17;s:0:\"\";i:18;s:0:\"\";i:19;s:0:\"\";}');

-- ----------------------------
-- Table structure for `wxq_yiqixueba_server_wxq123_member`
-- ----------------------------
DROP TABLE IF EXISTS `wxq_yiqixueba_server_wxq123_member`;
CREATE TABLE `wxq_yiqixueba_server_wxq123_member` (
  `memberid` mediumint(8) unsigned NOT NULL auto_increment,
  `membertype` tinyint(1) NOT NULL,
  `typeid` mediumint(8) NOT NULL,
  `shibiema` char(10) character set gbk NOT NULL,
  `token` char(8) character set gbk NOT NULL,
  `weixinimg` char(80) character set gbk NOT NULL,
  `tijiaotime` int(10) unsigned default NULL,
  PRIMARY KEY  (`memberid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of wxq_yiqixueba_server_wxq123_member
-- ----------------------------
INSERT INTO `wxq_yiqixueba_server_wxq123_member` VALUES ('1', '0', '1', '2812', 'M8W6c8', '', '1372603574');

-- ----------------------------
-- Table structure for `wxq_yiqixueba_setting`
-- ----------------------------
DROP TABLE IF EXISTS `wxq_yiqixueba_setting`;
CREATE TABLE `wxq_yiqixueba_setting` (
  `settingid` mediumint(8) unsigned NOT NULL auto_increment,
  `mokuaiid` mediumint(8) NOT NULL,
  `skey` varchar(255) NOT NULL,
  `svalue` text NOT NULL,
  PRIMARY KEY  (`settingid`)
) ENGINE=MyISAM AUTO_INCREMENT=75 DEFAULT CHARSET=gbk;

-- ----------------------------
-- Records of wxq_yiqixueba_setting
-- ----------------------------
INSERT INTO `wxq_yiqixueba_setting` VALUES ('1', '0', 'thistemplate', 'default');
INSERT INTO `wxq_yiqixueba_setting` VALUES ('2', '0', 'sitekey', 'ce33719144dd5eee020b4af8bcc7c2c6');
INSERT INTO `wxq_yiqixueba_setting` VALUES ('8', '0', 'yiqixueba_brand_nav_menu', '1');
INSERT INTO `wxq_yiqixueba_setting` VALUES ('4', '0', 'yiqixueba_tuangou_top_menu', '0');
INSERT INTO `wxq_yiqixueba_setting` VALUES ('5', '0', 'yiqixueba_tuangou_nav_menu', '1');
INSERT INTO `wxq_yiqixueba_setting` VALUES ('6', '0', 'yiqixueba_yikatong_nav_menu', '1');
INSERT INTO `wxq_yiqixueba_setting` VALUES ('7', '0', 'yiqixueba_yikatong_top_menu', '0');
INSERT INTO `wxq_yiqixueba_setting` VALUES ('9', '0', 'yiqixueba_brand_top_menu', '0');
INSERT INTO `wxq_yiqixueba_setting` VALUES ('10', '0', 'yiqixueba_chanpinku_nav_menu', '1');
INSERT INTO `wxq_yiqixueba_setting` VALUES ('11', '0', 'yiqixueba_chanpinku_top_menu', '0');
INSERT INTO `wxq_yiqixueba_setting` VALUES ('12', '0', 'yiqixueba_brand_thistemplate', 'default');
INSERT INTO `wxq_yiqixueba_setting` VALUES ('13', '0', 'yiqixueba_youhuiquan_nav_menu', '1');
INSERT INTO `wxq_yiqixueba_setting` VALUES ('14', '0', 'yiqixueba_youhuiquan_top_menu', '0');
INSERT INTO `wxq_yiqixueba_setting` VALUES ('15', '0', 'yiqixueba_yikatong_shop_table', 'yiqixueba_brand_shop');
INSERT INTO `wxq_yiqixueba_setting` VALUES ('16', '0', 'yiqixueba_yikatong_fields', 'a:3:{s:6:\"shopid\";s:6:\"shopid\";s:8:\"shopname\";s:8:\"shopname\";s:3:\"uid\";s:3:\"uid\";}');
INSERT INTO `wxq_yiqixueba_setting` VALUES ('27', '0', 'yiqixueba_brand_dianping_content_minlen', '12');
INSERT INTO `wxq_yiqixueba_setting` VALUES ('17', '0', 'yiqixueba_yikatong_shop_url', 'plugin.php?id=yiqixueba&submod=shopdisplay&shopid={shopid}');
INSERT INTO `wxq_yiqixueba_setting` VALUES ('18', '0', 'yiqixueba_wxq123_nav_menu', '0');
INSERT INTO `wxq_yiqixueba_setting` VALUES ('19', '0', 'yiqixueba_wxq123_top_menu', '0');
INSERT INTO `wxq_yiqixueba_setting` VALUES ('20', '0', 'yiqixueba_wxq123_shop_table', 'yiqixueba_brand_shop');
INSERT INTO `wxq_yiqixueba_setting` VALUES ('21', '0', 'yiqixueba_wxq123_shop_url', 'plugin.php?id=yiqixueba&submod=shopdisplay&shopid={shopid}');
INSERT INTO `wxq_yiqixueba_setting` VALUES ('22', '0', 'yiqixueba_wxq123_fields', 'a:4:{s:6:\"shopid\";s:6:\"shopid\";s:8:\"shopname\";s:8:\"shopname\";s:10:\"shopmanage\";s:3:\"uid\";s:12:\"shoplocation\";s:12:\"shoplocation\";}');
INSERT INTO `wxq_yiqixueba_setting` VALUES ('23', '0', 'yiqixueba_yikatong_money', '2');
INSERT INTO `wxq_yiqixueba_setting` VALUES ('24', '0', 'yiqixueba_yikatong_jifen', '3');
INSERT INTO `wxq_yiqixueba_setting` VALUES ('25', '0', 'yiqixueba_yikatong_shop_addurl', '');
INSERT INTO `wxq_yiqixueba_setting` VALUES ('28', '0', 'yiqixueba_brand_dianping_content_maxlen', '120');
INSERT INTO `wxq_yiqixueba_setting` VALUES ('26', '0', 'yiqixueba_yikatong_shop_logourl', 'http://www.wxq123.com/data/attachment/common/');
INSERT INTO `wxq_yiqixueba_setting` VALUES ('29', '0', 'yiqixueba_brand_dianping_recontent', '1');
INSERT INTO `wxq_yiqixueba_setting` VALUES ('30', '0', 'yiqixueba_brand_dianping_recontent_minlen', '');
INSERT INTO `wxq_yiqixueba_setting` VALUES ('31', '0', 'yiqixueba_brand_dianping_recontent_maxlen', '');
INSERT INTO `wxq_yiqixueba_setting` VALUES ('32', '0', 'yiqixueba_brand_dianping_recontent_num', '10');
INSERT INTO `wxq_yiqixueba_setting` VALUES ('33', '0', 'yiqixueba_brand_dianping_subtype', '2');
INSERT INTO `wxq_yiqixueba_setting` VALUES ('34', '0', 'yiqixueba_brand_dianping_xiaoshu', '1');
INSERT INTO `wxq_yiqixueba_setting` VALUES ('35', '0', 'yiqixueba_brand_dianping_option', 'a:1:{i:0;a:3:{s:4:\"name\";s:4:\"测试\";s:5:\"title\";s:26:\"口味|服务|环境|性价比|口碑\";s:6:\"status\";i:1;}}');
INSERT INTO `wxq_yiqixueba_setting` VALUES ('36', '0', 'yiqixueba_brand_botton1', 'cf/164723flwql56ariwwh59c.jpg');
INSERT INTO `wxq_yiqixueba_setting` VALUES ('37', '0', 'yiqixueba_brand_botton2', '');
INSERT INTO `wxq_yiqixueba_setting` VALUES ('38', '0', 'yiqixueba_brand_botton3', '');
INSERT INTO `wxq_yiqixueba_setting` VALUES ('39', '0', 'yiqixueba_brand_botton4', '');
INSERT INTO `wxq_yiqixueba_setting` VALUES ('40', '0', 'yiqixueba_yikatong_shopgroup', '1');
INSERT INTO `wxq_yiqixueba_setting` VALUES ('41', '0', 'yiqixueba_yikatong_goods_table', 'yiqixueba_brand_chanpinku');
INSERT INTO `wxq_yiqixueba_setting` VALUES ('42', '0', 'yiqixueba_yikatong_goods_url', 'plugin.php?id=yiqixueba&submod=cpkdisplay&cpkid={goodsid}');
INSERT INTO `wxq_yiqixueba_setting` VALUES ('43', '0', 'yiqixueba_yikatong_goods_addurl', '');
INSERT INTO `wxq_yiqixueba_setting` VALUES ('44', '0', 'yiqixueba_yikatong_goods_logourl', '');
INSERT INTO `wxq_yiqixueba_setting` VALUES ('45', '0', 'yiqixueba_yikatong_goodsfields', 'a:4:{s:7:\"goodsid\";s:11:\"chanpinkuid\";s:6:\"shopid\";s:6:\"shopid\";s:9:\"goodsname\";s:13:\"chanpinkuname\";s:9:\"goodspice\";s:4:\"pice\";}');
INSERT INTO `wxq_yiqixueba_setting` VALUES ('46', '0', 'yiqixueba_yikatong_jicihelp', '计次消费帮助内容');
INSERT INTO `wxq_yiqixueba_setting` VALUES ('47', '0', 'yiqixueba_yikatong_shijianhelp', '时间限制帮助内容');
INSERT INTO `wxq_yiqixueba_setting` VALUES ('48', '0', 'yiqixueba_yikatong_liangkahelp', '亮卡打折帮助信息');
INSERT INTO `wxq_yiqixueba_setting` VALUES ('49', '0', 'yiqixueba_yikatong_xianjinhelp', '现金消费帮助信息');
INSERT INTO `wxq_yiqixueba_setting` VALUES ('50', '0', 'yiqixueba_yikatong_yuehelp', '余额消费帮助信息');
INSERT INTO `wxq_yiqixueba_setting` VALUES ('51', '0', 'yiqixueba_yikatong_jifenhelp', '积分消费帮助信息');
INSERT INTO `wxq_yiqixueba_setting` VALUES ('52', '0', 'yiqixueba_yikatong_businessgroup', '1');
INSERT INTO `wxq_yiqixueba_setting` VALUES ('53', '0', 'joinbusiness', 'gdfgdfgdf');
INSERT INTO `wxq_yiqixueba_setting` VALUES ('54', '0', 'yiqixueba_yikatong_joinbusiness', '&nbsp;');
INSERT INTO `wxq_yiqixueba_setting` VALUES ('55', '0', 'yiqixueba_brand_gonggao1', '公告1标题');
INSERT INTO `wxq_yiqixueba_setting` VALUES ('56', '0', 'yiqixueba_brand_gonggao2', '公告2标题');
INSERT INTO `wxq_yiqixueba_setting` VALUES ('57', '0', 'yiqixueba_brand_gonggao3', '公告3标题');
INSERT INTO `wxq_yiqixueba_setting` VALUES ('58', '0', 'yiqixueba_brand_gonggao4', '公告4标题');
INSERT INTO `wxq_yiqixueba_setting` VALUES ('59', '0', 'yiqixueba_brand_gonggaotext1', '');
INSERT INTO `wxq_yiqixueba_setting` VALUES ('60', '0', 'yiqixueba_brand_gonggaotext2', '');
INSERT INTO `wxq_yiqixueba_setting` VALUES ('61', '0', 'yiqixueba_brand_gonggaotext3', '');
INSERT INTO `wxq_yiqixueba_setting` VALUES ('62', '0', 'yiqixueba_brand_gonggaotext4', '');
INSERT INTO `wxq_yiqixueba_setting` VALUES ('64', '0', 'yiqixueba_chanpinku_chanpinku_sort', '1=数码\r\n1.1=电脑\r\n1.1.1=台式机\r\n1.1.2=笔记本\r\n1.2=手机\r\n2=服装');
INSERT INTO `wxq_yiqixueba_setting` VALUES ('63', '0', 'yiqixueba_brand_businessgroup', '1');
INSERT INTO `wxq_yiqixueba_setting` VALUES ('65', '0', 'yiqixueba_chanpinku_fields', 'a:1:{i:1;a:4:{s:4:\"name\";s:3:\"ttt\";s:5:\"title\";s:6:\"他他他\";s:7:\"selectc\";s:18:\"1=哈哈\r\n1.1=不哈哈\";s:5:\"field\";s:6:\"select\";}}');
INSERT INTO `wxq_yiqixueba_setting` VALUES ('74', '0', 'index_tuisong', 'a:4:{s:8:\"huandeng\";a:2:{i:0;i:14;i:1;i:15;}s:7:\"toutiao\";a:1:{i:0;i:14;}s:6:\"wenben\";a:1:{i:0;i:14;}s:5:\"tuwen\";a:1:{i:0;i:14;}}');
INSERT INTO `wxq_yiqixueba_setting` VALUES ('66', '0', 'yiqixueba_chanpinku_sort', '1=数码\r\n1.1=电脑\r\n1.1.1=台式机\r\n1.1.2=笔记本\r\n1.2=手机\r\n2=服装');
INSERT INTO `wxq_yiqixueba_setting` VALUES ('68', '0', 'shop_tablename', '');
INSERT INTO `wxq_yiqixueba_setting` VALUES ('69', '0', 'shop_shopid', '');
INSERT INTO `wxq_yiqixueba_setting` VALUES ('70', '0', 'shop_shopname', '');
INSERT INTO `wxq_yiqixueba_setting` VALUES ('71', '0', 'shop_condition', '');
INSERT INTO `wxq_yiqixueba_setting` VALUES ('72', '0', 'regsetp1tips', '');

-- ----------------------------
-- Table structure for `wxq_yiqixueba_shop`
-- ----------------------------
DROP TABLE IF EXISTS `wxq_yiqixueba_shop`;
CREATE TABLE `wxq_yiqixueba_shop` (
  `shopid` mediumint(8) unsigned NOT NULL auto_increment,
  `shopname` char(20) character set gbk NOT NULL,
  `shopaddress` char(100) character set gbk NOT NULL,
  `shopphone` char(20) character set gbk NOT NULL,
  `shoplianxiren` char(20) character set gbk NOT NULL,
  `status` tinyint(1) NOT NULL,
  `shopsort` smallint(6) NOT NULL,
  `shopdescription` text character set gbk,
  PRIMARY KEY  (`shopid`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of wxq_yiqixueba_shop
-- ----------------------------
INSERT INTO `wxq_yiqixueba_shop` VALUES ('1', '测试商家', '河南省郑州市五七路118号', '0371-111111111', '好人', '0', '1', '&lt;DIV align=center&gt;&lt;STRONG&gt;适当&lt;/STRONG&gt;&lt;FONT color=#f00000&gt;放&lt;IMG src=&quot;http://www.wxq123.com/static/image/smiley/comcom/28.gif&quot;&gt;松的&lt;/FONT&gt;&lt;FONT color=#000080&gt;&lt;FONT size=5&gt;山东&lt;/FONT&gt;分公司的&lt;/FONT&gt;&lt;/DIV&gt;\r\n&lt;DIV align=center&gt;&lt;FONT color=#000080&gt;公司豆腐干地方&lt;/FONT&gt;&lt;/DIV&gt;');
INSERT INTO `wxq_yiqixueba_shop` VALUES ('2', '再测试一个', '阿四大时代', '0312-11123456', '银行间', '0', '2', null);

-- ----------------------------
-- Table structure for `wxq_yiqixueba_shop_adminmenu`
-- ----------------------------
DROP TABLE IF EXISTS `wxq_yiqixueba_shop_adminmenu`;
CREATE TABLE `wxq_yiqixueba_shop_adminmenu` (
  `menuid` smallint(6) unsigned NOT NULL auto_increment,
  `upid` smallint(6) NOT NULL,
  `menuname` char(50) character set gbk NOT NULL,
  `menutitle` char(50) character set gbk NOT NULL,
  `displayorder` smallint(6) NOT NULL,
  PRIMARY KEY  (`menuid`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of wxq_yiqixueba_shop_adminmenu
-- ----------------------------
INSERT INTO `wxq_yiqixueba_shop_adminmenu` VALUES ('1', '0', 'base', '基础设置', '0');
INSERT INTO `wxq_yiqixueba_shop_adminmenu` VALUES ('2', '1', 'reg', '插件注册', '2');
INSERT INTO `wxq_yiqixueba_shop_adminmenu` VALUES ('3', '1', 'basesetting', '基础设置', '1');
INSERT INTO `wxq_yiqixueba_shop_adminmenu` VALUES ('4', '0', 'shopadmin', '商家管理', '1');
INSERT INTO `wxq_yiqixueba_shop_adminmenu` VALUES ('5', '4', 'shopfield', '商家字段', '1');
INSERT INTO `wxq_yiqixueba_shop_adminmenu` VALUES ('6', '4', 'shopadmin', '商家管理', '2');
INSERT INTO `wxq_yiqixueba_shop_adminmenu` VALUES ('7', '1', 'index', '系统首页', '0');
INSERT INTO `wxq_yiqixueba_shop_adminmenu` VALUES ('8', '4', 'shoptype', '商家类型', '0');

-- ----------------------------
-- Table structure for `wxq_yiqixueba_shop_setting`
-- ----------------------------
DROP TABLE IF EXISTS `wxq_yiqixueba_shop_setting`;
CREATE TABLE `wxq_yiqixueba_shop_setting` (
  `settingid` mediumint(8) unsigned NOT NULL auto_increment,
  `mokuaiid` mediumint(8) NOT NULL,
  `skey` varchar(255) NOT NULL,
  `svalue` text NOT NULL,
  PRIMARY KEY  (`settingid`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

-- ----------------------------
-- Records of wxq_yiqixueba_shop_setting
-- ----------------------------

-- ----------------------------
-- Table structure for `wxq_yiqixueba_shop_shopfield`
-- ----------------------------
DROP TABLE IF EXISTS `wxq_yiqixueba_shop_shopfield`;
CREATE TABLE `wxq_yiqixueba_shop_shopfield` (
  `shopfieldid` smallint(6) unsigned NOT NULL auto_increment,
  PRIMARY KEY  (`shopfieldid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of wxq_yiqixueba_shop_shopfield
-- ----------------------------

-- ----------------------------
-- Table structure for `wxq_yiqixueba_shopsort_copy`
-- ----------------------------
DROP TABLE IF EXISTS `wxq_yiqixueba_shopsort_copy`;
CREATE TABLE `wxq_yiqixueba_shopsort_copy` (
  `shopsortid` smallint(6) unsigned NOT NULL auto_increment,
  `sortname` char(20) character set gbk NOT NULL,
  `sorttitle` char(20) character set gbk NOT NULL,
  `sortlevel` smallint(6) NOT NULL,
  `sortupid` smallint(6) NOT NULL,
  `displayorder` smallint(6) NOT NULL,
  PRIMARY KEY  (`shopsortid`)
) ENGINE=MyISAM AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of wxq_yiqixueba_shopsort_copy
-- ----------------------------
INSERT INTO `wxq_yiqixueba_shopsort_copy` VALUES ('1', 'tuangou', '团购', '1', '0', '0');
INSERT INTO `wxq_yiqixueba_shopsort_copy` VALUES ('2', 'test', '测试', '2', '1', '0');
INSERT INTO `wxq_yiqixueba_shopsort_copy` VALUES ('3', 'next', '再测试', '3', '2', '0');
INSERT INTO `wxq_yiqixueba_shopsort_copy` VALUES ('4', 'dashd', 'ashdsa', '2', '1', '0');

-- ----------------------------
-- Table structure for `wxq_yiqixueba_shoptype`
-- ----------------------------
DROP TABLE IF EXISTS `wxq_yiqixueba_shoptype`;
CREATE TABLE `wxq_yiqixueba_shoptype` (
  `shoptypeid` smallint(6) unsigned NOT NULL auto_increment,
  `shoptypename` char(50) character set gbk NOT NULL,
  `inshoufei` varchar(255) NOT NULL,
  `inshoufeiqixian` varchar(255) NOT NULL,
  `shoptypedescription` varchar(255) NOT NULL,
  `cardfeiyong` varchar(255) NOT NULL,
  `cardpice` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `shoptypeico` varchar(255) character set gbk NOT NULL,
  PRIMARY KEY  (`shoptypeid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of wxq_yiqixueba_shoptype
-- ----------------------------
INSERT INTO `wxq_yiqixueba_shoptype` VALUES ('1', '普通商家组', '300', '365', '', '', '', '1', '');

-- ----------------------------
-- Table structure for `wxq_yiqixueba_wxq123_adminmenu`
-- ----------------------------
DROP TABLE IF EXISTS `wxq_yiqixueba_wxq123_adminmenu`;
CREATE TABLE `wxq_yiqixueba_wxq123_adminmenu` (
  `menuid` smallint(6) unsigned NOT NULL auto_increment,
  `upid` smallint(6) NOT NULL,
  `menuname` char(50) character set gbk NOT NULL,
  `menutitle` char(50) character set gbk NOT NULL,
  `displayorder` smallint(6) NOT NULL,
  PRIMARY KEY  (`menuid`)
) ENGINE=MyISAM AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of wxq_yiqixueba_wxq123_adminmenu
-- ----------------------------
INSERT INTO `wxq_yiqixueba_wxq123_adminmenu` VALUES ('1', '0', 'base', '基础设置', '0');
INSERT INTO `wxq_yiqixueba_wxq123_adminmenu` VALUES ('2', '1', 'reg', '插件注册', '2');
INSERT INTO `wxq_yiqixueba_wxq123_adminmenu` VALUES ('3', '1', 'base', '基础设置', '1');
INSERT INTO `wxq_yiqixueba_wxq123_adminmenu` VALUES ('4', '0', 'shop', '商家管理', '1');
INSERT INTO `wxq_yiqixueba_wxq123_adminmenu` VALUES ('5', '1', 'index', '系统首页', '0');
INSERT INTO `wxq_yiqixueba_wxq123_adminmenu` VALUES ('6', '4', 'shopsetting', '商家设置', '0');
INSERT INTO `wxq_yiqixueba_wxq123_adminmenu` VALUES ('7', '4', 'shoptype', '商家类型', '1');
INSERT INTO `wxq_yiqixueba_wxq123_adminmenu` VALUES ('8', '4', 'shopadmin', '商家管理', '2');

-- ----------------------------
-- Table structure for `wxq_yiqixueba_wxq123_business`
-- ----------------------------
DROP TABLE IF EXISTS `wxq_yiqixueba_wxq123_business`;
CREATE TABLE `wxq_yiqixueba_wxq123_business` (
  `businessid` mediumint(8) unsigned NOT NULL auto_increment,
  `businessgroupid` smallint(3) NOT NULL,
  `relname` char(10) character set gbk NOT NULL,
  `businessname` char(40) character set gbk NOT NULL,
  `sex` tinyint(1) NOT NULL,
  `phone` char(15) character set gbk NOT NULL,
  `address` char(100) character set gbk NOT NULL,
  `birthday` int(10) unsigned NOT NULL,
  `gerenphoto` char(100) character set gbk NOT NULL,
  `shenfenno` char(20) NOT NULL,
  `shenfenphoto` char(100) character set gbk NOT NULL,
  `businesssummary` varchar(255) character set gbk NOT NULL,
  `contractimage` varchar(255) character set gbk NOT NULL,
  `status` tinyint(1) NOT NULL,
  `uid` mediumint(8) unsigned NOT NULL,
  `cardtype` smallint(3) NOT NULL,
  `cardnum` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`businessid`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of wxq_yiqixueba_wxq123_business
-- ----------------------------
INSERT INTO `wxq_yiqixueba_wxq123_business` VALUES ('2', '1', '康登', '我爱家居', '1', '0731-52663766', '湖南湘潭市岳塘区家家美建材超市', '1970', '', '43030219751105001x', 'cf/140131gxzg6j66fcr9x66p.jpg', '&lt;p align=&quot;center&quot;&gt;\r\n	&lt;strong&gt;&lt;span style=&quot;font-size:24px;&quot;&gt;接哈圣诞节哈是的&lt;/span&gt;&lt;/strong&gt; \r\n&lt;/p&gt;', 'cf/140131s2lql7ntb1sic44n.jpg', '1', '5', '1', '10000');

-- ----------------------------
-- Table structure for `wxq_yiqixueba_wxq123_businessgroup`
-- ----------------------------
DROP TABLE IF EXISTS `wxq_yiqixueba_wxq123_businessgroup`;
CREATE TABLE `wxq_yiqixueba_wxq123_businessgroup` (
  `businessgroupid` smallint(6) unsigned NOT NULL auto_increment,
  `businessgroupname` char(50) character set gbk NOT NULL,
  `inshoufei` int(10) unsigned NOT NULL,
  `inshoufeiqixian` int(10) unsigned NOT NULL,
  `businessgroupdescription` varchar(255) character set gbk NOT NULL,
  `cardfeiyong` int(10) NOT NULL,
  `cardpice` int(10) unsigned NOT NULL,
  `status` tinyint(1) NOT NULL,
  `businessgroupico` varchar(255) character set gbk NOT NULL,
  `xiaofei` varchar(255) character set gbk NOT NULL,
  `zhanghaoyue` int(10) NOT NULL,
  `zhanghaojifen` int(10) NOT NULL,
  `xiaofeitypeshenhe` tinyint(1) NOT NULL,
  `dianyuanshenhe` tinyint(1) NOT NULL,
  `dianzhang` varchar(255) character set gbk NOT NULL,
  `caiwu` varchar(255) character set gbk NOT NULL,
  `shouyin` varchar(255) character set gbk NOT NULL,
  `enfendian` tinyint(1) NOT NULL,
  `enbusinessnum` int(10) NOT NULL,
  `contractsample` char(100) character set gbk NOT NULL,
  PRIMARY KEY  (`businessgroupid`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of wxq_yiqixueba_wxq123_businessgroup
-- ----------------------------
INSERT INTO `wxq_yiqixueba_wxq123_businessgroup` VALUES ('1', '普通商家组', '300', '365', '', '0', '0', '1', 'cf/164617sed5t1j99ejlts1s.jpg', 'a:4:{i:0;s:4:\"jici\";i:1;s:7:\"shijian\";i:2;s:7:\"liangka\";i:3;s:3:\"yue\";}', '0', '0', '1', '1', 'a:3:{i:0;s:5:\"kaika\";i:1;s:4:\"buka\";i:2;s:9:\"zhuxiaoka\";}', 'a:2:{i:0;s:5:\"kaika\";i:1;s:4:\"buka\";}', 'a:2:{i:0;s:5:\"kaika\";i:1;s:4:\"buka\";}', '1', '10', '普通商家组1371631047.doc');
INSERT INTO `wxq_yiqixueba_wxq123_businessgroup` VALUES ('2', 'VIP商家组', '0', '0', '', '0', '0', '1', 'cf/114407howwu77uu1o5uz5z.png', 'a:6:{i:0;s:4:\"jici\";i:1;s:7:\"shijian\";i:2;s:7:\"liangka\";i:3;s:7:\"xianjin\";i:4;s:3:\"yue\";i:5;s:5:\"jifen\";}', '0', '0', '0', '0', 'N;', 'N;', 'N;', '1', '1', '');

-- ----------------------------
-- Table structure for `wxq_yiqixueba_wxq123_jilu`
-- ----------------------------
DROP TABLE IF EXISTS `wxq_yiqixueba_wxq123_jilu`;
CREATE TABLE `wxq_yiqixueba_wxq123_jilu` (
  `jiluid` mediumint(8) unsigned NOT NULL auto_increment,
  `time` int(10) unsigned NOT NULL,
  `postxml` text NOT NULL,
  `type` char(20) NOT NULL,
  `fromusername` char(255) NOT NULL,
  `tousername` char(255) default NULL,
  `inputtype` char(255) NOT NULL,
  `keyword` text,
  `post` text,
  PRIMARY KEY  (`jiluid`)
) ENGINE=MyISAM AUTO_INCREMENT=289 DEFAULT CHARSET=gbk;

-- ----------------------------
-- Records of wxq_yiqixueba_wxq123_jilu
-- ----------------------------
INSERT INTO `wxq_yiqixueba_wxq123_jilu` VALUES ('266', '1372682604', '', '', '', null, '', '', null);
INSERT INTO `wxq_yiqixueba_wxq123_jilu` VALUES ('267', '1372778558', '', '', '', null, '', '', null);
INSERT INTO `wxq_yiqixueba_wxq123_jilu` VALUES ('268', '1372996305', '', '', '', null, '', '', null);
INSERT INTO `wxq_yiqixueba_wxq123_jilu` VALUES ('269', '1373006747', '', '', '', null, '', '', null);
INSERT INTO `wxq_yiqixueba_wxq123_jilu` VALUES ('270', '1373006749', '', '', '', null, '', '', null);
INSERT INTO `wxq_yiqixueba_wxq123_jilu` VALUES ('271', '1373335951', '', '', '', null, '', '', null);
INSERT INTO `wxq_yiqixueba_wxq123_jilu` VALUES ('272', '1373343621', '', '', '', null, '', '', null);
INSERT INTO `wxq_yiqixueba_wxq123_jilu` VALUES ('273', '1373343706', '', '', '', null, '', '', null);
INSERT INTO `wxq_yiqixueba_wxq123_jilu` VALUES ('274', '1373483895', '', '', '', null, '', '', null);
INSERT INTO `wxq_yiqixueba_wxq123_jilu` VALUES ('275', '1373483895', '', '', '', null, '', '', null);
INSERT INTO `wxq_yiqixueba_wxq123_jilu` VALUES ('276', '1373483895', '', '', '', null, '', '', null);
INSERT INTO `wxq_yiqixueba_wxq123_jilu` VALUES ('277', '1373486059', '', '', '', null, '', '', null);
INSERT INTO `wxq_yiqixueba_wxq123_jilu` VALUES ('278', '1373486063', '', '', '', null, '', '', null);
INSERT INTO `wxq_yiqixueba_wxq123_jilu` VALUES ('279', '1373650409', '', '', '', null, '', '', null);
INSERT INTO `wxq_yiqixueba_wxq123_jilu` VALUES ('280', '1374029814', '', '', '', null, '', '', null);
INSERT INTO `wxq_yiqixueba_wxq123_jilu` VALUES ('281', '1374480140', '', '', '', null, '', '', null);
INSERT INTO `wxq_yiqixueba_wxq123_jilu` VALUES ('282', '1374585142', '', '', '', null, '', '', null);
INSERT INTO `wxq_yiqixueba_wxq123_jilu` VALUES ('283', '1374717489', '', '', '', null, '', '', null);
INSERT INTO `wxq_yiqixueba_wxq123_jilu` VALUES ('284', '1374807496', '', '', '', null, '', '', null);
INSERT INTO `wxq_yiqixueba_wxq123_jilu` VALUES ('285', '1374807513', '', '', '', null, '', '', null);
INSERT INTO `wxq_yiqixueba_wxq123_jilu` VALUES ('286', '1374822480', '', '', '', null, '', '', null);
INSERT INTO `wxq_yiqixueba_wxq123_jilu` VALUES ('287', '1374822485', '', '', '', null, '', '', null);
INSERT INTO `wxq_yiqixueba_wxq123_jilu` VALUES ('288', '1374866663', '', '', '', null, '', '', null);

-- ----------------------------
-- Table structure for `wxq_yiqixueba_wxq123_member`
-- ----------------------------
DROP TABLE IF EXISTS `wxq_yiqixueba_wxq123_member`;
CREATE TABLE `wxq_yiqixueba_wxq123_member` (
  `uid` mediumint(8) NOT NULL,
  `shibiema` char(11) character set gbk NOT NULL,
  `token` char(6) character set gbk NOT NULL,
  `membertype` char(10) NOT NULL,
  `yikatong_business_array` text character set gbk NOT NULL,
  `yikatong_dianzhang_array` text character set gbk NOT NULL,
  `yikatong_caiwu_array` text character set gbk NOT NULL,
  `yikatong_shouyin_array` text character set gbk NOT NULL,
  `yikatong_kaxiaoshou_array` text character set gbk NOT NULL,
  `yikatong_shop_array` text character set gbk NOT NULL,
  `yikatong_goods_array` text character set gbk NOT NULL,
  PRIMARY KEY  (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of wxq_yiqixueba_wxq123_member
-- ----------------------------
INSERT INTO `wxq_yiqixueba_wxq123_member` VALUES ('1', '8249328', 'oqhXFW', 'geren', '', '', '', '', '', '', '');

-- ----------------------------
-- Table structure for `wxq_yiqixueba_wxq123_setting`
-- ----------------------------
DROP TABLE IF EXISTS `wxq_yiqixueba_wxq123_setting`;
CREATE TABLE `wxq_yiqixueba_wxq123_setting` (
  `settingid` mediumint(8) unsigned NOT NULL auto_increment,
  `mokuaiid` mediumint(8) NOT NULL,
  `skey` varchar(255) NOT NULL,
  `svalue` text NOT NULL,
  PRIMARY KEY  (`settingid`)
) ENGINE=MyISAM AUTO_INCREMENT=8 DEFAULT CHARSET=gbk;

-- ----------------------------
-- Records of wxq_yiqixueba_wxq123_setting
-- ----------------------------
INSERT INTO `wxq_yiqixueba_wxq123_setting` VALUES ('1', '0', 'regsetp1tips', '');
INSERT INTO `wxq_yiqixueba_wxq123_setting` VALUES ('2', '0', 'weixinimg', '');
INSERT INTO `wxq_yiqixueba_wxq123_setting` VALUES ('4', '0', 'shop_tablename', 'yiqixueba_shop');
INSERT INTO `wxq_yiqixueba_wxq123_setting` VALUES ('5', '0', 'shop_shopid', 'shopid');
INSERT INTO `wxq_yiqixueba_wxq123_setting` VALUES ('6', '0', 'shop_shopname', 'shopname');
INSERT INTO `wxq_yiqixueba_wxq123_setting` VALUES ('7', '0', 'shop_condition', '');

-- ----------------------------
-- Table structure for `wxq_yiqixueba_wxq123_shop`
-- ----------------------------
DROP TABLE IF EXISTS `wxq_yiqixueba_wxq123_shop`;
CREATE TABLE `wxq_yiqixueba_wxq123_shop` (
  `shopid` mediumint(8) unsigned NOT NULL auto_increment,
  `shopname` char(100) character set gbk NOT NULL,
  `uid` mediumint(8) NOT NULL,
  `shoplocation` char(20) character set gbk NOT NULL,
  `oldshopid` mediumint(8) NOT NULL,
  `shaixuantime` int(10) unsigned default NULL,
  PRIMARY KEY  (`shopid`)
) ENGINE=MyISAM AUTO_INCREMENT=15 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of wxq_yiqixueba_wxq123_shop
-- ----------------------------
INSERT INTO `wxq_yiqixueba_wxq123_shop` VALUES ('13', '再测', '1', '116.347496,39.734284', '1', '1371235822');
INSERT INTO `wxq_yiqixueba_wxq123_shop` VALUES ('14', '测试商家', '0', '114.486206,38.070489', '2', '1371235834');

-- ----------------------------
-- Table structure for `wxq_yiqixueba_wxq123_shoptype`
-- ----------------------------
DROP TABLE IF EXISTS `wxq_yiqixueba_wxq123_shoptype`;
CREATE TABLE `wxq_yiqixueba_wxq123_shoptype` (
  `shoptypeid` smallint(6) unsigned NOT NULL auto_increment,
  `shoptypename` char(50) character set gbk NOT NULL,
  `inshoufei` varchar(255) NOT NULL,
  `inshoufeiqixian` varchar(255) NOT NULL,
  `shoptypedescription` varchar(255) NOT NULL,
  `cardfeiyong` varchar(255) NOT NULL,
  `cardpice` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `shoptypeico` varchar(255) character set gbk NOT NULL,
  PRIMARY KEY  (`shoptypeid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of wxq_yiqixueba_wxq123_shoptype
-- ----------------------------
INSERT INTO `wxq_yiqixueba_wxq123_shoptype` VALUES ('1', '普通商家组', '300', '365', '', '', '', '1', '');

-- ----------------------------
-- Table structure for `wxq_yiqixueba_wxq123_sort`
-- ----------------------------
DROP TABLE IF EXISTS `wxq_yiqixueba_wxq123_sort`;
CREATE TABLE `wxq_yiqixueba_wxq123_sort` (
  `sortid` smallint(6) unsigned NOT NULL auto_increment,
  `mokuaiid` smallint(6) NOT NULL,
  `sortname` char(20) character set gbk NOT NULL,
  `sorttitle` char(20) character set gbk NOT NULL,
  `sortlevel` smallint(6) NOT NULL,
  `sortupid` smallint(6) NOT NULL,
  `displayorder` smallint(6) NOT NULL,
  `upids` text character set gbk NOT NULL,
  `oldsortid` char(10) character set gbk NOT NULL,
  PRIMARY KEY  (`sortid`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of wxq_yiqixueba_wxq123_sort
-- ----------------------------
INSERT INTO `wxq_yiqixueba_wxq123_sort` VALUES ('1', '16', 'meishi', '美食', '1', '0', '0', '0', '');
INSERT INTO `wxq_yiqixueba_wxq123_sort` VALUES ('2', '16', 'chuancai', '川菜', '2', '1', '0', '0-1', '');
INSERT INTO `wxq_yiqixueba_wxq123_sort` VALUES ('5', '16', 'ceshi1', '测试1', '1', '0', '2', '0', '');
INSERT INTO `wxq_yiqixueba_wxq123_sort` VALUES ('6', '16', 'ceshi2', '测试2', '2', '5', '0', '0-5', '');
INSERT INTO `wxq_yiqixueba_wxq123_sort` VALUES ('7', '16', 'ceshi3', '测试3', '3', '6', '0', '0-6', '');
INSERT INTO `wxq_yiqixueba_wxq123_sort` VALUES ('8', '16', 'dalei1', '大类1', '1', '0', '1', '0', '');
INSERT INTO `wxq_yiqixueba_wxq123_sort` VALUES ('9', '16', 'jiangzhecai', '江浙菜', '2', '1', '0', '0-1', '');

-- ----------------------------
-- Table structure for `wxq_yiqixueba_yikatong_adminmenu`
-- ----------------------------
DROP TABLE IF EXISTS `wxq_yiqixueba_yikatong_adminmenu`;
CREATE TABLE `wxq_yiqixueba_yikatong_adminmenu` (
  `menuid` smallint(6) unsigned NOT NULL auto_increment,
  `upid` smallint(6) NOT NULL,
  `menuname` char(50) character set gbk NOT NULL,
  `menutitle` char(50) character set gbk NOT NULL,
  `displayorder` smallint(6) NOT NULL,
  PRIMARY KEY  (`menuid`)
) ENGINE=MyISAM AUTO_INCREMENT=13 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of wxq_yiqixueba_yikatong_adminmenu
-- ----------------------------
INSERT INTO `wxq_yiqixueba_yikatong_adminmenu` VALUES ('1', '0', 'base', '基础设置', '0');
INSERT INTO `wxq_yiqixueba_yikatong_adminmenu` VALUES ('2', '1', 'reg', '插件注册', '2');
INSERT INTO `wxq_yiqixueba_yikatong_adminmenu` VALUES ('3', '1', 'base', '基础设置', '1');
INSERT INTO `wxq_yiqixueba_yikatong_adminmenu` VALUES ('4', '0', 'member', '会员管理', '5');
INSERT INTO `wxq_yiqixueba_yikatong_adminmenu` VALUES ('5', '4', 'mkcard', '生成卡', '1');
INSERT INTO `wxq_yiqixueba_yikatong_adminmenu` VALUES ('6', '4', 'cardadmin', '管理卡', '2');
INSERT INTO `wxq_yiqixueba_yikatong_adminmenu` VALUES ('7', '4', 'cardcat', '卡分类', '0');
INSERT INTO `wxq_yiqixueba_yikatong_adminmenu` VALUES ('8', '1', 'index', '系统首页', '0');
INSERT INTO `wxq_yiqixueba_yikatong_adminmenu` VALUES ('9', '0', 'shop', '商家管理', '1');
INSERT INTO `wxq_yiqixueba_yikatong_adminmenu` VALUES ('10', '9', 'shopsetting', '商家设置', '0');
INSERT INTO `wxq_yiqixueba_yikatong_adminmenu` VALUES ('11', '9', 'shopadmin', '商家管理', '2');
INSERT INTO `wxq_yiqixueba_yikatong_adminmenu` VALUES ('12', '9', 'shoptype', '商家组', '1');

-- ----------------------------
-- Table structure for `wxq_yiqixueba_yikatong_business`
-- ----------------------------
DROP TABLE IF EXISTS `wxq_yiqixueba_yikatong_business`;
CREATE TABLE `wxq_yiqixueba_yikatong_business` (
  `businessid` mediumint(8) unsigned NOT NULL auto_increment,
  `businessgroupid` smallint(3) NOT NULL,
  `relname` char(10) character set gbk NOT NULL,
  `businessname` char(40) character set gbk NOT NULL,
  `sex` tinyint(1) NOT NULL,
  `phone` char(15) character set gbk NOT NULL,
  `address` char(100) character set gbk NOT NULL,
  `birthday` int(10) unsigned NOT NULL,
  `gerenphoto` char(100) character set gbk NOT NULL,
  `shenfenno` char(20) NOT NULL,
  `shenfenphoto` char(100) character set gbk NOT NULL,
  `businesssummary` varchar(255) character set gbk NOT NULL,
  `contractimage` varchar(255) character set gbk NOT NULL,
  `status` tinyint(1) NOT NULL,
  `uid` mediumint(8) unsigned NOT NULL,
  `cardtype` smallint(3) NOT NULL,
  `cardnum` int(10) unsigned NOT NULL,
  `jointime` int(10) unsigned default NULL,
  `shopid` mediumint(8) NOT NULL,
  PRIMARY KEY  (`businessid`)
) ENGINE=MyISAM AUTO_INCREMENT=11 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of wxq_yiqixueba_yikatong_business
-- ----------------------------
INSERT INTO `wxq_yiqixueba_yikatong_business` VALUES ('5', '0', '杨文', '', '1', '13113890911', '河北石家庄市新华小区', '0', '', '130106196806050972', '', '<p align=\"center\">\r\n	<strong><span style=\"font-size:24px;\">粉红色的撒旦</span></strong>\r\n</p>', '', '0', '1', '0', '0', null, '2');
INSERT INTO `wxq_yiqixueba_yikatong_business` VALUES ('6', '0', '', '', '0', '', '', '0', '', '', '', '', '', '0', '1', '0', '0', null, '5');
INSERT INTO `wxq_yiqixueba_yikatong_business` VALUES ('7', '0', '', '', '0', '', '', '0', '', '', '', '', '', '0', '1', '0', '0', null, '6');
INSERT INTO `wxq_yiqixueba_yikatong_business` VALUES ('8', '0', '杨鑫培', '', '1', '13106514246', '河北石家庄市平安小区', '885139200', '', '', '', '', '', '0', '1', '0', '0', null, '4');
INSERT INTO `wxq_yiqixueba_yikatong_business` VALUES ('9', '0', '', '', '0', '', '', '0', '', '', '', '', '', '0', '1', '0', '0', null, '8');
INSERT INTO `wxq_yiqixueba_yikatong_business` VALUES ('10', '0', '', '', '0', '', '', '0', '', '', '', '', '', '0', '1', '0', '0', null, '7');

-- ----------------------------
-- Table structure for `wxq_yiqixueba_yikatong_businessgroup`
-- ----------------------------
DROP TABLE IF EXISTS `wxq_yiqixueba_yikatong_businessgroup`;
CREATE TABLE `wxq_yiqixueba_yikatong_businessgroup` (
  `businessgroupid` smallint(6) unsigned NOT NULL auto_increment,
  `businessgroupname` char(50) character set gbk NOT NULL,
  `inshoufei` int(10) unsigned NOT NULL,
  `inshoufeiqixian` int(10) unsigned NOT NULL,
  `businessgroupdescription` varchar(255) character set gbk NOT NULL,
  `cardfeiyong` int(10) NOT NULL,
  `cardpice` int(10) unsigned NOT NULL,
  `status` tinyint(1) NOT NULL,
  `businessgroupico` varchar(255) character set gbk NOT NULL,
  `xiaofei` varchar(255) character set gbk NOT NULL,
  `zhanghaoyue` int(10) NOT NULL,
  `zhanghaojifen` int(10) NOT NULL,
  `xiaofeitypeshenhe` tinyint(1) NOT NULL,
  `dianyuanshenhe` tinyint(1) NOT NULL,
  `dianzhang` varchar(255) character set gbk NOT NULL,
  `caiwu` varchar(255) character set gbk NOT NULL,
  `shouyin` varchar(255) character set gbk NOT NULL,
  `enfendian` tinyint(1) NOT NULL,
  `enbusinessnum` int(10) NOT NULL,
  `contractsample` char(100) character set gbk NOT NULL,
  PRIMARY KEY  (`businessgroupid`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of wxq_yiqixueba_yikatong_businessgroup
-- ----------------------------
INSERT INTO `wxq_yiqixueba_yikatong_businessgroup` VALUES ('1', '普通商家组', '300', '1', '', '50', '50', '1', 'cf/164617sed5t1j99ejlts1s.jpg', 'a:6:{i:0;s:4:\"jici\";i:1;s:7:\"shijian\";i:2;s:7:\"liangka\";i:3;s:7:\"xianjin\";i:4;s:3:\"yue\";i:5;s:5:\"jifen\";}', '100', '100', '1', '1', 'a:3:{i:0;s:5:\"kaika\";i:1;s:4:\"buka\";i:2;s:9:\"zhuxiaoka\";}', 'a:2:{i:0;s:5:\"kaika\";i:1;s:4:\"buka\";}', 'a:2:{i:0;s:5:\"kaika\";i:1;s:4:\"buka\";}', '1', '10', '普通商家组1371631047.doc');
INSERT INTO `wxq_yiqixueba_yikatong_businessgroup` VALUES ('2', 'VIP商家组', '600', '1', '', '0', '50', '1', 'cf/114407howwu77uu1o5uz5z.png', 'a:6:{i:0;s:4:\"jici\";i:1;s:7:\"shijian\";i:2;s:7:\"liangka\";i:3;s:7:\"xianjin\";i:4;s:3:\"yue\";i:5;s:5:\"jifen\";}', '1000', '1000', '0', '0', 'a:8:{i:0;s:5:\"kaika\";i:1;s:4:\"buka\";i:2;s:9:\"zhuxiaoka\";i:3;s:10:\"kachongzhi\";i:4;s:13:\"jifenzengsong\";i:5;s:12:\"goodssetting\";i:6;s:10:\"viewmember\";i:7;s:11:\"viewxiaofei\";}', 'a:8:{i:0;s:5:\"kaika\";i:1;s:4:\"buka\";i:2;s:9:\"zhuxiaoka\";i:3;s:10:\"kachongzhi\";i:4;s:13:\"jifenzengsong\";i:5;s:12:\"goodssetting\";i:6;s:10:\"viewmember\";i:7;s:11:\"viewxiaofei\";}', 'a:8:{i:0;s:5:\"kaika\";i:1;s:4:\"buka\";i:2;s:9:\"zhuxiaoka\";i:3;s:10:\"kachongzhi\";i:4;s:13:\"jifenzengsong\";i:5;s:12:\"goodssetting\";i:6;s:10:\"viewmember\";i:7;s:11:\"viewxiaofei\";}', '1', '10', '');

-- ----------------------------
-- Table structure for `wxq_yiqixueba_yikatong_card`
-- ----------------------------
DROP TABLE IF EXISTS `wxq_yiqixueba_yikatong_card`;
CREATE TABLE `wxq_yiqixueba_yikatong_card` (
  `cardnoid` mediumint(8) unsigned NOT NULL auto_increment,
  `cardcatid` smallint(3) NOT NULL,
  `cardpici` smallint(3) NOT NULL,
  `cardno` char(20) character set gbk NOT NULL,
  `cardpass` char(32) character set gbk NOT NULL,
  `cardtype` tinyint(1) NOT NULL,
  `uid` mediumint(8) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `maketime` int(10) unsigned NOT NULL,
  `bindtime` int(10) unsigned NOT NULL,
  `fafanguid` mediumint(8) default NULL,
  PRIMARY KEY  (`cardnoid`)
) ENGINE=MyISAM AUTO_INCREMENT=21 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of wxq_yiqixueba_yikatong_card
-- ----------------------------
INSERT INTO `wxq_yiqixueba_yikatong_card` VALUES ('1', '1', '1', 'abc00001', 'p586YS', '0', '1', '0', '1370487754', '1372035556', '1');
INSERT INTO `wxq_yiqixueba_yikatong_card` VALUES ('2', '1', '1', 'abc00002', 'hcN7pa', '0', '0', '0', '1370487754', '0', '1');
INSERT INTO `wxq_yiqixueba_yikatong_card` VALUES ('3', '1', '1', 'abc00003', 'HfZhfj', '0', '0', '0', '1370487754', '0', '1');
INSERT INTO `wxq_yiqixueba_yikatong_card` VALUES ('5', '1', '1', 'abc00005', 'XVJkHx', '0', '0', '0', '1370487754', '0', '1');
INSERT INTO `wxq_yiqixueba_yikatong_card` VALUES ('6', '1', '1', 'abc00006', 'nJuToy', '0', '0', '0', '1370487754', '0', '1');
INSERT INTO `wxq_yiqixueba_yikatong_card` VALUES ('7', '1', '1', 'abc00007', 'VSsH4g', '0', '0', '0', '1370487754', '0', '1');
INSERT INTO `wxq_yiqixueba_yikatong_card` VALUES ('8', '1', '1', 'abc00008', 'IzcctB', '0', '0', '0', '1370487754', '0', '1');
INSERT INTO `wxq_yiqixueba_yikatong_card` VALUES ('9', '1', '1', 'abc00009', 'VPzKaz', '0', '0', '0', '1370487754', '0', '1');
INSERT INTO `wxq_yiqixueba_yikatong_card` VALUES ('10', '1', '1', 'abc00010', 'G7nnHk', '0', '0', '0', '1370487754', '0', '1');
INSERT INTO `wxq_yiqixueba_yikatong_card` VALUES ('11', '1', '2', 'abc00011', 'JagITy', '0', '0', '0', '1370875162', '0', '2');
INSERT INTO `wxq_yiqixueba_yikatong_card` VALUES ('12', '1', '2', 'abc00012', 'DfArHM', '0', '0', '0', '1370875162', '0', '2');
INSERT INTO `wxq_yiqixueba_yikatong_card` VALUES ('13', '1', '2', 'abc00013', 'FnZUrU', '0', '0', '0', '1370875162', '0', '2');
INSERT INTO `wxq_yiqixueba_yikatong_card` VALUES ('15', '1', '2', 'abc00015', 'hl6U75', '0', '0', '0', '1370875162', '0', '2');
INSERT INTO `wxq_yiqixueba_yikatong_card` VALUES ('16', '1', '2', 'abc00016', 'oxzVVE', '0', '0', '0', '1370875162', '0', '2');
INSERT INTO `wxq_yiqixueba_yikatong_card` VALUES ('17', '1', '2', 'abc00017', 'Z5s9bz', '0', '0', '0', '1370875162', '0', '2');
INSERT INTO `wxq_yiqixueba_yikatong_card` VALUES ('18', '1', '2', 'abc00018', 'eB1K45', '0', '0', '0', '1370875162', '0', '2');
INSERT INTO `wxq_yiqixueba_yikatong_card` VALUES ('19', '1', '2', 'abc00019', 'bHvWO5', '0', '0', '0', '1370875162', '0', '2');
INSERT INTO `wxq_yiqixueba_yikatong_card` VALUES ('20', '1', '2', 'abc00020', 'stNvpN', '0', '0', '0', '1370875162', '0', '2');

-- ----------------------------
-- Table structure for `wxq_yiqixueba_yikatong_cardcat`
-- ----------------------------
DROP TABLE IF EXISTS `wxq_yiqixueba_yikatong_cardcat`;
CREATE TABLE `wxq_yiqixueba_yikatong_cardcat` (
  `cardcatid` smallint(6) unsigned NOT NULL auto_increment,
  `cardcatname` char(50) character set gbk NOT NULL,
  `cardcatdescription` text character set gbk NOT NULL,
  `cardjine` int(10) unsigned NOT NULL,
  `cardpice` int(10) unsigned NOT NULL,
  `cardyouxiaoqi` int(10) unsigned NOT NULL,
  `carddzyouxiaoqi` char(10) character set gbk NOT NULL,
  `status` tinyint(1) NOT NULL,
  `cardcatico` varchar(255) character set gbk NOT NULL,
  `cardkaishi` int(10) unsigned NOT NULL,
  `cardtype` char(20) character set gbk NOT NULL,
  `cardjifen` int(10) NOT NULL,
  `cardqingling` varchar(255) character set gbk NOT NULL,
  `shopid` mediumint(8) NOT NULL,
  PRIMARY KEY  (`cardcatid`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of wxq_yiqixueba_yikatong_cardcat
-- ----------------------------
INSERT INTO `wxq_yiqixueba_yikatong_cardcat` VALUES ('1', '普通卡', '&lt;strong&gt;最普通的会员卡&lt;/strong&gt;', '0', '0', '0', '1年', '1', 'cf/225828pxofhah25na13bk1.jpg', '0', 'benwangka', '0', '0', '0');

-- ----------------------------
-- Table structure for `wxq_yiqixueba_yikatong_dianyuan`
-- ----------------------------
DROP TABLE IF EXISTS `wxq_yiqixueba_yikatong_dianyuan`;
CREATE TABLE `wxq_yiqixueba_yikatong_dianyuan` (
  `dianyuanid` mediumint(8) unsigned NOT NULL auto_increment,
  `shopid` mediumint(8) NOT NULL,
  `dianyuanname` char(40) character set gbk NOT NULL,
  `dyname` char(40) character set gbk NOT NULL,
  `dysex` tinyint(1) NOT NULL,
  `dyphone` char(20) character set gbk NOT NULL,
  `dytype` smallint(3) NOT NULL,
  `dyquanxian` text character set gbk NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY  (`dianyuanid`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of wxq_yiqixueba_yikatong_dianyuan
-- ----------------------------
INSERT INTO `wxq_yiqixueba_yikatong_dianyuan` VALUES ('1', '15', 'luyane', '测试人员', '2', '1234567', '1', 'a:4:{i:0;s:4:\"view\";i:1;s:5:\"banli\";i:2;s:7:\"zhuxiao\";i:3;s:5:\"buban\";}', '0');
INSERT INTO `wxq_yiqixueba_yikatong_dianyuan` VALUES ('2', '16', 'luyane', '哈哈', '2', '1234567', '2', 'a:4:{i:0;s:4:\"view\";i:1;s:5:\"banli\";i:2;s:7:\"zhuxiao\";i:3;s:5:\"buban\";}', '0');

-- ----------------------------
-- Table structure for `wxq_yiqixueba_yikatong_goods`
-- ----------------------------
DROP TABLE IF EXISTS `wxq_yiqixueba_yikatong_goods`;
CREATE TABLE `wxq_yiqixueba_yikatong_goods` (
  `goodsid` mediumint(8) NOT NULL,
  `goodspice` int(10) NOT NULL,
  `goodsnum` int(10) NOT NULL,
  `jici` tinyint(1) NOT NULL,
  `jicitext` text character set gbk NOT NULL,
  `shijian` tinyint(1) NOT NULL,
  `shijiantext` text character set gbk NOT NULL,
  `liangka` tinyint(1) NOT NULL,
  `liangkatext` text character set gbk NOT NULL,
  `xianjin` tinyint(1) NOT NULL,
  `xianjintext` text character set gbk NOT NULL,
  `yue` tinyint(1) NOT NULL,
  `yuetext` text character set gbk NOT NULL,
  `jifen` tinyint(1) NOT NULL,
  `jifentext` text character set gbk NOT NULL,
  `start` int(10) unsigned NOT NULL,
  `end` int(10) unsigned NOT NULL,
  `status` tinyint(1) NOT NULL,
  `shopid` int(10) unsigned NOT NULL,
  `uid` mediumint(8) NOT NULL,
  `businessid` mediumint(8) NOT NULL,
  `jointime` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`goodsid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of wxq_yiqixueba_yikatong_goods
-- ----------------------------
INSERT INTO `wxq_yiqixueba_yikatong_goods` VALUES ('1', '0', '0', '0', '', '0', '', '0', '', '0', '', '0', '', '0', '', '0', '0', '0', '1', '1', '4', '1372042372');

-- ----------------------------
-- Table structure for `wxq_yiqixueba_yikatong_goods_temp`
-- ----------------------------
DROP TABLE IF EXISTS `wxq_yiqixueba_yikatong_goods_temp`;
CREATE TABLE `wxq_yiqixueba_yikatong_goods_temp` (
  `goodsid` mediumint(8) NOT NULL,
  `goodspice` int(10) unsigned NOT NULL,
  `goodsnum` int(10) unsigned NOT NULL,
  `jici` tinyint(1) NOT NULL,
  `jicitext` text character set gbk NOT NULL,
  `shijian` tinyint(1) NOT NULL,
  `shijiantext` text character set gbk NOT NULL,
  `liangka` tinyint(1) NOT NULL,
  `liangkatext` text character set gbk NOT NULL,
  `xianjin` tinyint(1) NOT NULL,
  `xianjintext` text character set gbk NOT NULL,
  `yue` tinyint(1) NOT NULL,
  `yuetext` text character set gbk NOT NULL,
  `jifen` tinyint(1) NOT NULL,
  `jifentext` text character set gbk NOT NULL,
  `start` int(10) unsigned NOT NULL,
  `end` int(10) unsigned NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY  (`goodsid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of wxq_yiqixueba_yikatong_goods_temp
-- ----------------------------
INSERT INTO `wxq_yiqixueba_yikatong_goods_temp` VALUES ('7', '123', '100', '0', 'a:4:{s:5:\"cishu\";s:2:\"10\";s:7:\"feiyong\";s:3:\"110\";s:8:\"zengsong\";s:2:\"10\";s:8:\"chongzhi\";s:2:\"10\";}', '0', 'a:4:{s:5:\"daoqi\";s:0:\"\";s:7:\"feiyong\";s:3:\"100\";s:8:\"zengsong\";s:0:\"\";s:8:\"chongzhi\";s:0:\"\";}', '0', 'a:1:{s:7:\"feiyong\";s:0:\"\";}', '0', 'a:3:{s:7:\"feiyong\";s:0:\"\";s:8:\"zengsong\";s:0:\"\";s:8:\"chongzhi\";s:0:\"\";}', '0', 'a:3:{s:7:\"feiyong\";s:0:\"\";s:8:\"zengsong\";s:0:\"\";s:8:\"chongzhi\";s:0:\"\";}', '0', 'a:3:{s:7:\"feiyong\";s:0:\"\";s:8:\"zengsong\";s:0:\"\";s:8:\"chongzhi\";s:0:\"\";}', '0', '0', '0');
INSERT INTO `wxq_yiqixueba_yikatong_goods_temp` VALUES ('0', '0', '0', '0', 'N;', '0', 'N;', '0', 'N;', '0', 'N;', '0', 'N;', '0', 'N;', '0', '0', '0');

-- ----------------------------
-- Table structure for `wxq_yiqixueba_yikatong_member`
-- ----------------------------
DROP TABLE IF EXISTS `wxq_yiqixueba_yikatong_member`;
CREATE TABLE `wxq_yiqixueba_yikatong_member` (
  `uid` mediumint(8) NOT NULL,
  `brand` char(20) character set gbk NOT NULL,
  `yikatong` char(20) character set gbk NOT NULL,
  `wxq123` char(20) character set gbk NOT NULL,
  `yikatong_business_array` text character set gbk NOT NULL,
  `yikatong_dianzhang_array` text character set gbk NOT NULL,
  `yikatong_caiwu_array` text character set gbk NOT NULL,
  `yikatong_shouyin_array` text character set gbk NOT NULL,
  `yikatong_kaxiaoshou_array` text character set gbk NOT NULL,
  `yikatong_shop_array` text character set gbk NOT NULL,
  `yikatong_goods_array` text character set gbk NOT NULL,
  `jointime` int(10) unsigned NOT NULL,
  PRIMARY KEY  (`uid`)
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of wxq_yiqixueba_yikatong_member
-- ----------------------------
INSERT INTO `wxq_yiqixueba_yikatong_member` VALUES ('1', '', '', '', '', '', '', '', '', '', '', '0');

-- ----------------------------
-- Table structure for `wxq_yiqixueba_yikatong_setting`
-- ----------------------------
DROP TABLE IF EXISTS `wxq_yiqixueba_yikatong_setting`;
CREATE TABLE `wxq_yiqixueba_yikatong_setting` (
  `skey` varchar(255) NOT NULL,
  `svalue` text NOT NULL,
  PRIMARY KEY  (`skey`)
) ENGINE=MyISAM DEFAULT CHARSET=gbk;

-- ----------------------------
-- Records of wxq_yiqixueba_yikatong_setting
-- ----------------------------
INSERT INTO `wxq_yiqixueba_yikatong_setting` VALUES ('shop_tablename', 'yiqixueba_shop');
INSERT INTO `wxq_yiqixueba_yikatong_setting` VALUES ('shop_shopid', 'shopid');
INSERT INTO `wxq_yiqixueba_yikatong_setting` VALUES ('shop_shopname', 'shopname');
INSERT INTO `wxq_yiqixueba_yikatong_setting` VALUES ('shop_condition', '');
INSERT INTO `wxq_yiqixueba_yikatong_setting` VALUES ('jifenyouxiaoqi', '');

-- ----------------------------
-- Table structure for `wxq_yiqixueba_yikatong_shop`
-- ----------------------------
DROP TABLE IF EXISTS `wxq_yiqixueba_yikatong_shop`;
CREATE TABLE `wxq_yiqixueba_yikatong_shop` (
  `shopid` mediumint(8) unsigned NOT NULL,
  `businessgroupid` mediumint(8) NOT NULL,
  `uid` mediumint(8) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `jointime` tinyint(10) unsigned NOT NULL,
  `upshopid` mediumint(8) unsigned NOT NULL,
  `shopname` char(255) character set gbk NOT NULL,
  PRIMARY KEY  (`shopid`)
) ENGINE=MyISAM AUTO_INCREMENT=18 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of wxq_yiqixueba_yikatong_shop
-- ----------------------------
INSERT INTO `wxq_yiqixueba_yikatong_shop` VALUES ('2', '1', '1', '0', '255', '0', '0');
INSERT INTO `wxq_yiqixueba_yikatong_shop` VALUES ('5', '1', '1', '0', '255', '2', '0');
INSERT INTO `wxq_yiqixueba_yikatong_shop` VALUES ('6', '1', '1', '0', '255', '2', '0');
INSERT INTO `wxq_yiqixueba_yikatong_shop` VALUES ('4', '1', '1', '0', '255', '0', '0');
INSERT INTO `wxq_yiqixueba_yikatong_shop` VALUES ('7', '1', '1', '0', '255', '4', '0');
INSERT INTO `wxq_yiqixueba_yikatong_shop` VALUES ('3', '0', '1', '0', '255', '0', '0');
INSERT INTO `wxq_yiqixueba_yikatong_shop` VALUES ('8', '1', '1', '0', '255', '2', '0');
INSERT INTO `wxq_yiqixueba_yikatong_shop` VALUES ('1', '0', '1', '0', '255', '0', '0');
INSERT INTO `wxq_yiqixueba_yikatong_shop` VALUES ('9', '0', '2', '0', '255', '0', '0');
INSERT INTO `wxq_yiqixueba_yikatong_shop` VALUES ('11', '0', '1', '0', '255', '0', '0');
INSERT INTO `wxq_yiqixueba_yikatong_shop` VALUES ('14', '0', '1', '0', '255', '0', '测试商家');
INSERT INTO `wxq_yiqixueba_yikatong_shop` VALUES ('15', '0', '1', '0', '255', '0', '我的分店');

-- ----------------------------
-- Table structure for `wxq_yiqixueba_yikatong_shopdianyuan_copy`
-- ----------------------------
DROP TABLE IF EXISTS `wxq_yiqixueba_yikatong_shopdianyuan_copy`;
CREATE TABLE `wxq_yiqixueba_yikatong_shopdianyuan_copy` (
  `dianyuanid` mediumint(8) unsigned NOT NULL auto_increment,
  `shopid` mediumint(8) NOT NULL,
  `dyusername` char(40) character set gbk NOT NULL,
  `dyname` char(40) character set gbk NOT NULL,
  `dysex` tinyint(1) NOT NULL,
  `dyphone` char(20) character set gbk NOT NULL,
  `dytype` smallint(3) NOT NULL,
  `dyquanxian` text character set gbk NOT NULL,
  `status` tinyint(1) NOT NULL,
  PRIMARY KEY  (`dianyuanid`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of wxq_yiqixueba_yikatong_shopdianyuan_copy
-- ----------------------------
INSERT INTO `wxq_yiqixueba_yikatong_shopdianyuan_copy` VALUES ('1', '15', 'luyane', '测试人员', '2', '1234567', '1', 'a:4:{i:0;s:4:\"view\";i:1;s:5:\"banli\";i:2;s:7:\"zhuxiao\";i:3;s:5:\"buban\";}', '0');
INSERT INTO `wxq_yiqixueba_yikatong_shopdianyuan_copy` VALUES ('2', '16', 'luyane', '哈哈', '2', '1234567', '2', 'a:4:{i:0;s:4:\"view\";i:1;s:5:\"banli\";i:2;s:7:\"zhuxiao\";i:3;s:5:\"buban\";}', '0');

-- ----------------------------
-- Table structure for `wxq_yiqixueba_yikatong_shopgroup`
-- ----------------------------
DROP TABLE IF EXISTS `wxq_yiqixueba_yikatong_shopgroup`;
CREATE TABLE `wxq_yiqixueba_yikatong_shopgroup` (
  `shopgroupid` smallint(6) unsigned NOT NULL auto_increment,
  `shopgroupname` char(50) character set gbk NOT NULL,
  `inshoufei` int(10) unsigned NOT NULL,
  `inshoufeiqixian` int(10) unsigned NOT NULL,
  `shopgroupdescription` varchar(255) character set gbk NOT NULL,
  `cardfeiyong` int(10) NOT NULL,
  `cardpice` int(10) unsigned NOT NULL,
  `status` tinyint(1) NOT NULL,
  `shopgroupico` varchar(255) character set gbk NOT NULL,
  `xiaofei` varchar(255) character set gbk NOT NULL,
  `kayue` varchar(255) NOT NULL,
  `kajifen` varchar(255) NOT NULL,
  `enfendian` varchar(255) NOT NULL,
  `enshopnum` varchar(255) NOT NULL,
  `zhanghaoyue` varchar(255) NOT NULL,
  `zhanghaojifen` varchar(255) NOT NULL,
  `xiaofeitypeshenhe` varchar(255) NOT NULL,
  `dianyuanshenhe` varchar(255) NOT NULL,
  `dianzhang` varchar(255) NOT NULL,
  `caiwu` varchar(255) NOT NULL,
  `shouyin` varchar(255) NOT NULL,
  PRIMARY KEY  (`shopgroupid`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of wxq_yiqixueba_yikatong_shopgroup
-- ----------------------------
INSERT INTO `wxq_yiqixueba_yikatong_shopgroup` VALUES ('1', '普通商家组', '300', '365', '撒打算的', '0', '0', '1', 'cf/225828pxofhah25na13bk1.jpg', 'a:6:{i:0;s:4:\"jici\";i:1;s:7:\"shijian\";i:2;s:7:\"liangka\";i:3;s:7:\"xianjin\";i:4;s:3:\"yue\";i:5;s:5:\"jifen\";}', '', '', '1', '10', '', '', '1', '1', 'a:3:{i:0;s:5:\"kaika\";i:1;s:4:\"buka\";i:2;s:9:\"zhuxiaoka\";}', 'N;', 'N;');
INSERT INTO `wxq_yiqixueba_yikatong_shopgroup` VALUES ('2', 'VIP商家组', '0', '0', '????', '0', '0', '1', '', '', '', '', '', '', '', '', '', '', '', '', '');

-- ----------------------------
-- Table structure for `wxq_yiqixueba_yikatong_shoptype`
-- ----------------------------
DROP TABLE IF EXISTS `wxq_yiqixueba_yikatong_shoptype`;
CREATE TABLE `wxq_yiqixueba_yikatong_shoptype` (
  `shoptypeid` smallint(6) unsigned NOT NULL auto_increment,
  `shoptypename` char(50) character set gbk NOT NULL,
  `inshoufei` varchar(255) NOT NULL,
  `inshoufeiqixian` varchar(255) NOT NULL,
  `shoptypedescription` varchar(255) NOT NULL,
  `cardfeiyong` varchar(255) NOT NULL,
  `cardpice` varchar(255) NOT NULL,
  `status` tinyint(1) NOT NULL,
  `shoptypeico` varchar(255) character set gbk NOT NULL,
  `goods` varchar(255) NOT NULL,
  PRIMARY KEY  (`shoptypeid`)
) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of wxq_yiqixueba_yikatong_shoptype
-- ----------------------------
INSERT INTO `wxq_yiqixueba_yikatong_shoptype` VALUES ('1', '普通商家组', '300', '365', '', '', '', '1', 'cf/225828pxofhah25na13bk1.jpg', 'a:2:{i:0;s:2:\"20\";i:1;s:2:\"19\";}');
INSERT INTO `wxq_yiqixueba_yikatong_shoptype` VALUES ('2', 'VIP商家组', '', '', '????', '', '', '1', '', '');

-- ----------------------------
-- Table structure for `wxq_yiqixueba_yikatong_sort`
-- ----------------------------
DROP TABLE IF EXISTS `wxq_yiqixueba_yikatong_sort`;
CREATE TABLE `wxq_yiqixueba_yikatong_sort` (
  `sortid` smallint(6) unsigned NOT NULL auto_increment,
  `mokuaiid` smallint(6) NOT NULL,
  `sortname` char(20) character set gbk NOT NULL,
  `sorttitle` char(20) character set gbk NOT NULL,
  `sortlevel` smallint(6) NOT NULL,
  `sortupid` smallint(6) NOT NULL,
  `displayorder` smallint(6) NOT NULL,
  `upids` text character set gbk NOT NULL,
  `oldsortid` char(10) character set gbk NOT NULL,
  PRIMARY KEY  (`sortid`)
) ENGINE=MyISAM AUTO_INCREMENT=10 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of wxq_yiqixueba_yikatong_sort
-- ----------------------------
INSERT INTO `wxq_yiqixueba_yikatong_sort` VALUES ('1', '9', 'meishi', '美食', '1', '0', '0', '0', '');
INSERT INTO `wxq_yiqixueba_yikatong_sort` VALUES ('2', '9', 'chuancai', '川菜', '2', '1', '0', '0-1', '');
INSERT INTO `wxq_yiqixueba_yikatong_sort` VALUES ('5', '9', 'ceshi1', '测试1', '1', '0', '2', '0', '');
INSERT INTO `wxq_yiqixueba_yikatong_sort` VALUES ('6', '9', 'ceshi21', '测试21', '2', '5', '0', '0-5', '');
INSERT INTO `wxq_yiqixueba_yikatong_sort` VALUES ('7', '9', 'yikatong1', '一卡用', '3', '6', '0', '0-6', '');
INSERT INTO `wxq_yiqixueba_yikatong_sort` VALUES ('8', '9', 'dalei1', '大类1', '1', '0', '1', '0', '');
INSERT INTO `wxq_yiqixueba_yikatong_sort` VALUES ('9', '9', 'jiangzhecai', '江浙菜', '2', '1', '0', '0-1', '');
