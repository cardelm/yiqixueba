<?php
function get_avatar($uid, $size = 'middle', $type = '') 
{
	global $_G;
	$ucenterurl =  $_G['setting']['ucenterurl'];
	$size = in_array($size, array('big', 'middle', 'small')) ? $size : 'middle';
	$uid = abs(intval($uid));
	$uid = sprintf("%09d", $uid);
	$dir1 = substr($uid, 0, 3);
	$dir2 = substr($uid, 3, 2);
	$dir3 = substr($uid, 5, 2);
	$typeadd = $type == 'real' ? '_real' : '';
	$avatarfile=$ucenterurl.'/data/avatar/'.$dir1.'/'.$dir2.'/'.$dir3.'/'.substr($uid, -2).$typeadd."_avatar_$size.jpg";
	return $avatarfile;
}
	
function get_noavatar($size='middle')
{
	global $_G;
	$ucenterurl =  $_G['setting']['ucenterurl'];
	return 	$ucenterurl.'/images/noavatar_'.$size.'.gif';
}
	
function archivermessage($message)
{
	//$message=htmlspecialchars($message);
	$message=nl2br($message);
	$message=strip_tags($message);
	$message=preg_replace('/\[attach\](.+?)\[\/attach\]/is','',$message);
	$message=preg_replace('/\[img\](.+?)\[\/img\]/is','',$message);
	$message=preg_replace('/\[audio\](.+?)\[\/audio\]/is','',$message);
	$message=preg_replace('/\[media\](.+?)\[\/media\]/is','',$message);
	$message=preg_replace('/\[flash\](.+?)\[\/flash\]/is','',$message);
	$message=preg_replace("/\[hide=?\d*\](.*?)\[\/hide\]/is",'',$message);
	$message=preg_replace("/\[\/?\w+=?.*?\]/",'',$message);
	return $message;
}

function get_attachurl($remote)
{
	global $_G;
	if ($remote) return $_G['setting']['ftp']['attachurl'];
	else return $_G['setting']['attachurl'];
}

function get_extension($file)
{
	return pathinfo($file, PATHINFO_EXTENSION);
}
?>
