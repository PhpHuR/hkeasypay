<?php
//使用POST方法將傳送參數到server
//需POST的參數有 company_code, timestamp, sign
//製作sign的方法如下
//將company_code, timestamp, api_key 依序使用&符號串聯起來後再使用SHA256演算法製作hash, hash值即是sign
//POST 網址
$api_key = 'wuFSHvowLvNAJUHu'; //your key
$post['company_code'] = '8813'; // your company_code
$post['timestamp'] = time();
$param = $post['company_code'];
$param .= '&'.$post['timestamp'];
$param .= '&'.$api_key;
$post['sign'] = hash('SHA256', $param);
?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body onload="document.form1.submit()">
<h1>付款页</h1>
<form id="form1" name="form1" method="post" action="http://www.paypaypro.com/pay/paymentpage">
    <input name="company_code" type="hidden" value="<?php echo $post['company_code'] ;?>">
    <input name="timestamp" type="hidden" value="<?php echo $post['timestamp'] ;?>">
    <input name="sign" type="hidden" value="<?php echo $post['sign'] ;?>">
    <input type="submit" value="进入收银台">
</form>
</body>
</html>