<?php

/**
*	一起学吧平台程序
*	文件名：yikatong_shop.inc.php  创建时间：2013-6-26 09:30  杨文
*
*/

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
$this_page = 'plugins&identifier=yiqixueba&pmod=admin&submod=yikatong_shop';

$subac = getgpc('subac');
$subacs = array('shoplist','shopedit','shopselect');
$subac = in_array($subac,$subacs) ? $subac : $subacs[0];

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
//店铺数据初始化
$query = DB::query("SELECT * FROM ".DB::table($plugin_setting['yiqixueba_yikatong_shop_table']));
while($row = DB::fetch($query)) {
	if(DB::result_first("SELECT count(*) FROM ".DB::table('yiqixueba_yikatong_shop')." WHERE shopid=".$row[$shop_files['shopid']])==0){
		//DB::insert('yiqixueba_yikatong_shop', array('shopid'=>$row[$shop_files['shopid']],'uid'=>$row[$shop_files['uid']]));
	}
}

$upshopid = getgpc('upshopid');

$shopid = getgpc('shopid');
$shop_info = $shopid ? DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_yikatong_shop')." WHERE shopid=".$shopid) : array();

if($subac == 'shoplist') {
	if(!submitcheck('submit')) {
		showtips(lang('plugin/yiqixueba','shop_list_tips'));
		showformheader($this_page.'&subac=shoplist');
		showtableheader();
		//每页显示条数
		$tpp = intval(getgpc('tpp')) ? intval(getgpc('tpp')) : '20';
		$select[$tpp] = $tpp ? "selected='selected'" : '';
		$tpp_options = "<option value='20' $select[20]>20</option><option value='50' $select[50]>50</option><option value='100' $select[100]>100</option>";
		//
		//////搜索内容
		$shopname = trim(getgpc('shopname'));
		$shopuid = trim(getgpc('shopuid'));
		echo '<tr><td>';
		//店铺名称和所属用户搜索
		echo lang('plugin/yiqixueba','shopname').'&nbsp;&nbsp;<input type="text" name="shopname" value="'.$shopname.'" size="20">&nbsp;&nbsp;'.lang('plugin/yiqixueba','shopuid').'&nbsp;&nbsp;<input type="text" name="shopuid" value="'.$shopuid.'" size="10">&nbsp;&nbsp;';
		//商家组
		$businessgroupid = intval(getgpc('businessgroupid'));
		$businessgroup_select = '<select name="businessgroupid"><option value="">'.lang('plugin/yiqixueba','all').'</option>';
		$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_yikatong_businessgroup')."  WHERE status = 1 ");
		while($row = DB::fetch($query)) {
			$businessgroup_select .= '<option value="'.$row['businessgroupid'].'" '.($businessgroupid == $row['businessgroupid'] ? ' selected' : '').'>'.$row['businessgroupname'].'</option>';
		}
		$businessgroup_select .= '</select>';
		echo '&nbsp;&nbsp;'.lang('plugin/yiqixueba','businessgroup').'&nbsp;&nbsp;'.$businessgroup_select;
		$status = trim(getgpc('status'));
		echo '&nbsp;&nbsp;'.lang('plugin/yiqixueba','shenhe').'&nbsp;&nbsp;<select name="status"><option value="">'.lang('plugin/yiqixueba','all').'</option><option value="2" '.($status == 2 ? ' selected' : '').'>'.lang('plugin/yiqixueba','shenheed').'</option><option value="1" '.($status == 1 ? ' selected' : '').'>'.lang('plugin/yiqixueba','noshenhe').'</option></select>';
		//每页显示条数
		echo "&nbsp;&nbsp;".$lang['perpage']."<select name=\"tpp\">$tpp_options</select>&nbsp;&nbsp;<input class=\"btn\" type=\"submit\" value=\"$lang[search]\" /></td></tr>";
		//////搜索内容
		showtablefooter();
		showtableheader(lang('plugin/yiqixueba','shop_list'));
		showsubtitle(array('', lang('plugin/yiqixueba','shopname'),lang('plugin/yiqixueba','shopuid'), lang('plugin/yiqixueba','businessgroup'), lang('plugin/yiqixueba','status'), ''));
		$get_text = '&tpp='.$tpp.'&businessgroupid='.$businessgroupid.'&status='.$status.'&shopuid='.$shopuid.'&shopname='.$shopname;
		//搜索条件处理
		$perpage = $tpp;
		$start = ($page - 1) * $perpage;
		$where = "";
		$where .= $businessgroupid ? " and businessgroupid=".$businessgroupid : "";
		$where .= $status ? " and status = ".($status-1) : "";
		$where .= $shopname ? " and shopname like '%".$shopname."%'" : "";
		$where .= DB::result_first("SELECT uid FROM ".DB::table('common_member')." WHERE username ='".$shopuid."'") ? " and uid =".(DB::result_first("SELECT uid FROM ".DB::table('common_member')." WHERE username ='".$shopuid."'")) : "";
		if($where) {
			$where = " where ".substr($where,4,strlen($where)-4);
		}
		if(!$where){
			$where .= " WHERE upshopid = 0 ";
		}
		$shopcount = DB::result_first("SELECT count(*) FROM ".DB::table('yiqixueba_yikatong_shop').$where);
		$multi = multi($shopcount, $perpage, $page, ADMINSCRIPT."?action=".$this_page."&subac=shoplist".$get_text);

		$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_yikatong_shop').$where." order by shopid desc limit ".$start.", ".$perpage);
		while($row = DB::fetch($query)) {
			$mknum = DB::result_first("SELECT count(*) FROM ".DB::table('yiqixueba_yikatong_shop')." WHERE upshopid=".$row['shopid']);
			DB::update('yiqixueba_yikatong_shop', array('shopname'=>DB::result_first("SELECT ".$shop_files['shopname']." FROM ".DB::table($plugin_setting['yiqixueba_yikatong_shop_table'])." WHERE ".$shop_files['shopid']." = ".$row['shopid'])),array('shopid'=>$row['shopid']));
			showtablerow('', array('class="td25"','class="td28"', 'class="td23"', 'class="td23"','class="td25"',''), array(
				($mknum ?'<a href="javascript:;" class="right" onclick="toggle_group(\'menu_'.$row['shopid'].'\', this)">[+]</a>':'')."<input class=\"checkbox\" type=\"checkbox\" name=\"delete[]\" value=\"$row[shopid]\" ".($mknum ?"disabled=\"disabled\"":"").">",
				DB::result_first("SELECT ".$shop_files['shopname']." FROM ".DB::table($plugin_setting['yiqixueba_yikatong_shop_table'])." WHERE ".$shop_files['shopid']." = ".$row['shopid']),
				DB::result_first("SELECT username FROM ".DB::table('common_member')." WHERE uid=".$row['uid']),
				$row['businessgroupid'] ? DB::result_first("SELECT businessgroupname FROM ".DB::table('yiqixueba_yikatong_businessgroup')." WHERE businessgroupid=".$row['businessgroupid']) : '',
				"<input class=\"checkbox\" type=\"checkbox\" name=\"statusnew[".$row['shopid']."]\" value=\"1\" ".($row['status'] > 0 ? 'checked' : '').">",
				"<a href=\"".ADMINSCRIPT."?action=".$this_page."&subac=shopselect&shopid=$row[shopid]\" class=\"act\">".lang('plugin/yiqixueba','shenhe')."</a>".(!$row['upshopid'] ?("&nbsp;&nbsp;<a href=\"".ADMINSCRIPT."?action=".$this_page."&subac=shopselect&upshopid=$row[shopid]\" class=\"act\">".lang('plugin/yiqixueba','fendian')."</a>"):''),
			));
			$query1 = DB::query("SELECT * FROM ".DB::table('yiqixueba_yikatong_shop')." WHERE upshopid=".$row['shopid']);
			$kk = 0;
			showtagheader('tbody', 'menu_'.$row['shopid'], false);
			while($row1 = DB::fetch($query1)) {
				showtablerow('', array('class="td25"','class="td28"', 'class="td23"', 'class="td23"','class="td25"',''), array(
					"<input class=\"checkbox\" type=\"checkbox\" name=\"delete[]\" value=\"$row1[shopid]\">",
					"<div class=\"".($kk == $mknum ? 'board' : 'lastboard')."\">&nbsp;".
					DB::result_first("SELECT ".$shop_files['shopname']." FROM ".DB::table($plugin_setting['yiqixueba_yikatong_shop_table'])." WHERE ".$shop_files['shopid']." = ".$row1['shopid']).'</div>',
					DB::result_first("SELECT username FROM ".DB::table('common_member')." WHERE uid=".$row1['uid']),
					$row1['businessgroupid'] ? DB::result_first("SELECT businessgroupname FROM ".DB::table('yiqixueba_yikatong_businessgroup')." WHERE businessgroupid=".$row1['businessgroupid']) : '',
					"<input class=\"checkbox\" type=\"checkbox\" name=\"statusnew[".$row1['shopid']."]\" value=\"1\" ".($row1['status'] > 0 ? 'checked' : '').">",
					"<a href=\"".ADMINSCRIPT."?action=".$this_page."&subac=shopselect&upshopid=$row[shopid]&shopid=$row1[shopid]\" class=\"act\">".lang('plugin/yiqixueba','shenhe')."</a>",
				));
				DB::update('yiqixueba_yikatong_shop', array('shopname'=>DB::result_first("SELECT ".$shop_files['shopname']." FROM ".DB::table($plugin_setting['yiqixueba_yikatong_shop_table'])." WHERE ".$shop_files['shopid']." = ".$row1['shopid'])),array('shopid'=>$row1['shopid']));
				$kk++;
			}
			showtagfooter('tbody');
		}
		echo '<tr><td></td><td colspan="6"><div><a href="'.ADMINSCRIPT.'?action='.$this_page.'&subac=shopselect" class="addtr">'.lang('plugin/yiqixueba','add_shop').'</a></div></td></tr>';
		showsubmit('submit','submit','del');
		showtablefooter();
		showformfooter();
	}else{
		$deletes = getgpc('delete');
		if(is_array($deletes)){
			foreach($deletes as $k=>$v ){
				DB::delete('yiqixueba_yikatong_shop',array('shopid'=>$v));
				DB::delete('yiqixueba_yikatong_business',array('shopid'=>$v));
			}
		}
		cpmsg(lang('plugin/yiqixueba', 'shop_edit_succeed'), 'action='.$this_page.'&subac=shoplist', 'succeed');
	}
}elseif($subac == 'shopedit') {
	if(!submitcheck('submit')) {
		showtips(lang('plugin/yiqixueba','shop_edit_tips'));
		showformheader($this_page.'&subac=shopedit','enctype');
		showtableheader(lang('plugin/yiqixueba','shop_edit'));
		$shopid ? showhiddenfields(array('shopid'=>$shopid)) : '';
		showsetting(lang('plugin/yiqixueba','shopname'),'',DB::result_first("SELECT ".$shop_files['shopname']." FROM ".DB::table($plugin_setting['yiqixueba_yikatong_shop_table'])." WHERE ".$shop_files['shopid']." = ".$shop_info['shopid']),'text',true,0,lang('plugin/yiqixueba','yikatong_shopuname_comment'),'','',true);
		showsetting(lang('plugin/yiqixueba','shopuid'),'',DB::result_first("SELECT username FROM ".DB::table('common_member')." WHERE uid = ".$shop_info['uid']),'text',true,0,lang('plugin/yiqixueba','yikatong_shopuid_comment'),'','',true);
		//商家组
		$businessgroup_select = '<select name="businessgroupid"><option value="">'.lang('plugin/yiqixueba','select').'</option>';
		$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_yikatong_businessgroup')."  WHERE status = 1 ");
		while($row = DB::fetch($query)) {
			$businessgroup_select .= '<option value="'.$row['businessgroupid'].'" '.($shop_info['businessgroupid'] == $row['businessgroupid'] ? ' selected' : '').'>'.$row['businessgroupname'].'</option>';
		}
		$businessgroup_select .= '</select>';
		showsetting(lang('plugin/yiqixueba','businessgroup'),'','',$businessgroup_select,'',0,lang('plugin/yiqixueba','yikatong_businessgroup_comment'),'','',true);
		showsetting(lang('plugin/yiqixueba','status'),'shop_info[status]',$shop_info['status'],'radio','',0,lang('plugin/yiqixueba','yikatong_shopstatus_comment'),'','',true);
		showsubmit('submit');
		showtablefooter();
		showformfooter();
	}else{
		if(!htmlspecialchars(trim($_GET['shop_info']['shopname']))) {
			cpmsg(lang('plugin/yiqixueba','shopname_nonull'));
		}
		$datas = $_GET['shop_info'];
		foreach ( $datas as $k=>$v) {
			$data[$k] = htmlspecialchars(trim($v));
			if(!DB::result_first("describe ".DB::table('yiqixueba_yikatong_shop')." ".$k)) {
				$sql = "alter table ".DB::table('yiqixueba_yikatong_shop')." add `".$k."` varchar(255) not Null;";
				runquery($sql);
			}
		}
		if($shopid) {
			DB::update('yiqixueba_yikatong_shop',$data,array('shopid'=>$shopid));
		}else{
			DB::insert('yiqixueba_yikatong_shop',$data);
		}
		cpmsg(lang('plugin/yiqixueba', 'shop_edit_succeed'), 'action='.$this_page.'&subac=shoplist', 'succeed');
	}
}elseif($subac == 'shopselect') {
	if(!submitcheck('submit')) {

		//商家组option
		$businessgroup_option = '';
		$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_yikatong_businessgroup')." WHERE status = 1 order by businessgroupid asc");
		while($row = DB::fetch($query)) {
			$businessgroup_option .= '<option value="'.$row['businessgroupid'].'" '.($business_info['businessgroupid']==$row['businessgroupid'] ? ' selected':'').'>'.$row['businessgroupname'].'</option>';
		}
		//性别option
		$sex_option = '<option value="0" '.($business_info['sex']==0 ? ' selected':'').'>'.lang('plugin/yiqixueba','baomi').'</option><option value="1" '.($business_info['sex']==1 ? ' selected':'').'>'.lang('plugin/yiqixueba','man').'</option><option value="2" '.($business_info['sex']==2 ? ' selected':'').'>'.lang('plugin/yiqixueba','woman').'</option>';
		showtips(lang('plugin/yiqixueba','shop_select_tips'));
		showformheader($this_page.'&subac=shopselect','enctype');
		showtableheader(lang('plugin/yiqixueba','shop_select'));
		$upshopid ? showhiddenfields(array('upshopid'=>$upshopid)) : '';
		$upshopid ? showhiddenfields(array('businessgroupid'=>DB::result_first("SELECT businessgroupid FROM ".DB::table('yiqixueba_yikatong_shop')." WHERE shopid=".$upshopid ))) : '';
		$upshopid ? showsetting(lang('plugin/yiqixueba','upshop'),'','',DB::result_first("SELECT ".$shop_files['shopname']." FROM ".DB::table($plugin_setting['yiqixueba_yikatong_shop_table'])." WHERE ".$shop_files['shopid']." = ".$upshopid),'',0,lang('plugin/yiqixueba','businessgroup_comment'),'','',true) : '';
		if($shopid){
			$shopid ? showhiddenfields(array('shopid'=>$shopid)) : '';
			showsetting(lang('plugin/yiqixueba','shopname'),'',DB::result_first("SELECT ".$shop_files['shopname']." FROM ".DB::table($plugin_setting['yiqixueba_yikatong_shop_table'])." WHERE ".$shop_files['shopid']." = ".$shop_info['shopid']),'text',true,0,lang('plugin/yiqixueba','yikatong_shopuname_comment'),'','',true);
			showsetting(lang('plugin/yiqixueba','shopuid'),'',DB::result_first("SELECT username FROM ".DB::table('common_member')." WHERE uid = ".$shop_info['uid']),'text',true,0,lang('plugin/yiqixueba','yikatong_shopuid_comment'),'','',true);
			$business_info = DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_yikatong_business')." WHERE shopid=".$shopid);
		}else{
			echo '<tr><td colspan="2" class="td27" s="1">'.lang('plugin/yiqixueba','shopname').':</td></tr>';
			echo '<tr><td class="vtop rowform"><input name="shopname" value="" type="text" class="txt" onblur="ajaxget(\'plugin.php?id=yiqixueba&submod=ajax&ajaxtype=getshopinfo&shopname=\' + this.value, \'shop_info\', \'shop_info\');"/></td><td class="vtop tips2" s="1">yikatong_shopname_comment</td></tr>';
			showtablefooter();
			echo '<div id="shop_info"></div>';
			showtableheader();
		}
		if(!$upshopid){
			showsetting(lang('plugin/yiqixueba','businessgroup'),'','','<select name="businessgroupid">'.$businessgroup_option.'</select>','',0,lang('plugin/yiqixueba','businessgroup_comment'),'','',true);
			showsetting(lang('plugin/yiqixueba','relname'),'relname',$business_info['relname'],'text','',0,lang('plugin/yiqixueba','relname_comment'),'','',true);
			showsetting(lang('plugin/yiqixueba','sex'),'','','<select name="sex">'.$sex_option.'</select>','',0,lang('plugin/yiqixueba','sex_comment'),'','',true);
			showsetting(lang('plugin/yiqixueba','phone'),'phone',$business_info['phone'],'text','',0,lang('plugin/yiqixueba','phone_comment'),'','',true);
			showsetting(lang('plugin/yiqixueba','address'),'address',$business_info['address'],'text','',0,lang('plugin/yiqixueba','address_comment'),'','',true);
			echo '<script src="static/js/calendar.js" type="text/javascript"></script>';
			showsetting(lang('plugin/yiqixueba','birthday'),'birthday',$business_info['birthday'] ? dgmdate($business_info['birthday'],'d') : '','calendar','',0,lang('plugin/yiqixueba','birthday_comment'),'','',true);
			showsetting(lang('plugin/yiqixueba','gerenphoto'),'gerenphoto',$business_info['gerenphoto'],'filetext','',0,lang('plugin/yiqixueba','gerenphoto_comment').$gerenphotohtml,'','',true);
			showsetting(lang('plugin/yiqixueba','shenfenno'),'shenfenno',$business_info['shenfenno'],'text','',0,lang('plugin/yiqixueba','shenfenno_comment'),'','',true);
			showsetting(lang('plugin/yiqixueba','shenfenphoto'),'shenfenphoto',$business_info['shenfenphoto'],'filetext','',0,lang('plugin/yiqixueba','shenfenphoto_comment').$shenfenphotohtml,'','',true);
			echo '<script src="source/plugin/yiqixueba/template/kindeditor/kindeditor.js" type="text/javascript"></script>';
			echo '<link rel="stylesheet" href="source/plugin/yiqixueba/template/kindeditor/themes/default/default.css" />';
			echo '<link rel="stylesheet" href="source/plugin/yiqixueba/template/kindeditor/plugins/code/prettify.css" />';
			echo '<script src="source/plugin/yiqixueba/template/kindeditor/lang/zh_CN.js" type="text/javascript"></script>';
			echo '<script src="source/plugin/yiqixueba/template/kindeditor/prettify.js" type="text/javascript"></script>';
			echo '<tr class="noborder" ><td colspan="2" class="td27" s="1">'.lang('plugin/yiqixueba','businesssummary').':</td></tr>';
			echo '<tr class="noborder" ><td colspan="2" ><textarea name="businesssummary" style="width:700px;height:200px;visibility:hidden;">'.$business_info['businesssummary'].'</textarea></td></tr>';
			showsetting(lang('plugin/yiqixueba','contractimage'),'contractimage',$business_info['contractimage'],'filetext','',0,lang('plugin/yiqixueba','contractimage_comment').$contractimagehtml,'','',true);
		}
		showsetting(lang('plugin/yiqixueba','status'),'shop_info[status]',$shop_info['status'],'radio','',0,lang('plugin/yiqixueba','yikatong_shopstatus_comment'),'','',true);
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
		$shopid = intval($_POST['shopid']);
		if(!$shopid){
			cpmsg('请填写或者选择商家名称');
		}
		$gerenphoto = addslashes($_POST['gerenphoto']);
		if($_FILES['gerenphoto']) {
			$upload = new discuz_upload();
			if($upload->init($_FILES['gerenphoto'], 'common') && $upload->save()) {
				$gerenphoto = $upload->attach['attachment'];
			}
		}
		if($_POST['delete1'] && addslashes($_POST['gerenphoto'])) {
			$valueparse = parse_url(addslashes($_POST['gerenphoto']));
			if(!isset($valueparse['host']) && !strexists(addslashes($_POST['gerenphoto']), '{STATICURL}')) {
				@unlink($_G['setting']['attachurl'].'common/'.addslashes($_POST['gerenphoto']));
			}
			$gerenphoto = '';
		}
		$shenfenphoto = addslashes($_POST['shenfenphoto']);
		if($_FILES['shenfenphoto']) {
			$upload = new discuz_upload();
			if($upload->init($_FILES['shenfenphoto'], 'common') && $upload->save()) {
				$shenfenphoto = $upload->attach['attachment'];
			}
		}
		if($_POST['delete2'] && addslashes($_POST['shenfenphoto'])) {
			$valueparse = parse_url(addslashes($_POST['shenfenphoto']));
			if(!isset($valueparse['host']) && !strexists(addslashes($_POST['shenfenphoto']), '{STATICURL}')) {
				@unlink($_G['setting']['attachurl'].'common/'.addslashes($_POST['shenfenphoto']));
			}
			$shenfenphoto = '';
		}
		$contractimage = addslashes($_POST['contractimage']);
		if($_FILES['contractimage']) {
			$upload = new discuz_upload();
			if($upload->init($_FILES['contractimage'], 'common') && $upload->save()) {
				$contractimage = $upload->attach['attachment'];
			}
		}
		if($_POST['delete3'] && addslashes($_POST['contractimage'])) {
			$valueparse = parse_url(addslashes($_POST['contractimage']));
			if(!isset($valueparse['host']) && !strexists(addslashes($_POST['contractimage']), '{STATICURL}')) {
				@unlink($_G['setting']['attachurl'].'common/'.addslashes($_POST['contractimage']));
			}
			$contractimage = '';
		}
		$data = $data1 = array();
		$data['shopid'] = $shopid;
		$oldshop_info = DB::fetch_first("SELECT * FROM ".DB::table($plugin_setting['yiqixueba_yikatong_shop_table'])." WHERE ".$shop_files['shopid']." =".$shopid);
		$data['uid'] = $oldshop_info[$shop_files['uid']];
		$data['shopname'] = $oldshop_info[$shop_files['name']];
		$data['businessgroupid'] = intval($_POST['businessgroupid']);
		$data['jointime'] = time();
		$data['upshopid'] = intval($_POST['upshopid']) ? intval($_POST['upshopid']) : 0;
		$data['status'] = intval($_POST['status']);

		$data1['relname'] = trim($_POST['relname']);
		$data1['uid'] = $oldshop_info[$shop_files['uid']];
		$data1['shopid'] = $shopid;
		$data1['sex'] = intval($_POST['sex']);
		$data1['phone'] = trim($_POST['phone']);
		$data1['address'] = trim($_POST['address']);
		$data1['birthday'] = strtotime(trim($_POST['birthday']));
		$data1['gerenphoto'] =$gerenphoto;
		$data1['shenfenphoto'] =$shenfenphoto;
		$data1['contractimage'] =$contractimage;
		$data1['businesssummary'] = stripslashes($_POST['businesssummary']);
		$data1['shenfenno'] = trim($_POST['shenfenno']);
		if(DB::result_first("SELECT count(*) FROM ".DB::table('yiqixueba_yikatong_shop')." WHERE shopid=".$shopid)==0){
			DB::insert('yiqixueba_yikatong_shop', $data);
		}else{
			DB::update('yiqixueba_yikatong_shop', $data,array('shopid'=>$shopid));
		}
		if(DB::result_first("SELECT count(*) FROM ".DB::table('yiqixueba_yikatong_business')." WHERE shopid=".$shopid." AND uid = ".$oldshop_info[$shop_files['uid']])==0){
			DB::insert('yiqixueba_yikatong_business', $data1);
		}
		cpmsg(lang('plugin/yiqixueba', 'shop_edit_succeed'), 'action='.$this_page.'&subac=shoplist', 'succeed');
	}
}
//dump($plugin_setting);
?>