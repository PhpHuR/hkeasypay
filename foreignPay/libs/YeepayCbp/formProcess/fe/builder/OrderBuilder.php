<?php
/**
 * Created by PhpStorm.
 * User: yp-tc-7044
 * Date: 2017/10/23
 * Time: 上午9:14
 */

namespace YeepayCbp\formProcess\fe\builder;


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
     * 请求号
     * @var
     */
    protected $requestId;
    /**
     * 购汇金额
     * @var
     */
    protected $amount;
    /**
     * 购汇币种
     * @var
     */
    protected $currency;
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
     * 锁定牌价标识
     * @var
     */
    protected $listPriceToken;
    /**
     * 通知地址
     * @var
     */
    protected $notifyUrl;
    /**
     * 明细地址
     * @var
     */
    protected $detailPath;
    /**
     * 明细列表
     * @var
     */
    protected $detailList;

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
    public function getDetailList()
    {
        return $this->detailList;
    }

    /**
     * @param mixed $detailList
     */
    public function setDetailList($detailList)
    {
        $this->detailList = $detailList;
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
        if (empty($this->notifyUrl)) {
            throw new NullPointerException('notifyUrl is null');
        }
        if (!empty($this->detailList)) {
            $detailList = $this->detailList;
            if (!is_array($detailList)) {
                $detailList = is_object($detailList) ? (array)$detailList : json_decode($detailList, true);
            }
            if (!isset($detailList['amount']) || empty($detailList['amount'])) {
                throw new NullPointerException('detailList.amount is null');
            }
            if (!isset($detailList['name']) || empty($detailList['name'])) {
                throw new NullPointerException('detailList.name is null');
            }
            if (!isset($detailList['idType']) || empty($detailList['idType'])) {
                throw new NullPointerException('detailList.idType is null');
            }
            if (!isset($detailList['idNum']) || empty($detailList['idNum'])) {
                throw new NullPointerException('detailList.idNum is null');
            }
            if (!isset($detailList['bankCardNum']) || empty($detailList['bankCardNum'])) {
                throw new NullPointerException('detailList.bankCardNum is null');
            }
            if (!isset($detailList['phoneNum']) || empty($detailList['phoneNum'])) {
                throw new NullPointerException('detailList.phoneNum is null');
            }
            if (!isset($detailList['forUse']) || empty($detailList['forUse'])) {
                throw new NullPointerException('detailList.forUse is null');
            }
        }
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
        $hmacSource .= $this->orderAmount;
        $hmacSource .= $this->orderCurrency;
        $hmacSource .= $this->listPriceToken;
        $hmacSource .= $this->notifyUrl;
        $hmacSource .= $this->detailPath;

        if (!empty($this->detailList)) {
            $detailList = $this->detailList;
            if (!is_array($detailList)) {
                $detailList = is_object($detailList) ? (array)$detailList : json_decode($detailList, true);
            }
            if (isset($detailList['amount'])) {
                $hmacSource .= $detailList['amount'];
            }
            if (isset($detailList['name'])) {
                $hmacSource .= $detailList['name'];
            }
            if (isset($detailList['idType'])) {
                $hmacSource .= $detailList['idType'];
            }
            if (isset($detailList['idNum'])) {
                $hmacSource .= $detailList['idNum'];
            }
            if (isset($detailList['bankCardNum'])) {
                $hmacSource .= $detailList['bankCardNum'];
            }
            if (isset($detailList['phoneNum'])) {
                $hmacSource .= $detailList['phoneNum'];
            }
            if (isset($detailList['forUse'])) {
                $hmacSource .= $detailList['forUse'];
            }
        }
        return $this->encipher($hmacSource, ConfigurationUtils::getInstance()->getHmacKey($this->merchantId));
    }

}