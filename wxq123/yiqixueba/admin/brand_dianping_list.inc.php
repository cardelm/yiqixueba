<?php

/**
*	一起学吧平台程序
*	文件名：brand_dianping_list.inc.php  创建时间：2013-6-9 16:25  杨文
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

dump($pre_var);
dump($mokuaiid);
if(!submitcheck('submit')) {
	showtips(lang('plugin/yiqixueba','brand_dianping_list_tips'));
	showformheader($this_page.'&subac=goodslist');
	showtableheader('search');
	//每页显示条数
	$tpp = intval(getgpc('tpp')) ? intval(getgpc('tpp')) : '20';
	$select[$tpp] = $tpp ? "selected='selected'" : '';
	$tpp_options = "<option value='20' $select[20]>20</option><option value='50' $select[50]>50</option><option value='100' $select[100]>1001</option>";
	//////搜索内容
	echo '<tr><td>';
	//模块选择
	$upmokuai_select = '<select name="upmokuai"><option value="">'.lang('plugin/yiqixueba','all').'</option>';
	foreach ($mokuai_data as $row){
		$upmokuai_select .= '<option value="'.$row['mokuaiid'].'" '.($upmokuai == $row['mokuaiid'] ? ' selected' : '').'>'.$row['mokuaititle'].'</option>';
	}
	$upmokuai_select .= '</select>';
	echo '&nbsp;&nbsp;'.lang('plugin/yiqixueba','upmokuai').'&nbsp;&nbsp;'.$upmokuai_select;
	if ($upmokuai){
		$sortupid_select = '<select name="shopsort"><option value="0">顶级</option>';
		$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_brand_shopsort')." where upmokuai = ".$upmokuai." order by concat(upids,'-',shopsortid) asc");
		while($row = DB::fetch($query)) {
			$sortupid_select .= '<option value="'.$row['shopsortid'].'" '.($shop_info['shopsort'] == $row['shopsortid'] ? ' selected' :'').'>'.str_repeat("--",$row['sortlevel']-1).$row['sorttitle'].'</option>';
		}
		$sortupid_select .= '</select>';
		echo '&nbsp;&nbsp;'.lang('plugin/yiqixueba','shopsort').'&nbsp;&nbsp;'.$sortupid_select;
	}
	$shenhe_select = '<select name="shenhe"><option value="">'.lang('plugin/yiqixueba','all').'</option><option value="1" '.($shenhe==1 ? ' selected':'').'>'.lang('plugin/yiqixueba','noshenhe').'</option><option value="2" '.($shenhe==2 ? ' selected':'').'>'.lang('plugin/yiqixueba','shenheed').'</option></select>';
	echo '&nbsp;&nbsp;'.lang('plugin/yiqixueba','shenhe').'&nbsp;&nbsp;'.$shenhe_select;
	$renling_select = '<select name="renling"><option value="">'.lang('plugin/yiqixueba','all').'</option><option value="1" '.($renling==1 ? ' selected':'').'>'.lang('plugin/yiqixueba','norenling').'</option><option value="2" '.($renling==2 ? ' selected':'').'>'.lang('plugin/yiqixueba','renlinged').'</option></select>';
	echo '&nbsp;&nbsp;'.lang('plugin/yiqixueba','renling').'&nbsp;&nbsp;'.$renling_select;
	//每页显示条数
	echo "&nbsp;&nbsp;".$lang['perpage']."<select name=\"tpp\">$tpp_options</select>";
	echo "&nbsp;&nbsp;".lang('plugin/yiqixueba','shortshopname').'&nbsp;&nbsp;<input type="text" name="shopname" value="'.$shopname.'" size="10">&nbsp;&nbsp;'.lang('plugin/yiqixueba','dianzhu').'&nbsp;&nbsp;<input type="text" name="dianzhu" value="'.$dianzhu.'" size="6">';
	echo "&nbsp;&nbsp;<input class=\"btn\" type=\"submit\" value=\"$lang[search]\" /></td></tr>";
	//////搜索内容
	showtablefooter();
	showtableheader(lang('plugin/yiqixueba','brand_dianping_list'));
	showsubtitle(array('', lang('plugin/yiqixueba','dianpingname'),lang('plugin/yiqixueba','shopnum'), lang('plugin/yiqixueba','dianpingquanxian'), lang('plugin/yiqixueba','status'), ''));
	$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_brand_dianping')." order by dianpingid asc");
	while($row = DB::fetch($query)) {
		showtablerow('', array('class="td25"','class="td23"', 'class="td23"', 'class="td23"','class="td25"',''), array(
			"<input class=\"checkbox\" type=\"checkbox\" name=\"delete[]\" value=\"$row[dianpingid]\">",
		$row['dianpingname'],
		$row['dianpingname'],
		$row['dianpingname'],
		"<input class=\"checkbox\" type=\"checkbox\" name=\"statusnew[".$row['dianpingid']."]\" value=\"1\" ".($row['status'] > 0 ? 'checked' : '').">",
			"<a href=\"".ADMINSCRIPT."?action=".$this_page."&mokuaiid=$mokuaiid&subac=goodsedit&dianpingid=$row[dianpingid]\" class=\"act\">".lang('plugin/yiqixueba','edit')."</a>",
		));
	}
	echo $upmokuai ? '<tr><td></td><td colspan="6"><div><a href="'.ADMINSCRIPT.'?action='.$this_page.'&subac=dianpingedit" class="addtr">'.lang('plugin/yiqixueba','add_goods').'</a></div></td></tr>' : '' ;
	showsubmit('submit','submit','del');
	showtablefooter();
	showformfooter();
}else{
}

?>