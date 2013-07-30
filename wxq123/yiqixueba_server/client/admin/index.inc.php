<?php

/**
*	一起学吧平台程序
*	文件名：index.inc.php  创建时间：2013-6-1 15:16  杨文
*
*/

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
$this_page = 'plugins&identifier=yiqixueba_server&pmod=admincp&submod=index';
echo 'This Is index';

		$indata['inputtype'] = htmlspecialchars($inputtype);
		$indata['fromusername'] = htmlspecialchars($fromusername);
		$indata['tousername'] = htmlspecialchars($tousername);
		$indata['keyword'] = $keyword;
		$sitesbm = '2812';
		dump(api_indata('addwxjilu',$indata));



//api_api_indata
function api_indata($apiaction,$indata=array()){
	global $_G,$indata,$sitesbm;
	$site_info = DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_server_site')." WHERE shibiema='".$sitesbm."'");
	$testurl = str_replace("http://","",$site_info['siteurl']);
	$testurl = str_replace("/","",$testurl);
	if(fsockopen($testurl, 80)){
		$indata['sitekey'] = $site_info['sitekey'];
		$indata['siteurl'] = $site_info['siteurl'];
		if($site_info['charset']=='gbk') {
			foreach ( $indata as $k=>$v) {
				//$indata[$k] = diconv($v,$_G['charset'],'utf8');
			}
		}
		$indata = serialize($indata);
		$indata = base64_encode($indata);
		$api_url =$site_info['siteurl'].'plugin.php?id=yiqixueba:api&apiaction='.$apiaction.'&indata='.$indata.'&sign='.md5(md5($indata));
		$xml = @file_get_contents($api_url);
		require_once libfile('class/xml');
		$outdata = is_array(xml2array($xml)) ? xml2array($xml) : $xml;
		return $outdata;
	}else{
		return false;
	}
}//end func
?>