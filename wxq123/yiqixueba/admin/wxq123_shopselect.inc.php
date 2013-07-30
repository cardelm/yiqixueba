<?php

/**
*	һ��ѧ��ƽ̨����
*	�ļ�����wxq123_shopselect.inc.php  ����ʱ�䣺2013-6-5 00:14  ����
*
*/
//�̼�ɸѡҳ��
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
$this_page = 'plugins&identifier=yiqixueba&pmod=admin&submod=wxq123_shopselect';

$subac = getgpc('subac');
$subacs = array('shopselect');
$subac = in_array($subac,$subacs) ? $subac : $subacs[0];

//��ȡһ��ͨ���ò���
$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_setting')." WHERE skey like 'yiqixueba_wxq123%'");
while($row = DB::fetch($query)) {
	$wxq123_setting[$row['skey']] = $row['svalue'];
}

$shop_table = $wxq123_setting['yiqixueba_wxq123_shop_table'];
$wxq123_fields = dunserialize($wxq123_setting['yiqixueba_wxq123_fields']);

//�����û����������ת������ҳ��
if(!$shop_table||!$wxq123_fields['shopid']||!$wxq123_fields['shopname']) {
	cpmsg(lang('plugin/yiqixueba', 'tablename_set_error'), 'action=plugins&identifier=yiqixueba&pmod=admin&submod=wxq123_setting', 'error');
}


