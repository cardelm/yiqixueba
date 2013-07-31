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
			cpmsg('文件格式不对！');
		}elseif($_FILES["drfile"]["size"]>20000){
			cpmsg('文件太大了，上传文件应少于2M');
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
			cpmsg('卡文件共包含'.count($cont_arr).'个卡号，成功导入'.$k.'个，一卡通导入成功', 'action=plugins&identifier=yikatong&pmod=admin&baction=yktcp&bmenu=yikatong', 'succeed');
		}
	
	}else{

		showtips('<li>导入磁卡</li>');
		showformheader("plugins&identifier=yikatong&pmod=admin&baction=yktcp&bmenu=yikatong&daoru=yes", 'enctype="multipart/form-data"');
		showtableheader('导入磁卡');
		showsetting('导入磁卡文件','drfile','','file');
		showsubmit('yktdrsubmit');
		showtablefooter();
		showformfooter();
	}

}else{
	if(!submitcheck('yktsubmit')) {
		//var_dump($_POST);
		showtips('<li><a href="'.ADMINSCRIPT.'?action=plugins&identifier=yikatong&pmod=admin&baction=yktcp&bmenu=yikatong&daoru=yes">导入磁卡</a></li>');
		showformheader("plugins&identifier=yikatong&pmod=admin&baction=yktcp&bmenu=yikatong");
		echo '<div style="height:30px;line-height:30px;">会员帐号：<input type="text" name="hyzh" class="txt" value="'.$_POST['hyzh'].'" />磁卡号码：<input type="text" class="txt" name="cikahao" value="'.$_POST['cikahao'].'" />状态：<select name="zhuangtai"><option value="0">激活状态</option><option value="1" '.($_POST['zhuangtai']==1?' selected':'').'>未激活</option><option value="2" '.($_POST['zhuangtai']==2?' selected':'').'>已激活</option></select> <input type="submit" class="btn" value="'.cplang('search').'"  name="srchsubmit"  /></div>';showtableheader('磁卡列表');
		showsubtitle(array('磁卡ID','磁卡密钥','余额','积分','所属店铺', '绑定用户'));
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
			$sjid = DB::result_first("SELECT count(*) FROM ".DB::table('forum_thread')." WHERE tid='".$row['itemid']."'")>0?DB::result_first("SELECT subject FROM ".DB::table('forum_thread')." WHERE tid='".$row['itemid']."'"):'未分配';
			showtablerow('',
				array('style="width:120px;"','style="width:120px;"',''),
				array($row['ID'],
				$row['cardpass'],
				$row['jine'],
				$row['jifen'],
				$sjid,
				DB::result_first("SELECT count(*) FROM ".DB::table('brand_hy')." WHERE hykh='".$row['ID']."'")==0?'未激活':DB::result_first("SELECT username FROM ".DB::table('common_member')." WHERE uid='".DB::result_first("SELECT hyid FROM ".DB::table('brand_hy')." WHERE hykh='".$row['ID']."'")."'")
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
