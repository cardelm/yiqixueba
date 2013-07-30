<?php

/**
*	一起学吧平台程序
*	文件名：brand_dianping_setting.inc.php  创建时间：2013-6-9 16:25  杨文
*
*/
//一卡通设置页面
//此页面有两个地方引用，一个是“基础设置”中的模块管理中的模块列表中的设置
//还有就是顶部菜单中一卡通中的设置
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}


//读取yiqixueba_setting参数设置中的一卡通参数
$mokuai_setting = array();
$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_setting')." WHERE skey like 'yiqixueba_".$mokuai_info['upmokuai']."_".$mokuai_info['mokuainame']."%'");
while($row = DB::fetch($query)) {
	$mokuai_setting[$row['skey']] = $row['svalue'];
}
$mokuaiid = $mokuaiid ? $mokuaiid : $mokuai_info['mokuaiid'];

$pre_var = 'yiqixueba_'.$mokuai_info['upmokuai'].'_'.$mokuai_info['mokuainame'];


if(!submitcheck('submit')) {
	showtips(lang('plugin/yiqixueba',$mokuai_info['mokuainame'].'_setting_tips'));
	showformheader($this_page.'&subac=goodssetting&mokuaiid='.$mokuaiid);
	showtableheader(lang('plugin/yiqixueba','yikatong_setting'));
	showhiddenfields(array('mokuaiid'=>$mokuaiid));
	showsetting(lang('plugin/yiqixueba','content_minlen'),'setting['.$pre_var.'_content_minlen]',$mokuai_setting[$pre_var.'_content_minlen'],'text','','',lang('plugin/yiqixueba','content_minlen_comment'),'','',true);
	showsetting(lang('plugin/yiqixueba','content_maxlen'),'setting['.$pre_var.'_content_maxlen]',$mokuai_setting[$pre_var.'_content_maxlen'],'text','','',lang('plugin/yiqixueba','content_maxlen_comment'),'','',true);
	showsetting(lang('plugin/yiqixueba','recontent'),'setting['.$pre_var.'_recontent]',$mokuai_setting[$pre_var.'_recontent'],'radio','','',lang('plugin/yiqixueba','recontent_comment'),'','',true);
	showsetting(lang('plugin/yiqixueba','recontent_minlen'),'setting['.$pre_var.'_recontent_minlen]',$mokuai_setting[$pre_var.'_recontent_minlen'],'text','','',lang('plugin/yiqixueba','recontent_minlen_comment'),'','',true);
	showsetting(lang('plugin/yiqixueba','recontent_maxlen'),'setting['.$pre_var.'_recontent_maxlen]',$mokuai_setting[$pre_var.'_recontent_maxlen'],'text','','',lang('plugin/yiqixueba','recontent_maxlen_comment'),'','',true);
	showsetting(lang('plugin/yiqixueba','recontent_num'),array('setting['.$pre_var.'_recontent_num]',array(
			array(5, '5'.lang('plugin/yiqixueba','tiao'), array($pre_var.'_recontent_num' => 5)),
			array(10, '10'.lang('plugin/yiqixueba','tiao'), array($pre_var.'_recontent_num' => 10)),
			array(20, '20'.lang('plugin/yiqixueba','tiao'), array($pre_var.'_recontent_num' => 20)),
		)),$mokuai_setting[$pre_var.'_recontent_num'],'mradio','','',lang('plugin/yiqixueba','recontent_num_comment'),'','',true);
	showsetting(lang('plugin/yiqixueba','subtype'),array('setting['.$pre_var.'_subtype]',array(
			array(1, lang('plugin/yiqixueba','shijinzhi')),
			array(2, lang('plugin/yiqixueba','baifenzhi')),
			array(3, lang('plugin/yiqixueba','wufenzhi')),
		)),$mokuai_setting[$pre_var.'_subtype'],'select','','',lang('plugin/yiqixueba','subtype_comment'),'','',true);
	showsetting(lang('plugin/yiqixueba','xiaoshu'),array('setting['.$pre_var.'_xiaoshu]',array(
			array(0, lang('plugin/yiqixueba','nodispaly')),
			array(1, lang('plugin/yiqixueba','yiwei')),
			array(2, lang('plugin/yiqixueba','erwei')),
		)),$mokuai_setting[$pre_var.'_xiaoshu'],'select','','',lang('plugin/yiqixueba','xiaoshu_comment'),'','',true);
	showtablefooter();
	//点评项管理设置
	showtableheader(lang('plugin/yiqixueba','dianping_option'));
	showsubtitle(array('',lang('plugin/yiqixueba','optionname'),lang('plugin/yiqixueba','optiontitle'),  lang('plugin/yiqixueba','status')));
	$option_array = dunserialize($mokuai_setting[$pre_var.'_option']);

	if(is_array($option_array)){
		foreach ( $option_array as $k => $v ){
			showtablerow('', array('class="td25"','class="td23"','class="td29"','class="td25"'), array(
				"<input class=\"checkbox\" type=\"checkbox\" name=\"delete[$k]\" value=\"$k\">",
				'<input type="text" name="namenew[]" value="'.$v['name'].'">',
				'<input type="text" name="titlenew[]" size="30" value="'.$v['title'].'">',
				"<input class=\"checkbox\" type=\"checkbox\" name=\"statusnew[]\" value=\"1\" ".($v['status'] > 0 ? 'checked' : '').">",
			));
		}
	}
	echo '<tr><td></td><td colspan="5"><div><a href="###" onclick="addrow(this, 0)" class="addtr">'.lang('plugin/yiqixueba','add_optionname').'</a></div></td></tr>';
	showsubmit('submit','submit','del');
	showtablefooter();
	showformfooter();
	echo <<<EOT
<script type="text/JavaScript">
	var rowtypedata = [
		[
			[1, '', 'td25'],
			[1, '<input type="text" class="txt" size="15" name="newname[]">', 'td23'],
			[1, '<input type="text" class="txt" size="30" name="newtitle[]">', 'td29'],
			[1, '<input type="checkbox" class="checkbox" name="newstatus[]">', 'td25'],
		],
	];
</script>
EOT;

}else{
	//dump($_POST);
	//已经设置的字段参数
	$brand_dianping_option = array();
	$namenew = getgpc('namenew');
	$titlenew = getgpc('titlenew');
	$statusnew = getgpc('statusnew');
	if(is_array($titlenew)){
		foreach ($titlenew as $k=>$v){
			$brand_dianping_option[$k]['name'] = trim(htmlspecialchars($namenew[$k]));
			$brand_dianping_option[$k]['title'] = trim(htmlspecialchars($v));
			$brand_dianping_option[$k]['status'] = intval($statusnew[$k]);
		}
	}
	//新建的字段参数
	$newname = getgpc('newname');
	$newtitle = getgpc('newtitle');
	$newstatus = getgpc('newstatus');
	if(is_array($newname)){
		foreach ($newname as $k=>$v){
			if(trim(htmlspecialchars($v))){
				$brand_dianping_option[$k]['name'] = trim(htmlspecialchars($v));
				$brand_dianping_option[$k]['title'] = trim(htmlspecialchars($newtitle[$k]));
				$brand_dianping_option[$k]['status'] = intval($newstatus[$k]);
			}
		}
	}
	//删除的字段参数
	$deletes = getgpc('delete');
	if(is_array($deletes)){
		foreach ($deletes as $k=>$v){
			unset($brand_dianping_option[$k]);
		}
	}

	$setting = getgpc('setting');
	$setting[$pre_var.'_option'] = serialize($brand_dianping_option);//序列化字段参数
	if (is_array($setting)){
		foreach ($setting as $key => $value){
			if (DB::result_first("SELECT count(*) FROM ".DB::table('yiqixueba_setting')." WHERE skey='".$key."'") == 0){
				DB::insert('yiqixueba_setting',array('skey'=>$key,'svalue'=>$value));
			}else{
				DB::update('yiqixueba_setting',array('svalue'=>$value),array('skey'=>$key));
			}
		}
	}
	cpmsg(lang('plugin/yiqixueba', 'mokuai_setting_succeed'), 'action='.$this_page.'&subac=goodstypesetting', 'succeed');
}

?>