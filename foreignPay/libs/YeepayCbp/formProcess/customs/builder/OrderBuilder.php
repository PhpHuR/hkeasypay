<?php
/**
 * Created by PhpStorm.
 * User: yp-tc-7044
 * Date: 2017/10/9
 * Time: 下午4:19
 */

namespace YeepayCbp\formProcess\customs\builder;


use YeepayCbp\exception\NullPointerException;
use YeepayCbp\formProcess\Process;
use YeepayCbp\utils\ConfigurationUtils;

class OrderBuilder extends Process
{
    protected $merchantId;

    /**
     * 支付流水号
     * @var
     */
    protected $paySerialNumber;

    protected $notifyUrl;

    /**
     * 付款人信息
     * @var
     */
    protected $payer;

    /**
     * 报关信息
     * @var
     */
    protected $customsInfos;

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
    public function getPaySerialNumber()
    {
        return $this->paySerialNumber;
    }

    /**
     * @param mixed $paySerialNumber
     */
    public function setPaySerialNumber($paySerialNumber)
    {
        $this->paySerialNumber = $paySerialNumber;
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
    public function getPayer()
    {
        return $this->payer;
    }

    /**
     * @param mixed $payer
     */
    public function setPayer($payer)
    {
        $this->payer = $payer;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCustomsInfos()
    {
        return $this->customsInfos;
    }

    /**
     * @param mixed $customsInfos
     */
    public function setCustomsInfos($customsInfos)
    {
        $this->customsInfos = $customsInfos;
        return $this;
    }


    public function builder($params)
    {
        // TODO: Implement builder() method.
        if (empty($this->merchantId)) {
            throw new NullPointerException('merchantId is null');
        }
        if (empty($this->paySerialNumber)) {
            throw new NullPointerException('paySerialNumber is null');
        }
        if (empty($this->notifyUrl)) {
            throw new NullPointerException('notifyUrl is null');
        }
        if (empty($this->payer)) {
            throw new NullPointerException('payer is null');
        }
        if (empty($this->customsInfos)) {
            throw new NullPointerException('customsInfos is null');
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
        $hmacSource .= $this->paySerialNumber;
        $hmacSource .= $this->notifyUrl;

        if (!empty($this->payer)) {
            $payer = $this->payer;
            if (!is_array($payer)) {
                $payer = is_object($payer) ? (array)$payer : json_decode($this->payer, true);
            }
            if (isset($payer['payerName'])) {
                $hmacSource .= $payer['payerName'];
            }
            if ($payer['idNum']) {
                $hmacSource .= $payer['idNum'];
            }
            if (isset($payer['phoneNum'])) {
                $hmacSource .= $payer['phoneNum'];
            }
        }

        if (!empty($this->customsInfos)) {
            $customsInfos = $this->customsInfos;
            if (!is_array($customsInfos)) {
                $customsInfos = is_object($customsInfos) ? (array)$customsInfos : json_decode($customsInfos, true);
            }
            foreach ($customsInfos as $customsInfo) {
                if (!is_array($customsInfo)) {
                    $customsInfo = is_object($customsInfo) ? (array)$customsInfo : json_decode($customsInfo, true);
                }
                if (isset($customsInfo['customsChannel'])) {
                    $hmacSource .= $customsInfo['customsChannel'];
                }
                if (isset($customsInfo['amount'])) {
                    $hmacSource .= $customsInfo['amount'];
                }
                if (isset( $customsInfo['freight'])) {
                    $hmacSource .= $customsInfo['freight'];
                }
                if (isset($customsInfo['goodsAmount'])) {
                    $hmacSource .= $customsInfo['goodsAmount'];
                }
                if (isset($customsInfo['tax'])) {
                    $hmacSource .= $customsInfo['tax'];
                }
                if (isset($customsInfo['insuredAmount'])) {
                    $hmacSource .= $customsInfo['insuredAmount'];
                }
                if (isset($customsInfo['merchantCommerceName'])) {
                    $hmacSource .= $customsInfo['merchantCommerceName'];
                }
                if (isset($customsInfo['merchantCommerceCode'])) {
                    $hmacSource .= $customsInfo['merchantCommerceCode'];
                }
                if (isset($customsInfo['storeHouse'])) {
                    $hmacSource .= $customsInfo['storeHouse'];
                }
                if (isset($customsInfo['customsCode'])) {
                    $hmacSource .= $customsInfo['customsCode'];
                }
                if (isset($customsInfo['ciqCode'])) {
                    $hmacSource .= $customsInfo['ciqCode'];
                }
                if (isset( $customsInfo['functionCode'])) {
                    $hmacSource .= $customsInfo['functionCode'];
                }
                if (isset($customsInfo['businessType'])) {
                    $hmacSource .= $customsInfo['businessType'];
                }
                if (isset($customsInfo['dxpid'])) {
                    $hmacSource .= $customsInfo['dxpid'];
                }
            }
        }
        return $this->encipher($hmacSource, ConfigurationUtils::getInstance()->getHmacKey($this->merchantId));
    }
}