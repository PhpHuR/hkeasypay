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

class RefundBuilder extends Process
{
    /**
     * 商户ID
     * @var
     */
    protected $merchantId;

    /**
     * 订单号
     * @var
     */
    protected $requestId;

    /**
     * 金额
     * @var
     */
    protected $amount;

    /**
     * 原订单流水号
     * @var
     */
    protected $orderId;

    /**
     * 通知地址
     * @var
     */
    protected $notifyUrl;

    /**
     * 备注
     * @var
     */
    protected $remark;

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
        return $this;
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
    public function getOrderId()
    {
        return $this->orderId;
    }

    /**
     * @param mixed $orderId
     */
    public function setOrderId($orderId)
    {
        $this->orderId = $orderId;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNotifyUrl()
    {
        return $this->notifyUrl;
    }

    /**
     * @param mixed $notifyUrl
     */
    public function setNotifyUrl($notifyUrl)
    {
        $this->notifyUrl = $notifyUrl;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRemark()
    {
        return $this->remark;
    }

    /**
     * @param mixed $remark
     */
    public function setRemark($remark)
    {
        $this->remark = $remark;
        return $this;
    }


    public function builder($params)
    {
        // TODO: Implement builder() method.
        if (empty($this->merchantId)) {
            throw new NullPointerException('merchantId is null');
        }
        if (empty($this->requestId)) {
            throw new NullPointerException('requestId is null');
        }
        if (empty($this->amount)) {
            throw new NullPointerException('amount is null');
        }
        if (empty($this->orderId)) {
            throw new NullPointerException('orderId is null');
        }
        if (empty($this->notifyUrl)) {
            throw new NullPointerException('notifyUrl is null');
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
        $hmacSource .= $this->amount;
        $hmacSource .= $this->orderId;
        $hmacSource .= $this->notifyUrl;
        $hmacSource .= $this->remark;
        return $this->encipher($hmacSource,ConfigurationUtils::getInstance()->getHmacKey($this->merchantId));
    }
}