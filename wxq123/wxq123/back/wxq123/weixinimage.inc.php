<?php

/**
 *      [17xue8.cn] (C)2013-2099 杨文.
 *      这不是免费的。
 *
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
if($_G['cache']['plugin']['wxq123']['weixinimage']!='') {
	$membg = str_replace('{STATICURL}', STATICURL, $_G['cache']['plugin']['wxq123']['weixinimage']);
	if(!preg_match("/^".preg_quote(STATICURL, '/')."/i", $membg) && !(($valueparse = parse_url($membg)) && isset($valueparse['host']))) {
		$membg =  DISCUZ_ROOT.$_G['setting']['attachurl'].'temp/'.$_G['cache']['plugin']['wxq123']['weixinimage'];
	}
}else{
	$membg = '002.gif';
}
$size = GetImageSize($membg);
//var_dump($size);
$str = '7721';
$str1 = 'Ha';
$font = 'static/image/seccode/font/en/FetteSteinschrift.ttf';
$pic = imagecreate($size[0], intval($size[1]*1.2));
$simage = ImageCreateFromPNG($membg);
$bgcolor = imagecolorallocate($pic, 255, 255, 255);
$color = imagecolorallocate($pic, 255, 0, 0);
imagecopy($pic, $simage, 0, 0, 0, 0, $size[0], intval($size[1]*1.2));
imagefilledrectangle($pic,intval($size[0]*0.41), intval($size[1]*0.41),intval($size[0]*0.59), intval($size[1]*0.59),$bgcolor);
imagefilledrectangle($pic,0, intval($size[1]),intval($size[0]), intval($size[1]*1.2),$bgcolor);
imagettftext($pic, intval($size[0]*0.09), 0, intval($size[0]*0.41), intval($size[1]*0.525), $color, $font, $str1);
imagettftext($pic, intval($size[0]*0.1), 0, intval($size[0]*0.1), intval($size[1]*1.15), $color, $font, 'Code:'.$str);
header('Content-type: image/png');
imagepng($pic);
imagedestroy($simage);
imagedestroy($pic);

?>