<?php
/**
 * Created by PhpStorm.
 * User: yp-tc-7044
 * Date: 2017/10/1
 * Time: 下午1:17
 */

namespace YeepayCbp\responseHandle\transferHandle;

use YeepayCbp\responseHandle\ResponseTypeHandle;

class OrderHanlde extends ResponseTypeHandle
{
    public function __construct()
    {
        $fields = [
            'merchantId',
            'requestId',
            'status',
        ];
        $this->setHmacFields($fields);
    }
}