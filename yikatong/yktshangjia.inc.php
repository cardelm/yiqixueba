<?php
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
$plugin['ykt_credit'] = DB::result_first("SELECT value FROM ".DB::table('common_pluginvar')." WHERE variable='ykt_credit'");
$plugin['ykt_jifen'] = DB::result_first("SELECT value FROM ".DB::table('common_pluginvar')." WHERE variable='ykt_jifen'");
$sjgriup = DB::result_first("SELECT value FROM ".DB::table('common_pluginvar')." WHERE variable='ykt_sjgroup'");
$editid = getgpc('editid');
if($editid==''){
	showtableheader('商家信息列表');
	showsubtitle(array( '用户名', '商家信息','商家地址', '电话', '银行卡号', '姓名','余额','积分','会员数','消费利率','赠送利率','积分赠送','操作'));
	$perpage = 20;
	$start = ($page - 1) * $perpage;
	$sitecount = DB::result_first("SELECT count(*) FROM ".DB::table('common_member')." WHERE groupid='".$sjgriup."'");
	$multi = multi($sitecount, $perpage, $page, ADMINSCRIPT."?action=plugins&identifier=yikatong&pmod=yktshangjia");
	$query = DB::query("SELECT * FROM ".DB::table('common_member')." WHERE groupid='".$sjgriup."' order by uid asc limit ".$start.",".$perpage." ");
	while($row = DB::fetch($query)) {
		$sjinfo = DB::fetch_first("SELECT * FROM ".DB::table('yikatong_shangjia')." WHERE uid='".$row['uid']."'");
		if(!$sjinfo){
			DB::insert('yikatong_shangjia', array('uid'=>$row['uid']));
			DB::update('yikatong_shangjia', array('members'=>serialize(array()),'sharemembers'=>serialize(array())),array('uid'=>$row['uid']));
		}
		$yue =  DB::result_first("SELECT extcredits".$plugin['ykt_credit']." FROM ".DB::table('common_member_count')." WHERE uid='".$row['uid']."'");
		$jfyue =  DB::result_first("SELECT extcredits".$plugin['ykt_jifen']." FROM ".DB::table('common_member_count')." WHERE uid='".$row['uid']."'");

		showtablerow('',array('style="width:60px;"','style="width:80px;"','style="width:120px;"','style="width:120px;"','style="width:150px;"','style="width:60px;"','style="width:60px;"','style="width:60px;"','style="width:40px;"','style="width:60px;"','style="width:60px;"','style="width:60px;"', ''),array($row['username'],$sjinfo['shangjianame'],$sjinfo['address'],$sjinfo['phone'],'['.$sjinfo['yinhangclass'].']'.$sjinfo['yinhangkahao'],$sjinfo['username'],$yue,$jfyue,count(dunserialize($sjinfo['members'])).'/'.count(dunserialize($sjinfo['sharemembers'])),$sjinfo['zongnum'],$sjinfo['zengsong'],$sjinfo['chunjifen'],'<a href="admin.php?action=plugins&identifier=yikatong&pmod=yktshangjia&editid='.$row['uid'].'">编辑</a>' ));
	}
	//showsubmit('yktsjsubmit', 'submit', '', '', $multi);
	echo '<tr><td>'.$multi.'</td></tr>';
	showtablefooter();
}else{
	$editid = getgpc('editid');
	if(submitcheck('yktsjeditsubmit')) {
		//if(getgpc('shangjianame')!=''&&DB::result_first("SELECT count(*) FROM ".DB::table('yikatong_shangjia')." WHERE shangjianame='".getgpc('shangjianame')."'")==1) {
			$data = getgpc('data');
			$data['status'] = 0;
			if($data['zongnum']<0||$data['zongnum']>1){
				cpmsg('比例格式不对！');
			}
			DB::update('yikatong_shangjia', $data,array('uid'=>$editid));
			DB::update('common_member_count', array("extcredits".$plugin['ykt_credit']=>$data['jine']),array('uid'=>$editid));
			cpmsg('商家修改成功', 'action=plugins&identifier=yikatong&pmod=yktshangjia', 'succeed');
		//}
	}
	$memberinfo = DB::fetch_first("SELECT * FROM ".DB::table('common_member')." WHERE uid='".$editid."'");
	$sjinfo = DB::fetch_first("SELECT * FROM ".DB::table('yikatong_shangjia')." WHERE uid='".$editid."'");
	$yhcalss_arr = array("工商银行", "农业银行", "建设银行", "中国银行", "交通银行", "招商银行", "深圳发展银行", "浦发银行", "桂林商业银行", "湛江商行", "鄞州银行", "进出口银行", "农业发展银行", "国家开发银行", "富滇银行", "深圳农村商业银行", "柳州市商业银行", "吉林银行", "上海农商行", "西安商行", "民生银行", "华夏银行","兴业银行", "中信银行", "北京银行", "上海银行", "光大银行", "浙商银行", "东亚银行", "恒生银行", "汇丰中国", "渣打银行", "广东发展银行", "花旗银行", "星展银行", "徽商银行", "南京银行", "恒丰银行", "平安银行", "广州银行", "厦门国际银行", "荷兰银行", "华侨银行", "德意志银行", "杭州银行", "宁波银行", "渤海银行", "永亨银行中国", "南商银行中国", "友利银行中国", "中信嘉华", "巴黎银行中国", "三菱东京日联银行", "瑞穗银行", "北京农商行", "邮政储蓄银行", "东莞银行", "汉口银行", "法国兴业银行", "泉州商业银行", "成都银行", "厦门市商业银行", "福建海峡银行", "包商银行", "大连银行", "哈尔滨银行", "大庆商行");
	$yhclass_text = '<select name=data[yinhangclass]><option value="请选择">请选择</option>';
	foreach ( $yhcalss_arr as $yhcvalue ){
		$yhclass_text .= '<option value="'.$yhcvalue.'" '.($sjinfo['yinhangclass']==$yhcvalue?' selected':'').'>'.$yhcvalue.'</option>';
	}
	$yhclass_text .= '</select>';
	$block_text = '<select name=data[jsdate]><option value="请选择">请选择</option>';
	$query = DB::query("SELECT * FROM ".DB::table('common_block')." WHERE  blocktype  = '1'");
	while($row = DB::fetch($query)) {
		$block_text .= '<option value="'.$row['bid'].'" '.($sjinfo['jsdate']==$row['bid']?' selected':'').'>'.$row['name'].'</option>';
	}
	$block_text .= '</select>';
	showformheader("plugins&identifier=yikatong&pmod=yktshangjia&editid=".$editid);
	showtableheader('编辑商家信息');
	
	showsetting('用户名','','',$memberinfo['username'].'<input type="hidden" name="editid" value="'.$editid.'">','','','联盟商家的用户名，不能修改');
	showsetting('商家信息','data[shangjianame]',$sjinfo['shangjianame'],'text','','','<font color="#FF0000">商家的店铺名称</font>');
	showsetting('商家地址','data[address]',$sjinfo['address'],'text','','');
	showsetting('电话','data[phone]',$sjinfo['phone'],'text','','');
	showsetting('银行类型','','',$yhclass_text,'','');
	showsetting('银行卡号','data[yinhangkahao]',$sjinfo['yinhangkahao'],'text','','');
	showsetting('姓名','data[username]',$sjinfo['username'],'text','','');
	showsetting('余额','data[jine]',DB::result_first("SELECT extcredits".$plugin['ykt_credit']." FROM ".DB::table('common_member_count')." WHERE uid='".$editid."'"),'text','','','<font color="#FF0000">请谨慎填写，这里是商家账户上的金钱数，请确定已经收取了商家的费用后并核实认真填写</font>');
	showsetting('消费利率','data[zongnum]',$sjinfo['zongnum'],'text','','','<font color="#FF0000">消费利率注解：例如会员刷卡转账1000消费积分给商家，刷卡利率则设置0.95,那么商家实际可收到950点消费积分！（扣除的50点消费积分则是站长盈利点）</font>');
	showsetting('赠送利率','data[zengsong]',$sjinfo['zengsong'],'text','','','<font color="#FF0000">赠送利率注解：如果会员刷卡1000点消费积分，那么赠送利率设置10的话，表示每10点消费积分可由系统赠送另外一种积分1点。1000点消费积分消耗可换取100点积分</font>');
	showsetting('积分赠送','data[chunjifen]',$sjinfo['chunjifen'],'text','','','<font color="#FF0000">积分赠送注解：例如会员在商家消费100元，商家则在PC端积分赠送板块输入100，系统会将商家积分转入会员账号内。如积分赠送设置10.会员给商家100元，就获得10点积分</font>');
	showsetting('数据调用地址','','',$block_text,'','','填写门户--模块管理--<a href="admin.php?action=block&operation=jscall">数据调用</a>中的“外部调用”进行设置。');
	showsubmit('yktsjeditsubmit');
	showtablefooter();
	showformfooter();

}
?>
