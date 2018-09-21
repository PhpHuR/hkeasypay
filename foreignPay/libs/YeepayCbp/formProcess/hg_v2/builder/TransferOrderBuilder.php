<?php
/**
 * 转账业务
 * Created by PhpStorm.
 * User: yinquan.ma
 * Date: 2017/10/8
 * Time: 下午5:41
 */

namespace YeepayCbp\formProcess\hg_v2\builder;

use YeepayCbp\exception\NullPointerException;
use YeepayCbp\formProcess\Process;
use YeepayCbp\utils\ConfigurationUtils;

class TransferOrderBuilder extends Process
{
    /**
     * 商户编号
     * @var
     */
    protected $merchantId;
    /**
     * 订单号
     * @var
     */
    protected $requestId;
    /**
     * 转出会员id
     * @var
     */
    protected $fromMember;
    /**
     * 转入会员id
     * @var
     */
    protected $toMember;
    /**
     * 转账金额
     * @var
     */
    protected $amount;
    /**
     * currency
     * @var
     */
    protected $currency;

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

    /**
     * @return mixed
     */
    public function getFromMember()
    {
        return $this->fromMember;
    }

    /**
     * @param mixed $fromMember
     */
    public function setFromMember($fromMember)
    {
        $this->fromMember = $fromMember;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getToMember()
    {
        return $this->toMember;
    }

    /**
     * @param mixed $toMember
     */
    public function setToMember($toMember)
    {
        $this->toMember = $toMember;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAmount()
    {
        return $this->amount;
    }

    /**
     * @param mixed $amount
     */
    public function setAmount($amount)
    {
        $this->amount = $amount;
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


    public function builder($params)
    {
        // TODO: Implement builder() method.
        if (empty($this->merchantId)) {
            throw new NullPointerException('merchantId is empty');
        }
        if (empty($this->requestId)) {
            throw new NullPointerException('requestId is empty');
        }
        if (empty($this->fromMember)) {
            throw new NullPointerException('fromMember is empty');
        }
        if (empty($this->toMember)) {
            throw new NullPointerException('toMember is empty');
        }
        if (empty($this->amount)) {
            throw new NullPointerException('amount is empty');
        }
        if (empty($this->currency)) {
            throw new NullPointerException('currency is empty');
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
        $hmacSource .= $this->fromMember;
        $hmacSource .= $this->toMember;
        $hmacSource .= $this->amount;
        $hmacSource .= $this->currency;

        return $this->encipher($hmacSource,ConfigurationUtils::getInstance()->getHmacKey($this->merchantId));
    }
}