<?php
/**
 * 充值业务
 * Created by PhpStorm.
 * User: yinquan.ma
 * Date: 2017/10/8
 * Time: 下午5:39
 */

namespace YeepayCbp\formProcess\hg_v2\builder;


use YeepayCbp\exception\NullPointerException;
use YeepayCbp\formProcess\Process;
use YeepayCbp\utils\ConfigurationUtils;

class RechargeOrderBuilder extends Process
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
     * 充值的会员id（小型卖家）
     * @var
     */
    protected $rechargeMemberId;
    /**
     * 充值金额
     * @var
     */
    protected $orderAmount;
    /**
     * 充值币种
     * @var
     */
    protected $orderCurrency;
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
     * 银行卡信息
     * @var
     */
    protected $bankCard;

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
    public function getRechargeMemberId()
    {
        return $this->rechargeMemberId;
    }

    /**
     * @param mixed $rechargeMemberId
     */
    public function setRechargeMemberId($rechargeMemberId)
    {
        $this->rechargeMemberId = $rechargeMemberId;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getOrderAmount()
    {
        return $this->orderAmount;
    }

    /**
     * @param mixed $orderAmount
     */
    public function setOrderAmount($orderAmount)
    {
        $this->orderAmount = $orderAmount;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getOrderCurrency()
    {
        return $this->orderCurrency;
    }

    /**
     * @param mixed $orderCurrency
     */
    public function setOrderCurrency($orderCurrency)
    {
        $this->orderCurrency = $orderCurrency;
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
    public function getBankCard()
    {
        return $this->bankCard;
    }

    /**
     * @param mixed $bankCard
     */
    public function setBankCard($bankCard)
    {
        $this->bankCard = $bankCard;
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
        if (empty($this->rechargeMemberId)) {
            throw new NullPointerException('rechargeMemberId is empty');
        }
        if (empty($this->orderAmount)) {
            throw new NullPointerException('orderAmount is empty');
        }
        if (empty($this->orderCurrency)) {
            throw new NullPointerException('orderCurrency is empty');
        }
        if (empty($this->notifyUrl)) {
            throw new NullPointerException('notifyUrl is empty');
        }
        if (empty($this->callbackUrl)) {
            throw new NullPointerException('callbackUrl is empty');
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
        $hmacSource .= $this->rechargeMemberId;
        $hmacSource .= $this->orderAmount;
        $hmacSource .= $this->orderCurrency;
        $hmacSource .= $this->notifyUrl;
        $hmacSource .= $this->callbackUrl;
        if (!empty($this->bankCard)) {
            $bankCard = $this->bankCard;
            if (!is_array($bankCard)) {
                $bankCard = is_object($bankCard) ? (array)$bankCard : json_decode($this->payer, true);
            }
            if (isset($bankCard['name'])) {
                $hmacSource .= $bankCard['name'];
            }
            if (isset($bankCard['cardNo'])) {
                $hmacSource .= $bankCard['cardNo'];
            }
            if (isset($bankCard['cvv2'])) {
                $hmacSource .= $bankCard['cvv2'];
            }
            if (isset($bankCard['idNo'])) {
                $hmacSource .= $bankCard['idNo'];
            }
            if (isset($bankCard['expiryDate'])) {
                $hmacSource .= $bankCard['expiryDate'];
            }
            if (isset($bankCard['mobileNo'])) {
                $hmacSource .= $bankCard['mobileNo'];
            }
        }
        return $this->encipher($hmacSource,ConfigurationUtils::getInstance()->getHmacKey($this->merchantId));
    }
}