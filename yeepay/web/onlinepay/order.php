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


	//$config = include('../config.php');
    /*商户私钥*/
    //$private_key ='MIIEowIBAAKCAQEAgrIZAdjGLkWRnnhgHiMlCCvmHP49G7itGUbig4QRs74qrCZfzR5B5mUE+fA7COO7rpTL0zB/LvPnCwRsJ7Q48luVkCnintjcNcuSlIga12m1uxQMscAnVVz9KB66W6ACYfQ7PCL4kyo+z0Opdcs+SUqwqiocj5zMhJO0nkyddzAx1dbL5EHAjcC+cQ7J2aR5SgY+j+diGLW4txrqzx7/7sL5fDQVRmi4oSNKripDuPwC13V9FoN12rQA6ELwXklJ9dCZyZvh/PDy3AM0KQ1Nck1PCdBRmNenHApvAsY77XpI4AqALk0yGWPDgKID+U0DobNjIU1n2wPEG/cWxhDsfwIDAQABAoIBAE8KChmV0XSWWhRuVCKlunWQpt+N2cL0EqsgtUg4DMSZExF9O56+17fQDAxjfjBIGW7hScr0n1Xz5xxAlnAEjBP10yOWURkjqTlXXdQ545G2ulLjMzIkNSVo0Sj8PFPBFu/KVjBuLcpCWC3ci5VTTt3gL6sZQKCRgRYEhczeJLS5MMHZN6NAsuO7CrisBE+Rv2hnzQ8gdk8YXzP1oaKah3lDm8lPnG7D+KcYCCNmHd1TlJfSv9DnoEVIZIDi4251stRjbAirSbCJEd4nyoIlxT19F0qgNPlFWOc6Z51OtTjNM4dS5uaNAyOgeRzpdgHCeBOq9rO99+JEJY7M41y60VECgYEAxwvuOsmxuR00hBuUHl20+/FiWvIxEo0Glq98WjMh2ZrFnwYvZMs3AOxhr6ZHRzAx4vp4oqv/i93U6Lhb65/2diz5fbqFf1RjYiIPuBwXML+qlSUBTaDZqtJREosXcHuEhjVhhWKTKmvipD91bNGdwMQwXY5zHwvSXb0PhgAP1/UCgYEAqBd+zw5xc2TvS20xNesSBs7O3xa1BcXMd957get5NzNZ7muO96vG5pefDeqCT7fd96PKR9/NoW7sBug/w7ep0rLnTmna6Fzpecnk9dFoGzQ96E+KxW9hTKyavVfMcEWLY8q/APYZVF513ZUZm5CuQS9eI06JcdlVZCE3nlpbDiMCgYAUYqxraOzCwLL4NLrewUof44DnP5a3B6p9FEvwEPyOhMNongGMmSNw/MSkcKssJ0t0q6JfRq5NbNK5YuhHIYLkZ4bF0ayKdeIX0tU5TecyHu8hh0Cy6p5gWFnlREmKQ5w3ApCSUJ4x4gq8N6OXGYDGlVE+w7AWpedNomdMmgUFYQKBgQChtzEF7YRSm3npHB0rHYQTTqYSVRtFeX30mPREExJkfB/6VDqQpw/Ny3N3hPVn0qJXXJoAuh1wQXIMVyb5mdplXj9Q3mCACtuIkyeXI6c//OvOc7AzsKtwg+K/ZRfHr/Chym4mc5384IAO9SJU20X6aqLr3uQ2xvvzQE3tKErP9wKBgB86JesYj7BIqPz+xk2P5ksQcw7I77E9JzNhmusFSF3IsliA6aJZuTDWvOCcZAMRsRGE8gh3l9MgdJ+TwGACzsWPBCPzIO2WMG21wRsD7RKcqDAw1kHoNSa1aUsvCjNPbuIR8olozbF1p1ZKRyUdxgS2m2+OTvFX+L1qHiJnzdcC';
    /*YOP公钥*/
   // $yop_public_key ='MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEA4g7dPL+CBeuzFmARI2GFjZpKODUROaMG+E6wdNfv5lhPqC3jjTIeljWU8AiruZLGRhl92QWcTjb3XonjaV6k9rf9adQtyv2FLS7bl2Vz2WgjJ0FJ5/qMaoXaT+oAgWFk2GypyvoIZsscsGpUStm6BxpWZpbPrGJR0N95un/130cQI9VCmfvgkkCaXt7TU1BbiYzkc8MDpLScGm/GUCB2wB5PclvOxvf5BR/zNVYywTEFmw2Jo0hIPPSWB5Yyf2mx950Fx8da56co/FxLdMwkDOO51Qg3fbaExQDVzTm8Odi++wVJEP1y34tlmpwFUVbAKIEbyyELmi/2S6GG0j9vNwIDAQAB';

	//$request = new YopRequest('cbp_120180473', $private_key,'http://open.yeepay.com:18064/yop-center',$yop_public_key);
	
	
	$pd=encode_json($_POST["details"]);
	$suborder=encode_json($_POST["hiddenSubOrder"]);

    //加入请求参数
  //加入请求参数
	$jsonRequest="{\"requestId\":\"".$_POST["requestId"]."\",
	\"orderAmount\":\"".$_POST["orderAmount"]."\",
	\"orderCurrency\":\"".$_POST["orderCurrency"]."\",
	\"notifyUrl\":\"".$_POST["notifyUrl"]."\",
	\"callbackUrl\":\"".$_POST["callbackUrl"]."\",
	\"remark\":\"".$_POST["remark"]."\",
	\"paymentModeCode\":\"".$_POST["paymentModeCode"]."\",
	\"authCode\":\"".$_POST["authCode"]."\",
	\"cashierVersion\":\"".$_POST["cashierVersion"]."\",
	\"forUse\":\"".$_POST["forUse"]."\",
	\"merchantUserId\":\"".$_POST["merchantUserId"]."\",
	\"bindCardId\":\"".$_POST["bindCardId"]."\",
	\"clientIp\":\"".$_POST["clientIp"]."\",
	\"openId\":\"".$_POST["openId"]."\",
	\"timeout\":\"".$_POST["timeout"]."\",
	 \"payer\": {
        \"name\": \"".$_POST["payerName"]."\",
        \"idType\": \"".$_POST["payerIdType"]."\",
        \"idNum\": \"".$_POST["payerIdNum"]."\",
        \"bankCardNum\": \"".$_POST["bankCardNum"]."\",
        \"phoneNum\": \"".$_POST["payerPhoneNum"]."\",
        \"email\": \"".$_POST["email"]."\"
    },
	\"receiver\": {
        \"receiver\": \"".$_POST["payerName"]."\",
        \"phoneNum\": \"".$_POST["receiverPhoneNum"]."\",
        \"address\": \"".$_POST["address"]."\"
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
	print_r($jsonRequest);exit();
	
	$request->setJsonParam($jsonRequest);
    //提交Post请求
    $response = YopClient3::post("/rest/v1.0/kj/onlinepay/order", $request);
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



