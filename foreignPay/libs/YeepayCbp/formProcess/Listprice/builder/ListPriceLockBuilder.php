<?php
/**
 * Created by PhpStorm.
 * User: yp-tc-7044
 * Date: 2017/10/17
 * Time: 上午11:37
 */

namespace YeepayCbp\formProcess\Listprice\builder;


use YeepayCbp\exception\NullPointerException;
use YeepayCbp\formProcess\Process;
use YeepayCbp\utils\ConfigurationUtils;

class ListPriceLockBuilder extends Process
{
    /**
     * 商户编号
     * @var
     */
    protected $merchantId;
    /**
     * 币种
     * @var
     */
    protected $currency;
    /**
     * 锁定牌价类型
     * @var
     */
    protected $type;

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
        return $this;
    }

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @param mixed $type
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }


    public function builder($params)
    {
        // TODO: Implement builder() method.
        if (is_null($this->merchantId)) {
            throw new NullPointerException('merchantId is null');
        }
        if (is_null($this->currency)) {
            throw new NullPointerException('currency is null');
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
        $hmacSource .= $this->currency;
        $hmacSource .= $this->type;
        return $this->encipher($hmacSource, ConfigurationUtils::getInstance()->getHmacKey($this->merchantId));
    }
}