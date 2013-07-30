<?php

/**
*	一起学吧平台程序
*	文件名：tuangou_setting.inc.php.inc.php  创建时间：2013-6-12 20:39  杨文
*
*/

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
$this_page = 'plugins&identifier=yiqixueba&pmod=admin&submod=tuangou_setting.inc.php';

$subac = getgpc('subac');
$subacs = array('tuangou_setting.inc.phplist','tuangou_setting.inc.phpedit');
$subac = in_array($subac,$subacs) ? $subac : $subacs[0];

$tuangou_setting.inc.phpid = getgpc('tuangou_setting.inc.phpid');
$tuangou_setting.inc.php_info = $tuangou_setting.inc.phpid ? DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_tuangou_setting.inc.php')." WHERE tuangou_setting.inc.phpid=".$tuangou_setting.inc.phpid) : array();

if($subac == 'tuangou_setting.inc.phplist') {
	if(!submitcheck('submit')) {
		showtips(lang('plugin/yiqixueba','tuangou_setting.inc.php_list_tips'));
		showformheader($this_page.'&subac=tuangou_setting.inc.phplist');
		showtableheader(lang('plugin/yiqixueba','tuangou_setting.inc.php_list'));
		showsubtitle(array('', lang('plugin/yiqixueba','tuangou_setting.inc.phpname'),lang('plugin/yiqixueba','shopnum'), lang('plugin/yiqixueba','tuangou_setting.inc.phpquanxian'), lang('plugin/yiqixueba','status'), ''));
		//$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_tuangou_setting.inc.php')." order by tuangou_setting.inc.phpid asc");
		//while($row = DB::fetch($query)) {
			showtablerow('', array('class="td25"','class="td23"', 'class="td23"', 'class="td23"','class="td25"',''), array(
				"<input class=\"checkbox\" type=\"checkbox\" name=\"delete[]\" value=\"$row[tuangou_setting.inc.phpid]\">",
			$row['tuangou_setting.inc.phpname'],
			$row['tuangou_setting.inc.phpname'],
			$row['tuangou_setting.inc.phpname'],
			"<input class=\"checkbox\" type=\"checkbox\" name=\"statusnew[".$row['tuangou_setting.inc.phpid']."]\" value=\"1\" ".($row['status'] > 0 ? 'checked' : '').">",
				"<a href=\"".ADMINSCRIPT."?action=".$this_page."&subac=tuangou_setting.inc.phpedit&tuangou_setting.inc.phpid=$row[tuangou_setting.inc.phpid]\" class=\"act\">".lang('plugin/yiqixueba','edit')."</a>",
			));
		//}
		echo '<tr><td></td><td colspan="6"><div><a href="'.ADMINSCRIPT.'?action='.$this_page.'&subac=tuangou_setting.inc.phpedit" class="addtr">'.lang('plugin/yiqixueba','add_tuangou_setting.inc.php').'</a></div></td></tr>';
		showsubmit('submit','submit','del');
		showtablefooter();
		showformfooter();
	}else{
	}
}elseif($subac == 'tuangou_setting.inc.phpedit') {
	if(!submitcheck('submit')) {
		showtips(lang('plugin/yiqixueba','tuangou_setting.inc.php_edit_tips'));
		showformheader($this_page.'&subac=tuangou_setting.inc.phpedit','enctype');
		showtableheader(lang('plugin/yiqixueba','tuangou_setting.inc.php_edit'));
		$tuangou_setting.inc.phpid ? showhiddenfields(array('tuangou_setting.inc.phpid'=>$tuangou_setting.inc.phpid)) : '';
		showsetting(lang('plugin/yiqixueba','tuangou_setting.inc.phpname'),'tuangou_setting.inc.php_info[tuangou_setting.inc.phpname]',$tuangou_setting.inc.php_info['tuangou_setting.inc.phpname'],'text','',0,lang('plugin/yiqixueba','tuangou_setting.inc.phpname_comment'),'','',true);
		showsubmit('submit');
		showtablefooter();
		showformfooter();
	}else{
		if(!htmlspecialchars(trim($_GET['tuangou_setting.inc.php_info']['tuangou_setting.inc.phpname']))) {
			cpmsg(lang('plugin/yiqixueba','tuangou_setting.inc.phpname_nonull'));
		}
		$datas = $_GET['tuangou_setting.inc.php_info'];
		foreach ( $datas as $k=>$v) {
			$data[$k] = htmlspecialchars(trim($v));
			if(!DB::result_first("describe ".DB::table('yiqixueba_tuangou_setting.inc.php')." ".$k)) {
				$sql = "alter table ".DB::table('yiqixueba_tuangou_setting.inc.php')." add `".$k."` varchar(255) not Null;";
				runquery($sql);
			}
		}
		if($tuangou_setting.inc.phpid) {
			DB::update('yiqixueba_tuangou_setting.inc.php',$data,array('tuangou_setting.inc.phpid'=>$tuangou_setting.inc.phpid));
		}else{
			DB::insert('yiqixueba_tuangou_setting.inc.php',$data);
		}
		cpmsg(lang('plugin/yiqixueba', 'tuangou_setting.inc.php_edit_succeed'), 'action='.$this_page.'&subac=tuangou_setting.inc.phplist', 'succeed');
	}
}

?>