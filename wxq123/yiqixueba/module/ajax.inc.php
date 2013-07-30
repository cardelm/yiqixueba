<?php

/**
*	һ��ѧ��ƽ̨����
*	�ļ�����ajax.inc.php  ����ʱ�䣺2013-6-16 22:18  ����
*
*/

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
$ajaxtype = trim(getgpc('ajaxtype'));
if($ajaxtype == 'getdist'){
	$dist = getgpc('dist');
	$siat_select = '<select name="dist2">';
	$query = DB::query("SELECT * FROM ".DB::table('common_district')." WHERE upid = $dist order by displayorder asc");
	while($row = DB::fetch($query)) {
		$siat_select .= '<option value="'.$row['id'].'">'.$row['name'].'</option>';
	}
	$siat_select .='</select>';
}elseif ($ajaxtype == 'checkdianyuan'){
	$dyusername = getgpc('dyusername');
	if(!$dyusername){
		$return = '�û�������Ϊ��';
	}elseif(DB::result_first("SELECT count(*) FROM ".DB::table('common_member')." WHERE username='".$dyusername."'")==0){
		$pass = random(4);
		$return = '�û�������ע�ᣬ���������'.$pass.'<input type="hidden" name="dypass" value="'.$pass.'">';
	}else{
		$return = '���û����Ѿ�ʹ�ã���ȷ���Ƿ���Ŀ�ͨ���û�Ϊ��Ա';
	}
}elseif ($ajaxtype == 'dyquanxian'){
	$dyquanxianname = $dyquanxiantitle = array();
	$dytype = intval(getgpc('dytype'));
	if($dytype == 1){
		$dyquanxianname = array('view','banli','zhuxiao','buban');
		$dyquanxiantitle = array('�鿴���Ѽ�¼','�����Ա��','ע����Ա��','�����Ա��');
	}elseif($dytype == 2){
		$dyquanxianname = array('view','banli','zhuxiao','buban');
		$dyquanxiantitle = array('�鿴���Ѽ�¼','�����Ա��','ע����Ա��','�����Ա��');
	}
	include template('yiqixueba:yiqixueba/default/ajax/'.$ajaxtype);
	exit();
}elseif ($ajaxtype == 'viewhelp'){
	$helpid = trim(getgpc('helpid'));
	$help_conment = $base_setting['yiqixueba_yikatong_'.$helpid.'help'];
	include template('yiqixueba:yiqixueba/default/ajax/'.$ajaxtype);
	exit();

}elseif ($ajaxtype == 'viewphoto'){
	$phototype = trim(getgpc('phototype'));
	if($phototype == 'geren' ){
		$phototype_text = '�鿴���˽�����Ƭ����';
		$photosrc = 'source/plugin/yiqixueba/template/default/style/image/';
		$photowidth = 120;
		$photoheight = 48;
	}
	if($phototype == 'shenfen' ){
		$phototype_text = '�鿴���֤ͼƬ����';
		$photosrc = 'source/plugin/yiqixueba/template/default/style/image/';
		$photowidth = 120;
		$photoheight = 80;
	}
}elseif ($ajaxtype == 'viewcardtype'){
	$cardtype_list = array();
	$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_yikatong_cardcat')." WHERE status = 1 order by cardcatid asc");
	$k = 0;
	while($row = DB::fetch($query)) {
		$cardtype_list[$k] =$row;
		$cardtype_list[$k]['cardtypename'] = $row['cardtypename'];
		$cardtype_text = strip_tags(html_entity_decode($row['cardcatdescription']));
		$cardtype_text = trim(str_replace("&nbsp;","",$cardtype_text));
		$cardtype_text = html_entity_decode($cardtype_text);
		if(!$cardtype_text){
		}else{
			$cardtype_list[$k]['cardtype_text'] = html_entity_decode($row['cardcatdescription']);
		}
		$k++;
	}
}elseif ($ajaxtype == 'getshopinfo'){
	$shopname = trim(getgpc('shopname'));
	$shop_lists = array();
	$shop_fields = dunserialize($base_setting['yiqixueba_yikatong_fields']);
	$query = DB::query("SELECT * FROM ".DB::table($base_setting['yiqixueba_yikatong_shop_table'])." WHERE ".$shop_fields['shopname']."  LIKE '%".$shopname."%'");
	$k=0;
	while($row = DB::fetch($query)) {
		if(DB::result_first("SELECT count(*) FROM ".DB::table('yiqixueba_yikatong_shop')." WHERE shopid=".$row[$shop_fields['shopid']])==0){
			$username = DB::result_first("SELECT username FROM ".DB::table('common_member')." WHERE uid=".$row[$shop_fields['uid']]);
			$shop_lists[$k]['shopid'] = $row[$shop_fields['shopid']];
			$shop_lists[$k]['shopname'] = $base_setting['yiqixueba_yikatong_shop_url'] ? ('<a href="'.str_replace("{shopid}",$row[$shop_fields['shopid']],$base_setting['yiqixueba_yikatong_shop_url']).'"  target="_blank">'.$row[$shop_fields['shopname']].'</a>&nbsp;&nbsp;'.$username) : $row[$shop_fields['shopname']].'&nbsp;&nbsp;'.$username;
			$k++;
		}
	}
	$shop_listsnum = count($shop_lists);
}elseif ($ajaxtype == 'dianyuannamecheck'){
	$outdata = '';
	$username = trim(getgpc('username'));
	if(!$username){
		$outdata = '�û�������Ϊ��';
	}elseif(DB::result_first("SELECT count(*) FROM ".DB::table('common_member')." WHERE username='".$username."'")==0){
		$pass = random(4);
		$outdata = '�û�������ע�ᣬ���������'.$pass.'<input type="hidden" name="dypass" value="'.$pass.'">';
	}else{
		$outdata = '���û����Ѿ�ʹ�ã���ȷ���Ƿ���Ŀ�ͨ���û�Ϊ��Ա';
	}
	include template('yiqixueba:yiqixueba/default/ajax/globalajax');
	exit();
}elseif ($ajaxtype == 'tuisong'){
	$tuisong = dunserialize($base_setting['index_tuisong']);
	$tuisong = $tuisong ? $tuisong : array();

	foreach($tuisong as $k=>$v ){
		$globalwin_conment .= $k;
		if(is_array($v)){
			$select[$k] = '';
			$select[$k] .= '<select name="oldshopid"><option value="0">��ѡ��</option>';
			foreach($v as $kk=>$vv ){
				$select[$k] .= '<option value="'.$vv.'">'.DB::result_first("SELECT shopname FROM ".DB::table('yiqixueba_brand_shop')." WHERE shopid=".$vv).'</option>';
			}
			$select[$k] .= '</select>';
		}
		$tuisongnum[$k] = count($v);
	}
	
	$shopid = intval(getgpc('shopid'));
	$shop_info = DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_brand_shop')." WHERE shopid=".$shopid);
	$globalwintips = '���͡�'.$shop_info['shopname'].'��ѡ��';
	$globalwin_conment = '';
	$globalwin_conment .= '<form method="post" autocomplete="off" name="tuisongform" id="tuisongform" class="s_clear"  action="plugin.php?id=yiqixueba&submod=tuisong">';
	$globalwin_conment .= '<input type="hidden" name="handlekey" value="tuisong" />';
	$globalwin_conment .= '<input type="hidden" name="formhash" value="'.FORMHASH.'" />';
	$globalwin_conment .= '<input type="hidden" name="shopid" value="'.$shopid.'" />';
	$globalwin_conment .= '<input type="hidden" name="referer" value="'.dreferer().'" />';
	$globalwin_conment .= '<table cellpadding="0" cellspacing="0" class="mbm">';
	$globalwin_conment .= '<tr><th width="80"><input type="checkbox" name="tuisongweizhi[0]" value="huandeng">��ҳ�õ�</th><td style="width:auto;">'.($select['huandeng']?'�滻��'.$select['huandeng']:'').($tuisongnum['huandeng']<10 ? '<br /><input type="checkbox" name="addnew[0]" value="huandeng">����' :'').'</td><td rowspan="5" style="vertical-align: top;">��ѡ��������λ���Ժ������������ѡ������ѡ�������滻��ѡ���滻�����̣����лõ�������Ϊ10����ͷ��������һ�����ı���ͼ����������Ϊ4����</td></tr>';
	$globalwin_conment .= '<tr><th><input type="checkbox" name="tuisongweizhi[1]" value="toutiao">��ҳͷ��</th><td>'.($select['toutiao']?'�滻��'.$select['toutiao']:'').($tuisongnum['toutiao']<1 ? '<br /><input type="checkbox" name="addnew[1]" value="toutiao">����' :'').'</td></tr>';
	$globalwin_conment .= '<tr><th><input type="checkbox" name="tuisongweizhi[2]" value="wenben">��ҳ�ı�</th><td>'.($select['wenben']?'�滻��'.$select['wenben']:'').($tuisongnum['wenben']<4 ? '<br /><input type="checkbox" name="addnew[2]" value="wenben">����' :'').'</td></tr>';
	$globalwin_conment .= '<tr><th><input type="checkbox" name="tuisongweizhi[3]" value="tuwen">��ҳͼ��</th><td>'.($select['tuwen']?'�滻��'.$select['tuwen']:'').($tuisongnum['tuwen']<4 ? '<br /><input type="checkbox" name="addnew[3]" value="tuwen">����' :'').'</td></tr>';
	$globalwin_conment .= '<tr><td></td><td><input type="hidden" name="submit" value="true" /><button type="submit" class="pn pnc" tabindex="6"><strong>����</strong></button></td></tr>';
	$globalwin_conment .= '</table></form>';

	include template('yiqixueba:yiqixueba/default/ajax/globalwin');
	exit();
}elseif ($ajaxtype == 'getserverdist'){
	$prov = intval(getgpc('prov'));
	$city = intval(getgpc('city'));
	if($prov){
		$indata = array('prov'=>$prov);
		$outdata = api_indata('getserverdist',$indata);
	}
	if($city){
		$indata = array('city'=>$city);
		$outdata = api_indata('getserverdist',$indata);
	}
	if (!$prov && !$city){
		$outdata = '��ѡ��ʡ�ݻ����';
	}
	
	include template('yiqixueba:yiqixueba/default/ajax/globalajax');
	exit();
}
include template('yiqixueba:yiqixueba/default/ajax/'.$ajaxtype);
?>