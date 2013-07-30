<?php

define('CHARSET', 'GBK'); //�����������ݱ���
require './source/class/class_xml.php'; //XML��ʽ���ĵ���array���໥ת������
error_reporting(7);

$charset = $_GET['charset'] ? $_GET['charset'] : $_POST['charset']; //�ͻ������ݱ���
//����ת��
if(strtoupper($charset) != CHARSET) {
	foreach($POST as $key => $value) {
		$POST[$key] = iconv($charset, CHARSET, $value);
	}
	foreach($GET as $key => $value) {
		$GET[$key] = iconv($charset, CHARSET, $value);
	}
}

$data = array('html'=>'', 'data'=>''); //��ʼ��Ҫ��������
$sign = $_GET['sign'] ? $_GET['sign'] : $_POST['sign']; //��ȡ�ͻ����������ݵ�ǩ��
$clientid = $_GET['clientid'] ? $_GET['clientid'] : $_POST['clientid']; //�ͻ���ID

$client = get_client_by_clientid($clientid); //�õ��ͻ��˵������Ϣ
if(empty($client)) { //�ͻ��˲�����
	exit('CLIENT_NOT_EXISTS'); //ֱ�ӷ���ʧ��
}

$datasign = ''; //����ǩ��
if(!empty($_POST)) {
	unset($_POST['sign']); //ɾ��ǩ���������˲������μ�ǩ������
	$datasign = get_sign($_POST, $client['key']); //�������ݵ�ǩ��
} else {
	unset($_GET['sign']); //ɾ��ǩ���������˲������μ�ǩ������
	$datasign = get_sign($_GET, $client['key']); //�������ݵ�ǩ��
}

if($datasign != $sign) { //ǩ������ȷ
	exit('SIGN_ERROR'); //����ǩ������
}

if($_POST['op'] == 'getdata') { //�ж��Ƿ�Ϊ���������б�
	$datalist = $data = array();//�����б�
	$wherearr = array(); //SQL ��������

	//��ȡ�ͻ���POST����
	$start = intval($_POST['start']); //��ʼ��������
	$limit = intval($_POST['items']); //Ҫ��ʾ��������
	$bannedids = addslashes($_POST['bannedids']); //�ͻ������ε�IDS
	$param1 = addslashes($_POST['param1']); //���ݵ��ò���1,�����ֵҪ��Ϊstring��
	$param2 = intval($_POST['param2']); //���ݵ��ò���2,�����ֵҪ��Ϊint��

	//�������1
	if(!empty($param1)){
		$wherearr[] = "fieldsparam1='$param1'";
	}
	//�������2
	if(!empty($param2)) {
		$wherearr[] = "fieldsparam2='$param2'";
	}
	//����ͻ������ε�IDS
	if(!empty($bannedids)) {
		$banids = explode(',', $bannedids);
		$wherearr[] = "csid NOT IN (".implode("','", $banids)."')";
	}
	$where = !empty($wherearr) ? 'WHERE '.implode(' AND ', $wherearr) : ''; //��������
	/*���ݿ���ش���
	$query = DB::query('SELECT * FROM '.DB::table('tablename')." $where LIMIT $start, $limit"); //SQL��ѯ
	while($value = DB::fetch($query)) {
		//�˴�Ϊ���ݴ����߼�����
		$data[] = $value;
	}
	 */

	//����Ϊ��ʱ�������ݣ���ʽ����������Լ���ҵ������ص���
	$url = 'http://www.wxq123.com/';
	$data = range($start, $start + $limit);//������ʱ�ļ�����
	foreach($data as $value) {
		//��Ҫע�⣺ �� id�� title�� url�� pic�� picflag�� summary �����ֶ��⣬�����ֶ���Ҫ�ŵ� fields �����
		$datalist[] = array(
			'id' => $value,
			'title' => 'xml_block_title'.$value, //����
			'url' => $url.'xml_server.php?csid='.$value, //���ӵ�ַ
			'pic' => $url.'/data/attachment/photo.gif', //ͼƬ��ַ
			'picflag' => '0', //0Ϊurl 1Ϊ���� 2 ΪftpԶ�̣����ͼƬ��DXϵͳ�е�ͼƬ�����������Ϊ1��2���������Ϊ0
			'summary' => '', //���
			'fields' => array( //���ù淶��fields��ָ�����ֶ�
				'author' => 'xml_user'.$value,
				'authorid' => $value,
				'field1' => 'field1value'.$value,
				'field2' => 'field2value'.$value
			)
		);
	}
	$data['data'] = $datalist;

	//���Ҫ����HTML���룬��ֱ��ʹ�����´���
	//$data['html'] = 'HTML CODE';
	$xml = array2xml($data); //ת��ΪXML�ĵ�
} else if($_GET['op'] == 'getconfig') {
	$xml = file_get_contents('source/plugin/wxq123/block_xml_sample.xml');//block_xml_sample.xml�ļ��е�����Ϊ ���ù淶XML�ĵ�ʾ�� ������
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
 * ��ÿͻ�����Ϣ
 * @param  $clientid
 * @return array �ͻ�����Ϣ����
 */
function get_client_by_clientid($clientid){
	$client = array();
	$clientid = intval($clientid);
	if($clientid) {

		/*���ݿ���ش���
		$client = DB::fetch_first('SELECT * FROM '.DB::table('clienttable')." clientid='$clientid'"); //SQL��ѯ
		 */

		//����Ϊ��ʱ�������ݣ���ʽ����������Լ���ҵ������ص���
		//ģ�����ݿ�
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
 * ����ǩ��
 * @param array $para ��������
 * @param string $key ������Կ
 * @return string ǩ��
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
