<?php

/**
*	一起学吧平台程序
*	文件名：yikatong_member.php  创建时间：2013-6-26 17:20  杨文
*
*/

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$this_page = 'plugin.php?id=yiqixueba:manage&man=yikatong&subman=member';

$type = trim(getgpc('type'));
$types = array('search','create','again','locking','charge','quit');
$type = in_array($type,$types) ? $type : $types[0];
$cardcatid = intval(getgpc('cardcatid'));

$member_lists = array();

$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_yikatong_member')." order by jointime desc");
while($row = DB::fetch($query)) {
	$member_lists[] = $row;
}
$membernum = count($member_lists);

$cardcat_lists = array();

$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_yikatong_cardcat')." order by cardcatid desc");
$k=0;
while($row = DB::fetch($query)) {
	$cardcat_lists[$k] = $row;
	if($row['cardcatico']!='') {
		$cardcatico = str_replace('{STATICURL}', STATICURL, $row['cardcatico']);
		if(!preg_match("/^".preg_quote(STATICURL, '/')."/i", $cardcatico) && !(($valueparse = parse_url($cardcatico)) && isset($valueparse['host']))) {
			$cardcatico = $_G['setting']['attachurl'].'common/'.$row['cardcatico'].'?'.random(6);
		}
		$cardcaticohtml = '<img src="'.$cardcatico.'" width="85" height="54"/>';
	}
	$cardcat_lists[$k]['cardcatico'] = $cardcatico;
	$cardcat_lists[$k]['cardcaticohtml'] = $cardcaticohtml;
	$cardcat_lists[$k]['cardtype'] = lang('plugin/yiqixueba',$row['cardtype']);
	$cardcat_lists[$k]['cardcatdescription'] = htmlspecialchars_decode($row['cardcatdescription']);
//	$cardcat_lists[$k]['cardcatname'] = $row['cardcatname'];
//	$cardcat_lists[$k]['cardjine'] = $row['cardjine'];
//	$cardcat_lists[$k]['cardjine'] = $row['cardjine'];
//	$cardcat_lists[$k]['cardjine'] = $row['cardjine'];
//	$cardcat_lists[$k]['cardjine'] = $row['cardjine'];
//	$cardcat_lists[$k]['cardjine'] = $row['cardjine'];
//	$cardcat_lists[$k]['cardjine'] = $row['cardjine'];
//	$cardcat_lists[$k]['cardjine'] = $row['cardjine'];
	$k++;
}
$cardcatnum = count($cardcat_lists);
$topnavs = array();
foreach($types as $k=>$v ){
	$topnavs[] = array('name'=>$v,'title'=>lang('plugin/yiqixueba','card_'.$v));
}


