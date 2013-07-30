<?php

/**
*	一起学吧平台程序
*	文件名：shoptype.inc.php  创建时间：2013-5-31 20:41  杨文
*
*/

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
$this_page = 'plugins&identifier=yiqixueba_yikatong&pmod=admin&submod=shoptype';

$subac = getgpc('subac');
$subacs = array('shoptypelist','shoptypeedit');
$subac = in_array($subac,$subacs) ? $subac : $subacs[0];

$shoptypeid = getgpc('shoptypeid');
$shoptype_info = $shoptypeid ? DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_yikatong_shoptype')." WHERE shoptypeid=".$shoptypeid) : array();

if($subac == 'shoptypelist') {
	if(!submitcheck('submit')) {
		showtips(lang('plugin/yiqixueba_yikatong','shoptype_list_tips'));
		showformheader($this_page.'&subac=shoptypelist');
		showtableheader(lang('plugin/yiqixueba_yikatong','shoptype_list'));
		showsubtitle(array('', lang('plugin/yiqixueba_yikatong','shoptypename'),lang('plugin/yiqixueba_yikatong','shopnum'), lang('plugin/yiqixueba_yikatong','shoptypequanxian'), lang('plugin/yiqixueba_yikatong','status'), ''));
		$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_yikatong_shoptype')." order by shoptypeid asc");
		while($row = DB::fetch($query)) {
			$shoptypeico = '';
			if($row['shoptypeico']!='') {
				$shoptypeico = str_replace('{STATICURL}', STATICURL, $row['shoptypeico']);
				if(!preg_match("/^".preg_quote(STATICURL, '/')."/i", $shoptypeico) && !(($valueparse = parse_url($shoptypeico)) && isset($valueparse['host']))) {
					$shoptypeico = $_G['setting']['attachurl'].'common/'.$row['shoptypeico'].'?'.random(6);
				}
				$shoptypeico = '<img src="'.$shoptypeico.'" width="40" height="40"/>';
			}else{
				$shoptypeico = '';
			}
			showtablerow('', array('class="td25"','class="td23"', 'class="td23"', 'class="td23"','class="td25"',''), array(
				"<input class=\"checkbox\" type=\"checkbox\" name=\"delete[]\" value=\"$row[shoptypeid]\">",
				$shoptypeico.$row['shoptypename'],
				$row['shoptypepice'],
				$row['shoptypedescription'],
				"<input class=\"checkbox\" type=\"checkbox\" name=\"statusnew[".$row['shoptypeid']."]\" value=\"1\" ".($row['status'] > 0 ? 'checked' : '').">",
				"<a href=\"".ADMINSCRIPT."?action=".$this_page."&subac=shoptypeedit&shoptypeid=$row[shoptypeid]\" class=\"act\">".lang('plugin/yiqixueba_yikatong','edit')."</a>",
			));
		}
		echo '<tr><td></td><td colspan="6"><div><a href="'.ADMINSCRIPT.'?action='.$this_page.'&subac=shoptypeedit" class="addtr">'.lang('plugin/yiqixueba_yikatong','add_shoptype').'</a></div></td></tr>';
		showsubmit('submit','submit','del');
		showtablefooter();
		showformfooter();
	}else{
	}
}elseif($subac == 'shoptypeedit') {
	if(!submitcheck('submit')) {
		if($shoptype_info['shoptypeico']!='') {
			$shoptypeico = str_replace('{STATICURL}', STATICURL, $shoptype_info['shoptypeico']);
			if(!preg_match("/^".preg_quote(STATICURL, '/')."/i", $shoptypeico) && !(($valueparse = parse_url($shoptypeico)) && isset($valueparse['host']))) {
				$shoptypeico = $_G['setting']['attachurl'].'common/'.$shoptype_info['shoptypeico'].'?'.random(6);
			}
			$shoptypeicohtml = '<br /><label><input type="checkbox" class="checkbox" name="delete1" value="yes" /> '.$lang['del'].'</label><br /><img src="'.$shoptypeico.'" width="40" height="40"/>';
		}

		showtips(lang('plugin/yiqixueba_yikatong','shoptype_edit_tips'));
		showformheader($this_page.'&subac=shoptypeedit','enctype');
		showtableheader(lang('plugin/yiqixueba_yikatong','shoptype_edit'));
		$shoptypeid ? showhiddenfields($hiddenfields = array('shoptypeid'=>$shoptypeid)) : '';
		showsetting(lang('plugin/yiqixueba_yikatong','shoptypeico'),'shoptypeico',$shoptype_info['shoptypeico'],'filetext','','',lang('plugin/yiqixueba_yikatong','shoptypeico_comment').$shoptypeicohtml,'','',true);
		showsetting(lang('plugin/yiqixueba_yikatong','shoptypename'),'shoptype_info[shoptypename]',$shoptype_info['shoptypename'],'text','',0,lang('plugin/yiqixueba_yikatong','shoptypename_comment'),'','',true);
		showsetting(lang('plugin/yiqixueba_yikatong','inshoufei'),'shoptype_info[inshoufei]',$shoptype_info['inshoufei'],'text','',0,lang('plugin/yiqixueba_yikatong','inshoufei_comment'),'','',true);
		showsetting(lang('plugin/yiqixueba_yikatong','inshoufeiqixian'),'shoptype_info[inshoufeiqixian]',$shoptype_info['inshoufeiqixian'],'text','',0,lang('plugin/yiqixueba_yikatong','inshoufeiqixian_comment'),'','',true);
		showsetting(lang('plugin/yiqixueba_yikatong','shoptypedescription'),'shoptype_info[shoptypedescription]',$shoptype_info['shoptypedescription'],'textarea','',0,lang('plugin/yiqixueba_yikatong','shoptypedescription_comment'),'','',true);
		showsetting(lang('plugin/yiqixueba_yikatong','cardfeiyong'),'shoptype_info[cardfeiyong]',$shoptype_info['cardfeiyong'],'text','',0,lang('plugin/yiqixueba_yikatong','cardfeiyong_comment'),'','',true);
		showsetting(lang('plugin/yiqixueba_yikatong','cardpice'),'shoptype_info[cardpice]',$shoptype_info['cardpice'],'text','',0,lang('plugin/yiqixueba_yikatong','cardpice_comment'),'','',true);
		showsetting(lang('plugin/yiqixueba_yikatong','status'),'shoptype_info[status]',$shoptype_info['status'],'radio','',0,lang('plugin/yiqixueba_yikatong','status_comment'),'','',true);
		showsubmit('submit');
		showtablefooter();
		showformfooter();
	}else{
		if(!htmlspecialchars(trim($_GET['shoptype_info']['shoptypename']))) {
			cpmsg(lang('plugin/yiqixueba_yikatong','shoptypename_nonull'));
		}
		$shoptypeico = addslashes($_POST['shoptypeico']);
		if($_FILES['shoptypeico']) {
			$upload = new discuz_upload();
			if($upload->init($_FILES['shoptypeico'], 'common') && $upload->save()) {
				$shoptypeico = $upload->attach['attachment'];
			}
		}
		if($_POST['delete1'] && addslashes($_POST['shoptypeico'])) {
			$valueparse = parse_url(addslashes($_POST['shoptypeico']));
			if(!isset($valueparse['host']) && !strexists(addslashes($_POST['shoptypeico']), '{STATICURL}')) {
				@unlink($_G['setting']['attachurl'].'temp/'.addslashes($_POST['shoptypeico']));
			}
			$shoptypeico = '';
		}
		$datas = $_GET['shoptype_info'];
		$datas['shoptypeico'] = $shoptypeico;
		foreach ( $datas as $k=>$v) {
			$data[$k] = htmlspecialchars(trim($v));
			if(!DB::result_first("describe ".DB::table('yiqixueba_yikatong_shoptype')." ".$k)) {
				$sql = "alter table ".DB::table('yiqixueba_yikatong_shoptype')." add `".$k."` varchar(255) not Null;";
				runquery($sql);
			}
		}
		if($shoptypeid) {
			DB::update('yiqixueba_yikatong_shoptype',$data,array('shoptypeid'=>$shoptypeid));
		}else{
			DB::insert('yiqixueba_yikatong_shoptype',$data);
		}
		cpmsg(lang('plugin/yiqixueba_yikatong', 'shoptype_edit_succeed'), 'action='.$this_page.'&subac=shoptypelist', 'succeed');
	}
}
?>