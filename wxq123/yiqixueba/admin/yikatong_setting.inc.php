<?php

/**
*	һ��ѧ��ƽ̨����
*	�ļ�����tuangou_setting.inc.php  ����ʱ�䣺2013-6-9 16:25  ����
*
*/
//һ��ͨ����ҳ��
//��ҳ���������ط����ã�һ���ǡ��������á��е�ģ������е�ģ���б��е�����
//���о��Ƕ����˵���һ��ͨ�е�����
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

//��ģ������У���$mokuai_info��������ֱ��ִ�б�ҳ��ʱ��û��$mokuai_info����
if(!$mokuai_info){
	$mokuai_info = DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_mokuai')." WHERE mokuainame ='yikatong'");
}
//��ȡyiqixueba_setting���������е�һ��ͨ����
$mokuai_setting = array();
$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_setting')." WHERE skey like 'yiqixueba_".$mokuai_info['mokuainame']."%'");
while($row = DB::fetch($query)) {
	$mokuai_setting[$row['skey']] = $row['svalue'];
}
//dump($mokuai_setting);
$mokuaiid = $mokuaiid ? $mokuaiid : $mokuai_info['mokuaiid'];

$pre_var = 'yiqixueba_'.$mokuai_info['mokuainame'];

$this_page = $this_page ? $this_page : 'plugins&identifier=yiqixueba&pmod=admin&submod=yikatong_setting';


