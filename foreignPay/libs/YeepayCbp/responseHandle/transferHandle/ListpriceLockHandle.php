<?php
/**
 * Created by PhpStorm.
 * User: yp-tc-7044
 * Date: 2017/10/1
 * Time: 下午1:19
 */

namespace YeepayCbp\responseHandle\transferHandle;


use YeepayCbp\responseHandle\ResponseTypeHandle;

class ListpriceLockHandle extends ResponseTypeHandle
{
    public function __construct()
    {
        $fields = [
            'merchantId',
            'serialNumber',
            'listprice',
            'validity',
            'effective',
            'status',
        ];
        $this->setHmacFields($fields);
    }
}