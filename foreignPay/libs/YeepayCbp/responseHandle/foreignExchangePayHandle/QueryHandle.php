<?php
/**
 * Created by PhpStorm.
 * User: yiqnuan.ma <yinquan.ma@yeepay.com>
 * Date: 2017/9/14
 * Time: 下午2:22
 */

namespace YeepayCbp\responseHandle\foreignExchangePayHandle;


use YeepayCbp\responseHandle\ResponseTypeHandle;

class QueryHandle extends ResponseTypeHandle
{
    public function __construct()
    {
        $fields = [
            'merchantId',
            'requestId',
            'serialNumber',
            'totalRefundCount',
            'totalRefundAmount',
            'orderCurrency',
            'orderAmount',
            'remark',
            'payment' => [
                'amount',
                'currency',
                'status',
                'completeDateTime',
                'bindCardId',
            ],
            'foreignExchange' => [
                'amount',
                'currency',
                'status',
                'listprice',
                'deductionAmount',
                'completeDateTime',
            ],
        ];
        $this->setHmacFields($fields);
    }
}