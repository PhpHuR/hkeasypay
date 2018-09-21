<?php
/**
 * Created by PhpStorm.
 * User: yiqnuan.ma <yinquan.ma@yeepay.com>
 * Date: 2017/9/24
 * Time: 下午7:00
 */

namespace YeepayCbp\responseHandle\onlinepayHandle;


use YeepayCbp\responseHandle\ResponseTypeHandle;

class QueryHandle extends ResponseTypeHandle
{
    public function __construct()
    {
        $fields =[
            'merchantId',
            'requestId',
            'serialNumber',
            'totalRefundCount',
            'totalRefundAmount',
            'orderCurrency',
            'orderAmount',
            'status',
            'completeDateTime',
            'remark',
        ];
        $this->setHmacFields($fields);
    }
} 