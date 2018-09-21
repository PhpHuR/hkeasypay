<?php

namespace YeepayCbp\formProcess\foreignExchangePay\builder;

use YeepayCbp\Entity\BankCard;
use YeepayCbp\Entity\Payer;
use YeepayCbp\Entity\ProductDetail;
use YeepayCbp\exception\NullPointerException;
use YeepayCbp\FormProcess\Process;
use YeepayCbp\utils\ConfigurationUtils;

/**
 * Created by PhpStorm.
 * User: yiqnuan.ma <yinquan.ma@yeepay.com>
 * Date: 2017/9/14
 * Time: 下午2:03
 */
class OrderBuilder extends Process
{
    protected $merchantId;
    protected $orderAmount;
    protected $orderCurrency;
    protected $requestId;
    protected $amount;
    protected $currency;
    protected $forUse;
    protected $listPriceToken;
    protected $notifyUrl;
    protected $callbackUrl;
    protected $remark;
    protected $paymentModeCode;
    protected $openId;

    /**
     * @var productDetails
     */
    protected $productDetails;

    /**
     * @var Payer
     */
    protected $payer;

    protected $cashierVersion;
    protected $merchantUserId;
    protected $bindCardId;

    /**
     * @var BankCard
     */
    protected $bankCard;

    protected $clientIp;
    protected $timeout;
    /**
     * @var subOrders
     */
    protected $subOrders;

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
    public function getForUse()
    {
        return $this->forUse;
    }

