<?php

//--main start--
function getpageid($submod,$subop,$pagetype) {
	$pagetype = empty($pagetype) ? 0 : intval($pagetype);
	$subop = empty($subop) ? 'index' : trim($subop);
	if(DB::result_first("SELECT count(*) FROM ".DB::table('yiqixueba_main_pageid')." WHERE pagetype=".$pagetype." and submod='".$submod."' and subop = '".$subop."'")==0) {
		$data['pagetype'] = $pagetype;
		$data['submod'] = $submod;
		$data['subop'] = $subop;
		$data['pageid'] = md5($submod.$subop);
		DB::insert('yiqixueba_main_pageid',$data);
	}
	$pageid = DB::result_first("SELECT pageid FROM ".DB::table('yiqixueba_main_pageid')." WHERE pagetype=".$pagetype." and submod='".$submod."' and subop = '".$subop."'");
	$pagefile = DISCUZ_ROOT.'source/plugin/yiqixueba/data/'.$pageid.'.php';
	if(!file_exists($pagefile)) {
		file_put_contents($pagefile,"<?php\n\n//This pageid is ".$pageid.".php\n//submod:".$submod."\n//subop:".$subop."\n\nif(!defined('IN_DISCUZ')) {\n\texit('Access Denied');\n}\n\n\$pageid = '".$pageid.".php';\n\ninclude template('yiqixueba:".$pageid."');\n?>");
	}
	$tempfile = DISCUZ_ROOT.'source/plugin/yiqixueba/template/'.$pageid.'.htm';
	if(!file_exists($tempfile)) {
		//file_put_contents($tempfile,"<!-- This template is ".$pageid.".htm-->\n<!-- This submod is ".$submod."-->\n<!-- This subop is ".$subop."-->\n\n<!--{template common/header}-->\n\n\n<!--{subtemplate common/footer}-->");
		file_put_contents($tempfile,"<!--{template common/header}-->\n\n\n<!--{subtemplate common/footer}-->");
	}
	return $pagefile;
}//end func
//
function abc(){

}//end func
//--main end--
?>