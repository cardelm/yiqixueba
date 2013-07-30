<?php

/**
*	一起学吧平台程序
*	文件名：shop_shopsort.inc.php  创建时间：2013-6-4 09:37  杨文
*
*/

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
$this_page = 'plugins&identifier=yiqixueba&pmod=admin&submod=shopsort';

$subac = getgpc('subac');
$subacs = array('shopsortlist','shopsortedit');
$subac = in_array($subac,$subacs) ? $subac : $subacs[0];

$shopsortid = getgpc('shopsortid');
$shopsort_info = $shopsortid ? DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_shopsort')." WHERE shopsortid=".$shopsortid) : array();


$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_shopsort')." order by displayorder asc");
while($row = DB::fetch($query)) {
	$data[] = $row;
}
$tree = getTree($data, 0);

if($subac == 'shopsortlist') {
	if(!submitcheck('submit')) {
		showtips(lang('plugin/yiqixueba','shopsort_list_tips'));
		showformheader($this_page.'&subac=shopsortlist');
		showtableheader(lang('plugin/yiqixueba','shopsort_list'));
		showsubtitle(array('', lang('plugin/yiqixueba','shopsortname'),lang('plugin/yiqixueba','shopsorttitle'), lang('plugin/yiqixueba','displayorder'), ''));
		getRow($tree);
		echo '<tr><td></td><td colspan="6"><div><a href="'.ADMINSCRIPT.'?action='.$this_page.'&subac=shopsortedit" class="addtr">'.lang('plugin/yiqixueba','add_shopsort').'</a></div></td></tr>';
		showsubmit('submit','submit','del');
		showtablefooter();
		showformfooter();
	}else{
	}
}elseif($subac == 'shopsortedit') {
	if(!submitcheck('submit')) {
		$menu_select = '<select name="sortupid"><option value="0">顶级</option>';
		$menu_select .= getselect($tree,$shopsort_info['sortupid']);
		$menu_select .= '</select>';
		showtips(lang('plugin/yiqixueba','shopsort_edit_tips'));
		showformheader($this_page.'&subac=shopsortedit','enctype');
		showtableheader(lang('plugin/yiqixueba','shopsort_edit'));
		$shopsortid ? showhiddenfields(array('shopsortid'=>$shopsortid)) : '';
		showsetting(lang('plugin/yiqixueba','shopsortname'),'shopsortname',$shopsort_info['sortname'],'text','',0,lang('plugin/yiqixueba','shopsortname_comment'),'','',true);
		showsetting(lang('plugin/yiqixueba','shopsorttitle'),'shopsorttitle',$shopsort_info['sorttitle'],'text','',0,lang('plugin/yiqixueba','shopsorttitle_comment'),'','',true);
		showsetting(lang('plugin/yiqixueba','sortupid'),'','',$menu_select,'',0,lang('plugin/yiqixueba','sortupid_comment'),'','',true);
		showsetting(lang('plugin/yiqixueba','displayorder'),'displayorder',$shopsort_info['displayorder'],'text','',0,lang('plugin/yiqixueba','displayorder_comment'),'','',true);
		showsubmit('submit');
		showtablefooter();
		showformfooter();
	}else{
		if(!htmlspecialchars(trim($_GET['shopsortname']))) {
			cpmsg(lang('plugin/yiqixueba','shopsortname_nonull'));
		}
		$data = array();
		$data['sortname'] = htmlspecialchars(trim($_GET['shopsortname']));
		$data['sorttitle'] = htmlspecialchars(trim($_GET['shopsorttitle']));
		$data['sortupid'] = intval($_GET['sortupid']);
		$data['sortlevel'] = $data['sortupid'] ==0 ? 1 : (intval(DB::result_first("SELECT sortlevel FROM ".DB::table('yiqixueba_shopsort')." WHERE shopsortid=".$data['sortupid']))+1);
		$data['displayorder'] = htmlspecialchars(trim($_GET['displayorder']));
		if($shopsortid) {
			DB::update('yiqixueba_shopsort',$data,array('shopsortid'=>$shopsortid));
		}else{
			DB::insert('yiqixueba_shopsort',$data);
		}
		cpmsg(lang('plugin/yiqixueba', 'shopsort_edit_succeed'), 'action='.$this_page.'&subac=shopsortlist', 'succeed');
	}
}

//显示分类
function getRow($data){
	global $this_page;
	$return = '';
	foreach($data as $k => $v){
		$return = showtablerow('', array('class="td25"','class="td23"', 'class="td23"', 'class="td25"',''), array(
			"<input class=\"checkbox\" type=\"checkbox\" name=\"delete[]\" value=\"$v[shopsortid]\">",
			str_repeat("--",$v['sortlevel']-1).$v['sortname'],
			$v['sorttitle'],
			'<input type="text" class="txt" name="displayordergnew['.$v['shopsortid'].']" value="'.$v['displayorder'].'" size="2" />',
				"<a href=\"".ADMINSCRIPT."?action=".$this_page."&subac=shopsortedit&shopsortid=$v[shopsortid]\" class=\"act\">".lang('plugin/yiqixueba','edit')."</a>",
			));
		if($v['sub']){
			getRow($v['sub']);
		}
	}
	return $return;
}
//显示分类下拉框
function getselect($data,$value){
	//$return = '';
	foreach($data as $k => $v){
		$return .= '<option value="'.$v['shopsortid'].'" '.($value==$v['shopsortid']?' selected':'').'>'.str_repeat("--",$v['sortlevel']).$v['sorttitle'].'</option>';
		if($v['sub']){
			$return .= getselect($v['sub'],$value);
		}
	}
	return $return;
}
//分类数据转换
function getTree($data, $pId){
	$tree = '';
	foreach($data as $k => $v){
		if($v['sortupid'] == $pId){         //父亲找到儿子
			$v['sub'] = getTree($data, $v['shopsortid']);
			$tree[] = $v;
			unset($data[$k]);
		}
	}
	return $tree;
}

// 浏览器友好的变量输出
function dump($var, $echo=true,$label=null, $strict=true){
    $label = ($label===null) ? '' : rtrim($label) . ' ';
    if(!$strict) {
        if (ini_get('html_errors')) {
            $output = print_r($var, true);
            $output = "<pre>".$label.htmlspecialchars($output,ENT_QUOTES)."</pre>";
        } else {
            $output = $label . " : " . print_r($var, true);
        }
    }else {
        ob_start();
        var_dump($var);
        $output = ob_get_clean();
        if(!extension_loaded('xdebug')) {
            $output = preg_replace("/\]\=\>\n(\s+)/m", "] => ", $output);
            $output = '<pre>'. $label. htmlspecialchars($output, ENT_QUOTES). '</pre>';
        }
    }
    if ($echo) {
        echo($output);
        return null;
    }else
        return $output;
}
?>