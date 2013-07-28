<?php

/**
*	
*	文件名：shop.inc.php 创建时间：2013-7-26 23:31  杨文
*	修改时间：2013-7-26 23:31 杨文
*/


/**
*	商家展示-商家管理程序
*	文件名：shop.inc.php 创建时间：2013-7-26 23:28  杨文
*
*/

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

require_once DISCUZ_ROOT.'source/plugin/yiqixueba_shop/function.func.php';

$this_page = substr($_SERVER['QUERY_STRING'],7,strlen($_SERVER['QUERY_STRING'])-7);
stripos($this_page,'subac=') ? $this_page = substr($this_page,0,stripos($this_page,'subac=')-1) : $this_page;

$subac = getgpc('subac');
$subacs = array('shoplist','shopedit');
$subac = in_array($subac,$subacs) ? $subac : $subacs[0];

$shopid = getgpc('shopid');
$shop_info = $shopid ? DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_shop_shop')." WHERE shopid=".$shopid) : array();

if($subac == 'shoplist') {
	if(!submitcheck('submit')) {
		showtips(lang('plugin/yiqixueba_shop','shop_list_tips'));
		showformheader($this_page.'&subac=shoplist');
		showtableheader(lang('plugin/yiqixueba_shop','shop_list'));
		showsubtitle(array('', lang('plugin/yiqixueba_shop','ico'),lang('plugin/yiqixueba_shop','shopname'), lang('plugin/yiqixueba_shop','displayorder'), lang('plugin/yiqixueba_shop','status'), ''));
		$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_shop_shop')." order by displayorder asc");
		while($row = DB::fetch($query)) {
			$shopico = '';
			if($row['shopico']!='') {
				$shopico = str_replace('{STATICURL}', STATICURL, $row['shopico']);
				if(!preg_match("/^".preg_quote(STATICURL, '/')."/i", $shopico) && !(($valueparse = parse_url($shopico)) && isset($valueparse['host']))) {
					$shopico = $_G['setting']['attachurl'].'common/'.$row['shopico'].'?'.random(6);
				}
			}
			showtablerow('', array('class="td25"','style="width:45px"', 'class="td23"', 'class="td28"'), array(
				"<input class=\"checkbox\" type=\"checkbox\" name=\"delete[]\" value=\"$row[shopid]\">",
				$shopico ?'<img src="'.$shopico.'" width="40" height="40" align="left" style="margin-right:5px" />' : '',
				$row['shopname'],
				"<input type=\"text\" name=\"displayordernew[".$row['shopid']."]\" value=\"".$row['displayorder']."\"  size=\"2\">",
				"<input class=\"checkbox\" type=\"checkbox\" name=\"statusnew[".$row['shopid']."]\" value=\"1\" ".($row['status'] > 0 ? 'checked' : '').">",
				"<a href=\"".ADMINSCRIPT."?action=".$this_page."&subac=shopedit&shopid=$row[shopid]\" class=\"act\">".lang('plugin/yiqixueba_shop','edit')."</a>",
			));
		}
	echo '<tr><td></td><td colspan="6"><div><a href="'.ADMINSCRIPT.'?action='.$this_page.'&subac=shopedit" class="addtr">'.lang('plugin/yiqixueba_shop','add_shop').'</a></div></td></tr>';
	showsubmit('submit','submit','del');
	showtablefooter();
	showformfooter();
	}else{
	}
}elseif($subac == 'shopedit') {
	if(!submitcheck('submit')) {
		if($shop_info['shopico']!='') {
			$shopico = str_replace('{STATICURL}', STATICURL, $shop_info['shopico']);
			if(!preg_match("/^".preg_quote(STATICURL, '/')."/i", $shopico) && !(($valueparse = parse_url($shopico)) && isset($valueparse['host']))) {
				$shopico = $_G['setting']['attachurl'].'common/'.$shop_info['shopico'].'?'.random(6);
				$shopicohtml = '<br /><label><input type="checkbox" class="checkbox" name="delete1" value="yes" /> '.$lang['del'].'</label><br /><img src="'.$shopico.'" width="40" height="40"/>';
			}
		}
		showtips(lang('plugin/yiqixueba_shop','shop_edit_tips'));
		showformheader($this_page.'&subac=shopedit','enctype');
		showtableheader(lang('plugin/yiqixueba_shop','shop_edit'));
		$shopid ? showhiddenfields(array('shopid'=>$shopid)) : '';
		showsetting(lang('plugin/yiqixueba_shop','shopico'),'shopico',$shop_info['shopico'],'filetext','',0,lang('plugin/yiqixueba_shop','shopico_comment').$shopicohtml,'','',true);
		showsetting(lang('plugin/yiqixueba_shop','shopname'),'shop_info[shopname]',$shop_info['shopname'],'text','',0,lang('plugin/yiqixueba_shop','shopname_comment'),'','',true);
		showsubmit('submit');
		showtablefooter();
		showformfooter();
	}else{
		if(!htmlspecialchars(trim($_GET['shop_info']['shopname']))) {
			cpmsg(lang('plugin/yiqixueba_shop','shopname_nonull'));
		}
		$shopico = addslashes($_POST['shopico']);
		if($_FILES['shopico']) {
			$upload = new discuz_upload();
			if($upload->init($_FILES['shopico'], 'common') && $upload->save()) {
				$shopico = $upload->attach['attachment'];
			}
		}
		if($_POST['delete1'] && addslashes($_POST['shopico'])) {
			$valueparse = parse_url(addslashes($_POST['shopico']));
			if(!isset($valueparse['host']) && !strexists(addslashes($_POST['shopico']), '{STATICURL}')) {
				@unlink($_G['setting']['attachurl'].'temp/'.addslashes($_POST['shopico']));
			}
			$shopico = '';
		}
		$datas = $_GET['shop_info'];
		$datas['shopico'] = $shopico;
		foreach ( $datas as $k=>$v) {
			$data[$k] = htmlspecialchars(trim($v));
			if(!DB::result_first("describe ".DB::table('yiqixueba_shop_shop')." ".$k)) {
				$sql = "alter table ".DB::table('yiqixueba_shop_shop')." add `".$k."` varchar(255) not Null;";
				runquery($sql);
			}
		}
		if($shopid) {
			DB::update('yiqixueba_shop_shop',$data,array('shopid'=>$shopid));
		}else{
			DB::insert('yiqixueba_shop_shop',$data);
		}
		cpmsg(lang('plugin/yiqixueba_shop', 'shop_edit_succeed'), 'action='.$this_page.'&subac=shoplist', 'succeed');
	}
	
}
?>