<?php

/**
*	һ��ѧ��ƽ̨����
*	�ļ�����shopdisplay_dianping.inc.php  ����ʱ�䣺2013-7-2 09:11  ����
*
*/

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
//��Ҫ��¼
if(!$_G['uid']) {
	showmessage('login_before_enter_home', null, array(), array('showmsg' => true, 'login' => 1));
}

$shopid = intval(getgpc('shopid'));

if(!submitcheck('dianpingsubmit')) {
	$optionarray = dunserialize($base_setting['yiqixueba_brand_dianping_option']);
	$option_text = '';
	for($i=5;$i>=0;$i--){
		$option_text .= '<option value="'.$i.'">'.$i.'</option>';
	}


	$options = array();
	foreach($optionarray as $k=>$v ){
		if($v['status']){
			$options[$k]['name'] = $v['name'];
			foreach( explode("|",$v['title']) as $kk=>$vv ){
				$options[$k]['select'] .= '<select name="option_'.$kk.'"><option value="">'.$vv.'</option>';
				$options[$k]['select'] .= $option_text;
				$options[$k]['select'] .= '</select>';
			}
		}
	}

	include template('yiqixueba:'.$template_file);
}else{
}
?>