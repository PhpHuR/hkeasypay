<?php
/**
 * Created by PhpStorm.
 * User: yp-tc-7044
 * Date: 2017/9/26
 * Time: 上午9:30
 */

namespace YeepayCbp\responseHandle\ciqHandle;


use YeepayCbp\responseHandle\ResponseTypeHandle;

class OrderHandle extends ResponseTypeHandle
{
    public function __construct()
    {
        $fields = [
            'merchantId',
            'paySerialNumber',
            'status',
        ];
        $this->setHmacFields($fields);
    }
}