<?php

/**
*	一起学吧平台程序
*	文件名：wxq123_shopadmin.inc.php  创建时间：2013-6-5 00:22  杨文
*
*/

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
$this_page = 'plugins&identifier=yiqixueba&pmod=admin&submod=wxq123_shopadmin';

$subac = getgpc('subac');
$subacs = array('shoplist','shopedit');
$subac = in_array($subac,$subacs) ? $subac : $subacs[0];

//读取一卡通设置参数
$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_setting')." WHERE skey like 'yiqixueba_wxq123%'");
while($row = DB::fetch($query)) {
	$wxq123_setting[$row['skey']] = $row['svalue'];
}
$wxq123_fields = dunserialize($wxq123_setting['yiqixueba_wxq123_fields']);

$shopid = getgpc('shopid');
$shop_info = $shopid ? DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_wxq123_shop')." WHERE shopid=".$shopid) : array();



if($subac == 'shoplist') {
	if(!submitcheck('submit')) {
		showtips(lang('plugin/yiqixueba','shop_list_tips'));
		showformheader($this_page.'&subac=shoplist');
		showtableheader('search');
		echo '<tr><td>';
		//搜索用参数
		$shopname = trim(getgpc('shopname'));
		echo lang('plugin/yiqixueba','shopname')."&nbsp;&nbsp;<input size=\"15\" name=\"shopname\" type=\"text\" value=\"$shopname\" />";
		$tpp = intval(getgpc('tpp')) ? intval(getgpc('tpp')) : '20';
		$tpp_options = "<option value='20' $select[20]>20</option><option value='50' $select[50]>50</option><option value='100' $select[100]>100</option>";
		echo '&nbsp;&nbsp;'.$lang['perpage']."&nbsp;&nbsp;<select name=\"tpp\">$tpp_options</select>";
		$renling = trim(getgpc('renling'));
		$renling_options = "<option value='all' $select[all]>".lang('plugin/yiqixueba','all')."</option><option value='renlinged' $select[renlinged]>".lang('plugin/yiqixueba','renlinged')."</option><option value='norenling' $select[norenling]>".lang('plugin/yiqixueba','norenling')."</option>";
		echo '&nbsp;&nbsp;'.lang('plugin/yiqixueba','renling')."&nbsp;&nbsp;<select name=\"renling\">$renling_options</select>";
		echo "&nbsp;&nbsp;<input class=\"btn\" type=\"submit\" value=\"$lang[search]\" /></td></tr>";
		showtablefooter();
		showtableheader(lang('plugin/yiqixueba','shop_list'));
		showsubtitle(array('', lang('plugin/yiqixueba','field_shopname'),lang('plugin/yiqixueba','field_shopmanage'),lang('plugin/yiqixueba','field_shaixuantime'),lang('plugin/yiqixueba','shoptypename'), ''));
		$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_wxq123_shop')." order by shopid asc");
		while($row = DB::fetch($query)) {
			$shop_url = str_replace("{shopid}",intval($row['oldshopid']),$wxq123_setting['yiqixueba_wxq123_shop_url']);
			showtablerow('', array('class="td25"','class="td29"',''), array(
				"<input class=\"checkbox\" type=\"checkbox\" name=\"delete[]\" value=\"$row[shopid]\">",
				'<a href="'.$shop_url.'" target="_blank">'.$row['shopname'].'</a>',
				$row['uid'] ? '<a href="home.php?mod=space&uid='.intval($row['uid']).'" target="_blank">'.DB::result_first("SELECT username FROM ".DB::table('common_member')." WHERE uid=".intval($row['uid'])).'</a>' : lang('plugin/yiqixueba','norenling'),
				$row['shaixuantime'] ? dgmdate($row['shaixuantime'],'dt') : '',
				$row['shopgroup'],
				"<input class=\"checkbox\" type=\"checkbox\" name=\"statusnew[".$row['brand_shopid']."]\" value=\"1\" ".($row['status'] > 0 ? 'checked' : '').">",
				"<a href=\"".ADMINSCRIPT."?action=".$this_page."&subac=shopedit&shopid=$row[shopid]\" class=\"act\">".lang('plugin/yiqixueba','edit')."</a>",
			));
		}
		showsubmit('submit','submit','del');
		showtablefooter();
		showformfooter();
	}else{
	}
}elseif($subac == 'shopedit') {
	if(!submitcheck('submit')) {
		showtips(lang('plugin/yiqixueba','shop_edit_tips'));
		showformheader($this_page.'&subac=shopedit','enctype');
		showtableheader(lang('plugin/yiqixueba','shop_edit'));
		$shopid ? showhiddenfields(array('shopid'=>$shopid)) : '';
		showsetting(lang('plugin/yiqixueba','shopname'),'shop_info[shopname]',$shop_info['shopname'],'text','',0,lang('plugin/yiqixueba','shopname_comment'),'','',true);
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
			if(!DB::result_first("describe ".DB::table('yiqixueba_wxq123_shop')." ".$k)) {
				$sql = "alter table ".DB::table('yiqixueba_wxq123_shop')." add `".$k."` varchar(255) not Null;";
				runquery($sql);
			}
		}
		if($shopid) {
			DB::update('yiqixueba_wxq123_shop',$data,array('shopid'=>$shopid));
		}else{
			DB::insert('yiqixueba_wxq123_shop',$data);
		}
		cpmsg(lang('plugin/yiqixueba', 'shop_edit_succeed'), 'action='.$this_page.'&subac=shoplist', 'succeed');
	}
}

?>