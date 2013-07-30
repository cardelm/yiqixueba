<?php

/**
*	一起学吧平台程序
*	文件名：shopfield.inc.php  创建时间：2013-6-1 02:24  杨文
*
*/

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
$this_page = 'plugins&identifier=yiqixueba_shop&pmod=admin&submod=shopfield';


$subac = getgpc('subac');
$subacs = array('shopfieldlist','shopfieldedit','makecard');
$subac = in_array($subac,$subacs) ? $subac : $subacs[0];

$shopfieldid = getgpc('shopfieldid');
$shopfield_info = $shopfieldid ? DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_shop_shopfield')." WHERE shopfieldid=".$shopfieldid) : array();

if($subac == 'shopfieldlist') {
	if(!submitcheck('submit')) {
		showtips(lang('plugin/yiqixueba_shop','shopfield_list_tips'));
		showformheader($this_page.'&subac=shopfieldlist');
		showtableheader(lang('plugin/yiqixueba_shop','shopfield_list'));
		showsubtitle(array('', lang('plugin/yiqixueba_shop','shopfieldname'),lang('plugin/yiqixueba_shop','cardtype'), lang('plugin/yiqixueba_shop','shopfielddescription'), lang('plugin/yiqixueba_shop','status'), ''));
		$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_shop_shopfield')." order by shopfieldid asc");
		while($row = DB::fetch($query)) {
			$shopfieldico = '';
			if($row['shopfieldico']!='') {
				$shopfieldico = str_replace('{STATICURL}', STATICURL, $row['shopfieldico']);
				if(!preg_match("/^".preg_quote(STATICURL, '/')."/i", $shopfieldico) && !(($valueparse = parse_url($shopfieldico)) && isset($valueparse['host']))) {
					$shopfieldico = $_G['setting']['attachurl'].'common/'.$row['shopfieldico'].'?'.random(6);
				}
				$shopfieldico = '<img src="'.$shopfieldico.'" width="40" height="40"/>';
			}else{
				$shopfieldico = '';
			}
			showtablerow('', array('class="td25"','class="td23"', 'class="td23"', 'class="td23"','class="td25"',''), array(
				"<input class=\"checkbox\" type=\"checkbox\" name=\"delete[]\" value=\"$row[shopfieldid]\">",
				$shopfieldico.'<br />'.$row['shopfieldname'],
				lang('plugin/yiqixueba_shop',$row['cardtype']),
				$row['shopfielddescription'],
				"<input class=\"checkbox\" type=\"checkbox\" name=\"statusnew[".$row['shopfieldid']."]\" value=\"1\" ".($row['status'] > 0 ? 'checked' : '').">",
				"<a href=\"".ADMINSCRIPT."?action=".$this_page."&subac=shopfieldedit&shopfieldid=$row[shopfieldid]\" class=\"act\">".lang('plugin/yiqixueba_shop','edit')."</a>&nbsp;&nbsp;<a href=\"".ADMINSCRIPT."?action=plugins&identifier=yiqixueba_shop&pmod=admin&submod=mkcard&shopfieldid=$row[shopfieldid]\" class=\"act\">".lang('plugin/yiqixueba_shop','makecard')."</a>",
			));
		}
		echo '<tr><td></td><td colspan="6"><div><a href="'.ADMINSCRIPT.'?action='.$this_page.'&subac=shopfieldedit" class="addtr">'.lang('plugin/yiqixueba_shop','add_shopfield').'</a></div></td></tr>';
		showsubmit('submit','submit','del');
		showtablefooter();
		showformfooter();
	}else{
	}
}elseif($subac == 'shopfieldedit') {
	if(!submitcheck('submit')) {
		if($shopfield_info['shopfieldico']!='') {
			$shopfieldico = str_replace('{STATICURL}', STATICURL, $shopfield_info['shopfieldico']);
			if(!preg_match("/^".preg_quote(STATICURL, '/')."/i", $shopfieldico) && !(($valueparse = parse_url($shopfieldico)) && isset($valueparse['host']))) {
				$shopfieldico = $_G['setting']['attachurl'].'common/'.$shopfield_info['shopfieldico'].'?'.random(6);
			}
			$shopfieldicohtml = '<br /><label><input type="checkbox" class="checkbox" name="delete1" value="yes" /> '.$lang['del'].'</label><br /><img src="'.$shopfieldico.'" width="40" height="40"/>';
		}
		$shopfieldtype_select = '<select name="shopfield_info[shopfieldtype]"><option value="benwangka" '.($shopfield_info['shopfieldtype'] == 'benwangka' ? ' selected': '').'>'.lang('plugin/yiqixueba_shop','benwangka').'</option><option value="quanwangka" '.($shopfield_info['shopfieldtype'] == 'quanwangka' ? ' selected': '').'>'.lang('plugin/yiqixueba_shop','quanwangka').'</option><option value="xunika" '.($shopfield_info['shopfieldtype'] == 'xunika' ? ' selected': '').'>'.lang('plugin/yiqixueba_shop','xunika').'</option></select>';
		showtips(lang('plugin/yiqixueba_shop','shopfield_edit_tips'));
		showformheader($this_page.'&subac=shopfieldedit','enctype');
		showtableheader(lang('plugin/yiqixueba_shop','shopfield_edit'));
		$shopfieldid ? showhiddenfields($hiddenfields = array('shopfieldid'=>$shopfieldid)) : '';
		showsetting(lang('plugin/yiqixueba_shop','shopfieldname'),'shopfield_info[shopfieldname]',$shopfield_info['shopfieldname'],'text','',0,lang('plugin/yiqixueba_shop','shopfieldname_comment'),'','',true);
		showsetting(lang('plugin/yiqixueba_shop','shopfieldtitle'),'shopfield_info[shopfieldtitle]',$shopfield_info['shopfieldtitle'],'text','',0,lang('plugin/yiqixueba_shop','shopfieldtitle_comment'),'','',true);
		showsetting(lang('plugin/yiqixueba_shop','shopfielddescription'),'shopfield_info[shopfielddescription]',$shopfield_info['shopfielddescription'],'textarea','',0,lang('plugin/yiqixueba_shop','shopfielddescription_comment'),'','',true);
		showsetting(lang('plugin/yiqixueba_shop','shopfieldtype'),'','',$shopfieldtype_select,'',0,lang('plugin/yiqixueba_shop','shopfieldtype_comment'),'','',true);
		showsetting(lang('plugin/yiqixueba_shop','cardpice'),'shopfield_info[cardpice]',$shopfield_info['cardpice'],'text','',0,lang('plugin/yiqixueba_shop','cardpice_comment'),'','',true);
		showsetting(lang('plugin/yiqixueba_shop','status'),'shopfield_info[status]',$shopfield_info['status'],'radio','',0,lang('plugin/yiqixueba_shop','status_comment'),'','',true);
		showsubmit('submit');
		showtablefooter();
		showformfooter();
	}else{
		if(!htmlspecialchars(trim($_GET['shopfield_info']['shopfieldname']))) {
			cpmsg(lang('plugin/yiqixueba_shop','shopfieldname_nonull'));
		}
		$shopfieldico = addslashes($_POST['shopfieldico']);
		if($_FILES['shopfieldico']) {
			$upload = new discuz_upload();
			if($upload->init($_FILES['shopfieldico'], 'common') && $upload->save()) {
				$shopfieldico = $upload->attach['attachment'];
			}
		}
		if($_POST['delete1'] && addslashes($_POST['shopfieldico'])) {
			$valueparse = parse_url(addslashes($_POST['shopfieldico']));
			if(!isset($valueparse['host']) && !strexists(addslashes($_POST['shopfieldico']), '{STATICURL}')) {
				@unlink($_G['setting']['attachurl'].'temp/'.addslashes($_POST['shopfieldico']));
			}
			$shopfieldico = '';
		}
		$datas = $_GET['shopfield_info'];
		$datas['shopfieldico'] = $shopfieldico;
		foreach ( $datas as $k=>$v) {
			$data[$k] = htmlspecialchars(trim($v));
			if(!DB::result_first("describe ".DB::table('yiqixueba_shop_shopfield')." ".$k)) {
				$sql = "alter table ".DB::table('yiqixueba_shop_shopfield')." add `".$k."` varchar(255) not Null;";
				runquery($sql);
			}
		}
		if($shopfieldid) {
			DB::update('yiqixueba_shop_shopfield',$data,array('shopfieldid'=>$shopfieldid));
		}else{
			DB::insert('yiqixueba_shop_shopfield',$data);
		}
		cpmsg(lang('plugin/yiqixueba_shop', 'shopfield_edit_succeed'), 'action='.$this_page.'&subac=shopfieldlist', 'succeed');
	}
}
?>