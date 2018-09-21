<?php
/**
 * Created by PhpStorm.
 * User: yiqnuan.ma <yinquan.ma@yeepay.com>
 * Date: 2017/9/14
 * Time: 下午3:52
 */

namespace YeepayCbp\responseHandle\foreignExchangePayHandle;



use YeepayCbp\responseHandle\ResponseTypeHandle;

class RefundQueryHandle extends ResponseTypeHandle
{

    public function __construct()
    {
        $fields = [
            'merchantId',
            'requestId',
            'serialNumber',
            'orderId',
            'status',
            'errorCode',
            'errorMessage',
            'amount',
            'currency',
            'completeDateTime',
        ];
        $this->setHmacFields($fields);
    }
}