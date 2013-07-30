<?php
/**
 *      一起学吧客户端程序
 *		插件安装程序，只运行一次，随后删除
 *      $Id: install.php 2013-05-28 22:45:03Z yangwen $
 */

$sitekey = DB::result_first("SELECT svalue FROM ".DB::table('common_setting')." WHERE skey='yiqixueba_sitekey'");
if ($sitekey){
	//unlink(file_exists(dirname(__FILE__).'/'.basename(__FILE__)));
	//exit();
}
require_once DISCUZ_ROOT.'/source/discuz_version.php';
$installdata['charset'] = $_G['charset'];
$installdata['clientip'] = $_G['clientip'];
$installdata['siteurl'] = $_G['siteurl'];
$installdata['version'] = DISCUZ_VERSION.'-'.DISCUZ_RELEASE.'-'.DISCUZ_FIXBUG;

$outdata = api_indata('install',$installdata);

if ($outdata['sitekey']){
	if(DB::result_first("SELECT count(*) FROM ".DB::table('yiqixueba_setting')." WHERE skey='sitekey'")==0) {
		DB::insert('yiqixueba_setting',array('skey'=>'sitekey','svalue'=>$outdata['sitekey']));
	}else{
		DB::update('yiqixueba_setting',array('svalue'=>$outdata['sitekey']),array('skey'=>'sitekey'));
	}
}


$sql = <<<EOF
DROP TABLE IF EXISTS `wxq_yiqixueba_setting`;
CREATE TABLE `wxq_yiqixueba_setting` (
  `settingid` mediumint(8) unsigned NOT NULL auto_increment,
  `mokuaiid` mediumint(8) NOT NULL,
  `skey` varchar(255) NOT NULL,
  `svalue` text(0) NOT NULL,
  PRIMARY KEY  (`settingid`)
) ENGINE=MyISAM;

DROP TABLE IF EXISTS `wxq_yiqixueba_mokuai`;
CREATE TABLE `wxq_yiqixueba_mokuai` (
	`mokuaiid` mediumint(8) unsigned NOT NULL auto_increment,
	`mokuainame` char(20) NOT NULL,
	`mokuaititle` char(20) NOT NULL,
	`mokuaiver` char(50) NOT NULL,
	`displayorder` smallint(6) NOT NULL,
	`status` tinyint(1) NOT NULL,
	`installtime` int(10) unsigned NOT NULL,
	PRIMARY KEY  (`mokuaiid`)
) ENGINE=MyISAM;

DROP TABLE IF EXISTS `wxq_yiqixueba_mokuai_page`;
CREATE TABLE `wxq_yiqixueba_mokuai_page` (
	`pageid` char(32) NOT NULL,
	`type` smallint(6) NOT NULL,
	`mokuaiid` mediumint(8) NOT NULL,
	`displayorder` smallint(6) NOT NULL,
	`status` tinyint(1) NOT NULL,
	PRIMARY KEY  (`pageid`)
) ENGINE=MyISAM;
INSERT INTO `wxq_yiqixueba_mokuai_page` VALUES ('', '0', '0', '1', '1');

EOF;
$sql .= "INSERT INTO `wxq_yiqixueba_mokuai_page` VALUES (".md5('basesetting').", '0', '0', '0', '1');\n";
$sql .= "INSERT INTO `wxq_yiqixueba_mokuai_page` VALUES (".md5('regsetting').", '0', '0', '1', '1');\n";
//runquery($sql);
//$finish = TRUE;

////api_api_indata
//function api_indata($apiaction,$indata){
//	global $_G,$indata,$sitekey;
//	$indata['sitekey'] = $sitekey;
//	$indata['siteurl'] = $_G['siteurl'];
//	$indata = serialize($indata);
//	$indata = base64_encode($indata);
//	$api_url = 'http://www.wxq123.com/plugin.php?id=yiqixueba_server:api&apiaction='.$apiaction.'&indata='.$indata.'&sign='.md5(md5($indata));
//	$xml = @file_get_contents($api_url);
//	require_once libfile('class/xml');
//	$outdata = is_array(xml2array($xml)) ? xml2array($xml) : $xml;
//	return $outdata;
//}//end func
?>