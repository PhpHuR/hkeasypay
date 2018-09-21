<?php
/**
 * Created by PhpStorm.
 * User: yp-tc-7044
 * Date: 2017/10/18
 * Time: 下午4:28
 */

namespace YeepayCbp\responseHandle\ciqHandle;


use YeepayCbp\responseHandle\ResponseTypeHandle;

class OrderNotifyResponse extends ResponseTypeHandle
{
    public function __construct()
    {
        $fields = [
            'merchantId',
            'paySerialNumber',
            'ciqInfos' => [
                'ciqChannel',
                'ciqCode',
                'amount',
                'status',
            ]
        ];
        $this->setHmacFields($fields);
    }
}