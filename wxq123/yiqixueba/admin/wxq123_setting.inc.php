<?php

/**
*	һ��ѧ��ƽ̨����
*	�ļ�����wxq123_setting.inc.php  ����ʱ�䣺2013-6-9 16:35  ����
*
*/

//΢��ǽ����ҳ��
//��ҳ���������ط����ã�һ���ǡ��������á��е�ģ������е�ģ���б��е�����
//���о��Ƕ����˵���΢��ǽ�е�����
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

//��ģ������У���$mokuai_info��������ֱ��ִ�б�ҳ��ʱ��û��$mokuai_info����
if(!$mokuai_info){
	$mokuai_info = DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_mokuai')." WHERE mokuainame ='wxq123'");
}
//��ȡyiqixueba_setting���������е�һ��ͨ����
$mokuai_setting = array();
$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_setting')." WHERE skey like 'yiqixueba_".$mokuai_info['mokuainame']."%'");
while($row = DB::fetch($query)) {
	$mokuai_setting[$row['skey']] = $row['svalue'];
}
$mokuaiid = $mokuaiid ? $mokuaiid : $mokuai_info['mokuaiid'];

$pre_var = 'yiqixueba_'.$mokuai_info['mokuainame'];

$this_page = $this_page ? $this_page : 'plugins&identifier=yiqixueba&pmod=admin&submod=wxq123_setting';