if(!submitcheck('submit')) {
	showtips(lang('plugin/yiqixueba',$mokuai_info['mokuainame'].'_setting_tips'));
	showformheader($this_page.'&subac=mokuaisetting&mokuaiid='.$mokuaiid);
	showtableheader(lang('plugin/yiqixueba','yikatong_setting'));
	showhiddenfields(array('mokuaiid'=>$mokuaiid));
	showsetting(lang('plugin/yiqixueba','nav_menu'),'setting['.$pre_var.'_nav_menu]',$mokuai_setting[$pre_var.'_nav_menu'],'radio','','',lang('plugin/yiqixueba','nav_menu_comment'),'','',true);
	showsetting(lang('plugin/yiqixueba','top_menu'),'setting['.$pre_var.'_top_menu]',$mokuai_setting[$pre_var.'_top_menu'],'radio','','',lang('plugin/yiqixueba','top_menu_comment'),'','',true);
	//dump($_G['setting']['extcredits']);
	//���׻���
	$money_select = '<select name="setting['.$pre_var.'_money]">';
	foreach ( $_G['setting']['extcredits'] as $k => $v ){
		$money_select .= '<option value="'.$k.'" '.($mokuai_setting[$pre_var.'_money']==$k ? ' selected':'').'>'.$v['title'].'</option>';
	}
	$money_select .= '</select>';
	showsetting(lang('plugin/yiqixueba','money'),'','',$money_select,'','',lang('plugin/yiqixueba','money_comment'),'','',true);
	//���ͻ���
	$jifen_select = '<select name="setting['.$pre_var.'_jifen]">';
	foreach ( $_G['setting']['extcredits'] as $k => $v ){
		$jifen_select .= '<option value="'.$k.'" '.($mokuai_setting[$pre_var.'_jifen']==$k ? ' selected':'').'>'.$v['title'].'</option>';
	}
	$jifen_select .= '</select>';
	showsetting(lang('plugin/yiqixueba','jifen'),'','',$jifen_select,'','',lang('plugin/yiqixueba','jifen_comment'),'','',true);
	$businessgroup_select = '<select name="setting['.$pre_var.'_businessgroup]">';
	$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_yikatong_businessgroup')." WHERE status = 1 order by businessgroupid asc");
	while($row = DB::fetch($query)) {
		$businessgroup_select .= '<option value="'.$row['businessgroupid'].'" '.($mokuai_setting[$pre_var.'_businessgroup']==$row['businessgroupid'] ? ' selected':'').'>'.$row['businessgroupname'].'</option>';
	}
	$businessgroup_select .= '</select>';
	showsetting(lang('plugin/yiqixueba','businessgroup'),'setting['.$pre_var.'_businessgroup]',$mokuai_setting[$pre_var.'_businessgroup'],$businessgroup_select,'','',lang('plugin/yiqixueba','businessgroup_comment'),'','',true);

	echo '<script src="source/plugin/yiqixueba/template/kindeditor/kindeditor.js" type="text/javascript"></script>';
	echo '<link rel="stylesheet" href="source/plugin/yiqixueba/template/kindeditor/themes/default/default.css" />';
	echo '<link rel="stylesheet" href="source/plugin/yiqixueba/template/kindeditor/plugins/code/prettify.css" />';
	echo '<script src="source/plugin/yiqixueba/template/kindeditor/lang/zh_CN.js" type="text/javascript"></script>';
	echo '<script src="source/plugin/yiqixueba/template/kindeditor/prettify.js" type="text/javascript"></script>';
	echo '<tr class="noborder" ><td colspan="2" class="td27" s="1">'.lang('plugin/yiqixueba','joinbusiness').':</td></tr>';
	echo '<tr class="noborder" ><td colspan="2" ><textarea name="joinbusiness" style="width:700px;height:200px;visibility:hidden;">'.$mokuai_setting[$pre_var.'_joinbusiness'].'</textarea></td></tr>';

	showsetting(lang('plugin/yiqixueba','jicihelp'),'setting['.$pre_var.'_jicihelp]',$mokuai_setting[$pre_var.'_jicihelp'],'textarea','','',lang('plugin/yiqixueba','jicihelp_comment'),'','',true);
	showsetting(lang('plugin/yiqixueba','shijianhelp'),'setting['.$pre_var.'_shijianhelp]',$mokuai_setting[$pre_var.'_shijianhelp'],'textarea','','',lang('plugin/yiqixueba','shijianhelp_comment'),'','',true);
	showsetting(lang('plugin/yiqixueba','liangkahelp'),'setting['.$pre_var.'_liangkahelp]',$mokuai_setting[$pre_var.'_liangkahelp'],'textarea','','',lang('plugin/yiqixueba','liangkahelp_comment'),'','',true);
	showsetting(lang('plugin/yiqixueba','xianjinhelp'),'setting['.$pre_var.'_xianjinhelp]',$mokuai_setting[$pre_var.'_xianjinhelp'],'textarea','','',lang('plugin/yiqixueba','xianjinhelp_comment'),'','',true);
	showsetting(lang('plugin/yiqixueba','yuehelp'),'setting['.$pre_var.'_yuehelp]',$mokuai_setting[$pre_var.'_yuehelp'],'textarea','','',lang('plugin/yiqixueba','yuehelp_comment'),'','',true);
	showsetting(lang('plugin/yiqixueba','jifenhelp'),'setting['.$pre_var.'_jifenhelp]',$mokuai_setting[$pre_var.'_jifenhelp'],'textarea','','',lang('plugin/yiqixueba','jifenhelp_comment'),'','',true);



	//��Ӧ�̼��ֶ�����
	showsetting(lang('plugin/yiqixueba','shop_table'),'setting['.$pre_var.'_shop_table]',$mokuai_setting[$pre_var.'_shop_table'],'text','','',lang('plugin/yiqixueba','shop_table_comment'),'','',true);
	showsetting(lang('plugin/yiqixueba','shop_url'),'setting['.$pre_var.'_shop_url]',$mokuai_setting[$pre_var.'_shop_url'],'textarea','','',lang('plugin/yiqixueba','shop_url_comment'),'','',true);
	//showsetting(lang('plugin/yiqixueba','shop_listurl'),'setting['.$pre_var.'_shop_listurl]',$mokuai_setting[$pre_var.'_shop_listurl'],'textarea','','',lang('plugin/yiqixueba','shop_listurl_comment'),'','',true);
	showsetting(lang('plugin/yiqixueba','shop_addurl'),'setting['.$pre_var.'_shop_addurl]',$mokuai_setting[$pre_var.'_shop_addurl'],'textarea','','',lang('plugin/yiqixueba','shop_addurl_comment'),'','',true);
	showsetting(lang('plugin/yiqixueba','shop_logourl'),'setting['.$pre_var.'_shop_logourl]',$mokuai_setting[$pre_var.'_shop_logourl'],'textarea','','',lang('plugin/yiqixueba','shop_logourl_comment'),'','',true);
	showtablefooter();
	showtableheader(lang('plugin/yiqixueba','table_fields'));
	showsubtitle(array('', $mokuai_info['mokuaititle'].lang('plugin/yiqixueba','newfieldsname'),lang('plugin/yiqixueba','fieldsname'),  ''));
	$fields_array = dunserialize($mokuai_setting[$pre_var.'_fields']);

	if(is_array($fields_array)){
		foreach ( $fields_array as $k => $v ){
			showtablerow('', array('class="td25"','class="td29"','class="td29"'), array(
				"<input class=\"checkbox\" type=\"checkbox\" name=\"delete[$k]\" value=\"$k\">",
				lang('plugin/yiqixueba','field_'.$k),
				'<input type="text" name="titlenew['.$k.']" value="'.$v.'">',
				'',
			));
		}
	}
	echo '<tr><td></td><td colspan="2"><div><a href="###" onclick="addrow(this, 0)" class="addtr">'.lang('plugin/yiqixueba','add_fieldsname').'</a></div></td></tr>';
	showtablefooter();
	showtableheader();
	//��Ӧ��Ʒ�ֶ�����
	showsetting(lang('plugin/yiqixueba','goods_table'),'setting['.$pre_var.'_goods_table]',$mokuai_setting[$pre_var.'_goods_table'],'text','','',lang('plugin/yiqixueba','goods_table_comment'),'','',true);
	showsetting(lang('plugin/yiqixueba','goods_url'),'setting['.$pre_var.'_goods_url]',$mokuai_setting[$pre_var.'_goods_url'],'textarea','','',lang('plugin/yiqixueba','goods_url_comment'),'','',true);
	//showsetting(lang('plugin/yiqixueba','goods_listurl'),'setting['.$pre_var.'_goods_listurl]',$mokuai_setting[$pre_var.'_goods_listurl'],'textarea','','',lang('plugin/yiqixueba','goods_listurl_comment'),'','',true);
	showsetting(lang('plugin/yiqixueba','goods_addurl'),'setting['.$pre_var.'_goods_addurl]',$mokuai_setting[$pre_var.'_goods_addurl'],'textarea','','',lang('plugin/yiqixueba','goods_addurl_comment'),'','',true);
	showsetting(lang('plugin/yiqixueba','goods_logourl'),'setting['.$pre_var.'_goods_logourl]',$mokuai_setting[$pre_var.'_goods_logourl'],'textarea','','',lang('plugin/yiqixueba','goods_logourl_comment'),'','',true);
	showtablefooter();
	showtableheader(lang('plugin/yiqixueba','goods_fields'));
	showsubtitle(array('', $mokuai_info['mokuaititle'].lang('plugin/yiqixueba','newgoodsfieldsname'),lang('plugin/yiqixueba','goodsfieldsname'),  ''));

	$goodsfields_array = dunserialize($mokuai_setting[$pre_var.'_goodsfields']);

	if(is_array($goodsfields_array)){
		foreach ( $goodsfields_array as $k => $v ){
			showtablerow('', array('class="td25"','class="td29"','class="td29"'), array(
				"<input class=\"checkbox\" type=\"checkbox\" name=\"goodsdelete[$k]\" value=\"$k\">",
				lang('plugin/yiqixueba','field_'.$k),
				'<input type="text" name="titlegoodsnew['.$k.']" value="'.$v.'">',
				'',
			));
		}
	}
	echo '<tr><td></td><td colspan="2"><div><a href="###" onclick="addrow(this, 1)" class="addtr">'.lang('plugin/yiqixueba','add_fieldsname').'</a></div></td></tr>';
	showsubmit('submit','submit','del');
	showtablefooter();
	showformfooter();
	//�����̼���Щ�ֶ���Ҫ����
	$fields_value = array('shopid','shoplogo','shopname','uid','shoplocation');
	//�����ֶε�����select
	$fields_select = '<select name="newfield[]">';
	foreach ($fields_value as $k=>$v){
		if(!in_array($v,$fields_array)){
			$fields_select .= '<option value="'.$v.'">'.lang('plugin/yiqixueba','field_'.$v).'</option>';
		}
	}
	$fields_select .= '</select>';
	//������Ʒ��Щ�ֶ���Ҫ����
	$goodsfields_value = array('goodsid','goodsname','goodspice','shopid','goodslogo','goodsnum');
	//�����ֶε�����select
	$goodsfields_select = '<select name="newgoodsfield[]">';
	foreach ($goodsfields_value as $k=>$v){
		if(!in_array($v,$goodsfields_array)){
			$goodsfields_select .= '<option value="'.$v.'">'.lang('plugin/yiqixueba','field_'.$v).'</option>';
		}
	}
	$goodsfields_select .= '</select>';

	echo <<<EOT
<script type="text/JavaScript">
	var rowtypedata = [
		[
			[1, '', 'td25'],
			[1, '$fields_select', 'td29'],
			[1, '<input type="text" class="txt" size="15" name="newtitle[]">', 'td29'],
		],
		[
			[1, '', 'td25'],
			[1, '$goodsfields_select', 'td29'],
			[1, '<input type="text" class="txt" size="15" name="newtitlegoods[]">', 'td29'],
		],
	];
</script>
EOT;
		echo <<<EOF
<script>
	KindEditor.ready(function(K) {
		var editor1 = K.create('textarea[name="joinbusiness"]', {
			cssPath : 'source/plugin/yiqixueba/template/kindeditor/plugins/code/prettify.css',
			uploadJson : 'source/plugin/yiqixueba/template/kindeditor/upload_json.php',
			items : ['source', '|', 'undo', 'redo', '|', 'preview', 'cut', 'copy', 'paste','plainpaste', 'wordpaste', '|', 'justifyleft', 'justifycenter', 'justifyright','justifyfull', 'insertorderedlist', 'insertunorderedlist', 'indent', 'outdent', 'subscript','superscript', 'clearhtml', 'quickformat', 'selectall', '|', 'fullscreen', '/','formatblock', 'fontname', 'fontsize', '|', 'forecolor', 'hilitecolor', 'bold','italic', 'underline', 'strikethrough', 'lineheight', 'removeformat', '|', 'image', 'multiimage','flash', 'media',  'table', 'hr', 'emoticons','pagebreak','anchor', 'link', 'unlink', '|', 'about'],
			afterCreate : function() {
				var self = this;
				K.ctrl(document, 13, function() {
					self.sync();
					K('form[name=cpform]')[0].submit();
				});
				K.ctrl(self.edit.doc, 13, function() {
					self.sync();
					K('form[name=cpform]')[0].submit();
				});
			}
		});
		prettyPrint();
	});
</script>

EOF;

}else{
	//�Ѿ����õ��̼��ֶβ���
	$yikatong_fields = array();
	$titlenew = getgpc('titlenew');
	if(is_array($titlenew)){
		foreach ($titlenew as $k=>$v){
			$yikatong_fields[$k] = strtolower(trim(htmlspecialchars($v)));
		}
	}
	//�½����̼��ֶβ���
	$newtitle = getgpc('newtitle');
	$newfield = getgpc('newfield');
	if(is_array($newtitle)){
		foreach ($newtitle as $k=>$v){
			if(strtolower(trim(htmlspecialchars($v)))){
				$yikatong_fields[$newfield[$k]] = strtolower(trim(htmlspecialchars($v)));
			}
		}
	}
	//ɾ�����̼��ֶβ���
	$deletes = getgpc('delete');
	if(is_array($deletes)){
		foreach ($deletes as $k=>$v){
			unset($yikatong_fields[$k]);
		}
	}

	//�Ѿ����õ���Ʒ�ֶβ���
	$yikatong_goodsfields = array();
	$titlegoodsnew = getgpc('titlegoodsnew');
	if(is_array($titlegoodsnew)){
		foreach ($titlegoodsnew as $k=>$v){
			$yikatong_goodsfields[$k] = strtolower(trim(htmlspecialchars($v)));
		}
	}
	//�½�����Ʒ�ֶβ���
	$newtitlegoods = getgpc('newtitlegoods');
	$newgoodsfield = getgpc('newgoodsfield');
	if(is_array($newtitlegoods)){
		foreach ($newtitlegoods as $k=>$v){
			if(strtolower(trim(htmlspecialchars($v)))){
				$yikatong_goodsfields[$newgoodsfield[$k]] = strtolower(trim(htmlspecialchars($v)));
			}
		}
	}
	//ɾ������Ʒ�ֶβ���
	$goodsdeletes = getgpc('delete');
	if(is_array($goodsdeletes)){
		foreach ($goodsdeletes as $k=>$v){
			unset($yikatong_goodsfields[$k]);
		}
	}

	$setting = getgpc('setting');
	$setting[$pre_var.'_fields'] = serialize($yikatong_fields);//���л��̼��ֶβ���
	$setting[$pre_var.'_goodsfields'] = serialize($yikatong_goodsfields);//���л���Ʒ�ֶβ���
	$setting[$pre_var.'_joinbusiness'] = stripslashes($_POST['joinbusiness']);
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