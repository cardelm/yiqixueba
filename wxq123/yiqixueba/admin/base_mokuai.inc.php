<?php

/**
*	一起学吧平台程序
*	文件名：base_mokuai.inc.php  创建时间：2013-6-4 09:36  杨文
*
*/

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
$this_page = 'plugins&identifier=yiqixueba&pmod=admin&submod=base_mokuai';

$subac = getgpc('subac');
$subacs = array('mokuailist','mokuaiedit','mokuaisetting','mokuaiclose','mokuaiopen','mokuaiinstall','mokuaiuninstall');
$subac = in_array($subac,$subacs) ? $subac : $subacs[0];

$mokuaiid = getgpc('mokuaiid');
$mokuai_info = $mokuaiid ? DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_mokuai')." WHERE mokuaiid=".$mokuaiid) : array();

//var_dump($subac);

if($subac == 'mokuailist') {
	if(!submitcheck('submit')) {
		//服务器端的模块数据
		$indata = array();
		$server_mokuais = api_indata('getmokuailist',$indata);
		//dump($server_mokuais);
		foreach ( $server_mokuais as $k=>$v) {
			$mokuai_c_list = DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_mokuai')." WHERE mokuainame='".$v['mokuainame']."'");
			if($mokuai_c_list) {
				unset($server_mokuais[$k]);
			}
		}
		//服务器端的模块数据
		//var_dump($server_mokuais);
		showtips(lang('plugin/yiqixueba','mokuai_list_tips'));
		showformheader($this_page.'&subac=mokuailist');
		showtableheader(lang('plugin/yiqixueba','yes_mokuai_list'));
		showsubtitle(array('', lang('plugin/yiqixueba','mokuaititle'),lang('plugin/yiqixueba','mokuaiver'), lang('plugin/yiqixueba','mokuaipice'),lang('plugin/yiqixueba','upmokuai'), lang('plugin/yiqixueba','description'), ''));
		$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_mokuai')." order by displayorder asc");
		while($row = DB::fetch($query)) {
			showtablerow('', array('class="td25"','class="td23"', 'class="td23"','class="td25"', 'class="td23"','class="td28"',''), array(
				'',
				$row['mokuaititle'],
				$row['mokuaiver'],
				$row['mokuaipice'],
				$row['upmokuai'],
				$row['mokuaidescription'],
				($row['status'] ? ("<a href=\"".ADMINSCRIPT."?action=".$this_page."&subac=mokuaisetting&mokuaiid=$row[mokuaiid]\" class=\"act\">".lang('plugin/yiqixueba','mokuai_setting')."</a>&nbsp;&nbsp;<a href=\"".ADMINSCRIPT."?action=".$this_page."&subac=mokuaiclose&mokuaiid=$row[mokuaiid]\" class=\"act\">".lang('plugin/yiqixueba','mokuai_close')."</a>&nbsp;&nbsp;") : ("<a href=\"".ADMINSCRIPT."?action=".$this_page."&subac=mokuaiopen&mokuaiid=$row[mokuaiid]\" class=\"act\">".lang('plugin/yiqixueba','mokuai_open')."</a>&nbsp;&nbsp;"))."<a href=\"".ADMINSCRIPT."?action=".$this_page."&subac=mokuaiuninstall&mokuaiid=$row[mokuaiid]\" class=\"act\">".lang('plugin/yiqixueba','mokuai_uninstall')."</a>",
			));
		}
		showtablefooter();
		showtableheader(lang('plugin/yiqixueba','no_mokuai_list'));
		showsubtitle(array('', lang('plugin/yiqixueba','mokuaititle'),lang('plugin/yiqixueba','mokuaiver'), lang('plugin/yiqixueba','mokuaipice'),lang('plugin/yiqixueba','upmokuai'), lang('plugin/yiqixueba','description'), ''));
		foreach ( $server_mokuais as  $k=>$v) {
			showtablerow('', array('class="td25"','class="td23"', 'class="td23"','class="td25"', 'class="td23"','class="td28"',''), array(
				"",
			$v['mokuaititle'],
			$v['versionname'],
			$v['mokuaipice'],
			$v['upmokuai'],
			$v['mokuaidescription'],
				"<a href=\"".ADMINSCRIPT."?action=".$this_page."&subac=mokuaiinstall&verid=$v[verid]\" class=\"act\">".lang('plugin/yiqixueba','mokuai_install').$v['verid']."</a>",
			));
		}
		showsubmit('submit','submit','del');
		showtablefooter();
		showformfooter();
	}else{
	}
}elseif($subac == 'mokuaiedit') {
	if(!submitcheck('submit')) {
		showtips(lang('plugin/yiqixueba','mokuai_edit_tips'));
		showformheader($this_page.'&subac=mokuaiedit','enctype');
		showtableheader(lang('plugin/yiqixueba','mokuai_edit'));
		$mokuaiid ? showhiddenfields(array('mokuaiid'=>$mokuaiid)) : '';
		showsetting(lang('plugin/yiqixueba','mokuainame'),'mokuai_info[mokuainame]',$mokuai_info['mokuainame'],'text','',0,lang('plugin/yiqixueba','mokuainame_comment'),'','',true);
		showsubmit('submit');
		showtablefooter();
		showformfooter();
	}else{
		if(!htmlspecialchars(trim($_GET['mokuai_info']['mokuainame']))) {
			cpmsg(lang('plugin/yiqixueba','mokuainame_nonull'));
		}
		$datas = $_GET['mokuai_info'];
		foreach ( $datas as $k=>$v) {
			$data[$k] = htmlspecialchars(trim($v));
			if(!DB::result_first("describe ".DB::table('yiqixueba_mokuai')." ".$k)) {
				$sql = "alter table ".DB::table('yiqixueba_mokuai')." add `".$k."` varchar(255) not Null;";
				runquery($sql);
			}
		}
		if($mokuaiid) {
			DB::update('yiqixueba_mokuai',$data,array('mokuaiid'=>$mokuaiid));
		}else{
			DB::insert('yiqixueba_mokuai',$data);
		}
		cpmsg(lang('plugin/yiqixueba', 'mokuai_edit_succeed'), 'action='.$this_page.'&subac=mokuailist', 'succeed');
	}
}elseif($subac == 'mokuaiclose') {
	DB::update('yiqixueba_mokuai',array('status'=>0),array('mokuaiid'=>$mokuaiid));
	cpmsg(lang('plugin/yiqixueba', 'mokuai_edit_succeed'), 'action='.$this_page.'&subac=mokuailist', 'succeed');

}elseif($subac == 'mokuaiopen') {
	DB::update('yiqixueba_mokuai',array('status'=>1),array('mokuaiid'=>$mokuaiid));
	cpmsg(lang('plugin/yiqixueba', 'mokuai_edit_succeed'), 'action='.$this_page.'&subac=mokuailist', 'succeed');
}elseif($subac == 'mokuaiinstall') {
	//服务器端的模块数据
	$indata = array();
	$server_mokuais = api_indata('getmokuailist',$indata);
	foreach ( $server_mokuais as $k=>$v) {
		$mokuai_c_list = DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_mokuai')." WHERE mokuainame='".$v['mokuainame']."'");
		if($mokuai_c_list) {
			unset($server_mokuais[$k]);
		}
	}
	//服务器端的模块数据
	//dump($server_mokuais);
	$verid = intval($_GET['verid']);
	//dump($verid);
	$data = array();
	$data['mokuainame'] = $server_mokuais[$verid]['mokuainame'];
	$data['mokuaititle'] = $server_mokuais[$verid]['mokuaititle'];
	$data['mokuaiver'] = $server_mokuais[$verid]['versionname'];
	$data['upmokuai'] = $server_mokuais[$verid]['upmokuai'];
	$data['mokuaipice'] = $server_mokuais[$verid]['mokuaipice'];
	$data['mokuaidescription'] = $server_mokuais[$verid]['mokuaidescription'];
	$data['installtime'] = TIMESTAMP;
	//dump($data);
	if (DB::result_first("SELECT count(*) FROM ".DB::table('yiqixueba_mokuai')." WHERE mokuainame='".$data['mokuainame']."'")==0){
		DB::insert('yiqixueba_mokuai',$data);
	}
	cpmsg(lang('plugin/yiqixueba', 'mokuai_edit_succeed'), 'action='.$this_page.'&subac=mokuailist', 'succeed');
}elseif($subac == 'mokuaiuninstall') {
	DB::delete('yiqixueba_mokuai',array('mokuaiid'=>$mokuaiid));
	cpmsg(lang('plugin/yiqixueba', 'mokuai_edit_succeed'), 'action='.$this_page.'&subac=mokuailist', 'succeed');

}elseif($subac == 'mokuaisetting') {
	$setting_file = DISCUZ_ROOT.'source/plugin/yiqixueba/admin/'.($mokuai_info['upmokuai'] ? $mokuai_info['upmokuai'].'_' : '').$mokuai_info['mokuainame'].'_setting.inc.php';
	if (!file_exists($setting_file)){
		copy(DISCUZ_ROOT.'source/plugin/yiqixueba/admin/brand_dianping_setting.inc.php',$setting_file);
	}
	require_once $setting_file;
	//cpmsg(lang('plugin/yiqixueba', 'mokuai_setting_error'), 'action='.$this_page.'&subac=mokuailist', 'error');

}

?>