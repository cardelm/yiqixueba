<?php

/**
*	一起学吧平台程序
*	文件名：wxq_wxqwx.inc.php  创建时间：2013-6-4 09:37  杨文
*
*/

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
$this_page = 'plugins&identifier=yiqixueba&pmod=admin&submod=wxqwx';

$subac = getgpc('subac');
$subacs = array('wxqwxlist','wxqwxedit');
$subac = in_array($subac,$subacs) ? $subac : $subacs[0];

$wxqwxid = getgpc('wxqwxid');
$wxqwx_info = $wxqwxid ? DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_wxqwx')." WHERE wxqwxid=".$wxqwxid) : array();

if($subac == 'wxqwxlist') {
	if(!submitcheck('submit')) {
		showtips(lang('plugin/yiqixueba','wxqwx_list_tips'));
		showformheader($this_page.'&subac=wxqwxlist');
		showtableheader(lang('plugin/yiqixueba','wxqwx_list'));
		showsubtitle(array('', lang('plugin/yiqixueba','wxqwxname'),lang('plugin/yiqixueba','shopnum'), lang('plugin/yiqixueba','wxqwxquanxian'), lang('plugin/yiqixueba','status'), ''));
		//$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_wxqwx')." order by wxqwxid asc");
		//while($row = DB::fetch($query)) {
			showtablerow('', array('class="td25"','class="td23"', 'class="td23"', 'class="td23"','class="td25"',''), array(
				"<input class=\"checkbox\" type=\"checkbox\" name=\"delete[]\" value=\"$row[wxqwxid]\">",
			$row['wxqwxname'],
			$row['wxqwxname'],
			$row['wxqwxname'],
			"<input class=\"checkbox\" type=\"checkbox\" name=\"statusnew[".$row['wxqwxid']."]\" value=\"1\" ".($row['status'] > 0 ? 'checked' : '').">",
				"<a href=\"".ADMINSCRIPT."?action=".$this_page."&subac=wxqwxedit&wxqwxid=$row[wxqwxid]\" class=\"act\">".lang('plugin/yiqixueba','edit')."</a>",
			));
		//}
		echo '<tr><td></td><td colspan="6"><div><a href="'.ADMINSCRIPT.'?action='.$this_page.'&subac=wxqwxedit" class="addtr">'.lang('plugin/yiqixueba','add_wxqwx').'</a></div></td></tr>';
		showsubmit('submit','submit','del');
		showtablefooter();
		showformfooter();
	}else{
	}
}elseif($subac == 'wxqwxedit') {
	if(!submitcheck('submit')) {
		showtips(lang('plugin/yiqixueba','wxqwx_edit_tips'));
		showformheader($this_page.'&subac=wxqwxedit','enctype');
		showtableheader(lang('plugin/yiqixueba','wxqwx_edit'));
		$wxqwxid ? showhiddenfields(array('wxqwxid'=>$wxqwxid)) : '';
		showsetting(lang('plugin/yiqixueba','wxqwxname'),'wxqwx_info[wxqwxname]',$wxqwx_info['wxqwxname'],'text','',0,lang('plugin/yiqixueba','wxqwxname_comment'),'','',true);
		showsubmit('submit');
		showtablefooter();
		showformfooter();
	}else{
		if(!htmlspecialchars(trim($_GET['wxqwx_info']['wxqwxname']))) {
			cpmsg(lang('plugin/yiqixueba','wxqwxname_nonull'));
		}
		$datas = $_GET['wxqwx_info'];
		foreach ( $datas as $k=>$v) {
			$data[$k] = htmlspecialchars(trim($v));
			if(!DB::result_first("describe ".DB::table('yiqixueba_wxqwx')." ".$k)) {
				$sql = "alter table ".DB::table('yiqixueba_wxqwx')." add `".$k."` varchar(255) not Null;";
				runquery($sql);
			}
		}
		if($wxqwxid) {
			DB::update('yiqixueba_wxqwx',$data,array('wxqwxid'=>$wxqwxid));
		}else{
			DB::insert('yiqixueba_wxqwx',$data);
		}
		cpmsg(lang('plugin/yiqixueba', 'wxqwx_edit_succeed'), 'action='.$this_page.'&subac=wxqwxlist', 'succeed');
	}
}

?>