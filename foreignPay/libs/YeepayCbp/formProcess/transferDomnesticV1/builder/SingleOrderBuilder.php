<?php
/**
 * Created by PhpStorm.
 * User: yp-tc-7044
 * Date: 2017/10/17
 * Time: 上午10:19
 */

namespace YeepayCbp\formProcess\transferDomnesticV1\builder;


use YeepayCbp\exception\NullPointerException;
use YeepayCbp\formProcess\Process;
use YeepayCbp\utils\ConfigurationUtils;

class SingleOrderBuilder extends Process
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
     * 收款人信息
     * @var
     */
    protected $payee;

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

    /**
     * @return mixed
     */
    public function getPayee()
    {
        return $this->payee;
    }

    /**
     * @param mixed $payee
     */
    public function setPayee($payee)
    {
        $this->payee = $payee;
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
        if (empty($this->notifyUrl)) {
            throw new NullPointerException('notifyUrl is null');
        }
        if (empty($this->payee)) {
            throw new NullPointerException('payee is null');
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
        $hmacSource .= $this->notifyUrl;
        $hmacSource .= $this->callbackUrl;
        $hmacSource .= $this->remark;
        if (!empty($this->payee)) {
            $payee = $this->payee;
            if (!is_array($payee)) {
                $payee = is_object($payee)?(array)$payee : json_decode($payee, true);
            }
            if (isset($payee['name'])) {
                $hmacSource .= $payee['name'];
            }
            if (isset($payee['bankCardNum'])) {
                $hmacSource .= $payee['bankCardNum'];
            }
            if (isset($payee['bankName'])) {
                $hmacSource .= $payee['bankName'];
            }
            if (isset($payee['branchBankName'])) {
                $hmacSource .= $payee['branchBankName'];
            }
            if (isset( $payee['province'])) {
                $hmacSource .= $payee['province'];
            }
            if (isset($payee['city'])) {
                $hmacSource .= $payee['city'];
            }
        }
        return $this->encipher($hmacSource,ConfigurationUtils::getInstance()->getHmacKey($this->merchantId));

    }
}