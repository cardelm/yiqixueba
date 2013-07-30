<?php
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
		exit('Access Denied');
}
$indata['charset'] = $_G['charset'];
$indata['clientip'] = $_G['clientip'];
$indata['siteurl'] = $_G['siteurl'];
$indata['version'] = DISCUZ_VERSION.'-'.DISCUZ_RELEASE.'-'.DISCUZ_FIXBUG;
$indata['plugin'] = 'yiqixueba_yikatong';
$indata['pluginver'] = 'V1.0';

$indata = serialize($indata);
$indata = base64_encode($indata);
$sign = md5(md5($indata));
$apiurl = 'http://www.wxq123.com/plugin.php?id=yiqixueba_server:api&indata='.$indata.'&sign='.$sign;
$outdata = file_get_contents($apiurl);


$sql = <<<EOF

DROP TABLE IF EXISTS `wxq_yiqixueba_yikatong_setting`;
CREATE TABLE `wxq_yiqixueba_yikatong_setting` (
  `skey` varchar(255) NOT NULL,
  `svalue` text(0) NOT NULL,
  PRIMARY KEY  (`skey`)
) ENGINE=MyISAM;


EOF;
runquery($sql);






?>