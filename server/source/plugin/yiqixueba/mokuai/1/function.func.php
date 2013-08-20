<?php
//api_api_indata
function api_indata($apiaction,$indata=array()){
	global $_G,$sitekey,$server_siteurl;
	//if(fsockopen('www.wxq123.com', 80)){
		$indata['sitekey'] = $sitekey;
		$indata['siteurl'] = $_G['siteurl'];
		if($_G['charset']=='gbk') {
			foreach ( $indata as $k=>$v) {
				//$indata[$k] = diconv($v,$_G['charset'],'utf8');
			}
		}
		$indata = serialize($indata);
		$indata = base64_encode($indata);
		$api_url = $server_siteurl.'plugin.php?id=yiqixueba:api&apiaction='.$apiaction.'&indata='.$indata.'&sign='.md5(md5($indata));
		$xml = @file_get_contents($api_url);
		require_once libfile('class/xml');
		$outdata = is_array(xml2array($xml)) ? xml2array($xml) : $xml;
		return $outdata;
	//}else{
		//return false;
	//}
}//end func
//
function get_page($type,$submod){
	if($type == 'admincp'){
		$submod_array = explode("_",$submod);
		$submod_file = DISCUZ_ROOT.'source/plugin/yiqixueba_'.$submod_array[0].'/'.$submod_array[1].'.inc.php';
	}elseif($type == 'api'){
	}
	return $submod_file;
}//end func
//
function refresh_plugin($plugininfo){
	//$mokuai_dir = DISCUZ_ROOT.'source/plugin/yiqixueba_server/mokuai/'.;
	$mokuai_info = $mokuai_setting = array();
	$mokuai_info = $plugininfo;
	$mokuai_info['identifier'] = str_replace("yiqixueba_","",$plugininfo['identifier']);
	$query = DB::query("SELECT * FROM ".DB::table('common_pluginvar')." WHERE pluginid = ".$plugininfo['pluginid']." order by displayorder asc");
	while($row = DB::fetch($query)) {
		$mokuai_setting[] = $row;
	}
	$mokuai_info['setting'] = serialize($mokuai_setting);

	if(DB::result_first("SELECT count(*) FROM ".DB::table('yiqixueba_server_mokuai')." WHERE identifier='".$mokuai_info['identifier']."' AND version ='".$plugininfo['version']."'")==0){
		$mokuai_info['available'] = 1;
		$mokuai_info['createtime'] = time();
		DB::insert('yiqixueba_server_mokuai', $mokuai_info);
	}else{
		$mokuai_info['updatetime'] = time();
		unset($mokuai_info['available']);
		DB::update('yiqixueba_server_mokuai', $mokuai_info,array('identifier'=>$mokuai_info['identifier'],'version'=>$plugininfo['version']));
	}
}//end func
?>