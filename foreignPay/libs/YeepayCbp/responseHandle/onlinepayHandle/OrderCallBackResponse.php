<?php
/**
 * 异步回调
 * Created by PhpStorm.
 * User: yinquan.ma
 * Date: 2017/10/10
 * Time: 下午3:43
 */

namespace YeepayCbp\responseHandle\onlinepayHandle;


use YeepayCbp\responseHandle\ResponseTypeHandle;

class OrderCallBackResponse extends ResponseTypeHandle
{
    public function __construct()
    {
        $fields = [
            'merchantId',
            'requestId',
            'serialNumber',
            'totalRefundCount',
            'totalRefundAmount',
            'orderCurrency',
            'orderAmount',
            'status',
            'completeDateTime',
            'remark',
        ];
        $this->setHmacFields($fields);
    }
}