<?php
/**
 * Created by PhpStorm.
 * User: yp-tc-7044
 * Date: 2017/9/26
 * Time: 上午9:32
 */

namespace YeepayCbp\responseHandle\customsHandle;


use YeepayCbp\responseHandle\ResponseTypeHandle;

class QueryHandle extends ResponseTypeHandle
{

    public function __construct()
    {
        $fields = [
            'merchantId',
            'paySerialNumber',
            'customsInfos' => [
                'customsChannel',
                'amount',
                'freight',
                'goodsAmount',
                'tax',
                'status',
            ],
        ];
        $this->setHmacFields($fields);
    }
}