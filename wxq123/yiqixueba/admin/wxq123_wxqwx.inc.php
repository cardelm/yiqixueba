<?php

/**
*	一起学吧平台程序
*	文件名：wxq123_wxqwx.inc.php  创建时间：2013-6-17 11:30  杨文
*
*/

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
$this_page = 'plugins&identifier=yiqixueba&pmod=admin&submod=wxq123_wxqwx';

$subac = getgpc('subac');
$subacs = array('wxq123_wxqwxlist','wxq123_wxqwxedit');
$subac = in_array($subac,$subacs) ? $subac : $subacs[0];

$wxq123_wxqwxid = getgpc('wxq123_wxqwxid');
$wxq123_wxqwx_info = $wxq123_wxqwxid ? DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_wxq123_wxqwx')." WHERE wxq123_wxqwxid=".$wxq123_wxqwxid) : array();

if($subac == 'wxq123_wxqwxlist') {
	if(!submitcheck('submit')) {
		showtips(lang('plugin/yiqixueba','wxq123_wxqwx_list_tips'));
		showformheader($this_page.'&subac=wxq123_wxqwxlist');
		showtableheader(lang('plugin/yiqixueba','wxq123_wxqwx_list'));
		showsubtitle(array('', lang('plugin/yiqixueba','wxq123_wxqwxname'),lang('plugin/yiqixueba','shopnum'), lang('plugin/yiqixueba','wxq123_wxqwxquanxian'), lang('plugin/yiqixueba','status'), ''));
		//$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_wxq123_wxqwx')." order by wxq123_wxqwxid asc");
		//while($row = DB::fetch($query)) {
			showtablerow('', array('class="td25"','class="td23"', 'class="td23"', 'class="td23"','class="td25"',''), array(
				"<input class=\"checkbox\" type=\"checkbox\" name=\"delete[]\" value=\"$row[wxq123_wxqwxid]\">",
			$row['wxq123_wxqwxname'],
			$row['wxq123_wxqwxname'],
			$row['wxq123_wxqwxname'],
			"<input class=\"checkbox\" type=\"checkbox\" name=\"statusnew[".$row['wxq123_wxqwxid']."]\" value=\"1\" ".($row['status'] > 0 ? 'checked' : '').">",
				"<a href=\"".ADMINSCRIPT."?action=".$this_page."&subac=wxq123_wxqwxedit&wxq123_wxqwxid=$row[wxq123_wxqwxid]\" class=\"act\">".lang('plugin/yiqixueba','edit')."</a>",
			));
		//}
		echo '<tr><td></td><td colspan="6"><div><a href="'.ADMINSCRIPT.'?action='.$this_page.'&subac=wxq123_wxqwxedit" class="addtr">'.lang('plugin/yiqixueba','add_wxq123_wxqwx').'</a></div></td></tr>';
		showsubmit('submit','submit','del');
		showtablefooter();
		showformfooter();
	}else{
	}
}elseif($subac == 'wxq123_wxqwxedit') {
	if(!submitcheck('submit')) {
		showtips(lang('plugin/yiqixueba','wxq123_wxqwx_edit_tips'));
		showformheader($this_page.'&subac=wxq123_wxqwxedit','enctype');
		showtableheader(lang('plugin/yiqixueba','wxq123_wxqwx_edit'));
		$wxq123_wxqwxid ? showhiddenfields(array('wxq123_wxqwxid'=>$wxq123_wxqwxid)) : '';
		showsetting(lang('plugin/yiqixueba','wxq123_wxqwxname'),'wxq123_wxqwx_info[wxq123_wxqwxname]',$wxq123_wxqwx_info['wxq123_wxqwxname'],'text','',0,lang('plugin/yiqixueba','wxq123_wxqwxname_comment'),'','',true);
		showsubmit('submit');
		showtablefooter();
		showformfooter();
	}else{
		if(!htmlspecialchars(trim($_GET['wxq123_wxqwx_info']['wxq123_wxqwxname']))) {
			cpmsg(lang('plugin/yiqixueba','wxq123_wxqwxname_nonull'));
		}
		$datas = $_GET['wxq123_wxqwx_info'];
		foreach ( $datas as $k=>$v) {
			$data[$k] = htmlspecialchars(trim($v));
			if(!DB::result_first("describe ".DB::table('yiqixueba_wxq123_wxqwx')." ".$k)) {
				$sql = "alter table ".DB::table('yiqixueba_wxq123_wxqwx')." add `".$k."` varchar(255) not Null;";
				runquery($sql);
			}
		}
		if($wxq123_wxqwxid) {
			DB::update('yiqixueba_wxq123_wxqwx',$data,array('wxq123_wxqwxid'=>$wxq123_wxqwxid));
		}else{
			DB::insert('yiqixueba_wxq123_wxqwx',$data);
		}
		cpmsg(lang('plugin/yiqixueba', 'wxq123_wxqwx_edit_succeed'), 'action='.$this_page.'&subac=wxq123_wxqwxlist', 'succeed');
	}
}

?>