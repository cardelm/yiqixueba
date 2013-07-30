<?php

/**
*	一起学吧平台程序
*	文件名：base_shopsort.inc.php  创建时间：2013-6-8 12:37  杨文
*
*/

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
$this_page = 'plugins&identifier=yiqixueba&pmod=admin&submod=base_shopsort';

$subac = getgpc('subac');
$subacs = array('base_shopsortlist','base_shopsortedit');
$subac = in_array($subac,$subacs) ? $subac : $subacs[0];

$base_shopsortid = getgpc('base_shopsortid');
$base_shopsort_info = $base_shopsortid ? DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_base_shopsort')." WHERE base_shopsortid=".$base_shopsortid) : array();

if($subac == 'base_shopsortlist') {
	if(!submitcheck('submit')) {
		showtips(lang('plugin/yiqixueba','base_shopsort_list_tips'));
		showformheader($this_page.'&subac=base_shopsortlist');
		showtableheader(lang('plugin/yiqixueba','base_shopsort_list'));
		showsubtitle(array('', lang('plugin/yiqixueba','base_shopsortname'),lang('plugin/yiqixueba','shopnum'), lang('plugin/yiqixueba','base_shopsortquanxian'), lang('plugin/yiqixueba','status'), ''));
		//$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_base_shopsort')." order by base_shopsortid asc");
		//while($row = DB::fetch($query)) {
			showtablerow('', array('class="td25"','class="td23"', 'class="td23"', 'class="td23"','class="td25"',''), array(
				"<input class=\"checkbox\" type=\"checkbox\" name=\"delete[]\" value=\"$row[base_shopsortid]\">",
			$row['base_shopsortname'],
			$row['base_shopsortname'],
			$row['base_shopsortname'],
			"<input class=\"checkbox\" type=\"checkbox\" name=\"statusnew[".$row['base_shopsortid']."]\" value=\"1\" ".($row['status'] > 0 ? 'checked' : '').">",
				"<a href=\"".ADMINSCRIPT."?action=".$this_page."&subac=base_shopsortedit&base_shopsortid=$row[base_shopsortid]\" class=\"act\">".lang('plugin/yiqixueba','edit')."</a>",
			));
		//}
		echo '<tr><td></td><td colspan="6"><div><a href="'.ADMINSCRIPT.'?action='.$this_page.'&subac=base_shopsortedit" class="addtr">'.lang('plugin/yiqixueba','add_base_shopsort').'</a></div></td></tr>';
		showsubmit('submit','submit','del');
		showtablefooter();
		showformfooter();
	}else{
	}
}elseif($subac == 'base_shopsortedit') {
	if(!submitcheck('submit')) {
		showtips(lang('plugin/yiqixueba','base_shopsort_edit_tips'));
		showformheader($this_page.'&subac=base_shopsortedit','enctype');
		showtableheader(lang('plugin/yiqixueba','base_shopsort_edit'));
		$base_shopsortid ? showhiddenfields(array('base_shopsortid'=>$base_shopsortid)) : '';
		showsetting(lang('plugin/yiqixueba','base_shopsortname'),'base_shopsort_info[base_shopsortname]',$base_shopsort_info['base_shopsortname'],'text','',0,lang('plugin/yiqixueba','base_shopsortname_comment'),'','',true);
		showsubmit('submit');
		showtablefooter();
		showformfooter();
	}else{
		if(!htmlspecialchars(trim($_GET['base_shopsort_info']['base_shopsortname']))) {
			cpmsg(lang('plugin/yiqixueba','base_shopsortname_nonull'));
		}
		$datas = $_GET['base_shopsort_info'];
		foreach ( $datas as $k=>$v) {
			$data[$k] = htmlspecialchars(trim($v));
			if(!DB::result_first("describe ".DB::table('yiqixueba_base_shopsort')." ".$k)) {
				$sql = "alter table ".DB::table('yiqixueba_base_shopsort')." add `".$k."` varchar(255) not Null;";
				runquery($sql);
			}
		}
		if($base_shopsortid) {
			DB::update('yiqixueba_base_shopsort',$data,array('base_shopsortid'=>$base_shopsortid));
		}else{
			DB::insert('yiqixueba_base_shopsort',$data);
		}
		cpmsg(lang('plugin/yiqixueba', 'base_shopsort_edit_succeed'), 'action='.$this_page.'&subac=base_shopsortlist', 'succeed');
	}
}

?>