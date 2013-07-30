<?php

/**
*	一起学吧平台程序
*	文件名：wxq123_sort.inc.php  创建时间：2013-6-15 15:58  杨文
*
*/

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
$this_page = 'plugins&identifier=yiqixueba&pmod=admin&submod=wxq123_sort';

$subac = getgpc('subac');
$subacs = array('wxq123_sortlist','wxq123_sortedit');
$subac = in_array($subac,$subacs) ? $subac : $subacs[0];

$wxq123_sortid = getgpc('wxq123_sortid');
$wxq123_sort_info = $wxq123_sortid ? DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_wxq123_sort')." WHERE wxq123_sortid=".$wxq123_sortid) : array();

if($subac == 'wxq123_sortlist') {
	if(!submitcheck('submit')) {
		showtips(lang('plugin/yiqixueba','wxq123_sort_list_tips'));
		showformheader($this_page.'&subac=wxq123_sortlist');
		showtableheader(lang('plugin/yiqixueba','wxq123_sort_list'));
		showsubtitle(array('', lang('plugin/yiqixueba','wxq123_sortname'),lang('plugin/yiqixueba','shopnum'), lang('plugin/yiqixueba','wxq123_sortquanxian'), lang('plugin/yiqixueba','status'), ''));
		//$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_wxq123_sort')." order by wxq123_sortid asc");
		//while($row = DB::fetch($query)) {
			showtablerow('', array('class="td25"','class="td23"', 'class="td23"', 'class="td23"','class="td25"',''), array(
				"<input class=\"checkbox\" type=\"checkbox\" name=\"delete[]\" value=\"$row[wxq123_sortid]\">",
			$row['wxq123_sortname'],
			$row['wxq123_sortname'],
			$row['wxq123_sortname'],
			"<input class=\"checkbox\" type=\"checkbox\" name=\"statusnew[".$row['wxq123_sortid']."]\" value=\"1\" ".($row['status'] > 0 ? 'checked' : '').">",
				"<a href=\"".ADMINSCRIPT."?action=".$this_page."&subac=wxq123_sortedit&wxq123_sortid=$row[wxq123_sortid]\" class=\"act\">".lang('plugin/yiqixueba','edit')."</a>",
			));
		//}
		echo '<tr><td></td><td colspan="6"><div><a href="'.ADMINSCRIPT.'?action='.$this_page.'&subac=wxq123_sortedit" class="addtr">'.lang('plugin/yiqixueba','add_wxq123_sort').'</a></div></td></tr>';
		showsubmit('submit','submit','del');
		showtablefooter();
		showformfooter();
	}else{
	}
}elseif($subac == 'wxq123_sortedit') {
	if(!submitcheck('submit')) {
		showtips(lang('plugin/yiqixueba','wxq123_sort_edit_tips'));
		showformheader($this_page.'&subac=wxq123_sortedit','enctype');
		showtableheader(lang('plugin/yiqixueba','wxq123_sort_edit'));
		$wxq123_sortid ? showhiddenfields(array('wxq123_sortid'=>$wxq123_sortid)) : '';
		showsetting(lang('plugin/yiqixueba','wxq123_sortname'),'wxq123_sort_info[wxq123_sortname]',$wxq123_sort_info['wxq123_sortname'],'text','',0,lang('plugin/yiqixueba','wxq123_sortname_comment'),'','',true);
		showsubmit('submit');
		showtablefooter();
		showformfooter();
	}else{
		if(!htmlspecialchars(trim($_GET['wxq123_sort_info']['wxq123_sortname']))) {
			cpmsg(lang('plugin/yiqixueba','wxq123_sortname_nonull'));
		}
		$datas = $_GET['wxq123_sort_info'];
		foreach ( $datas as $k=>$v) {
			$data[$k] = htmlspecialchars(trim($v));
			if(!DB::result_first("describe ".DB::table('yiqixueba_wxq123_sort')." ".$k)) {
				$sql = "alter table ".DB::table('yiqixueba_wxq123_sort')." add `".$k."` varchar(255) not Null;";
				runquery($sql);
			}
		}
		if($wxq123_sortid) {
			DB::update('yiqixueba_wxq123_sort',$data,array('wxq123_sortid'=>$wxq123_sortid));
		}else{
			DB::insert('yiqixueba_wxq123_sort',$data);
		}
		cpmsg(lang('plugin/yiqixueba', 'wxq123_sort_edit_succeed'), 'action='.$this_page.'&subac=wxq123_sortlist', 'succeed');
	}
}

?>