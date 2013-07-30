<?php

/**
*	一起学吧平台程序
*	文件名：yikatong_sort.inc.php  创建时间：2013-6-14 12:34  杨文
*
*/

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
$this_page = 'plugins&identifier=yiqixueba&pmod=admin&submod=yikatong_sort';

$subac = getgpc('subac');
$subacs = array('sortlist','sortedit');
$subac = in_array($subac,$subacs) ? $subac : $subacs[0];

$sortid = getgpc('sortid');
$sort_info = $sortid ? DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_yikatong_sort')." WHERE sortid=".$sortid) : array();

$mokuaiid = $sortid ? $sort_info['mokuaiid'] :intval(getgpc('mokuaiid'));

$mokuai_data = array();
$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_mokuai')."  WHERE upmokuai='yikatong' order by displayorder asc");
while($row = DB::fetch($query)) {
	$mokuai_data[$row['mokuaiid']] = $row;
}

if($subac == 'sortlist') {
	if(!submitcheck('submit')) {
		showtips(lang('plugin/yiqixueba','yikatong_sort_list_tips'));
		showformheader($this_page.'&subac=sortlist');
		showtableheader();
		//////搜索内容
		echo '<tr><td>';
		//模块选择
		$mokuaiid_select = '<select name="mokuaiid"><option value="">'.lang('plugin/yiqixueba','all').'</option>';
		foreach ($mokuai_data as $row){
			$mokuaiid_select .= '<option value="'.$row['mokuaiid'].'" '.($mokuaiid == $row['mokuaiid'] ? ' selected' : '').'>'.$row['mokuaititle'].'</option>';
		}
		$mokuaiid_select .= '</select>';
		echo '&nbsp;&nbsp;'.lang('plugin/yiqixueba','upmokuai').'&nbsp;&nbsp;'.$mokuaiid_select;
		//每页显示条数
		echo "&nbsp;&nbsp;<input class=\"btn\" type=\"submit\" value=\"$lang[search]\" /></td></tr>";
		//////搜索内容
		showtablefooter();
		if($mokuaiid){
			showtableheader(lang('plugin/yiqixueba','yikatong_sort_list'));
			showsubtitle(array('', lang('plugin/yiqixueba','sortname'),lang('plugin/yiqixueba','shopnum'), lang('plugin/yiqixueba','sortquanxian'), lang('plugin/yiqixueba','status'), ''));
			$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_yikatong_sort')." WHERE mokuaiid=".$mokuaiid." order by concat(upids,'-',sortid) asc");
			while($row = DB::fetch($query)) {
				showtablerow('', array('class="td25"','class="td23"', 'class="td23"', 'class="td23"','class="td25"',''), array(
					"<input class=\"checkbox\" type=\"checkbox\" name=\"delete[]\" value=\"$row[sortid]\">",
				str_repeat("--",$row['sortlevel']-1).$row['sortname'],
				str_repeat("--",$row['sortlevel']-1).$row['sorttitle'],
				$row['sortname'],
				'<input type="text" class="txt" name="displayordernew['.$row['sortid'].']" value="'.$row['displayorder'].'" size="2" />',
					"<a href=\"".ADMINSCRIPT."?action=".$this_page."&subac=sortedit&sortid=$row[sortid]\" class=\"act\">".lang('plugin/yiqixueba','edit')."</a>",
				));
			}
			echo '<tr><td></td><td colspan="6"><div><a href="'.ADMINSCRIPT.'?action='.$this_page.'&subac=sortedit&mokuaiid='.$mokuaiid.'" class="addtr">'.lang('plugin/yiqixueba','add_sort').'</a></div></td></tr>';
			showsubmit('submit','submit','del');
			showtablefooter();
		}
		showformfooter();
	}else{
		if($idg = $_GET['delete']) {
			$idg = dintval($idg, is_array($idg) ? true : false);
			if($idg) {
				DB::delete('yiqixueba_yikatong_sort', DB::field('sortid', $idg));
			}
		}
		$displayordernew = $_GET['displayordernew'];
		if(is_array($displayordernew)) {
			foreach ( $displayordernew as $k=>$v) {
				DB::update('yiqixueba_yikatong_sort',array('displayorder'=>intval($v)),array('sortid'=>$k));
			}
		}
		cpmsg(lang('plugin/yiqixueba_server', 'mokuai_edit_succeed'), 'action='.$this_page.'&subop=sortlist&upmokuai='.$upmokuai, 'succeed');
	}
}elseif($subac == 'sortedit') {
	if(!submitcheck('submit')) {
		$sortupid_select = '<select name="sortupid"><option value="">'.lang('plugin/yiqixueba','all').'</option>';
		$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_yikatong_sort')." order by concat(upids,'-',sortid) asc");
		while($row = DB::fetch($query)) {
			$sortupid_select .= '<option value="'.$row['sortid'].'" '.($sort_info['sortupid'] == $row['sortid'] ? ' selected' : '').'>'.str_repeat("--",$row['sortlevel']-1).$row['sorttitle'].'</option>';
		}
		$sortupid_select .= '</select>';
		showtips(lang('plugin/yiqixueba','sort_edit_tips'));
		showformheader($this_page.'&subac=sortedit');
		showtableheader(lang('plugin/yiqixueba','sort_edit'));
		$mokuaiid ? showhiddenfields(array('mokuaiid'=>$mokuaiid)) : '';
		$sortid ? showhiddenfields(array('sortid'=>$sortid)) : '';
		showsetting(lang('plugin/yiqixueba','sortupid'),'','',$sortupid_select,'',0,lang('plugin/yiqixueba','sortupid_comment'),'','',true);
		showsetting(lang('plugin/yiqixueba','sortname'),'sortname',$sort_info['sortname'],'text','',0,lang('plugin/yiqixueba','sortname_comment'),'','',true);
		showsetting(lang('plugin/yiqixueba','sorttitle'),'sorttitle',$sort_info['sorttitle'],'text','',0,lang('plugin/yiqixueba','sorttitle_comment'),'','',true);
		showsubmit('submit');
		showtablefooter();
		showformfooter();
	}else{
		if(!htmlspecialchars(trim($_GET['sortname']))) {
			cpmsg(lang('plugin/yiqixueba','sortname_nonull'));
		}
		$data = array();
		$data['mokuaiid'] = intval($_GET['mokuaiid']);
		$data['sortname'] = htmlspecialchars(trim($_GET['sortname']));
		$data['sorttitle'] = htmlspecialchars(trim($_GET['sorttitle']));
		$data['sortupid'] = intval($_GET['sortupid']);
		$data['upids'] = intval($_GET['sortupid']) ? intval(DB::result_first("SELECT upids FROM ".DB::table('yiqixueba_yikatong_sort')." WHERE sortid=".intval($_GET['sortupid']))).'-'.intval($_GET['sortupid']) : intval($_GET['sortupid']);
		$data['sortlevel'] = $data['sortupid'] ==0 ? 1 : (intval(DB::result_first("SELECT sortlevel FROM ".DB::table('yiqixueba_yikatong_sort')." WHERE sortid=".$data['sortupid']))+1);
		$data['displayorder'] = htmlspecialchars(trim($_GET['displayorder']));
		if($sortid) {
			DB::update('yiqixueba_yikatong_sort',$data,array('sortid'=>$sortid));
		}else{
			DB::insert('yiqixueba_yikatong_sort',$data);
		}
		cpmsg(lang('plugin/yiqixueba', 'shopsort_edit_succeed'), 'action='.$this_page.'&subac=sortlist&mokuaiid='.$mokuaiid, 'succeed');
	}
}

?>