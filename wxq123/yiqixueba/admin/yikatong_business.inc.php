<?php

/**
*	一起学吧平台程序
*	文件名：yikatong_business.inc.php  创建时间：2013-6-19 13:58  杨文
*
*/

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
$this_page = 'plugins&identifier=yiqixueba&pmod=admin&submod=yikatong_business';

$subac = getgpc('subac');
$subacs = array('businesslist','businessedit');
$subac = in_array($subac,$subacs) ? $subac : $subacs[0];

//编辑状态下的商家ID
$businessid = getgpc('businessid');
$business_info = $businessid ? DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_yikatong_business')." WHERE businessid=".$businessid) : array();


//定义该页面所需要的最基本的设置项数组
$bixusetting_array = array('shop_table','fields','money','jifen','goods_table','goodsfields');
foreach ( $bixusetting_array as $k => $v ){
	if(!$plugin_setting['yiqixueba_yikatong_'.$v]){
		cpmsg(lang('plugin/yiqixueba','business_fields_error'),'action=plugins&identifier=yiqixueba&pmod=admin&submod=yikatong_setting','error');
	}
}
$shop_files = dunserialize($plugin_setting['yiqixueba_yikatong_fields']);
$goods_files = dunserialize($plugin_setting['yiqixueba_yikatong_goodsfields']);
if(!$shop_files['uid'] || !$shop_files['shopid'] || !$shop_files['shopname'] || !$goods_files['goodsid'] ||!$goods_files['goodsname'] ){
	cpmsg(lang('plugin/yiqixueba','business_fields_error'),'action=plugins&identifier=yiqixueba&pmod=admin&submod=yikatong_setting','error');
}

