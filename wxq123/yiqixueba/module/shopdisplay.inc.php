<?php

/**
*	一起学吧平台程序
*	文件名：shopdisplay.inc.php  创建时间：2013-6-13 10:03  杨文
*
*/

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
//店铺基本信息
$shopid = intval(getgpc('shopid'));
$shop_info = DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_brand_shop')." WHERE shopid=".$shopid);

//评价信息
$optionarray = dunserialize($base_setting['yiqixueba_brand_dianping_option']);
$option_text = '';
for($i=5;$i>0;$i--){
	$option_text .= '<option value="'.$i.'">'.$i.'</option>';
}
$options = array();
foreach($optionarray as $k=>$v ){
	if($v['status']){
		$options[$k]['name'] = $v['name'];
		$options_array = explode("|",$v['title']);
		foreach( $options_array as $kk=>$vv ){
			$options[$k]['select'] .= '<select name="option[]"><option value="0">'.$vv.'</option>';
			$options[$k]['select'] .= $option_text;
			$options[$k]['select'] .= '</select>';

		}
	}
}

//点评列表
$dianpinglists = array();
$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_brand_dianping_shop')." WHERE shopid = ".$shopid." order by dingpingtime desc limit 0,10");
$k=0;
while($row = DB::fetch($query)) {
	$dianpinglists[$k] = $row;
	$dianpinglists[$k]['dingpingtime'] = dgmdate($row['dingpingtime'],'dt');
	$dianpinglists[$k]['dianpingneirong'] = cutstr($row['dianpingneirong'],80);
	$dianpinglists[$k]['username'] = DB::result_first("SELECT username FROM ".DB::table('common_member')." WHERE uid=".$row['uid']);
	$pingfen_array[$k] = explode("|",$row['pingfen']);
	$zongdefen_array[$k] = explode("|",$row['defen']);
	foreach($options_array as $kk=>$vv ){
		if($k==0){
			$zongdefen .= $vv.'&nbsp;:&nbsp;'.$zongdefen_array[$k][$kk].'分&nbsp;&nbsp;';
		}
		$dianpinglists[$k]['pingfent'] .= $vv.'&nbsp;:&nbsp;'.$pingfen_array[$k][$kk].'分&nbsp;&nbsp;';
	}
	$k++;
}
//是否已经点评过
$dpzhuangtai = DB::result_first("SELECT count(*) FROM ".DB::table('yiqixueba_brand_dianping_shop')." WHERE shopid = ".$shopid." AND uid=".$_G['uid']);




$view = getgpc('view');

$shoplogo = $shoplogohsrc = '';
if($shop_info['shoplogo']!='') {
	$shoplogo = str_replace('{STATICURL}', STATICURL, $shop_info['shoplogo']);
	if(!preg_match("/^".preg_quote(STATICURL, '/')."/i", $mokuaiico) && !(($valueparse = parse_url($shoplogo)) && isset($valueparse['host']))) {
		$shoplogo = $_G['setting']['attachurl'].'common/'.$shop_info['shoplogo'].'?'.random(6);
		$shoplogosrc = $shoplogo;
		$shoplogo = '<img src="'.$shoplogo.'" width="80" height="60"/>';
	}
}
$shoplogo = $shoplogo ? $shoplogo : '<img src="source/plugin/yiqixueba/template/yiqixueba/default/style/image/noshoplogo.jpg" width="80" height="60"/>';
$shoplogosrc = $shoplogosrc ? $shoplogosrc : 'source/plugin/yiqixueba/template/yiqixueba/default/style/image/noshoplogo.jpg';

$shop_info['shopinformation'] =html_entity_decode($shop_info['shopinformation']);
$shop_info['shoplocation'] =explode(',',$shop_info['shoplocation']);


$sort_data = array();
$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_brand_shopsort')." order by displayorder asc");
while($row = DB::fetch($query)) {
	$sort_data[$row['shopsortid']] = $row;
}
$sssort_title_text = $sssort = '';
$sssort = $sort_data[$shop_info['shopsort']]['upids'] ? $sort_data[$shop_info['shopsort']]['upids'].'-'.$shop_info['shopsort'] : $shop_info['shopsort'];
$sssort_array = explode("-",$sssort);
$sssort_title_array = array();
foreach ($sssort_array as $v){
	if ($v){
		$sssort_title_array[] = $sort_data[$v]['sorttitle'];
	}
}
$sssort_title_text = implode(">>",$sssort_title_array);

$view = 'guestbook';
$view = 'review';
$catcfg['gusetbook'] = 1;

$chanpinku_list = array();
$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_brand_chanpinku')." WHERE shopid = ".$shop_info['shopid']." order by chanpinkuid asc limit 0,4");
$k=0;
while($row = DB::fetch($query)) {
	$logo = '';
	if($row['logo']!='') {
		$logo = str_replace('{STATICURL}', STATICURL, $row['logo']);
		if(!preg_match("/^".preg_quote(STATICURL, '/')."/i", $mokuaiico) && !(($valueparse = parse_url($logo)) && isset($valueparse['host']))) {
			$logo = $_G['setting']['attachurl'].'common/'.$row['logo'].'?'.random(6);
		}
		$logo = '<img src="'.$logo.'" width="80" height="60"/>';
	}
	$logo = $logo ? $logo : '<img src="source/plugin/yiqixueba/template/yiqixueba/default/style/image/nogoodslogo.jpg" width="80" height="60"/>';
	$chanpinku_list[$k]['chanpinkuname'] = $row['chanpinkuname'];
	$chanpinku_list[$k]['pice'] = $row['pice'];
	$chanpinku_list[$k]['logo'] = $logo;
	$k++;
}

if(submitcheck('dianpingsubmit')) {
	$olddefen = DB::result_first("SELECT defen FROM ".DB::table('yiqixueba_brand_dianping_shop')." WHERE shopid=".$shopid." order by dingpingtime desc ");
	$olddefenarr = $defenarr = array();
	$olddefenarr = explode("|",$olddefen);
	foreach($_POST['option'] as $k=>$v ){
		$defenarr[$k] = $olddefenarr[$k] ? intval($olddefenarr[$k])+intval($_POST['option'][$k]) : intval($_POST['option'][$k]);
	}
	$pjdata['uid'] = $_G['uid'];
	$pjdata['shopid'] = intval($_POST['shopid']);
	$pjdata['chanpinid'] = 0;
	$pjdata['zongti'] = $_POST['zongti'];
	$pjdata['pingfen'] = implode("|",$_POST['option']);
	$pjdata['defen'] = implode("|",$defenarr);
	$pjdata['dianpingtitle'] = $_POST['dianpingtitle'];
	$pjdata['dianpingneirong'] = $_POST['dianpingneirong'];
	$pjdata['dingpingtime'] = time();
	if(DB::result_first("SELECT count(*) FROM ".DB::table('yiqixueba_brand_dianping_shop')." WHERE uid=".$_G['uid']." AND shopid =".$pjdata['shopid'])==0){
		DB::insert('yiqixueba_brand_dianping_shop', $pjdata);
	}
	showmessage('您的评价已经提交', 'plugin.php?id=yiqixueba&submod=shopdisplay&shopid='.$shop_info['shopid']);
}//dump($base_setting);
include template('yiqixueba:'.$template_file);
?>