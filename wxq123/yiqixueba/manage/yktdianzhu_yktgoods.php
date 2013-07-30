<?php

/**
*	一起学吧平台程序
*	文件名：yktdianzhu_yktgoods.php  创建时间：2013-6-17 22:27  杨文
*
*/

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$xflx_array = array('jici','shijian','liangka','xianjin','yue','jifen');

$subtype = trim(getgpc('subtype'));
$goodsid = intval(getgpc('goodsid'));

$goods_table = $base_setting['yiqixueba_yikatong_goods_table'];
$shop_table = $base_setting['yiqixueba_yikatong_shop_table'];
$yikatong_fields = dunserialize($base_setting['yiqixueba_yikatong_goodsfields']);

//店铺情况
$fields = dunserialize($base_setting['yiqixueba_yikatong_fields']);

$myshopoption = '';
$myshoplist = $myshop_in = array();
$query = DB::query("SELECT * FROM ".DB::table('yiqixueba_yikatong_shop')." WHERE uid = ".$_G['uid']." order by shopid asc");
$k = 0;
while($row = DB::fetch($query)) {
	$myshoplist[$k]['shopid'] = $row['oldshopid'];
	$myshoplist[$k]['shopname'] = DB::result_first("SELECT ".$fields['shopname']." FROM ".DB::table($base_setting['yiqixueba_yikatong_shop_table'])." WHERE ".$fields['shopid']."=".$row['oldshopid']);
	$myshopoption .= '<option value="'.$row['oldshopid'].'" '.($dianyuan_info['shopid'] ==$row['oldshopid'] ? ' selected' : '').'>'.$myshoplist[$k]['shopname'].'</option>';
	$myshop_in[] =  $row['oldshopid'];
	$k++;
}
$myshop_num = count($myshoplist);
///////////////////////////

$goods_info = $goodsid ? DB::fetch_first("SELECT * FROM ".DB::table($goods_table)." WHERE ".$yikatong_fields['goodsid']."=".$goodsid) : array();
$setting_info = $goodsid ? DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_yikatong_goods')." WHERE goodsid=".$goodsid) : array();
$setting_edit = $goodsid ? DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_yikatong_goods_temp')." WHERE goodsid=".$goodsid) : array();


