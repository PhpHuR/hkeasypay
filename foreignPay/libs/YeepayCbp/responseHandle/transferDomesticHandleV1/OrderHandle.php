<?php
/**
 * Created by PhpStorm.
 * User: yp-tc-7044
 * Date: 2017/10/1
 * Time: 下午3:19
 */

namespace YeepayCbp\responseHandle\transferDomesticHandleV1;


use YeepayCbp\responseHandle\ResponseTypeHandle;

class OrderHandle extends ResponseTypeHandle
{
    public function __construct()
    {
        $fields =[
            'merchantId',
            'requestId',
            'status',
        ];
        $this->setHmacFields($fields);
    }
}