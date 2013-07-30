<?php

/**
 *      [17xue8.cn] (C)2013-2099 杨文.
 *      这不是免费的。
 *
 */

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

$submod = getgpc('submod');
$submods = array('list','edit','setting','tableedit','field','fieldedit','shop','shopedit','goods');
$submod = in_array($submod,$submods) ? $submod : $submods[0];

$funcid = getgpc('funcid');
$func_info = $funcid ? DB::fetch_first("SELECT * FROM ".DB::table('wxq123_func')." WHERE funcid=".$funcid) : array();
$shibiema = random(8,1);
while(DB::result_first("SELECT count(*) FROM ".DB::table('wxq123_shibiema')." WHERE shibiema='".$shibiema ."'")) {
	$shibiema = random(8,1);
}

var_dump($shibiema);	
if($submod == 'list') {	
	if(!submitcheck('submit')) {
		showtips(lang('plugin/wxq123','weixin_setting_tips'));
		showformheader("plugins&identifier=wxq123&pmod=weixinmanage&submod=list");
		showtableheader(lang('plugin/wxq123','weixin_func_list'));
		showsubtitle(array('', lang('plugin/wxq123','functitle'),lang('plugin/wxq123','funckey'), lang('plugin/wxq123','funclevel'), lang('plugin/wxq123','funcfwid'),lang('plugin/wxq123','funcdescription'),  lang('plugin/wxq123','funcname'),lang('plugin/wxq123','status'), ''));
		$perpage = 10;
		$start = ($page - 1) * $perpage;
		$sitecount = DB::result_first("SELECT count(*) FROM ".DB::table('wxq123_func'));
		$multi = multi($sitecount, $perpage, $page, ADMINSCRIPT."?action=plugins&identifier=wxq123&pmod=weixinmanage");
		$query = DB::query("SELECT * FROM ".DB::table('wxq123_func')." order by funcid desc limit ".$start.",".$perpage." ");
		while($row = DB::fetch($query)) {
			showtablerow('', array('class="td25"', 'class="td23"','class="td23"', 'class="td25"', 'class="td23"','class="td28"','class="td23"','class="td25"',''), array(
				"<input class=\"checkbox\" type=\"checkbox\" name=\"delete[]\" value=\"$row[funcid]\">",
				$row['functitle'],
				$row['funckey'],
				$row['funclevel'],
				$row['funcfwid'],
				$row['funcdescription'],
				$row['funcname'],
				"<input class=\"checkbox\" type=\"checkbox\" name=\"statusnew[]\" value=\"$row[funcid]\" ".($row['status'] > 0 ? 'checked' : '').">",
				"<a href=\"".ADMINSCRIPT."?action=plugins&identifier=wxq123&pmod=weixinmanage&submod=edit&funcid=$row[funcid]\" class=\"act\">".$lang['edit']."</a>&nbsp;&nbsp;<a href=\"".ADMINSCRIPT."?action=plugins&identifier=wxq123&pmod=weixinmanage&submod=setting&funcid=$row[funcid]\" class=\"act\">".lang('plugin/wxq123','setting')."</a>",
			));
		}
		echo '<tr><td></td><td colspan="5"><div><a href="'.ADMINSCRIPT.'?action=plugins&identifier=wxq123&pmod=weixinmanage&submod=edit" class="addtr">'.lang('plugin/wxq123','add_func').'</a></div></td></tr>';
		showsubmit('submit', 'submit', 'del','','',$multi);
		showtablefooter();
		showformfooter();
	}else{
		if($ids = $_GET['delete']) {
			$ids = dintval($ids, is_array($ids) ? true : false);
			if($ids) {
				DB::delete('wxq123_func', DB::field('funcid', $ids));
			}
		}
	}
}elseif($submod == 'edit'){
	if(!submitcheck('submit')) {
		$funcintype = '<select name="intype"><option>'.lang('plugin/wxq123','all').'</option><option value="text" '.($func_info['']=='text'?' selected':'').'>'.lang('plugin/wxq123','text').'</option><option value="location" '.($func_info['']=='location'?' selected':'').'>'.lang('plugin/wxq123','location').'</option><option value="image" '.($func_info['']=='image'?' selected':'').'>'.lang('plugin/wxq123','image').'</option><option value="link" '.($func_info['']=='link'?' selected':'').'>'.lang('plugin/wxq123','link').'</option><option value="event" '.($func_info['']=='event'?' selected':'').'>'.lang('plugin/wxq123','event').'</option></select>';
		$funcouttype = '<select name="outtype"><option>'.lang('plugin/wxq123','all').'</option><option value="text" '.($func_info['']=='text'?' selected':'').'>'.lang('plugin/wxq123','text').'</option><option value="music" '.($func_info['']=='music'?' selected':'').'>'.lang('plugin/wxq123','music').'</option><option value="news" '.($func_info['']=='news'?' selected':'').'>'.lang('plugin/wxq123','news').'</option></select>';
		$fwid_select = '<select name="fid"><option></option>';
		$query = DB::query("SELECT * FROM ".DB::table('wxq123_func')." where funcfwid = 0 ");
		while($row = DB::fetch($query)) {
			$fwid_select .= '<option value="'.$row['funcid'].'">'.$row['funcname'].'</option>';
		}
		$fwid_select .= '</select>';
		showtips(lang('plugin/wxq123','weixin_setting_tips'));
		showformheader("plugins&identifier=wxq123&pmod=weixinmanage&submod=edit");
		showtableheader(lang('plugin/wxq123','weixin_func_edit'));
		$funcid ? showhiddenfields($hiddenfields = array('funcid'=>$funcid)) : '';
		showsetting(lang('plugin/wxq123','functitle'),'functitle',$func_info['functitle'],'text','',0,lang('plugin/wxq123','functitle_comment'),'','',true);
		showsetting(lang('plugin/wxq123','funcdescription'),'funcdescription',$func_info['funcdescription'],'textarea','',0,lang('plugin/wxq123','funcdescription_comment'),'','',true);
		showsetting(lang('plugin/wxq123','funcintype'),'','',$funcintype,'',0,lang('plugin/wxq123','funcintype_comment'),'','',true);
		showsetting(lang('plugin/wxq123','funckey'),'funckey',$func_info['funckey'],'text','',0,lang('plugin/wxq123','funckey_comment'),'','',true);
		showsetting(lang('plugin/wxq123','funcname'),'funcname',$func_info['funcname'],'text','',0,lang('plugin/wxq123','funcname_comment'),'','',true);
		showsetting(lang('plugin/wxq123','funcfwid'),'','',$fwid_select,'',0,lang('plugin/wxq123','funcfwid_comment'),'','',true);
		showsetting(lang('plugin/wxq123','funcconents'),'funcconents',$func_info['funcconents'],'textarea','',0,lang('plugin/wxq123','funcconents_comment'),'','',true);
		showsubmit('submit');
		showtablefooter();
		showformfooter();
	}else{
		$data['functitle'] = htmlspecialchars(trim($_GET['functitle']));
		$data['funcname'] = htmlspecialchars(trim($_GET['funcname']));
		$data['funcintype'] = htmlspecialchars(trim($_GET['funcintype']));
		$data['funckey'] = htmlspecialchars(trim($_GET['funckey']));
		$data['funcdescription'] = htmlspecialchars(trim($_GET['funcdescription']));
		$data['funcconents'] = htmlspecialchars(trim($_GET['funcconents']));
		$funcid ? DB::update('wxq123_func',$data,array('funcid'=>$funcid)) : DB::insert('wxq123_func',$data);
		cpmsg(lang('plugin/wxq123', 'func_edit_succeed'), 'action=plugins&identifier=wxq123&pmod=weixinmanage', 'succeed');
	}
}elseif($submod == 'setting'){
}
?>