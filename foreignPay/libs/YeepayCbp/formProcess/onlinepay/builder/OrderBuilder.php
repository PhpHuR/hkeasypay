<?php
/**
 *
 *
 * PHP Version 5
 *
 * @category  Class
 * @file      OrderBuilder.php
 * @package yeepayCbp\formProcess\onlinepay
 * @author    chao.ma <chao.ma@ehking.com>
 */

namespace YeepayCbp\formProcess\onlinepay\builder;


use YeepayCbp\entity\BankCard;
use YeepayCbp\entity\Payer;
use YeepayCbp\entity\ProductDetail;
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
     * 订单金额
     * @var
     */
    protected $orderAmount;
    /**
     * 订单币种
     * @var
     */
    protected $orderCurrency;
    /**
     * 订单号
     * @var
     */
    protected $requestId;
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
     * 支付方式编码
     * @var
     */
    protected $paymentModeCode;
    /**
     * 商品信息
     * @var
     */
    protected $productDetails;
    /**
     * 申报信息
     * @var Payer
     */
    protected $payer;
    /**
     * 快捷支付信息
     * @var BankCard
     */
    protected $bankCard;
    /**
     * 收银台类型
     * @var
     */
    protected $cashierVersion;
    /**
     * 贸易背景
     * @var
     */
    protected $forUse;
    /**
     * 商户会员 ID
     * @var
     */
    protected $merchantUserId;
    /**
     * 绑卡 ID
     * @var
     */
    protected $bindCardId;
    /**
     * clientIp
     * @var
     */
    protected $clientIp;
    /**
     * 订单超时时间
     * @var
     */
    protected $timeout;
    /**
     * 支付宝支付授权码
     * @var
     */
    protected $authCode;
    /**
     * 微信公众号 openId
     * @var
     */
    protected $openId;
    /**
     * @var subOrders
     */
    protected $subOrders;

    protected $splitRecords;

    protected $paymentToken;
    /**
     * 分账标识
     * @var
     */
    protected $splitMark;
    /**
     * 分账规则
     * @var
     */
    protected $splitRule;
    /**
     * 收货人信息
     * @var
     */
    protected $receiver;

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
    public function getAuthCode()
    {
        return $this->authCode;
    }

    /**
     * @param mixed $authCode
     */
    public function setAuthCode($authCode)
    {
        $this->authCode = $authCode;
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
    public function getReceiver()
    {
        return $this->receiver;
    }

    /**
     * @param mixed $receiver
     */
    public function setReceiver($receiver)
    {
        $this->receiver = $receiver;
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
     * @return mixed
     */
    public function getProductDetails()
    {
        return $this->productDetails;
    }

    /**
     * @param mixed $productDetails
     */
    public function setProductDetails($productDetails)
    {
        $this->productDetails = $productDetails;
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
     * @return mixed
     */
    public function getSplitRecords()
    {
        return $this->splitRecords;
    }

    /**
     * @param mixed $splitRecords
     */
    public function setSplitRecords($splitRecords)
    {
        $this->splitRecords = $splitRecords;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPaymentToken()
    {
        return $this->paymentToken;
    }

    /**
     * @param mixed $paymentToken
     */
    public function setPaymentToken($paymentToken)
    {
        $this->paymentToken = $paymentToken;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSplitMark()
    {
        return $this->splitMark;
    }

    /**
     * @param mixed $splitMark
     */
    public function setSplitMark($splitMark)
    {
        $this->splitMark = $splitMark;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSplitRule()
    {
        return $this->splitRule;
    }

    /**
     * @param mixed $splitRule
     */
    public function setSplitRule($splitRule)
    {
        $this->splitRule = $splitRule;
        return $this;
    }

    public function builder($params = array())
    {
        //校验非空规则
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

        if (empty($this->notifyUrl)) {
            throw new NullPointerException('notifyUrl is null');
        }

        if (empty($this->callbackUrl)) {
            throw new NullPointerException('callbackUrl is null');
        }

        if (empty($this->productDetails)) {
            throw new NullPointerException('productDetails is null');
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
        $hmacSource .= $this->orderAmount;
        $hmacSource .= $this->orderCurrency;
        $hmacSource .= $this->requestId;
        $hmacSource .= $this->notifyUrl;
        $hmacSource .= $this->callbackUrl;
        $hmacSource .= $this->remark;
        $hmacSource .= $this->paymentModeCode;
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

        if (!empty($this->splitRecords)) {
            $splitRecords = $this->splitRecords;
            if (!is_array($splitRecords)) {
                $splitRecords = is_object($splitRecords) ? (array)$splitRecords : json_decode($splitRecords, true);
            }
            foreach ($splitRecords as $splitRecord) {
                if (!is_array($splitRecord)) {
                    $splitRecord = is_object($splitRecord) ? (array)$splitRecord : json_decode($splitRecord, true);
                }
                if (isset($splitRecord['merchantInfo'])) {
                    $hmacSource .= $splitRecord['merchantInfo'];
                }
                if (isset($splitRecord['merchantMark'])) {
                    $hmacSource .= $splitRecord['merchantMark'];
                }
                if (isset($splitRecord['splitRemark'])) {
                    $hmacSource .= $splitRecord['splitRemark'];
                }
                if (isset($splitRecord['splitAmount'])) {
                    $hmacSource .= $splitRecord['splitAmount'];
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
            if (isset($payer['phoneNum'])) {
                $hmacSource .= $payer['phoneNum'];
            }
            if (isset($payer['idNum'])) {
                $hmacSource .= $payer['idNum'];
            }
            if (isset($payer['bankCardNum'])) {
                $hmacSource .= $payer['bankCardNum'];
            }
            if (isset($payer['email'])) {
                $hmacSource .= $payer['email'];
            }
        }

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

        $hmacSource .= $this->cashierVersion;
        $hmacSource .= $this->forUse;
        $hmacSource .= $this->merchantUserId;
        $hmacSource .= $this->bindCardId;
        $hmacSource .= $this->clientIp;
        $hmacSource .= $this->timeout;
        $hmacSource .= $this->splitMark;
        $hmacSource .= $this->splitRule;

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

        $hmacSource .= $this->authCode;
        $hmacSource .= $this->openId;

        if (!empty($this->receiver)) {
            $receiver = $this->receiver;
            if (!is_array($receiver)) {
                $receiver = is_object($receiver) ? (array)$receiver : json_decode($this->receiver, true);
            }
            if (isset($receiver['receiver'])) {
                $hmacSource .= $receiver['receiver'];
            }
            if (isset($receiver['phoneNum'])) {
                $hmacSource .= $receiver['phoneNum'];
            }
            if (isset($receiver['address'])) {
                $hmacSource .= $receiver['address'];
            }
        }
        return $this->encipher($hmacSource, ConfigurationUtils::getInstance()->getHmacKey($this->merchantId));
    }


} 