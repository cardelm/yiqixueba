<?php
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit();
}

$subcp = getgpc('subcp');
$subcps = array('shoplist','shopedit');
$subcp = in_array($subcp,$subcps) ? $subcp : $subcps[0];

$shopid = getgpc('shopid');
//$shop_info = $shopid ? DB::fetch_first("SELECT * FROM ".DB::table('wxq123_server_mokuai')." WHERE shopid=".$shopid) : array();

if($subcp == 'shoplist') {
	if(!submitcheck('submit')) {
		showtips($mokuailang['shop_list_tips']);
		showformheader($basepage.'&subcp=shoplist');
		showtableheader($mokuailang['shop_list']);
		showsubtitle(array('', $mokuailang['displayorder'],$mokuailang['shopname'], $mokuailang['shoptype'], $mokuailang['shopcat'], $mokuailang['shopsbm'],$mokuailang['shopcat'], $mokuailang['shopcat'],$mokuailang['status'], ''));
		echo '<tr><td></td><td colspan="8"><div><a href="'.ADMINSCRIPT.'?action='.$basepage.'&subcp=shopedit" class="addtr">'.$mokuailang['add_shop'].'</a></div></td></tr>';
		showsubmit('submit','submit','del');
		showtablefooter();
		showformfooter();
	}else{
	}
}elseif($subcp == 'shopedit') {
	if(!submitcheck('submit')) {
		showtips($mokuailang['shop_edit_tips']);
		showformheader($basepage.'&subcp=shopedit');
		showtableheader($mokuailang['shop_edit']);
		showsetting($mokuailang['shopname'],'shopname',$shop_info['shopname'],'text','',0,$mokuailang['shopname_comment'],'','',true);
		showsetting($mokuailang['shopname'],'shopname',$shop_info['shopname'],'text','',0,$mokuailang['shopname_comment'],'','',true);
		showsubmit('submit');
		showtablefooter();
		showformfooter();
	}else{
	}
}
?>