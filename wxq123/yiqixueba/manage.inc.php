<?php

/**
*	一起学吧平台程序
*	前台管理
*	文件名：manage.inc.php  创建时间：2013-6-1 15:17  杨文
*
*/

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
//$debug = array('yikatong_joinbusiness');


//读取参数设置
$base_setting = array();
$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_setting'));
while($row = DB::fetch($query)) {
	$base_setting[$row['skey']] = $row['svalue'];
}
$shopfields = dunserialize($base_setting['yiqixueba_yikatong_fields']);

//读取提交的参数
$man = addslashes(trim(getgpc('man')));
$subman = addslashes(trim(getgpc('subman')));

//需要登录
if(!$_G['uid']) {
	showmessage('login_before_enter_home', null, array(), array('showmsg' => true, 'login' => 1));
}
$navtitle = lang('plugin/yiqixueba','member_manage');

if(getgpc('login_yiqixueba_manage') && getgpc('cppwd') && submitcheck('loginsubmit')) {
	$referer = dreferer();
	require_once libfile('function/member');
	loaducenter();
	$result = userlogin($_G['username'], trim(getgpc('cppwd')),'','','',$_G['clientip']);

	if($result['status']){
		dsetcookie('yiqixueba_login','yes',900);
	}
}

if($man == 'logout'){
	dsetcookie('yiqixueba_login',null,0);
	//$man = 'login';
	$subtpl = 'yiqixueba:manage/login';
}

if(!getcookie('yiqixueba_login') ){
	//$man = 'login';
	$subtpl = 'yiqixueba:manage/login';
	include template('yiqixueba:manage/main');
	exit();
}else{
	dsetcookie('yiqixueba_login','yes',900);
}

//$script = 'noperm';
$page = intval(getgpc('page'))?  intval(getgpc('page')) : 1;
//根据uid判断用户组
$groups = array('business','dianzhang','caiwu','shouyin','kaxiaoshou','guest');
foreach( $groups as $k=>$v ){
	$groups_t[] = lang('plugin/yiqixueba','g_'.$v);
}
//dump($base_setting);
$viewuid = intval(getgpc('viewuid'));
$uid = $_G['adminid'] == 1 && $viewuid ? $viewuid : $_G['uid'];
//商家列表
//用户表、商家表、店长表、财务表、收银员表、卡销售表中一定要有相关字段来标识各个参数
$businessarray = $dianzhangarray = $caiwuarray = $shouyinarray = $kaxiaoshouarray = array();
$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_yikatong_business')." WHERE uid = ".$uid);
while($row = DB::fetch($query)) {
	$businessarray[] = $row;
}
$businessnum = count($businessarray);
$oldshopnum = DB::result_first("SELECT count(*) FROM ".DB::table($base_setting['yiqixueba_yikatong_shop_table'])." WHERE ".$shopfields['uid']."=".$uid);
//dump($oldshopnum);
$member_info = DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_member')." WHERE uid=".$uid);
$navs = array();
$subnavs = array();



$node = PluginNode();
$usergroups = UsergroupPerm();
$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_mokuai')." WHERE upmokuai = '' order by displayorder asc");
while($row = DB::fetch($query)) {
	$mans[] = $row['mokuainame'];
	$navs[] = array('navname'=>$row['mokuainame'],'navtitle'=>$row['mokuaititle']);
}
$man = in_array($man,$mans) ? $man : $mans[0];

$usergroup = trim(DB::result_first("SELECT ".$man." FROM ".DB::table('yiqixueba_member')." WHERE uid=".$_G['uid']));

$submans = dunserialize($usergroup) ? $usergroup : $usergroups[$man.'_'.$usergroup];
$submans =$submans ? $submans : $usergroups[$man.'_guest'];
$subman = in_array($subman,$submans) ? $subman : $submans[0];

foreach($submans as $key=>$value ){
	$subnavs[] = array('navname'=>$value,'navtitle'=>$node[$man.'_'.$value]);
}

