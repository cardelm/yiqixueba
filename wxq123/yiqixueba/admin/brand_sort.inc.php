<?php

/**
*	一起学吧平台程序
*	文件名：brand_sort.inc.php  创建时间：2013-6-14 16:11  杨文
*
*/

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
$this_page = 'plugins&identifier=yiqixueba&pmod=admin&submod=brand_sort';

$subac = getgpc('subac');
$subacs = array('sortlist','sortedit');
$subac = in_array($subac,$subacs) ? $subac : $subacs[0];

$sortid = getgpc('sortid');
$sort_info = $sortid ? DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_brand_sort')." WHERE sortid=".$sortid) : array();

if($subac == 'sortlist') {
	if(!submitcheck('submit')) {
		showtips(lang('plugin/yiqixueba','sort_list_tips'));
		showformheader($this_page.'&subac=sortlist');
		showtableheader(lang('plugin/yiqixueba','sort_list'));
		showsubtitle(array('', lang('plugin/yiqixueba','sortname'),lang('plugin/yiqixueba','shopnum'),  lang('plugin/yiqixueba','displayorder'), ''));
		$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_brand_sort')." order by sortid asc");
		while($row = DB::fetch($query)) {
			showtablerow('', array('class="td25"','class="td23"', 'class="td23"', 'class="td23"','class="td25"',''), array(
				"<input class=\"checkbox\" type=\"checkbox\" name=\"delete[]\" value=\"$row[sortid]\">",
			str_repeat("--",$row['sortlevel']-1).$row['sortname'],
			str_repeat("--",$row['sortlevel']-1).$row['sorttitle'],
			'<input type="text" class="txt" name="displayordernew['.$row['sortid'].']" value="'.$row['displayorder'].'" size="2" />',
			"<a href=\"".ADMINSCRIPT."?action=".$this_page."&subac=sortedit&sortid=$row[sortid]\" class=\"act\">".lang('plugin/yiqixueba','edit')."</a>",
			));
		}
		echo '<tr><td></td><td colspan="6"><div><a href="'.ADMINSCRIPT.'?action='.$this_page.'&subac=sortedit" class="addtr">'.lang('plugin/yiqixueba','add_sort').'</a></div></td></tr>';
		showsubmit('submit','submit','del');
		showtablefooter();
		showformfooter();
	}else{
		if($idg = $_GET['delete']) {
			$idg = dintval($idg, is_array($idg) ? true : false);
			if($idg) {
				DB::delete('yiqixueba_brand_sort', DB::field('sortid', $idg));
			}
		}
		$displayordernew = $_GET['displayordernew'];
		if(is_array($displayordernew)) {
			foreach ( $displayordernew as $k=>$v) {
				DB::update('yiqixueba_brand_sort',array('displayorder'=>intval($v)),array('sortid'=>$k));
			}
		}
		cpmsg(lang('plugin/yiqixueba_server', 'mokuai_edit_succeed'), 'action='.$this_page.'&subop=sortlist', 'succeed');
	}
}elseif($subac == 'sortedit') {
	if(!submitcheck('submit')) {
		$sortupid_select = '<select name="sortupid"><option value="">'.lang('plugin/yiqixueba','all').'</option>';
		$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_brand_sort')." order by concat(upids,'-',sortid) asc");
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
		$data['upids'] = intval($_GET['sortupid']) ? intval(DB::result_first("SELECT upids FROM ".DB::table('yiqixueba_wxq123_sort')." WHERE sortid=".intval($_GET['sortupid']))).'-'.intval($_GET['sortupid']) : intval($_GET['sortupid']);
		$data['sortlevel'] = $data['sortupid'] ==0 ? 1 : (intval(DB::result_first("SELECT sortlevel FROM ".DB::table('yiqixueba_wxq123_sort')." WHERE sortid=".$data['sortupid']))+1);
		$data['displayorder'] = intval($_GET['displayorder']);
		if($sortid) {
			DB::update('yiqixueba_brand_sort',$data,array('sortid'=>$sortid));
		}else{
			DB::insert('yiqixueba_brand_sort',$data);
		}
		cpmsg(lang('plugin/yiqixueba', 'shopsort_edit_succeed'), 'action='.$this_page.'&subac=sortlist', 'succeed');
	}
}

?>