<?php
header("content-type:text/html;charset=utf-8");
require_once ("../../lib/YopClient.php");
require_once ("../../lib/YopClient3.php");
require_once ("../../lib/Util/YopSignUtils.php");

		//接收数据
        $raw_post_data =$_POST;
		$config = include('../config.php');
     /*商户私钥*/
		$private_key =$config["private_key"];
     /*YOP公钥*/
		$yop_public_key = $config["yop_public_key"];
		$data=YopSignUtils::decrypt($raw_post_data["response"],$private_key,$yop_public_key);
	  //通知的url需要返回success 
		print_r("success"); 
	