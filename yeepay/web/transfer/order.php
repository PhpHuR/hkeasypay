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
	\"currency\":\"".$_POST["currency"]."\",
	\"creditedCurrency\":\"".$_POST["creditedCurrency"]."\",
	\"transferMode\":\"".$_POST["transferMode"]."\",
	\"singleReceiveAccount\":\"".$_POST["singleReceiveAccount"]."\",
	\"isMerger\":\"".$_POST["isMerger"]."\",
	\"detailPath\":\"".$_POST["detailPath"]."\",
	\"contractPath\":\"".$_POST["contractPath"]."\",
	\"listpriceToken\":\"".$_POST["listpriceToken"]."\",
	\"notifyUrl\":\"".$_POST["notifyUrl"]."\",
	\"callbackUrl\":\"".$_POST["callbackUrl"]."\",
	 \"payer\": {
        \"recName\": \"".$_POST["recName"]."\",
        \"accountNumber\": \"".$_POST["accountNumber"]."\",
        \"recAddress\": \"".$_POST["recAddress"]."\",
        \"countryCode\": \"".$_POST["countryCode"]."\",
        \"ibanCode\": \"".$_POST["ibanCode"]."\",
		 \"bankName\": \"".$_POST["bankName"]."\",
        \"swiftCode\": \"".$_POST["swiftCode"]."\",
        \"routingCode\": \"".$_POST["routingCode"]."\",
        \"bsbCode\": \"".$_POST["bsbCode"]."\",
        \"bankAddress\": \"".$_POST["bankAddress"]."\",
		\"postScript\": \"".$_POST["postScript"]."\",
		\"proxyBankAccountNumber\": \"".$_POST["proxyBankAccountNumber"]."\",
		\"proxyBankName\": \"".$_POST["proxyBankName"]."\",
		\"proxySwiftCode\": \"".$_POST["proxySwiftCode"]."\",
		\"proxyBankAddress\": \"".$_POST["proxyBankAddress"]."\"
    } }";
	$request->setJsonParam($jsonRequest);
    //提交Post请求
    $response = YopClient3::post("/rest/v1.0/kj/transfer/order", $request);
    if($response->validSign==1){
      //  echo "返回结果签名验证成功!\n";
    }
    //取得返回结果
	print_r($response);

}
order();



