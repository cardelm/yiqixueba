<?php 
include_once("function.inc.php");
class waterFallMain 
{
	static $filters;
	static $orderBys;
	static $setting;
	function __construct()
	{
		global $_G;
		if (!isset(self::$setting)) self::$setting=$_G['cache']['plugin']['yiqixueba_pbl'];
		if (!is_array(self::$filters)) {
			self::$filters=array();
			if (isset($_G['setting']['recommendthread']['iconlevels']))
			{
				self::$filters['1']=array('name'=>lang('plugin/yiqixueba_pbl', 'love'),'sql'=>'recommends>='.$_G['setting']['recommendthread']['iconlevels']['0']);
			}
			if (isset($_G['setting']['heatthread']['iconlevels']))
			{
				self::$filters['2']=array('name'=>lang('plugin/yiqixueba_pbl', 'hot'),'sql'=>'heats>='.$_G['setting']['heatthread']['iconlevels']['0']);
			}
			self::$filters['3']=array('name'=>lang('plugin/yiqixueba_pbl', 'digest'),'sql'=>'digest in (1,2,3)');
		}
		
		if (!is_array(self::$orderBys)) {
			self::$orderBys=array();
			self::$orderBys['1']=array('name'=>lang('plugin/yiqixueba_pbl','bydateline'),'sql'=>'order by dateline desc');
			self::$orderBys['2']=array('name'=>lang('plugin/yiqixueba_pbl','bylastpost'),'sql'=>'order by lastpost desc');
			self::$orderBys['3']=array('name'=>lang('plugin/yiqixueba_pbl','byviews'),'sql'=>'order by views desc');
			self::$orderBys['4']=array('name'=>lang('plugin/yiqixueba_pbl','byreplies'),'sql'=>'order by replies desc');
			self::$orderBys['5']=array('name'=>lang('plugin/yiqixueba_pbl','byrand'),'sql'=>'order by rand()');
		}
	}
	
	private function getForumids()
	{
		$forumidArray=unserialize(self::$setting['forumidlist']);
		$forumids=implode(",",$forumidArray);
		return $forumids;
	}	
	
	private function getWhereSql($fid,$typeid="",$filter)
	{
		if (empty($fid)) $fid=$this->getForumids();
		if (empty($fid)) return '';
		$whereSql="where fid in($fid)";
		if (!empty($typeid)&&self::$setting['usetypeid']) $whereSql=$whereSql." and typeid in ($typeid)";
		$whereSql=$whereSql." and displayorder>=0";//displayorder>=0为了过滤掉回收站内的主题
		if (self::$setting['onlypic']) $whereSql=$whereSql." and attachment=2";//有图主题过滤
		if (!empty($filter)&&array_key_exists($filter,self::$filters)) $whereSql=$whereSql." and ".self::$filters[$filter]['sql'];
		return $whereSql;		
	}
	
	private function getOrderBySql($orderBy)
	{
		if (empty($orderBy))
		{
			$orderBy=self::$setting['defaultorderby'];
		}
		if (array_key_exists($orderBy,self::$orderBys)) return self::$orderBys[$orderBy]['sql'];
		else return "";
	}
	
	public function getMulPage($fid,$typeid="",$filter,$orderBy,$page)
	{
		$perpage=self::$setting['eachload']*self::$setting['loadsperpage'];//每页显示数
		$query=DB::fetch_first("select count(*) as num from ".DB::table('forum_thread')." ".$this->getWhereSql($fid,$typeid,$filter));
		$num=$query['num'];
		$pagenum=ceil($num/$perpage);//总页数
		if($page<1) $page=1;
		if($page>$pagenum) $page=$pagenum;	
		if (self::$setting['usetypeid'])
		{
			$mpurl = "plugin.php?id=yiqixueba_pbl:yiqixueba_pbl&fid=$fid&typeid=$typeid&filter=$filter&orderby=$orderBy";
		}
		else 
		{
			$mpurl = "plugin.php?id=yiqixueba_pbl:yiqixueba_pbl&fid=$fid&filter=$filter&orderby=$orderBy";
		}
		$mulpage=multi($num, $perpage, $page, $mpurl);
		return $mulpage;
	}
	
