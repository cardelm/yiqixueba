<?php
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
				if(strlen($hcont_arr[0])==8&&strlen(trim($hcont_arr[1]))==6&&DB::result_first("SELECT count(*) FROM ".DB::table('yikatong_card')." WHERE cardno='".$hcont_arr[0]."'")==0){
					$yikatong['uid'] = 0;
					$yikatong['cardno'] = $hcont_arr[0];
					$yikatong['cardpass'] = trim($hcont_arr[1]);
					$yikatong['shangjiaid'] = 0;
					$yikatong['jine'] = 0; 
					$yikatong['status'] = 0;
					DB::insert('yikatong_card', $yikatong);	
					$k++;
				}
			}
			unlink("data/".$_FILES["drfile"]["name"]);
			cpmsg('���ļ�������'.count($cont_arr).'�����ţ��ɹ�����'.$k.'����һ��ͨ����ɹ�', '', 'succeed');
		}
	
	}else{

		showtips('<li>����ſ�</li>');
		showformheader("plugins&identifier=yikatong&pmod=yktcp&daoru=yes", 'enctype="multipart/form-data"');
		showtableheader('����ſ�');
		showsetting('����ſ��ļ�','drfile','','file');
		showsubmit('yktdrsubmit');
		showtablefooter();
		showformfooter();
	}

}else{



	showtips('<li><a href="'.ADMINSCRIPT.'?action=plugins&identifier=yikatong&pmod=yktcp&daoru=yes">����ſ�</a></li>');
	showformheader("plugins&identifier=yikatong&pmod=yktcp");
	showtableheader('�ſ��б�');
	showsubtitle(array('�ſ�ID', '�ſ���Կ', '�ſ�״̬'));
	$perpage = 10;
	$start = ($page - 1) * $perpage;
	$sitecount = DB::result_first("SELECT count(*) FROM ".DB::table('yikatong_card'));
	$multi = multi($sitecount, $perpage, $page, ADMINSCRIPT."?action=plugins&identifier=yikatong&pmod=yktcp");
	$query = DB::query("SELECT * FROM ".DB::table('yikatong_card')." order by id asc limit ".$start.",".$perpage." ");
	while($row = DB::fetch($query)) {
		showtablerow('',array('style="width:120px;"','style="width:60px;"','style="width:60px;"'),array($row['cardno'],$row['cardpass'],$row['status']==0?'δ����':DB::result_first("SELECT username FROM ".DB::table('common_member')." WHERE uid='".$row['uid']."'")));
	}
	//showsubmit('yktsubmit', 'submit', '', '', $multi);
	echo '<tr><td>'.$multi.'</td></tr>';
	showtablefooter();
	showformfooter();
}
?>
