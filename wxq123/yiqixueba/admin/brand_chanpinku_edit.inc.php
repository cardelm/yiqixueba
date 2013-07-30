<?php

/**
*	一起学吧平台程序
*	文件名：brand_dianping_setting.inc.php  创建时间：2013-6-9 16:25  杨文
*
*/
//一卡通设置页面
//此页面有两个地方引用，一个是“基础设置”中的模块管理中的模块列表中的设置
//还有就是顶部菜单中一卡通中的设置
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}


$mokuaiid = $mokuaiid ? $mokuaiid : $mokuai_info['mokuaiid'];

$pre_var = 'yiqixueba_'.$mokuai_info['upmokuai'].'_'.$mokuai_info['mokuainame'];

$chanpinid = getgpc('chanpinid');
$chanpinku_info =$chanpinid ? DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_brand_chanpinku')." WHERE chanpinkuid=".$chanpinid) :'';
if(!submitcheck('submit')) {
	$chanpinku_sort = $plugin_setting['yiqixueba_chanpinku_chanpinku_sort'];
	//dump($chanpinku_sort);
	$array1 = explode("\n",$chanpinku_sort);
	//dump($array1);
	$guize =  array();
	$cats_option = '';
	foreach ( $array1 as $k => $v ){
		$array2 = explode("=",$v);
		$guize[] = array('level'=>substr_count($array2[0],"."),'up'=>substr($array2[0],0,strrpos($array2[0],".")),'id'=>$array2[0],'name'=>$array2[1]);
		if(substr_count($array2[0],".")==0){
			$cats_option .= '<option value="'.$array2[0].'">'.$array2[1].'</option>';
		}
	}
	//dump($guize);
	$yiqixueba_chanpinku_fields = dunserialize($plugin_setting['yiqixueba_chanpinku_fields']);
	$logo = '';
	if($chanpinku_info['logo']!='') {
		$logo = str_replace('{STATICURL}', STATICURL, $chanpinku_info['logo']);
		if(!preg_match("/^".preg_quote(STATICURL, '/')."/i", $mokuaiico) && !(($valueparse = parse_url($logo)) && isset($valueparse['host']))) {
			$logo = $_G['setting']['attachurl'].'common/'.$chanpinku_info['logo'].'?'.random(6);
		}
		$logohtml = '<br /><label><input type="checkbox" class="checkbox" name="delete" value="yes" /> '.$lang['del'].'</label><br /><img src="'.$logo.'" width="80" height="60"/>';
	}
	showtips(lang('plugin/yiqixueba','brand_chanpinku_edit_tips'));
	showformheader($this_page.'&subac=goodsedit&mokuaiid='.$mokuaiid,'enctype');
	showtableheader(lang('plugin/yiqixueba','brand_chanpinku_edit'));
	$chanpinid ? showhiddenfields(array('chanpinid'=>$chanpinid)) : '';
	showsetting(lang('plugin/yiqixueba','shopname'),'chanpinku_info[shopid]',$chanpinku_info['shopid'],'text','',0,lang('plugin/yiqixueba','shopname_comment'),'','',true);
	showsetting(lang('plugin/yiqixueba','chanpinkuname'),'chanpinku_info[chanpinkuname]',$chanpinku_info['chanpinkuname'],'text','',0,lang('plugin/yiqixueba','chanpinkuname_comment'),'','',true);
	showsetting(lang('plugin/yiqixueba','chanpinku_sort'),'','','<select name="">'.$cats_option.'</select>','',0,lang('plugin/yiqixueba','chanpin_sort_comment'),'','',true);
	showsetting(lang('plugin/yiqixueba','chanpinkulogo'),'logo',$chanpinku_info['logo'],'filetext','',0,lang('plugin/yiqixueba','chanpinkulogo_comment'),'','',true);
	showsetting(lang('plugin/yiqixueba','chanpinkupice'),'chanpinku_info[pice]',$chanpinku_info['pice'],'text','',0,lang('plugin/yiqixueba','chanpinkupice_comment'),'','',true);
	echo '<script src="source/plugin/yiqixueba/template/kindeditor/kindeditor.js" type="text/javascript"></script>';
	echo '<link rel="stylesheet" href="source/plugin/yiqixueba/template/kindeditor/themes/default/default.css" />';
	echo '<link rel="stylesheet" href="source/plugin/yiqixueba/template/kindeditor/plugins/code/prettify.css" />';
	echo '<script src="source/plugin/yiqixueba/template/kindeditor/lang/zh_CN.js" type="text/javascript"></script>';
	echo '<script src="source/plugin/yiqixueba/template/kindeditor/prettify.js" type="text/javascript"></script>';
	echo '<script src="source/plugin/yiqixueba/template/kindeditor/editor.js" type="text/javascript"></script>';
	echo '<tr class="noborder" ><td colspan="2" class="td27" s="1">'.lang('plugin/yiqixueba','shopinformation').':</td></tr>';
	echo '<tr class="noborder" ><td colspan="2" ><textarea name="shopinformation" style="width:700px;height:200px;visibility:hidden;">'.$chanpinku_info['information'].'</textarea></td></tr>';
	showsubmit('submit');
	showtablefooter();
	showformfooter();
}else{
	if(!htmlspecialchars(trim($_GET['chanpinku_info']['chanpinkuname']))) {
		cpmsg(lang('plugin/yiqixueba','chanpinkuname_nonull'));
	}
	$logo = addslashes($_GET['logo']);
	if($_FILES['logo']) {
		$upload = new discuz_upload();
		if($upload->init($_FILES['logo'], 'common') && $upload->save()) {
			$logo = $upload->attach['attachment'];
		}
	}
	if($_POST['delete'] && addslashes($_POST['logo'])) {
		$valueparse = parse_url(addslashes($_POST['logo']));
		if(!isset($valueparse['host']) && !strexists(addslashes($_POST['logo']), '{STATICURL}')) {
			@unlink($_G['setting']['attachurl'].'temp/'.addslashes($_POST['logo']));
		}
		$logo = '';
	}
	$data = array();
	$datas = $_GET['chanpinku_info'];
	$datas['logo'] = $logo;
	$datas['information'] = stripslashes($_POST['shopinformation']);
	foreach ( $datas as $k=>$v) {
		$data[$k] = htmlspecialchars(trim($v));
		if(!DB::result_first("describe ".DB::table('yiqixueba_brand_chanpinku')." ".$k)) {
			$sql = "alter table ".DB::table('yiqixueba_brand_chanpinku')." add `".$k."` varchar(255) not Null;";
			runquery($sql);
		}
	}
	if($chanpinid) {
		DB::update('yiqixueba_brand_chanpinku',$data,array('chanpinkuid'=>$chanpinid));
	}else{
		DB::insert('yiqixueba_brand_chanpinku',$data);
	}
	cpmsg(lang('plugin/yiqixueba', 'brand_chanpinku_edit_succeed'), 'action='.$this_page.'&subac=goodslist&mokuaiid='.$mokuaiid, 'succeed');
}
?>