<?php

/**
*	一起学吧平台程序
*	文件名：goods_goodssort.inc.php  创建时间：2013-7-9 12:24  杨文
*
*/

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
$this_page = 'plugins&identifier=yiqixueba&pmod=admin&submod=goods_goodssort';

$subac = getgpc('subac');
$subacs = array('shopsortlist','shopsortedit');
$subac = in_array($subac,$subacs) ? $subac : $subacs[0];

$shopsortid = getgpc('shopsortid');
$shopsort_info = $shopsortid ? DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_goods_goodssort')." WHERE shopsortid=".$shopsortid) : array();

$upmokuai = intval(getgpc('upmokuai'));
$sortupid = intval(getgpc('sortupid'));

$brand_mokuaiid = DB::result_first("SELECT count(*) FROM ".DB::table('yiqixueba_mokuai')." WHERE mokuainame='brand'");
$mokuai_data = array();
$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_mokuai')."  WHERE upmokuai='brand' order by displayorder asc");
while($row = DB::fetch($query)) {
	$mokuai_data[$row['mokuaiid']] = $row;
}


if($subac == 'shopsortlist') {
	if(!submitcheck('submit')) {

		showtips(lang('plugin/yiqixueba','shopsort_list_tips'));
		showformheader($this_page.'&subac=shopsortlist');
		showtableheader();

		//////搜索内容
		echo '<tr><td>';
		//分类选择
		$sortupid_select = '<select name="sortupid"><option value="0">顶级</option>';
		//$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_goods_goodssort')." where sortupid = ".$sortupid." order by concat(upids,'-',shopsortid) asc");
		$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_goods_goodssort')." order by concat(upids,'-',shopsortid) asc");
		while($row = DB::fetch($query)) {
			$sortupid_select .= '<option value="'.$row['shopsortid'].'" '.($sortupid == $row['shopsortid'] ? ' selected' :'').'>'.str_repeat("--",$row['sortlevel']-1).$row['sorttitle'].'</option>';
		}
		$sortupid_select .= '</select>';
		echo '&nbsp;&nbsp;选择上级分类&nbsp;&nbsp;'.$sortupid_select;
		echo "&nbsp;&nbsp;<input class=\"btn\" type=\"submit\" value=\"$lang[search]\" /></td></tr>";
		//////搜索内容
		showtablefooter();
		showtableheader(lang('plugin/yiqixueba','shopsort_list'));
		showsubtitle(array('', lang('plugin/yiqixueba','shopsortname'),lang('plugin/yiqixueba','shopsorttitle'), lang('plugin/yiqixueba','displayorder'), ''));

		$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_goods_goodssort')." where sortupid = ".$sortupid." order by displayorder asc");
		while($row = DB::fetch($query)) {
			showtablerow('', array('class="td25"','class="td23"', 'class="td23"', 'class="td25"',''), array(
				"<input class=\"checkbox\" type=\"checkbox\" name=\"delete[]\" value=\"$row[shopsortid]\">",
				str_repeat("--",$row['sortlevel']-1).$row['sortname'],
				str_repeat("--",$row['sortlevel']-1).$row['sorttitle'],
				'<input type="text" class="txt" name="displayordernew['.$row['shopsortid'].']" value="'.$row['displayorder'].'" size="2" />',
				"<a href=\"".ADMINSCRIPT."?action=".$this_page."&subac=shopsortedit&shopsortid=$row[shopsortid]\" class=\"act\">".lang('plugin/yiqixueba','edit')."</a>",
		));
		}
		echo '<tr><td></td><td colspan="6"><div><a href="'.ADMINSCRIPT.'?action='.$this_page.'&subac=shopsortedit&upmokuai='.$upmokuai.'&sortupid='.$sortupid.'" class="addtr">'.lang('plugin/yiqixueba','add_shopsort').'</a></div></td></tr>';
		showsubmit('submit','submit','del');
		showtablefooter();
		showformfooter();
	}else{
		if($idg = $_GET['delete']) {
			$idg = dintval($idg, is_array($idg) ? true : false);
			if($idg) {
				DB::delete('yiqixueba_goods_goodssort', DB::field('shopsortid', $idg));
			}
		}
		$displayordernew = $_GET['displayordernew'];
		if(is_array($displayordernew)) {
			foreach ( $displayordernew as $k=>$v) {
				DB::update('yiqixueba_goods_goodssort',array('displayorder'=>intval($v)),array('shopsortid'=>$k));
			}
		}
		cpmsg(lang('plugin/yiqixueba_server', 'sort_edit_succeed'), 'action='.$this_page.'&subop=shopsortlist&upmokuai='.$upmokuai.'&sortupid='.$sortupid, 'succeed');
	}
}elseif($subac == 'shopsortedit') {
	if(!submitcheck('submit')) {
		$upmokuai = $shopsort_info['upmokuai'] ? $shopsort_info['upmokuai'] : $upmokuai;
		$sortupid = $shopsort_info['sortupid'] ? $shopsort_info['sortupid'] : $sortupid;
		$sortupid_select = '<select name="sortupid"><option value="0">顶级</option>';
		$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_goods_goodssort')." order by concat(upids,'-',shopsortid) asc");
		while($row = DB::fetch($query)) {
			$sortupid_select .= '<option value="'.$row['shopsortid'].'" '.($shopsort_info['sortupid'] == $row['shopsortid'] ? ' selected' :'').'>'.str_repeat("--",$row['sortlevel']-1).$row['sorttitle'].'</option>';
		}
		$sortupid_select .= '</select>';


		showtips(lang('plugin/yiqixueba','shopsort_edit_tips'));
		showformheader($this_page.'&subac=shopsortedit','enctype');
		showtableheader(lang('plugin/yiqixueba','shopsort_edit'));
		$shopsortid ? showhiddenfields(array('shopsortid'=>$shopsortid)) : '';
		$upmokuai ? showhiddenfields(array('upmokuai'=>$upmokuai)) : '';
		$sortupid ? showhiddenfields(array('sortupid'=>$sortupid)) : '';
		showsetting(lang('plugin/yiqixueba','sortupid'),'','',$sortupid_select,'',0,lang('plugin/yiqixueba','sortupid_comment'),'','',true);
		showsetting(lang('plugin/yiqixueba','shopsortname'),'shopsortname',$shopsort_info['sortname'],'text','',0,lang('plugin/yiqixueba','shopsortname_comment'),'','',true);
		showsetting(lang('plugin/yiqixueba','shopsorttitle'),'shopsorttitle',$shopsort_info['sorttitle'],'text','',0,lang('plugin/yiqixueba','shopsorttitle_comment'),'','',true);
		//showsetting(lang('plugin/yiqixueba','displayorder'),'displayorder',$shopsort_info['displayorder'],'text','',0,lang('plugin/yiqixueba','displayorder_comment'),'','',true);
		showsubmit('submit');
		showtablefooter();
		showformfooter();
	}else{
		if(!htmlspecialchars(trim($_GET['shopsortname']))) {
			cpmsg(lang('plugin/yiqixueba','shopsortname_nonull'));
		}
		$data = array();
		$data['sortname'] = htmlspecialchars(trim($_GET['shopsortname']));
		$data['sorttitle'] = htmlspecialchars(trim($_GET['shopsorttitle']));
		$data['sortupid'] = intval($_GET['sortupid']);

		$data['upids'] = intval($_GET['sortupid']) ? trim(DB::result_first("SELECT upids FROM ".DB::table('yiqixueba_goods_goodssort')." WHERE shopsortid=".intval($_GET['sortupid']))).'-'.intval($_GET['sortupid']) : intval($_GET['sortupid']);


		$data['sortlevel'] = $data['sortupid'] ==0 ? 1 : (intval(DB::result_first("SELECT sortlevel FROM ".DB::table('yiqixueba_goods_goodssort')." WHERE shopsortid=".$data['sortupid']))+1);
		$data['displayorder'] = htmlspecialchars(trim($_GET['displayorder']));

		if($shopsortid) {
			DB::update('yiqixueba_goods_goodssort',$data,array('shopsortid'=>$shopsortid));
		}else{
			DB::insert('yiqixueba_goods_goodssort',$data);
		}
		cpmsg(lang('plugin/yiqixueba', 'shopsort_edit_succeed'), 'action='.$this_page.'&subac=shopsortlist', 'succeed');
	}
}



?>