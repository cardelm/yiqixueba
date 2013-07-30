<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}


$query = DB::query("SELECT * FROM ".DB::table('wxq123_server_site_mokuai')." WHERE siteid = ".DB::result_first("SELECT siteid FROM ".DB::table('wxq123_server_site')." WHERE siteurl = '".$apidata['siteurl']."' or searchurl = '".$apidata['searchurl']."'" ));
while($row = DB::fetch($query)) {
	$mokuais[] = $row['mokuaiid'];
}

$k = 0;
$query = DB::query("SELECT * FROM ".DB::table('wxq123_server_mokuai')." where status = 1 order by mokuaiid asc");
while($row = DB::fetch($query)) {
	if($row['mokuaiico']!='') {
		$mokuaiico = str_replace('{STATICURL}', STATICURL, $row['mokuaiico']);
		if(!preg_match("/^".preg_quote(STATICURL, '/')."/i", $mokuaiico) && !(($valueparse = parse_url($mokuaiico)) && isset($valueparse['host']))) {
			$mokuaiico = 'http://www.wxq123.com/'.$_G['setting']['attachurl'].'temp/'.$row['mokuaiico'].'?'.random(6);
		}
	}else{
		$mokuaiico = '';
	}
	$outdata['mokuais'][$k]['mokuaiid'] = $row['mokuaiid'];
	$outdata['mokuais'][$k]['mokuainame'] = $row['mokuainame'];
	$outdata['mokuais'][$k]['mokuaititle'] = $row['mokuaititle'];
	$outdata['mokuais'][$k]['mokuaipice'] = $row['mokuaipice'];
	$outdata['mokuais'][$k]['mokuaiico'] = $mokuaiico;
	$outdata['mokuais'][$k]['mokuaidescription'] = $row['mokuaidescription'];
	$outdata['mokuais'][$k]['version'] = $row['version'];
	if (in_array($row['mokuaiid'],$mokuais)){
		$outdata['mokuais'][$k]['status'] = 1;
	}else{
		$outdata['mokuais'][$k]['status'] = 0;
	}
	$k++;
}

$outdata['tips'] = $apidata['searchurl'];

?>