//dump($setting_info);
//dump($goods_info);
//dump($myshoplist);
if($subtype == 'xiaofeisetting'){
	if(!submitcheck('xiaofeisettingsubmit')) {
		$goodsname = $goods_info[$yikatong_fields['goodsname']];
		$shopname = DB::result_first("SELECT ".$fields['shopname']." FROM ".DB::table($shop_table)." WHERE ".$fields['shopid']."=".$goods_info[$yikatong_fields['shopid']]);
		$goodspice = $yikatong_fields['goodspice'] ? (lang('plugin/yiqixueba','rmb').$goods_info[$yikatong_fields['goodspice']].lang('plugin/yiqixueba','rmbyuan')) : '<input type="text" style=" height: 17px; padding: 2px 4px;"  size="5"  name="goodspice" value="'.$setting_info['goodspice'].'">';
		$goodsnum = $yikatong_fields['goodsnum'] ? $goods_info[$yikatong_fields['goodsnum']] : '<input type="text" style=" height: 17px; padding: 2px 4px;"  size="5"  name="goodsnum" value="'.$setting_info['goodsnum'].'">';
		//消费形式
		$xflx_conment = $xflx_edit_conment = array();
		foreach ( $xflx_array as $k => $v ){
			//当前
			$setting_text = dunserialize($setting_info[$v.'text']);
			//修改
			$setting_edit_text = dunserialize($setting_edit[$v.'text']);

			$xflx_title[$k] = lang('plugin/yiqixueba','xiaofei_'.$v);
			$xflx_conment[$k] =  lang('plugin/yiqixueba','dangqian').':&nbsp;&nbsp;<input type="checkbox" name="'.$v.'" '.($setting_info[$v] ? ' checked="checked"':'').'  disabled>&nbsp;&nbsp;'.lang('plugin/yiqixueba','available');
			$xflx_edit_conment[$k] =  lang('plugin/yiqixueba','xiugai').':&nbsp;&nbsp;<input type="checkbox" name="'.$v.'" '.($setting_edit[$v] ? ' checked="checked"':'').'>&nbsp;&nbsp;'.lang('plugin/yiqixueba','available');
			if($v=='jici'){
				$xflx_conment[$k] .= '&nbsp;&nbsp;'.lang('plugin/yiqixueba','cishu').'<input type="text" style=" height: 17px; padding: 2px 4px;"  size="5"  name="setting_info['.$v.'][cishu]" value="'.$setting_text['cishu'].'"  disabled>';
				$xflx_edit_conment[$k] .= '&nbsp;&nbsp;'.lang('plugin/yiqixueba','cishu').'<input type="text" style=" height: 17px; padding: 2px 4px;"  size="5"  name="setting_info['.$v.'][cishu]" value="'.$setting_edit_text['cishu'].'">';
			}elseif($v=='shijian'){
				$xflx_conment[$k] .= '&nbsp;&nbsp;'.lang('plugin/yiqixueba','daoqishijian').'<input type="text" style=" height: 17px; padding: 2px 4px;"  size="12"  name="setting_info['.$v.'][daoqi]" value="'.$setting_text['cishu'].'"  onclick="showcalendar(event, this)"  disabled>';
				$xflx_edit_conment[$k] .= '&nbsp;&nbsp;'.lang('plugin/yiqixueba','daoqishijian').'<input type="text" style=" height: 17px; padding: 2px 4px;"  size="12"  name="setting_info['.$v.'][daoqi]" value="'.$setting_edit_text['cishu'].'"  onclick="showcalendar(event, this)">';
			}
			if(in_array($v, array('jici','shijian','liangka','xianjin'))){
				$xflx_conment[$k] .= '&nbsp;&nbsp;'.lang('plugin/yiqixueba','xianjinfeiyong').'<input type="text" style=" height: 17px; padding: 2px 4px;"  size="5"  name="setting_info['.$v.'][feiyong]" value="'.$setting_text['feiyong'].'" disabled>'.lang('plugin/yiqixueba','rmbyuan');
				$xflx_edit_conment[$k] .= '&nbsp;&nbsp;'.lang('plugin/yiqixueba','xianjinfeiyong').'<input type="text" style=" height: 17px; padding: 2px 4px;"  size="5"  name="setting_info['.$v.'][feiyong]" value="'.$setting_edit_text['feiyong'].'">'.lang('plugin/yiqixueba','rmbyuan');
			}elseif(in_array($v, array('yue','jifen'))){
				$xflx_conment[$k] .= '&nbsp;&nbsp;'.lang('plugin/yiqixueba','kanei'.$v).'<input type="text" style=" height: 17px; padding: 2px 4px;"  size="5"  name="setting_info['.$v.'][feiyong]" value="'.$setting_text['feiyong'].'"    disabled>';
				$xflx_edit_conment[$k] .= '&nbsp;&nbsp;'.lang('plugin/yiqixueba','kanei'.$v).'<input type="text" style=" height: 17px; padding: 2px 4px;"  size="5"  name="setting_info['.$v.'][feiyong]" value="'.$setting_edit_text['feiyong'].'"  >';
			}
			if($v!='liangka'){
				$xflx_conment[$k] .= '&nbsp;&nbsp;'.lang('plugin/yiqixueba','jifenzengsong').'<input type="text" style=" height: 17px; padding: 2px 4px;"  size="5"  name="setting_info['.$v.'][zengsong]" value="'.$setting_text['zengsong'].'"    disabled>&nbsp;&nbsp;'.lang('plugin/yiqixueba','kaneichongzhi').'<input type="text" style=" height: 17px; padding: 2px 4px;"  size="5"  name="setting_info['.$v.'][chongzhi]" value="'.$setting_text['chongzhi'].'"    disabled>';
				$xflx_edit_conment[$k] .= '&nbsp;&nbsp;'.lang('plugin/yiqixueba','jifenzengsong').'<input type="text" style=" height: 17px; padding: 2px 4px;"  size="5"  name="setting_info['.$v.'][zengsong]" value="'.$setting_edit_text['zengsong'].'">&nbsp;&nbsp;'.lang('plugin/yiqixueba','kaneichongzhi').'<input type="text" style=" height: 17px; padding: 2px 4px;"  size="5"  name="setting_info['.$v.'][chongzhi]" value="'.$setting_edit_text['chongzhi'].'">';
			}
		}
	}else{
		$data = array();
		foreach($xflx_array as $k=>$v ){
			$data[$v] = trim(getgpc($v));
			$guize = getgpc('setting_info');
			$data[$v.'text'] = serialize($guize[$v]);
		}
		$data['goodspice'] = $yikatong_fields['goodspice'] ? $goods_info[$yikatong_fields['goodspice']] : intval(getgpc('goodspice'));
		$data['goodsnum'] = $yikatong_fields['goodsnum'] ? $goods_info[$yikatong_fields['goodsnum']] : intval(getgpc('goodsnum'));
		$data['start'] = strtotime(trim(getgpc('start')));
		$data['end'] = strtotime(trim(getgpc('end')));
		$data['status'] = 0;

		if(DB::result_first("SELECT count(*) FROM ".DB::table('yiqixueba_yikatong_goods')." WHERE goodsid=".$goodsid)==1){
			DB::update('yiqixueba_yikatong_goods_temp', $data,array('goodsid'=>$goodsid));
		}else{
			$data['goodsid'] = $goodsid;
			DB::insert('yiqixueba_yikatong_goods_temp', $data);
		}
		showmessage('商品设置成功，请等待审核', 'plugin.php?id=yiqixueba:manage&man=yktdianzhu&subman=yktgoods');
	}
}else{
	$myshop_in_text = implode(",",$myshop_in);
	$query = DB::query("SELECT * FROM ".DB::table($goods_table)." WHERE ".$yikatong_fields['shopid']." IN (".$myshop_in_text.") order by ".$yikatong_fields['goodsid']." desc");
	$k = 0;
	while($row = DB::fetch($query)) {
		$setting_info = DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_yikatong_goods')." WHERE goodsid=".$row[$yikatong_fields['goodsid']]) ;
		$setting_edit = DB::fetch_first("SELECT * FROM ".DB::table('yiqixueba_yikatong_goods_temp')." WHERE goodsid=".$row[$yikatong_fields['goodsid']]);
		
		$goodslist[$k]['goodsid'] = $row[$yikatong_fields['goodsid']];
		$goodslist[$k]['goodsname'] = $row[$yikatong_fields['goodsname']];
		$goodslist[$k]['goodspice'] = $yikatong_fields['goodspice'] ?$row[$yikatong_fields['goodspice']] : $setting_info['goodspice'];
		$goodslist[$k]['goodsnum'] = $yikatong_fields['goodsnum'] ? intval($row[$yikatong_fields['goodsnum']]) : (intval($setting_info['goodsnum']).($setting_edit ? '('.$setting_edit['goodsnum'].')':''));
		$goodslist[$k]['start'] = (dgmdate(intval($setting_info['start']),'d').($setting_edit['start'] ? '('.$setting_edit['start'].')':''));
		$goodslist[$k]['end'] = (dgmdate(intval($setting_info['end']),'d').($setting_edit['end'] ? '('.$setting_edit['end'].')':''));
		$k++;
	}
	$dianyuan_num = count($goodslist);
	//dump($goodslist);
}