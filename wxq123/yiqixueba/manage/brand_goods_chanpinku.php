<?php

/**
*	һ��ѧ��ƽ̨����
*	�ļ�����brand_chanpinku.php  ����ʱ�䣺2013-6-25 11:39  ����
*
*/

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$this_page = 'plugin.php?id=yiqixueba:manage&man=brand&subman=goods&goodstype=chanpinku';

$type = trim(getgpc('type'));

if(!$type){
	$chanpinku_list = array();
	//ÿҳ��ʾ����
	$tpp = intval(getgpc('tpp')) ? intval(getgpc('tpp')) : '20';
	$select[$tpp] = $tpp ? "selected='selected'" : '';
	$tpp_options = "<option value='20' $select[20]>20</option><option value='50' $select[50]>50</option><option value='100' $select[100]>100</option>";
	//
	//////��������
	$search_text = '';
	$search_text .= '<tr><td>';
	//ģ��ѡ��
	$search_text .= '��Ʒ����&nbsp;&nbsp;<input type="text" name="chanpinkuname" value="'.$chanpinkuname.'" size="10">';
	//����ѡ��
	$sort_select = '<select name="chanpinkusort"><option value="">'.lang('plugin/yiqixueba','all').'</option>';
	$query = DB::query("SELECT cardpici FROM ".DB::table('yiqixueba_yikatong_card')." group  by cardpici");
	while($row = DB::fetch($query)) {
		$sort_select .= '<option value="'.$row['cardpici'].'" '.($cardpici == $row['cardpici'] ? ' selected' : '').'>'.$row['cardpici'].'</option>';
	}
	$sort_select .= '</select>';
	$search_text .= '&nbsp;&nbsp;��Ʒ����&nbsp;&nbsp;'.$sort_select;
	$search_text .= '&nbsp;&nbsp;'.lang('plugin/yiqixueba','cardbind').'&nbsp;&nbsp;<select name="cardbind"><option value="">'.lang('plugin/yiqixueba','all').'</option><option value="1" '.($cardbind == 1 ? ' selected' : '').'>'.lang('plugin/yiqixueba','nocardbind').'</option><option value="2" '.($cardbind == 2 ? ' selected' : '').'>'.lang('plugin/yiqixueba','cardbinded').'</option></select>';
	//ÿҳ��ʾ����
	$search_text .= "&nbsp;&nbsp;".$lang['perpage']."<select name=\"tpp\">$tpp_options</select>&nbsp;&nbsp;<input class=\"btn\" type=\"submit\" value=\"����\" /></td></tr>";
	$get_text = '&tpp='.$tpp.'&cardpici='.$cardpici.'&cardbind='.$cardbind.'&cardno='.$cardno.'&carduname='.$carduname;
	//������������
	$perpage = $tpp;
	$start = ($page - 1) * $perpage;
	$where = "";
	$where .= $cardpici ? " and cardpici=".$cardpici : "";
	$where .= $cardbind ? " and status = ".($cardbind-1) : "";
	$where .= $cardno ? " and cardno like '%".$cardno."%'" : "";
	$where .= $carduname ? " and uid =".(DB::result_first("SELECT uid FROM ".DB::table('common_member')." WHERE username ='".$carduname."'")) : "";
	if($where) {
		$where = " where ".substr($where,4,strlen($where)-4);
	}

	$chanpinkucount = DB::result_first("SELECT count(*) FROM ".DB::table('yiqixueba_brand_chanpinku').$where);
	$multi = multi($chanpinkucount, $perpage, $page,$this_page.$get_text);

	$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_brand_chanpinku').$where." order by shopid asc limit ".$start.", ".$perpage);
	while($row = DB::fetch($query)) {
		$chanpinku_list[] = $row;
	}
	$chanpinkunum = count($chanpinku_list);
}else{
}


