<?php
/**
 * Created by PhpStorm.
 * User: yp-tc-7044
 * Date: 2017/10/1
 * Time: 下午3:20
 */

namespace YeepayCbp\responseHandle\transferDomesticHandleV2;


use YeepayCbp\responseHandle\ResponseTypeHandle;

class QueryHandle extends ResponseTypeHandle
{
    public function __construct()
    {
        $fields = [
            'merchantId',
            'requestId',
            'remitRequestId',
            'serialNumber',
            'amount',
            'currency',
            'status',
            'completeDateTime',
            'remark',
        ];
        $this->setHmacFields($fields);
    }
}