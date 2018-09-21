<?php
/**
 * Created by PhpStorm.
 * User: yiqnuan.ma <yinquan.ma@yeepay.com>
 * Date: 2017/9/24
 * Time: 下午7:00
 */

namespace YeepayCbp\responseHandle;


use YeepayCbp\Exception\InvalidResponseException;
use YeepayCbp\responseHandle\onlinepayHandle\OrderCallBackResponse;

class NotifyHandle extends ResponseTypeHandle{

    public function handle($data = array())
    {
        if($data['status']== 'SUCCESS'){
            //成功时相关处理代码
        }elseif($data['status'] == 'FAILED' || $data['status'] == 'CANCEL'){
            //失败时相关处理代码
        }elseif($data['status'] == 'INIT'){
            //待处理状态下相关处理代码
        }else{
            throw new InvalidResponseException(array(
                'error_description'=> 'notify response error',
                'responseData'=>$data
            ));
        }
    }


}