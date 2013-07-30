<?php

define('CHARSET', 'GBK'); //服务器端数据编码
require './source/class/class_xml.php'; //XML格式的文档和array的相互转换的类
error_reporting(7);

$charset = $_GET['charset'] ? $_GET['charset'] : $_POST['charset']; //客户端数据编码
//数据转码
if(strtoupper($charset) != CHARSET) {
	foreach($POST as $key => $value) {
		$POST[$key] = iconv($charset, CHARSET, $value);
	}
	foreach($GET as $key => $value) {
		$GET[$key] = iconv($charset, CHARSET, $value);
	}
}

$data = array('html'=>'', 'data'=>''); //初始化要返回数据
$sign = $_GET['sign'] ? $_GET['sign'] : $_POST['sign']; //获取客户端请求数据的签名
$clientid = $_GET['clientid'] ? $_GET['clientid'] : $_POST['clientid']; //客户端ID

$client = get_client_by_clientid($clientid); //得到客户端的相关信息
if(empty($client)) { //客户端不存在
	exit('CLIENT_NOT_EXISTS'); //直接返回失败
}

$datasign = ''; //数据签名
if(!empty($_POST)) {
	unset($_POST['sign']); //删除签名参数，此参数不参加签名计算
	$datasign = get_sign($_POST, $client['key']); //计算数据的签名
} else {
	unset($_GET['sign']); //删除签名参数，此参数不参加签名计算
	$datasign = get_sign($_GET, $client['key']); //计算数据的签名
}

if($datasign != $sign) { //签名不正确
	exit('SIGN_ERROR'); //输入签名错误
}

if($_POST['op'] == 'getdata') { //判断是否为请求数据列表
	$datalist = $data = array();//数据列表
	$wherearr = array(); //SQL 条件数组

	//获取客户端POST参数
	$start = intval($_POST['start']); //起始数据行数
	$limit = intval($_POST['items']); //要显示多少条数
	$bannedids = addslashes($_POST['bannedids']); //客户端屏蔽的IDS
	$param1 = addslashes($_POST['param1']); //数据调用参数1,假设此值要求为string型
	$param2 = intval($_POST['param2']); //数据调用参数2,假设此值要求为int型

	//处理参数1
	if(!empty($param1)){
		$wherearr[] = "fieldsparam1='$param1'";
	}
	//处理参数2
	if(!empty($param2)) {
		$wherearr[] = "fieldsparam2='$param2'";
	}
	//处理客户端屏蔽的IDS
	if(!empty($bannedids)) {
		$banids = explode(',', $bannedids);
		$wherearr[] = "csid NOT IN (".implode("','", $banids)."')";
	}
	$where = !empty($wherearr) ? 'WHERE '.implode(' AND ', $wherearr) : ''; //构造条件
	/*数据库相关处理
	$query = DB::query('SELECT * FROM '.DB::table('tablename')." $where LIMIT $start, $limit"); //SQL查询
	while($value = DB::fetch($query)) {
		//此处为数据处理逻辑代码
		$data[] = $value;
	}
	 */

	//以下为临时测试数据，正式环境请根据自己的业务做相关调整
	$url = 'http://www.wxq123.com/';
	$data = range($start, $start + $limit);//构造临时的假数据
	foreach($data as $value) {
		//需要注意： 除 id， title， url， pic， picflag， summary 几个字段外，其它字段需要放到 fields 数组里。
		$datalist[] = array(
			'id' => $value,
			'title' => 'xml_block_title'.$value, //标题
			'url' => $url.'xml_server.php?csid='.$value, //链接地址
			'pic' => $url.'/data/attachment/photo.gif', //图片地址
			'picflag' => '0', //0为url 1为本地 2 为ftp远程；如果图片是DX系统中的图片可以情况设置为1或2，其它情况为0
			'summary' => '', //简介
			'fields' => array( //配置规范中fields中指定的字段
				'author' => 'xml_user'.$value,
				'authorid' => $value,
				'field1' => 'field1value'.$value,
				'field2' => 'field2value'.$value
			)
		);
	}
	$data['data'] = $datalist;

	//如果要返回HTML代码，可直接使用以下代码
	//$data['html'] = 'HTML CODE';
	$xml = array2xml($data); //转换为XML文档
} else if($_GET['op'] == 'getconfig') {
	$xml = file_get_contents('source/plugin/wxq123/block_xml_sample.xml');//block_xml_sample.xml文件中的内容为 配置规范XML文档示例 的内容
} else {
	$xml = 'NO_OPERATION';
}
ob_end_clean();
@header("Expires: -1");
@header("Cache-Control: no-store, private, post-check=0, pre-check=0, max-age=0", FALSE);
@header("Pragma: no-cache");
header("Content-type: text/xml");
echo $xml;
exit();

/**
 * 获得客户端信息
 * @param  $clientid
 * @return array 客户端信息数组
 */
function get_client_by_clientid($clientid){
	$client = array();
	$clientid = intval($clientid);
	if($clientid) {

		/*数据库相关处理
		$client = DB::fetch_first('SELECT * FROM '.DB::table('clienttable')." clientid='$clientid'"); //SQL查询
		 */

		//以下为临时测试数据，正式环境请根据自己的业务做相关调整
		//模拟数据库
		$CLIENTSDB = array(
			'100000' => array(
				'clientid' => '100000',
				'key' => '*654%#(asd94',
			),
			'200000' => array(
				'clientid' => '200000',
				'key' => '1#9!(@@34#94',
			),
			'300000' => array(
				'clientid' => '300000',
				'key' => '7$@^8^$7as89',
			),
			'400000' => array(
				'clientid' => '400000',
				'key' => '23@#86^%4&32',
			),
		);
		$client = isset($CLIENTSDB[$clientid]) ? $CLIENTSDB[$clientid] : array();
	}
	return $client;
}


/**
 * 生成签名
 * @param array $para 参数数组
 * @param string $key 加密密钥
 * @return string 签名
 */
function get_sign($para, $key = ''){
	ksort($para);
	$signarr = array();
	foreach($para as $k => $v) {
		$signarr[] = $k.'='.$v;
	}
	$sign = implode('&', $signarr);
	$sign = md5($sign.$key);
	return $sign;
}
?>
