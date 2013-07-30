<?php

/**
*	一起学吧平台程序
*	文件名：wxq_weituangou.inc.php  创建时间：2013-6-7 22:44  杨文
*
*/

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
$this_page = 'plugins&identifier=yiqixueba&pmod=admin&submod=weituangou';

$subac = getgpc('subac');
$subacs = array('weituangoulist','weituangouedit');
$subac = in_array($subac,$subacs) ? $subac : $subacs[0];

$weituangouid = getgpc('weituangouid');
$weituangou_info = $weituangouid ? DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_weituangou')." WHERE weituangouid=".$weituangouid) : array();

if($subac == 'weituangoulist') {
	if(!submitcheck('submit')) {
		showtips(lang('plugin/yiqixueba','weituangou_list_tips'));
		showformheader($this_page.'&subac=weituangoulist');
		showtableheader(lang('plugin/yiqixueba','weituangou_list'));
		showsubtitle(array('', lang('plugin/yiqixueba','weituangouname'),lang('plugin/yiqixueba','shopnum'), lang('plugin/yiqixueba','weituangouquanxian'), lang('plugin/yiqixueba','status'), ''));
		//$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_weituangou')." order by weituangouid asc");
		//while($row = DB::fetch($query)) {
			showtablerow('', array('class="td25"','class="td23"', 'class="td23"', 'class="td23"','class="td25"',''), array(
				"<input class=\"checkbox\" type=\"checkbox\" name=\"delete[]\" value=\"$row[weituangouid]\">",
			$row['weituangouname'],
			$row['weituangouname'],
			$row['weituangouname'],
			"<input class=\"checkbox\" type=\"checkbox\" name=\"statusnew[".$row['weituangouid']."]\" value=\"1\" ".($row['status'] > 0 ? 'checked' : '').">",
				"<a href=\"".ADMINSCRIPT."?apiaction=".$this_page."&subac=weituangouedit&weituangouid=$row[weituangouid]\" class=\"act\">".lang('plugin/yiqixueba','edit')."</a>",
			));
		//}
		echo '<tr><td></td><td colspan="6"><div><a href="'.ADMINSCRIPT.'?apiaction='.$this_page.'&subac=weituangouedit" class="addtr">'.lang('plugin/yiqixueba','add_weituangou').'</a></div></td></tr>';
		showsubmit('submit','submit','del');
		showtablefooter();
		showformfooter();
	}else{
	}
}elseif($subac == 'weituangouedit') {
	if(!submitcheck('submit')) {
		showtips(lang('plugin/yiqixueba','weituangou_edit_tips'));
		showformheader($this_page.'&subac=weituangouedit','enctype');
		showtableheader(lang('plugin/yiqixueba','weituangou_edit'));
		$weituangouid ? showhiddenfields(array('weituangouid'=>$weituangouid)) : '';
		showsetting(lang('plugin/yiqixueba','weituangouname'),'weituangou_info[weituangouname]',$weituangou_info['weituangouname'],'text','',0,lang('plugin/yiqixueba','weituangouname_comment'),'','',true);
		showsubmit('submit');
		showtablefooter();
		showformfooter();
	}else{
		if(!htmlspecialchars(trim($_GET['weituangou_info']['weituangouname']))) {
			cpmsg(lang('plugin/yiqixueba','weituangouname_nonull'));
		}
		$datas = $_GET['weituangou_info'];
		foreach ( $datas as $k=>$v) {
			$data[$k] = htmlspecialchars(trim($v));
			if(!DB::result_first("describe ".DB::table('yiqixueba_weituangou')." ".$k)) {
				$sql = "alter table ".DB::table('yiqixueba_weituangou')." add `".$k."` varchar(255) not Null;";
				runquery($sql);
			}
		}
		if($weituangouid) {
			DB::update('yiqixueba_weituangou',$data,array('weituangouid'=>$weituangouid));
		}else{
			DB::insert('yiqixueba_weituangou',$data);
		}
		cpmsg(lang('plugin/yiqixueba', 'weituangou_edit_succeed'), 'apiaction='.$this_page.'&subac=weituangoulist', 'succeed');
	}
}

?>