<?php

/**
*	一起学吧平台程序
*	文件名：brand_gonggao.inc.php  创建时间：2013-6-23 22:10  杨文
*
*/

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
$this_page = 'plugins&identifier=yiqixueba&pmod=admin&submod=brand_gonggao';

$subac = getgpc('subac');
$subacs = array('gonggaolist','gonggaoedit');
$subac = in_array($subac,$subacs) ? $subac : $subacs[0];

$gonggaoid = getgpc('gonggaoid');
$gonggao_info = $gonggaoid ? DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_brand_gonggao')." WHERE gonggaoid=".$gonggaoid) : array();

if($subac == 'gonggaolist') {
	if(!submitcheck('submit')) {
		showtips(lang('plugin/yiqixueba','gonggao_list_tips'));
		showformheader($this_page.'&subac=gonggaolist');
		showtableheader(lang('plugin/yiqixueba','gonggao_list'));
		showsubtitle(array('', lang('plugin/yiqixueba','gonggaoname'),lang('plugin/yiqixueba','youxiaoqi'), lang('plugin/yiqixueba','displayorder'), lang('plugin/yiqixueba','status'), ''));
		$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_brand_gonggao')." order by displayorder asc");
		while($row = DB::fetch($query)) {
			showtablerow('', array('class="td25"','class="td23"', 'class="td23"', 'class="td23"','class="td25"',''), array(
				"<input class=\"checkbox\" type=\"checkbox\" name=\"delete[]\" value=\"$row[gonggaoid]\">",
			$row['gonggaoname'],
			$row['youxiaoqi'] ? dgmdate($row['youxiaoqi'],'d'):'',
			'<input type="text" class="txt" name="displayordernew['.$row['gonggaoid'].']" value="'.$row['displayorder'].'" size="2" />',
			"<input class=\"checkbox\" type=\"checkbox\" name=\"statusnew[".$row['gonggaoid']."]\" value=\"1\" ".($row['status'] > 0 ? 'checked' : '').">",
				"<a href=\"".ADMINSCRIPT."?action=".$this_page."&subac=gonggaoedit&gonggaoid=$row[gonggaoid]\" class=\"act\">".lang('plugin/yiqixueba','edit')."</a>",
			));
		}
		echo '<tr><td></td><td colspan="6"><div><a href="'.ADMINSCRIPT.'?action='.$this_page.'&subac=gonggaoedit" class="addtr">'.lang('plugin/yiqixueba','add_gonggao').'</a></div></td></tr>';
		showsubmit('submit','submit','del');
		showtablefooter();
		showformfooter();
	}else{
		if($idg = $_GET['delete']) {
			$idg = dintval($idg, is_array($idg) ? true : false);
			if($idg) {
				DB::delete('yiqixueba_brand_gonggao', DB::field('gonggaoid', $idg));
			}
		}
		$displayordernew = $_GET['displayordernew'];
		if(is_array($displayordernew)) {
			foreach ( $displayordernew as $k=>$v) {
				DB::update('yiqixueba_brand_gonggao',array('displayorder'=>intval($v)),array('gonggaoid'=>$k));
			}
		}
	}
}elseif($subac == 'gonggaoedit') {
	if(!submitcheck('submit')) {
		showtips(lang('plugin/yiqixueba','gonggao_edit_tips'));
		showformheader($this_page.'&subac=gonggaoedit','enctype');
		showtableheader(lang('plugin/yiqixueba','gonggao_edit'));
		$gonggaoid ? showhiddenfields(array('gonggaoid'=>$gonggaoid)) : '';
		echo '<script src="static/js/calendar.js" type="text/javascript"></script>';
		showsetting(lang('plugin/yiqixueba','gonggaoname'),'gonggao_info[gonggaoname]',$gonggao_info['gonggaoname'],'text','',0,lang('plugin/yiqixueba','gonggaoname_comment'),'','',true);
		showsetting(lang('plugin/yiqixueba','youxiaoqi'),'gonggao_info[youxiaoqi]',$gonggao_info['youxiaoqi'] ? dgmdate($gonggao_info['youxiaoqi'],'d'):'','calendar','',0,lang('plugin/yiqixueba','youxiaoqi_comment'),'','',true);
		echo '<script src="source/plugin/yiqixueba/template/kindeditor/kindeditor.js" type="text/javascript"></script>';
		echo '<link rel="stylesheet" href="source/plugin/yiqixueba/template/kindeditor/themes/default/default.css" />';
		echo '<link rel="stylesheet" href="source/plugin/yiqixueba/template/kindeditor/plugins/code/prettify.css" />';
		echo '<script src="source/plugin/yiqixueba/template/kindeditor/lang/zh_CN.js" type="text/javascript"></script>';
		echo '<script src="source/plugin/yiqixueba/template/kindeditor/prettify.js" type="text/javascript"></script>';
		echo '<tr class="noborder" ><td colspan="2" class="td27" s="1">'.lang('plugin/yiqixueba','gonggaotext').':</td></tr>';
		echo '<tr class="noborder" ><td colspan="2" ><textarea name="gonggaotext" style="width:700px;height:200px;visibility:hidden;">'.$gonggao_info['gonggaotext'].'</textarea></td></tr>';
		showsetting(lang('plugin/yiqixueba','status'),'gonggao_info[status]',$gonggao_info['status'],'radio','',0,lang('plugin/yiqixueba','status_comment'),'','',true);
		showsubmit('submit');
		showtablefooter();
		showformfooter();
		echo <<<EOF
<script>
	KindEditor.ready(function(K) {
		var editor1 = K.create('textarea[name="gonggaotext"]', {
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
		if(!htmlspecialchars(trim($_GET['gonggao_info']['gonggaoname']))) {
			cpmsg(lang('plugin/yiqixueba','gonggaoname_nonull'));
		}
		$data = array();
		$datas = $_GET['gonggao_info'];
		$datas['gonggaotext'] = stripslashes($_POST['gonggaotext']);
		$data['createtime'] = time();
		foreach ( $datas as $k=>$v) {
			$data[$k] = trim($v);
			if(!DB::result_first("describe ".DB::table('yiqixueba_brand_gonggao')." ".$k)) {
				$sql = "alter table ".DB::table('yiqixueba_brand_gonggao')." add `".$k."` varchar(255) not Null;";
				runquery($sql);
			}
		}
		$data['youxiaoqi'] = strtotime($data['youxiaoqi']);
		if($gonggaoid) {
			DB::update('yiqixueba_brand_gonggao',$data,array('gonggaoid'=>$gonggaoid));
		}else{
			DB::insert('yiqixueba_brand_gonggao',$data);
		}
		cpmsg(lang('plugin/yiqixueba', 'gonggao_edit_succeed'), 'action='.$this_page.'&subac=gonggaolist', 'succeed');
	}
}

?>