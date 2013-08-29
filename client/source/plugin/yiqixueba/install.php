<?php

$server_siteurl = 'http://localhost/yiqixueba/dz3utf8/';
if(fsockopen('localhost', 80)){
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
}else{
	echo lang('plugin/yiqixueba','jianchawangluo');
}
var_dump($outdata);

//如果安装失败则执行以下代码
//DB::delete('common_plugin', DB::field('identifier', $pluginarray['plugin']['identifier']));

//$finish = TRUE;



?>