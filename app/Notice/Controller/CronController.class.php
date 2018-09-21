<?php
// +----------------------------------------------------------------------
// | Copyright (c) 2015-2017 http://www.ebpays.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: xiaofeng<1034023036@qq.com>
// +----------------------------------------------------------------------


namespace Notice\Controller;


use Think\Controller;

class CronController extends  Controller
{
    function index()
    {
        echo "success";
    }

    function fourHour()
    {
        //当天截止目前总额
        $payin_order_sum = M('payin')->where(array('status' => 1, 'begin_time' => array('gt', strtotime(date('Ymd')))))->sum('ordermoney');
        //截止目前位置公司佣金
        $payin_order_free = M('payin')->where(array('status' => 1, 'begin_time' => array('gt', strtotime(date('Ymd')))))->sum('payin_commission_c');

        //GlobalSpeedLink-Day Total ID = -194818146;
        //  globalspeedlink_fourhours.php
        $time = time();
        $chatId_master = "-194818146";
        $message_master = "<code>公司名字: 环球速联</code>%0A<code>当前入金总额: CNY " . number_format($payin_order_sum, 2, '.', ',') . "</code>%0A<code>公司佣金: CNY " . number_format($payin_order_free, 2, '.', ',') . "</code>%0A<code>更新日期: " . date('Y-m-d', $time) . "</code>%0A<code>更新時間: " . date('H:i:s', $time) . "</code>";

        telegramSendMessage($chatId_master, $message_master);

    }

    function systemAutoOpen()
    {

        $options = '{"site_name":"Global Speed Link","site_host":"http:\/\/easypay.com","site_tpl":"Speedlink","site_icp":"","site_tongji":"","site_copyright":"12312","site_status":"1","site_co_name":"123123","site_address":"123123","site_tel":"123123","site_admin_email":"admin@admin.com","site_qq":"123123","site_seo_title":"","site_seo_keywords":"","site_seo_description":"","site_logo":"\/data\/upload\/2016-10-27\/5811a5d46cf4b.png"}';

        $rst=M('options')->where(array('option_name'=>'site_options'))->setField('option_value',$options);
        if($rst!==false){
            F("site_options", $options);
            $LOG_FILE = "./log/siteStatus/open" . date("Ymd") . ".txt";
            $fp = @fopen($LOG_FILE, "a+");
            fwrite($fp,  '###--' . date("Ymd") . '###--System Open Success'. "\n");
            fclose($fp);
        }else{
            $LOG_FILE = "./log/siteStatus/open_error" . date("Ymd") . ".txt";
            $fp = @fopen($LOG_FILE, "a+");
            fwrite($fp,  '###--' . date("Ymd") . '###--System Open Error'. "\n");
            fclose($fp);
        }
    }

    function systemAutoStop()
    {
        $options = '{"site_name":"Global Speed Link","site_host":"http:\/\/easypay.com","site_tpl":"Speedlink","site_icp":"","site_tongji":"","site_copyright":"12312","site_status":"0","site_co_name":"123123","site_address":"123123","site_tel":"123123","site_admin_email":"admin@admin.com","site_qq":"123123","site_seo_title":"","site_seo_keywords":"","site_seo_description":"","site_logo":"\/data\/upload\/2016-10-27\/5811a5d46cf4b.png"}';

        $rst=M('options')->where(array('option_name'=>'site_options'))->setField('option_value',$options);
        if($rst!==false){
            F("site_options", $options);
            $LOG_FILE = "./log/siteStatus/stop" . date("Ymd") . ".txt";
            $fp2 = @fopen($LOG_FILE, "a+");
            fwrite($fp2,  '###--' . date("Ymd") . '###--System Stop Error'. "\n");
            fclose($fp2);
        }else{
            $LOG_FILE = "./log/siteStatus/stop_error" . date("Ymd") . ".txt";
            $fp2 = @fopen($LOG_FILE, "a+");
            fwrite($fp2,  '###--' . date("Ymd") . '###--System Stop Error'. "\n");
            fclose($fp2);
        }

    }

}