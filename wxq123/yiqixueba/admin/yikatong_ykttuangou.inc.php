<?php

/**
*	一起学吧平台程序
*	文件名：yikatong_ykttuangou.inc.php  创建时间：2013-6-7 22:49  杨文
*
*/

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
$this_page = 'plugins&identifier=yiqixueba&pmod=admin&submod=ykttuangou';

$ykttuangou_setting = array();
$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_yikatong_setting')." WHERE skey like 'ykttuangou_%'");
while($row = DB::fetch($query)) {
	$ykttuangou_setting[$row['skey']] = $row['svalue'];
}

$subac = getgpc('subac');
$subacs = array('ykttuangoulist','ykttuangouedit','ykttuangousetting');
$subac = in_array($subac,$subacs) ? $subac : $subacs[0];

$ykttuangouid = getgpc('ykttuangouid');
$ykttuangou_info = $ykttuangouid ? DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_ykttuangou')." WHERE ykttuangouid=".$ykttuangouid) : array();

if($subac == 'ykttuangoulist') {
	if(!submitcheck('submit')) {
		showtips(lang('plugin/yiqixueba','ykttuangou_list_tips'));
		showformheader($this_page.'&subac=ykttuangoulist');
		showtableheader(lang('plugin/yiqixueba','ykttuangou_list').'&nbsp;&nbsp;<A href="'.ADMINSCRIPT.'?action='.$this_page.'&subac=ykttuangousetting">设置</A>');
		showsubtitle(array('', lang('plugin/yiqixueba','ykttuangouname'),lang('plugin/yiqixueba','shopnum'), lang('plugin/yiqixueba','ykttuangouquanxian'), lang('plugin/yiqixueba','status'), ''));
		//$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_ykttuangou')." order by ykttuangouid asc");
		//while($row = DB::fetch($query)) {
			showtablerow('', array('class="td25"','class="td23"', 'class="td23"', 'class="td23"','class="td25"',''), array(
				"<input class=\"checkbox\" type=\"checkbox\" name=\"delete[]\" value=\"$row[ykttuangouid]\">",
			$row['ykttuangouname'],
			$row['ykttuangouname'],
			$row['ykttuangouname'],
			"<input class=\"checkbox\" type=\"checkbox\" name=\"statusnew[".$row['ykttuangouid']."]\" value=\"1\" ".($row['status'] > 0 ? 'checked' : '').">",
				"<a href=\"".ADMINSCRIPT."?action=".$this_page."&subac=ykttuangouedit&ykttuangouid=$row[ykttuangouid]\" class=\"act\">".lang('plugin/yiqixueba','edit')."</a>",
			));
		//}
		echo '<tr><td></td><td colspan="6"><div><a href="'.ADMINSCRIPT.'?action='.$this_page.'&subac=ykttuangouedit" class="addtr">'.lang('plugin/yiqixueba','add_ykttuangou').'</a></div></td></tr>';
		showsubmit('submit','submit','del');
		showtablefooter();
		showformfooter();
	}else{
	}
}elseif($subac == 'ykttuangouedit') {
	if(!submitcheck('submit')) {
		showtips(lang('plugin/yiqixueba','ykttuangou_edit_tips'));
		showformheader($this_page.'&subac=ykttuangouedit','enctype');
		showtableheader(lang('plugin/yiqixueba','ykttuangou_edit'));
		$ykttuangouid ? showhiddenfields(array('ykttuangouid'=>$ykttuangouid)) : '';
		showsetting(lang('plugin/yiqixueba','ykttuangouname'),'ykttuangou_info[ykttuangouname]',$ykttuangou_info['ykttuangouname'],'text','',0,lang('plugin/yiqixueba','ykttuangouname_comment'),'','',true);
		showsubmit('submit');
		showtablefooter();
		showformfooter();
	}else{
		if(!htmlspecialchars(trim($_GET['ykttuangou_info']['ykttuangouname']))) {
			cpmsg(lang('plugin/yiqixueba','ykttuangouname_nonull'));
		}
		$datas = $_GET['ykttuangou_info'];
		foreach ( $datas as $k=>$v) {
			$data[$k] = htmlspecialchars(trim($v));
			if(!DB::result_first("describe ".DB::table('yiqixueba_ykttuangou')." ".$k)) {
				$sql = "alter table ".DB::table('yiqixueba_ykttuangou')." add `".$k."` varchar(255) not Null;";
				runquery($sql);
			}
		}
		if($ykttuangouid) {
			DB::update('yiqixueba_ykttuangou',$data,array('ykttuangouid'=>$ykttuangouid));
		}else{
			DB::insert('yiqixueba_ykttuangou',$data);
		}
		cpmsg(lang('plugin/yiqixueba', 'ykttuangou_edit_succeed'), 'action='.$this_page.'&subac=ykttuangoulist', 'succeed');
	}
}elseif($subac == 'ykttuangousetting') {
	if(!submitcheck('submit')) {
		showtips(lang('plugin/yiqixueba','ykttuangou_edit_tips'));
		showformheader($this_page.'&subac=ykttuangouedit','enctype');
		showtableheader(lang('plugin/yiqixueba','ykttuangou_edit'));
		$ykttuangouid ? showhiddenfields(array('ykttuangouid'=>$ykttuangouid)) : '';
		showsetting(lang('plugin/yiqixueba','ykttuangouname'),'ykttuangou_info[ykttuangouname]',$ykttuangou_info['ykttuangouname'],'text','',0,lang('plugin/yiqixueba','ykttuangouname_comment'),'','',true);
		showsubmit('submit');
		showtablefooter();
		showformfooter();
	}else{
		if(!htmlspecialchars(trim($_GET['ykttuangou_info']['ykttuangouname']))) {
			cpmsg(lang('plugin/yiqixueba','ykttuangouname_nonull'));
		}
		$datas = $_GET['ykttuangou_info'];
		foreach ( $datas as $k=>$v) {
			$data[$k] = htmlspecialchars(trim($v));
			if(!DB::result_first("describe ".DB::table('yiqixueba_ykttuangou')." ".$k)) {
				$sql = "alter table ".DB::table('yiqixueba_ykttuangou')." add `".$k."` varchar(255) not Null;";
				runquery($sql);
			}
		}
		if($ykttuangouid) {
			DB::update('yiqixueba_ykttuangou',$data,array('ykttuangouid'=>$ykttuangouid));
		}else{
			DB::insert('yiqixueba_ykttuangou',$data);
		}
		cpmsg(lang('plugin/yiqixueba', 'ykttuangou_edit_succeed'), 'action='.$this_page.'&subac=ykttuangoulist', 'succeed');
	}
}

?>