///////////
$this_page = 'plugin.php?id=yiqixueba:manage&man='.$man.'&subman='.$subman;
if($subman&&$man) {
	$manage_flie = DISCUZ_ROOT.'source/plugin/yiqixueba/manage/'.$man.'_'.$subman.'.php';
	if(!file_exists($manage_flie)) {
		file_put_contents($manage_flie,$manage_text);
	}
	if(abs(filesize($manage_flie))==0) {
		file_put_contents($manage_flie,"<?php\n\n/**\n*\t一起学吧平台程序\n*\t文件名：".$man."_".$subman.".php  创建时间：".dgmdate(time(),'dt')."  杨文\n*\n*/\n\nif(!defined('IN_DISCUZ')) {\n\texit('Access Denied');\n}\n\n\$this_page = 'plugin.php?id=yiqixueba:manage&man=".$man."&subman=".$subman."';\n");
	}
	require_once $manage_flie;
	$subtpl = 'yiqixueba:manage/'.$man.'_'.$subman;
	$template_flie = DISCUZ_ROOT.'source/plugin/yiqixueba/template/manage/'.$man.'_'.$subman.'.htm';
	if(!file_exists($template_flie)) {
		file_put_contents($template_flie,"<!--{if !\$".$subman."}-->\n\t<div class=\"bmw mtw\">\n\t\t<div class=\"hm bm_h\"><h2 class=\"mbm xs2\">".$node[$man.'_'.$subman]."</h2></div>\n\t\t<div class=\"bm_c\">{\$_G['username']}，你好，{\$msg_text}</div>\n\t</div>\n<!--{else}-->\n<!--{/if}-->");
	}
}else{
	$manage_flie = DISCUZ_ROOT.'source/plugin/yiqixueba/manage/'.$man.'.php';
}
if(!$navs){
	showmessage('login_before_enter_home');
}
include template('yiqixueba:manage/main');



//现暂不是呀该函数
function getperm(){
	$perms = array();
	$perms['brand']['guest']['base'] = '基本信息';
	$perms['brand']['guest']['business'] = '商家管理';
	$perms['yikatong']['guest']['joinbusiness'] = '商家入住';
	$perms['yikatong']['guest']['bind'] = '会员绑定';
	$perms['yikatong']['business']['joinbusiness'] = '商家管理';
	$perms['yikatong']['business']['xiaofei'] = '会员消费';
	$perms['yikatong']['caiwu']['xiaofei'] = '会员消费';
	$perms['yikatong']['caiwu']['xiaofei'] = '会员消费';
	$perms['yikatong']['dianzhang']['xiaofei'] = '会员消费';
	$perms['yikatong']['business']['myshop'] = '我的店铺';
	return $perms;
}//end func

//前台会员中心的节点，会员中心的页面数组
function PluginNode(){
	$node = array();
	//商家联盟
	$node['brand_base'] = '基本信息';
	$node['brand_business'] = '商家管理';
	$node['brand_shop'] = '商铺管理';
	$node['brand_goods'] = '商品管理';
	$node['brand_dianyuan'] = '店员管理';
	//一卡通
	$node['yikatong_base'] = '基本信息';
	$node['yikatong_bind'] = '会员绑定';
	$node['yikatong_xiaofei'] = '会员消费';
	$node['yikatong_business'] = '商家管理';
	$node['yikatong_shop'] = '商铺管理';
	$node['yikatong_goods'] = '商品管理';
	$node['yikatong_dianyuan'] = '店员管理';
	$node['yikatong_member'] = '会员管理';
	$node['yikatong_xiaofei'] = '会员消费';
	$node['yikatong_xiaofeijilu'] = '消费记录';
	$node['yikatong_caiwuinfo'] = '财务信息';
	//微信墙123
	$node['wxq123_base'] = '基本信息';
	$node['wxq123_shop'] = '商铺管理';
	$node['wxq123_weixin'] = '微信设置';
	return $node;
}//end func