    /**
     * @param mixed $forUse
     */
    public function setForUse($forUse)
    {
        $this->forUse = $forUse;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getListPriceToken()
    {
        return $this->listPriceToken;
    }

    /**
     * @param mixed $listPriceToken
     */
    public function setListPriceToken($listPriceToken)
    {
        $this->listPriceToken = $listPriceToken;
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
    public function getPaymentModeCode()
    {
        return $this->paymentModeCode;
    }

    /**
     * @param mixed $paymentModeCode
     */
    public function setPaymentModeCode($paymentModeCode)
    {
        $this->paymentModeCode = $paymentModeCode;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getOpenId()
    {
        return $this->openId;
    }

    /**
     * @param mixed $openId
     */
    public function setOpenId($openId)
    {
        $this->openId = $openId;
        return $this;
    }

    /**
     * @return productDetails
     */
    public function getProductDetails()
    {
        return $this->productDetails;
    }

    /**
     * @param productDetails $productDetails
     */
    public function setProductDetails($productDetails)
    {
        $this->productDetails = $productDetails;
        return $this;
    }

    /**
     * @return Payer
     */
    public function getPayer()
    {
        return $this->payer;
    }

    /**
     * @param Payer $payer
     */
    public function setPayer($payer)
    {
        $this->payer = $payer;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCashierVersion()
    {
        return $this->cashierVersion;
    }

    /**
     * @param mixed $cashierVersion
     */
    public function setCashierVersion($cashierVersion)
    {
        $this->cashierVersion = $cashierVersion;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMerchantUserId()
    {
        return $this->merchantUserId;
    }

    /**
     * @param mixed $merchantUserId
     */
    public function setMerchantUserId($merchantUserId)
    {
        $this->merchantUserId = $merchantUserId;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBindCardId()
    {
        return $this->bindCardId;
    }

    /**
     * @param mixed $bindCardId
     */
    public function setBindCardId($bindCardId)
    {
        $this->bindCardId = $bindCardId;
        return $this;
    }

    /**
     * @return BankCard
     */
    public function getBankCard()
    {
        return $this->bankCard;
    }

    /**
     * @param BankCard $bankCard
     */
    public function setBankCard($bankCard)
    {
        $this->bankCard = $bankCard;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getClientIp()
    {
        return $this->clientIp;
    }

    /**
     * @param mixed $clientIp
     */
    public function setClientIp($clientIp)
    {
        $this->clientIp = $clientIp;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTimeout()
    {
        return $this->timeout;
    }

    /**
     * @param mixed $timeout
     */
    public function setTimeout($timeout)
    {
        $this->timeout = $timeout;
        return $this;
    }

    /**
     * @return subOrders
     */
    public function getSubOrders()
    {
        return $this->subOrders;
    }

    /**
     * @param subOrders $subOrders
     */
    public function setSubOrders($subOrders)
    {
        $this->subOrders = $subOrders;
        return $this;
    }


    /**
     * @param $params
     * @return mixed
     */
    public function builder($params)
    {
        // TODO: Implement builder() method.

        if (empty($this->merchantId)) {
            throw new NullPointerException('merchantId is null');
        }
        if (empty($this->orderAmount)) {
            throw new NullPointerException('orderAmount is null');
        }
        if (empty($this->orderCurrency)) {
            throw new NullPointerException('orderCurrency is null');
        }
        if (empty($this->requestId)) {
            throw new NullPointerException('requestId is null');
        }
        if (empty($this->currency)) {
            throw new NullPointerException('currency is null');
        }
        if (empty($this->forUse)) {
            throw new NullPointerException('forUse is null');
        }
        if (empty($this->notifyUrl)) {
            throw new NullPointerException('notifyUrl is null');
        }
        if (empty($this->callbackUrl)) {
            throw new NullPointerException('callbackUrl is null');
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
        $hmacSource = "";
        $hmacSource .= $this->merchantId;
        $hmacSource .= $this->orderAmount;
        $hmacSource .= $this->orderCurrency;
        $hmacSource .= $this->requestId;
        $hmacSource .= $this->amount;
        $hmacSource .= $this->currency;
        $hmacSource .= $this->forUse;
        $hmacSource .= $this->listPriceToken;
        $hmacSource .= $this->notifyUrl;
        $hmacSource .= $this->callbackUrl;
        $hmacSource .= $this->remark;
        $hmacSource .= $this->paymentModeCode;
        $hmacSource .= $this->openId;

        if (!empty($this->productDetails)) {
            foreach ($this->productDetails as $productDetail) {
                if (!is_array($productDetail)) {
                    $productDetail = is_object($productDetail) ? (array)$productDetail : json_decode($productDetail, true);
                }
                if (isset($productDetail['name'])) {
                    $hmacSource .= $productDetail['name'];
                }
                if (isset($productDetail['quantity'])) {
                    $hmacSource .= $productDetail['quantity'];
                }
                if (isset($productDetail['amount'])) {
                    $hmacSource .= $productDetail['amount'];
                }
                if (isset($productDetail['receiver'])) {
                    $hmacSource .= $productDetail['receiver'];
                }
                if (isset($productDetail['description'])) {
                    $hmacSource .= $productDetail['description'];
                }
            }
        }
        if (!empty($this->payer)) {
            $payer = $this->payer;
            if (!is_array($payer)) {
                if (is_object($payer)) {
                    $payer = (array)$payer;
                } else {
                    $payer = json_decode($this->payer, true);
                }

            }
            if (isset($payer['name'])) {
                $hmacSource .= $payer['name'];
            }
            if (isset($payer['idType'])) {
                $hmacSource .= $payer['idType'];
            }
            if (isset($payer['idNum'])) {
                $hmacSource .= $payer['idNum'];
            }
            if (isset($payer['bankCardNum'])) {
                $hmacSource .= $payer['bankCardNum'];
            }
            if (isset($payer['phoneNum'])) {
                $hmacSource .= $payer['phoneNum'];
            }
            if (isset($payer['email'])) {
                $hmacSource .= $payer['email'];
            }
            if (isset($payer['nationality'])) {
                $hmacSource .= $payer['nationality'];
            }
        }

        $hmacSource .= $this->cashierVersion;
        $hmacSource .= $this->merchantUserId;
        $hmacSource .= $this->bindCardId;

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

        $hmacSource .= $this->clientIp;
        $hmacSource .= $this->timeout;

        if (!empty($this->subOrders)) {
            foreach ($this->subOrders as $subOrder) {
                if (!is_array($subOrder)) {
                    $subOrder = json_decode($subOrder, true);
                }
                if (isset($subOrder['requestId'])) {
                    $hmacSource .= $subOrder['requestId'];
                }
                if (isset($subOrder['amount'])) {
                    $hmacSource .= $subOrder['amount'];
                }
            }
        }
        return $this->encipher($hmacSource, ConfigurationUtils::getInstance()->getHmacKey($this->merchantId));
    }
}