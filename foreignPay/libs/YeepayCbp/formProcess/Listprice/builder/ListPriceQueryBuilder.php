<?php
/**
 * Created by PhpStorm.
 * User: yp-tc-7044
 * Date: 2017/10/17
 * Time: 上午11:32
 */

namespace YeepayCbp\formProcess\Listprice\builder;


use YeepayCbp\exception\NullPointerException;
use YeepayCbp\formProcess\Process;
use YeepayCbp\utils\ConfigurationUtils;

class ListPriceQueryBuilder extends Process
{

    /**
     * 商户编号
     * @var
     */
    protected $merchantId;
    /**
     * 原币种
     * @var
     */
    protected $sourceCurrency;

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
    public function getSourceCurrency()
    {
        return $this->sourceCurrency;
    }

    /**
     * @param mixed $sourceCurrency
     */
    public function setSourceCurrency($sourceCurrency)
    {
        $this->sourceCurrency = $sourceCurrency;
        return $this;
    }


    public function builder($params)
    {
        // TODO: Implement builder() method.
        if (is_null($this->merchantId)) {
            throw new NullPointerException('merchantId is null');
        }
        if (is_null($this->sourceCurrency)) {
            throw new NullPointerException('sourceCurrency is null');
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
        $hmacSource .= $this->sourceCurrency;
        return $this->encipher($hmacSource, ConfigurationUtils::getInstance()->getHmacKey($this->merchantId));
    }
}