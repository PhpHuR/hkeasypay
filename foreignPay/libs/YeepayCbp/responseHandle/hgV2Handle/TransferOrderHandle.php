<?php
/**
 * Created by PhpStorm.
 * User: yp-tc-7044
 * Date: 2017/10/1
 * Time: 下午3:15
 */

namespace YeepayCbp\responseHandle\hgV2Handle;


use YeepayCbp\responseHandle\ResponseTypeHandle;

class TransferOrderHandle extends ResponseTypeHandle
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