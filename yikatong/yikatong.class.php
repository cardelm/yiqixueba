<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}


//
class plugin_yikatong{
	function global_login_extra(){
		global $_G;
		if($_G['uid']==0){
			return '<div class="fastlg_fm y" style="margin-right: 10px; padding-right: 10px"><p><a href="plugin.php?id=yikatong:shopadmin&mod=login"><img src="source/plugin/yikatong/ykt.gif" width="124" height="24" border="0" alt="用一卡通进行登陆"></a></p><p class="hm xg1" style="padding-top: 2px;">一卡通快速登录</p></div>';
		}
		
	}//end func

	function global_usernav_extra1(){
		global $_G;
		//if($_G['uid']>0){
			$yktmember = '<span class="pipe">|</span><a href="plugin.php?id=yikatong:brand&mod=member">会员中心</a>';
		//}
		return $yktmember;
	
	}//end func

}//end class

//
class plugin_yikatong_forum extends plugin_yikatong{
	//
	function index_top() {
		$shop_sortid = DB::result_first("SELECT value FROM ".DB::table('brand_settings')." WHERE variable='shop_zidingyi'");
	}//end func
	//
	function forumdisplay_top_output(){
	}//end func


	//
	function  post_top(){
		global $_G,$sortid,$_POST,$_GET;
	}//end func
	//发布帖子页
	function post_top_output(){
	}//end func


	//
	function viewthread_modaction_output(){
		//define('IS_ROBOT', true);
		//var_dump(IS_ROBOT);
		return ;
	
	}//end func
	//
	function viewthread_top(){
		//define('IS_ROBOT', true);
	}//end func
	//
	function viewthread_postbottom_output() {

	}//end func
	//
	function forumdisplay_postbutton_bottom(){
		
		//dump($_G['uid']);
	}//end func
	//
	function guide_top_output(){
		global $data;
		return $return;
	
	}//end func
	//
	function guide_nav_extra_output(){
		global $navtitle,$lang;
		$lang['guide_my'] = "我的店铺";
		$navtitle = "我的店铺";
		return $return;
	
	}//end func
	//
	function forumdisplay_top(){
		$shop_sortid = DB::result_first("SELECT value FROM ".DB::table('brand_settings')." WHERE variable='shop_zidingyi'");
	
	}//end func
	//
	function viewthread_useraction_output(){

	}//end func
	//
	function forumdisplay_ykt_postnum() {
		global $_G;
		$threads_num = DB::result_first("SELECT threads FROM ".DB::table('forum_forum')." WHERE fid='".$_G['fid']."'");
		$posts_num = DB::result_first("SELECT posts FROM ".DB::table('forum_forum')." WHERE fid='".$_G['fid']."'");
		return $posts_num - $threads_num;
	}//end func
	//
	function _text(){
		global $sortid,$_POST,$_GET;
		//$sortid = $_GET['sortid'];
		//if(CURSCRIPT == 'forum'&&CURMODULE =='post'&&$_GET['action']=='newthread'&&$_POST){
			file_put_contents('text.txt','POST[typeoption][ykt_scjg]='.DB::result_first("SELECT optionid FROM ".DB::table('forum_typeoption')." WHERE identifier= 'ykt_canshu1'").'tid='.$_POST['tid']);
		//}
	}//end func

}//end class

?>