if($subac == 'shopselect') {
	if(!submitcheck('submit')) {
		showtips(lang('plugin/yiqixueba','shop_select_tips'));
		showformheader($this_page.'&subac=shopselect');
		//�����ò���
		$shopname = trim(getgpc('shopname'));
		$tpp = intval(getgpc('tpp')) ? intval(getgpc('tpp')) : '20';
		//$renling = trim(getgpc('renling'));
		$shaixuan = trim(getgpc('shaixuan'));
		$select[$tpp] = $tpp ? "selected='selected'" : '';
		$select[$renling] = $renling ? "selected='selected'" : '';
		$select[$shaixuan] = $shaixuan ? "selected='selected'" : '';
		$tpp_options = "<option value='20' $select[20]>20</option><option value='50' $select[50]>50</option><option value='100' $select[100]>100</option>";
		//$renling_options = "<option value='all' $select[all]>".lang('plugin/yiqixueba','all')."</option><option value='renlinged' $select[renlinged]>".lang('plugin/yiqixueba','renlinged')."</option><option value='norenling' $select[norenling]>".lang('plugin/yiqixueba','norenling')."</option>";
		$shaixuan_options = "<option value='all' $select[all]>".lang('plugin/yiqixueba','all')."</option><option value='shaixuaned' $select[shaixuaned]>".lang('plugin/yiqixueba','shaixuaned')."</option><option value='noshaixuan' $select[noshaixuan]>".lang('plugin/yiqixueba','noshaixuan')."</option>";
		$get_text = '&tpp='.$tpp.'&shopname='.$shopname.'&shaixuan='.$shaixuan;
		showtableheader('search');
		echo '<tr><td>';
		echo lang('plugin/yiqixueba','shopname')."&nbsp;&nbsp;<input size=\"15\" name=\"shopname\" type=\"text\" value=\"$shopname\" />";
		echo '&nbsp;&nbsp;'.$lang['perpage']."&nbsp;&nbsp;<select name=\"tpp\">$tpp_options</select>";
		//echo '&nbsp;&nbsp;'.lang('plugin/yiqixueba','renling')."&nbsp;&nbsp;<select name=\"renling\">$renling_options</select>";
		echo '&nbsp;&nbsp;'.lang('plugin/yiqixueba','shaixuan')."&nbsp;&nbsp;<select name=\"shaixuan\">$shaixuan_options</select>";
		echo "&nbsp;&nbsp;<input class=\"btn\" type=\"submit\" value=\"$lang[search]\" /></td></tr>";
		showtablefooter();
		showtableheader(lang('plugin/yiqixueba','shop_select'));
		//���������Ҫ�������е�������ͬ������ɸѡ��ʱ���б������ʾ
		$subtitle = array();
		$subtitle[] = '';
		foreach ($wxq123_fields as $k=>$v){
			$subtitle[] = lang('plugin/yiqixueba','field_'.$v);
		}
		$subtitle[] = lang('plugin/yiqixueba','pass');
		$subtitle[] = lang('plugin/yiqixueba','nopass');
		
		//showsubtitle(array('', lang('plugin/yiqixueba','shopname'), lang('plugin/yiqixueba','pass'),lang('plugin/yiqixueba','nopass'), ''));
		showsubtitle($subtitle);
		$perpage = $tpp;
		$start = ($page - 1) * $perpage;
		$where = "";
		if($shopname) {
			$where .= " and ".$wxq123_fields['shopname']." like '%".$shopname."%'";
		}
		//��ɸѡsql
		if($shaixuan == 'shaixuaned'){
			$new_shopid_array = array();
			$new_shopid_array[] = 0;
			$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_wxq123_shop'));
			while($row = DB::fetch($query)) {
				$new_shopid_array[] = $row['oldshopid'];
			}
			$where .= " and ".$wxq123_fields['shopid']." IN (".implode(",",$new_shopid_array).')';
		//δɸѡsql
		}elseif($shaixuan == 'noshaixuan'){
			$new_shopid_array = array();
			$new_shopid_array[] = 0;
			$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_wxq123_shop'));
			while($row = DB::fetch($query)) {
				$new_shopid_array[] = $row['oldshopid'];
			}
			$where .= " and ".$wxq123_fields['shopid']." NOT IN (".implode(",",$new_shopid_array).')';
		}
		if($where) {
			$where = " where ".substr($where,4,strlen($where)-4);
		}

		$shopcount = DB::result_first("SELECT count(*) FROM ".DB::table($shop_table).$where);
		$multi = multi($shopcount, $perpage, $page, ADMINSCRIPT."?action=".$this_page.$get_text);
		$query = DB::query("SELECT * FROM ".DB::table($shop_table).$where." order by ".$wxq123_fields['shopid']." asc limit ".$start.", ".$perpage);
		
		while($row = DB::fetch($query)) {
			$new_shop_info = DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_wxq123_shop')." WHERE oldshopid = ".intval($row[$wxq123_fields['shopid']]));
			$oldshopname = $new_shop_info['shopname'] ? $new_shop_info['shopname'] : $row[$wxq123_fields['shopname']];

			$shop_url = str_replace("{shopid}",intval($row[$wxq123_fields['shopid']]),$wxq123_setting['yiqixueba_wxq123_shop_url']);

			//��ȡԭ���ı���ֶ�
			$tablerow_old = array();
			$tablerow_old[] = '';
			foreach ($wxq123_fields as $k=>$v){
				if($v == 'shopname'){
					$tablerow_old[] = '<a href="'.$shop_url.'" target="_blank">'.$row[$v].'</a>';
				}else{
					$tablerow_old[] = $row[$v];
				}
			}
			$tablerow_old[] = $new_shop_info['oldshopid'] ? lang('plugin/yiqixueba','pass'): "<input class=\"checkbox\" type=\"checkbox\" name=\"passnew[]\" value=\"".$row[$wxq123_fields['shopid']]."\">";
			$tablerow_old[] = $new_shop_info['oldshopid'] ? "<input class=\"checkbox\" type=\"checkbox\" name=\"nopassnew[]\" value=\"".$row[$wxq123_fields['shopid']]."\">" : lang('plugin/yiqixueba','nopass');


			showtablerow('', array('class="td25"','class="td29"',''), $tablerow_old);
		}
		showsubmit('submit','submit','','',$multi);
		showtablefooter();
		showformfooter();
	}else{
		//ͨ������
		$passnew = $_GET['passnew'];
		if(is_array($passnew)) {
			foreach ( $passnew as $k=>$v) {
				if($v && DB::result_first("SELECT count(*) FROM ".DB::table('yiqixueba_wxq123_shop')." WHERE oldshopid=".intval($v))==0) {
					$old_data = DB::fetch_first("SELECT * FROM ".DB::table($shop_table)." WHERE ".$wxq123_fields['shopid']."=".intval($v));
					$insert_data = array();
					foreach ($wxq123_fields as $kk=>$vv){
						if($kk=='shopid'){
							$insert_data['oldshopid'] = $old_data[$vv];
						}elseif($kk=='shopmanage'){
							$insert_data['uid'] = $old_data[$vv];
						}else{
							$insert_data[$kk] = $old_data[$vv];
						}
					}
					$insert_data['shaixuantime'] = time();
					DB::insert('yiqixueba_wxq123_shop',$insert_data);
				}
			}
		}
		//��ͨ������
		$nopassnew = $_GET['nopassnew'];
		if(is_array($nopassnew)) {
			foreach ( $nopassnew as $k=>$v) {
				if($v && DB::result_first("SELECT count(*) FROM ".DB::table('yiqixueba_wxq123_shop')." WHERE oldshopid=".intval($v))==1) {
					//DB::update('yiqixueba_wxq123_shop', array('oldshopid'=>0),array('oldshopid'=>intval($v)));
					DB::delete('yiqixueba_wxq123_shop',array('oldshopid'=>intval($v)));
				}
			}
		}
		cpmsg(lang('plugin/yiqixueba', 'shop_edit_succeed'), 'action='.$this_page.'&subac=shopselect', 'succeed');
	}
}

?>