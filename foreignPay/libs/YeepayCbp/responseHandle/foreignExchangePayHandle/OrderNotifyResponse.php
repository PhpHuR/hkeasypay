<?php
/**
 * Created by PhpStorm.
 * User: yp-tc-7044
 * Date: 2017/10/18
 * Time: 下午4:56
 */

namespace YeepayCbp\responseHandle\foreignExchangePayHandle;


use YeepayCbp\responseHandle\ResponseTypeHandle;

class OrderNotifyResponse extends ResponseTypeHandle
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
            'payment' => [
                'amount',
                'currency',
                'status',
                'completeDateTime',
                'bindCardId',
            ],
            'subOrder'=>[
                'orderAmount',
                'requestId',
                'serialNumber',
            ],
        ];
        $this->setHmacFields($fields);
    }

}