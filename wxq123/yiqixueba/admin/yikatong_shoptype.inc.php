<?php

/**
*	一起学吧平台程序
*	文件名：yikatong_shopgroup.inc.php  创建时间：2013-6-4 09:37  杨文
*
*/

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
$this_page = 'plugins&identifier=yiqixueba&pmod=admin&submod=yikatong_shopgroup';

$subac = getgpc('subac');
$subacs = array('shopgrouplist','shopgroupedit');
$subac = in_array($subac,$subacs) ? $subac : $subacs[0];

$shopgroupid = getgpc('shopgroupid');
$shopgroup_info = $shopgroupid ? DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_yikatong_shopgroup')." WHERE shopgroupid=".$shopgroupid) : array();

if($subac == 'shopgrouplist') {
	if(!submitcheck('submit')) {
		showtips(lang('plugin/yiqixueba','shopgroup_list_tips'));
		showformheader($this_page.'&subac=shopgrouplist');
		showtableheader(lang('plugin/yiqixueba','shopgroup_list'));
		showsubtitle(array('', lang('plugin/yiqixueba','shopgroupname'),lang('plugin/yiqixueba','shopnum'), lang('plugin/yiqixueba','shopgroupquanxian'), lang('plugin/yiqixueba','status'), ''));
		$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_yikatong_shopgroup')." order by shopgroupid asc");
		while($row = DB::fetch($query)) {
			$shopgroupico = '';
			if($row['shopgroupico']!='') {
				$shopgroupico = str_replace('{STATICURL}', STATICURL, $row['shopgroupico']);
				if(!preg_match("/^".preg_quote(STATICURL, '/')."/i", $shopgroupico) && !(($valueparse = parse_url($shopgroupico)) && isset($valueparse['host']))) {
					$shopgroupico = $_G['setting']['attachurl'].'common/'.$row['shopgroupico'].'?'.random(6);
				}
				$shopgroupico = '<img src="'.$shopgroupico.'" width="40" height="40"/>';
			}else{
				$shopgroupico = '';
			}
			showtablerow('', array('class="td25"','class="td23"', 'class="td25"', 'class="td28"','class="td25"',''), array(
				"<input class=\"checkbox\" type=\"checkbox\" name=\"delete[]\" value=\"$row[shopgroupid]\">",
				$shopgroupico.$row['shopgroupname'],
				$row['shopgrouppice'],
				lang('plugin/yiqixueba','inshoufei').':'.$row['inshoufei'].'&nbsp;&nbsp;'.lang('plugin/yiqixueba','inshoufeiqixian').':'.$row['inshoufeiqixian'].'&nbsp;&nbsp;'.lang('plugin/yiqixueba','cardfeiyong').':'.$row['cardfeiyong'].'&nbsp;&nbsp;'.lang('plugin/yiqixueba','cardpice').':'.$row['cardpice'],
				"<input class=\"checkbox\" type=\"checkbox\" name=\"statusnew[".$row['shopgroupid']."]\" value=\"1\" ".($row['status'] > 0 ? 'checked' : '').">",
				"<a href=\"".ADMINSCRIPT."?action=".$this_page."&subac=shopgroupedit&shopgroupid=$row[shopgroupid]\" class=\"act\">".lang('plugin/yiqixueba','edit')."</a>",
			));
		}
		echo '<tr><td></td><td colspan="6"><div><a href="'.ADMINSCRIPT.'?action='.$this_page.'&subac=shopgroupedit" class="addtr">'.lang('plugin/yiqixueba','add_shopgroup').'</a></div></td></tr>';
		showsubmit('submit','submit','del');
		showtablefooter();
		showformfooter();
	}else{
	}
}elseif($subac == 'shopgroupedit') {
	if(!submitcheck('submit')) {
		if($shopgroup_info['shopgroupico']!='') {
			$shopgroupico = str_replace('{STATICURL}', STATICURL, $shopgroup_info['shopgroupico']);
			if(!preg_match("/^".preg_quote(STATICURL, '/')."/i", $shopgroupico) && !(($valueparse = parse_url($shopgroupico)) && isset($valueparse['host']))) {
				$shopgroupico = $_G['setting']['attachurl'].'common/'.$shopgroup_info['shopgroupico'].'?'.random(6);
			}
			$shopgroupicohtml = '<br /><label><input type="checkbox" class="checkbox" name="delete1" value="yes" /> '.$lang['del'].'</label><br /><img src="'.$shopgroupico.'" width="40" height="40"/>';
		}

		showtips(lang('plugin/yiqixueba','shopgroup_edit_tips'));
		showformheader($this_page.'&subac=shopgroupedit','enctype');

		showtableheader(lang('plugin/yiqixueba','shopgroup_edit'));

		$shopgroupid ? showhiddenfields($hiddenfields = array('shopgroupid'=>$shopgroupid)) : '';

		showsetting(lang('plugin/yiqixueba','shopgroupico'),'shopgroupico',$shopgroup_info['shopgroupico'],'filetext','','',lang('plugin/yiqixueba','shopgroupico_comment').$shopgroupicohtml,'','',true);

		showsetting(lang('plugin/yiqixueba','shopgroupname'),'shopgroup_info[shopgroupname]',$shopgroup_info['shopgroupname'],'text','',0,lang('plugin/yiqixueba','shopgroupname_comment'),'','',true);

		showsetting(lang('plugin/yiqixueba','shopgroupdescription'),'shopgroup_info[shopgroupdescription]',$shopgroup_info['shopgroupdescription'],'textarea','',0,lang('plugin/yiqixueba','shopgroupdescription_comment'),'','',true);

		showsetting(lang('plugin/yiqixueba','inshoufei'),'shopgroup_info[inshoufei]',$shopgroup_info['inshoufei'],'text','',0,lang('plugin/yiqixueba','inshoufei_comment'),'','',true);

		showsetting(lang('plugin/yiqixueba','inshoufeiqixian'),'shopgroup_info[inshoufeiqixian]',$shopgroup_info['inshoufeiqixian'],'text','',0,lang('plugin/yiqixueba','inshoufeiqixian_comment'),'','',true);

		showsetting(lang('plugin/yiqixueba','cardfeiyong'),'shopgroup_info[cardfeiyong]',$shopgroup_info['cardfeiyong'],'text','',0,lang('plugin/yiqixueba','cardfeiyong_comment'),'','',true);

		showsetting(lang('plugin/yiqixueba','cardpice'),'shopgroup_info[cardpice]',$shopgroup_info['cardpice'],'text','',0,lang('plugin/yiqixueba','cardpice_comment'),'','',true);

		//可以使用的商品类型
		$goods = dunserialize($shopgroup_info['goods']);
		$goods_array = array();
		$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_mokuai')." where upmokuai = 'yikatong'");
		while($row = DB::fetch($query)) {
			$goods_array[] = array($row['mokuaiid'],$row['mokuaititle']);
		}
		showsetting(lang('plugin/yiqixueba','engoodstype'), array('goods', $goods_array), $goods, 'mcheckbox','',0,lang('plugin/yiqixueba','engoodstype_comment'),'','',true);

		showsetting(lang('plugin/yiqixueba','status'),'shopgroup_info[status]',$shopgroup_info['status'],'radio','',0,lang('plugin/yiqixueba','status_comment'),'','',true);

		showsubmit('submit');
		showtablefooter();
		showformfooter();
	}else{
		if(!htmlspecialchars(trim($_GET['shopgroup_info']['shopgroupname']))) {
			cpmsg(lang('plugin/yiqixueba','shopgroupname_nonull'));
		}
		$shopgroupico = addslashes($_POST['shopgroupico']);
		if($_FILES['shopgroupico']) {
			$upload = new discuz_upload();
			if($upload->init($_FILES['shopgroupico'], 'common') && $upload->save()) {
				$shopgroupico = $upload->attach['attachment'];
			}
		}
		if($_POST['delete1'] && addslashes($_POST['shopgroupico'])) {
			$valueparse = parse_url(addslashes($_POST['shopgroupico']));
			if(!isset($valueparse['host']) && !strexists(addslashes($_POST['shopgroupico']), '{STATICURL}')) {
				@unlink($_G['setting']['attachurl'].'temp/'.addslashes($_POST['shopgroupico']));
			}
			$shopgroupico = '';
		}
		$data = array();
		$datas = $_GET['shopgroup_info'];
		$datas['shopgroupico'] = $shopgroupico;
		$datas['goods'] = serialize($_GET['goods']);;
		foreach ( $datas as $k=>$v) {
			if($k=='goods'){
				$data[$k] = trim($v);
			}else{
				$data[$k] = htmlspecialchars(trim($v));
			}
			if(!DB::result_first("describe ".DB::table('yiqixueba_yikatong_shopgroup')." ".$k)) {
				$sql = "alter table ".DB::table('yiqixueba_yikatong_shopgroup')." add `".$k."` varchar(255) not Null;";
				runquery($sql);
			}
		}
		if($shopgroupid) {
			DB::update('yiqixueba_yikatong_shopgroup',$data,array('shopgroupid'=>$shopgroupid));
		}else{
			DB::insert('yiqixueba_yikatong_shopgroup',$data);
		}
		cpmsg(lang('plugin/yiqixueba', 'shopgroup_edit_succeed'), 'action='.$this_page.'&subac=shopgrouplist', 'succeed');
	}
}
?>