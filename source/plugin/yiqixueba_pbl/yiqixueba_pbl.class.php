<?php
/*页面嵌入点，当新发布一主题时，为他生成缩略图*/
if(!defined('IN_DISCUZ')) {

exit('Access Denied');

}
include_once("function.inc.php");
require_once ("thumb.class.php");
class plugin_yiqixueba_pbl{	
	function common() {	
	}
}

class plugin_yiqixueba_pbl_forum extends plugin_yiqixueba_pbl{
	private $needBuild;

	function post_yiqixueba_pbl_message($a) {

		global $_G;
		$forumIDList = (array)unserialize($_G['cache']['plugin']['yiqixueba_pbl']['forumidlist']);
		$useThumb=$_G['cache']['plugin']['yiqixueba_pbl']['usethumb'];
		if(($useThumb)&&(in_array($_G['fid'], $forumIDList)))
		{
			
			$this->needBuild=1;
		}
		else 
		{
			$this->needBuild=0;
		}
		
		if (($this->needBuild)&&($a['param']['0'] == 'post_newthread_succeed'))
		{
			$tid=$a['param'][2]['tid'];
			$query=DB::fetch_first("select attachment,remote from ".DB::table('forum_threadimage')." where tid=".$tid);
			$threadImage=$query['attachment'];	
			if ($threadImage) 
			{  
				$sourceFile=get_attachurl($query['remote']).'forum/'.$threadImage;
				$targetFileName='thumb'.$tid;			
				$thumb=new thumb();
				$thumb->create($sourceFile,$targetFileName,$_G['cache']['plugin']['yiqixueba_pbl']['thumbwidth'],$_G['cache']['plugin']['yiqixueba_pbl']['thumbheight']);
			}
		}
	}

}



?>