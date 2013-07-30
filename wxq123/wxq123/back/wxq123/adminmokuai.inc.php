<?php


if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

require_once DISCUZ_ROOT.'source/plugin/wxq123/source/function/function_admin.php';
$subop = addslashes(getgpc('subop'));
$subops = array('mokuailist','mokuaisetting','mokuaiopen','mokuaiclose','mokuaiinstall','mokuaiupgrade','mokuaiuninstall');
$subop = in_array($subop,$subops) ? $subop : $subops[0];

if($subop == 'mokuailist'){
	if(!submitcheck('submit')) {
		$mokuai_list_info = get_server_data('mokuailistinfo');
		$mokuai_list_info['tips'] ?	showtips($mokuai_list_info['tips']) : showtips(lang('plugin/wxq123','mokuai_list_tips'));
		showformheader("plugins&identifier=wxq123&pmod=adminmokuai&subop=mokuailist");
		showtableheader(lang('plugin/wxq123','mokuai_list'));
		showsubtitle(array(lang('plugin/wxq123','displayorder'),lang('plugin/wxq123','mokuaiico'), lang('plugin/wxq123','mokuaititle'), lang('plugin/wxq123','mokuaipice'),lang('plugin/wxq123','validity'),lang('plugin/wxq123','description'),lang('plugin/wxq123','stauts'), ''));
		foreach ($mokuai_list_info['mokuais'] as $k=>$v){
			$optiontext = '';
			if ($v['status']==0){
				$optiontext = "<a href=\"".ADMINSCRIPT."?action=plugins&identifier=wxq123&pmod=adminmokuai&subop=adminmokuai&mokuaiid=$v[mokuaiid]\" class=\"act\">".lang('plugin/wxq123','mokuaibuy')."</a>";
			}else{
				if (DB::result_first("SELECT count(*) FROM ".DB::table('wxq123_mokuai')." WHERE mokuainame = '".$v['mokuainame']."'")==0){
					$optiontext = "<a href=\"".ADMINSCRIPT."?action=plugins&identifier=wxq123&pmod=adminmokuai&subop=mokuaiinstall&mokuaiid=$v[mokuaiid]\" class=\"act\">".lang('plugin/wxq123','install')."</a>";
				}else{
					$optiontext = "<a href=\"".ADMINSCRIPT."?action=plugins&identifier=wxq123&pmod=adminmokuai&subop=mokuaisetting&mokuaiid=$v[mokuaiid]\" class=\"act\">".lang('plugin/wxq123','setting')."</a>";
				}
			}

			showtablerow('', array('class="td25"','class="td25"', 'class="td23"', 'class="td25"','class="td23"','class="td29"', 'class="td25"',''), array(
				'<input type="text" class="txt" name="displayordernew['.$v['mokuaiid'].']" value="'.intval($v['displayorder']).'" size="2" />',
				'<img src="'.$v['mokuaiico'].'" width="40" height="40" />',
				$v['mokuaititle'].'('.$v['mokuainame'].')',
				$v['mokuaipice'],
				$v['validity'],
				$v['mokuaidescription'],
				'',
				$optiontext,
			));
		}
		showtablefooter();
		showformfooter();
	}else{
		var_dump($_GET);
	}
}elseif($subop == 'mokuaisetting'){
	if(!submitcheck('submit')) {
		showtips(lang('plugin/wxq123','wxq123_setting_tips'));
		showformheader("plugins&identifier=wxq123&pmod=adminmokuai&subop=mokuaisetting",'enctype');
		showtableheader($goodsid ? lang('plugin/wxq123','goods_edit') : lang('plugin/wxq123','goods_add'));
		showsetting(lang('plugin/wxq123','isweb'),'isweb',$wxq123_setting['isweb'],'radio','',0,lang('plugin/wxq123','isweb_comment'),'','',true);
		showsetting(lang('plugin/wxq123','goodsname'),'goodsname',$wxq123_setting['goodsname'],'text','',0,lang('plugin/wxq123','goodsname_comment'),'','',true);
		showsubmit('submit');
		showtablefooter();
		showformfooter();
	}else{
		var_dump($_GET);
	}
}elseif($subop == 'mokuaiopen'){
}elseif($subop == 'mokuaiclose'){
}elseif($subop == 'mokuaiinstall'){
	var_dump($_GET);
}elseif($subop == 'mokuaiupgrade'){
}elseif($subop == 'mokuaiuninstall'){
}
?>