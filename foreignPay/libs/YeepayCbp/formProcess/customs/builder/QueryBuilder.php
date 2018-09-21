<?php
/**
 * Created by PhpStorm.
 * User: yp-tc-7044
 * Date: 2017/10/9
 * Time: 下午4:19
 */

namespace YeepayCbp\formProcess\customs\builder;


use YeepayCbp\exception\NullPointerException;
use YeepayCbp\formProcess\Process;
use YeepayCbp\utils\ConfigurationUtils;

class QueryBuilder extends Process
{

    protected $merchantId;

    /**
     * 支付流水号
     * @var
     */
    protected $paySerialNumber;

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
    public function getPaySerialNumber()
    {
        return $this->paySerialNumber;
    }

    /**
     * @param mixed $paySerialNumber
     */
    public function setPaySerialNumber($paySerialNumber)
    {
        $this->paySerialNumber = $paySerialNumber;
        return $this;
    }


    public function builder($params)
    {
        // TODO: Implement builder() method.
        if (empty($this->merchantId)) {
            throw new NullPointerException('merchantId is null');
        }
        if (empty($this->paySerialNumber)) {
            throw new NullPointerException('paySerialNumber is null');
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
        $hmacSource .= $this->paySerialNumber;

        return $this->encipher($hmacSource, ConfigurationUtils::getInstance()->getHmacKey($this->merchantId));
    }

}