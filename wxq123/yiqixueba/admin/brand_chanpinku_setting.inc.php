<?php

/**
*	一起学吧平台程序
*	文件名：tuangou_setting.inc.php  创建时间：2013-6-9 16:25  杨文
*
*/
//一卡通设置页面
//此页面有两个地方引用，一个是“基础设置”中的模块管理中的模块列表中的设置
//还有就是顶部菜单中一卡通中的设置
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

//在模块管理中，有$mokuai_info参数，而直接执行笨页面时则没有$mokuai_info参数
if(!$mokuai_info){
	$mokuai_info = DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_mokuai')." WHERE mokuainame ='brand'");
}
//读取yiqixueba_setting参数设置中的一卡通参数
$mokuai_setting = array();
$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_setting')." WHERE skey like 'yiqixueba_".$mokuai_info['mokuainame']."%'");
while($row = DB::fetch($query)) {
	$mokuai_setting[$row['skey']] = $row['svalue'];
}
$mokuaiid = $mokuaiid ? $mokuaiid : $mokuai_info['mokuaiid'];

$pre_var = 'yiqixueba_'.$mokuai_info['mokuainame'];

//$this_page = $this_page ? $this_page : 'plugins&identifier=yiqixueba&pmod=admin&submod=brand_setting';


if(!submitcheck('submit')) {
	showtips(lang('plugin/yiqixueba',$mokuai_info['mokuainame'].'_setting_tips'));
	showformheader($this_page.'&subac=goodssetting&mokuaiid='.$mokuaiid);
	showtableheader(lang('plugin/yiqixueba','brand_setting'));

	showhiddenfields(array('mokuaiid'=>$mokuaiid));

	showsetting(lang('plugin/yiqixueba','chanpinku_sort'),'setting['.$pre_var.'_sort]',$mokuai_setting[$pre_var.'_sort'],'textarea','','',lang('plugin/yiqixueba','chanpinku_sort_comment'),'','',true);
	showtablefooter();
	showtableheader(lang('plugin/yiqixueba','chanpinku_fields'));
	showsubtitle(array('', lang('plugin/yiqixueba','fieldsname'),lang('plugin/yiqixueba','fieldstitle'),lang('plugin/yiqixueba','selectconmet'),lang('plugin/yiqixueba','fieldstype'),  ''));
	$fields_array = dunserialize($mokuai_setting[$pre_var.'_fields']);
	
	if(is_array($fields_array)){
		foreach ( $fields_array as $k => $v ){
			showtablerow('', array('class="td25"','class="td23"','class="td23"','class="td23"','class="td23"',''), array(
				"<input class=\"checkbox\" type=\"checkbox\" name=\"delete[$k]\" value=\"$k\">",
				'<input type="text" name="namenew['.$k.']" size="12" value="'.$v['name'].'">',
				'<input type="text" name="titlenew['.$k.']" size="12" value="'.$v['title'].'">',
				'<textarea name="selectcnew['.$k.']" rows="2" cols="20">'.$v['selectc'].'</textarea>',
				'<input type="hidden" name="fieldnew['.$k.']" value="'.$v['field'].'" >'.lang('plugin/yiqixueba','f_'.$v['field']),
			));
		}
	}
	echo '<tr><td></td><td colspan="2"><div><a href="###" onclick="addrow(this, 0)" class="addtr">'.lang('plugin/yiqixueba','add_fieldsname').'</a></div></td></tr>';
	showsubmit('submit','submit','del');
	showtablefooter();
	showformfooter();
	//设置哪些字段需要设置
	$fields_value = array('text','textarea','select','calendar','number','edit');
	//设置字段的下拉select
	$fields_select = '<select name="newfield[]">';
	foreach ($fields_value as $k=>$v){
		if(!in_array($v,$fields_array)){
			$fields_select .= '<option value="'.$v.'">'.lang('plugin/yiqixueba','f_'.$v).'</option>';
		}
	}
	$fields_select .= '</select>';

	echo <<<EOT
<script type="text/JavaScript">
	var rowtypedata = [
		[
			[1, '', 'td25'],
			[1, '<input type="text" class="txt" size="12" name="newname[]">', 'td23'],
			[1, '<input type="text" class="txt" size="12" name="newtitle[]">', 'td23'],
			[1, '<textarea name="newselectc[]" rows="2" cols="20"></textarea>', 'td23'],
			[1, '$fields_select', 'td23'],
		],
	];
</script>
EOT;

}else{
	//dump($_POST);
	//已经设置的字段参数
	$brand_fields = array();
	$namenew = getgpc('namenew');
	$titlenew = getgpc('titlenew');
	$fieldnew = getgpc('fieldnew');
	$selectcnew = getgpc('selectcnew');
	if(is_array($titlenew)){
		foreach ($titlenew as $k=>$v){
			if(strtolower(trim(htmlspecialchars($v)))){
				$brand_fields[] = array('name'=>strtolower(trim(htmlspecialchars($namenew[$k]))),'title'=>strtolower(trim(htmlspecialchars($v))),'selectc'=>strtolower(trim(htmlspecialchars($selectcnew[$k]))),'field'=>strtolower(trim(htmlspecialchars($fieldnew[$k]))));
				if(!DB::result_first("describe ".DB::table('yiqixueba_brand_chanpinku')." ".strtolower(trim(htmlspecialchars($namenew[$k]))))) {
					if($fieldnew[$k]=='text'){
						$datatype = 'char(100)';
					}
					if($fieldnew[$k]=='textarea'){
						$datatype = 'varchar(255)';
					}
					if($fieldnew[$k]=='select' ||$fieldnew[$k]=='edit'){
						$datatype = 'text(0)';
					}
					if($fieldnew[$k]=='calendar'||$fieldnew[$k]=='number'){
						$datatype = 'int(11)';
					}
					$sql = "alter table ".DB::table('yiqixueba_brand_chanpinku')." add `".strtolower(trim(htmlspecialchars($namenew[$k])))."` ".$datatype." not Null;";
					runquery($sql);
				}
			}
		}
	}
	//新建的字段参数
	$newname = getgpc('newname');
	$newtitle = getgpc('newtitle');
	$newfield = getgpc('newfield');
	$newselectc = getgpc('newselectc');
	if(is_array($newtitle)){
		foreach ($newtitle as $k=>$v){
			if(strtolower(trim(htmlspecialchars($v)))){
				$brand_fields[] = array('name'=>strtolower(trim(htmlspecialchars($newname[$k]))),'title'=>strtolower(trim(htmlspecialchars($v))),'selectc'=>strtolower(trim(htmlspecialchars($newselectc[$k]))),'field'=>strtolower(trim(htmlspecialchars($newfield[$k]))));
				if(!DB::result_first("describe ".DB::table('yiqixueba_brand_chanpinku')." ".strtolower(trim(htmlspecialchars($newname[$k]))))) {
					if($newfield[$k]=='text'){
						$datatype = 'char(100)';
					}
					if($newfield[$k]=='textarea'){
						$datatype = 'varchar(255)';
					}
					if($newfield[$k]=='select' ||$newfield[$k]=='edit'){
						$datatype = 'text(0)';
					}
					if($newfield[$k]=='calendar'||$newfield[$k]=='number'){
						$datatype = 'int(11)';
					}
					$sql = "alter table ".DB::table('yiqixueba_brand_chanpinku')." add `".strtolower(trim(htmlspecialchars($newname[$k])))."` ".$datatype." not Null;";
					runquery($sql);
				}
			}
		}
	}
	//删除的字段参数
	$deletes = getgpc('delete');
	if(is_array($deletes)){
		foreach ($deletes as $k=>$v){
			if(DB::result_first("describe ".DB::table('yiqixueba_brand_chanpinku')." ".$brand_fields[$k]['name'])) {
				runquery("alter table `".DB::table('yiqixueba_brand_chanpinku')."` drop column ".$brand_fields[$k]['name']."  ");
			}
			unset($brand_fields[$k]);
		}
	}

	$setting = getgpc('setting');
	$setting[$pre_var.'_fields'] = serialize($brand_fields);//序列化字段参数
	if (is_array($setting)){
		foreach ($setting as $key => $value){
			if (DB::result_first("SELECT count(*) FROM ".DB::table('yiqixueba_setting')." WHERE skey='".$key."'") == 0){
				DB::insert('yiqixueba_setting',array('skey'=>$key,'svalue'=>$value));
			}else{
				DB::update('yiqixueba_setting',array('svalue'=>$value),array('skey'=>$key));
			}
		}
	}
	cpmsg(lang('plugin/yiqixueba', 'mokuai_setting_succeed'), 'action='.$this_page, 'succeed');
}

?>