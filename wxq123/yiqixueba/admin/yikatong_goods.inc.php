<?php

/**
*	一起学吧平台程序
*	文件名：yikatong_goods.inc.php  创建时间：2013-6-15 04:40  杨文
*
*/

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
$this_page = 'plugins&identifier=yiqixueba&pmod=admin&submod=yikatong_goods';

$subac = getgpc('subac');
$subacs = array('goodslist','yktgoodssetting');
$subac = in_array($subac,$subacs) ? $subac : $subacs[0];

//读取一卡通设置参数
$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_setting')." WHERE skey like 'yiqixueba_yikatong%'");
while($row = DB::fetch($query)) {
	$yikatong_setting[$row['skey']] = $row['svalue'];
}

$goods_table = $yikatong_setting['yiqixueba_yikatong_goods_table'];
$shop_table = $yikatong_setting['yiqixueba_yikatong_shop_table'];
$yikatong_fields = dunserialize($yikatong_setting['yiqixueba_yikatong_goodsfields']);
$shop_fields = dunserialize($yikatong_setting['yiqixueba_yikatong_fields']);

//如果商品还没有设置则跳转至设置页面
if(!$goods_table||!$yikatong_fields['shopid']||!$yikatong_fields['goodsname']||!$yikatong_fields['goodsid']) {
	cpmsg(lang('plugin/yiqixueba', 'tablename_set_error'), 'action=plugins&identifier=yiqixueba&pmod=admin&submod=yikatong_setting', 'error');
}
//如果商家还没有设置则跳转至设置页面
if(!$shop_table||!$shop_fields['shopid']||!$shop_fields['shopname']) {
	cpmsg(lang('plugin/yiqixueba', 'tablename_set_error'), 'action=plugins&identifier=yiqixueba&pmod=admin&submod=yikatong_setting', 'error');
}


$goodsid = getgpc('goodsid');
$goods_info = $goodsid ? DB::fetch_first("SELECT * FROM ".DB::table($goods_table)." WHERE ".$yikatong_fields['goodsid']."=".$goodsid) : array();
$yktgoods_setting = $goodsid ? DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_yikatong_goods')." WHERE goodsid = ".$goodsid) : array();

