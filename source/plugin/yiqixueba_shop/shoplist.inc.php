<?php

/**
*	商家展示-商家管理程序
*	文件名：shoplist.inc.php 创建时间：2013-7-24 11:37  杨文
*
*/

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

require_once DISCUZ_ROOT.'source/plugin/yiqixueba_shop/function.func.php';

$this_page = substr($_SERVER['QUERY_STRING'],7,strlen($_SERVER['QUERY_STRING'])-7);
stripos($this_page,'subac=') ? $this_page = substr($this_page,0,stripos($this_page,'subac=')-1) : $this_page;

$subac = getgpc('subac');
$subacs = array('shoplistlist','shoplistedit');
$subac = in_array($subac,$subacs) ? $subac : $subacs[0];

$shoplistid = getgpc('shoplistid');
$shoplist_info = $shoplistid ? DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_shop_shoplist')." WHERE shoplistid=".$shoplistid) : array();

if($subac == 'shoplistlist') {
	if(!submitcheck('submit')) {
		showtips(lang('plugin/yiqixueba_shop','shoplist_list_tips'));
		showformheader($this_page.'&subac=shoplistlist');
		showtableheader(lang('plugin/yiqixueba_shop','shoplist_list'));
		showsubtitle(array('', lang('plugin/yiqixueba_shop','ico'),lang('plugin/yiqixueba_shop','shoplistname'), lang('plugin/yiqixueba_shop','displayorder'), lang('plugin/yiqixueba_shop','status'), ''));
		$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_shop_shoplist')." order by displayorder asc");
		while($row = DB::fetch($query)) {
			$shoplistico = '';
			if($row['shoplistico']!='') {
				$shoplistico = str_replace('{STATICURL}', STATICURL, $row['shoplistico']);
				if(!preg_match("/^".preg_quote(STATICURL, '/')."/i", $shoplistico) && !(($valueparse = parse_url($shoplistico)) && isset($valueparse['host']))) {
					$shoplistico = $_G['setting']['attachurl'].'common/'.$row['shoplistico'].'?'.random(6);
				}
			}
			showtablerow('', array('class="td25"','style="width:45px"', 'class="td23"', 'class="td28"'), array(
				"<input class=\"checkbox\" type=\"checkbox\" name=\"delete[]\" value=\"$row[shoplistid]\">",
				$shoplistico ?'<img src="'.$shoplistico.'" width="40" height="40" align="left" style="margin-right:5px" />' : '',
				$row['shoplistname'],
				"<input type=\"text\" name=\"displayordernew[".$row['shoplistid']."]\" value=\"".$row['displayorder']."\"  size=\"2\">",
				"<input class=\"checkbox\" type=\"checkbox\" name=\"statusnew[".$row['shoplistid']."]\" value=\"1\" ".($row['status'] > 0 ? 'checked' : '').">",
				"<a href=\"".ADMINSCRIPT."?action=".$this_page."&subac=shoplistedit&shoplistid=$row[shoplistid]\" class=\"act\">".lang('plugin/yiqixueba_shop','edit')."</a>",
			));
		}
	echo '<tr><td></td><td colspan="6"><div><a href="'.ADMINSCRIPT.'?action='.$this_page.'&subac=shoplistedit" class="addtr">'.lang('plugin/yiqixueba_shop','add_shoplist').'</a></div></td></tr>';
	showsubmit('submit','submit','del');
	showtablefooter();
	showformfooter();
	}else{
	}
}elseif($subac == 'shoplistedit') {
	if(!submitcheck('submit')) {
		if($shoplist_info['shoplistico']!='') {
			$shoplistico = str_replace('{STATICURL}', STATICURL, $shoplist_info['shoplistico']);
			if(!preg_match("/^".preg_quote(STATICURL, '/')."/i", $shoplistico) && !(($valueparse = parse_url($shoplistico)) && isset($valueparse['host']))) {
				$shoplistico = $_G['setting']['attachurl'].'common/'.$shoplist_info['shoplistico'].'?'.random(6);
				$shoplisticohtml = '<br /><label><input type="checkbox" class="checkbox" name="delete1" value="yes" /> '.$lang['del'].'</label><br /><img src="'.$shoplistico.'" width="40" height="40"/>';
			}
		}
		showtips(lang('plugin/yiqixueba_shop','shoplist_edit_tips'));
		showformheader($this_page.'&subac=shoplistedit','enctype');
		showtableheader(lang('plugin/yiqixueba_shop','shoplist_edit'));
		$shoplistid ? showhiddenfields(array('shoplistid'=>$shoplistid)) : '';
		showsetting(lang('plugin/yiqixueba_shop','shoplistico'),'shoplistico',$shoplist_info['shoplistico'],'filetext','',0,lang('plugin/yiqixueba_shop','shoplistico_comment').$shoplisticohtml,'','',true);
		showsetting(lang('plugin/yiqixueba_shop','shoplistname'),'shoplist_info[shoplistname]',$shoplist_info['shoplistname'],'text','',0,lang('plugin/yiqixueba_shop','shoplistname_comment'),'','',true);
		showsubmit('submit');
		showtablefooter();
		showformfooter();
	}else{
		if(!htmlspecialchars(trim($_GET['shoplist_info']['shoplistname']))) {
			cpmsg(lang('plugin/yiqixueba_shop','shoplistname_nonull'));
		}
		$shoplistico = addslashes($_POST['shoplistico']);
		if($_FILES['shoplistico']) {
			$upload = new discuz_upload();
			if($upload->init($_FILES['shoplistico'], 'common') && $upload->save()) {
				$shoplistico = $upload->attach['attachment'];
			}
		}
		if($_POST['delete1'] && addslashes($_POST['shoplistico'])) {
			$valueparse = parse_url(addslashes($_POST['shoplistico']));
			if(!isset($valueparse['host']) && !strexists(addslashes($_POST['shoplistico']), '{STATICURL}')) {
				@unlink($_G['setting']['attachurl'].'temp/'.addslashes($_POST['shoplistico']));
			}
			$shoplistico = '';
		}
		$datas = $_GET['shoplist_info'];
		$datas['shoplistico'] = $shoplistico;
		foreach ( $datas as $k=>$v) {
			$data[$k] = htmlspecialchars(trim($v));
			if(!DB::result_first("describe ".DB::table('yiqixueba_shop_shoplist')." ".$k)) {
				$sql = "alter table ".DB::table('yiqixueba_shop_shoplist')." add `".$k."` varchar(255) not Null;";
				runquery($sql);
			}
		}
		if($shoplistid) {
			DB::update('yiqixueba_shop_shoplist',$data,array('shoplistid'=>$shoplistid));
		}else{
			DB::insert('yiqixueba_shop_shoplist',$data);
		}
		cpmsg(lang('plugin/yiqixueba_shop', 'shoplist_edit_succeed'), 'action='.$this_page.'&subac=shoplistlist', 'succeed');
	}
	
}
?>