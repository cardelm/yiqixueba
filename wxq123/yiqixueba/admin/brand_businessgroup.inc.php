<?php

/**
*	一起学吧平台程序
*	文件名：brand_businessgroup.inc.php  创建时间：2013-6-23 01:52  杨文
*
*/

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
$this_page = 'plugins&identifier=yiqixueba&pmod=admin&submod=brand_businessgroup';

$subac = getgpc('subac');
$subacs = array('businessgrouplist','businessgroupedit');
$subac = in_array($subac,$subacs) ? $subac : $subacs[0];

$businessgroupid = getgpc('businessgroupid');
$businessgroup_info = $businessgroupid ? DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_brand_businessgroup')." WHERE businessgroupid=".$businessgroupid) : array();

if($subac == 'businessgrouplist') {
	if(!submitcheck('submit')) {
		showtips(lang('plugin/yiqixueba','businessgroup_list_tips'));
		showformheader($this_page.'&subac=businessgrouplist');
		showtableheader(lang('plugin/yiqixueba','businessgroup_list'));
		showsubtitle(array('', lang('plugin/yiqixueba','businessgroupname'),lang('plugin/yiqixueba','shopnum'), lang('plugin/yiqixueba','businessgroupquanxian'), lang('plugin/yiqixueba','status'), ''));
		$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_brand_businessgroup')." order by businessgroupid asc");
		while($row = DB::fetch($query)) {
			$businessgroupico = '';
			if($row['businessgroupico']!='') {
				$businessgroupico = str_replace('{STATICURL}', STATICURL, $row['businessgroupico']);
				if(!preg_match("/^".preg_quote(STATICURL, '/')."/i", $businessgroupico) && !(($valueparse = parse_url($businessgroupico)) && isset($valueparse['host']))) {
					$businessgroupico = $_G['setting']['attachurl'].'common/'.$row['businessgroupico'].'?'.random(6);
				}
				$businessgroupico = '<img src="'.$businessgroupico.'" width="40" height="40"/><br />';
			}else{
				$businessgroupico = '';
			}
			showtablerow('', array('class="td25"','class="td23"', 'class="td25"', 'class="td28"','class="td25"',''), array(
				"<input class=\"checkbox\" type=\"checkbox\" name=\"delete[]\" value=\"$row[businessgroupid]\">",
				$businessgroupico.$row['businessgroupname'],
				DB::result_first("SELECT count(*) FROM ".DB::table('yiqixueba_brand_business')." WHERE businessgroupid=".$row['businessgroupid']),
				lang('plugin/yiqixueba','inshoufei').':'.$row['inshoufei'].'&nbsp;&nbsp;'.lang('plugin/yiqixueba','inshoufeiqixian').':'.$row['inshoufeiqixian'],
				"<input class=\"checkbox\" type=\"checkbox\" name=\"statusnew[".$row['businessgroupid']."]\" value=\"1\" ".($row['status'] > 0 ? 'checked' : '').">",
				"<a href=\"".ADMINSCRIPT."?action=".$this_page."&subac=businessgroupedit&businessgroupid=$row[businessgroupid]\" class=\"act\">".lang('plugin/yiqixueba','edit')."</a>",
			));
		}
		echo '<tr><td></td><td colspan="6"><div><a href="'.ADMINSCRIPT.'?action='.$this_page.'&subac=businessgroupedit" class="addtr">'.lang('plugin/yiqixueba','add_businessgroup').'</a></div></td></tr>';
		showsubmit('submit','submit','del');
		showtablefooter();
		showformfooter();
	}else{
	}
}elseif($subac == 'businessgroupedit') {
	if(!submitcheck('submit')) {
		if($businessgroup_info['businessgroupico']!='') {
			$businessgroupico = str_replace('{STATICURL}', STATICURL, $businessgroup_info['businessgroupico']);
			if(!preg_match("/^".preg_quote(STATICURL, '/')."/i", $businessgroupico) && !(($valueparse = parse_url($businessgroupico)) && isset($valueparse['host']))) {
				$businessgroupico = $_G['setting']['attachurl'].'common/'.$businessgroup_info['businessgroupico'].'?'.random(6);
			}
			$businessgroupicohtml = '<br /><label><input type="checkbox" class="checkbox" name="delete1" value="yes" /> '.$lang['del'].'</label><br /><img src="'.$businessgroupico.'" width="80" height="60"/>';
		}
		if($businessgroup_info['contractsample']!='') {
			$contractsamplehtml = '<label><input type="checkbox" class="checkbox" name="delete2" value="yes" /> '.$lang['del'].'</label><br /><a href="source/plugin/yiqixueba/data/'.$businessgroup_info['contractsample'].'">'.lang('plugin/yiqixueba','contractsample').'</a><br />';
		}
		showtips(lang('plugin/yiqixueba','businessgroup_edit_tips'));
		showformheader($this_page.'&subac=businessgroupedit','enctype');
		showtableheader(lang('plugin/yiqixueba','businessgroup_edit'));
		$businessgroupid ? showhiddenfields(array('businessgroupid'=>$businessgroupid)) : '';

		showsetting(lang('plugin/yiqixueba','businessgroupico'),'businessgroupico',$businessgroup_info['businessgroupico'],'filetext','','',lang('plugin/yiqixueba','businessgroupico_comment').$businessgroupicohtml,'','',true);

		showsetting(lang('plugin/yiqixueba','businessgroupname'),'businessgroup_info[businessgroupname]',$businessgroup_info['businessgroupname'],'text','',0,lang('plugin/yiqixueba','businessgroupname_comment'),'','',true);

		echo '<script src="source/plugin/yiqixueba/template/kindeditor/kindeditor.js" type="text/javascript"></script>';
		echo '<link rel="stylesheet" href="source/plugin/yiqixueba/template/kindeditor/themes/default/default.css" />';
		echo '<link rel="stylesheet" href="source/plugin/yiqixueba/template/kindeditor/plugins/code/prettify.css" />';
		echo '<script src="source/plugin/yiqixueba/template/kindeditor/lang/zh_CN.js" type="text/javascript"></script>';
		echo '<script src="source/plugin/yiqixueba/template/kindeditor/prettify.js" type="text/javascript"></script>';
		echo '<tr class="noborder" ><td colspan="2" class="td27" s="1">'.lang('plugin/yiqixueba','businessgroupdescription').':</td></tr>';
		echo '<tr class="noborder" ><td colspan="2" ><textarea name="businessgroupdescription" style="width:700px;height:200px;visibility:hidden;">'.$businessgroup_info['businessgroupdescription'].'</textarea></td></tr>';

		showsetting(lang('plugin/yiqixueba','isbusiness'),'businessgroup_info[isbusiness]',$businessgroup_info['isbusiness'],'radio','',0,lang('plugin/yiqixueba','isbusiness_comment'),'','',true);

		showsetting(lang('plugin/yiqixueba','inshoufei'),'businessgroup_info[inshoufei]',$businessgroup_info['inshoufei'],'text','',0,lang('plugin/yiqixueba','inshoufei_comment'),'','',true);

		showsetting(lang('plugin/yiqixueba','inshoufeiqixian'),'businessgroup_info[inshoufeiqixian]',$businessgroup_info['inshoufeiqixian'],'text','',0,lang('plugin/yiqixueba','inshoufeiqixian_comment'),'','',true);

		showsetting(lang('plugin/yiqixueba','enbusinessnum'),'businessgroup_info[enbusinessnum]',$businessgroup_info['enbusinessnum'] ? $businessgroup_info['enbusinessnum'] : '1' ,'text','',0,lang('plugin/yiqixueba','enbusinessnum_comment'),'','',true);

		showsetting(lang('plugin/yiqixueba','enfendian'),'businessgroup_info[enfendian]',$businessgroup_info['enfendian'],'radio','',0,lang('plugin/yiqixueba','enfendian_comment'),'','',true);

		//店员权限
		$dianzhang = dunserialize($businessgroup_info['dianzhang']);
		$dianzhang_array = array();
		$dianyuan_array = array('viewmember','viewxiaofei');
		foreach ( $dianyuan_array as $k => $v ){
			$dianzhang_array[] = array($v,lang('plugin/yiqixueba','dianyuan_'.$v));
		}
		showsetting(lang('plugin/yiqixueba','dianzhang'), array('dianzhang', $dianzhang_array), $dianzhang, 'mcheckbox','',0,lang('plugin/yiqixueba','dianzhang_comment'),'','',true);
		$caiwu = dunserialize($businessgroup_info['caiwu']);
		$caiwu_array = array();
		foreach ( $dianyuan_array as $k => $v ){
			$caiwu_array[] = array($v,lang('plugin/yiqixueba','dianyuan_'.$v));
		}
		showsetting(lang('plugin/yiqixueba','caiwu'), array('caiwu', $caiwu_array), $caiwu, 'mcheckbox','',0,lang('plugin/yiqixueba','caiwu_comment'),'','',true);
		$shouyin = dunserialize($businessgroup_info['shouyin']);
		$shouyin_array = array();
		foreach ( $dianyuan_array as $k => $v ){
			$shouyin_array[] = array($v,lang('plugin/yiqixueba','dianyuan_'.$v));
		}
		showsetting(lang('plugin/yiqixueba','shouyin'), array('shouyin', $shouyin_array), $shouyin, 'mcheckbox','',0,lang('plugin/yiqixueba','shouyin_comment'),'','',true);
		showsetting(lang('plugin/yiqixueba','dianyuanshenhe'),'businessgroup_info[dianyuanshenhe]',$businessgroup_info['dianyuanshenhe'],'radio','',0,lang('plugin/yiqixueba','dianyuanshenhe_comment'),'','',true);
		showsetting(lang('plugin/yiqixueba','contractsample'),'contractsample',$businessgroup_info['contractsample'],'filetext','',0,$contractsamplehtml.lang('plugin/yiqixueba','contractsample_comment'),'','',true);
		showsetting(lang('plugin/yiqixueba','status'),'businessgroup_info[status]',$businessgroup_info['status'],'radio','',0,lang('plugin/yiqixueba','status_comment'),'','',true);

		showsubmit('submit');
		showtablefooter();
		showformfooter();
		echo <<<EOF
<script>
	KindEditor.ready(function(K) {
		var editor1 = K.create('textarea[name="businessgroupdescription"]', {
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
		if(!htmlspecialchars(trim($_GET['businessgroup_info']['businessgroupname']))) {
			cpmsg(lang('plugin/yiqixueba','businessgroupname_nonull'));
		}
		$businessgroupico = addslashes($_POST['businessgroupico']);
		if($_FILES['businessgroupico']) {
			$upload = new discuz_upload();
			if($upload->init($_FILES['businessgroupico'], 'common') && $upload->save()) {
				$businessgroupico = $upload->attach['attachment'];
			}
		}
		if($_POST['delete1'] && addslashes($_POST['businessgroupico'])) {
			$valueparse = parse_url(addslashes($_POST['businessgroupico']));
			if(!isset($valueparse['host']) && !strexists(addslashes($_POST['businessgroupico']), '{STATICURL}')) {
				@unlink($_G['setting']['attachurl'].'temp/'.addslashes($_POST['businessgroupico']));
			}
			$businessgroupico = '';
		}
		$contractsample = addslashes($_POST['contractsample']);
		if($contractsample && $_FILES['contractsample']) {
			if($_FILES['contractsample']['error']){
				cpmsg('文件错误');
			}
			if($_FILES['contractsample']['type']=='application/msword'){
				$contractsample = htmlspecialchars(trim($_GET['businessgroup_info']['businessgroupname'])).time().substr($_FILES['contractsample']['name'],intval(strrpos($_FILES['contractsample']['name'],".")));
				move_uploaded_file($_FILES['contractsample']['tmp_name'], "source/plugin/yiqixueba/data/" . $contractsample);
			}
		}
		if($_POST['delete2'] && addslashes($_POST['contractsample'])) {
				@unlink('source/plugin/yiqixueba/data/'.addslashes($_POST['contractsample']));
			$$contractsample = '';
		}
		$data = array();
		$datas = $_GET['businessgroup_info'];
		$datas['businessgroupico'] = $businessgroupico;
		$datas['contractsample'] = $contractsample;
		$datas['xiaofei'] = serialize($_GET['xiaofei']);;
		$datas['dianzhang'] = serialize($_GET['dianzhang']);;
		$datas['caiwu'] = serialize($_GET['caiwu']);;
		$datas['shouyin'] = serialize($_GET['shouyin']);;
		$datas['businessgroupdescription'] = stripslashes($_POST['businessgroupdescription']);
		foreach ( $datas as $k=>$v) {
			if(in_array($k,array('xiaofei','dianzhang','caiwu','shouyin'))){
				$data[$k] = trim($v);
			}else{
				$data[$k] = htmlspecialchars(trim($v));
			}
			if(!DB::result_first("describe ".DB::table('yiqixueba_brand_businessgroup')." ".$k)) {
				$sql = "alter table ".DB::table('yiqixueba_brand_businessgroup')." add `".$k."` varchar(255) not Null;";
				runquery($sql);
			}
		}
		if($businessgroupid) {
			DB::update('yiqixueba_brand_businessgroup',$data,array('businessgroupid'=>$businessgroupid));
		}else{
			DB::insert('yiqixueba_brand_businessgroup',$data);
		}
		cpmsg(lang('plugin/yiqixueba', 'businessgroup_edit_succeed'), 'action='.$this_page.'&subac=businessgrouplist', 'succeed');
	}

}

?>