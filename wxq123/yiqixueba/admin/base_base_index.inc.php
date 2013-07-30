<?php

/**
*	一起学吧平台程序
*	文件名：base_base_index.inc.php  创建时间：2013-6-8 10:06  杨文
*
*/

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
$this_page = 'plugins&identifier=yiqixueba&pmod=admin&submod=base_index';

$subac = getgpc('subac');
$subacs = array('base_indexlist','base_indexedit');
$subac = in_array($subac,$subacs) ? $subac : $subacs[0];

$base_indexid = getgpc('base_indexid');
$base_index_info = $base_indexid ? DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_base_base_index')." WHERE base_indexid=".$base_indexid) : array();

if($subac == 'base_indexlist') {
	if(!submitcheck('submit')) {
		showtips(lang('plugin/yiqixueba','base_base_index_list_tips'));
		showformheader($this_page.'&subac=base_indexlist');
		showtableheader(lang('plugin/yiqixueba','base_base_index_list'));
		showsubtitle(array('', lang('plugin/yiqixueba','base_indexname'),lang('plugin/yiqixueba','shopnum'), lang('plugin/yiqixueba','base_indexquanxian'), lang('plugin/yiqixueba','status'), ''));
		//$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_base_index')." order by base_indexid asc");
		//while($row = DB::fetch($query)) {
			showtablerow('', array('class="td25"','class="td23"', 'class="td23"', 'class="td23"','class="td25"',''), array(
				"<input class=\"checkbox\" type=\"checkbox\" name=\"delete[]\" value=\"$row[base_indexid]\">",
			$row['base_indexname'],
			$row['base_indexname'],
			$row['base_indexname'],
			"<input class=\"checkbox\" type=\"checkbox\" name=\"statusnew[".$row['base_indexid']."]\" value=\"1\" ".($row['status'] > 0 ? 'checked' : '').">",
				"<a href=\"".ADMINSCRIPT."?action=".$this_page."&subac=base_indexedit&base_indexid=$row[base_indexid]\" class=\"act\">".lang('plugin/yiqixueba','edit')."</a>",
			));
		//}
		echo '<tr><td></td><td colspan="6"><div><a href="'.ADMINSCRIPT.'?action='.$this_page.'&subac=base_indexedit" class="addtr">'.lang('plugin/yiqixueba','add_base_index').'</a></div></td></tr>';
		showsubmit('submit','submit','del');
		showtablefooter();
		showformfooter();
	}else{
	}
}elseif($subac == 'base_indexedit') {
	if(!submitcheck('submit')) {
		showtips(lang('plugin/yiqixueba','base_base_index_edit_tips'));
		showformheader($this_page.'&subac=base_indexedit','enctype');
		showtableheader(lang('plugin/yiqixueba','base_base_index_edit'));
		$base_indexid ? showhiddenfields(array('base_indexid'=>$base_indexid)) : '';
		showsetting(lang('plugin/yiqixueba','base_indexname'),'base_index_info[base_indexname]',$base_index_info['base_indexname'],'text','',0,lang('plugin/yiqixueba','base_base_indexname_comment'),'','',true);
		showsubmit('submit');
		showtablefooter();
		showformfooter();
	}else{
		if(!htmlspecialchars(trim($_GET['base_index_info']['base_indexname']))) {
			cpmsg(lang('plugin/yiqixueba','base_base_indexname_nonull'));
		}
		$datas = $_GET['base_index_info'];
		foreach ( $datas as $k=>$v) {
			$data[$k] = htmlspecialchars(trim($v));
			if(!DB::result_first("describe ".DB::table('yiqixueba_base_base_index')." ".$k)) {
				$sql = "alter table ".DB::table('yiqixueba_base_base_index')." add `".$k."` varchar(255) not Null;";
				runquery($sql);
			}
		}
		if($base_indexid) {
			DB::update('yiqixueba_base_base_index',$data,array('base_indexid'=>$base_indexid));
		}else{
			DB::insert('yiqixueba_base_base_index',$data);
		}
		cpmsg(lang('plugin/yiqixueba', 'base_base_index_edit_succeed'), 'action='.$this_page.'&subac=base_indexlist', 'succeed');
	}
}

?>