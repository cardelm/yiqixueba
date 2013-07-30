<?php

/**
*	一起学吧平台程序
*	文件名：wxq_wxqshopadmin.inc.php  创建时间：2013-6-4 09:37  杨文
*
*/

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
$this_page = 'plugins&identifier=yiqixueba&pmod=admin&submod=wxqshopadmin';

$subac = getgpc('subac');
$subacs = array('shoplist','shopedit');
$subac = in_array($subac,$subacs) ? $subac : $subacs[0];

$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_wxq123_setting'));
while($row = DB::fetch($query)) {
	$wxq123_setting[$row['skey']] = $row['svalue'];
}

$shopid = getgpc('shopid');
$shop_info = $shopid ? DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_wxq_shop')." WHERE shopid=".$shopid) : array();

if($subac == 'shoplist') {
	if(!submitcheck('submit')) {
		showtips(lang('plugin/yiqixueba','shop_list_tips'));
		$shopname = trim(getgpc('shopname'));
		$tpp = intval(getgpc('tpp')) ? intval(getgpc('tpp')) : '20';
		$renling = intval(getgpc('renling'));
		$select[$tpp] = $tpp ? "selected='selected'" : '';
		$tpp_options = "<option value='20' $select[20]>20</option><option value='50' $select[50]>50</option><option value='100' $select[100]>100</option>";
		$renlingoptions = '<option value="0" '.(!$renling?' selected':'').'>'.lang('plugin/yiqixueba','all').'</option><option value="1" '.($renling ==1?' selected':'').'>'.lang('plugin/yiqixueba','renling_no').'</option><option value="2" '.($renling ==2?' selected':'').'>'.lang('plugin/yiqixueba','renling_yes').'</option>';
		$get_text = '&tpp='.$tpp.'&shopname='.$shopname.'&renling='.$renling;
		showformheader($this_page.'&subac=shoplist');
		showtableheader('search');
		showtablerow('', array('width="100"', 'width="160"', 'width="60"', 'width="60"'),
			array(
				lang('plugin/yiqixueba','shopname'),
				"<input size=\"15\" name=\"shopname\" type=\"text\" value=\"$shopname\" />",
				$lang['perpage'],
				"<select name=\"tpp\">$tpp_options</select>",
				"<select name=\"renling\">$renlingoptions</select><input class=\"btn\" type=\"submit\" value=\"$lang[search]\" />"
			)
		);

		showtablefooter();
		showformfooter();
		showformheader($this_page.'&subac=shoplist');
		showtableheader(lang('plugin/yiqixueba','shop_list'));
		showsubtitle(array('', lang('plugin/yiqixueba','shopname'),lang('plugin/yiqixueba','shopnum'), lang('plugin/yiqixueba','shopquanxian'), lang('plugin/yiqixueba','pass'),lang('plugin/yiqixueba','nopass'), ''));
		$perpage = $tpp;
		$start = ($page - 1) * $perpage;
		$where = "";
		if($renling) {
			$where1 .= " and stauts = ".$renling;
		}
		if(substr($where1,0,4)==' and') {
			$where1 = substr($where1,4,strlen($where1));
		}
		if($shopname) {
			if($where1) {
				$where .= $where1." and shopname like '%".$shopname."%' or ".$where1." and shopshortname like '%".$shopname."%'";
			}else{
				$where .= " shopname like '%".$shopname."%' or shopshortname like '%".$shopname."%'";
			}
		}else{
			$where .= $where1;
		}
		$where = $where ? (" where ".$where):'';
		$shopcount = DB::result_first("SELECT count(*) FROM ".DB::table('wxq123_shop').$where);
		$multi = multi($shopcount, $perpage, $page, ADMINSCRIPT."?action=".$this_page.$get_text);
		$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_wxq_shop')." order by shopid asc");
		while($row = DB::fetch($query)) {
			showtablerow('', array('class="td25"','class="td28"', 'class="td23"', 'class="td23"','class="td25"','class="td25"',''), array(
				"<input class=\"checkbox\" type=\"checkbox\" name=\"delete[]\" value=\"$row[shopid]\">",
				$row['shopname'],
				$row['shopname'],
				$row['shopname'],
				$new_shop_info['oldshopid'] ? lang('plugin/yiqixueba','pass'): "<input class=\"checkbox\" type=\"checkbox\" name=\"passnew[]\" value=\"".$row[$wxq123_setting['shop_shopid']]."\">",
				$new_shop_info['oldshopid'] ? "<input class=\"checkbox\" type=\"checkbox\" name=\"nopassnew[]\" value=\"".$row[$wxq123_setting['shop_shopid']]."\">" : lang('plugin/yiqixueba','nopass'),
				"<a href=\"".ADMINSCRIPT."?action=".$this_page."&subac=shopedit&shopid=$row[shopid]\" class=\"act\">".lang('plugin/yiqixueba','edit')."</a>",
			));
		}
		showsubmit('submit');
		showtablefooter();
		showformfooter();
	}else{
		$passnew = $_GET['passnew'];
		if(is_array($passnew)) {
			foreach ( $passnew as $k=>$v) {
				if($v && DB::result_first("SELECT count(*) FROM ".DB::table('yiqixueba_wxq_shop')." WHERE oldshopid=".intval($v))==0) {
					DB::insert('yiqixueba_wxq_shop',array('oldshopid'=>$v,'shopname'=>$_GET['shopname'][$k]));
				}
			}
		}
		$nopassnew = $_GET['nopassnew'];
		if(is_array($nopassnew)) {
			foreach ( $nopassnew as $k=>$v) {
				if($v && DB::result_first("SELECT count(*) FROM ".DB::table('yiqixueba_wxq_shop')." WHERE oldshopid=".intval($v))==1) {
					DB::delete('yiqixueba_wxq_shop',array('oldshopid'=>intval($v)));
				}
			}
		}
		cpmsg(lang('plugin/yiqixueba', 'shop_edit_succeed'), 'action='.$this_page.'&subac=shoplist', 'succeed');
	}
}elseif($subac == 'shopedit') {
	if(!submitcheck('submit')) {
		$shopgroup_select = '<select name="shoptype">';
		$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_wxq_shoptype')." WHERE status=1 order by shoptypeid asc");
		while($row = DB::fetch($query)) {
			$shopgroup_select .= '<option value="'.$row['shoptypeid'].'" '.($row['shoptypeid'] == $shop_info['shoptypeid'] ? ' selected' : '').'>'.$row['shoptypename'].'</option>';
		}
		$shopgroup_select .= '</select>';
		showtips(lang('plugin/yiqixueba','shop_edit_tips'));
		showformheader($this_page.'&subac=shopedit','enctype');
		showtableheader(lang('plugin/yiqixueba','shop_edit'));
		$shopid ? showhiddenfields(array('shopid'=>$shopid)) : '';
		showsetting(lang('plugin/yiqixueba','shopname'),'','',$shop_info['shopname'],'',0,lang('plugin/yiqixueba','wxqshopname_comment'),'','',true);
		showsetting(lang('plugin/yiqixueba','shoptypename'),'','',$shopgroup_select,'',0,lang('plugin/yiqixueba','shoptypename_comment'),'','',true);
		showsetting(lang('plugin/yiqixueba','shopsbm'),'shopsbm',$shop_info['shopsbm'],'text','',0,lang('plugin/yiqixueba','shopsbm_comment'),'','',true);
		showsetting(lang('plugin/yiqixueba','shoptoken'),'shoptoken',$shop_info['shoptoken'],'text','',0,lang('plugin/yiqixueba','shoptoken_comment'),'','',true);
		showsetting(lang('plugin/yiqixueba','firsttype'),array('firsttype',array(array('text',lang('plugin/yiqixueba','wxtext')),array('music',lang('plugin/yiqixueba','wxmusic')),array('news',lang('plugin/yiqixueba','wxnews')))),$wxq123_setting['weixinimg'],'select','',0,lang('plugin/yiqixueba','firsttype_comment').$weixinimghtml,'','',true);
		showsubmit('submit');
		showtablefooter();
		showformfooter();
	}else{
		if(!htmlspecialchars(trim($_GET['shop_info']['shopname']))) {
			cpmsg(lang('plugin/yiqixueba','shopname_nonull'));
		}
		$datas = $_GET['shop_info'];
		foreach ( $datas as $k=>$v) {
			$data[$k] = htmlspecialchars(trim($v));
			if(!DB::result_first("describe ".DB::table('yiqixueba_wxq_shop')." ".$k)) {
				$sql = "alter table ".DB::table('yiqixueba_wxq_shop')." add `".$k."` varchar(255) not Null;";
				runquery($sql);
			}
		}
		if($shopid) {
			DB::update('yiqixueba_wxq_shop',$data,array('shopid'=>$shopid));
		}else{
			DB::insert('yiqixueba_wxq_shop',$data);
		}
		cpmsg(lang('plugin/yiqixueba', 'shop_edit_succeed'), 'action='.$this_page.'&subac=shoplist', 'succeed');
	}
}

?>