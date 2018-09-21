<?php
/**
 * Created by PhpStorm.
 * User: yiqnuan.ma <yinquan.ma@yeepay.com>
 * Date: 2017/9/14
 * Time: 下午5:41
 */

namespace YeepayCbp\formProcess\foreignExchangePay\builder;


use YeepayCbp\exception\NullPointerException;
use YeepayCbp\FormProcess\Process;
use YeepayCbp\utils\ConfigurationUtils;

class ListPriceLockBuilder extends Process
{

    public $merchantId;
    public $currency;

    /**
     * @return mixed
     */
    public function getMerchantId()
    {
        return $this->merchantId;
    }

    /**
     * @param mixed $merchantId
     */
    public function setMerchantId($merchantId)
    {
        $this->merchantId = $merchantId;
    }

    /**
     * @return mixed
     */
    public function getCurrency()
    {
        return $this->currency;
    }

    /**
     * @param mixed $currency
     */
    public function setCurrency($currency)
    {
        $this->currency = $currency;
    }


    public function builder($params)
    {
        // TODO: Implement builder() method.
        if (empty($this->merchantId)) {
            throw new NullPointerException('merchantId  is null');
        }
        if (empty($this->currency)) {
            throw new NullPointerException('currency  is null');
        }

        return $this->buildJson();
    }

    /**
     * 生成认证串
     * @return mixed
     */
    function generateHmac()
    {
        // TODO: Implement generateHmac() method.
        $hmacSource = "";
        $hmacSource .= $this->merchantId;
        $hmacSource .= $this->currency;
        return $this->encipher($hmacSource,ConfigurationUtils::getInstance()->getHmacKey($this->merchantId));
    }
}