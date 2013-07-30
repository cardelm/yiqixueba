<?php

/**
*	一起学吧平台程序
*	文件名：proadmin.inc.php  创建时间：2013-6-1 22:40  杨文
*
*/

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
$this_page = 'plugins&identifier=yiqixueba_server&pmod=admincp&submod=proadmin';

$subop = getgpc('subop');
$subops = array('pagelist','pageedit');
$subop = in_array($subop,$subops) ? $subop : $subops[0];

$page_type_array = array('admin','module','ajax','api','hook');

$mokuais= array('server','client');
$mokuai = trim(getgpc('mokuai'));
$mokuai = in_array($mokuai,$mokuais) ? $mokuai : $mokuais[0];

$mokuai_text = '';
foreach ($mokuais as $k=>$v){
	$mokuai_text .= ($mokuai == $v ? lang('plugin/yiqixueba_server',$v.'_pro'): '<a href="'.ADMINSCRIPT.'?action='.$this_page.'&mokuai='.$v.'">'.lang('plugin/yiqixueba_server','server_pro').'</a>').'&nbsp;&nbsp;';
}

//程序列表
if($subop == 'pagelist') {
	if(!submitcheck('submit')) {
		showtips('<li>'.lang('plugin/yiqixueba_server','edit').lang('plugin/yiqixueba_server',$mokuai.'_pro').'</li>'.lang('plugin/yiqixueba_server','page_list_tips'));
		showformheader($this_page.'&subop=pagelist');
		showtableheader(lang('plugin/yiqixueba_server','page_list').'&nbsp;&nbsp;'.$mokuai_text);
		showsubtitle(array('', lang('plugin/yiqixueba_server','displayorder'),lang('plugin/yiqixueba_server','pagename'),lang('plugin/yiqixueba_server','pagetitle'), lang('plugin/yiqixueba_server','pagetype'), lang('plugin/yiqixueba_server','pagedescription'),lang('plugin/yiqixueba_server','pagetips'), lang('plugin/yiqixueba_server','status'), ''));
		$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_server_page')." WHERE mokuai='$mokuai' order by displayorder asc");
		while($row = DB::fetch($query)) {
			showtablerow('', array('class="td25"','class="td25"', 'class="td23"', 'class="td23"','class="td23"','class="td29"', 'class="td29"', 'class="td25"',''), array(
				"<input class=\"checkbox\" type=\"checkbox\" name=\"delete[]\" value=\"$row[mokuai]\">",
				'<input type="text" class="txt" name="displayordermnew['.$row['pageid'].']" value="'.$row['displayorder'].'" size="2" />',
				$row['filename'],
				$row['filetitle'],
				lang('plugin/yiqixueba_server',$row['pagetype']),
				$row['pagedescription'],
				$row1['mokuaidescription'],
				$row['status'] == 0 ? lang('plugin/yiqixueba_server','close') :lang('plugin/yiqixueba_server','open'),
				"<a href=\"".ADMINSCRIPT."?action=$this_page&subop=pageedit&mokuai=$mokuai&pageid=$row[pageid]\" class=\"act\">".lang('plugin/yiqixueba_server','edit')."</a>"
			));
		}
		echo '<tr><td></td><td colspan="8"><div><a href="###" onclick="addrow(this, 0);" class="addtr">'.lang('plugin/yiqixueba_server','add_page').'</a><input type="hidden" name="mokuai" value="'.$mokuai.'"></div></td></tr>';
		showsubmit('submit','submit','del');
		showtablefooter();
		showformfooter();
		$type_select = '<select name="newtype[]">';
		foreach ( $page_type_array as $k=>$v) {
			$type_select .= '<option value="'.$v.'">'.lang('plugin/yiqixueba_server',$v).'</option>';
		}
		$type_select .='</select>';
		echo <<<EOT
<script type="text/JavaScript">
	var rowtypedata = [
		[[1,''], [1,'<input name="newdisplayorder[]" type="text" class="txt" value="0">','td25'], [1, '','td23'], [1, '<input name="newtitle[]" type="text" class="txt">','td23'],[1,'$type_select','td25'],[3,''],],
	];
	</script>
EOT;
	}else{
		if(getgpc('newtitle')) {
			$newdisplayorder = getgpc('newdisplayorder');
			$newtype = getgpc('newtype');
			foreach ( getgpc('newtitle') as $k=>$v) {
				if(DB::result_first("SELECT count(*) FROM ".DB::table('yiqixueba_server_page')." WHERE mokuai='".$mokuai."'  and filetitle='".trim($v)."' and pagetype = '".trim($newtype[$k])."'")) {
					cpmsg(lang('plugin/yiqixueba_server', 'page_edit_error'));
				}else{
					$data['mokuai'] = trim($mokuai);
					$data['pagetype'] = trim($newtype[$k]);
					$data['filetitle'] = trim($v);
					$data['displayorder'] = trim($newdisplayorder[$k]);
					$data['status'] = 0;
					DB::insert('yiqixueba_server_page',$data);
				}
			}
			cpmsg($mokuai.lang('plugin/yiqixueba_server', 'page_edit_succeed'), 'action='.$this_page.'&subop=pagelist&mokuai='.$mokuai, 'succeed');
		}
	}
//模块组编辑
//编辑页面
}elseif($subop == 'pageedit'){
	$pageid = intval(getgpc('pageid'));
	$page_info = DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_server_page')." WHERE pageid='".$pageid."'");
	if(!submitcheck('submit')) {
		$page_type_select = '<select name="pagetype" onchange="var styles, key;styles=new Array(\'admin\',\'api\',\'ajax\', \'hook\', \'module\'); for(key in styles) {var obj=$(\'page_\'+styles[key]); if(obj) { obj.style.display=styles[key]==this.options[this.selectedIndex].value?\'\':\'none\';}}">';
		foreach ( $page_type_array as $k=>$v) {
			$page_type_select .= '<option value="'.$v.'" '.($page_info['pagetype'] == $v ?' selected':'').'>'.lang('plugin/yiqixueba_server',$v).'</option>';
		}
		$page_type_select .= '</select>';


		showtips('<li>'.lang('plugin/yiqixueba_server','edit').$group_info['mokuaititle'].'-'.$mokuai_info['versionname'].$page_info['filename'].'</li>'.lang('plugin/yiqixueba_server','page_edit_tips'));
		showformheader($this_page.'&subop=pageedit');
		showtableheader(lang('plugin/yiqixueba_server','page_edit'));
		showhiddenfields(array('mokuai'=>$mokuai,'groupid'=>$groupid,'pageid'=>$pageid));
		showsetting(lang('plugin/yiqixueba_server','pagetype'),'pagetype',$page_info['pagetype'],$page_type_select,'','',lang('plugin/yiqixueba_server','pagetitle_comment'),'','',true);
		showsetting(lang('plugin/yiqixueba_server','pagetitle'),'pagetitle',$page_info['filetitle'],'text','','',lang('plugin/yiqixueba_server','pagetitle_comment'),'','',true);
		if($page_info['pagetype'] =='hook') {
		}else{
			showsetting(lang('plugin/yiqixueba_server','pagename'),'pagename',$page_info['filename'],'text','','',lang('plugin/yiqixueba_server','pagename_comment'),'','',true);
		}

		showtagheader('tbody', "page_api", $page_info['pagetype'] == 'api');
		showtitle(lang('plugin/yiqixueba_server','api'));
		showsetting('threadtype_edit_inputsize', 'rules[calendar][inputsize]', $option['rules']['inputsize'], 'text');
		showtagfooter('tbody');

		showtagheader('tbody', "page_admin", $page_info['pagetype'] == 'admin');
		showtitle(lang('plugin/yiqixueba_server','admin'));
		showsetting(lang('plugin/yiqixueba_server','menu'), '', '', getupmenu('admin',$page_info['menu']),'','',lang('plugin/yiqixueba_server','menu_comment'),'','',true);
		showsetting(lang('plugin/yiqixueba_server','menunew'), 'admin_menunew', '', 'text','','',lang('plugin/yiqixueba_server','menunew_comment'),'','',true);
		showtagfooter('tbody');

		showtagheader('tbody', "page_ajax", $page_info['pagetype'] == 'ajax');
		showtitle(lang('plugin/yiqixueba_server','ajax'));
		showsetting('threadtype_edit_inputsize', 'rules[calendar][inputsize]', $option['rules']['inputsize'], 'text');
		showtagfooter('tbody');

		showtagheader('tbody', "page_hook", $page_info['pagetype'] == 'hook');
		showtitle(lang('plugin/yiqixueba_server','hook'));
		showsetting('threadtype_edit_inputsize', 'rules[calendar][inputsize]', $option['rules']['inputsize'], 'text');
		showtagfooter('tbody');

		showtagheader('tbody', "page_module", $page_info['pagetype'] == 'module');
		showtitle(lang('plugin/yiqixueba_server','module'));
		showsetting(lang('plugin/yiqixueba_server','menu'), '', '', getupmenu('module'),'','',lang('plugin/yiqixueba_server','menu_comment'),'','',true);
		showsetting(lang('plugin/yiqixueba_server','menunew'), 'module_menunew', '', 'text','','',lang('plugin/yiqixueba_server','menunew_comment'),'','',true);
		showtagfooter('tbody');

		showsetting(lang('plugin/yiqixueba_server','pagedescription'),'pagedescription',$page_info['pagedescription'],'textarea','','',lang('plugin/yiqixueba_server','pagedescription_comment'),'','',true);
		showsetting(lang('plugin/yiqixueba_server','pagecontents'),'pagecontents',htmlspecialchars_decode($page_info['pagecontents']),'textarea','','',lang('plugin/yiqixueba_server','pagecontents_comment'),'','',true);
		showsetting(lang('plugin/yiqixueba_server','status'),'status',$page_info['status'],'radio','','',lang('plugin/yiqixueba_server','page_status_comment'));
		showsubmit('submit');
		showtablefooter();
		showformfooter();
	}else{
		if(DB::result_first("SELECT count(*) FROM ".DB::table('yiqixueba_server_page')." WHERE mokuai='".$mokuai."'  and filename='".trim(getgpc('pagename'))."' and pagetype = '".trim($newtype[$k])."' and pageid <>".$pageid)) {
			cpmsg(lang('plugin/yiqixueba_server', 'page_edit_error'));
		}
		$data['menu'] = trim(getgpc(trim(getgpc('pagetype')).'_'.'menunew')) ? trim(getgpc(trim(getgpc('pagetype')).'_'.'menunew')) : trim(getgpc(trim(getgpc('pagetype')).'_'.'menu'));
		$data['filename'] = trim(getgpc('pagename'));
		$data['filetitle'] = trim(getgpc('pagetitle'));
		$data['pagedescription'] = trim(getgpc('pagedescription'));
		$data['pagecontents'] = htmlspecialchars(trim(getgpc('pagecontents')));
		$data['status'] = trim(getgpc('status'));
		DB::update('yiqixueba_server_page',$data,array('pageid'=>$pageid));
		$file_name = DISCUZ_ROOT.'source/plugin/yiqixueba_server/source//mokuai/ver'.$mokuai.'/'.trim(getgpc('pagetype')).'/'.$data['filename'].'.php';
		if(trim(getgpc('pagetype')=='admin')) {
			$file_header = "<?php\n\n/**\n*\t一起学吧平台程序\n*\t".$data['filetitle']."\n*\n文件名：".$data['filename'].".php  创建时间：".dgmdate(time(),'dt')."  杨文\n*\n*/\n\nif(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {\n\texit('Access Denied');\n}\n";
			file_put_contents($file_name, $file_header.htmlspecialchars_decode($data['pagecontents'])."\n?>");
		}elseif(trim(getgpc('pagetype')=='module')) {






		}
		cpmsg($group_info['mokuaititle'].'-'.$mokuai_info['versionname'].lang('plugin/yiqixueba_server', 'page_edit_succeed'), 'action='.$this_page.'&subop=pagelist&mokuai='.$mokuai.'&groupid='.$groupid, 'succeed');
	}

}
//
function getupmenu($menutype,$menuvalue) {
	$query = DB::query("SELECT menu FROM ".DB::table('yiqixueba_server_page')." WHERE pagetype='".$menutype."' group by menu");
	$return = '<select name="'.$menutype.'_menu">';
	while($row = DB::fetch($query)) {
		$return .= '<option value="'.$row['menu'].'" '.($menuvalue == $row['menu'] ? ' selected' : '').'>'.$row['menu'].'</option>';
	}
	$return .= '</select>';
	return $return;
}//end func
?>