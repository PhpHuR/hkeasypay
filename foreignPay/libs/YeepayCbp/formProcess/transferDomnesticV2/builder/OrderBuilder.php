<?php
/**
 * Created by PhpStorm.
 * User: yp-tc-7044
 * Date: 2017/10/17
 * Time: 上午10:19
 */

namespace YeepayCbp\formProcess\transferDomnesticV2\builder;


use YeepayCbp\exception\NullPointerException;
use YeepayCbp\formProcess\Process;
use YeepayCbp\utils\ConfigurationUtils;

class OrderBuilder extends Process
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
     * 转账金额
     * @var
     */
    protected $amount;
    /**
     * 转账金额币种
     * @var
     */
    protected $currency;
    /**
     * 汇款类型
     * @var
     */
    protected $transferMode;
    /**
     * 上传明细地址
     * @var
     */
    protected $detailPath;
    /**
     * 通知地址
     * @var
     */
    protected $notifyUrl;
    /**
     * 回调地址
     * @var
     */
    protected $callbackUrl;
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
    public function getTransferMode()
    {
        return $this->transferMode;
    }

    /**
     * @param mixed $transferMode
     */
    public function setTransferMode($transferMode)
    {
        $this->transferMode = $transferMode;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDetailPath()
    {
        return $this->detailPath;
    }

    /**
     * @param mixed $detailPath
     */
    public function setDetailPath($detailPath)
    {
        $this->detailPath = $detailPath;
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
    public function getCallbackUrl()
    {
        return $this->callbackUrl;
    }

    /**
     * @param mixed $callbackUrl
     */
    public function setCallbackUrl($callbackUrl)
    {
        $this->callbackUrl = $callbackUrl;
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
        if (empty($this->currency)) {
            throw new NullPointerException('currency is null');
        }
        if (empty($this->transferMode)) {
            throw new NullPointerException('transferMode is null');
        }
        if (empty($this->detailPath)) {
            throw new NullPointerException('detailPath is null');
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
        $hmacSource .= $this->currency;
        $hmacSource .= $this->transferMode;
        $hmacSource .= $this->detailPath;
        $hmacSource .= $this->notifyUrl;
        $hmacSource .= $this->callbackUrl;
        $hmacSource .= $this->remark;
        return $this->encipher($hmacSource,ConfigurationUtils::getInstance()->getHmacKey($this->merchantId));

    }
}