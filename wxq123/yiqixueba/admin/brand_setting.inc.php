<?php

/**
*	一起学吧平台程序
*	文件名：tuangou_setting.inc.php  创建时间：2013-6-9 16:25  杨文
*
*/

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
//在模块管理中，有$mokuai_info参数，而直接执行笨页面时则没有$mokuai_info参数
if(!$mokuai_info){
	$mokuai_info = DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_mokuai')." WHERE mokuainame ='brand'");
}
//读取yiqixueba_setting参数设置中的一卡通参数
$mokuai_setting = array();
$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_setting')." WHERE skey like 'yiqixueba_".$mokuai_info['mokuainame']."%'");
while($row = DB::fetch($query)) {
	$mokuai_setting[$row['skey']] = $row['svalue'];
}
$mokuaiid = $mokuaiid ? $mokuaiid : $mokuai_info['mokuaiid'];

$pre_var = 'yiqixueba_'.$mokuai_info['mokuainame'];

$this_page = $this_page ? $this_page : 'plugins&identifier=yiqixueba&pmod=admin&submod=brand_setting';

//dump($mokuai_setting);

if(!submitcheck('submit')) {
	//读取模版信息
	$templates = array();
	$temp_dir = DISCUZ_ROOT.'source/plugin/yiqixueba/template/yiqixueba';
	if ($handle = opendir($temp_dir)) {
		while (false !== ($file = readdir($handle))) {
			if ($file != "." && $file != "..") {
				if (is_dir($temp_dir."/".$file)) {
					$templates[] = $file;
				}
			}
		}
	}
	$temp_select = '<select name="setting[yiqixueba_'.$mokuai_info['mokuainame'].'_thistemplate]">';
	foreach ($templates as $k=>$v){
		$temp_select .= '<option value="'.$v.'" '.($mokuai_setting['yiqixueba_'.$mokuai_info['mokuainame'].'_thistemplate'] == $v ? ' selected':'').'>'.lang('plugin/yiqixueba','temp_'.$v).'</option>';
	}
	$temp_select .= '</select>';

	//处理按钮图片
	$botton = $bottonhtml = array();
	for($i=1;$i<5 ;$i++ ){
		$botton[$i-1] = '';
		if($mokuai_setting['yiqixueba_'.$mokuai_info['mokuainame'].'_botton'.$i]!='') {
			$botton[$i-1] = str_replace('{STATICURL}', STATICURL, $mokuai_setting['yiqixueba_'.$mokuai_info['mokuainame'].'_botton'.$i]);
			if(!preg_match("/^".preg_quote(STATICURL, '/')."/i", $botton[$i-1]) && !(($valueparse = parse_url($botton[$i-1])) && isset($valueparse['host']))) {
				$botton[$i-1] = $_G['setting']['attachurl'].'common/'.$mokuai_setting['yiqixueba_'.$mokuai_info['mokuainame'].'_botton'.$i].'?'.random(6);
			}
			$bottonhtml[$i-1] = '<label><input type="checkbox" class="checkbox" name="delete" value="yes" /> '.$lang['del'].'</label><br /><img src="'.$botton[$i-1].'" width="145" height="30"/><br />';
		}
	}
	
	showtips(lang('plugin/yiqixueba',$mokuai_info['mokuainame'].'_setting_tips'));
	showformheader($this_page.'&subac=mokuaisetting&mokuaiid='.$mokuaiid,'enctype');
	showtableheader(lang('plugin/yiqixueba','yikatong_setting'));
	showhiddenfields(array('mokuaiid'=>$mokuaiid));

	showsetting(lang('plugin/yiqixueba','nav_menu'),'setting[yiqixueba_'.$mokuai_info['mokuainame'].'_nav_menu]',$mokuai_setting['yiqixueba_'.$mokuai_info['mokuainame'].'_nav_menu'],'radio','','',lang('plugin/yiqixueba','nav_menu_comment'),'','',true);

	showsetting(lang('plugin/yiqixueba','top_menu'),'setting[yiqixueba_'.$mokuai_info['mokuainame'].'_top_menu]',$mokuai_setting['yiqixueba_'.$mokuai_info['mokuainame'].'_top_menu'],'radio','','',lang('plugin/yiqixueba','top_menu_comment'),'','',true);

	$businessgroup_select = '<select name="setting['.$pre_var.'_businessgroup]">';
	$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_yikatong_businessgroup')." WHERE status = 1 order by businessgroupid asc");
	while($row = DB::fetch($query)) {
		$businessgroup_select .= '<option value="'.$row['businessgroupid'].'" '.($mokuai_setting[$pre_var.'_businessgroup']==$row['businessgroupid'] ? ' selected':'').'>'.$row['businessgroupname'].'</option>';
	}
	$businessgroup_select .= '</select>';
	showsetting(lang('plugin/yiqixueba','businessgroup'),'setting['.$pre_var.'_businessgroup]',$mokuai_setting[$pre_var.'_businessgroup'],$businessgroup_select,'','',lang('plugin/yiqixueba','businessgroup_comment'),'','',true);

	showsetting(lang('plugin/yiqixueba','thistemplate'),'','',$temp_select,'','',lang('plugin/yiqixueba','thistemplate_comment'),'','',true);

	showsetting(lang('plugin/yiqixueba','botton1'),'yiqixueba_'.$mokuai_info['mokuainame'].'_botton1',$mokuai_setting['yiqixueba_'.$mokuai_info['mokuainame'].'_botton1'],'filetext','','',$bottonhtml[0].lang('plugin/yiqixueba','botton1_comment'),'','',true);
	showsetting(lang('plugin/yiqixueba','botton2'),'yiqixueba_'.$mokuai_info['mokuainame'].'_botton2',$mokuai_setting['yiqixueba_'.$mokuai_info['mokuainame'].'_botton2'],'filetext','','',$bottonhtml[1].lang('plugin/yiqixueba','botton2_comment'),'','',true);
	showsetting(lang('plugin/yiqixueba','botton3'),'yiqixueba_'.$mokuai_info['mokuainame'].'_botton3',$mokuai_setting['yiqixueba_'.$mokuai_info['mokuainame'].'_botton3'],'filetext','','',$bottonhtml[2].lang('plugin/yiqixueba','botton3_comment'),'','',true);
	showsetting(lang('plugin/yiqixueba','botton4'),'yiqixueba_'.$mokuai_info['mokuainame'].'_botton4',$mokuai_setting['yiqixueba_'.$mokuai_info['mokuainame'].'_botton4'],'filetext','','',$bottonhtml[3].lang('plugin/yiqixueba','botton4_comment'),'','',true);
	showsubmit('submit');
	showtablefooter();
	showformfooter();
}else{
	$setting = getgpc('setting');
	$botton = array();
	for($i=1;$i<5 ;$i++ ){
		$botton[$i-1] = addslashes($_GET['yiqixueba_'.$mokuai_info['mokuainame'].'_botton'.$i]);
		if($_FILES['yiqixueba_'.$mokuai_info['mokuainame'].'_botton'.$i]) {
			$upload = new discuz_upload();
			if($upload->init($_FILES['yiqixueba_'.$mokuai_info['mokuainame'].'_botton'.$i], 'common') && $upload->save()) {
				$botton[$i-1] = $upload->attach['attachment'];
			}
		}
		if($_POST['delete'] && addslashes($_POST['yiqixueba_'.$mokuai_info['mokuainame'].'_botton'.$i])) {
			$valueparse = parse_url(addslashes($_POST['yiqixueba_'.$mokuai_info['mokuainame'].'_botton'.$i]));
			if(!isset($valueparse['host']) && !strexists(addslashes($_POST['yiqixueba_'.$mokuai_info['mokuainame'].'_botton'.$i]), '{STATICURL}')) {
				@unlink($_G['setting']['attachurl'].'temp/'.addslashes($_POST['yiqixueba_'.$mokuai_info['mokuainame'].'_botton'.$i]));
			}
			$botton[$i-1] = '';
		}
		$setting['yiqixueba_'.$mokuai_info['mokuainame'].'_botton'.$i] = $botton[$i-1];
	}
	$setting['yiqixueba_'.$mokuai_info['mokuainame'].'_gonggaotext1'] = stripslashes($_POST['gonggaotext1']);
	$setting['yiqixueba_'.$mokuai_info['mokuainame'].'_gonggaotext2'] = stripslashes($_POST['gonggaotext2']);
	$setting['yiqixueba_'.$mokuai_info['mokuainame'].'_gonggaotext3'] = stripslashes($_POST['gonggaotext3']);
	$setting['yiqixueba_'.$mokuai_info['mokuainame'].'_gonggaotext4'] = stripslashes($_POST['gonggaotext4']);
	if (is_array($setting)){
		foreach ($setting as $key => $value){
			if (DB::result_first("SELECT count(*) FROM ".DB::table('yiqixueba_setting')." WHERE skey='".$key."'") == 0){
				DB::insert('yiqixueba_setting',array('skey'=>$key,'svalue'=>$value));
			}else{
				DB::update('yiqixueba_setting',array('svalue'=>$value),array('skey'=>$key));
			}
		}
	}
	cpmsg(lang('plugin/yiqixueba', 'mokuai_setting_succeed'), 'action='.$this_page.'&subac=mokuailist', 'succeed');
}

?>