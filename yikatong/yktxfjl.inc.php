<?php
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$xflx_array = array('����','�ֽ�����','�������','��������','��ҵ����','��������');
$zt_array = array('��','����');
$query = DB::query("SELECT * FROM ".DB::table('brand_xfjl')." WHERE hyuid =".$_G['uid']);
$key = 0;
while($row = DB::fetch($query)) {
	$xiaofeijilu[$key] = $row;
	
	$xiaofeijilu[$key]['xflx'] = $xflx_array[$row['xflx']];
	$xiaofeijilu[$key]['rangli'] = $row['rangli']*100;
	$xiaofeijilu[$key]['zt'] = $zt_array[$row['zt']];
	$key++;
}
$xflu_num = count($xiaofeijilu);
?>