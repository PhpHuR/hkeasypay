<?php
/**
 * Created by PhpStorm.
 * User: yiqnuan.ma <yinquan.ma@yeepay.com>
 * Date: 2017/9/24
 * Time: 下午7:00
 */

namespace YeepayCbp\responseHandle\onlinepayHandle;


use YeepayCbp\responseHandle\ResponseTypeHandle;

class OrderHandle extends ResponseTypeHandle
{
    public function __construct()
    {
        $fields =[
            'merchantId',
            'requestId',
            'status',
            'redirectUrl',
        ];
        $this->setHmacFields($fields);
    }

} 