<?php

/**
*	һ��ѧ��ƽ̨����
*	ǰ̨����
*	�ļ�����manage.inc.php  ����ʱ�䣺2013-6-1 15:17  ����
*
*/

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
//$debug = array('yikatong_joinbusiness');


//��ȡ��������
$base_setting = array();
$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_setting'));
while($row = DB::fetch($query)) {
	$base_setting[$row['skey']] = $row['svalue'];
}
$shopfields = dunserialize($base_setting['yiqixueba_yikatong_fields']);

//��ȡ�ύ�Ĳ���
$man = addslashes(trim(getgpc('man')));
$subman = addslashes(trim(getgpc('subman')));

//��Ҫ��¼
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
//����uid�ж��û���
$groups = array('business','dianzhang','caiwu','shouyin','kaxiaoshou','guest');
foreach( $groups as $k=>$v ){
	$groups_t[] = lang('plugin/yiqixueba','g_'.$v);
}
//dump($base_setting);
$viewuid = intval(getgpc('viewuid'));
$uid = $_G['adminid'] == 1 && $viewuid ? $viewuid : $_G['uid'];
//�̼��б�
//�û����̼ұ��곤�����������Ա�������۱���һ��Ҫ������ֶ�����ʶ��������
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
		file_put_contents($manage_flie,"<?php\n\n/**\n*\tһ��ѧ��ƽ̨����\n*\t�ļ�����".$man."_".$subman.".php  ����ʱ�䣺".dgmdate(time(),'dt')."  ����\n*\n*/\n\nif(!defined('IN_DISCUZ')) {\n\texit('Access Denied');\n}\n\n\$this_page = 'plugin.php?id=yiqixueba:manage&man=".$man."&subman=".$subman."';\n");
	}
	require_once $manage_flie;
	$subtpl = 'yiqixueba:manage/'.$man.'_'.$subman;
	$template_flie = DISCUZ_ROOT.'source/plugin/yiqixueba/template/manage/'.$man.'_'.$subman.'.htm';
	if(!file_exists($template_flie)) {
		file_put_contents($template_flie,"<!--{if !\$".$subman."}-->\n\t<div class=\"bmw mtw\">\n\t\t<div class=\"hm bm_h\"><h2 class=\"mbm xs2\">".$node[$man.'_'.$subman]."</h2></div>\n\t\t<div class=\"bm_c\">{\$_G['username']}����ã�{\$msg_text}</div>\n\t</div>\n<!--{else}-->\n<!--{/if}-->");
	}
}else{
	$manage_flie = DISCUZ_ROOT.'source/plugin/yiqixueba/manage/'.$man.'.php';
}
if(!$navs){
	showmessage('login_before_enter_home');
}
include template('yiqixueba:manage/main');



//���ݲ���ѽ�ú���
function getperm(){
	$perms = array();
	$perms['brand']['guest']['base'] = '������Ϣ';
	$perms['brand']['guest']['business'] = '�̼ҹ���';
	$perms['yikatong']['guest']['joinbusiness'] = '�̼���ס';
	$perms['yikatong']['guest']['bind'] = '��Ա��';
	$perms['yikatong']['business']['joinbusiness'] = '�̼ҹ���';
	$perms['yikatong']['business']['xiaofei'] = '��Ա����';
	$perms['yikatong']['caiwu']['xiaofei'] = '��Ա����';
	$perms['yikatong']['caiwu']['xiaofei'] = '��Ա����';
	$perms['yikatong']['dianzhang']['xiaofei'] = '��Ա����';
	$perms['yikatong']['business']['myshop'] = '�ҵĵ���';
	return $perms;
}//end func

//ǰ̨��Ա���ĵĽڵ㣬��Ա���ĵ�ҳ������
function PluginNode(){
	$node = array();
	//�̼�����
	$node['brand_base'] = '������Ϣ';
	$node['brand_business'] = '�̼ҹ���';
	$node['brand_shop'] = '���̹���';
	$node['brand_goods'] = '��Ʒ����';
	$node['brand_dianyuan'] = '��Ա����';
	//һ��ͨ
	$node['yikatong_base'] = '������Ϣ';
	$node['yikatong_bind'] = '��Ա��';
	$node['yikatong_xiaofei'] = '��Ա����';
	$node['yikatong_business'] = '�̼ҹ���';
	$node['yikatong_shop'] = '���̹���';
	$node['yikatong_goods'] = '��Ʒ����';
	$node['yikatong_dianyuan'] = '��Ա����';
	$node['yikatong_member'] = '��Ա����';
	$node['yikatong_xiaofei'] = '��Ա����';
	$node['yikatong_xiaofeijilu'] = '���Ѽ�¼';
	$node['yikatong_caiwuinfo'] = '������Ϣ';
	//΢��ǽ123
	$node['wxq123_base'] = '������Ϣ';
	$node['wxq123_shop'] = '���̹���';
	$node['wxq123_weixin'] = '΢������';
	return $node;
}//end func

