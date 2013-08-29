<?php
$server_siteurl = 'http://localhost/discuzdemo/dz3utf8/';

$sql = <<<EOF
DROP TABLE IF EXISTS `pre_yiqixueba_setting`;
DROP TABLE IF EXISTS `pre_yiqixueba_pages`;
DROP TABLE IF EXISTS `pre_yiqixueba_mokuai`;
EOF;
runquery($sql);

$installdata = array();
$installdata['clientip'] = $_G['clientip'];
$installdata['siteurl'] = $_G['siteurl'];
$installdata = serialize($installdata);
$installdata = base64_encode($installdata);
$api_url = $server_siteurl.'plugin.php?id=yiqixueba:api&apiaction=uninstall&indata='.$installdata.'&sign='.md5(md5($installdata));
$xml = @file_get_contents($api_url);
require_once libfile('class/xml');
$outdata = is_array(xml2array($xml)) ? xml2array($xml) : $xml;
$finish = TRUE;

?>