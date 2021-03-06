<?php
/**
 * Created by PhpStorm.
 * User: yp-tc-7044
 * Date: 2017/10/18
 * Time: 下午5:18
 */

namespace YeepayCbp\responseHandle\hgV2Handle;


use YeepayCbp\responseHandle\ResponseTypeHandle;

class RechargeOrderNotifyResponse extends ResponseTypeHandle
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