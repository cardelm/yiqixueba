<?php
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
$plugin['ykt_credit'] = DB::result_first("SELECT value FROM ".DB::table('common_pluginvar')." WHERE variable='ykt_credit'");
$plugin['ykt_jifen'] = DB::result_first("SELECT value FROM ".DB::table('common_pluginvar')." WHERE variable='ykt_jifen'");
$sjgriup = DB::result_first("SELECT value FROM ".DB::table('common_pluginvar')." WHERE variable='ykt_sjgroup'");
$editid = getgpc('editid');
if($editid==''){
	showtableheader('�̼���Ϣ�б�');
	showsubtitle(array( '�û���', '�̼���Ϣ','�̼ҵ�ַ', '�绰', '���п���', '����','���','����','��Ա��','��������','��������','��������','����'));
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

		showtablerow('',array('style="width:60px;"','style="width:80px;"','style="width:120px;"','style="width:120px;"','style="width:150px;"','style="width:60px;"','style="width:60px;"','style="width:60px;"','style="width:40px;"','style="width:60px;"','style="width:60px;"','style="width:60px;"', ''),array($row['username'],$sjinfo['shangjianame'],$sjinfo['address'],$sjinfo['phone'],'['.$sjinfo['yinhangclass'].']'.$sjinfo['yinhangkahao'],$sjinfo['username'],$yue,$jfyue,count(dunserialize($sjinfo['members'])).'/'.count(dunserialize($sjinfo['sharemembers'])),$sjinfo['zongnum'],$sjinfo['zengsong'],$sjinfo['chunjifen'],'<a href="admin.php?action=plugins&identifier=yikatong&pmod=yktshangjia&editid='.$row['uid'].'">�༭</a>' ));
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
				cpmsg('������ʽ���ԣ�');
			}
			DB::update('yikatong_shangjia', $data,array('uid'=>$editid));
			DB::update('common_member_count', array("extcredits".$plugin['ykt_credit']=>$data['jine']),array('uid'=>$editid));
			cpmsg('�̼��޸ĳɹ�', 'action=plugins&identifier=yikatong&pmod=yktshangjia', 'succeed');
		//}
	}
	$memberinfo = DB::fetch_first("SELECT * FROM ".DB::table('common_member')." WHERE uid='".$editid."'");
	$sjinfo = DB::fetch_first("SELECT * FROM ".DB::table('yikatong_shangjia')." WHERE uid='".$editid."'");
	$yhcalss_arr = array("��������", "ũҵ����", "��������", "�й�����", "��ͨ����", "��������", "���ڷ�չ����", "�ַ�����", "������ҵ����", "տ������", "۴������", "����������", "ũҵ��չ����", "���ҿ�������", "��������", "����ũ����ҵ����", "��������ҵ����", "��������", "�Ϻ�ũ����", "��������", "��������", "��������","��ҵ����", "��������", "��������", "�Ϻ�����", "�������", "��������", "��������", "��������", "����й�", "��������", "�㶫��չ����", "��������", "��չ����", "��������", "�Ͼ�����", "�������", "ƽ������", "��������", "���Ź�������", "��������", "��������", "����־����", "��������", "��������", "��������", "���������й�", "���������й�", "���������й�", "���żλ�", "���������й�", "���ⶫ����������", "��������", "����ũ����", "������������", "��ݸ����", "��������", "������ҵ����", "Ȫ����ҵ����", "�ɶ�����", "��������ҵ����", "������Ͽ����", "��������", "��������", "����������", "��������");
	$yhclass_text = '<select name=data[yinhangclass]><option value="��ѡ��">��ѡ��</option>';
	foreach ( $yhcalss_arr as $yhcvalue ){
		$yhclass_text .= '<option value="'.$yhcvalue.'" '.($sjinfo['yinhangclass']==$yhcvalue?' selected':'').'>'.$yhcvalue.'</option>';
	}
	$yhclass_text .= '</select>';
	$block_text = '<select name=data[jsdate]><option value="��ѡ��">��ѡ��</option>';
	$query = DB::query("SELECT * FROM ".DB::table('common_block')." WHERE  blocktype  = '1'");
	while($row = DB::fetch($query)) {
		$block_text .= '<option value="'.$row['bid'].'" '.($sjinfo['jsdate']==$row['bid']?' selected':'').'>'.$row['name'].'</option>';
	}
	$block_text .= '</select>';
	showformheader("plugins&identifier=yikatong&pmod=yktshangjia&editid=".$editid);
	showtableheader('�༭�̼���Ϣ');
	
	showsetting('�û���','','',$memberinfo['username'].'<input type="hidden" name="editid" value="'.$editid.'">','','','�����̼ҵ��û����������޸�');
	showsetting('�̼���Ϣ','data[shangjianame]',$sjinfo['shangjianame'],'text','','','<font color="#FF0000">�̼ҵĵ�������</font>');
	showsetting('�̼ҵ�ַ','data[address]',$sjinfo['address'],'text','','');
	showsetting('�绰','data[phone]',$sjinfo['phone'],'text','','');
	showsetting('��������','','',$yhclass_text,'','');
	showsetting('���п���','data[yinhangkahao]',$sjinfo['yinhangkahao'],'text','','');
	showsetting('����','data[username]',$sjinfo['username'],'text','','');
	showsetting('���','data[jine]',DB::result_first("SELECT extcredits".$plugin['ykt_credit']." FROM ".DB::table('common_member_count')." WHERE uid='".$editid."'"),'text','','','<font color="#FF0000">�������д���������̼��˻��ϵĽ�Ǯ������ȷ���Ѿ���ȡ���̼ҵķ��ú󲢺�ʵ������д</font>');
	showsetting('��������','data[zongnum]',$sjinfo['zongnum'],'text','','','<font color="#FF0000">��������ע�⣺�����Աˢ��ת��1000���ѻ��ָ��̼ң�ˢ������������0.95,��ô�̼�ʵ�ʿ��յ�950�����ѻ��֣����۳���50�����ѻ�������վ��ӯ���㣩</font>');
	showsetting('��������','data[zengsong]',$sjinfo['zengsong'],'text','','','<font color="#FF0000">��������ע�⣺�����Աˢ��1000�����ѻ��֣���ô������������10�Ļ�����ʾÿ10�����ѻ��ֿ���ϵͳ��������һ�ֻ���1�㡣1000�����ѻ������Ŀɻ�ȡ100�����</font>');
	showsetting('��������','data[chunjifen]',$sjinfo['chunjifen'],'text','','','<font color="#FF0000">��������ע�⣺�����Ա���̼�����100Ԫ���̼�����PC�˻������Ͱ������100��ϵͳ�Ὣ�̼һ���ת���Ա�˺��ڡ��������������10.��Ա���̼�100Ԫ���ͻ��10�����</font>');
	showsetting('���ݵ��õ�ַ','','',$block_text,'','','��д�Ż�--ģ�����--<a href="admin.php?action=block&operation=jscall">���ݵ���</a>�еġ��ⲿ���á��������á�');
	showsubmit('yktsjeditsubmit');
	showtablefooter();
	showformfooter();

}
?>
