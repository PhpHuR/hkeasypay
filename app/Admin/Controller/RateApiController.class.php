<?php

namespace Admin\Controller;

use Common\Controller\AuthController;

class RateApiController extends AuthController
{
    public function curfloat(){
        ignore_user_abort(true);
        set_time_limit(0);
        while(C('for_state') == 1){
            $this->do_cron();
        }
    }


     private function write_txt(){
//        ignore_user_abort(true);
//        set_time_limit(0);
        $appkey = 'abaee68e17050f301014424debf0b63d';
        $url = "http://web.juhe.cn:8080/finance/exchange/rmbquot?key=".$appkey;
        $res = go_curl($url,'get');
        $arr = json_decode($res,true);

        $data['curbuy']  = $arr['result'][0]['data3']['fBuyPri']/100;
        $data['cursell'] = $arr['result'][0]['data3']['fSellPri']/100;
        $data['update_at'] = time();
        $hosturl = 'http://www.paypaypro.com/Api/RateApi/curbuy';
//    发送数据
         $res = request_post($hosturl, $data);
        unset($data);
        unset($appkey);
        unset($url);
        unset($res);
        unset($arr);

    }
    private function do_cron(){
//        ignore_user_abort(true);
//        set_time_limit(0);
        $this->write_txt();
        sleep(900);
        return true;
    }


}