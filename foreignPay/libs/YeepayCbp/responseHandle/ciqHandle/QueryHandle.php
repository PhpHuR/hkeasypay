<?php
/**
 * Created by PhpStorm.
 * User: yp-tc-7044
 * Date: 2017/9/26
 * Time: 上午9:31
 */

namespace YeepayCbp\responseHandle\ciqHandle;


use YeepayCbp\responseHandle\ResponseTypeHandle;

class QueryHandle extends ResponseTypeHandle
{
    public function __construct()
    {
        $fields = [
            'ciqChannel',
            'ciqCode',
            'amount',
            'status',
        ];
        $this->setHmacFields($fields);
    }
}