$indata = array();
$wxq123_setting = api_indata('getweixinsetting',$indata);
dump($wxq123_setting);
if(!submitcheck('submit')) {
	showtips(lang('plugin/yiqixueba',$mokuai_info['mokuainame'].'_setting_tips'));
	showformheader($this_page.'&subac=mokuaisetting&mokuaiid='.$mokuaiid);
	showtableheader(lang('plugin/yiqixueba','wxq123_setting'));
	showhiddenfields(array('mokuaiid'=>$mokuaiid));
	showsetting(lang('plugin/yiqixueba','shibiema'),'','','http://www.wxq123.com/weixin/?sbm='.$wxq123_setting['shibiema'],'',0,lang('plugin/yiqixueba','shibiema_comment').$wxq123_setting['shibiema'],'','',true);
	showsetting(lang('plugin/yiqixueba','token'),'token',$wxq123_setting['token'],'text','',0,lang('plugin/yiqixueba','token_comment'),'','',true);
	showsetting(lang('plugin/yiqixueba','weixinimg'),'weixinimg',$plugin_setting['weixinimg'],'filetext','',0,lang('plugin/yiqixueba','weixinimg_comment').$weixinimghtml,'','',true);
	showsetting(lang('plugin/yiqixueba','firsttype'),array('firsttype',array(array('text',lang('plugin/yiqixueba','wxtext')),array('music',lang('plugin/yiqixueba','wxmusic')),array('news',lang('plugin/yiqixueba','wxnews')))),$plugin_setting['weixinimg'],'select','',0,lang('plugin/yiqixueba','firsttype_comment').$weixinimghtml,'','',true);
	showsetting(lang('plugin/yiqixueba','userreg'),'userreg',$plugin_setting['userreg'],'radio','',0,lang('plugin/yiqixueba','userreg_comment'),'','',true);
	showtablefooter();
	showtableheader(lang('plugin/yiqixueba','wxq123_data_setting'));
	showsetting(lang('plugin/yiqixueba','shop_tablename'),'setting[shop_tablename]',$plugin_setting['shop_tablename'],'text','',0,lang('plugin/yiqixueba','shop_tablename_comment'),'','',true);
	showsetting(lang('plugin/yiqixueba','shop_shopid'),'setting[shop_shopid]',$plugin_setting['shop_shopid'],'text','',0,lang('plugin/yiqixueba','shop_shopid_comment'),'','',true);
	showsetting(lang('plugin/yiqixueba','shop_shopname'),'setting[shop_shopname]',$plugin_setting['shop_shopname'],'text','',0,lang('plugin/yiqixueba','shop_shopname_comment'),'','',true);
	showsetting(lang('plugin/yiqixueba','shop_condition'),'setting[shop_condition]',$plugin_setting['shop_condition'],'text','',0,lang('plugin/yiqixueba','shop_condition_comment'),'','',true);
	showtablefooter();
	showtableheader(lang('plugin/yiqixueba','wxq123_base_setting'));
	showsetting(lang('plugin/yiqixueba','regsetp1tips'),'setting[regsetp1tips]',$plugin_setting['regsetp1tips'],'textarea','',0,lang('plugin/yiqixueba','regsetp1tips_comment'),'','',true);
	//��Ӧ�̼��ֶ�����
	showsetting(lang('plugin/yiqixueba','shop_table'),'setting['.$pre_var.'_shop_table]',$mokuai_setting[$pre_var.'_shop_table'],'text','','',lang('plugin/yiqixueba','shop_table_comment'),'','',true);
	showsetting(lang('plugin/yiqixueba','shop_url'),'setting['.$pre_var.'_shop_url]',$mokuai_setting[$pre_var.'_shop_url'],'textarea','','',lang('plugin/yiqixueba','shop_url_comment'),'','',true);
	showtablefooter();
	showtableheader(lang('plugin/yiqixueba','table_fields'));
	showsubtitle(array('', $mokuai_info['mokuaititle'].lang('plugin/yiqixueba','newfieldsname'),lang('plugin/yiqixueba','fieldsname'),  ''));
	$fields_array = dunserialize($mokuai_setting[$pre_var.'_fields']);
	
	if(is_array($fields_array)){
		foreach ( $fields_array as $k => $v ){
			showtablerow('', array('class="td25"','class="td23"',''), array(
				"<input class=\"checkbox\" type=\"checkbox\" name=\"delete[$k]\" value=\"$k\">",
				lang('plugin/yiqixueba','field_'.$k),
				'<input type="text" name="titlenew['.$k.']" value="'.$v.'">',
				'',
			));
		}
	}
	echo '<tr><td></td><td colspan="2"><div><a href="###" onclick="addrow(this, 0)" class="addtr">'.lang('plugin/yiqixueba','add_fieldsname').'</a></div></td></tr>';
	showsubmit('submit','submit','del');
	showtablefooter();
	showformfooter();
	//������Щ�ֶ���Ҫ����
	$fields_value = array('shopid','shopname','shopmanage','shoplocation');
	//�����ֶε�����select
	$fields_select = '<select name="newfield[]">';
	foreach ($fields_value as $k=>$v){
		if(!in_array($v,$fields_array)){
			$fields_select .= '<option value="'.$v.'">'.lang('plugin/yiqixueba','field_'.$v).'</option>';
		}
	}
	$fields_select .= '</select>';

	echo <<<EOT
<script type="text/JavaScript">
	var rowtypedata = [
		[
			[1, '', 'td25'],
			[1, '$fields_select', 'td28'],
			[1, '<input type="text" class="txt" size="15" name="newtitle[]">'],
		],
	];
</script>
EOT;

}else{
	//�Ѿ����õ��ֶβ���
	$wxq123_fields = array();
	$titlenew = getgpc('titlenew');
	if(is_array($titlenew)){
		foreach ($titlenew as $k=>$v){
			$wxq123_fields[$k] = strtolower(trim(htmlspecialchars($v)));
		}
	}
	//�½����ֶβ���
	$newtitle = getgpc('newtitle');
	$newfield = getgpc('newfield');
	if(is_array($newtitle)){
		foreach ($newtitle as $k=>$v){
			if(strtolower(trim(htmlspecialchars($v)))){
				$wxq123_fields[$newfield[$k]] = strtolower(trim(htmlspecialchars($v)));
			}
		}
	}
	//ɾ�����ֶβ���
	$deletes = getgpc('delete');
	if(is_array($deletes)){
		foreach ($deletes as $k=>$v){
			unset($wxq123_fields[$k]);
		}
	}

	$setting = getgpc('setting');
	$setting[$pre_var.'_fields'] = serialize($wxq123_fields);//���л��ֶβ���
	if (is_array($setting)){
		foreach ($setting as $key => $value){
			if (DB::result_first("SELECT count(*) FROM ".DB::table('yiqixueba_setting')." WHERE skey='".$key."'") == 0){
				DB::insert('yiqixueba_setting',array('skey'=>$key,'svalue'=>$value));
			}else{
				DB::update('yiqixueba_setting',array('svalue'=>$value),array('skey'=>$key));
			}
		}
	}
	cpmsg(lang('plugin/yiqixueba', 'mokuai_setting_succeed'), 'action='.$this_page.'&subac=mokuailist', 'succeed');
}

?>