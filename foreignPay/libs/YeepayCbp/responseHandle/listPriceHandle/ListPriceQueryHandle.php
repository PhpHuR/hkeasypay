<?php
/**
 * Created by PhpStorm.
 * User: yp-tc-7044
 * Date: 2017/10/18
 * Time: 上午11:05
 */

namespace YeepayCbp\responseHandle\listPriceHandle;


use YeepayCbp\responseHandle\ResponseTypeHandle;

class ListPriceQueryHandle extends ResponseTypeHandle
{
    public function __construct()
    {
        $fields = [
            'merchantId',
            'sourceCurrency',
            'targetCurrency',
            'offer',
            'bid',
            'listpriceDateTime',
            'status',
            'errorMsg',
        ];
        $this->setHmacFields($fields);
    }
}