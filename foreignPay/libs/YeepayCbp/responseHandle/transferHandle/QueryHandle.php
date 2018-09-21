<?php
/**
 * Created by PhpStorm.
 * User: yp-tc-7044
 * Date: 2017/10/1
 * Time: 下午1:19
 */

namespace YeepayCbp\responseHandle\transferHandle;


use YeepayCbp\responseHandle\ResponseTypeHandle;

class QueryHandle extends ResponseTypeHandle
{
    public function __construct()
    {
        $fields = [
            'merchantId',
            'requestId',
            'serialNumber',
            'currency',
            'amount',
            'status',
            'completeDataTime',
            'foexignExchangeResponse' => [
                'amount',
                'currency',
                'status',
                'listprice',
                'deductionAmount',
                'completeDataTime',
            ],
        ];
        $this->setHmacFields($fields);
    }
}