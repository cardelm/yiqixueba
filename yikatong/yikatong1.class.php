<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
//
class plugin_yikatong{
	//
	function global_login_extra(){
		global $_G;
		if($_G['uid']==0){
			return '<div class="fastlg_fm y" style="margin-right: 10px; padding-right: 10px"><p><a href="plugin.php?id=yikatong:shopadmin&mod=login"><img src="source/plugin/yikatong/ykt.gif" width="124" height="24" border="0" alt="��һ��ͨ���е�½"></a></p><p class="hm xg1" style="padding-top: 2px;">һ��ͨ���ٵ�¼</p></div>';
		}
	}//end func

	function global_usernav_extra1(){
		global $_G;
		if($_G['uid']>0){
			$yktmember = '<span class="pipe">|</span><a href="plugin.php?id=yikatong:brand&mod=member">��Ա����</a>';
		}
		return $yktmember;
	
	}//end func
	//
	function discuzcode($param) {
			global $_G;
			if($param['caller'] == 'discuzcode') {
				$_G['discuzcodemessage'] = preg_replace('/\[wb=(.+?)\](.+?)\[\/wb\]/', '<a href="http://t.qq.com/\\1" target="_blank"><img src="\\2" /></a>', $_G['discuzcodemessage']);
			}
			if($param['caller'] == 'messagecutstr') {
				$_G['discuzcodemessage'] = preg_replace('/\[tthread=(.+?)\](.*?)\[\/tthread\]/', '', $_G['discuzcodemessage']);
			}
	}//end func

}//end class

//
class plugin_yikatong_forum extends plugin_yikatong{
	//
	function forumdisplay_top_output(){
		global $_G,$tpid;
		if($_G['fid'] == intval(DB::result_first("SELECT value FROM ".DB::table('brand_settings')." WHERE variable='goods_forum'"))){
			$_G['setting']['threadplugins']['yikatong']['name'] = 'һ��ͨ��Ʒ';
		}
		if($_G['fid'] == intval(DB::result_first("SELECT value FROM ".DB::table('brand_settings')." WHERE variable='shop_forum'"))){
			$_G['setting']['threadplugins']['yikatong']['name'] = 'һ��ͨ����';
		}
		return ;
	}//end func


	//
	function  post_top(){
		global $_G,$sortid,$_POST,$_GET;
		$shop_zidingyi = intval(DB::result_first("SELECT value FROM ".DB::table('brand_settings')." WHERE variable='shop_zidingyi'"));
		$goods_zidingyi = intval(DB::result_first("SELECT value FROM ".DB::table('brand_settings')." WHERE variable='goods_zidingyi'"));
		$shop_forum = intval(DB::result_first("SELECT value FROM ".DB::table('brand_settings')." WHERE variable='shop_forum'"));
		$goods_forum = intval(DB::result_first("SELECT value FROM ".DB::table('brand_settings')." WHERE variable='goods_forum'"));
		$shop_count = intval(DB::result_first("SELECT count(*) FROM ".DB::table('forum_thread')." WHERE authorid=$_G[uid] and sortid = ".$shop_zidingyi));
		if($shop_count>0){
			file_put_contents('text.txt','shop_count='.$shop_count);
			//showmessage('�ɹ���Ϣ', 'forum.php?mod=forumdisplay&fid='.$shop_forum);
		}

		$this->_text();
	}//end func
	//
	function  post_top_message($value){
		$value=array('param'=>'jksahdash');
		return;
	
	}//end func
	//��������ҳ
	function post_top_output(){
		global $sortid,$_G,$isfirstpost,$forum_optionlist,$editorid,$_POST,$_GET;
		$shopid = $_GET['shopid']?$_GET['shopid']:$_POST['shopid'];
		$shopid = $shopid?$shopid:0;

		$shop_zidingyi = intval(DB::result_first("SELECT value FROM ".DB::table('brand_settings')." WHERE variable='shop_zidingyi'"));
		$goods_zidingyi = intval(DB::result_first("SELECT value FROM ".DB::table('brand_settings')." WHERE variable='goods_zidingyi'"));
		$shop_forum = intval(DB::result_first("SELECT value FROM ".DB::table('brand_settings')." WHERE variable='shop_forum'"));
		$goods_forum = intval(DB::result_first("SELECT value FROM ".DB::table('brand_settings')." WHERE variable='goods_forum'"));
		$shop_count = intval(DB::result_first("SELECT count(*) FROM ".DB::table('forum_thread')." WHERE authorid=$_G[uid] and sortid = ".$shop_zidingyi));
		if($sortid == $goods_zidingyi){
			if($shopid ==0 ){
				$sortid = $shop_zidingyi;
				require_once libfile('function/threadsort');
				threadsort_checkoption($sortid);
				$forum_optionlist = getsortedoptionlist();
				loadcache(array('threadsort_option_'.$sortid, 'threadsort_template_'.$sortid));
				$_GET['fid'] =  $fid = $shop_forum;
				$_G['forum']['threadsorts']['description'][$_G['forum_selectsortid']] = '����û���̼ң���ѡ���̼�';
			}
		}
		
	}//end func

	//
	function forumdisplay_postbutton_bottom_putput(){
		//dump($_G['uid']);
	}//end func
	//
	function _text(){
		global $sortid,$_POST,$_GET;
		$sortid = $_GET['sortid'];
		if(CURSCRIPT == 'forum'&&CURMODULE =='post'&&$_GET['action']=='newthread'&&$_POST){
			file_put_contents('text.txt','POST[subject]='.$_POST['subject']);
		}
	}//end func

}//end class

?>

