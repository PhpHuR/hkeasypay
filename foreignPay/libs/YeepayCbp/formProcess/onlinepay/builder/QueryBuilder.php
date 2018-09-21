<?php
/**
 *
 *
 * PHP Version 5
 *
 * @category  Class
 * @file      QueryBuilder.php
 * @package yeepayCbp\formProcess\onlinepay
 * @author    chao.ma <chao.ma@ehking.com>
 */

namespace YeepayCbp\formProcess\onlinepay\builder;


use YeepayCbp\exception\NullPointerException;
use YeepayCbp\formProcess\Process;
use YeepayCbp\utils\ConfigurationUtils;

class QueryBuilder extends Process
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
        if (empty($this->merchantId)) {
            throw new NullPointerException('merchantId is null');
        }
        if (empty($this->requestId)) {
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
        $hmacSource = "";

        $hmacSource .= $this->merchantId;
        $hmacSource .= $this->requestId;
        return $this->encipher($hmacSource, ConfigurationUtils::getInstance()->getHmacKey($this->merchantId));
    }

} 