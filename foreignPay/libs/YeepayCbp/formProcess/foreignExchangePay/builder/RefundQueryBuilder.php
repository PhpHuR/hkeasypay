<?php
/**
 * Created by PhpStorm.
 * User: yiqnuan.ma <yinquan.ma@yeepay.com>
 * Date: 2017/9/14
 * Time: 下午5:40
 */

namespace YeepayCbp\formProcess\foreignExchangePay\builder;

use YeepayCbp\exception\NullPointerException;
use YeepayCbp\FormProcess\Process;
use YeepayCbp\utils\ConfigurationUtils;

class RefundQueryBuilder extends Process
{

    protected $merchantId;
    protected $requestId;

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
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRequestId()
    {
        return $this->requestId;
    }

    /**
     * @param mixed $requestId
     */
    public function setRequestId($requestId)
    {
        $this->requestId = $requestId;
        return $this;
    }


    public function builder($params)
    {
        // TODO: Implement builder() method.
        if (is_null($this->merchantId)) {
            throw new NullPointerException('merchantId is null');
        }
        if (is_null($this->requestId)) {
            throw new NullPointerException('requestId is null');
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
        $hmacSource = '';
        $hmacSource .= $this->merchantId;
        $hmacSource .= $this->requestId;
        return $this->encipher($hmacSource,ConfigurationUtils::getInstance()->getHmacKey($this->merchantId));
    }
}