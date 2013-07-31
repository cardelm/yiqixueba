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
		$errmsg =  '密码错误或商家用户有误！';
	}elseif(DB::result_first("SELECT count(*) FROM ".DB::table('yikatong_shangjia')." WHERE uid='".$ucresult[0]."'")==1){
		$num=4;//验证码个数
		$width=100;//验证码宽度
		$height=40;//验证码高度
		$code=' ';
		for($i=0;$i<$num;$i++){//生成验证码
			//switch(rand(0,2)){
				//case 0:$code[$i]=chr(rand(48,57));break;//数字
				//case 1:$code[$i]=chr(rand(65,90));break;//大写字母
				//case 2:$code[$i]=chr(rand(97,122));break;//小写字母
			//}
			$code[$i]=chr(rand(48,57));//数字
		}
		//$_SESSION["VerifyCode"]=$code;
		$image=imagecreate($width,$height);
		imagecolorallocate($image,255,255,255);
		//for($i=0;$i<80;$i++){//生成干扰像素
			//$dis_color=imagecolorallocate($image,rand(0,2555),rand(0,255),rand(0,255));
			//imagesetpixel($image,rand(1,$width),rand(1,$height),$dis_color);
		//}
		for($i=0;$i<$num;$i++){//打印字符到图像
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
		imagepng($image);//输出图像到浏览器
		imagedestroy($image);//释放资源
	}else{
		$errmsg =  '商家用户有误！';
	}
	echo $errmsg;

//http://www.17xue8.cn:88/debug/yanzhen.php?shangjianame=王琦&sjpass=wangqi&yzclass=1
// 转账：1；积分：2；春积分：3
?>