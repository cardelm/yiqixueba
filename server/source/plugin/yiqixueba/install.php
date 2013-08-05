<?php

//$server_siteurl = 'http://localhost/yiqixueba/dz3utf8/';
//测试阶段
$server_siteurl = $_G['siteurl'];

$installdata = array();
require_once DISCUZ_ROOT.'/source/discuz_version.php';
$installdata['charset'] = $_G['charset'];
$installdata['clientip'] = $_G['clientip'];
$installdata['siteurl'] = $_G['siteurl'];
$installdata['version'] = DISCUZ_VERSION.'-'.DISCUZ_RELEASE.'-'.DISCUZ_FIXBUG;
$installdata = serialize($installdata);
$installdata = base64_encode($installdata);
$api_url = $server_siteurl.'plugin.php?id=yiqixueba:api&apiaction=install&indata='.$installdata.'&sign='.md5(md5($installdata));
$xml = @file_get_contents($api_url);
require_once libfile('class/xml');
$outdata = is_array(xml2array($xml)) ? xml2array($xml) : $xml;




//$yiqixueba_setting = array();
//$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_setting'));
//while($row = DB::fetch($query)) {
	//$yiqixueba_setting[$row['skey']] = $row['svalue'];
//}

//dump($yiqixueba_setting);
$sql = <<<EOF
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

-- ----------------------------
-- Mokuai yiqixueba_server Records
-- ----------------------------
INSERT INTO `pre_yiqixueba_mokuai` VALUES ('2', '1', '1', '服务端', 'server', '', '', 'yiqixueba_server/', 'www.17xue8.cn', 'a:4:{i:0;a:10:{s:4:\"name\";s:5:\"index\";s:4:\"menu\";s:12:\"后台首页\";s:3:\"url\";s:0:\"\";s:4:\"type\";s:1:\"3\";s:7:\"adminid\";s:1:\"0\";s:12:\"displayorder\";i:0;s:8:\"navtitle\";s:0:\"\";s:7:\"navicon\";s:0:\"\";s:10:\"navsubname\";s:0:\"\";s:9:\"navsuburl\";s:0:\"\";}i:1;a:10:{s:4:\"name\";s:9:\"sitegroup\";s:4:\"menu\";s:9:\"站长组\";s:3:\"url\";s:0:\"\";s:4:\"type\";s:1:\"3\";s:7:\"adminid\";s:1:\"0\";s:12:\"displayorder\";i:1;s:8:\"navtitle\";s:0:\"\";s:7:\"navicon\";s:0:\"\";s:10:\"navsubname\";s:0:\"\";s:9:\"navsuburl\";s:0:\"\";}i:2;a:10:{s:4:\"name\";s:4:\"site\";s:4:\"menu\";s:12:\"站长管理\";s:3:\"url\";s:0:\"\";s:4:\"type\";s:1:\"3\";s:7:\"adminid\";s:1:\"0\";s:12:\"displayorder\";i:2;s:8:\"navtitle\";s:0:\"\";s:7:\"navicon\";s:0:\"\";s:10:\"navsubname\";s:0:\"\";s:9:\"navsuburl\";s:0:\"\";}i:3;a:10:{s:4:\"name\";s:6:\"mokuai\";s:4:\"menu\";s:12:\"模块管理\";s:3:\"url\";s:0:\"\";s:4:\"type\";s:1:\"3\";s:7:\"adminid\";s:1:\"0\";s:12:\"displayorder\";i:3;s:8:\"navtitle\";s:0:\"\";s:7:\"navicon\";s:0:\"\";s:10:\"navsubname\";s:0:\"\";s:9:\"navsuburl\";s:0:\"\";}}', 'V2.0', 'a:0:{}', '0');

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
-- Table structure for `pre_yiqixueba_setting`
-- ----------------------------
DROP TABLE IF EXISTS `pre_yiqixueba_setting`;
CREATE TABLE `pre_yiqixueba_setting` (
  `skey` varchar(255) NOT NULL,
  `svalue` text NOT NULL,
  PRIMARY KEY  (`skey`)
) ENGINE=MyISAM;

-- ----------------------------
-- Records of pre_yiqixueba_setting
-- ----------------------------
INSERT INTO `pre_yiqixueba_setting` VALUES ('server_siteurl', 'http://localhost/discuzdemo/dz3utf8/');


-- ----------------------------
-- Mokuai yiqixueba_server Tables
-- ----------------------------
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
) ENGINE=MyISAM;

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
) ENGINE=MyISAM;

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
  `currentversion` tinyint(1) NOT NULL default '0',
  `setting` text NOT NULL,
  `displayorder` smallint(6) NOT NULL,
  `createtime` int(10) NOT NULL,
  `updatetime` int(10) NOT NULL,
  PRIMARY KEY  (`mokuaiid`)
) ENGINE=MyISAM;

-- ----------------------------
-- Records of pre_yiqixueba_server_mokuai
-- ----------------------------

EOF;

//runquery($sql);


//dump($outdata);

//如果安装失败则执行以下代码
//DB::delete('common_plugin', DB::field('identifier', $pluginarray['plugin']['identifier']));

$finish = TRUE;
?>