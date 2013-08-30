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
	$outdata[] = array('type'=>'sqldata','filetext'=>"
DROP TABLE IF EXISTS `pre_yiqixueba_setting`;
CREATE TABLE `pre_yiqixueba_setting` (
  `skey` varchar(255) NOT NULL,
  `svalue` text NOT NULL,
  PRIMARY KEY  (`skey`)
) ENGINE=MyISAM;
DROP TABLE IF EXISTS `pre_yiqixueba_mokuai`;
CREATE TABLE `pre_yiqixueba_mokuai` (
  `mokuaiid` smallint(6) unsigned NOT NULL auto_increment,
  `available` tinyint(1) NOT NULL default '0',
  `adminid` tinyint(1) unsigned NOT NULL default '0',
  `name` varchar(40) NOT NULL default '',
  `identifier` varchar(40) NOT NULL default '',
  `description` varchar(255) NOT NULL default '',
  `datatables` varchar(255) NOT NULL default '',
  `price` char(10) NOT NULL default '',
  `directory` varchar(100) NOT NULL default '',
  `copyright` varchar(100) NOT NULL default '',
  `modules` text NOT NULL,
  `version` varchar(20) NOT NULL default '',
  `setting` text NOT NULL,
  `displayorder` smallint(6) NOT NULL,
  PRIMARY KEY  (`mokuaiid`),
  UNIQUE KEY `identifier` (`identifier`)
) ENGINE=MyISAM;
");
	$main_mokuai_array = DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_server_mokuai')." WHERE identifier='main'");
	unset($main_mokuai_array['ico']);
	unset($main_mokuai_array['currentversion']);
	unset($main_mokuai_array['createtime']);
	unset($main_mokuai_array['updatetime']);
	if($site_info['charset'] != 'utf8'){
		foreach($main_mokuai_array as $k=>$v ){
			$main_mokuai_array[$k] = diconv($v,"UTF-8", $site_info['charset']."//IGNORE");
		}
	}
	$outdata[] = array('type'=>'dbi','tablename'=>'yiqixueba_setting','dbdata'=>array('skey'=>'sitekey','svalue'=>$site_info['sitekey']));
	//$outdata[] = array('type'=>'dbi','tablename'=>'yiqixueba_mokuai','dbdata'=>$main_mokuai_array);
	//$outdata[] = array('type'=>'requirefile','filename'=>'source/plugin/yiqixueba/test.inc.php','filetext'=>file_get_contents(DISCUZ_ROOT.'source/plugin/yiqixueba/check.php'));
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