<?php

/**
*	一起学吧平台程序
*	文件名：shop_shop.inc.php  创建时间：2013-6-4 09:37  杨文
*
*/

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
$this_page = 'plugins&identifier=yiqixueba&pmod=admin&submod=shop_shop';

$subac = getgpc('subac');
$subacs = array('shoplist','shopedit');
$subac = in_array($subac,$subacs) ? $subac : $subacs[0];

$shopid = getgpc('shopid');
$shop_info = $shopid ? DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_shop_shop')." WHERE shopid=".$shopid) : array();
var_dump($shop_info);
if($subac == 'shoplist') {
	if(!submitcheck('submit')) {
		showtips(lang('plugin/yiqixueba','shop_list_tips'));
		showformheader($this_page.'&subac=shoplist');
		showtableheader(lang('plugin/yiqixueba','shop_list'));
		showsubtitle(array('', lang('plugin/yiqixueba','shopname'),lang('plugin/yiqixueba','shopsort'), lang('plugin/yiqixueba','shopaddress'), lang('plugin/yiqixueba','shopphone'), lang('plugin/yiqixueba','shoplianxiren'), lang('plugin/yiqixueba','status'), ''));
		$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_shop_shop')." order by shopid asc");
		while($row = DB::fetch($query)) {
			showtablerow('', array('class="td25"','class="td29"', 'class="td23"', 'class="td29"','class="td23"','class="td23"','class="td25"',''), array(
				"<input class=\"checkbox\" type=\"checkbox\" name=\"delete[]\" value=\"$row[shopid]\">",
			$row['shopname'],
			DB::result_first("SELECT sorttitle FROM ".DB::table('yiqixueba_shopsort')." WHERE shopsortid =".$row['shopsort']),
			$row['shopaddress'],
			$row['shopphone'],
			$row['shoplianxiren'],
			"<input class=\"checkbox\" type=\"checkbox\" name=\"statusnew[".$row['shopid']."]\" value=\"1\" ".($row['status'] > 0 ? 'checked' : '').">",
				"<a href=\"".ADMINSCRIPT."?action=".$this_page."&subac=shopedit&shopid=$row[shopid]\" class=\"act\">".lang('plugin/yiqixueba','edit')."</a>",
			));
		}
		echo '<tr><td></td><td colspan="6"><div><a href="'.ADMINSCRIPT.'?action='.$this_page.'&subac=shopedit" class="addtr">'.lang('plugin/yiqixueba','add_shop').'</a></div></td></tr>';
		showsubmit('submit','submit','del');
		showtablefooter();
		showformfooter();
	}else{
	}
}elseif($subac == 'shopedit') {
	$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_shopsort')." order by displayorder asc");
	while($row = DB::fetch($query)) {
		$data[] = $row;
	}
	$tree = getTree($data, 0);
	if(!submitcheck('submit')) {
		require_once libfile('function/editor');
		$shopsort_select = '<select name="shop_info[shopsort]">';
		$shopsort_select .= getselect($tree,$shop_info['shopsort']);
		$shopsort_select .= '</select>';
		showtips(lang('plugin/yiqixueba','shop_edit_tips'));
		showformheader($this_page.'&subac=shopedit','onsubmit="edit_save();"');
		showtableheader(lang('plugin/yiqixueba','shop_edit'));
		$shopid ? showhiddenfields(array('shopid'=>$shopid)) : '';
		showsetting(lang('plugin/yiqixueba','shopname'),'shop_info[shopname]',$shop_info['shopname'],'text','',0,lang('plugin/yiqixueba','shopname_comment'),'','',true);//htmltext
		showsetting(lang('plugin/yiqixueba','shopsort'),'','',$shopsort_select,'',0,lang('plugin/yiqixueba','shopsort_comment'),'','',true);
		showsetting(lang('plugin/yiqixueba','shopaddress'),'shop_info[shopaddress]',$shop_info['shopaddress'],'text','',0,lang('plugin/yiqixueba','shopaddress_comment'),'','',true);
		showsetting(lang('plugin/yiqixueba','shopphone'),'shop_info[shopphone]',$shop_info['shopphone'],'text','',0,lang('plugin/yiqixueba','shopphone_comment'),'','',true);
		showsetting(lang('plugin/yiqixueba','shoplianxiren'),'shop_info[shoplianxiren]',$shop_info['shoplianxiren'],'text','',0,lang('plugin/yiqixueba','shoplianxiren_comment'),'','',true);
		//showsetting(lang('plugin/yiqixueba','shopdescription'),'shop_info[shopdescription]',$shop_info['shopdescription'],'textarea','',0,lang('plugin/yiqixueba','shopdescription_comment'),'','',true);
		echo '<script type="text/javascript" src="'.STATICURL.'image/editor/editor_function.js"></script><script type="text/javascript" src="'.$_G[setting][jspath].'swfupload.js?{VERHASH}"></script><script type="text/javascript" src="'.$_G[setting][jspath].'swfupload.queue.js?{VERHASH}"></script><script type="text/javascript" src="'.$_G[setting][jspath].'handlers.js?{VERHASH}"></script><script type="text/javascript" src="'.$_G[setting][jspath].'fileprogress.js?{VERHASH}"></script>';
		$src = 'home.php?mod=editor&charset='.CHARSET.'&allowhtml=1&doodle=0';
		echo '<tr><td><strong>'.lang('plugin/yiqixueba','shopdescription').':</strong></td><td></td></tr>';
		print <<<EOF
		<tr>
			<td colspan="2">
			<div id="icoImg_image_menu" style="display: none" unselectable="on">
			<table width="100%" cellpadding="0" cellspacing="0" class="fwin">
			<tr><td class="t_l"></td><td class="t_c"></td><td class="t_r"></td></tr><tr><td class="m_l">&nbsp;&nbsp;</td><td class="m_c"><div class="mtm mbm">
	<ul class="tb tb_s cl" id="icoImg_image_ctrl" style="margin-top:0;margin-bottom:0;">
	<li class="y"><span class="flbc" onclick="hideAttachMenu('icoImg_image_menu')">关闭</span></li>
	<li class="current" id="icoImg_btn_imgattachlist"><a href="javascript:;" hidefocus="true" onclick="switchImagebutton('imgattachlist');">上传图片</a></li>
	<li id="icoImg_btn_albumlist"  class="current"><a href="javascript:;" hidefocus="true" onclick="switchImagebutton('albumlist');">相册列表</a></li>
	</ul>
	<div class="p_opt popupfix" unselectable="on" id="icoImg_www" style="display: none">
		<table cellpadding="0" cellspacing="0" width="100%">
			<tr class="xg1">
				<th>e_img_inserturl</th>
				<th>e_img_width</th>
				<th>e_img_height</th>
			</tr>
			<tr>
				<td width="74%"><input type="text" id="icoImg_image_param_1" onchange="loadimgsize(this.value)" style="width: 95%;" value="" class="px" autocomplete="off" /></td>
				<td width="13%"><input id="icoImg_image_param_2" size="3" value="" class="px p_fre" autocomplete="off" /></td>
				<td width="13%"><input id="icoImg_image_param_3" size="3" value="" class="px p_fre" autocomplete="off" /></td>
			</tr>
			<tr>
				<td colspan="3" class="pns ptn">
					<button type="button" class="pn pnc" onclick="insertWWWImg();"><strong>提交</strong></button>
				</td>
			</tr>
		</table>
	</div>
	<div class="p_opt" unselectable="on" id="icoImg_imgattachlist" style="display: none;">
		<div class="pbm bbda cl">
			<div id="uploadPanel" class="y">
			</div>
			<div id="createalbum" class="y" style="display:none">
				<input type="text" name="newalbum" id="newalbum" class="px vm" value="input_album_name"  onfocus="if(this.value == 'input_album_name') {this.value = '';}" onblur="if(this.value == '') {this.value = 'input_album_name';}" />
				<button type="button" class="pn pnc" onclick="createNewAlbum();"><span>create</span></button>
				<button type="button" class="pn" onclick="selectCreateTab(1);"><span>cancel</span></button>
			</div>
			<span id="imgSpanButtonPlaceholder"></span>
		</div>
		<div class="upfilelist upfl bbda">
			<div id="imgattachlist">
				$article[attachs]
			</div>
			<div class="fieldset flash" id="imgUploadProgress"></div>
		</div>
		<p class="notice">click_pic_to_editor</p>
	</div>



	</td><td class="m_r"></td></tr><tr><td class="b_l"></td><td class="b_c"></td><td class="b_r"></td></tr></table>
			</div>
				<textarea class="userData" name="shopdescription" id="uchome-ttHtmlEditor" style="height:100%;width:100%;display:none;border:0px">$shop_info[shopdescription]</textarea>
				<iframe src="$src" name="uchome-ifrHtmlEditor" id="uchome-ifrHtmlEditor" scrolling="no" border="0" frameborder="0" style="width:100%;border: 1px solid #C5C5C5;" height="200"></iframe>
			<td>
		</tr>
EOF;
		showsetting(lang('plugin/yiqixueba','status'),'shop_info[status]',$shop_info['status'],'radio','',0,lang('plugin/yiqixueba','status_comment'),'','',true);
		showsubmit('submit');
		showtablefooter();
		showformfooter();
	}else{
		if(!htmlspecialchars(trim($_GET['shop_info']['shopname']))) {
			cpmsg(lang('plugin/yiqixueba','shopname_nonull'));
		}
		$data = array();
		$datas = $_GET['shop_info'];
		foreach ( $datas as $k=>$v) {
			$data[$k] = htmlspecialchars(trim($v));
			if(!DB::result_first("describe ".DB::table('yiqixueba_shop')." ".$k)) {
				$sql = "alter table ".DB::table('yiqixueba_shop_shop')." add `".$k."` varchar(255) not Null;";
				runquery($sql);
			}
		}
		$data['shopdescription'] = htmlspecialchars(trim($_POST['shopdescription']));
		if($shopid) {
			DB::update('yiqixueba_shop_shop',$data,array('shopid'=>$shopid));
		}else{
			DB::insert('yiqixueba_shop_shop',$data);
		}
		cpmsg(lang('plugin/yiqixueba', 'shop_edit_succeed'), 'action='.$this_page.'&subac=shoplist', 'succeed');
	}
}
//显示分类下拉框
function getselect($data,$value){
	//$return = '';
	foreach($data as $k => $v){
		$return .= '<option value="'.$v['shopsortid'].'" '.($value==$v['shopsortid']?' selected':'').'>'.str_repeat("--",$v['sortlevel']-1).$v['sorttitle'].'</option>';
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
?>