//各个模块的会员组默认权限
function UsergroupPerm(){
	$usergroups = array();
	//商家联盟
	$usergroups['brand_guest'] = array('base','shop','goods','dianyuan');
	$usergroups['brand_business'] = array('business','shop');
	//一卡通
	$usergroups['yikatong_guest'] = array('base','xiaofei','bind','shop','goods','dianyuan','member','xiaofeijilu','caiwuinfo');
	$usergroups['yikatong_business'] = array('base','xiaofei','business','myshop');
	//微信墙123
	$usergroups['wxq123_guest'] = array('base','shop','weixin');
	$usergroups['wxq123_business'] = array('business','myshop');
	return $usergroups;
}//end func

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


//
function writefile($man,$subman){
if($subman&&$man) {
	//在测试编程中临时增加的程序，用于自动产生菜单文件
	$upid = DB::result_first("SELECT menuid FROM ".DB::table('yiqixueba_menu')." WHERE menuname='".$man."' AND menutype = 'manage'");
	if(DB::result_first("SELECT count(*) FROM ".DB::table('yiqixueba_menu')." WHERE menutype = 'manage' AND upid=".$upid." AND menuname = '".$subman."'")==0){
		DB::insert('yiqixueba_menu', array('menutype'=>'manage','upid'=>$upid,'menuname'=>$subman,'menutitle'=>$node[$man.'_'.$subman]));
	}
	//读取前台管理页面中的规则
	$menu_info = DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_menu')." WHERE menuname='".$subman."' AND menutype = 'manage'");
	$page_rules = $menu_info['rules'] ? dunserialize($menu_info['rules']):array();
	$field_rules = explode("\n",$page_rules['field']);

	//dump($field_rules);
	//////////////
	if($page_rules['pagetype'] == 1){
		$temptext = '';
		foreach ( $page_rules['field'] as $k => $v ){
		}
	}elseif($page_rules['pagetype'] == 2){
		//程序页面
		$manage_text = "<?php\n\n/**\n*\t一起学吧平台程序\n*\t文件名：".$man."_".$subman.".php  创建时间：".dgmdate(time(),'dt')."  杨文\n*\n*/\n\nif(!defined('IN_DISCUZ')) {\n\texit('Access Denied');\n}\n\n\$this_page = 'plugin.php?id=yiqixueba:manage&man=yikatong&subman=".$subman."';\n";
		$manage_text .= "\n";
		$manage_text .= "\$".$page_rules['zhujian']." = getgpc('".$page_rules['zhujian']."');\n";
		$manage_text .= "\$".$subman."_info = \$".$page_rules['zhujian']." ? DB::fetch_first(\"SELECT * FROM \".DB::table('".$page_rules['tablename']."').\" WHERE ".$page_rules['zhujian']." = \".\$".$page_rules['zhujian']."):array();\n";
		$manage_text .= "\n";
		$manage_text .= "if(!submitcheck('".$subman."submit')) {\n";
		$manage_text .= "\n";
		$manage_text .= "}else{\n";
		$manage_text .= "\t\$data = array();\n";
		foreach ( $field_rules as $k => $v ){
			$inputs = explode("|",$v);
			if($inputs[2] == 'text' ||$inputs[2] == 'password' ){
				$manage_text .= "\t\$data['".$inputs[0]."'] = trim(addslashes(getgpc('".$inputs[0]."')));\n";
			}
		}
		$manage_text .= "\tif(\$".$page_rules['zhujian'].") {\n";
		$manage_text .= "\t\t//DB::update('".$page_rules['tablename']."',\$data,array('".$page_rules['zhujian']."'=>\$".$page_rules['zhujian']."));\n";
		$manage_text .= "\t}else{\n";
		$manage_text .= "\t\t//DB::insert('".$page_rules['tablename']."',\$data);\n";
		$manage_text .= "\t}\n";
		$manage_text .= "\tshowmessage('".$menu_info['menutitle']."编辑成功', \$this_page, 'succeed');\n";
		$manage_text .= "}\n";
		$manage_text .= "?>\n";
		//模版页面
		$temptext = "";
		$temptext .= "<!--{if \$".$page_rules['zhujian']."}-->\n";
		$temptext .= "<!--{else}-->\n";
		$temptext .= "\t<form method=\"post\" autocomplete=\"off\" id=\"".$subman."form\" name=\"".$subman."form\" action=\"{\$this_page}\" >\n";
		$temptext .= "\t<input type=\"hidden\" name=\"referer\" value=\"{echo dreferer()}\" />\n";
		$temptext .= "\t<input type=\"hidden\" name=\"".$subman."submit\" value=\"true\" />\n";
		$temptext .= "\t<input type=\"hidden\" name=\"formhash\" value=\"{FORMHASH}\" />\n";
		$temptext .= "\t<div class=\"c\">\n";
		$temptext .= "\t<table cellspacing=\"0\" cellpadding=\"0\" class=\"tfm\">\n";
		$temptext .= "\t\t<caption><h2 class=\"mbm xs2\">".$menu_info['menutitle']."</h2></caption>\n";
		foreach ( $field_rules as $k => $v ){
			$inputs = explode("|",$v);
			//$temptext .= "\t\n";
			$temptext .= "\t\t<tr><th valign=\"top\" width=\"60\" class=\"avt\">".$inputs[1]."</th><td valign=\"top\">\n";
			//$temptext .= "\t\n";
			if($inputs[2] == 'text' ||$inputs[2] == 'password' ){
				$temptext .= "\t\n";
				$temptext .= "\t\t\t<input type=\"text\" class=\"ps\" name=\"".$inputs[0]."\"".($inputs[3]==1? " value=\"\$".$inputs[0]."\"":"").">\n";
				$temptext .= "\t\n";
			}
			$temptext .= "\t\t</td><td valign=\"top\">&nbsp;</td></tr>\n";
			//$temptext .= "\t\n";
		}

		$temptext .= "\t\t<tr><td width=\"120\">&nbsp;</td><td valign=\"top\"><button type=\"submit\" name=\"".$subman."submit\" id=\"".$subman."submit\" value=\"true\" class=\"pn pnc\"><strong>确定</strong></button></td><td valign=\"top\">&nbsp;</td></tr>\n";
		$temptext .= "\t</table>\n";
		$temptext .= "\t</div>\n";
		$temptext .= "\t</form>\n";
		$temptext .= "<!--{/if}-->";
	}
	$manage_text = $manage_text ? $manage_text : "<?php\n\n/**\n*\t一起学吧平台程序\n*\t文件名：".$man."_".$subman.".php  创建时间：".dgmdate(time(),'dt')."  杨文\n*\n*/\n\nif(!defined('IN_DISCUZ')) {\n\texit('Access Denied');\n}\n\n\$this_page = 'plugin.php?id=yiqixueba:manage&man=yikatong&subman=".$subman."';\n\n\n?>";;
	$manage_flie = DISCUZ_ROOT.'source/plugin/yiqixueba/manage/'.$man.'_'.$subman.'.php';
	//写入测试程序文件
	//file_put_contents(DISCUZ_ROOT.'source/plugin/yiqixueba/manage/'.$man.'_test.php',$manage_text);
	if(!file_exists($manage_flie)) {
		file_put_contents($manage_flie,$manage_text);
	}
	require_once $manage_flie;
	$subtpl = 'yiqixueba:manage/'.$man.'_'.$subman;
	$template_flie = DISCUZ_ROOT.'source/plugin/yiqixueba/template/manage/'.$man.'_'.$subman.'.htm';
	//写入测试模版文件
	//file_put_contents(DISCUZ_ROOT.'source/plugin/yiqixueba/template/manage/'.$man.'_test.htm',$temptext);
	//
	if(!file_exists($template_flie)) {
		file_put_contents($template_flie,$temptext);
	}
}else{
	$manage_flie = DISCUZ_ROOT.'source/plugin/yiqixueba/manage/'.$man.'.php';
}
	return $subman;
}//end func
?>