	public function getThreads($fid,$typeid="",$filter,$orderBy,$page,$loads)
	{
		global $_G;
		$sql="SELECT fid,tid,author,authorid,subject,dateline,lastpost,attachment,views,replies,digest,heats,recommend_add,favtimes,sharetimes from ".DB::table('forum_thread')." ".$this->getWhereSql($fid,$typeid,$filter)." ".$this->getOrderBySql($orderBy);

		//设置页、段
		$perpage=self::$setting['eachload']*self::$setting['loadsperpage'];//每页显示数
		if ($page<1) $page=1;
		if ($loads<1) $loads=1;
		$start = $page * $perpage - $perpage+$loads*self::$setting['eachload']-self::$setting['eachload'];
		$sql=$sql." LIMIT $start,".self::$setting['eachload'];
		$query=DB::query($sql);
		$thread = $threads = array();
		while($thread = DB::fetch($query))
		{
			if (self::$setting['lengthforpost']>0) 
			{
				$firstpost=DB::fetch_first("select message from ".DB::table('forum_post')." where tid=$thread[tid] and first=1");	
				$thread['message']=archivermessage($firstpost['message']);
				$thread['message']=cutstr($thread['message'],self::$setting['lengthforpost']);//截取长度
			}
	
			
			
			//检查附件图片
			$img =DB::fetch_first("SELECT attachment,remote FROM ".DB::table('forum_threadimage')." WHERE tid=$thread[tid]");
			if ($img['attachment']) 
			{
				$thread['image'] = get_attachurl($img['remote']).'forum/'.$img['attachment'];
			}
			elseif ($thread['attachment']==2)//若主题中有图片附件，则找其第一个图片附件,有可能不是第一楼的图片
			{
	  			$img = DB::fetch_first("SELECT attachment ,remote FROM ".DB::table(getattachtablebytid($thread['tid']))." WHERE tid=$thread[tid]");
				if ($img['attachment']) 
				{
					$thread['image'] = get_attachurl($img['remote']).'forum/'.$img['attachment'];
				}	
			}
			elseif (!self::$setting['onlypic'])//在不是仅显示有图片主题的情况下，支持查找外链图片。
			{
				//偿试在主题帖子中查找[img]标签
				$find=preg_match('#\[img(.*?)\](.+?)\[/img\]#is',$firstpost['message'],$img);
				if ($find) {
					$thread['image']=$img[2];
				}
			}
			
			//检查缩略图
			if (self::$setting['usethumb'])
			{
				$extname=get_extension($thread['image']);
				$thumbfile=$_G['setting']['attachdir'].'yiqixueba_pbl/thumb'.$thread['tid'].'.'.$extname;
				if (file_exists($thumbfile))//判断是否有缩略图
				{
					$thread['thumb']=$_G['setting']['attachurl'].'yiqixueba_pbl/thumb'.$thread['tid'].'.'.$extname;
				}
			}
			if (!empty($thread['authorid'])) $thread['avatar']=get_avatar($thread['authorid'], 'small');
			else $thread['avatar']='';
			$thread['dateline']=date('Y-m-d h:m',$thread['dateline']);
			$threads[]=$thread;		
			
		}
			
		return $threads;
	}
	
	public function getForums()
	{
		global $_G;
		$sql="select a.fid,a.name,a.status,b.icon from ".DB::table('forum_forum')." as a left join ".DB::table('forum_forumfield')." as b on a.fid=b.fid where a.fid in (".$this->getForumids().")";
		$query=DB::query($sql);
		$forum=$forums=array();
		while($forum = DB::fetch($query))
		{
			//处理版块图标
			if($forum['icon']) {
				$parse = parse_url($forum['icon']);
				if(isset($parse['host'])) {
					$imgpath = $forum['icon'];
				} else {
					if($forum['status'] != 3) {
						$imgpath = $_G['setting']['attachurl'].'common/'.$forum['icon'];
					} else {
						$imgpath = $_G['setting']['attachurl'].'group/'.$forum['icon'];
					}
				}
				$forum['icon']=$imgpath;
			}
			$forums[$forum['fid']]=$forum;
		}
		return $forums;
	}	
	public function getTypeidsByFid($fid)
	{
		$typeids=array();
		if (!empty($fid)) {
			$sql="select typeid from ".DB::table('forum_threadclass')." where fid=$fid";
			$query=DB::query($sql);
			$typeid=array();
			while($typeid=DB::fetch($query))
			{
				$typeids[]=$typeid['typeid'];
			}
		}
		return $typeids;
	}
	public function getTypes()
	{
		$sql="select typeid,name from ".DB::table('forum_threadclass')." where fid in (".$this->getForumids().")";
		$query=DB::query($sql);
		$type=$types=array();
		while($type=DB::fetch($query))
		{
			$types[$type['typeid']]=$type['name'];
		}
		return $types;
	}
}	


?>