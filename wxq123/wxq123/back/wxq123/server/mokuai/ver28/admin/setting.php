<?php
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit();
}

if(!submitcheck('submit')) {
	$query = DB::query("SELECT * FROM ".DB::table('wxq123_'.$mokuainame.'_setting'));
	while($row = DB::fetch($query)) {
		$tuangou_setting[$row['skey']] = $row['svalue'];
	}

	$mokuaitype = 0 ;
	showtips($mokuailang['tuangou_setting_tips']);
	showformheader($basepage);
	showtableheader($mokuailang['tuangou_setting']);
	showsetting($mokuailang['mokuai_type'], array('mokuaitype', array(
		array(0, $mokuailang['mokuai_system'], array('system' => '','zidingyi' => 'none')),
		array(1, $mokuailang['mokuai_zidingyi'], array('system' => 'none','zidingyi' => '')),
	)), $mokuaitype, 'mradio','',0,$mokuailang['mokuaitype_comment'],'','',true);
	showtagheader('tbody', 'system', $mokuaitype == 0, 'sub');
		showsetting($mokuailang['tuangoucat'],'tuangoucat',$tuangou_setting['tuangoucat'],'textarea','',0,$mokuailang['system_tuangoucat_comment'],'','',true);
	showtagfooter('tbody');
	showtagheader('tbody', 'zidingyi', $mokuaitype == 1, 'sub');
		showsetting($mokuailang['tuangoulink'],'tuangoulink',$tuangou_setting['tuangoulink'],'text','',0,$mokuailang['tuangoulink_setting_comment'],'','',true);
		showsetting($mokuailang['tuangoucatlink'],'tuangoucatlink',$tuangou_setting['tuangoucatlink'],'text','',0,$mokuailang['tuangoucatlink_setting_comment'],'','',true);
		showsetting($mokuailang['tuangoucat'],'tuangoucat',$tuangou_setting['tuangoucat'],'textarea','',0,$mokuailang['zidingyi_tuangoucat_comment'],'','',true);
		showsetting($mokuailang['shoplist'],'shoplist',$tuangou_setting['shoplist'],'text','',0,$mokuailang['zidingyi_shoplist_comment'],'','',true);
		showsetting($mokuailang['goodslist'],'goodslist',$tuangou_setting['goodslist'],'text','',0,$mokuailang['zidingyi_goodslist_comment'],'','',true);
	showtagfooter('tbody');
	showsubmit('submit');
	showtablefooter();
	showformfooter();
}else{
	if (intval($_GET['mokuaitype'] == 0)){
	}else{
	}
	//var_dump($_GET['mokuaitype']);
}

?>