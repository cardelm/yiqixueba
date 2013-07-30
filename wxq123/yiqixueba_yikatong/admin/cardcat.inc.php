<?php

/**
*	一起学吧平台程序
*	文件名：cardcat.inc.php  创建时间：2013-5-31 17:53  杨文
*
*/

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
$this_page = 'plugins&identifier=yiqixueba_yikatong&pmod=admin&submod=cardcat';


$subac = getgpc('subac');
$subacs = array('cardcatlist','cardcatedit','makecard');
$subac = in_array($subac,$subacs) ? $subac : $subacs[0];

$cardcatid = getgpc('cardcatid');
$cardcat_info = $cardcatid ? DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_yikatong_cardcat')." WHERE cardcatid=".$cardcatid) : array();

if($subac == 'cardcatlist') {
	if(!submitcheck('submit')) {
		showtips(lang('plugin/yiqixueba_yikatong','cardcat_list_tips'));
		showformheader($this_page.'&subac=cardcatlist');
		showtableheader(lang('plugin/yiqixueba_yikatong','cardcat_list'));
		showsubtitle(array('', lang('plugin/yiqixueba_yikatong','cardcatname'),lang('plugin/yiqixueba_yikatong','cardtype'), lang('plugin/yiqixueba_yikatong','cardcatdescription'), lang('plugin/yiqixueba_yikatong','status'), ''));
		$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_yikatong_cardcat')." order by cardcatid asc");
		while($row = DB::fetch($query)) {
			$cardcatico = '';
			if($row['cardcatico']!='') {
				$cardcatico = str_replace('{STATICURL}', STATICURL, $row['cardcatico']);
				if(!preg_match("/^".preg_quote(STATICURL, '/')."/i", $cardcatico) && !(($valueparse = parse_url($cardcatico)) && isset($valueparse['host']))) {
					$cardcatico = $_G['setting']['attachurl'].'common/'.$row['cardcatico'].'?'.random(6);
				}
				$cardcatico = '<img src="'.$cardcatico.'" width="40" height="40"/>';
			}else{
				$cardcatico = '';
			}
			showtablerow('', array('class="td25"','class="td23"', 'class="td23"', 'class="td23"','class="td25"',''), array(
				"<input class=\"checkbox\" type=\"checkbox\" name=\"delete[]\" value=\"$row[cardcatid]\">",
				$cardcatico.'<br />'.$row['cardcatname'],
				lang('plugin/yiqixueba_yikatong',$row['cardtype']),
				$row['cardcatdescription'],
				"<input class=\"checkbox\" type=\"checkbox\" name=\"statusnew[".$row['cardcatid']."]\" value=\"1\" ".($row['status'] > 0 ? 'checked' : '').">",
				"<a href=\"".ADMINSCRIPT."?action=".$this_page."&subac=cardcatedit&cardcatid=$row[cardcatid]\" class=\"act\">".lang('plugin/yiqixueba_yikatong','edit')."</a>&nbsp;&nbsp;<a href=\"".ADMINSCRIPT."?action=plugins&identifier=yiqixueba_yikatong&pmod=admin&submod=mkcard&cardcatid=$row[cardcatid]\" class=\"act\">".lang('plugin/yiqixueba_yikatong','makecard')."</a>",
			));
		}
		echo '<tr><td></td><td colspan="6"><div><a href="'.ADMINSCRIPT.'?action='.$this_page.'&subac=cardcatedit" class="addtr">'.lang('plugin/yiqixueba_yikatong','add_cardcat').'</a></div></td></tr>';
		showsubmit('submit','submit','del');
		showtablefooter();
		showformfooter();
	}else{
	}
}elseif($subac == 'cardcatedit') {
	if(!submitcheck('submit')) {
		if($cardcat_info['cardcatico']!='') {
			$cardcatico = str_replace('{STATICURL}', STATICURL, $cardcat_info['cardcatico']);
			if(!preg_match("/^".preg_quote(STATICURL, '/')."/i", $cardcatico) && !(($valueparse = parse_url($cardcatico)) && isset($valueparse['host']))) {
				$cardcatico = $_G['setting']['attachurl'].'common/'.$cardcat_info['cardcatico'].'?'.random(6);
			}
			$cardcaticohtml = '<br /><label><input type="checkbox" class="checkbox" name="delete1" value="yes" /> '.$lang['del'].'</label><br /><img src="'.$cardcatico.'" width="40" height="40"/>';
		}
		$cardtype_select = '<select name="cardcat_info[cardtype]"><option value="benwangka" '.($cardcat_info['cardtype'] == 'benwangka' ? ' selected': '').'>'.lang('plugin/yiqixueba_yikatong','benwangka').'</option><option value="quanwangka" '.($cardcat_info['cardtype'] == 'quanwangka' ? ' selected': '').'>'.lang('plugin/yiqixueba_yikatong','quanwangka').'</option><option value="xunika" '.($cardcat_info['cardtype'] == 'xunika' ? ' selected': '').'>'.lang('plugin/yiqixueba_yikatong','xunika').'</option></select>';
		showtips(lang('plugin/yiqixueba_yikatong','cardcat_edit_tips'));
		showformheader($this_page.'&subac=cardcatedit','enctype');
		showtableheader(lang('plugin/yiqixueba_yikatong','cardcat_edit'));
		$cardcatid ? showhiddenfields($hiddenfields = array('cardcatid'=>$cardcatid)) : '';
		showsetting(lang('plugin/yiqixueba_yikatong','cardcatico'),'cardcatico',$cardcat_info['cardcatico'],'filetext','','',lang('plugin/yiqixueba_yikatong','cardcatico_comment').$cardcaticohtml,'','',true);
		showsetting(lang('plugin/yiqixueba_yikatong','cardcatname'),'cardcat_info[cardcatname]',$cardcat_info['cardcatname'],'text','',0,lang('plugin/yiqixueba_yikatong','cardcatname_comment'),'','',true);
		showsetting(lang('plugin/yiqixueba_yikatong','cardcatdescription'),'cardcat_info[cardcatdescription]',$cardcat_info['cardcatdescription'],'textarea','',0,lang('plugin/yiqixueba_yikatong','cardcatdescription_comment'),'','',true);
		showsetting(lang('plugin/yiqixueba_yikatong','cardtype'),'','',$cardtype_select,'',0,lang('plugin/yiqixueba_yikatong','cardtype_comment'),'','',true);
		showsetting(lang('plugin/yiqixueba_yikatong','cardpice'),'cardcat_info[cardpice]',$cardcat_info['cardpice'],'text','',0,lang('plugin/yiqixueba_yikatong','cardpice_comment'),'','',true);
		showsetting(lang('plugin/yiqixueba_yikatong','status'),'cardcat_info[status]',$cardcat_info['status'],'radio','',0,lang('plugin/yiqixueba_yikatong','status_comment'),'','',true);
		showsubmit('submit');
		showtablefooter();
		showformfooter();
	}else{
		if(!htmlspecialchars(trim($_GET['cardcat_info']['cardcatname']))) {
			cpmsg(lang('plugin/yiqixueba_yikatong','cardcatname_nonull'));
		}
		$cardcatico = addslashes($_POST['cardcatico']);
		if($_FILES['cardcatico']) {
			$upload = new discuz_upload();
			if($upload->init($_FILES['cardcatico'], 'common') && $upload->save()) {
				$cardcatico = $upload->attach['attachment'];
			}
		}
		if($_POST['delete1'] && addslashes($_POST['cardcatico'])) {
			$valueparse = parse_url(addslashes($_POST['cardcatico']));
			if(!isset($valueparse['host']) && !strexists(addslashes($_POST['cardcatico']), '{STATICURL}')) {
				@unlink($_G['setting']['attachurl'].'temp/'.addslashes($_POST['cardcatico']));
			}
			$cardcatico = '';
		}
		$datas = $_GET['cardcat_info'];
		$datas['cardcatico'] = $cardcatico;
		foreach ( $datas as $k=>$v) {
			$data[$k] = htmlspecialchars(trim($v));
			if(!DB::result_first("describe ".DB::table('yiqixueba_yikatong_cardcat')." ".$k)) {
				$sql = "alter table ".DB::table('yiqixueba_yikatong_cardcat')." add `".$k."` varchar(255) not Null;";
				runquery($sql);
			}
		}
		if($cardcatid) {
			DB::update('yiqixueba_yikatong_cardcat',$data,array('cardcatid'=>$cardcatid));
		}else{
			DB::insert('yiqixueba_yikatong_cardcat',$data);
		}
		cpmsg(lang('plugin/yiqixueba_yikatong', 'cardcat_edit_succeed'), 'action='.$this_page.'&subac=cardcatlist', 'succeed');
	}
}
?>