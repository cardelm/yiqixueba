<?php

/**
*	一起学吧平台程序
*	文件名：wxqshopadmin.inc.php  创建时间：2013-6-14 09:38  杨文
*
*/

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
$this_page = 'plugins&identifier=yiqixueba&pmod=admin&submod=wxqshopadmin';

$subac = getgpc('subac');
$subacs = array('wxqshopadminlist','wxqshopadminedit');
$subac = in_array($subac,$subacs) ? $subac : $subacs[0];

$wxqshopadminid = getgpc('wxqshopadminid');
$wxqshopadmin_info = $wxqshopadminid ? DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_wxqshopadmin')." WHERE wxqshopadminid=".$wxqshopadminid) : array();

if($subac == 'wxqshopadminlist') {
	if(!submitcheck('submit')) {
		showtips(lang('plugin/yiqixueba','wxqshopadmin_list_tips'));
		showformheader($this_page.'&subac=wxqshopadminlist');
		showtableheader(lang('plugin/yiqixueba','wxqshopadmin_list'));
		showsubtitle(array('', lang('plugin/yiqixueba','wxqshopadminname'),lang('plugin/yiqixueba','shopnum'), lang('plugin/yiqixueba','wxqshopadminquanxian'), lang('plugin/yiqixueba','status'), ''));
		//$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_wxqshopadmin')." order by wxqshopadminid asc");
		//while($row = DB::fetch($query)) {
			showtablerow('', array('class="td25"','class="td23"', 'class="td23"', 'class="td23"','class="td25"',''), array(
				"<input class=\"checkbox\" type=\"checkbox\" name=\"delete[]\" value=\"$row[wxqshopadminid]\">",
			$row['wxqshopadminname'],
			$row['wxqshopadminname'],
			$row['wxqshopadminname'],
			"<input class=\"checkbox\" type=\"checkbox\" name=\"statusnew[".$row['wxqshopadminid']."]\" value=\"1\" ".($row['status'] > 0 ? 'checked' : '').">",
				"<a href=\"".ADMINSCRIPT."?action=".$this_page."&subac=wxqshopadminedit&wxqshopadminid=$row[wxqshopadminid]\" class=\"act\">".lang('plugin/yiqixueba','edit')."</a>",
			));
		//}
		echo '<tr><td></td><td colspan="6"><div><a href="'.ADMINSCRIPT.'?action='.$this_page.'&subac=wxqshopadminedit" class="addtr">'.lang('plugin/yiqixueba','add_wxqshopadmin').'</a></div></td></tr>';
		showsubmit('submit','submit','del');
		showtablefooter();
		showformfooter();
	}else{
	}
}elseif($subac == 'wxqshopadminedit') {
	if(!submitcheck('submit')) {
		showtips(lang('plugin/yiqixueba','wxqshopadmin_edit_tips'));
		showformheader($this_page.'&subac=wxqshopadminedit','enctype');
		showtableheader(lang('plugin/yiqixueba','wxqshopadmin_edit'));
		$wxqshopadminid ? showhiddenfields(array('wxqshopadminid'=>$wxqshopadminid)) : '';
		showsetting(lang('plugin/yiqixueba','wxqshopadminname'),'wxqshopadmin_info[wxqshopadminname]',$wxqshopadmin_info['wxqshopadminname'],'text','',0,lang('plugin/yiqixueba','wxqshopadminname_comment'),'','',true);
		showsubmit('submit');
		showtablefooter();
		showformfooter();
	}else{
		if(!htmlspecialchars(trim($_GET['wxqshopadmin_info']['wxqshopadminname']))) {
			cpmsg(lang('plugin/yiqixueba','wxqshopadminname_nonull'));
		}
		$datas = $_GET['wxqshopadmin_info'];
		foreach ( $datas as $k=>$v) {
			$data[$k] = htmlspecialchars(trim($v));
			if(!DB::result_first("describe ".DB::table('yiqixueba_wxqshopadmin')." ".$k)) {
				$sql = "alter table ".DB::table('yiqixueba_wxqshopadmin')." add `".$k."` varchar(255) not Null;";
				runquery($sql);
			}
		}
		if($wxqshopadminid) {
			DB::update('yiqixueba_wxqshopadmin',$data,array('wxqshopadminid'=>$wxqshopadminid));
		}else{
			DB::insert('yiqixueba_wxqshopadmin',$data);
		}
		cpmsg(lang('plugin/yiqixueba', 'wxqshopadmin_edit_succeed'), 'action='.$this_page.'&subac=wxqshopadminlist', 'succeed');
	}
}

?>