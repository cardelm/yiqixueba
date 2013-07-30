
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
$loads=intval($_GET['loads']);

//获得帖子列表.
//////////
$navmode=waterFallMain::$setting['navmode'];
if($navmode == 4) {
	$ftype = $fid ? DB::result_first("SELECT type FROM ".DB::table('forum_forum')." WHERE fid=".$fid) : '';
	if($ftype == 'group' || $ftype == 'forum') {
		$forums=$water->getForums();
		foreach ( $forums as $fk=>$fv){
			$forumids[] = $fk;
		}
		$query = DB::query("SELECT * FROM ".DB::table('forum_forum')." WHERE fup =".$fid." order by displayorder asc");
		while($row = DB::fetch($query)) {
			if(in_array($row['fid'],$forumids)){
				$gfids[] = $row['fid'];
			}
		}
		if($ftype == 'forum' && $gfids ) {
			$gfids[] = $fid ; 
		}
		$fid = implode(",",$gfids);
	}
}
/////////////
$threads=$water->getThreads($fid,$typeid,$filter,$orderby,$page,$loads);
$noavatar=get_noavatar('small');
$forums=$water->getForums();
//一些参数
$picwidth=waterFallMain::$setting['picwidth'];
$picmaxheight=waterFallMain::$setting['picmaxheigh'];
$lengthforpost=waterFallMain::$setting['lengthforpost'];
include template('yiqixueba_pbl:threads');
?>