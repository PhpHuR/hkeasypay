<?php
// +----------------------------------------------------------------------
// | Copyright (c) 2015-2017 http://www.ebpays.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: xiaofeng<1034023036@qq.com>
// +----------------------------------------------------------------------
namespace Test\Controller;

use Think\Controller;

class TestController extends Controller
{
    function index()
    {
        echo "success";
    }
    function test()
    {
        $user['member_name'] = 1;
        $user_id = 8813;

        $bankName = '名称';
        $transfermoney = 234;
        $userChatId = getChatId($user_id,1);

        if ($userChatId) {
            $message_master = "%0A<code>銀行:" . $bankName . "</code>%0A<code>收款人: " .$bankName. "</code>%0A<code>銀行賬號: " . $bankName . "</code>%0A<code>金額: CNY " . number_format($transfermoney, 2, '.', ',') . "</code>%0A%0A<code>出金客戶: " . $bankName . "</code>%0A<code>更新日期: " . date('Y-m-d') . "</code>%0A<code>更新時間: " . date('H:i:s') . "</code>%0A<code>單號: " . $bankName . "</code>";

            $abc = "test";


            $res = telegramSendMessage($userChatId, $message_master);

            dump($res);
            die();

            $fp = @fopen("apayout.txt", "a+");
            fwrite($fp, $res . "###" . $user_id);
            fclose($fp);
        }
    }

}