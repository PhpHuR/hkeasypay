<?php
/**
 * Created by PhpStorm.
 * User: yp-tc-7044
 * Date: 2017/10/1
 * Time: 下午3:14
 */

namespace YeepayCbp\responseHandle\hgV2Handle;


use YeepayCbp\responseHandle\ResponseTypeHandle;

class RechargeQueryHandle extends ResponseTypeHandle
{
    public function __construct()
    {
        $fields = [
            'merchantId',
            'requestId',
            'rechargeMemberId',
            'orderAmount',
            'orderCurrency',
            'completeDateTime',
            'status',
            'serialNumber',
        ];
        $this->setHmacFields($fields);
    }
}