if($subac == 'goodslist') {
	if(!submitcheck('submit')) {
		showtips(lang('plugin/yiqixueba','goods_list_tips'));
		showformheader($this_page.'&subac=goodslist');
		showtableheader('search');
		echo '<tr><td>';
		//搜索用参数
		$shopname = trim(getgpc('shopname'));
		echo lang('plugin/yiqixueba','shopname')."&nbsp;&nbsp;<input size=\"15\" name=\"shopname\" type=\"text\" value=\"$shopname\" />";
		$goodsname = trim(getgpc('goodsname'));
		echo '&nbsp;&nbsp;'.lang('plugin/yiqixueba','goodsname')."&nbsp;&nbsp;<input size=\"15\" name=\"goodsname\" type=\"text\" value=\"$goodsname\" />";
		$tpp = intval(getgpc('tpp')) ? intval(getgpc('tpp')) : '20';
		$tpp_options = "<option value='20' $select[20]>20</option><option value='50' $select[50]>50</option><option value='100' $select[100]>100</option>";
		echo '&nbsp;&nbsp;'.$lang['perpage']."&nbsp;&nbsp;<select name=\"tpp\">$tpp_options</select>";
		$shenhe = trim(getgpc('shenhe'));
		$shenhe_options = "<option value='all' $select[all]>".lang('plugin/yiqixueba','all')."</option><option value='shenheed' $select[shenheed]>".lang('plugin/yiqixueba','shenheed')."</option><option value='noshenhe' $select[noshenhe]>".lang('plugin/yiqixueba','noshenhe')."</option>";
		echo '&nbsp;&nbsp;'.lang('plugin/yiqixueba','shenhe')."&nbsp;&nbsp;<select name=\"shenhe\">$shenhe_options</select>";
		echo "&nbsp;&nbsp;<input class=\"btn\" type=\"submit\" value=\"$lang[search]\" /></td></tr>";
		$get_text = '&tpp='.$tpp.'&shopname='.$shopname.'&shenhe='.$shenhe.'&shopgroup='.$shopgroup;
		showtablefooter();
		showtableheader(lang('plugin/yiqixueba','goods_list'));
		showsubtitle(array('', lang('plugin/yiqixueba','goodsname'),lang('plugin/yiqixueba','shopname'),lang('plugin/yiqixueba','goodspice'),lang('plugin/yiqixueba','xiaofeisetting'), ''));
		$perpage = $tpp;
		$start = ($page - 1) * $perpage;
		$where = "";
		if($shopname) {
			$where .= " and shopname like '%".$shopname."%'";
		}
		//已筛选sql
		if($shenhe == 'shenheed'){
			$where .= " and uid > 0";
		//未筛选sql
		}elseif($shenhe == 'noshenhe'){
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
		$query = DB::query("SELECT * FROM ".DB::table($goods_table)." order by ".$yikatong_fields['goodsid']." desc");
		$k = 1;
		while($row = DB::fetch($query)) {
			$goods_url = str_replace("{goodsid}",intval($row[$yikatong_fields['goodsid']]),$yikatong_setting['yiqixueba_yikatong_goods_url']);
			showtablerow('', array('class="td25"','class="td23"', 'class="td23"', 'class="td23"','class="td29"','class="td25"',''), array(
				$k,
				$goods_url ? '<a href="'.$goods_url.'" target="_blank">'.$row[$yikatong_fields['goodsname']].'</a>'  : $row[$yikatong_fields['goodsname']],
				DB::result_first("SELECT ".$shop_fields['shopname']." FROM ".DB::table($shop_table)." WHERE ".$shop_fields['shopid']."=".$row[$yikatong_fields['shopid']]),
				$row[$yikatong_fields['goodspice']],
				$row['goodsname'],
				"<input class=\"checkbox\" type=\"checkbox\" name=\"statusnew[".$row['goodsid']."]\" value=\"1\" ".($row['status'] > 0 ? 'checked' : '').">",
				"<a href=\"".ADMINSCRIPT."?action=".$this_page."&subac=yktgoodssetting&goodsid=".$row[$yikatong_fields['goodsid']]."\" class=\"act\">".lang('plugin/yiqixueba','shenhe')."</a>",
			));
			$k++;
		}
		showsubmit('submit','submit','');
		showtablefooter();
		showformfooter();
	}else{
	}
}elseif($subac == 'yktgoodssetting') {
	if(!submitcheck('submit')) {
		showtips(lang('plugin/yiqixueba','yktgoodssetting_tips'));
		showformheader($this_page.'&subac=yktgoodssetting','enctype');
		showtableheader(lang('plugin/yiqixueba','yktgoodssetting'));
		$goodsid ? showhiddenfields(array('goodsid'=>$goodsid)) : '';
		showsetting(lang('plugin/yiqixueba','shopname'),'goods_info[shopname]',DB::result_first("SELECT ".$shop_fields['shopname']." FROM ".DB::table($shop_table)." WHERE ".$shop_fields['shopid']."=".$goods_info[$yikatong_fields['shopid']]),'text',1,0,lang('plugin/yiqixueba','yktgoodssetting_shopname_comment'),'','',true);
		echo '<script src="static/js/calendar.js" type="text/javascript"></script>';
		showsetting(lang('plugin/yiqixueba','goodsname'),'goods_info[goodsname]',$goods_info[$yikatong_fields['goodsname']],'text',1,0,lang('plugin/yiqixueba','goodsname_comment'),'','',true);
		showtablefooter();
		showtableheader(lang('plugin/yiqixueba','xiaofeisetting'));
		showsubtitle(array('', lang('plugin/yiqixueba','xiaofeisname'),lang('plugin/yiqixueba','shuaka'),lang('plugin/yiqixueba','goodspice'),lang('plugin/yiqixueba','zhehoupice'),lang('plugin/yiqixueba','yue'),lang('plugin/yiqixueba','jifenpice'),lang('plugin/yiqixueba','shoptojifen'),lang('plugin/yiqixueba','sitetojifen'),lang('plugin/yiqixueba','jici'),lang('plugin/yiqixueba','youxiaoqi'), ''));
		for($i=0;$i<8;$i++){
			var_dump($i);
		}
		showtablerow('', array('class="td25"','class="td23"', 'class="td25"', 'class="td25"','class="td23"','class="td23"',''), array(
			"<input class=\"checkbox\" type=\"checkbox\" name=\"available[]\" value=\"$goodsid\">",
			lang('plugin/yiqixueba','liangka'),
			"<input class=\"checkbox\" type=\"checkbox\" name=\"shuak[]\" value=\"1\" ".($yktgoods_setting['status'] > 0 ? 'checked' : '').">",
			$goods_info[$yikatong_fields['goodspice']],
			'<input type="text" name="" size="2" value="">',
			'<input type="text" name="" size="2" value="">',
			'<input type="text" name="" size="2" value="">',
			'<input type="text" name="" size="2" value="">',
			'<input type="text" name="" size="2" value="">',
			'<input type="text" name="" size="2" value="">',
			'<input type="text" name="" size="12" value="" onclick="showcalendar(event, this)">',
		));
		showtablerow('', array('class="td25"','class="td23"', 'class="td25"', 'class="td25"','class="td23"','class="td23"',''), array(
			"<input class=\"checkbox\" type=\"checkbox\" name=\"available[]\" value=\"$goodsid\">",
			lang('plugin/yiqixueba','xianjin'),
			"<input class=\"checkbox\" type=\"checkbox\" name=\"shuak[]\" value=\"1\" ".($yktgoods_setting['status'] > 0 ? 'checked' : '').">",
			$goods_info[$yikatong_fields['goodspice']],
			'<input type="text" name="" size="2" value="">',
			'<input type="text" name="" size="2" value="">',
			'<input type="text" name="" size="2" value="">',
			'<input type="text" name="" size="2" value="">',
			'<input type="text" name="" size="2" value="">',
			'<input type="text" name="" size="2" value="">',
			'<input type="text" name="" size="12" value="" onclick="showcalendar(event, this)">',
		));
		showtablerow('', array('class="td25"','class="td23"', 'class="td25"', 'class="td25"','class="td23"','class="td23"',''), array(
			"<input class=\"checkbox\" type=\"checkbox\" name=\"available[]\" value=\"$goodsid\">",
			lang('plugin/yiqixueba','kaneiyue'),
			"<input class=\"checkbox\" type=\"checkbox\" name=\"shuak[]\" value=\"1\" ".($yktgoods_setting['status'] > 0 ? 'checked' : '').">",
			$goods_info[$yikatong_fields['goodspice']],
			'<input type="text" name="" size="2" value="">',
			'<input type="text" name="" size="2" value="">',
			'<input type="text" name="" size="2" value="">',
			'<input type="text" name="" size="2" value="">',
			'<input type="text" name="" size="2" value="">',
			'<input type="text" name="" size="2" value="">',
			'<input type="text" name="" size="12" value="" onclick="showcalendar(event, this)">',
		));
		showtablerow('', array('class="td25"','class="td23"', 'class="td25"', 'class="td25"','class="td23"','class="td23"',''), array(
			"<input class=\"checkbox\" type=\"checkbox\" name=\"available[]\" value=\"$goodsid\">",
			lang('plugin/yiqixueba','jifenduihuan'),
			"<input class=\"checkbox\" type=\"checkbox\" name=\"shuak[]\" value=\"1\" ".($yktgoods_setting['status'] > 0 ? 'checked' : '').">",
			$goods_info[$yikatong_fields['goodspice']],
			'<input type="text" name="" size="2" value="">',
			'<input type="text" name="" size="2" value="">',
			'<input type="text" name="" size="2" value="">',
			'<input type="text" name="" size="2" value="">',
			'<input type="text" name="" size="2" value="">',
			'<input type="text" name="" size="2" value="">',
			'<input type="text" name="" size="12" value="" onclick="showcalendar(event, this)">',
		));
		showtablefooter();
		showtableheader();
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
				$sql = "alter table ".DB::table('yiqixueba_yikatong_goods')." add `".$k."` varchar(255) not Null;";
				runquery($sql);
			}
		}
		if($goodsid) {
			DB::update('yiqixueba_yikatong_goods',$data,array('goodsid'=>$goodsid));
		}else{
			DB::insert('yiqixueba_yikatong_goods',$data);
		}
		cpmsg(lang('plugin/yiqixueba', 'goods_edit_succeed'), 'action='.$this_page.'&subac=goodslist', 'succeed');
	}
}

?>