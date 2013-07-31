<?php
/**
 *      [yikatong!] (C)2012-2099 YiQiXueBa.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: setting_reg.inc.php 24411 2012-09-17 05:09:03Z yangwen $
 */
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

$api_key = DB::result_first("SELECT svalue FROM ".DB::table('common_setting')." WHERE skey='yikatong_api_key'");
	
if($api_key&&empty($_GET['type'])){
		showtips('您已经注册，您的api_key为：'.$api_key.'。点击<a href="'.ADMINSCRIPT.'?action=plugins&identifier=yikatong&pmod=admin&bmenu=setting&baction=setting_reg&type=shenqing">这里</a>重新申请网站key');	
}else{
	if(!submitcheck('submit')) {
		require_once libfile('function/profile');
		showtips('<li>为了保护您的合法权益，将进行插件正版保护注册</li><li>地区的填写之前，请确保discuz的默认地区没有修改过</li>');
		showformheader('plugins&identifier=yikatong&pmod=admin&bmenu=setting&baction=setting_reg&type=shenqing');
		showtableheader('插件注册');
		$elems = array('resideprovince', 'residecity', 'residedist', 'residecommunity');
		showsetting('所在地区', '', '', '<div id="residedistrictbox">'.showdistrict(array(0,0,0,0), $elems, 'residedistrictbox', 1, 'reside').'</div>','','','填写您的网站使用地区，务必填写正确，否则您的商家无法选择正确的地区');
		showsetting('手机号码','site_tel','','text','','','能够使用的手机号码');
		showsubmit('submit');
		showtablefooter();
		showformfooter();

	}else{
		if($_POST['site_tel']=='') {
			cpmsg('请填写您的联系手机号码');
		}
		if(strlen($_POST['site_tel'])!=11) {
			cpmsg('手机号码位数不对');
		}

		$resideprovince = $_POST['resideprovince']?DB::result_first("SELECT id FROM ".DB::table('common_district')." WHERE name='".$_POST['resideprovince']."'"):0;
		$residecity = $_POST['residecity']?DB::result_first("SELECT id FROM ".DB::table('common_district')." WHERE name='".$_POST['residecity']."'"):0;
		$residedist = $_POST['residedist']?DB::result_first("SELECT id FROM ".DB::table('common_district')." WHERE name='".$_POST['residedist']."'"):0;
		$residecommunity = $_POST['residecommunity']?DB::result_first("SELECT id FROM ".DB::table('common_district')." WHERE name='".$_POST['residecommunity']."'"):0;
		if($resideprovince==0||$residecity==0) {
			cpmsg('请选择所在地');
		}
		


		require_once DISCUZ_ROOT.'./source/discuz_version.php';
		$install_data = array();
		$install_data['site_info'] = $_SERVER['SERVER_SOFTWARE'].$_SERVER['SERVER_NAME'].$_SERVER['DOCUMENT_ROOT'].$_SERVER['SERVER_ADMIN'].$_SERVER['SERVER_ADDR'].PHP_VERSION.PHP_OS;
		$install_data['site_url'] = $_G['siteurl'];
		$install_data['site_adminemail'] = $_G['setting']['adminemail'];
		$install_data['site_charset'] = strtolower($_G['charset']);
		$install_data['site_version'] = DISCUZ_VERSION;
		$install_data['site_release'] = DISCUZ_RELEASE;
		$install_data['site_timestamp'] = TIMESTAMP;
		$install_data['pluginidentifier'] = 'yikatong';
		$install_data['pluginver'] = 'V2.0';
		$install_data = strtolower($install_data['site_charset'])=='gbk'?changtext($install_data,'GBK','utf-8'):$install_data;
		$install_data['site_tel'] = urldecode($_POST['site_tel']);
		$install_data['resideprovince'] = $resideprovince;
		$install_data['residecity'] = $residecity;
		$install_data['residedist'] = $residedist;
		$install_data['residecommunity'] = $residecommunity;

		$sitestr = serialize($install_data);

		$sitestr=base64_encode($sitestr);
		$reg_url = 'http://www.17xue8.cn/xueba.php?mod=api&type=reg&charset='.$install_data['site_charset'].'&data='.$sitestr.'&sign='.md5(md5($sitestr));

		$output_text = file_get_contents($reg_url);

		$output_arr = unserialize($output_text);

		if($output_arr['errinfo']) {
			cpmsg($output_arr['errinfo'].'，请联系插件作者！');
		}

		if($output_arr['api_key']!='' && strlen($output_arr['api_key'])==32) {
			if(DB::result_first("SELECT count(*) FROM ".DB::table('common_setting')." WHERE skey='yikatong_api_key'")==1) {
				DB::update('common_setting', array('svalue'=>$output_arr['api_key']),array('skey'=>'yikatong_api_key'));
			}else{
				DB::insert('common_setting', array('svalue'=>$output_arr['api_key'],'skey'=>'yikatong_api_key'));
			}
			if(DB::result_first("SELECT count(*) FROM ".DB::table('common_setting')." WHERE skey='yikatong_site_prov'")==1) {
				DB::update('common_setting', array('svalue'=>$output_arr['site_prov']),array('skey'=>'yikatong_site_prov'));
			}else{
				DB::insert('common_setting', array('svalue'=>$output_arr['site_prov'],'skey'=>'yikatong_site_prov'));
			}
			if(DB::result_first("SELECT count(*) FROM ".DB::table('common_setting')." WHERE skey='yikatong_site_city'")==1) {
				DB::update('common_setting', array('svalue'=>$output_arr['site_city']),array('skey'=>'yikatong_site_city'));
			}else{
				DB::insert('common_setting', array('svalue'=>$output_arr['site_city'],'skey'=>'yikatong_site_city'));
			}
			if(DB::result_first("SELECT count(*) FROM ".DB::table('common_setting')." WHERE skey='yikatong_site_update'")==1) {
				DB::update('common_setting', array('svalue'=>TIMESTAMP),array('skey'=>'yikatong_site_update'));
			}else{
				DB::insert('common_setting', array('svalue'=>TIMESTAMP,'skey'=>'yikatong_site_update'));
			}
			cpmsg('注册成功，您的api_key值为：'.$output_arr['api_key'],'action=plugins&identifier=yikatong&pmod=admin&bmenu=setting&baction=index');
		}else{
			cpmsg('注册失败，请联系插件作者！');
		}
	}
}
?>