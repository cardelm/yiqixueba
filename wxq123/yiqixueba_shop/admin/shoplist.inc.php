<?php

/**
*	一起学吧平台程序
*	文件名：shoplist.inc.php  创建时间：2013-6-1 01:49  杨文
*
*/

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
$this_page = 'plugins&identifier=yiqixueba_shop&pmod=admin&submod=shoplist';

if(!submitcheck('submit')) {
		showtips(lang('plugin/yiqixueba_shop','shop_list_tips'));
		showformheader($this_page);
		showtableheader(lang('plugin/yiqixueba_shop','shop_list'));
		showsubtitle(array('', lang('plugin/yiqixueba_shop','shopname'),lang('plugin/yiqixueba_shop','cardtype'), lang('plugin/yiqixueba_shop','shopdescription'), lang('plugin/yiqixueba_shop','status'), ''));
		$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_shop_shop')." order by shopid asc");
		while($row = DB::fetch($query)) {
			$shoplistico = '';
			if($row['shoplistico']!='') {
				$shoplistico = str_replace('{STATICURL}', STATICURL, $row['shoplistico']);
				if(!preg_match("/^".preg_quote(STATICURL, '/')."/i", $shoplistico) && !(($valueparse = parse_url($shoplistico)) && isset($valueparse['host']))) {
					$shoplistico = $_G['setting']['attachurl'].'common/'.$row['shoplistico'].'?'.random(6);
				}
				$shoplistico = '<img src="'.$shoplistico.'" width="40" height="40"/>';
			}else{
				$shoplistico = '';
			}
			showtablerow('', array('class="td25"','class="td23"', 'class="td23"', 'class="td23"','class="td25"',''), array(
				"<input class=\"checkbox\" type=\"checkbox\" name=\"delete[]\" value=\"$row[shoplistid]\">",
				$shoplistico.'<br />'.$row['shoplistname'],
				lang('plugin/yiqixueba_shop',$row['cardtype']),
				$row['shoplistdescription'],
				"<input class=\"checkbox\" type=\"checkbox\" name=\"statusnew[".$row['shoplistid']."]\" value=\"1\" ".($row['status'] > 0 ? 'checked' : '').">",
				"<a href=\"".ADMINSCRIPT."?action=".$this_page."&subac=shoplistedit&shoplistid=$row[shoplistid]\" class=\"act\">".lang('plugin/yiqixueba_shop','edit')."</a>&nbsp;&nbsp;<a href=\"".ADMINSCRIPT."?action=plugins&identifier=yiqixueba_yikatong&pmod=admin&submod=mkcard&shoplistid=$row[shoplistid]\" class=\"act\">".lang('plugin/yiqixueba_shop','makecard')."</a>",
			));
		}
		echo '<tr><td></td><td colspan="6"><div><a href="'.ADMINSCRIPT.'?action=plugins&identifier=yiqixueba_shop&pmod=admin&submod=shopedit" class="addtr">'.lang('plugin/yiqixueba_shop','add_shop').'</a></div></td></tr>';
		showsubmit('submit','submit','del');
		showtablefooter();
		showformfooter();
}else{
}
?>