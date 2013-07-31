<?php

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

if(!submitcheck('submit')) {
	$weixin_config = array();
	$query = DB::query("SELECT * FROM ".DB::table('brand_settings'));
	while($row = DB::fetch($query)) {
		if(substr($row['variable'],0,7) == 'weixin_'){
			$weixin_config[$row['variable']] = $row['value'];
		}
		if(substr($row['variable'],0,6) == 'weitg_'){
			$weixin_config[$row['variable']] = $row['value'];
		}
		if(substr($row['variable'],0,7) == 'weiyhj_'){
			$weixin_config[$row['variable']] = $row['value'];
		}
	}
	showtips('<li>在使用微信之前，请确认站长已经申请了网站的公共微信帐号；</li><li>微商家已经独立插件，不需要在此处设置微商家；</li><li>请在微团购设置中的url地址填写：'.$_G['siteurl'].'weituangou.php</li><li>请在微优惠卷设置中的url地址填写：'.$_G['siteurl'].'weiyouhuijuan.php</li>');
	showformheader('plugins&identifier=yikatong&pmod=admin&bmenu=setting&baction=setting_weixin');
	showtableheader('微团购设置');
	showsetting('请输入站长的微信公共帐号','weitg_hao',$weixin_config['weitg_hao'],'text','','','输入站长的公共微信帐号');
	showsetting('请输入站长的微信TOKEN值','weitg_token',$weixin_config['weitg_token'],'text','','','输入站长的公共微信帐号');
	showsetting('默认搜索商家的范围','weitg_area',$weixin_config['weitg_area'],'text','','','默认值，单位：米');
	showsetting('使用道具后搜索商家的范围','weitg_daoju',$weixin_config['weitg_daoju'],'text','','','使用道具后，单位：米');
	showsetting('如果没有搜索结果的返回值','weitg_text',$weixin_config['weitg_text'],'textarea','','','如果在搜索范围内没有搜索出商家，显示的默认内容');
	showsetting('文本发送机器人','weitg_jiqiren',$weixin_config['weitg_jiqiren'],'textarea','','','格式为：<br />输入=输出');
	showtablefooter();
	showtableheader('微优惠卷设置');
	showsetting('请输入站长的微信公共帐号','weiyhj_hao',$weixin_config['weiyhj_hao'],'text','','','输入站长的公共微信帐号');
	showsetting('请输入站长的微信TOKEN值','weiyhj_token',$weixin_config['weiyhj_token'],'text','','','输入站长的公共微信帐号');
	showsetting('默认搜索商家的范围','weiyhj_area',$weixin_config['weiyhj_area'],'text','','','默认值，单位：米');
	showsetting('使用道具后搜索商家的范围','weiyhj_daoju',$weixin_config['weiyhj_daoju'],'text','','','使用道具后，单位：米');
	showsetting('如果没有搜索结果的返回值','weiyhj_text',$weixin_config['weiyhj_text'],'textarea','','','如果在搜索范围内没有搜索出商家，显示的默认内容');
	showsetting('文本发送机器人','weiyhj_jiqiren',$weixin_config['weiyhj_jiqiren'],'textarea','','','格式为：<br />输入=输出');
	showsubmit('submit');
	showtablefooter();
	showformfooter();

}else{
	$post_array = array('weixin_hao','weixin_token','weixin_area','weixin_daoju','weixin_text','weixin_text','weixin_jiqiren','weitg_hao','weitg_token','weitg_area','weitg_daoju','weitg_text','weitg_text','weitg_jiqiren','weiyhj_hao','weiyhj_token','weiyhj_area','weiyhj_daoju','weiyhj_text','weiyhj_text','weiyhj_jiqiren');
	foreach ( $post_array as $value){
		$data[$value] = $_POST[$value];
		if(DB::result_first("SELECT count(*) FROM ".DB::table('brand_settings')." WHERE variable='".$value."'")==1){
			DB::update('brand_settings', array('value'=>$data[$value]),array('variable'=>$value));
		}else{
			DB::insert('brand_settings', array('value'=>$data[$value],'variable'=>$value));
		}
		DB::update('forum_threadtype', array('fid'=>$data['weixin_forum']),array('typeid'=>$data['weixin_zidingyi']));
	}
	cpmsg('微信设置成功！','action=plugins&identifier=yikatong&pmod=admin&bmenu=setting&baction=setting_weixin','succeed');


}
?>