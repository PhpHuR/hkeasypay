<?php
/**
 * Created by PhpStorm.
 * User: yp-tc-7044
 * Date: 2017/10/18
 * Time: 下午5:05
 */

namespace YeepayCbp\responseHandle\foreignExchangePayHandle;


use YeepayCbp\responseHandle\ResponseTypeHandle;

class ForeignExchangeResponse extends ResponseTypeHandle
{
    public function __construct()
    {
        $fields = [
            'merchantId',
            'requestId',
            'serialNumber',
            'totalRefundCount',
            'totalRefundCount',
            'totalRefundAmount',
            'orderCurrency',
            'orderAmount',
            'remark',
            'foreignExchange' => [
                'amount',
                'currency',
                'status',
                'listprice',
                'deductionAmount',
                'completeDateTime',
            ],
            'suborders' => [
                'orderAmount',
                'requestId',
                'serialNumber',
            ],
        ];
        $this->setHmacFields($fields);
    }
}