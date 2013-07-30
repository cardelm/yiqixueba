<?php

/**
*	一起学吧平台程序
*	文件名：shop_goods.inc.php  创建时间：2013-6-4 09:37  杨文
*
*/

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
$this_page = 'plugins&identifier=yiqixueba&pmod=admin&submod=goods';

$subac = getgpc('subac');
$subacs = array('goodslist','goodsedit');
$subac = in_array($subac,$subacs) ? $subac : $subacs[0];

$goodsid = getgpc('goodsid');
$goods_info = $goodsid ? DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_goods')." WHERE goodsid=".$goodsid) : array();

if($subac == 'goodslist') {
	if(!submitcheck('submit')) {
		showtips(lang('plugin/yiqixueba','goods_list_tips'));
		showformheader($this_page.'&subac=goodslist');
		showtableheader(lang('plugin/yiqixueba','goods_list'));
		showsubtitle(array('', lang('plugin/yiqixueba','goodsname'),lang('plugin/yiqixueba','shopnum'), lang('plugin/yiqixueba','goodsquanxian'), lang('plugin/yiqixueba','status'), ''));
		//$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_goods')." order by goodsid asc");
		//while($row = DB::fetch($query)) {
			showtablerow('', array('class="td25"','class="td23"', 'class="td23"', 'class="td23"','class="td25"',''), array(
				"<input class=\"checkbox\" type=\"checkbox\" name=\"delete[]\" value=\"$row[goodsid]\">",
			$row['goodsname'],
			$row['goodsname'],
			$row['goodsname'],
			"<input class=\"checkbox\" type=\"checkbox\" name=\"statusnew[".$row['goodsid']."]\" value=\"1\" ".($row['status'] > 0 ? 'checked' : '').">",
				"<a href=\"".ADMINSCRIPT."?action=".$this_page."&subac=goodsedit&goodsid=$row[goodsid]\" class=\"act\">".lang('plugin/yiqixueba','edit')."</a>",
			));
		//}
		echo '<tr><td></td><td colspan="6"><div><a href="'.ADMINSCRIPT.'?action='.$this_page.'&subac=goodsedit" class="addtr">'.lang('plugin/yiqixueba','add_goods').'</a></div></td></tr>';
		showsubmit('submit','submit','del');
		showtablefooter();
		showformfooter();
	}else{
	}
}elseif($subac == 'goodsedit') {
	if(!submitcheck('submit')) {
		showtips(lang('plugin/yiqixueba','goods_edit_tips'));
		showformheader($this_page.'&subac=goodsedit','enctype');
		showtableheader(lang('plugin/yiqixueba','goods_edit'));
		$goodsid ? showhiddenfields(array('goodsid'=>$goodsid)) : '';
		showsetting(lang('plugin/yiqixueba','goodsname'),'goods_info[goodsname]',$goods_info['goodsname'],'text','',0,lang('plugin/yiqixueba','goodsname_comment'),'','',true);
		showsubmit('submit');
		showtablefooter();
		showformfooter();
	}else{
		if(!htmlspecialchars(trim($_GET['goods_info']['goodsname']))) {
			cpmsg(lang('plugin/yiqixueba','goodsname_nonull'));
		}
		$datas = $_GET['goods_info'];
		foreach ( $datas as $k=>$v) {
			$data[$k] = htmlspecialchars(trim($v));
			if(!DB::result_first("describe ".DB::table('yiqixueba_goods')." ".$k)) {
				$sql = "alter table ".DB::table('yiqixueba_goods')." add `".$k."` varchar(255) not Null;";
				runquery($sql);
			}
		}
		if($goodsid) {
			DB::update('yiqixueba_goods',$data,array('goodsid'=>$goodsid));
		}else{
			DB::insert('yiqixueba_goods',$data);
		}
		cpmsg(lang('plugin/yiqixueba', 'goods_edit_succeed'), 'action='.$this_page.'&subac=goodslist', 'succeed');
	}
}

?>