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
	showtips('<li>��ʹ��΢��֮ǰ����ȷ��վ���Ѿ���������վ�Ĺ���΢���ʺţ�</li><li>΢�̼��Ѿ��������������Ҫ�ڴ˴�����΢�̼ң�</li><li>����΢�Ź������е�url��ַ��д��'.$_G['siteurl'].'weituangou.php</li><li>����΢�Żݾ������е�url��ַ��д��'.$_G['siteurl'].'weiyouhuijuan.php</li>');
	showformheader('plugins&identifier=yikatong&pmod=admin&bmenu=setting&baction=setting_weixin');
	showtableheader('΢�Ź�����');
	showsetting('������վ����΢�Ź����ʺ�','weitg_hao',$weixin_config['weitg_hao'],'text','','','����վ���Ĺ���΢���ʺ�');
	showsetting('������վ����΢��TOKENֵ','weitg_token',$weixin_config['weitg_token'],'text','','','����վ���Ĺ���΢���ʺ�');
	showsetting('Ĭ�������̼ҵķ�Χ','weitg_area',$weixin_config['weitg_area'],'text','','','Ĭ��ֵ����λ����');
	showsetting('ʹ�õ��ߺ������̼ҵķ�Χ','weitg_daoju',$weixin_config['weitg_daoju'],'text','','','ʹ�õ��ߺ󣬵�λ����');
	showsetting('���û����������ķ���ֵ','weitg_text',$weixin_config['weitg_text'],'textarea','','','�����������Χ��û���������̼ң���ʾ��Ĭ������');
	showsetting('�ı����ͻ�����','weitg_jiqiren',$weixin_config['weitg_jiqiren'],'textarea','','','��ʽΪ��<br />����=���');
	showtablefooter();
	showtableheader('΢�Żݾ�����');
	showsetting('������վ����΢�Ź����ʺ�','weiyhj_hao',$weixin_config['weiyhj_hao'],'text','','','����վ���Ĺ���΢���ʺ�');
	showsetting('������վ����΢��TOKENֵ','weiyhj_token',$weixin_config['weiyhj_token'],'text','','','����վ���Ĺ���΢���ʺ�');
	showsetting('Ĭ�������̼ҵķ�Χ','weiyhj_area',$weixin_config['weiyhj_area'],'text','','','Ĭ��ֵ����λ����');
	showsetting('ʹ�õ��ߺ������̼ҵķ�Χ','weiyhj_daoju',$weixin_config['weiyhj_daoju'],'text','','','ʹ�õ��ߺ󣬵�λ����');
	showsetting('���û����������ķ���ֵ','weiyhj_text',$weixin_config['weiyhj_text'],'textarea','','','�����������Χ��û���������̼ң���ʾ��Ĭ������');
	showsetting('�ı����ͻ�����','weiyhj_jiqiren',$weixin_config['weiyhj_jiqiren'],'textarea','','','��ʽΪ��<br />����=���');
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
	cpmsg('΢�����óɹ���','action=plugins&identifier=yikatong&pmod=admin&bmenu=setting&baction=setting_weixin','succeed');


}
?>