<?php


//// 1. 初始化
//$ch = curl_init();
//// 2. 设置选项，包括URL
//curl_setopt($ch, CURLOPT_URL, "http://www.17xue8.cn");
//curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//curl_setopt($ch, CURLOPT_HEADER, 0);
//// 3. 执行并获取HTML文档内容
//$output = curl_exec($ch);
//if ($output === FALSE) {
//    echo "cURL Error: " . curl_error($ch);
//}
//$info = curl_getinfo($ch);

//// 测试用的URL
//$urls = array(
//"http://www.cnn.com",
//"http://www.mozilla.com",
//"http://www.facebook.com"
//);
//// 测试用的浏览器信息
//$browsers = array(
//"standard" => array (
//"user_agent" => "Mozilla/5.0 (Windows; U; Windows NT 6.1; en-US; rv:1.9.1.6) Gecko/20091201 Firefox/3.5.6 (.NET CLR 3.5.30729)",
//"language" => "en-us,en;q=0.5"
//),
//"iphone" => array (
//"user_agent" => "Mozilla/5.0 (iPhone; U; CPU like Mac OS X; en) AppleWebKit/420+ (KHTML, like Gecko) Version/3.0 Mobile/1A537a Safari/419.3",
//"language" => "en"
//),
//"french" => array (
//"user_agent" => "Mozilla/4.0 (compatible; MSIE 7.0; Windows NT 5.1; GTB6; .NET CLR 2.0.50727)",
//"language" => "fr,fr-FR;q=0.5"
//)
//);
//foreach ($urls as $url) {
//echo "URL: $url\n";
//foreach ($browsers as $test_name => $browser) {
//$ch = curl_init();
//// 设置 url
//curl_setopt($ch, CURLOPT_URL, $url);
//// 设置浏览器的特定header
//curl_setopt($ch, CURLOPT_HTTPHEADER, array(
//"User-Agent: {$browser['user_agent']}",
//"Accept-Language: {$browser['language']}"
//));
//// 页面内容我们并不需要
//curl_setopt($ch, CURLOPT_NOBODY, 1);
//// 只需返回HTTP header
//curl_setopt($ch, CURLOPT_HEADER, 1);
//// 返回结果，而不是输出它
//curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
////$output = curl_exec($ch);
//curl_close($ch);
//// 有重定向的HTTP头信息吗?
//if (preg_match("!Location: (.*)!", $output, $matches)) {
////echo "$test_name: redirects to $matches[1]\n";
//} else {
////echo "$test_name: no redirection\n";
//}
//}
////echo "\n\n";
//}

//$url = "http://www.wxq123.com/admin1.php?action=plugins&identifier=wxq123&pmod=mokuai11";
//$post_data = array (
//"foo" => "bar",
//"query" => "Nettuts",
//"action" => "Submit"
//);
//$ch = curl_init();
//curl_setopt($ch, CURLOPT_URL, $url);
//curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
//// 我们在POST数据哦！
//curl_setopt($ch, CURLOPT_POST, 1);
//// 把post的变量加上
//curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
//$output = curl_exec($ch);
//curl_close($ch);
//echo $output;

//echo '获取'. $info['url'] . '耗时'. $info['total_time'] . '秒';
// 4. 释放curl句柄
//curl_close($ch);


$cookie_jar = tempnam('data','cookie');
var_dump($cookie_jar);
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL,'member.php?mod=logging&action=login&loginsubmit=yes&infloat=yes&lssubmit=yes');
curl_setopt($ch, CURLOPT_POST, 1);
$request = 'username=wxq123&password=yxp19980119';
curl_setopt($ch, CURLOPT_POSTFIELDS, $request);//传递数据
curl_setopt($ch, CURLOPT_COOKIEJAR, $cookie_jar);//把返回来的cookie信息保存在$cookie_jar文件中
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//设定返回的数据是否自动显示
curl_setopt($ch, CURLOPT_HEADER, false);//设定是否显示头信息
curl_setopt($ch, CURLOPT_NOBODY, false);//设定是否输出页面内容
curl_exec($ch);
curl_close($ch); //get data after login
var_dump(file_get_contents($cookie_jar));
//
$ch2 = curl_init();
curl_setopt($ch2, CURLOPT_URL, "http://www.wxq123.com/forum.php?mod=post&action=newthread&fid=36");
curl_setopt($ch2, CURLOPT_HEADER, false);
curl_setopt($ch2, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch2, CURLOPT_COOKIEFILE, $cookie_jar);
$orders = curl_exec($ch2);

echo $orders;
curl_close($ch2);// 实践证明很稳定:)


?>