<?php
require './source/class/class_core.php';

$discuz = C::app();

$discuz->reject_robot();
$discuz->init();
	//session_start();
	require_once libfile('function/misc');
	require_once libfile('function/member');
	$shangjianame = getgpc('shangjianame');
	$sjpass = getgpc('sjpass');
	loaducenter();
	$ucresult = uc_user_login(addslashes($shangjianame),$sjpass);
	if($ucresult[0]<=0) {
		$errmsg =  '���������̼��û�����';
	}elseif(DB::result_first("SELECT count(*) FROM ".DB::table('yikatong_shangjia')." WHERE uid='".$ucresult[0]."'")==1){
		$num=4;//��֤�����
		$width=100;//��֤����
		$height=40;//��֤��߶�
		$code=' ';
		for($i=0;$i<$num;$i++){//������֤��
			//switch(rand(0,2)){
				//case 0:$code[$i]=chr(rand(48,57));break;//����
				//case 1:$code[$i]=chr(rand(65,90));break;//��д��ĸ
				//case 2:$code[$i]=chr(rand(97,122));break;//Сд��ĸ
			//}
			$code[$i]=chr(rand(48,57));//����
		}
		//$_SESSION["VerifyCode"]=$code;
		$image=imagecreate($width,$height);
		imagecolorallocate($image,255,255,255);
		//for($i=0;$i<80;$i++){//���ɸ�������
			//$dis_color=imagecolorallocate($image,rand(0,2555),rand(0,255),rand(0,255));
			//imagesetpixel($image,rand(1,$width),rand(1,$height),$dis_color);
		//}
		for($i=0;$i<$num;$i++){//��ӡ�ַ���ͼ��
			//$char_color=imagecolorallocate($image,rand(0,2555),rand(0,255),rand(0,255));
			$char_color=imagecolorallocate($image,0,0,0);
			//imagechar($image,60,($width/$num)*$i,rand(0,5),$code[$i],$char_color);
			imagechar($image,100,($width/$num)*$i,0,$code[$i],$char_color);
		}
		$yzdata['yanzhengma'] = $code;
		$yzdata['yzip'] = $_G['clientip'];
		$yzdata['yztime'] = $_G['timestamp'];
		$yzdata['yzclass'] = getgpc('yzclass');
		DB::update('yikatong_shangjia', $yzdata,array('uid'=>$ucresult[0]));
		header("Content-type:image/png");
		imagepng($image);//���ͼ�������
		imagedestroy($image);//�ͷ���Դ
	}else{
		$errmsg =  '�̼��û�����';
	}
	echo $errmsg;

//http://www.17xue8.cn:88/debug/yanzhen.php?shangjianame=����&sjpass=wangqi&yzclass=1
// ת�ˣ�1�����֣�2�������֣�3
?>