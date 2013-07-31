UPDATE `pre_common_plugin` SET modules = 'a:5:{i:0;a:10:{s:4:\"name\";s:7:\"yktbind\";s:4:\"menu\";s:10:\"一卡通绑定\";s:3:\"url\";s:0:\"\";s:4:\"type\";s:1:\"7\";s:7:\"adminid\";s:1:\"0\";s:12:\"displayorder\";s:1:\"0\";s:8:\"navtitle\";s:0:\"\";s:7:\"navicon\";s:0:\"\";s:10:\"navsubname\";s:0:\"\";s:9:\"navsuburl\";s:0:\"\";}i:1;a:10:{s:4:\"name\";s:8:\"yikatong\";s:4:\"menu\";s:0:\"\";s:3:\"url\";s:0:\"\";s:4:\"type\";s:2:\"11\";s:7:\"adminid\";s:1:\"0\";s:12:\"displayorder\";s:1:\"0\";s:8:\"navtitle\";s:0:\"\";s:7:\"navicon\";s:0:\"\";s:10:\"navsubname\";s:0:\"\";s:9:\"navsuburl\";s:0:\"\";}i:2;a:10:{s:4:\"name\";s:5:\"admin\";s:4:\"menu\";s:8:\"后台管理\";s:3:\"url\";s:0:\"\";s:4:\"type\";s:1:\"3\";s:7:\"adminid\";s:1:\"0\";s:12:\"displayorder\";s:1:\"0\";s:8:\"navtitle\";s:0:\"\";s:7:\"navicon\";s:0:\"\";s:10:\"navsubname\";s:0:\"\";s:9:\"navsuburl\";s:0:\"\";}i:3;a:10:{s:4:\"name\";s:7:\"yktxfjl\";s:4:\"menu\";s:12:\"我的消费记录\";s:3:\"url\";s:0:\"\";s:4:\"type\";s:1:\"7\";s:7:\"adminid\";s:1:\"0\";s:12:\"displayorder\";s:1:\"0\";s:8:\"navtitle\";s:0:\"\";s:7:\"navicon\";s:0:\"\";s:10:\"navsubname\";s:0:\"\";s:9:\"navsuburl\";s:0:\"\";}s:5:\"extra\";a:1:{s:11:\"installtype\";s:0:\"\";}}' WHERE identifier = 'yikatong';
DROP TABLE IF EXISTS `pre_brand_cikahaoma`;
CREATE TABLE `pre_brand_cikahaoma` (
  `cardpass` char(20) NOT NULL,
  `ID` text NOT NULL,
  `jine` char(50) NOT NULL,
  `jifen` mediumint(11) NOT NULL,
  `itemid` mediumint(11) NOT NULL,
  `username` varchar(255) NOT NULL,
  `jihuo` varchar(255) NOT NULL,
  `ssdq` varchar(255) DEFAULT NULL
) ENGINE=MyISAM;
DROP TABLE IF EXISTS `pre_brand_dianyuan`;
CREATE TABLE `pre_brand_dianyuan` (
  `ID` bigint(8) NOT NULL AUTO_INCREMENT,
  `sjuid` int(11) DEFAULT NULL,
  `name` varchar(20) DEFAULT NULL,
  `zhanghao` varchar(50) DEFAULT NULL,
  `mima` varchar(100) DEFAULT NULL,
  `mendian` varchar(100) DEFAULT NULL,
  `sjwb` varchar(6) DEFAULT NULL,
  `mddz` varchar(255) DEFAULT NULL,
  `dhhm` varchar(20) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM;
DROP TABLE IF EXISTS `pre_brand_hy`;
CREATE TABLE `pre_brand_hy` (
  `ID` bigint(8) NOT NULL AUTO_INCREMENT,
  `hyid` bigint(8) DEFAULT NULL,
  `sjid` bigint(8) DEFAULT NULL,
  `hykh` varchar(20) DEFAULT NULL,
  `dh` varchar(20) DEFAULT NULL,
  `sjmc` varchar(200) DEFAULT NULL,
  `zhanghao` varchar(25) DEFAULT NULL,
  `zcsj` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM;
DROP TABLE IF EXISTS `pre_brand_hycz`;
CREATE TABLE `pre_brand_hycz` (
  `id` bigint(8) NOT NULL AUTO_INCREMENT,
  `blr` varchar(20) DEFAULT NULL,
  `blsj` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `czje` int(4) DEFAULT NULL,
  `hykh` varchar(20) DEFAULT NULL,
  `blmd` varchar(20) DEFAULT NULL,
  `sjuid` int(4) DEFAULT NULL,
  `hyuid` int(11) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;
DROP TABLE IF EXISTS `pre_brand_pingfen`;
CREATE TABLE `pre_brand_pingfen` (
  `id` mediumint(11) unsigned NOT NULL AUTO_INCREMENT,
  `fid` mediumint(11) unsigned NOT NULL,
  `tid` mediumint(11) unsigned NOT NULL,
  `fenzhi` smallint(6) unsigned NOT NULL,
  `pfuid` mediumint(11) unsigned NOT NULL,
  `pfdateline` int(10) unsigned NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM;
DROP TABLE IF EXISTS `pre_brand_renyuanshuju`;
CREATE TABLE `pre_brand_renyuanshuju` (
  `itemid` text NOT NULL,
  `zhanghao` text NOT NULL,
  `mima` text NOT NULL,
  `xingming` text NOT NULL,
  `shouji` text NOT NULL,
  `shenfen` text NOT NULL,
  `zhicheng` text NOT NULL,
  `mingcheng` text NOT NULL
) ENGINE=MyISAM;
DROP TABLE IF EXISTS `pre_brand_wangzhanshouyi`;
CREATE TABLE `pre_brand_wangzhanshouyi` (
  `itemid` text NOT NULL,
  `uid` text NOT NULL,
  `shijian` datetime NOT NULL
) ENGINE=MyISAM;
DROP TABLE IF EXISTS `pre_brand_weituangou`;
CREATE TABLE `pre_brand_weituangou` (
  `wtgid` mediumint(11) unsigned NOT NULL AUTO_INCREMENT,
  `tid` mediumint(11) NOT NULL,
  `code` char(32) NOT NULL,
  `starttime` int(11) unsigned NOT NULL,
  `mun` int(6) NOT NULL,
  `uid` mediumint(8) NOT NULL,
  `shopid` mediumint(8) NOT NULL,
  `zhuangtai` tinyint(1) NOT NULL,
  `jine` int(10) NOT NULL,
  `shibiema` char(50) NOT NULL,
  PRIMARY KEY (`wtgid`)
) ENGINE=MyISAM;
DROP TABLE IF EXISTS `pre_brand_xfjl`;
CREATE TABLE `pre_brand_xfjl` (
  `ID` bigint(8) NOT NULL AUTO_INCREMENT,
  `xflx` int(2) NOT NULL DEFAULT '0' COMMENT '消费类型,0=不限1=现金消费2=余额消费，3=积分消费，4=企业消费 5=快速消费',
  `ddh` varchar(25) NOT NULL COMMENT '订单号',
  `spmc` varchar(50) NOT NULL COMMENT '商品名称',
  `jg` varchar(8) NOT NULL COMMENT '价格',
  `js` int(4) NOT NULL COMMENT '件数',
  `jysj` timestamp NULL DEFAULT CURRENT_TIMESTAMP COMMENT '交易时间',
  `hykh` int(8) NOT NULL COMMENT '会员卡号',
  `czy` varchar(25) NOT NULL COMMENT '操作员',
  `sssj` varchar(50) NOT NULL COMMENT '所属商家',
  `zt` int(2) NOT NULL DEFAULT '0' COMMENT '交易状态0=买单1=撤单',
  `sjuid` int(4) NOT NULL COMMENT '商家uid',
  `sptid` int(4) NOT NULL COMMENT '商品TID',
  `sptm` varchar(50) NOT NULL COMMENT '商品名称',
  `jieshen` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '节省',
  `rangli` decimal(10,2) DEFAULT '0.00' COMMENT '让利',
  `hyuid` bigint(11) DEFAULT NULL COMMENT '会员uid',
  `dptid` int(8) DEFAULT NULL,
  PRIMARY KEY (`ID`)
) ENGINE=MyISAM;

