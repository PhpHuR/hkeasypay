<?php
header("content-type:text/html;charset=utf-8");
require_once ("../../lib/YopClient.php");
require_once ("../../lib/YopClient3.php");
require_once ("../../lib/Util/YopSignUtils.php");


 

//Post请求 非对称秘钥
function order(){

	$config = include('../config.php');
    /*商户私钥*/
    $private_key =$config["private_key"];
    /*YOP公钥*/
    $yop_public_key = $config["yop_public_key"];

	$request = new YopRequest($config["app_key"], $private_key,  $config["yop_center"],$yop_public_key);    
  //加入请求参数
	$jsonRequest="{\"requestId\":\"".$_POST["requestId"]."\",
	\"amount\":\"".$_POST["amount"]."\",
	\"notifyUrl\":\"".$_POST["notifyUrl"]."\",
	\"callbackUrl\":\"".$_POST["callbackUrl"]."\",
	\"remark\":\"".$_POST["remark"]."\",
	 \"payee\": {
        \"name\": \"".$_POST["name"]."\",
        \"bankCardNum\": \"".$_POST["bankCardNum"]."\",
        \"bankName\": \"".$_POST["bankName"]."\",
        \"branchBankName\": \"".$_POST["branchBankName"]."\",
        \"province\": \"".$_POST["province"]."\",
		 \"city\": \"".$_POST["city"]."\"
    } }";
	$request->setJsonParam($jsonRequest);
    //提交Post请求
    $response = YopClient3::post("/rest/v1.0/kj/transferdomestic/singleorder", $request);
    if($response->validSign==1){
      //  echo "返回结果签名验证成功!\n";
    }
    //取得返回结果
	print_r($response);

}
order();



