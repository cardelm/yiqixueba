<?php

/**
*	一起学吧平台程序
*	文件名：brand_business.inc.php  创建时间：2013-6-23 01:56  杨文
*
*/

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
$this_page = 'plugins&identifier=yiqixueba&pmod=admin&submod=brand_business';

$subac = getgpc('subac');
$subacs = array('businesslist','businessedit');
$subac = in_array($subac,$subacs) ? $subac : $subacs[0];

$businessid = getgpc('businessid');
$business_info = $businessid ? DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_brand_business')." WHERE businessid=".$businessid) : array();


if($subac == 'businesslist') {
	if(!submitcheck('submit')) {
		showtips(lang('plugin/yiqixueba','business_list_tips'));
		showformheader($this_page.'&subac=businesslist');
		showtableheader(lang('plugin/yiqixueba','business_list'));
		showsubtitle(array('', lang('plugin/yiqixueba','businessname'), lang('plugin/yiqixueba','businessinfo'), lang('plugin/yiqixueba','photo'),lang('plugin/yiqixueba','shopinfo'),lang('plugin/yiqixueba','goodsinfo'),lang('plugin/yiqixueba','cardinfo'), lang('plugin/yiqixueba','status'), ''));
		$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_brand_business')." order by businessid desc");
		while($row = DB::fetch($query)) {

			//商家组信息
			$businessgroup_info = DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_brand_businessgroup')." WHERE businessgroupid=".$row['businessgroupid']);

			//商家选择的商家组和会员卡的算式
			$sxzjt = intval($businessgroup_info['inshoufei']) .'+'. intval($cardtype_info['cardpice']) .'*'. intval($row['cardnum']);

			//商家选择的商家组和会员卡所需要的资金数
			$sxzj = intval($businessgroup_info['inshoufei']) + intval($cardtype_info['cardpice']) * intval($row['cardnum']);


			//商家所拥有的店铺情况
			$shop_zongnum = DB::result_first("SELECT count(*) FROM ".DB::table('yiqixueba_brand_shop')." WHERE uid=".$row['uid']);
			$shop_spnum = DB::result_first("SELECT count(*) FROM ".DB::table('yiqixueba_brand_shop')." WHERE uid=".$row['uid']);

			showtablerow('', array('class="td25"','class="td29"','class="td29"', 'class="td29"', 'class="td29"','class="td29"','class="td29"','class="td29"','class="td29"','class="td25"',''), array(
				"<input class=\"checkbox\" type=\"checkbox\" name=\"delete[]\" value=\"$row[businessid]\">",
				'<strong>'.$row['businessname'].'</strong><br />'.$businessgroup_info['businessgroupname'].'<br />'.DB::result_first("SELECT username FROM ".DB::table('common_member')." WHERE uid=".$row['uid']),
				lang('plugin/yiqixueba','relname').':'.$row['relname'].'&nbsp;&nbsp;'.
				($row['sex'] ==1 ?lang('plugin/yiqixueba','man') : ($row['sex'] ==2 ?lang('plugin/yiqixueba','woman') : '')).'<br />'.
				$row['phone'].'<br />'.$row['address'],
				lang('plugin/yiqixueba','gerenphotos').':'.($row['gerenphoto']?lang('plugin/yiqixueba','yishangchuan'):lang('plugin/yiqixueba','zanwu')).'<br />'.
				lang('plugin/yiqixueba','shenfenphotos').':'.($row['shenfenphoto']?lang('plugin/yiqixueba','yishangchuan'):lang('plugin/yiqixueba','zanwu')).'<br />'.
				lang('plugin/yiqixueba','contractimages').':'.($row['contractimage']?lang('plugin/yiqixueba','yishangchuan'):lang('plugin/yiqixueba','zanwu')),
				lang('plugin/yiqixueba','shop_spnum').':'.$shop_spnum.'<br />'.
				lang('plugin/yiqixueba','shop_weinum').':'.($shop_zongnum-$shop_spnum).'<br />'.
				lang('plugin/yiqixueba','shop_zongnum').':'.$shop_zongnum,
				'',
				'',
				$status_text,
				"<a href=\"".ADMINSCRIPT."?action=".$this_page."&subac=businessedit&businessid=$row[businessid]\" class=\"act\">".lang('plugin/yiqixueba','edit')."</a>&nbsp;&nbsp;<a href=\"".ADMINSCRIPT."?action=plugins&identifier=yiqixueba&pmod=admin&submod=brand_shop&subac=shopedit&businessid=$row[businessid]\" class=\"act\">".lang('plugin/yiqixueba','shop')."</a>",
			));
		}
		echo '<tr><td></td><td colspan="6"><div><a href="'.ADMINSCRIPT.'?action='.$this_page.'&subac=businessedit" class="addtr">'.lang('plugin/yiqixueba','add_business').'</a></div></td></tr>';
		showsubmit('submit','submit','del');
		showtablefooter();
		showformfooter();
	}else{
	}
}elseif($subac == 'businessedit') {
	if(!submitcheck('submit')) {
		//商家组option
		$businessgroup_option = '';
		$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_brand_businessgroup')." WHERE status = 1 order by businessgroupid asc");
		while($row = DB::fetch($query)) {
			$businessgroup_option .= '<option value="'.$row['businessgroupid'].'" '.($business_info['businessgroupid']==$row['businessgroupid'] ? ' selected':'').'>'.$row['businessgroupname'].'</option>';

		}
		//性别option
		$sex_option = '<option value="0" '.($business_info['sex']==0 ? ' selected':'').'>'.lang('plugin/yiqixueba','baomi').'</option><option value="1" '.($business_info['sex']==1 ? ' selected':'').'>'.lang('plugin/yiqixueba','man').'</option><option value="2" '.($business_info['sex']==2 ? ' selected':'').'>'.lang('plugin/yiqixueba','woman').'</option>';
		if($business_info['gerenphoto']!='') {
			$gerenphoto = str_replace('{STATICURL}', STATICURL, $business_info['gerenphoto']);
			if(!preg_match("/^".preg_quote(STATICURL, '/')."/i", $gerenphoto) && !(($valueparse = parse_url($gerenphoto)) && isset($valueparse['host']))) {
				$gerenphoto = $_G['setting']['attachurl'].'common/'.$business_info['gerenphoto'].'?'.random(6);
			}
			$gerenphotohtml = '<br /><label><input type="checkbox" class="checkbox" name="delete1" value="yes" /> '.$lang['del'].'</label><br /><img src="'.$gerenphoto.'" />';
		}
		if($business_info['shenfenphoto']!='') {
			$shenfenphoto = str_replace('{STATICURL}', STATICURL, $business_info['shenfenphoto']);
			if(!preg_match("/^".preg_quote(STATICURL, '/')."/i", $shenfenphoto) && !(($valueparse = parse_url($shenfenphoto)) && isset($valueparse['host']))) {
				$shenfenphoto = $_G['setting']['attachurl'].'common/'.$business_info['shenfenphoto'].'?'.random(6);
			}
			$shenfenphotohtml = '<br /><label><input type="checkbox" class="checkbox" name="delete2" value="yes" /> '.$lang['del'].'</label><br /><img src="'.$shenfenphoto.'" />';
		}
		if($business_info['contractimage']!='') {
			$contractimage = str_replace('{STATICURL}', STATICURL, $business_info['contractimage']);
			if(!preg_match("/^".preg_quote(STATICURL, '/')."/i", $contractimage) && !(($valueparse = parse_url($contractimage)) && isset($valueparse['host']))) {
				$contractimage = $_G['setting']['attachurl'].'common/'.$business_info['contractimage'].'?'.random(6);
			}
			$contractimagehtml = '<br /><label><input type="checkbox" class="checkbox" name="delete3" value="yes" /> '.$lang['del'].'</label><br /><img src="'.$contractimage.'" />';
		}
		showtips(lang('plugin/yiqixueba','business_edit_tips'));
		showformheader($this_page.'&subac=businessedit','enctype');
		showtableheader(lang('plugin/yiqixueba','business_edit'));
		$businessid ? showhiddenfields(array('businessid'=>$businessid)) : '';
		showsetting(lang('plugin/yiqixueba','uid'),'business_info[uid]',$business_info['uid'],'text','',0,lang('plugin/yiqixueba','uid_comment'),'','',true);
		showsetting(lang('plugin/yiqixueba','businessname'),'business_info[businessname]',$business_info['businessname'],'text','',0,lang('plugin/yiqixueba','businessname_comment'),'','',true);
		showsetting(lang('plugin/yiqixueba','businessgroup'),'','','<select name="businessgroupid">'.$businessgroup_option.'</select>','',0,lang('plugin/yiqixueba','businessgroup_comment'),'','',true);
		showsetting(lang('plugin/yiqixueba','relname'),'business_info[relname]',$business_info['relname'],'text','',0,lang('plugin/yiqixueba','relname_comment'),'','',true);
		showsetting(lang('plugin/yiqixueba','sex'),'','','<select name="business_info[sex]">'.$sex_option.'</select>','',0,lang('plugin/yiqixueba','sex_comment'),'','',true);
		showsetting(lang('plugin/yiqixueba','phone'),'business_info[phone]',$business_info['phone'],'text','',0,lang('plugin/yiqixueba','phone_comment'),'','',true);
		showsetting(lang('plugin/yiqixueba','address'),'business_info[address]',$business_info['address'],'text','',0,lang('plugin/yiqixueba','address_comment'),'','',true);
		echo '<script src="static/js/calendar.js" type="text/javascript"></script>';
		showsetting(lang('plugin/yiqixueba','birthday'),'business_info[birthday]',$business_info['birthday'] ? dgmdate($business_info['birthday'],'d') : '','calendar','',0,lang('plugin/yiqixueba','birthday_comment'),'','',true);
		showsetting(lang('plugin/yiqixueba','gerenphoto'),'business_info[gerenphoto]',$business_info['gerenphoto'],'filetext','',0,lang('plugin/yiqixueba','gerenphoto_comment').$gerenphotohtml,'','',true);
		showsetting(lang('plugin/yiqixueba','shenfenno'),'business_info[shenfenno]',$business_info['shenfenno'],'text','',0,lang('plugin/yiqixueba','shenfenno_comment'),'','',true);
		showsetting(lang('plugin/yiqixueba','shenfenphoto'),'business_info[shenfenphoto]',$business_info['shenfenphoto'],'filetext','',0,lang('plugin/yiqixueba','shenfenphoto_comment').$shenfenphotohtml,'','',true);
		echo '<script src="source/plugin/yiqixueba/template/kindeditor/kindeditor.js" type="text/javascript"></script>';
		echo '<link rel="stylesheet" href="source/plugin/yiqixueba/template/kindeditor/themes/default/default.css" />';
		echo '<link rel="stylesheet" href="source/plugin/yiqixueba/template/kindeditor/plugins/code/prettify.css" />';
		echo '<script src="source/plugin/yiqixueba/template/kindeditor/lang/zh_CN.js" type="text/javascript"></script>';
		echo '<script src="source/plugin/yiqixueba/template/kindeditor/prettify.js" type="text/javascript"></script>';
		echo '<tr class="noborder" ><td colspan="2" class="td27" s="1">'.lang('plugin/yiqixueba','businesssummary').':</td></tr>';
		echo '<tr class="noborder" ><td colspan="2" ><textarea name="businesssummary" style="width:700px;height:200px;visibility:hidden;">'.$business_info['businesssummary'].'</textarea></td></tr>';
		showsetting(lang('plugin/yiqixueba','contractimage'),'business_info[contractimage]',$business_info['contractimage'],'filetext','',0,lang('plugin/yiqixueba','contractimage_comment').$contractimagehtml,'','',true);
		showsetting(lang('plugin/yiqixueba','status'),'business_info[status]',$business_info['status'],'radio','',0,lang('plugin/yiqixueba','status_comment'),'','',true);
		showsubmit('submit');
		showtablefooter();
		showformfooter();
		echo <<<EOF
<script>
	KindEditor.ready(function(K) {
		var editor1 = K.create('textarea[name="businesssummary"]', {
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
		$uid = intval($_GET['business_info']['uid']);
		if(!$uid || DB::result_first("SELECT count(*) FROM ".DB::table('common_member')." WHERE uid=".$uid) == 0){
			cpmsg(lang('plugin/yiqixueba', 'uid_error'), 'action='.$this_page.'&subac=businesslist');
		}
		if(!htmlspecialchars(trim($_GET['business_info']['businessname']))) {
			cpmsg(lang('plugin/yiqixueba','businessname_nonull'));
		}
		$datas = $_GET['business_info'];
		foreach ( $datas as $k=>$v) {
			$data[$k] = htmlspecialchars(trim($v));
			if(!DB::result_first("describe ".DB::table('yiqixueba_brand_business')." ".$k)) {
				$sql = "alter table ".DB::table('yiqixueba_brand_business')." add `".$k."` varchar(255) not Null;";
				runquery($sql);
			}
		}
		if($businessid) {
			DB::update('yiqixueba_brand_business',$data,array('businessid'=>$businessid));
		}else{
			DB::insert('yiqixueba_brand_business',$data);
		}
		cpmsg(lang('plugin/yiqixueba', 'business_edit_succeed'), 'action='.$this_page.'&subac=businesslist', 'succeed');
	}
}

?>