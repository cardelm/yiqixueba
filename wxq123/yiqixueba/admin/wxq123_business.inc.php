<?php

/**
*	一起学吧平台程序
*	文件名：wxq123_business.inc.php  创建时间：2013-6-22 19:36  杨文
*
*/

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
$this_page = 'plugins&identifier=yiqixueba&pmod=admin&submod=wxq123_business';

$subac = getgpc('subac');
$subacs = array('wxq123_businesslist','wxq123_businessedit');
$subac = in_array($subac,$subacs) ? $subac : $subacs[0];

$wxq123_businessid = getgpc('wxq123_businessid');
$wxq123_business_info = $wxq123_businessid ? DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_wxq123_business')." WHERE wxq123_businessid=".$wxq123_businessid) : array();

if($subac == 'wxq123_businesslist') {
	if(!submitcheck('submit')) {
		showtips(lang('plugin/yiqixueba','wxq123_business_list_tips'));
		showformheader($this_page.'&subac=wxq123_businesslist');
		showtableheader(lang('plugin/yiqixueba','wxq123_business_list'));
		showsubtitle(array('', lang('plugin/yiqixueba','wxq123_businessname'),lang('plugin/yiqixueba','shopnum'), lang('plugin/yiqixueba','wxq123_businessquanxian'), lang('plugin/yiqixueba','status'), ''));
		//$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_wxq123_business')." order by wxq123_businessid asc");
		//while($row = DB::fetch($query)) {
			showtablerow('', array('class="td25"','class="td23"', 'class="td23"', 'class="td23"','class="td25"',''), array(
				"<input class=\"checkbox\" type=\"checkbox\" name=\"delete[]\" value=\"$row[wxq123_businessid]\">",
			$row['wxq123_businessname'],
			$row['wxq123_businessname'],
			$row['wxq123_businessname'],
			"<input class=\"checkbox\" type=\"checkbox\" name=\"statusnew[".$row['wxq123_businessid']."]\" value=\"1\" ".($row['status'] > 0 ? 'checked' : '').">",
				"<a href=\"".ADMINSCRIPT."?action=".$this_page."&subac=wxq123_businessedit&wxq123_businessid=$row[wxq123_businessid]\" class=\"act\">".lang('plugin/yiqixueba','edit')."</a>",
			));
		//}
		echo '<tr><td></td><td colspan="6"><div><a href="'.ADMINSCRIPT.'?action='.$this_page.'&subac=wxq123_businessedit" class="addtr">'.lang('plugin/yiqixueba','add_wxq123_business').'</a></div></td></tr>';
		showsubmit('submit','submit','del');
		showtablefooter();
		showformfooter();
	}else{
	}
}elseif($subac == 'wxq123_businessedit') {
	if(!submitcheck('submit')) {
		showtips(lang('plugin/yiqixueba','wxq123_business_edit_tips'));
		showformheader($this_page.'&subac=wxq123_businessedit','enctype');
		showtableheader(lang('plugin/yiqixueba','wxq123_business_edit'));
		$wxq123_businessid ? showhiddenfields(array('wxq123_businessid'=>$wxq123_businessid)) : '';
		showsetting(lang('plugin/yiqixueba','wxq123_businessname'),'wxq123_business_info[wxq123_businessname]',$wxq123_business_info['wxq123_businessname'],'text','',0,lang('plugin/yiqixueba','wxq123_businessname_comment'),'','',true);
		showsubmit('submit');
		showtablefooter();
		showformfooter();
	}else{
		if(!htmlspecialchars(trim($_GET['wxq123_business_info']['wxq123_businessname']))) {
			cpmsg(lang('plugin/yiqixueba','wxq123_businessname_nonull'));
		}
		$datas = $_GET['wxq123_business_info'];
		foreach ( $datas as $k=>$v) {
			$data[$k] = htmlspecialchars(trim($v));
			if(!DB::result_first("describe ".DB::table('yiqixueba_wxq123_business')." ".$k)) {
				$sql = "alter table ".DB::table('yiqixueba_wxq123_business')." add `".$k."` varchar(255) not Null;";
				runquery($sql);
			}
		}
		if($wxq123_businessid) {
			DB::update('yiqixueba_wxq123_business',$data,array('wxq123_businessid'=>$wxq123_businessid));
		}else{
			DB::insert('yiqixueba_wxq123_business',$data);
		}
		cpmsg(lang('plugin/yiqixueba', 'wxq123_business_edit_succeed'), 'action='.$this_page.'&subac=wxq123_businesslist', 'succeed');
	}
}

?>