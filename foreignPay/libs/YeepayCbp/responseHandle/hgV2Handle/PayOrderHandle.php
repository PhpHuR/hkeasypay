<?php
/**
 * Created by PhpStorm.
 * User: yp-tc-7044
 * Date: 2017/10/1
 * Time: 下午3:16
 */

namespace YeepayCbp\responseHandle\hgV2Handle;


use YeepayCbp\responseHandle\ResponseTypeHandle;

class PayOrderHandle extends ResponseTypeHandle
{
    public function __construct()
    {
        $fields = [
            'merchantId',
            'requestId',
            'status',
            'serialNumber',
        ];
        $this->setHmacFields($fields);
    }
}