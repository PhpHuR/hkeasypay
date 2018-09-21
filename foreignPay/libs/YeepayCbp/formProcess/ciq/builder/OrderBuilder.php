<?php
/**
 * Created by PhpStorm.
 * User: yp-tc-7044
 * Date: 2017/10/3
 * Time: 下午4:08
 */

namespace YeepayCbp\formProcess\ciq\builder;

use YeepayCbp\entity\Payer;
use YeepayCbp\exception\NullPointerException;
use YeepayCbp\formProcess\Process;
use YeepayCbp\utils\ConfigurationUtils;

class OrderBuilder extends Process
{
    protected $merchantId;
    //支付流水号
    protected $paySerialNumber;
    protected $notifyUrl;
    /**
     * @var Payer
     */
    protected $payer;
    protected $ciqInfos;

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
    public function getCiqInfos()
    {
        return $this->ciqInfos;
    }

    /**
     * @param mixed $ciqInfos
     */
    public function setCiqInfos($ciqInfos)
    {
        $this->ciqInfos = $ciqInfos;
        return $this;
    }


    public function builder($params)
    {
        if (empty($this->merchantId)) {
            throw new NullPointerException('merchantId is null');
        }
        if (empty($this->paySerialNumber)) {
            throw new NullPointerException('paySerialNumbe is null');
        }
        if (empty($this->notifyUrl)) {
            throw new NullPointerException('notifyUrl is null');
        }
        if (empty($this->ciqInfos)) {
            throw new NullPointerException('ciqInfos is null');
        }

        return  $this->buildJson();
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
                if (is_object($payer)) {
                    $payer = (array)$payer;
                } else {
                    $payer = json_decode($this->payer, true);
                }
            }
            if (isset($payer['payerName'])) {
                $hmacSource .= $payer['payerName'];
            }
            if (isset($payer['idNum'])) {
                $hmacSource .= $payer['idNum'];
            }
            if (isset($payer['phoneNum'])) {
                $hmacSource .= $payer['phoneNum'];
            }
        }

        if (!empty($this->ciqInfos)) {
            $ciqInfos = $this->ciqInfos;
            if (!is_array($ciqInfos)) {
                $ciqInfos = (array)$ciqInfos;
            }
            foreach ($ciqInfos as $ciqInfo) {
                if (!is_array($ciqInfo)) {
                    $ciqInfo = is_object($ciqInfo) ? (array)$ciqInfo : json_decode($ciqInfo, true);
                }
                if (isset($ciqInfo['ciqChannel'])) {
                    $hmacSource .= $ciqInfo['ciqChannel'];
                }
                if (isset($ciqInfo['ciqCode'])) {
                    $hmacSource .= $ciqInfo['ciqCode'];
                }
                if (isset($ciqInfo['amount'])) {
                    $hmacSource .= $ciqInfo['amount'];
                }
                if (isset($ciqInfo['commerceCode'])) {
                    $hmacSource .= $ciqInfo['commerceCode'];
                }
                if (isset($ciqInfo['commerceName'])) {
                    $hmacSource .= $ciqInfo['commerceName'];
                }
                if (isset($ciqInfo['ciqJson'])) {
                    $hmacSource .= $ciqInfo['ciqJson'];
                }
            }
        }
        return $this->encipher($hmacSource, ConfigurationUtils::getInstance()->getHmacKey($this->merchantId));
    }
}