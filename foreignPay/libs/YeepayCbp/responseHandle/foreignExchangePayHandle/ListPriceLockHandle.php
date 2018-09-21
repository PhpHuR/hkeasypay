<?php
/**
 * Created by PhpStorm.
 * User: yiqnuan.ma <yinquan.ma@yeepay.com>
 * Date: 2017/9/14
 * Time: 下午3:52
 */

namespace YeepayCbp\responseHandle\foreignExchangePayHandle;

use YeepayCbp\responseHandle\ResponseTypeHandle;

class ListPriceLockHandle extends ResponseTypeHandle
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