<?php

/**
*	一起学吧平台程序
*	文件名：ajax.inc.php  创建时间：2013-6-16 22:18  杨文
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
		$return = '用户名不能为空';
	}elseif(DB::result_first("SELECT count(*) FROM ".DB::table('common_member')." WHERE username='".$dyusername."'")==0){
		$pass = random(4);
		$return = '用户名可以注册，随机密码是'.$pass.'<input type="hidden" name="dypass" value="'.$pass.'">';
	}else{
		$return = '该用户名已经使用，请确认是否真的开通该用户为店员';
	}
}elseif ($ajaxtype == 'dyquanxian'){
	$dyquanxianname = $dyquanxiantitle = array();
	$dytype = intval(getgpc('dytype'));
	if($dytype == 1){
		$dyquanxianname = array('view','banli','zhuxiao','buban');
		$dyquanxiantitle = array('查看消费记录','办理会员卡','注销会员卡','补办会员卡');
	}elseif($dytype == 2){
		$dyquanxianname = array('view','banli','zhuxiao','buban');
		$dyquanxiantitle = array('查看消费记录','办理会员卡','注销会员卡','补办会员卡');
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
		$phototype_text = '查看个人近期照片样本';
		$photosrc = 'source/plugin/yiqixueba/template/default/style/image/';
		$photowidth = 120;
		$photoheight = 48;
	}
	if($phototype == 'shenfen' ){
		$phototype_text = '查看身份证图片样本';
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
		$outdata = '用户名不能为空';
	}elseif(DB::result_first("SELECT count(*) FROM ".DB::table('common_member')." WHERE username='".$username."'")==0){
		$pass = random(4);
		$outdata = '用户名可以注册，随机密码是'.$pass.'<input type="hidden" name="dypass" value="'.$pass.'">';
	}else{
		$outdata = '该用户名已经使用，请确认是否真的开通该用户为店员';
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
			$select[$k] .= '<select name="oldshopid"><option value="0">请选择</option>';
			foreach($v as $kk=>$vv ){
				$select[$k] .= '<option value="'.$vv.'">'.DB::result_first("SELECT shopname FROM ".DB::table('yiqixueba_brand_shop')." WHERE shopid=".$vv).'</option>';
			}
			$select[$k] .= '</select>';
		}
		$tuisongnum[$k] = count($v);
	}
	
	$shopid = intval(getgpc('shopid'));
	$shop_info = DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_brand_shop')." WHERE shopid=".$shopid);
	$globalwintips = '推送【'.$shop_info['shopname'].'】选项';
	$globalwin_conment = '';
	$globalwin_conment .= '<form method="post" autocomplete="off" name="tuisongform" id="tuisongform" class="s_clear"  action="plugin.php?id=yiqixueba&submod=tuisong">';
	$globalwin_conment .= '<input type="hidden" name="handlekey" value="tuisong" />';
	$globalwin_conment .= '<input type="hidden" name="formhash" value="'.FORMHASH.'" />';
	$globalwin_conment .= '<input type="hidden" name="shopid" value="'.$shopid.'" />';
	$globalwin_conment .= '<input type="hidden" name="referer" value="'.dreferer().'" />';
	$globalwin_conment .= '<table cellpadding="0" cellspacing="0" class="mbm">';
	$globalwin_conment .= '<tr><th width="80"><input type="checkbox" name="tuisongweizhi[0]" value="huandeng">首页幻灯</th><td style="width:auto;">'.($select['huandeng']?'替换：'.$select['huandeng']:'').($tuisongnum['huandeng']<10 ? '<br /><input type="checkbox" name="addnew[0]" value="huandeng">增加' :'').'</td><td rowspan="5" style="vertical-align: top;">在选择了推送位置以后，如果是增加则选中增加选项，如果是替换则选择替换的商铺，其中幻灯最大个数为10个；头条智能有一个；文本和图文最大个数均为4个。</td></tr>';
	$globalwin_conment .= '<tr><th><input type="checkbox" name="tuisongweizhi[1]" value="toutiao">首页头条</th><td>'.($select['toutiao']?'替换：'.$select['toutiao']:'').($tuisongnum['toutiao']<1 ? '<br /><input type="checkbox" name="addnew[1]" value="toutiao">增加' :'').'</td></tr>';
	$globalwin_conment .= '<tr><th><input type="checkbox" name="tuisongweizhi[2]" value="wenben">首页文本</th><td>'.($select['wenben']?'替换：'.$select['wenben']:'').($tuisongnum['wenben']<4 ? '<br /><input type="checkbox" name="addnew[2]" value="wenben">增加' :'').'</td></tr>';
	$globalwin_conment .= '<tr><th><input type="checkbox" name="tuisongweizhi[3]" value="tuwen">首页图文</th><td>'.($select['tuwen']?'替换：'.$select['tuwen']:'').($tuisongnum['tuwen']<4 ? '<br /><input type="checkbox" name="addnew[3]" value="tuwen">增加' :'').'</td></tr>';
	$globalwin_conment .= '<tr><td></td><td><input type="hidden" name="submit" value="true" /><button type="submit" class="pn pnc" tabindex="6"><strong>推送</strong></button></td></tr>';
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
		$outdata = '请选择省份或城市';
	}
	
	include template('yiqixueba:yiqixueba/default/ajax/globalajax');
	exit();
}
include template('yiqixueba:yiqixueba/default/ajax/'.$ajaxtype);
?>