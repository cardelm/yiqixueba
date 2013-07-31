<?php


if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
require_once dirname(__FILE__).'/base.class.php';

class plugin_yiqixueba extends plugin_yiqixueba_base{
	//
	function plugin_yiqixueba() {
		$this->yiqixueba_init();
	}//end func
	//
	function global_cpnav_extra1() {
		global $_G;
		if($_G['adminid'] == 1) {
			$return = '石家庄'.$_G['siteinfo']['apikey'];
		}
		return $return;
		
	}//end func

	//
	function global_cpnav_extra2() {
		global $_G;
		if($_G['adminid'] == 1) {
			$return = '<a href="plugin.php?id=yiqixueba&submod=teacher" >老师频道</a><a href="plugin.php?id=yiqixueba&submod=parent" >家长频道</a><a href="plugin.php?id=yiqixueba&submod=student" >学生频道</a>';
		}
		return $return;
		
	}//end func

	//
	function global_usernav_extra1() {
		global $_G;
		if($_G['adminid'] == 1) {
			$return = '<span class="pipe">|</span><a href="plugin.php?id=yiqixueba&submod=member">会员中心</a>';
		}
		return $return;
	}//end func
	//
	function global_subnavbanner() {
		global $_G;
		if($_G['adminid'] == 1) {
			$return = <<<EOF
<STYLE type="text/css">
.wapNote,.colNav4t dl,.colNav4t dt,.colNav4t dd a:hover,.colNav4t dd a:hover span,#miniSearch .btn-search,.navAd,.colNav4t dl div em{ background:url(source/plugin/yiqixueba//template/style/gif.gif) no-repeat;}
.wapNote {position:absolute;left:205px;top:36px;padding-left:15px;line-height:16px;_width:180px;color:#00AAD1;background-position:-988px -260px;}
.wapNote a {color:#ff6600;}
.wapNote a:hover {text-decoration:underline;}

#colNav4t { height:58px; padding:1px; _margin-top:5px;
margin-bottom:5px; color:#325E7F;
font:14px/1.5 微软雅黑,Tahoma,Helvetica,Arial,"5b8b4f53";}

.colNav4t { background:#F6F6F6;}
.colNav4t a { color:#325E7F;}
.colNav4t dl { float:left; position:relative; z-index:1; padding:8px 8px 3px 14px; height:48px; background-position:-315px -120px;}
.colNav4t dl.navShopping { width:260px; padding-left:10px; background:none;clear:left}
.colNav4t dl.navLife { width:260px;}
.colNav4t dl.navTalk { width:180px;}
.colNav4t dl.navService { width:160px;}
.colNav4t dt { float:left; width:28px; margin-top:1px; text-align:center; font-size:12px; color:#4575CD; padding-top:25px;
background-position:-589px -55px;}
.colNav4t dl.navLife dt { background-position:-620px -53px;}
.colNav4t dl.navTalk dt { background-position:-651px -53px;}
.colNav4t dl.navService dt { background-position:-681px -55px;}
.colNav4t dd { margin-left:30px;}
.colNav4t dd a,.colNav4t dd a span { display:inline-block;zoom:1;*display:inline;}
.colNav4t dd a {margin-bottom:2px;margin-right:2px;font-size:14px;}
.colNav4t dd a span { position:relative; z-index:0; right:-2px; padding:0 7px 0 5px;padding-top:1px9;height:22px;line-height:22px;*cursor:pointer;}

.colNav4t dd a:hover { text-decoration:none; color:#FFFFFF;}
.colNav4t dd a:hover,.colNav4t dd a:hover span {background-position:-882px -153px;}
.colNav4t dd a:hover span { background-position:100% -153px;}

.colNav4t dl div { position:absolute; right:-2px; top:55px;width:103px}
.colNav4t dl div em { position:absolute; top:-6px; _top:-4px; right:4px; width:8px; height:8px; overflow:hidden; background-position:100% -19px;}
.colNav4t dl p { display:none; margin-top:5px; _margin-top:7px; padding:0 7px 5px 4px; border:1px solid #DDD; border-top:none; background:#FFF;}
.colNav4t dl.moreOn { background-color:#FFF;}
.colNav4t dl.moreOn em { display:none;}
.STYLE2 {font-weight: bold}
</style>
<div id="colNav4t"><div class="colNav4t cf"><dl class="navShopping">
<dt class="navAd"><strong>互动</strong></dt><dd>
<a target="_blank" title="了解石家庄民生民声" href="http://www.17xue8.cn/forum.php?gid=1"><span>石门新闻</span></a>
<a target="_blank" title="镇巴本地的便民生活信息" href="http://www.17xue8.cn/forum.php?gid=40"><span>时尚石门</span></a>
<a target="_blank" title="找一个人来爱自己" href="http://www.17xue8.cn/forum-46-1.html"><span>吃在石门</span></a>
<a target="_blank" title="本地美食，献出你的手艺" href="forum-36-1.html"><span>便民信息</span></a>
<a target="_blank" title="记录旅游的经历" href="http://www.17xue8.cn/forum.php?gid=99"><span>住在石门</span></a>
<a target="_blank" title="找一个人来自己爱" href="http://www.17xue8.cn/forum-45-1.html"><span>行在石门</span></a></dd>
</dl>
<dl class="navLife">
  <dt class="STYLE2"><strong>生活</strong></dt><dd>
<a title="镇巴租房卖房信息" href="forum-42-1.html"><span>房屋租售</span></a>
<a title="带你看遍镇巴各大企业" href="plugin.php?id=yiqixueba&submod=brand"><span>商家黄页</span></a>
<a target="_blank" title="工作、结婚、生子、买房、买车" href="http://www.17xue8.cn/forum.php?gid=42"><span>交友征婚</span></a>
<a title="镇巴人才频道，招聘、求职、兼职" href="plugin.php?id=yiqixueba&submod=hr"><span>求职招聘</span></a>
<a target="_blank" title="看看镇巴哪儿又有什么优惠活动了" href="http://www.17xue8.cn/forum-52-1.html"><span>促销优惠</span></a>
<a target="_blank" title="记录每一天的生活" href="http://www.17xue8.cn/forum-103-1.html"><span>摄影拍客</span></a></dd> 
</dl>
<dl class="navTalk">
<dt><strong>学习</strong></dt><dd>
<a href="plugin.php?id=yiqixueba&submod=newspaper"><span>教辅报刊</span></a>
<a target="_blank" href="http://www.zhenbaren.com/"><span>同步联系</span></a>
<a target="_blank" href="http://www.zhenbaren.com/"><span>家庭作业</span></a>
<a target="_blank" href="http://www.zhenbaren.com/"><span>一卡通</span></a>
</dd>
</dl>
<dl class="navService">
<dt><strong>兴趣</strong></dt><dd>
<a target="_blank" href="http://www.zhenbaren.com/"><span>日志</span></a><a target="_blank" href="http://www.zhenbaren.com/"><span>相册</span></a><a target="_blank" href="http://www.zhenbaren.com/"><span>应用</span></a><a target="_blank" href="http://www.zhenbaren.com/"><span>博客</span></a><a target="_blank" href="http://www.zhenbaren.com/"><span>电台</span></a><a target="_blank" href="http://www.zhenbaren.com/"><span>星空</span></a>
</dd>
</dl></div> 
</div>
EOF;
		}
		return $return;
	}//end func
	//
	function global_nav_extra() {
		global $submod,$_G;
		if($_G['adminid'] == 1) {
			$return = '<li '.($submod == 'banji' ? ' class="a"':'').' style="list-style: none;"><a href="plugin.php?id=yiqixueba&submod=banji" hidefocus="true" title="Banji">班级</a></li>';
			$return .= '<li '.($submod == 'brand' ? ' class="a"':'').' style="list-style: none;"><a href="plugin.php?id=yiqixueba&submod=brand" hidefocus="true" title="Banji">商家</a></li>';
		}
		
		return $return;
	}//end func
	//
	function discuzcode($param) {
		global $_G;
		//var_dump($param);
		//var_dump($_G['discuzcodemessage']);
	}//end func
}

//
class plugin_yiqixueba_forum extends plugin_yiqixueba {
	///
	function forumdisplay_top() {
		//include template('diy:group/index');
		//exit();
	}//end func
	//
	function forumdisplay_top_output() {
		global $_G,$navigation,$collapseimg,$_GET;
		if($_G['fid']==42) {
			////////////$_G['setting']['navs'][2]['navname'] = '';
			//$navigation = str_replace('<em>&rsaquo;</em> <a href="forum.php?gid=40">本地生活</a><em>&rsaquo;</em>','',$navigation);
			///////////////$navigation = 'fangwu';
			//$_G['forum']['allowspecialonly'] = 1;
			//var_dump($_G['forum']['allowspecialonly']);
		}
		//include template('diy:group/index');
	}//end func
}//end class
?>