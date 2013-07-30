<?php

/**
*	一起学吧平台程序
*	文件名：wxq_wxqshopset.inc.php  创建时间：2013-6-4 09:37  杨文
*
*/

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
$this_page = 'plugins&identifier=yiqixueba&pmod=admin&submod=wxqshopset';

$shopsetting = dunserialize(DB::result_first("SELECT svalue FROM ".DB::table('yiqixueba_wxq123_setting')." WHERE skey='shopsetting'"));

if(!$shopsetting) {
	$shopsetting = array(
		array(
			'wxqfield' => 'shopid',
			'tablename' => '' ,
			'fieldname' => '' ,
		),
		array(
			'wxqfield' => 'shopname',
			'tablename' => '' ,
			'fieldname' => '' ,
		),
		array(
			'wxqfield' => 'diliweizhi',
			'tablename' => '' ,
			'fieldname' => '' ,
		),
	);
}


if(!submitcheck('submit')) {
	showtips(lang('plugin/yiqixueba','wxqshopset_list_tips'));
	showformheader($this_page.'&subac=wxqshopsetlist');
	showtableheader(lang('plugin/yiqixueba','wxqshopset_list'));
	showsubtitle(array('', lang('plugin/yiqixueba','wxqfield'),lang('plugin/yiqixueba','tablename'), lang('plugin/yiqixueba','fieldname')));
	foreach ( $shopsetting as $k=>$v) {
		showtablerow('', array('class="td25"','class="td28"', 'class="td28"','class="td28"'), array(
		in_array($v['wxqfield'],array('shopid','shopname','diliweizhi')) ? '': "<input class=\"checkbox\" type=\"checkbox\" name=\"delete[]\" value=\"$v[wxqshopsetid]\">",
		in_array($v['wxqfield'],array('shopid','shopname','diliweizhi')) ? '<input type="hidden" name="wxqfield[]" value="'.$v['wxqfield'].'">'.lang('plugin/yiqixueba',$v['wxqfield']):'<input type="text" name="wxqfield[]" value="'.$v['wxqfield'].'">',
		'<input type="text" name="tablename[]" value="'.$v['tablename'].'">',
		'<input type="text" name="fieldname[]" value="'.$v['fieldname'].'">',
		));
	}
	echo '<tr><td></td><td colspan="3"><div><a href="###" onclick="addrow(this, 0)" class="addtr">'.lang('plugin/yiqixueba','add_shopsort').'</a></div></td></tr>';
	echo <<<EOT
	<script type="text/JavaScript">
		var rowtypedata = [
			[
				[1, '', 'td25'],
				[1, '<input type="text" name="wxqfield[]" value="">', 'td28'],
				[1, '<input type="text" name="tablename[]" value="">', 'td28'],
				[1, '<input type="text" name="fieldname[]" value="">', 'td28'],
			],
		];
	</script>
EOT;
	showsubmit('submit','submit','del');
	showtablefooter();
	showformfooter();
}else{
	$wxqfields = $_GET['wxqfield'];
	if(is_array($wxqfields)) {
		foreach ( $wxqfields as $k=>$v) {
			$data[$k]['wxqfield'] = addslashes($v);
			$data[$k]['tablename'] = addslashes($_GET['tablename'][$k]);
			$data[$k]['fieldname'] = addslashes($_GET['fieldname'][$k]);
		}
	}
	$data = serialize($data);
	if(DB::result_first("SELECT count(*) FROM ".DB::table('yiqixueba_wxq123_setting')." WHERE skey='shopsetting'")==0) {
		DB::insert('yiqixueba_wxq123_setting',array('skey'=>'shopsetting','svalue'=>''));
	}else{
		DB::update('yiqixueba_wxq123_setting',array('svalue'=>$data),array('skey'=>'shopsetting'));
	}
	cpmsg(lang('plugin/yiqixueba', 'wxq_shopset_succeed'), 'action='.$this_page, 'succeed');
}


?>