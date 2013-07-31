<?php

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$echoStr = $_GET["echostr"];
$signature = $_GET["signature"];
$timestamp = $_GET["timestamp"];
$nonce = $_GET["nonce"];	
	
$token = DB::result_first("SELECT value FROM ".DB::table('brand_settings')." WHERE variable = 'weixin_token'");

$tmpArr = array($token, $timestamp, $nonce);
sort($tmpArr);
$tmpStr = implode( $tmpArr );
$tmpStr = sha1( $tmpStr );

if( $tmpStr == $signature ){
	echo $echoStr;
	exit;
}else{
	echo '';
}

$postStr = $GLOBALS["HTTP_RAW_POST_DATA"];
//$postStr = $_POST;
//var_dump($postStr);
if (!empty($postStr)){
		$postObj = simplexml_load_string($postStr, 'SimpleXMLElement', LIBXML_NOCDATA);
		$inputtype = $postObj->MsgType;
		if($inputtype == 'text'){
			$content = trim($postObj->Content);
			$keyword = $content?true:false;
		}elseif($inputtype == 'location'){
			$location_x = trim($postObj->Location_X);
			$location_y = trim($postObj->Location_Y);
			$scale = trim($postObj->Scale);
			$label = trim($postObj->Label);
			$keyword = ($location_x&&$location_y&&$scale&&$label)?true:false;
		}elseif($inputtype == 'image'){
			$picurl = trim($postObj->PicUrl);
			$keyword = $picurl?true:false;
		}
		$fromUsername = $postObj->FromUserName;
		$toUsername = $postObj->ToUserName;
		$time = time();
		$textTpl = "<xml>
					<ToUserName><![CDATA[%s]]></ToUserName>
					<FromUserName><![CDATA[%s]]></FromUserName>
					<CreateTime>%s</CreateTime>
					<MsgType><![CDATA[%s]]></MsgType>
					<Content><![CDATA[%s]]></Content>
					<FuncFlag>0</FuncFlag>
					</xml>";             
		if(!empty( $keyword )){
			if($inputtype == 'text'){
				$contentStr = '欢迎加入！';
				$weixin_jiqiren = DB::result_first("SELECT value FROM ".DB::table('brand_settings')." WHERE variable = 'weixin_jiqiren'");
				$weixin_jiqiren_array = explode("\n",$weixin_jiqiren);
				foreach ( $weixin_jiqiren_array as $value){
					$weixin_jiqiren_array1 = explode("=",$value);
					if($content == $weixin_jiqiren_array1[0]){
						$contentStr = $weixin_jiqiren_array1[1];
					}
				}
			}elseif($inputtype == 'location'){
				$contentStr = '你现在的位置在'.$label."，坐标为".$location_x.'，'.$location_y;
			}elseif($inputtype == 'image'){
			}
			$msgType = "text";
			$resultStr = sprintf($textTpl, $fromUsername, $toUsername, $time, $msgType, $contentStr);
			echo $resultStr;
		}else{
			echo "系统错误";
		}

}else {
	echo "hg";
	exit;
}
 ?>