<?php

/**
*	一起学吧平台程序
*	文件名：yikatong_shopadmin.inc.php  创建时间：2013-6-5 00:22  杨文
*
*/

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
$this_page = 'plugins&identifier=yiqixueba&pmod=admin&submod=yikatong_shopadmin';

$subac = getgpc('subac');
$subacs = array('shoplist','shopedit');
$subac = in_array($subac,$subacs) ? $subac : $subacs[0];

//读取一卡通设置参数
$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_setting')." WHERE skey like 'yiqixueba_yikatong%'");
while($row = DB::fetch($query)) {
	$yikatong_setting[$row['skey']] = $row['svalue'];
}
$yikatong_fields = dunserialize($yikatong_setting['yiqixueba_yikatong_fields']);

$shopid = getgpc('shopid');
$shop_info = $shopid ? DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_yikatong_shop')." WHERE shopid=".$shopid) : array();

$shopgroup = intval(getgpc('shopgroup'));
$shopgroup = $shopid ? $shop_info['shopgroup'] : $shopgroup;

$shopgroup_array = array();
$shopgroup_option = '';
$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_yikatong_shoptype')." WHERE status = 1 order by shoptypeid asc");
while($row = DB::fetch($query)) {
	$shopgroup_option .= '<option value="'.$row['shoptypeid'].'" '.($shopgroup == $row['shoptypeid'] ? ' selected':'').'>'.$row['shoptypename'].'</option>';
	$shopgroup_array[$row['shoptypeid']] = $row;
}

update_shopinfo('yikatong');

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
		echo '&nbsp;&nbsp;'.lang('plugin/yiqixueba','shopgroup')."&nbsp;&nbsp;<select name=\"shopgroup\"><option value='all' $select[all]>".lang('plugin/yiqixueba','all')."</option>$shopgroup_option</select>";
		echo "&nbsp;&nbsp;<input class=\"btn\" type=\"submit\" value=\"$lang[search]\" /></td></tr>";
		$get_text = '&tpp='.$tpp.'&shopname='.$shopname.'&renling='.$renling.'&shopgroup='.$shopgroup;
		showtablefooter();
		showtableheader(lang('plugin/yiqixueba','shop_list'));
		showsubtitle(array('', lang('plugin/yiqixueba','field_shopname'),lang('plugin/yiqixueba','field_shopmanage'),lang('plugin/yiqixueba','field_shaixuantime'),lang('plugin/yiqixueba','shoptypename'),lang('plugin/yiqixueba','member_info'), ''));
		$perpage = $tpp;
		$start = ($page - 1) * $perpage;
		$where = "";
		if($shopname) {
			$where .= " and shopname like '%".$shopname."%'";
		}
		//已筛选sql
		if($renling == 'renlinged'){
			$where .= " and uid > 0";
		//未筛选sql
		}elseif($renling == 'norenling'){
			$where .= " and uid = 0";
		}
		if($shopgroup) {
			$where .= " and shopgroup = ".$shopgroup;
		}
		if($where) {
			$where = " where ".substr($where,4,strlen($where)-4);
		}

		$shopcount = DB::result_first("SELECT count(*) FROM ".DB::table('yiqixueba_yikatong_shop').$where);
		$multi = multi($shopcount, $perpage, $page, ADMINSCRIPT."?action=".$this_page.$get_text);
		$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_yikatong_shop').$where." order by shopid asc limit ".$start.", ".$perpage);
		while($row = DB::fetch($query)) {
			$shop_url = str_replace("{shopid}",intval($row['oldshopid']),$yikatong_setting['yiqixueba_yikatong_shop_url']);
			$member_znum = DB::result_first("SELECT count(*) FROM ".DB::table('yiqixueba_yikatong_card')." WHERE fafanguid=".$row['uid']);
			$member_fnum = DB::result_first("SELECT count(*) FROM ".DB::table('yiqixueba_yikatong_card')." WHERE fafanguid=".$row['uid']." and uid >0");
			showtablerow('', array('class="td25"','class="td29"',''), array(
				"<input class=\"checkbox\" type=\"checkbox\" name=\"delete[]\" value=\"$row[shopid]\">",
				'<a href="'.$shop_url.'" target="_blank">'.$row['shopname'].'</a>',
				$row['uid'] ? '<a href="home.php?mod=space&uid='.intval($row['uid']).'" target="_blank">'.DB::result_first("SELECT username FROM ".DB::table('common_member')." WHERE uid=".intval($row['uid'])).'</a>' : lang('plugin/yiqixueba','norenling'),
				$row['shaixuantime'] ? dgmdate($row['shaixuantime'],'dt') : '',
				$shopgroup_array[$row['shopgroup']]['shoptypename'],
				$member_fnum.'/'.$member_znum,
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
		showsetting(lang('plugin/yiqixueba','shopname'),'shop_info[shopname]',$shop_info['shopname'],'text',1,0,lang('plugin/yiqixueba','shopname_comment'),'','',true);
		showsetting(lang('plugin/yiqixueba','shopgroup'),'','','<select name="shop_info[shopgroup]">'.$shopgroup_option.'</select>','',0,lang('plugin/yiqixueba','shoptype_comment'),'','',true);
		showsetting(lang('plugin/yiqixueba','isfendian'),'shop_info[fendian]',$shop_info['fendian'],'radio','',0,lang('plugin/yiqixueba','isfendian_comment'),'','',true);
		showsubmit('submit');
		showtablefooter();
		showformfooter();
	}else{
		$data = array();
		$datas = $_GET['shop_info'];
		foreach ( $datas as $k=>$v) {
			$data[$k] = htmlspecialchars(trim($v));
			if(!DB::result_first("describe ".DB::table('yiqixueba_yikatong_shop')." ".$k)) {
				$sql = "alter table ".DB::table('yiqixueba_yikatong_shop')." add `".$k."` varchar(255) not Null;";
				runquery($sql);
			}
		}
		if($shopid) {
			DB::update('yiqixueba_yikatong_shop',$data,array('shopid'=>$shopid));
		}
		cpmsg(lang('plugin/yiqixueba', 'shop_edit_succeed'), 'action='.$this_page.'&subac=shoplist', 'succeed');
	}
}

?>