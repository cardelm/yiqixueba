<?php

if($apiaction == 'install'){

	if(DB::result_first("SELECT count(*) FROM ".DB::table('yiqixueba_server_site')." WHERE siteurl='".$indata['siteurl']."'")==0){
		$data = array();
		$data['salt'] = random(6);
		$data['charset'] = $indata['charset'];
		$data['clientip'] = $indata['clientip'];
		$data['version'] = $indata['version'];
		$data['siteurl'] = $indata['siteurl'];
		$data['sitekey'] = md5($indata['siteurl'].$data['salt']);
		$data['sitegroup'] = 1;
		$data['installtime'] = time();
		DB::insert('yiqixueba_server_site', $data);
	}
	$site_info = DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_server_site')." WHERE siteurl='".$indata['siteurl']."'");
	$outdata['sitekey'] = $site_info['sitekey'];
	$main_page = array('admincp','function','yiqixueba');
	foreach($main_page as $k=>$v ){
		$outdata['mod'][$v] = random(1).md5($v.$site_info['salt']);
	}
}elseif(DB::result_first("SELECT sitekey FROM ".DB::table('yiqixueba_server_site')." WHERE siteurl='".$indata['siteurl']."'")==$indata['sitekey']){
	if($apiaction == 'mokuaiinfo'){
		$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_server_mokuai')." WHERE available = 1 group by identifier order by displayorder asc");
		while($row = DB::fetch($query)) {
			$outdata[$row['mokuaiid']] = $row;
		}
	}
}else{
	$outdata['error'] = 'error';
}
?>