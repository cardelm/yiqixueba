<?php

/**
 *      [17xue8.cn] (C)2013-2099 杨文.
 *      这不是免费的。
 *
 */

if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}

$submod = getgpc('submod');
$submods = array('list','info');
$submod = in_array($submod,$submods) ? $submod : $submods[0];

$page = getgpc('page');
$page = $page ? $page : 1;

//模块列表
if($submod == 'info') {
		if(!submitcheck('submit')) {
			showtips('member_list_tips');
			showformheader("plugins&identifier=wxq123&pmod=weixinadmin");
			showtableheader('member_list');
			showsubtitle(array('','时间', '类型','用户','内容' ));
			$perpage = 10;
			$start = ($page - 1) * $perpage;
			$sitecount = DB::result_first("SELECT count(*) FROM ".DB::table('wxq123_member'));
			$multi = multi($sitecount, $perpage, $page, ADMINSCRIPT."?action=plugins&identifier=wxq123&pmod=weixinadmin");
			$query = DB::query("SELECT * FROM ".DB::table('wxq123_member')." order by wid desc limit ".$start.",".$perpage." ");
			while($row = DB::fetch($query)) {
				showtablerow('', array('class="td25"','class="td28"', 'class="td28"', '', ''), array('',$row['wid'],dgmdate($row['regtime'],'dt'),'','')
				);
			}
			showsubmit('submit','submit','del','',$multi);
			showtablefooter();
			showformfooter();
		}else{
		}
}elseif($submod == 'list') {
		if(!submitcheck('submit')) {
			showtips('临时测试');
			showformheader("plugins&identifier=wxq123&pmod=weixinadmin");
			showtableheader('微信记录');
			showsubtitle(array('时间', '类型','输入','get','post','用户','内容' ));
			$perpage = 10;
			$start = ($page - 1) * $perpage;
			$sitecount = DB::result_first("SELECT count(*) FROM ".DB::table('wxq123_weixin_temp'));
			$multi = multi($sitecount, $perpage, $page, ADMINSCRIPT."?action=plugins&identifier=wxq123&pmod=weixinadmin");
			$query = DB::query("SELECT * FROM ".DB::table('wxq123_weixin_temp')." order by id desc limit ".$start.",".$perpage." ");
			while($row = DB::fetch($query)) {
				showtablerow('', array('', '', '', ''), array(
					dgmdate($row['time'], $format = 'dt'),
					$row['type'],
					$row['inputtype'],
					$row['get'],
					$row['post'],
					$row['fromusername'],
					$row['postxml'],
				));
			}
			showsubmit('submit','submit','del','',$multi);
			showtablefooter();
			showformfooter();
		}else{
		}

}
//$urlToEncode="http://weixin.qq.com/r/6HXFymLEelwFh3OpnyDM/type/pp";
$data['wxtype'] = 'login';
$data['wxcode'] = random(6);
$urlToEncode="login";
generateQRfromGoogle($urlToEncode);
function generateQRfromGoogle($chl,$widhtHeight ='150',$EC_level='L',$margin='0') {
    $chl = urlencode($chl);
    echo '<A href="http://weixin.qq.com/r/6HXFymLEelwFh3OpnyDM"><img src="http://chart.apis.google.com/chart?chs='.$widhtHeight.'x'.$widhtHeight.'&cht=qr&chld='.$EC_level.'|'.$margin.'&chl='.$chl.'" alt="QR code" widhtHeight="'.$widhtHeight.'" widhtHeight="'.$widhtHeight.'"/></a>';
}


?>
