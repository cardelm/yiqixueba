<?php

/**
*	一起学吧平台程序
*	文件名：menu.inc.php  创建时间：2013-6-1 23:27  杨文
*
*/

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
$this_page = 'plugins&identifier=yiqixueba_server&pmod=admincp&submod=menu';


$subop = getgpc('subop');
$subops = array('menulist','menuedit');
$subop = in_array($subop,$subops) ? $subop : $subops[0];

$menutype = getgpc('menutype');
$menutypes = array('admin','manage','module','api');
$menutype = in_array($menutype,$menutypes) ? $menutype : $menutypes[0];

$menutype_text = '';
foreach ($menutypes as $k=>$v){
	$menutype_text .= ($menutype==$v ? lang('plugin/yiqixueba_server',$v): "<a href=\"".ADMINSCRIPT."?action=$this_page&menutype=$v\">".lang('plugin/yiqixueba_server',$v)."</a>")."&nbsp;&nbsp;";
}

$menuid = getgpc('menuid');
$menu_info = $menuid ? DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_menu')." WHERE menuid=".$menuid) : array();

dump($menu_info);

//菜单列表
if($subop == 'menulist') {
	if(!submitcheck('submit')) {
		showtips(lang('plugin/yiqixueba_server','menu_list_tips'));
		showformheader($this_page.'&subop=menulist');
		showtableheader(lang('plugin/yiqixueba_server','menu_list').'&nbsp;&nbsp;&nbsp;&nbsp;'.$menutype_text);
		showsubtitle(array('', lang('plugin/yiqixueba_server','displayorder'),lang('plugin/yiqixueba_server',''), lang('plugin/yiqixueba_server','menutitle'), lang('plugin/yiqixueba_server','submenutitle'), lang('plugin/yiqixueba_server','mokuai')));
		$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_menu')." WHERE upid=0 and menutype='".$menutype."' order by displayorder asc");
		while($row = DB::fetch($query)) {
			$mknum = DB::result_first("SELECT count(*) FROM ".DB::table('yiqixueba_menu')." WHERE upid=".$row['upid']." order by displayorder asc");
			showtablerow('', array('class="td25"','class="td25"', 'class="td25"', 'class="td23"', 'class="td28"'), array(
				($mknum ?'<a href="javascript:;" class="right" onclick="toggle_group(\'menu_'.$row['menuid'].'\', this)">[+]</a>':'')."<input class=\"checkbox\" type=\"checkbox\" name=\"delmenu[]\" value=\"$row[menuid]\">",
				'<input type="text" class="txt" name="displayordernew['.$row['menuid'].']" value="'.$row['displayorder'].'" size="1" />',
				$menuico.'<input type="hidden" name="menunamenew['.$row['menuid'].']" value="'.$row['menuname'].'">',
				$row['menutitle'].'('.$row['menuname'].')',
				'',
				'',
				"<a href=\"".ADMINSCRIPT."?action=$this_page&subop=menuedit&menutype=$menutype&menuid=$row[menuid]\" class=\"act\">".lang('plugin/yiqixueba_server','edit')."</a>&nbsp;&nbsp;"

			));
			$query1 = DB::query("SELECT * FROM ".DB::table('yiqixueba_menu')." WHERE upid=".$row['menuid']." order by displayorder asc");
			$kk = 0;
			showtagheader('tbody', 'menu_'.$row['menuid'], false);
			while($row1 = DB::fetch($query1)) {
				showtablerow('', array('class="td25"','class="td25"', 'class="td25"', 'class="td23"', 'class="td28"'), array(
					"<input class=\"checkbox\" type=\"checkbox\" name=\"delmenu[]\" value=\"$row1[menuid]\">",
					"<div class=\"".($kk == $mknum ? 'board' : 'lastboard')."\">&nbsp;</div>",
					'<input type="text" class="txt" name="displayordernew['.$row1['menuid'].']" value="'.$row1['displayorder'].'" size="1" />',
					'',
					$row1['menutitle'].'('.$row1['menuname'].')',
					DB::result_first("SELECT mokuaititle FROM ".DB::table('yiqixueba_server_mokuai')." WHERE mokuainame='".$row1['mokuaitype']."'"),
					"<a href=\"".ADMINSCRIPT."?action=$this_page&subop=menuedit&menutype=$menutype&menuid=$row1[menuid]\" class=\"act\">".lang('plugin/yiqixueba_server','edit')."</a>&nbsp;&nbsp;"
				));
			}
			showtagfooter('tbody');
			$kk++;
		}
		$menutype ? showhiddenfields(array('menutype'=>$menutype)) : '';
		echo '<tr><td></td><td colspan="8"><div><a href="'.ADMINSCRIPT.'?action='.$this_page.'&subop=menuedit&menutype='.$menutype.'" class="addtr">'.lang('plugin/yiqixueba_server','add_menu').'</a></div></td></tr>';
		showsubmit('submit','submit','del');
		showtablefooter();
		showformfooter();
	}else{
		if($idm = $_GET['delmenu']) {
			$idm = dintval($idm, is_array($idm) ? true : false);
			if($idm) {
				DB::delete('yiqixueba_menu', DB::field('menuid', $idm));
			}
		}
		$displayordernew = $_GET['displayordernew'];
		if(is_array($displayordernew)) {
			foreach ( $displayordernew as $k=>$v) {
				$data['displayorder'] = intval($v);
				DB::update('yiqixueba_menu',$data,array('menuid'=>$k));
			}
		}
		cpmsg(lang('plugin/yiqixueba_server',$menutype).lang('plugin/yiqixueba_server', 'menu_edit_succeed'), 'action='.$this_page.'&menutype='.$menutype, 'succeed');
	}
}elseif($subop == 'menuedit'){
	if(!submitcheck('submit')) {
		$menu_upid_select = '<select name="upid"><option value="0">'.lang('plugin/yiqixueba_server','topmenu').'</option>';
		$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_menu')." WHERE upid=0 and menutype='".$menutype."' order by displayorder asc");
		while($row = DB::fetch($query)) {
			$menu_upid_select .= '<option value="'.$row['menuid'].'" '.($menu_info['upid'] == $row['menuid'] ? ' selected' : '').'>--'.$row['menutitle'].'</option>';
		}
		$menu_upid_select .= '</select>';

		$mokuaiids_select = '<select name="mokuaitype">';
		$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_server_mokuai')." order by displayorder asc");
		while($row = DB::fetch($query)) {
			$mokuaiids_select .= '<option value="'.$row['mokuainame'].'" '.($menu_info['mokuaitype'] == $row['mokuainame'] ? ' selected' : '').'>'.$row['mokuaititle'].'</option>';
		}
		$mokuaiids_select .= '</select>';
		$rules_info = dunserialize($menu_info['rules']);
		showtips(lang('plugin/yiqixueba_server',$menutype));
		showformheader($this_page.'&subop=menuedit','enctype');
		showtableheader(lang('plugin/yiqixueba_server','menu_edit'));
		$menuid ? showhiddenfields(array('menuid'=>$menuid)) : '';
		$menutype ? showhiddenfields(array('menutype'=>$menutype)) : '';
		showsetting(lang('plugin/yiqixueba_server','upid'),'','',$menu_upid_select,'','',lang('plugin/yiqixueba_server','upid_comment'),'','',true);
		showsetting(lang('plugin/yiqixueba_server','menuname'),'menuname',$menu_info['menuname'],'text','',0,lang('plugin/yiqixueba_server','menuname_comment'),'','',true);
		showsetting(lang('plugin/yiqixueba_server','menutitle'),'menutitle',$menu_info['menutitle'],'text','',0,lang('plugin/yiqixueba_server','menutitle_comment'),'','',true);
		if ($menu_info['upid']){
			showsetting(lang('plugin/yiqixueba_server','mokuai'),'','',$mokuaiids_select,'',0,lang('plugin/yiqixueba_server','tablename_comment'),'','',true);
			if($menutype == 'admin'){
				showsetting(lang('plugin/yiqixueba_server','tablename'),'tablename',$rules_info['tablename'],'text','',0,lang('plugin/yiqixueba_server','tablename_comment'),'','',true);
				showsetting(lang('plugin/yiqixueba_server','fieldname'),'fieldname',$rules_info['fieldname'],'textarea','',0,lang('plugin/yiqixueba_server','fieldname_comment'),'','',true);
				showsetting(lang('plugin/yiqixueba_server','otheroption'),array('otheroption', array(
				array('datalist', lang('plugin/yiqixueba_server','datalist'), '1'),
				array('prepage', lang('plugin/yiqixueba_server','prepage'),  '1'),
				array('addnew', lang('plugin/yiqixueba_server','addnew'),  '1'),
				)),$rules_info['otheroption'],'omcheckbox','',0,lang('plugin/yiqixueba_server','otheroption_comment'),'','',true);
			}elseif($menutype == 'manage'){
				for($i=0;$i<5 ;$i++ ){
				
					showsetting('分支'.$i,'rules['.$i.'][fenzhi]',$rules_info[$i]['fenzhi'],'text','',0,'格式：英文|中文','','',true);
					showsetting('数据表名'.$i,'rules['.$i.'][tablename]',$rules_info[$i]['tablename'] ?$rules_info[$i]['tablename']:'yiqixueba_yikatong_','text','',0,'不要包含表前缀','','',true);
					showsetting('数据表主键'.$i,'rules['.$i.'][zhujian]',$rules_info[$i]['zhujian'],'text','',0,'数据表主键','','',true);
					showsetting('是否自动生成'.$i,'rules['.$i.'][ismake]',$rules_info[$i]['ismake'],'radio','',0,'当表不存在的时候，是否自动生成','','',true);
					showsetting('管理页面类型'.$i,'rules['.$i.'][pagetype]',$rules_info[$i]['pagetype'],'text','',0,'1=数据列表；2=数据编辑','','',true);
					showsetting('字段内容'.$i,'rules['.$i.'][field]',$rules_info[$i]['field'],'textarea','',0,'格式为：<br />页面类型为1时：变量标识|变量名称|变量类型|是否列表|搜索类型<br />页面类型为2时：变量标识|变量名称|变量类型|是否有值<br />取值为：text password <br />一行一个','','',true);
				}
			}
			showsetting(lang('plugin/yiqixueba_server','sourcecode'),'sourcecode',$menu_info['sourcecode'],'textarea','',0,lang('plugin/yiqixueba_server','sourcecode_comment'),'','',true);
			showsetting(lang('plugin/yiqixueba_server','makecode'),'makecode','','radio','',0,lang('plugin/yiqixueba_server','makecode_comment'),'','',true);
		}
		showsubmit('submit');
		showtablefooter();
		showformfooter();
	}else{
		$data = array();
		$data['menuname'] = htmlspecialchars(trim($_GET['menuname']));
		if ($menuid && DB::result_first("SELECT count(*) FROM ".DB::table('yiqixueba_menu')." WHERE menuname='".$data['menuname']."' and menutype='".$menutype."' and upid='".intval($_GET['upid'])."' and menuid <> ".$menuid)){
			cpmsg(lang('plugin/yiqixueba_server','menuname_err'));
		}
		$data['menutitle'] = htmlspecialchars(trim($_GET['menutitle']));
		$data['upid'] = intval($_GET['upid']);
		$data['menutype'] = $menutype;
		$data['rules'] = serialize($_GET['rules']);;
		if($data['menutype'] == 'admin') {
			$data['rules'] = serialize(array('tablename'=>htmlspecialchars(trim($_GET['tablename'])),'fieldname'=>htmlspecialchars(trim($_GET['fieldname'])),'otheroption'=>$_GET['otheroption']));
			if(intval($_GET['makecode'])) {
				var_dump($data['rules']);
			}
		}
		$data['sourcecode'] = htmlspecialchars(trim($_GET['sourcecode']));
		if($menuid) {
			DB::update('yiqixueba_menu',$data,array('menuid'=>$menuid));
		}else{
			DB::insert('yiqixueba_menu',$data);
		}
		cpmsg(lang('plugin/yiqixueba_server',$menutype).lang('plugin/yiqixueba_server', 'menu_edit_succeed'), 'action='.$this_page.'&subop=menuedit&menutype='.$menutype.'&menuid='.$menuid, 'succeed');
	}
}




?>