//����ģ��Ļ�Ա��Ĭ��Ȩ��
function UsergroupPerm(){
	$usergroups = array();
	//�̼�����
	$usergroups['brand_guest'] = array('base','shop','goods','dianyuan');
	$usergroups['brand_business'] = array('business','shop');
	//һ��ͨ
	$usergroups['yikatong_guest'] = array('base','xiaofei','bind','shop','goods','dianyuan','member','xiaofeijilu','caiwuinfo');
	$usergroups['yikatong_business'] = array('base','xiaofei','business','myshop');
	//΢��ǽ123
	$usergroups['wxq123_guest'] = array('base','shop','weixin');
	$usergroups['wxq123_business'] = array('business','myshop');
	return $usergroups;
}//end func

// ������Ѻõı������
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
	//�ڲ��Ա������ʱ���ӵĳ��������Զ������˵��ļ�
	$upid = DB::result_first("SELECT menuid FROM ".DB::table('yiqixueba_menu')." WHERE menuname='".$man."' AND menutype = 'manage'");
	if(DB::result_first("SELECT count(*) FROM ".DB::table('yiqixueba_menu')." WHERE menutype = 'manage' AND upid=".$upid." AND menuname = '".$subman."'")==0){
		DB::insert('yiqixueba_menu', array('menutype'=>'manage','upid'=>$upid,'menuname'=>$subman,'menutitle'=>$node[$man.'_'.$subman]));
	}
	//��ȡǰ̨����ҳ���еĹ���
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
		//����ҳ��
		$manage_text = "<?php\n\n/**\n*\tһ��ѧ��ƽ̨����\n*\t�ļ�����".$man."_".$subman.".php  ����ʱ�䣺".dgmdate(time(),'dt')."  ����\n*\n*/\n\nif(!defined('IN_DISCUZ')) {\n\texit('Access Denied');\n}\n\n\$this_page = 'plugin.php?id=yiqixueba:manage&man=yikatong&subman=".$subman."';\n";
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
		$manage_text .= "\tshowmessage('".$menu_info['menutitle']."�༭�ɹ�', \$this_page, 'succeed');\n";
		$manage_text .= "}\n";
		$manage_text .= "?>\n";
		//ģ��ҳ��
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

		$temptext .= "\t\t<tr><td width=\"120\">&nbsp;</td><td valign=\"top\"><button type=\"submit\" name=\"".$subman."submit\" id=\"".$subman."submit\" value=\"true\" class=\"pn pnc\"><strong>ȷ��</strong></button></td><td valign=\"top\">&nbsp;</td></tr>\n";
		$temptext .= "\t</table>\n";
		$temptext .= "\t</div>\n";
		$temptext .= "\t</form>\n";
		$temptext .= "<!--{/if}-->";
	}
	$manage_text = $manage_text ? $manage_text : "<?php\n\n/**\n*\tһ��ѧ��ƽ̨����\n*\t�ļ�����".$man."_".$subman.".php  ����ʱ�䣺".dgmdate(time(),'dt')."  ����\n*\n*/\n\nif(!defined('IN_DISCUZ')) {\n\texit('Access Denied');\n}\n\n\$this_page = 'plugin.php?id=yiqixueba:manage&man=yikatong&subman=".$subman."';\n\n\n?>";;
	$manage_flie = DISCUZ_ROOT.'source/plugin/yiqixueba/manage/'.$man.'_'.$subman.'.php';
	//д����Գ����ļ�
	//file_put_contents(DISCUZ_ROOT.'source/plugin/yiqixueba/manage/'.$man.'_test.php',$manage_text);
	if(!file_exists($manage_flie)) {
		file_put_contents($manage_flie,$manage_text);
	}
	require_once $manage_flie;
	$subtpl = 'yiqixueba:manage/'.$man.'_'.$subman;
	$template_flie = DISCUZ_ROOT.'source/plugin/yiqixueba/template/manage/'.$man.'_'.$subman.'.htm';
	//д�����ģ���ļ�
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