<?php
/**
 *      [Discuz!] (C)2012-2099 YiQiXueBa.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: yktcp.inc.php 24411 2012-09-17 05:09:03Z yangwen $
 */
if(!defined('IN_DISCUZ') || !defined('IN_ADMINCP')) {
	exit('Access Denied');
}
if(getgpc('daoru')=='yes') {
	if(submitcheck('yktdrsubmit')) {
		if($_FILES["drfile"]["type"]!='text/plain'){
			cpmsg('�ļ���ʽ���ԣ�');
		}elseif($_FILES["drfile"]["size"]>20000){
			cpmsg('�ļ�̫���ˣ��ϴ��ļ�Ӧ����2M');
		}else{
			if(file_exists("data/".$_FILES["drfile"]["name"])){
				unlink("data/".$_FILES["drfile"]["name"]);
			}
			move_uploaded_file($_FILES["drfile"]["tmp_name"],"data/".$_FILES["drfile"]["name"]);
			$contents = file_get_contents("data/".$_FILES["drfile"]["name"]);
			$contents = str_replace("\t","",$contents);
			$cont_arr = explode("\n",$contents);
			$k=0;
			foreach ($cont_arr as $fvalue){
				$hcont_arr = explode("|",$fvalue);
				if(count($hcont_arr)==5) {
					$yikatong['ID'] = $hcont_arr[0];
					$yikatong['cardpass'] = trim($hcont_arr[1]);
					$yikatong['jine'] = trim($hcont_arr[2]);
					$yikatong['jifen'] = trim($hcont_arr[3]);
					$yikatong['itemid'] = trim($hcont_arr[4]);
					if(DB::result_first("SELECT count(*) FROM ".DB::table('brand_cikahaoma')." WHERE ID=".intval($fvalue))==0) {
						DB::insert('brand_cikahaoma', $yikatong);	
						$k++;
					}
				}
			}
			unlink("data/".$_FILES["drfile"]["name"]);
			cpmsg('���ļ�������'.count($cont_arr).'�����ţ��ɹ�����'.$k.'����һ��ͨ����ɹ�', 'action=plugins&identifier=yikatong&pmod=admin&baction=yktcp&bmenu=yikatong', 'succeed');
		}
	
	}else{

		showtips('<li>����ſ�</li>');
		showformheader("plugins&identifier=yikatong&pmod=admin&baction=yktcp&bmenu=yikatong&daoru=yes", 'enctype="multipart/form-data"');
		showtableheader('����ſ�');
		showsetting('����ſ��ļ�','drfile','','file');
		showsubmit('yktdrsubmit');
		showtablefooter();
		showformfooter();
	}

}else{
	if(!submitcheck('yktsubmit')) {
		//var_dump($_POST);
		showtips('<li><a href="'.ADMINSCRIPT.'?action=plugins&identifier=yikatong&pmod=admin&baction=yktcp&bmenu=yikatong&daoru=yes">����ſ�</a></li>');
		showformheader("plugins&identifier=yikatong&pmod=admin&baction=yktcp&bmenu=yikatong");
		echo '<div style="height:30px;line-height:30px;">��Ա�ʺţ�<input type="text" name="hyzh" class="txt" value="'.$_POST['hyzh'].'" />�ſ����룺<input type="text" class="txt" name="cikahao" value="'.$_POST['cikahao'].'" />״̬��<select name="zhuangtai"><option value="0">����״̬</option><option value="1" '.($_POST['zhuangtai']==1?' selected':'').'>δ����</option><option value="2" '.($_POST['zhuangtai']==2?' selected':'').'>�Ѽ���</option></select> <input type="submit" class="btn" value="'.cplang('search').'"  name="srchsubmit"  /></div>';showtableheader('�ſ��б�');
		showsubtitle(array('�ſ�ID','�ſ���Կ','���','����','��������', '���û�'));
		$where = '';
		if($_POST['hyzh']){
			$where .= "and username like '%".trim($_POST['hyzh'])."%' ";
		}
		if($_POST['cikahao']){
			$where .= "and ID = '".trim($_POST['cikahao'])."' ";
		}
		if($_POST['zhuangtai']){
			$where .= "and jihuo = ".(intval($_POST['zhuangtai'])-1);
		}
		$where = substr($where,3);
		if(trim($where)!=''){
			$where = " WHERE ".$where;
		}
		//var_dump($where);
		//$sql = "alter table ".$_G['config']['db'][1]['tablepre']."brand_cikahaoma add username varchar(255) not Null\n";
		//$sql = "alter table ".$_G['config']['db'][1]['tablepre']."brand_cikahaoma add jihuo varchar(255) not Null";
		//runquery($sql); 
		$perpage = 10;
		$start = ($page - 1) * $perpage;
		$sitecount = DB::result_first("SELECT count(*) FROM ".DB::table('brand_cikahaoma').$where);
		$multi = multi($sitecount, $perpage, $page, ADMINSCRIPT."?action=plugins&identifier=yikatong&pmod=admin&baction=yktcp&bmenu=yikatong");
		$query = DB::query("SELECT * FROM ".DB::table('brand_cikahaoma').$where." order by ID desc limit ".$start.",".$perpage." ");
		while($row = DB::fetch($query)) {
			$sjid = DB::result_first("SELECT count(*) FROM ".DB::table('forum_thread')." WHERE tid='".$row['itemid']."'")>0?DB::result_first("SELECT subject FROM ".DB::table('forum_thread')." WHERE tid='".$row['itemid']."'"):'δ����';
			showtablerow('',
				array('style="width:120px;"','style="width:120px;"',''),
				array($row['ID'],
				$row['cardpass'],
				$row['jine'],
				$row['jifen'],
				$sjid,
				DB::result_first("SELECT count(*) FROM ".DB::table('brand_hy')." WHERE hykh='".$row['ID']."'")==0?'δ����':DB::result_first("SELECT username FROM ".DB::table('common_member')." WHERE uid='".DB::result_first("SELECT hyid FROM ".DB::table('brand_hy')." WHERE hykh='".$row['ID']."'")."'")
				)
			);
		}
		showsubmit('yktsubmit', 'submit', '', '', $multi);
		showtablefooter();
		showformfooter();
	}else{

	}
}
?>
