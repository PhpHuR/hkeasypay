<?php
header("content-type:text/html;charset=utf-8");
require_once ("../../lib/YopClient.php");
require_once ("../../lib/YopClient3.php");
require_once ("../../lib/Util/YopSignUtils.php");


/** 
 *  使用url_encode()对字符串进行编码
 *  @param string/array $str 需要编码的数据
 *  @return string/array $str 返回编码后的字符串
 */  
function url_encode($str) {  
    if(is_array($str)) {  
        foreach($str as $key=>$value) {  
            $str[urlencode($key)] = url_encode($value);  
        }  
    } else {  
        $str = urlencode($str);  
    }  

    return $str;  
}  

/**
* 输出json数据，不解析中文
* @param string/array $str 需要进行json编码的数据
* @return string  输出json数据
*/
function encode_json($str) {  
    $result = urldecode(json_encode(url_encode($str)));  
    return $result; 
}  

//Post请求 非对称秘钥
function order(){

	$config = include('../config.php');
    /*商户私钥*/
    $private_key =$config["private_key"];
    /*YOP公钥*/
    $yop_public_key = $config["yop_public_key"];

	$request = new YopRequest($config["app_key"], $private_key,  $config["yop_center"],$yop_public_key);
	
	
	$pd=encode_json($_POST["details"]);
	$suborder=encode_json($_POST["hiddenSubOrder"]);

    //加入请求参数
	$jsonRequest="{\"requestId\":\"".$_POST["requestId"]."\",
	\"orderAmount\":\"".$_POST["orderAmount"]."\",
	\"orderCurrency\":\"".$_POST["orderCurrency"]."\",
	\"amount\":\"".$_POST["amount"]."\",
	\"currency\":\"".$_POST["currency"]."\",
	\"forUse\":\"".$_POST["forUse"]."\",
	\"listPriceToken\":\"".$_POST["listPriceToken"]."\",
	\"notifyUrl\":\"".$_POST["notifyUrl"]."\",
	\"callbackUrl\":\"".$_POST["callbackUrl"]."\",
	\"remark\":\"".$_POST["remark"]."\",
	\"paymentModeCode\":\"".$_POST["paymentModeCode"]."\",
	\"openeId\":\"".$_POST["openeId"]."\",
	\"cashierVersion\":\"".$_POST["cashierVersion"]."\",
	\"merchantUserId\":\"".$_POST["merchantUserId"]."\",
	\"bindCardId\":\"".$_POST["bindCardId"]."\",
	\"clientIp\":\"".$_POST["clientIp"]."\",
	\"timeout\":\"".$_POST["timeout"]."\",
	 \"payer\": {
        \"name\": \"".$_POST["payerName"]."\",
        \"idType\": \"".$_POST["payerIdType"]."\",
        \"idNum\": \"".$_POST["payerIdNum"]."\",
        \"bankCardNum\": \"".$_POST["bankCardNum"]."\",
        \"phoneNum\": \"".$_POST["phoneNum"]."\",
        \"email\": \"".$_POST["email"]."\",
        \"nationality\": \"".$_POST["nationality"]."\"
    },
	 \"bankCard\": {
        \"name\": \"".$_POST["name"]."\",
        \"cardNo\": \"".$_POST["cardNo"]."\",
        \"cvv2\": \"".$_POST["cvv2"]."\",
        \"idNo\": \"".$_POST["idNo"]."\",
        \"expiryDate\": \"".$_POST["expiryDate"]."\",
        \"mobileNo\": \"".$_POST["mobileNo"]."\"
    },
	\"productDetails\": ". trim($pd,'"');
	if (!empty($_POST["hiddenSubOrder"]))$jsonRequest=$jsonRequest.", \"subOrders\":".trim($suborder,'"');
	
	$jsonRequest=$jsonRequest."}";

	$request->setJsonParam($jsonRequest);
    //提交Post请求
    $response = YopClient3::post("/rest/v1.0/kj/fe/order", $request);
    if($response->validSign==1){
        echo "返回结果签名验证成功!\n";
    }
    //取得返回结果
    print_r($response);
// 判断status 如果是REDIRECT 则跳转到收银台
	 $json_array =$response->stringResult;
    if(json_decode($json_array,true)["status"]=='REDIRECT'){
		
		$url=json_decode($json_array,true)["redirectUrl"];
		header("Location: $url");
   }
}
order();



