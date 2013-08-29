<?php

$site_info = DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_server_site')." WHERE siteurl='".$indata['siteurl']."'");

if($apiaction == 'install'){
	if(!$site_info){
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
}elseif($site_info['sitekey'] == $indata['sitekey']){
	if($apiaction == 'mokuaiinfo'){
		$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_server_mokuai')." WHERE available = 1 group by identifier order by displayorder asc");
		while($row = DB::fetch($query)) {
			$ico = '';
			if($row['ico']!='') {
				$ico = str_replace('{STATICURL}', STATICURL, $row['ico']);
				if(!preg_match("/^".preg_quote(STATICURL, '/')."/i", $ico) && !(($valueparse = parse_url($ico)) && isset($valueparse['host']))) {
					$ico = $_G['setting']['attachurl'].'common/'.$row['ico'].'?'.random(6);
				}
			}
			$row['ico'] = $ico;
			$outdata[$row['mokuaiid']] = $row;
		}
	}elseif($apiaction == 'installmokuai'){
		$outdata['salt'] = $site_info['salt'];
		$outdata['return_text'] = lang('plugin/yiqixueba','mokuai_install_return'.$indata['step']);
		if($indata['step']>10){
			$outdata['type'] = 'succeed';
			$outdata['step'] = '&subop=mokuailist&mokuaiid='.$indata['mokuaiid'].'&step='.($indata['step']+1);
		}else{
			$outdata['type'] = 'loading';
			$outdata['step'] = '&subop=install&mokuaiid='.$indata['mokuaiid'].'&step='.($indata['step']+1);
		}
	}
}else{
	$outdata['error'] = 'error';
}
?>