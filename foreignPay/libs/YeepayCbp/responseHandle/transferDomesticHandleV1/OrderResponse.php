<?php
/**
 * Created by PhpStorm.
 * User: yp-tc-7044
 * Date: 2017/10/18
 * Time: 下午5:40
 */

namespace YeepayCbp\responseHandle\transferDomesticHandleV1;


use YeepayCbp\responseHandle\ResponseTypeHandle;

class OrderResponse extends ResponseTypeHandle
{
    public function __construct()
    {
        $fields = [
            'merchantId',
            'requestId',
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