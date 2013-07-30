<?php
if(!defined('IN_DISCUZ')) {
   exit('Access Deined');
}
include_once("function.inc.php");
require_once ("thumb.class.php");

$where=$_GET['where'];
$index=intval($_GET['index']);
$pertask=intval($_GET['pertask']);
$allthread=intval($_GET['allthread']);

$sql="select a.tid,b.attachment,b.remote from ".DB::table('forum_thread')." as a left join ".DB::table('forum_threadimage')." as b on a.tid=b.tid ".$where;
$sql=$sql." limit ".$index*$pertask.",$pertask";
$query=DB::query($sql);
$thread=array();
$thumb=new thumb();
while($thread = DB::fetch($query))
{
	if ($thread['attachment'])
	{
		$sourceFile=get_attachurl($thread['remote']).'forum/'.$thread['attachment'];
		$targetFileName='thumb'.$thread['tid'];	
		$thumb->create($sourceFile,$targetFileName,$_G['cache']['plugin']['yiqixueba_pbl']['thumbwidth'],$_G['cache']['plugin']['yiqixueba_pbl']['thumbheight'],$allthread);
	}
}
echo "<p>complete once.</p>";
?>

