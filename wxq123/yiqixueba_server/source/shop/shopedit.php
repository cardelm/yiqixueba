<?php

/**
*	一起学吧平台程序
*	商家管理
*	文件名：shopedit.php  创建时间：2013-5-31 11:37  杨文
*
*/

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
$this_page = 'plugins&identifier=yiqixueba_server&pmod=admincp&submod=shopedit';

$subop = getgpc('subop');
$subops = array('shoplist','shopedit');
$subop = in_array($subop,$subops) ? $subop : $subops[0];

if($subop == 'shoplist') {
	if(!submitcheck('submit')) {
		showtips(lang('plugin/yiqixueba_server','shop_list_tips'));
		showformheader($this_page.'&subop=shoplist');
		showtableheader(lang('plugin/yiqixueba_server','shop_list'));
		showsubtitle(array('', lang('plugin/yiqixueba_server','displayorder'),lang('plugin/yiqixueba_server','mokuaiico'), lang('plugin/yiqixueba_server','mokuaititle'), lang('plugin/yiqixueba_server','versionname'),lang('plugin/yiqixueba_server','mokuaipice'), lang('plugin/yiqixueba_server','mokuaidescription'),lang('plugin/yiqixueba_server','status'), ''));
		$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_server_mokuai_group')." order by displayorder asc");
		while($row = DB::fetch($query)) {
			$mokuaiico = '';
			if($row['mokuaiico']!='') {
				$mokuaiico = str_replace('{STATICURL}', STATICURL, $row['mokuaiico']);
				if(!preg_match("/^".preg_quote(STATICURL, '/')."/i", $mokuaiico) && !(($valueparse = parse_url($mokuaiico)) && isset($valueparse['host']))) {
					$mokuaiico = $_G['setting']['attachurl'].'common/'.$row['mokuaiico'].'?'.random(6);
				}
				$mokuaiico = '<img src="'.$mokuaiico.'" width="40" height="40"/>';
			}else{
				$mokuaiico = '';
			}
			$mknum = DB::result_first("SELECT count(*) FROM ".DB::table('yiqixueba_server_mokuai')." WHERE groupid=".$row['groupid']." order by displayorder asc");
			showtablerow('', array('class="td25"','class="td25"', 'class="td25"', 'class="td23"','class="td25"','class="td28"',''), array(
				($mknum ?'<a href="javascript:;" class="right" onclick="toggle_group(\'mokuai_'.$row['groupid'].'\', this)">[+]</a>':'')."<input class=\"checkbox\" type=\"checkbox\" name=\"delgroup[]\" value=\"$row[groupid]\">",
				'<input type="text" class="txt" name="displayordergnew['.$row['groupid'].']" value="'.$row['displayorder'].'" size="1" />',
				$mokuaiico.'<input type="hidden" name="mokuainamenew['.$row['mokuaiid'].']" value="'.$row['mokuainame'].'">',
				$row['mokuaititle'].'('.$row['mokuainame'].')',
				'',
				'',
				'',
				'',
				"<a href=\"".ADMINSCRIPT."?action=$this_page&subop=groupedit&groupid=$row[groupid]\" class=\"act\">".lang('plugin/yiqixueba_server','edit')."</a>&nbsp;&nbsp;".'<a href="'.ADMINSCRIPT.'?action='.$this_page.'&subop=editmokuai&groupid='.$row['groupid'].'"  class="addchildboard">'.lang('plugin/yiqixueba_server','add_ver').'</a>',
			));
			$query1 = DB::query("SELECT * FROM ".DB::table('yiqixueba_server_mokuai')." WHERE groupid=".$row['groupid']." order by displayorder asc");
			$kk = 0;
			showtagheader('tbody', 'mokuai_'.$row['groupid'], false);
			while($row1 = DB::fetch($query1)) {
				showtablerow('', array('class="td25"','class="td25"', 'class="td25"', 'class="td23"','class="td25"','class="td23"','class="td29"', 'class="td25"',''), array(
					"<input class=\"checkbox\" type=\"checkbox\" name=\"delmokuai[]\" value=\"$row1[mokuaiid]\">",
					"<div class=\"".($kk == $mknum ? 'board' : 'lastboard')."\">&nbsp;</div>",
					'<input type="text" class="txt" name="displayordermnew['.$row1['mokuaiid'].']" value="'.$row1['displayorder'].'" size="1" />',
					'('.lang('plugin/yiqixueba_server','verid').$row1['mokuaiid'].')',
					$row1['versionname'],
					$row1['mokuaipice'],
					$row1['mokuaidescription'],
					$row1['status'] == 0 ? lang('plugin/yiqixueba_server','designing') :($row1['status'] == 1 ? lang('plugin/yiqixueba_server','open') :lang('plugin/yiqixueba_server','close')),
					"<a href=\"".ADMINSCRIPT."?action=$this_page&subop=editmokuai&groupid=$row[groupid]&mokuaiid=$row1[mokuaiid]\" class=\"act\">".lang('plugin/yiqixueba_server','edit')."</a>&nbsp;&nbsp;<a href=\"".ADMINSCRIPT."?action=$this_page&subop=pagelist&groupid=$row[groupid]&mokuaiid=$row1[mokuaiid]\" class=\"act\">".lang('plugin/yiqixueba_server','page')."</a>"
				));
			}
			showtagfooter('tbody');
			$kk++;
		}
		echo '<tr><td></td><td colspan="8"><div><a href="'.ADMINSCRIPT.'?action='.$this_page.'&subop=groupedit" class="addtr">'.lang('plugin/yiqixueba_server','add_mokuai').'</a></div></td></tr>';
		showsubmit('submit','submit','del');
		showtablefooter();
		showformfooter();
	}else{
		if($idg = $_GET['delgroup']) {
			$idg = dintval($idg, is_array($idg) ? true : false);
			if($idg) {
				DB::delete('yiqixueba_server_mokuai_group', DB::field('groupid', $idg));
				//删除站长数据表中的模块设置字段
				//$sql = "alter table ".DB::table('wxq123_site')." DROP `m_".$mokuainame."`;";
			}
		}
		if($idm = $_GET['delmokuai']) {
			$idm = dintval($idm, is_array($idm) ? true : false);
			if($idm) {
				foreach ( $idm as $k=>$v) {
					rmdirs(DISCUZ_ROOT.'source/plugin/yiqixueba_server/source/mokuai/ver'.$v.'/');
				}
				DB::delete('yiqixueba_server_mokuai', DB::field('mokuaiid', $idm));
			}
		}
		$displayordergnew = $_GET['displayordergnew'];
		if(is_array($displayordergnew)) {
			foreach ( $displayordergnew as $k=>$v) {
				$data['displayorder'] = intval($v);
				DB::update('yiqixueba_server_mokuai_group',$data,array('groupid'=>$k));
			}
		}
		$displayordermnew = $_GET['displayordermnew'];
		if(is_array($displayordermnew)) {
			foreach ( $displayordermnew as $k=>$v) {
				$data['displayorder'] = intval($v);
				DB::update('yiqixueba_server_mokuai',$data,array('mokuaiid'=>$k));
			}
		}
		cpmsg(lang('plugin/yiqixueba_server', 'mokuai_edit_succeed'), 'action='.$this_page, 'succeed');
	}
}if($subop == 'shopedit') {
}
?>