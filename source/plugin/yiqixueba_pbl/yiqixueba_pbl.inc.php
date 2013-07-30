<?php

if(!defined('IN_DISCUZ')) {
   exit('Access Deined');
}
require_once("main.class.php");
$water=new waterFallMain();
$fid=strval($_GET['fid']);
$typeid=strval($_GET['typeid']);
$filter=strval($_GET['filter']);
$orderby=strval($_GET['orderby']);
$page=intval($_GET['page']);

//添加分页
$mulpage=$water->getMulPage($fid,$typeid,$filter,$orderby,$page);
//所有已设置论坛版块和主题类别
$forums=$water->getForums();
$types=$typeidOfForum=array();
if (waterFallMain::$setting['usetypeid'])
{
	$types=$water->getTypes();
	foreach($forums as $fkey=>$fval)
	{
		$typeidOfForum[$fkey]=$water->getTypeidsByFid($fkey);
	}
}

//可选择的筛选和排序方式
$filters=waterFallMain::$filters;
$orderbys=waterFallMain::$orderBys;
//其他参数
$loadsperpage=waterFallMain::$setting['loadsperpage'];
$usetypeid=waterFallMain::$setting['usetypeid'];
$picwidth=waterFallMain::$setting['picwidth'];
$columnwidth=$picwidth+20;
$orderbydefault=waterFallMain::$setting['defaultorderby'];//默认的排序方式
$navmode=waterFallMain::$setting['navmode'];
//下面代码显示本插件的菜单名称在浏览器标题中
$navtitle = waterFallMain::$setting['navtitle'];
$metakeywords = waterFallMain::$setting['metakeywords'];
$metadescription = waterFallMain::$setting['metadescription'];

if($navmode==4) {
	$forums_fids = array();
	$query = DB::query("SELECT * FROM ".DB::table('forum_forum')." WHERE status <> 3 order by displayorder asc");
	while($row = DB::fetch($query)) {
		$forums_fids[$row['fid']] = $row;
	}
	foreach ( $forums as $fk=>$fv){
		$forumids[] = $fk;
	}
	$forums_list = array();
	$query = DB::query("SELECT * FROM ".DB::table('forum_forum')." WHERE status <> 3 order by displayorder asc");
	while($row = DB::fetch($query)) {
		if(in_array($row['fid'],$forumids)){
			if($row['type']=='forum'){
				$forum_list[$row['fup']] = $forums_fids[$row['fup']];
				$forum_list[$row['fid']] = $row;
				if($fid==$row['fup']||$fid==$row['fid']) {
					$g_fid = $row['fup'];
				}
				if($fid==$row['fid']) {
					$f_fid = $row['fid'];
				}
			}
			if($row['type']=='sub'){
				//$gfid = DB::result_first("SELECT fup FROM ".DB::table('forum_forum')." WHERE fid=".$row['fup']);
				$gfid = $forums_fids[$row['fup']]['fup'];
				//$forum_list[$gfid] = DB::fetch_first("SELECT * FROM ".DB::table('forum_forum')." WHERE fid=".$gfid);
				$forum_list[$gfid] = $forums_fids[$gfid];
				//$forum_list[$row['fup']] = DB::fetch_first("SELECT * FROM ".DB::table('forum_forum')." WHERE fid=".$row['fup']);
				$forum_list[$row['fup']] = $forums_fids[$row['fup']];
				$forum_list[$row['fid']] = $row;
				if($fid==$gfid||$fid==$row['fup']||$fid==$row['fid']) {
					$g_fid = $gfid;
				}
				if($fid==$row['fup']||$fid==$row['fid']) {
					$f_fid = $row['fup'];
				}
				if($fid==$row['fid']) {
					$s_fid = $row['fid'];
				}
			}
		}
	}
	foreach ( $forum_list as $fk=>$fv){
		if($fv['type']=='group'){
			$group[] = $fv;
		}
		if( $fv['fup'] == $g_fid && $fv['type']=='forum') {
			$forum[] = $fv;
		}
		if($fv['type']=='sub' && $fv['fup'] == $f_fid){
			$sub[] = $fv;
		}
	}
	$group = array_sort($group,'displayorder');
	$forum = array_sort($forum,'displayorder');
	$sub = array_sort($sub,'displayorder');
}

include template('yiqixueba_pbl:yiqixueba_pbl');

function array_sort($arr,$keys,$type='asc'){
	$keysvalue = $new_array = array();
	foreach ($arr as $k=>$v){
		$keysvalue[$k] = $v[$keys];
	}
	if($type == 'asc'){
		asort($keysvalue);
	}else{
		arsort($keysvalue);
	}
	reset($keysvalue);
	foreach ($keysvalue as $k=>$v){
		$new_array[$k] = $arr[$k];
	}
	return $new_array;
}

?>