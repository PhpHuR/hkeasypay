<?php
// +----------------------------------------------------------------------
// | Copyright (c) 2015-2017 http://www.ebpays.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: xiaofeng<1034023036@qq.com>
// +----------------------------------------------------------------------

/**
 * @param $chatId 發送消息ID
 * @param $text   發送消息
 * @return bool
 */

$botToken = "374219950:AAHpS8dKj0fy5U1WfGYB_2LgtsxBzu_UW0k";

$website = "https://api.telegram.org/bot" . $botToken;


$userChatId = '-211333672';

$message_master = "銀行: %0A收款人: Feng Zi Kun %0A 銀行賬號: 210365318668%0A金額: CNY 47990.00%0A%0A出金客戶: 鉑聯商貿有限公司%0A更新日期: 2017-03-17%0A更新時間: 13:19:28%0A單號: o2000920170317131927Huntq";


$res = file_get_contents($website . "/sendmessage?chat_id=" . $userChatId . "&text=" . $message_master);


var_dump($res);

function go_curl($url, $type, $data = false, &$err_msg = null, $timeout = 20, $cert_info = array())
{
    $type = strtoupper($type);
    if ($type == 'GET' && is_array($data)) {
        $data = http_build_query($data);
    }
    $option = array();
    if ($type == 'POST') {
        $option[CURLOPT_POST] = 1;
    }
    if ($data) {
        if ($type == 'POST') {
            $option[CURLOPT_POSTFIELDS] = $data;
        } elseif ($type == 'GET') {
            $url = strpos($url, '?') !== false ? $url . '&' . $data : $url . '?' . $data;
        }
    }
    $option[CURLOPT_URL] = $url;
    $option[CURLOPT_FOLLOWLOCATION] = TRUE;
    $option[CURLOPT_MAXREDIRS] = 4;
    $option[CURLOPT_RETURNTRANSFER] = TRUE;
    $option[CURLOPT_TIMEOUT] = $timeout;
    //设置证书信息
    if (!empty($cert_info) && !empty($cert_info['cert_file'])) {
        $option[CURLOPT_SSLCERT] = $cert_info['cert_file'];
        $option[CURLOPT_SSLCERTPASSWD] = $cert_info['cert_pass'];
        $option[CURLOPT_SSLCERTTYPE] = $cert_info['cert_type'];
    }
    //设置CA
    if (!empty($cert_info['ca_file'])) {
        // 对认证证书来源的检查，0表示阻止对证书的合法性的检查。1需要设置CURLOPT_CAINFO
        $option[CURLOPT_SSL_VERIFYPEER] = 1;
        $option[CURLOPT_CAINFO] = $cert_info['ca_file'];
    } else {
        // 对认证证书来源的检查，0表示阻止对证书的合法性的检查。1需要设置CURLOPT_CAINFO
        $option[CURLOPT_SSL_VERIFYPEER] = 0;
    }
    $ch = curl_init();
    curl_setopt_array($ch, $option);
    $response = curl_exec($ch);
    $curl_no = curl_errno($ch);
    $curl_err = curl_error($ch);
    curl_close($ch);
    // error_log
    if ($curl_no > 0) {
        if ($err_msg !== null) {
            $err_msg = '(' . $curl_no . ')' . $curl_err;
            $fp = @fopen("/data/wwwroot/hkeasypay/log/notifyerror/error.txt", "a+");
            fwrite($fp, json_encode($err_msg) . "\n");
            fclose($fp);
        }
    }
    return $response;
}