//dump($plugin_setting);
if($subac == 'businesslist') {
	if(!submitcheck('submit')) {
		showtips(lang('plugin/yiqixueba','business_list_tips'));
		showformheader($this_page.'&subac=businesslist');
		showtableheader(lang('plugin/yiqixueba','business_list'));
		showsubtitle(array('', lang('plugin/yiqixueba','businessname'), lang('plugin/yiqixueba','businessinfo'), lang('plugin/yiqixueba','caiwuinfo'),lang('plugin/yiqixueba','photo'),lang('plugin/yiqixueba','shopinfo'),lang('plugin/yiqixueba','goodsinfo'),lang('plugin/yiqixueba','cardinfo'), lang('plugin/yiqixueba','status'), ''));
		$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_yikatong_business')." order by businessid desc");
		while($row = DB::fetch($query)) {

			//商家组信息
			$businessgroup_info = DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_yikatong_businessgroup')." WHERE businessgroupid=".$row['businessgroupid']);

			//会员卡信息
			$cardtype_info = DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_yikatong_cardcat')." WHERE cardcatid=".$row['cardtype']);

			//商家选择的商家组和会员卡的算式
			$sxzjt = intval($businessgroup_info['inshoufei']) .'+'. intval($cardtype_info['cardpice']) .'*'. intval($row['cardnum']);

			//商家选择的商家组和会员卡所需要的资金数
			$sxzj = intval($businessgroup_info['inshoufei']) + intval($cardtype_info['cardpice']) * intval($row['cardnum']);

			//商家帐号上所拥有的金钱数
			$zhye = intval(DB::result_first("SELECT extcredits".intval($plugin_setting['yiqixueba_yikatong_money'])." FROM ".DB::table('common_member_count')." WHERE uid='".$row['uid']."'"));

			//商家帐号上所拥有的积分数
			$zhjf = intval(DB::result_first("SELECT extcredits".intval($plugin_setting['yiqixueba_yikatong_jifen'])." FROM ".DB::table('common_member_count')." WHERE uid='".$row['uid']."'"));

			//商家所处的状态
			$status_text = '';
			$status_array = array();
			if($row['status']){
				$status_array[] = lang('plugin/yiqixueba','tongguo');
			}else{
				if($zhye<$sxzj){
					$status_array[] = lang('plugin/yiqixueba','yuebuzu');
				}
				if(!$row['gerenphoto'] ||!$row['shenfenphoto'] ||!$row['contractimage'] ){
					$status_array[] = lang('plugin/yiqixueba','ziliaobuquan');
				}
				if(!$status_array){
					$status_array[] = lang('plugin/yiqixueba','daishen');
				}
			}
			$status_text = implode("<br />",$status_array);

			//商家所拥有的店铺情况
			$shop_zongnum = DB::result_first("SELECT count(*) FROM ".DB::table($plugin_setting['yiqixueba_yikatong_shop_table'])." WHERE ".$shop_files['uid']."=".$row['uid']);
			$shop_spnum = DB::result_first("SELECT count(*) FROM ".DB::table('yiqixueba_yikatong_shop')." WHERE uid=".$row['uid']);

			showtablerow('', array('class="td25"','class="td29"','class="td29"', 'class="td29"', 'class="td29"','class="td29"','class="td29"','class="td29"','class="td29"','class="td25"',''), array(
				"<input class=\"checkbox\" type=\"checkbox\" name=\"delete[]\" value=\"$row[businessid]\">",
				'<strong>'.$row['businessname'].'</strong><br />'.$businessgroup_info['businessgroupname'].'<br />'.DB::result_first("SELECT username FROM ".DB::table('common_member')." WHERE uid=".$row['uid']),
				lang('plugin/yiqixueba','relname').':'.$row['relname'].'&nbsp;&nbsp;'.
				($row['sex'] ==1 ?lang('plugin/yiqixueba','man') : ($row['sex'] ==2 ?lang('plugin/yiqixueba','woman') : '')).'<br />'.
				$row['phone'].'<br />'.$row['address'],
				lang('plugin/yiqixueba','sxzjs').':'.$sxzjt.'<br />'.
				lang('plugin/yiqixueba','zhyes').':'.$zhye.'<br />'.
				lang('plugin/yiqixueba','zhjfs').':'.$zhjf,
				lang('plugin/yiqixueba','gerenphotos').':'.($row['gerenphoto']?lang('plugin/yiqixueba','yishangchuan'):lang('plugin/yiqixueba','zanwu')).'<br />'.
				lang('plugin/yiqixueba','shenfenphotos').':'.($row['shenfenphoto']?lang('plugin/yiqixueba','yishangchuan'):lang('plugin/yiqixueba','zanwu')).'<br />'.
				lang('plugin/yiqixueba','contractimages').':'.($row['contractimage']?lang('plugin/yiqixueba','yishangchuan'):lang('plugin/yiqixueba','zanwu')),
				lang('plugin/yiqixueba','shop_spnum').':'.$shop_spnum.'<br />'.
				lang('plugin/yiqixueba','shop_weinum').':'.($shop_zongnum-$shop_spnum).'<br />'.
				lang('plugin/yiqixueba','shop_zongnum').':'.$shop_zongnum,
				'',
				'',
				$status_text,
				"<a href=\"".ADMINSCRIPT."?action=".$this_page."&subac=businessedit&businessid=$row[businessid]\" class=\"act\">".lang('plugin/yiqixueba','edit')."</a>",
			));
		}
		echo '<tr><td></td><td colspan="6"><div><a href="'.ADMINSCRIPT.'?action='.$this_page.'&subac=businessedit" class="addtr">'.lang('plugin/yiqixueba','add_business').'</a></div></td></tr>';
		showsubmit('submit','submit','del');
		showtablefooter();
		showformfooter();
	}else{
		if($ids = $_GET['delete']) {
			$ids = dintval($ids, is_array($ids) ? true : false);
			$delphoto_fields = array('gerenphoto','shenfenphoto','contractimage');
			foreach ( $ids as $k => $v ){
				$delbusiness_info = DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_yikatong_business')." WHERE businessid=".$v);
				foreach ( $delphoto_fields as $dk => $dv ){
					$valueparse = parse_url($delbusiness_info[$dv]);
					if(!isset($valueparse['host']) && !strexists($delbusiness_info[$dv], '{STATICURL}')) {
						@unlink($_G['setting']['attachurl'].'common/'.$delbusiness_info[$dv]);
					}
				}
				DB::delete('yiqixueba_yikatong_business',array('businessid'=>$v));
			}

		}
		cpmsg(lang('plugin/yiqixueba', 'business_edit_succeed'), 'action='.$this_page.'&subac=businesslist', 'succeed');
	}
}elseif($subac == 'businessedit') {
	if(!submitcheck('submit')) {
		//商家组option
		$businessgroup_option = '';
		$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_yikatong_businessgroup')." WHERE status = 1 order by businessgroupid asc");
		while($row = DB::fetch($query)) {
			$businessgroup_option .= '<option value="'.$row['businessgroupid'].'" '.($business_info['businessgroupid']==$row['businessgroupid'] ? ' selected':'').'>'.$row['businessgroupname'].'</option>';

		}
		//性别option
		$sex_option = '<option value="0" '.($business_info['sex']==0 ? ' selected':'').'>'.lang('plugin/yiqixueba','baomi').'</option><option value="1" '.($business_info['sex']==1 ? ' selected':'').'>'.lang('plugin/yiqixueba','man').'</option><option value="2" '.($business_info['sex']==2 ? ' selected':'').'>'.lang('plugin/yiqixueba','woman').'</option>';
		//会员卡option
		$cardcat_option = '';
		$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_yikatong_cardcat')." WHERE status = 1 order by cardcatid asc");
		while($row = DB::fetch($query)) {
			$cardcat_option .= '<option value="'.$row['cardcatid'].'" '.($business_info['cardtype']==$row['cardcatid'] ? ' selected':'').'>'.$row['cardcatname'].'</option>';
		}
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
		showsetting(lang('plugin/yiqixueba','cardtype'),'','','<select name="business_info[cardtype]">'.$cardcat_option.'</select>','',0,lang('plugin/yiqixueba','cardtype_comment'),'','',true);
		showsetting(lang('plugin/yiqixueba','cardnum'),'business_info[cardnum]',$business_info['cardnum'],'text','',0,lang('plugin/yiqixueba','cardnum_comment'),'','',true);
		if($business_info['businessgroupid']){
			$businessgroup_info = DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_yikatong_businessgroup')." WHERE businessgroupid=".$business_info['businessgroupid']);
			//dump($businessgroup_info);
			$cardtype_info = $business_info['businessgroupid'] ? DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_yikatong_cardcat')." WHERE cardcatid=".$business_info['cardtype']) : array();
			//dump($cardtype_info);
			showtablefooter();
			showtableheader(lang('plugin/yiqixueba','business_shenhe'));
			showtablerow('', array('class="td23"','class="td28"',''), array(
				lang('plugin/yiqixueba','business_base_info'),
				'该商家选择的是：【'.$businessgroup_info['businessgroupname'].'】商家组，该商家组的入驻费用是：'.$businessgroup_info['inshoufei'].'元，选择的会员卡类别是【'.$cardtype_info['cardcatname'].'】，共计购置了<strong>'.$business_info['cardnum'].'</strong>张会员卡，所需的费用为：',
				'',

			));
			showtablefooter();
			showtableheader();
			showsetting(lang('plugin/yiqixueba','business_status'),'business_info[status]',$business_info['status'],'radio','',0,lang('plugin/yiqixueba','business_status_comment'),'','',true);
		}
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
		if(!htmlspecialchars(trim($_GET['business_info']['businessname']))) {
			cpmsg(lang('plugin/yiqixueba','businessname_nonull'));
		}
		$gerenphoto = addslashes($_POST['business_info']['gerenphoto']);
		if($_FILES['business_info']['gerenphoto']) {
			$upload = new discuz_upload();
			if($upload->init($_FILES['business_info']['gerenphoto'], 'common') && $upload->save()) {
				$gerenphoto = $upload->attach['attachment'];
			}
		}
		if($_POST['delete1'] && addslashes($_POST['business_info']['gerenphoto'])) {
			$valueparse = parse_url(addslashes($_POST['business_info']['gerenphoto']));
			if(!isset($valueparse['host']) && !strexists(addslashes($_POST['business_info']['gerenphoto']), '{STATICURL}')) {
				@unlink($_G['setting']['attachurl'].'common/'.addslashes($_POST['business_info']['gerenphoto']));
			}
			$gerenphoto = '';
		}
		$shenfenphoto = addslashes($_POST['business_info']['shenfenphoto']);
		if($_FILES['business_info']['shenfenphoto']) {
			$upload = new discuz_upload();
			if($upload->init($_FILES['business_info']['shenfenphoto'], 'common') && $upload->save()) {
				$shenfenphoto = $upload->attach['attachment'];
			}
		}
		if($_POST['delete2'] && addslashes($_POST['business_info']['shenfenphoto'])) {
			$valueparse = parse_url(addslashes($_POST['business_info']['shenfenphoto']));
			if(!isset($valueparse['host']) && !strexists(addslashes($_POST['business_info']['shenfenphoto']), '{STATICURL}')) {
				@unlink($_G['setting']['attachurl'].'common/'.addslashes($_POST['business_info']['shenfenphoto']));
			}
			$shenfenphoto = '';
		}
		$contractimage = addslashes($_POST['business_info']['contractimage']);
		if($_FILES['business_info']['contractimage']) {
			$upload = new discuz_upload();
			if($upload->init($_FILES['business_info']['contractimage'], 'common') && $upload->save()) {
				$contractimage = $upload->attach['attachment'];
			}
		}
		if($_POST['delete3'] && addslashes($_POST['business_info']['contractimage'])) {
			$valueparse = parse_url(addslashes($_POST['business_info']['contractimage']));
			if(!isset($valueparse['host']) && !strexists(addslashes($_POST['business_info']['contractimage']), '{STATICURL}')) {
				@unlink($_G['setting']['attachurl'].'common/'.addslashes($_POST['business_info']['contractimage']));
			}
			$contractimage = '';
		}
		$datas = $_GET['business_info'];
		$datas['gerenphoto'] = $gerenphoto;
		$datas['shenfenphoto'] = $shenfenphoto;
		$datas['contractimage'] = $contractimage;
		$datas['businesssummary'] = stripslashes($_POST['businesssummary']);
		foreach ( $datas as $k=>$v) {
			$data[$k] = htmlspecialchars(trim($v));
			if(!DB::result_first("describe ".DB::table('yiqixueba_yikatong_business')." ".$k)) {
				$sql = "alter table ".DB::table('yiqixueba_yikatong_business')." add `".$k."` varchar(255) not Null;";
				runquery($sql);
			}
		}
		if($businessid) {
			DB::update('yiqixueba_yikatong_business',$data,array('businessid'=>$businessid));
		}else{
			DB::insert('yiqixueba_yikatong_business',$data);
		}
		cpmsg(lang('plugin/yiqixueba', 'business_edit_succeed'), 'action='.$this_page.'&subac=businesslist', 'succeed');
	}
}

?>