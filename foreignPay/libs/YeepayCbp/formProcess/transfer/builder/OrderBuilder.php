<?php
/**
 * Created by PhpStorm.
 * User: yp-tc-7044
 * Date: 2017/10/17
 * Time: 上午10:56
 */

namespace YeepayCbp\formProcess\transfer\builder;


use YeepayCbp\exception\NullPointerException;
use YeepayCbp\formProcess\Process;
use YeepayCbp\utils\ConfigurationUtils;

class OrderBuilder extends Process
{

    /**
     * 商户编号，非空
     * @var
     */
    protected $merchantId;
    /**
     * 订单号，非空
     * @var
     */
    protected $requestId;
    /**
     * 汇款金额，非空
     * @var
     */
    protected $amount;
    /**
     * currency
     * @var
     */
    protected $currency;
    /**
     * 预计到账币种，非空
     * @var
     */
    protected $creditedCurrency;
    /**
     * 汇款类型
     * @var
     */
    protected $transferMode;
    /**
     * 是否单账户
     * @var
     */
    protected $singleReceiveAccount;
    /**
     * 是否合并
     * @var
     */
    protected $isMerger;
    /**
     * 上传明细地址
     * @var
     */
    protected $detailPath;
    /**
     * 上传合同地址
     * @var
     */
    protected $contractPath;
    /**
     * 锁定牌价标识
     * @var
     */
    protected $listpriceToken;
    /**
     * 通知地址，非空
     * @var
     */
    protected $notifyUrl;
    /**
     * 回调地址
     * @var
     */
    protected $callbackUrl;
    /**
     * 汇款信息
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
    public function getCreditedCurrency()
    {
        return $this->creditedCurrency;
    }

    /**
     * @param mixed $creditedCurrency
     */
    public function setCreditedCurrency($creditedCurrency)
    {
        $this->creditedCurrency = $creditedCurrency;
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
    public function getSingleReceiveAccount()
    {
        return $this->singleReceiveAccount;
    }

    /**
     * @param mixed $singleReceiveAccount
     */
    public function setSingleReceiveAccount($singleReceiveAccount)
    {
        $this->singleReceiveAccount = $singleReceiveAccount;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getisMerger()
    {
        return $this->isMerger;
    }

    /**
     * @param mixed $isMerger
     */
    public function setIsMerger($isMerger)
    {
        $this->isMerger = $isMerger;
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
    public function getContractPath()
    {
        return $this->contractPath;
    }

    /**
     * @param mixed $contractPath
     */
    public function setContractPath($contractPath)
    {
        $this->contractPath = $contractPath;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getListpriceToken()
    {
        return $this->listpriceToken;
    }

    /**
     * @param mixed $listpriceToken
     */
    public function setListpriceToken($listpriceToken)
    {
        $this->listpriceToken = $listpriceToken;
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
        if (empty($this->creditedCurrency)) {
            throw new NullPointerException('creditedCurrency is null');
        }
        if (empty($this->notifyUrl)) {
            throw new NullPointerException('notifyUrl is null');
        }
        if (empty($this->callbackUrl)) {
            throw new NullPointerException('callbackUrl is null');
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
        $hmacSource .= $this->creditedCurrency;
        $hmacSource .= $this->transferMode;
        $hmacSource .= $this->singleReceiveAccount;
        $hmacSource .= $this->isMerger;
        $hmacSource .= $this->detailPath;
        $hmacSource .= $this->contractPath;
        $hmacSource .= $this->listpriceToken;
        $hmacSource .= $this->notifyUrl;
        $hmacSource .= $this->callbackUrl;

        if (!empty($this->payee)) {
            $payee = $this->payee;
            if (!is_array($payee)) {
                $payee = is_object($payee) ? (array)$payee : json_decode($payee, true);
            }
            if (isset($payee['recName'])) {
                $hmacSource .= $payee['recName'];
            }
            if (isset($payee['accountNumber'])) {
                $hmacSource .= $payee['accountNumber'];
            }
            if (isset($payee['recAddress'])) {
                $hmacSource .= $payee['recAddress'];
            }
            if (isset($payee['countryCode'])) {
                $hmacSource .= $payee['countryCode'];
            }
            if (isset($payee['ibanCode'])) {
                $hmacSource .= $payee['ibanCode'];
            }
            if (isset($payee['bankName'])) {
                $hmacSource .= $payee['bankName'];
            }
            if (isset($payee['swiftCode'])) {
                $hmacSource .= $payee['swiftCode'];
            }
            if (isset($payee['routingCode'])) {
                $hmacSource .= $payee['routingCode'];
            }
            if (isset($payee['bsbCode'])) {
                $hmacSource .= $payee['bsbCode'];
            }
            if (isset($payee['bankAddress'])) {
                $hmacSource .= $payee['bankAddress'];
            }
            if (isset($payee['postScript'])) {
                $hmacSource .= $payee['postScript'];
            }
            if (isset($payee['proxyBankAccountNumber'])) {
                $hmacSource .= $payee['proxyBankAccountNumber'];
            }
            if (isset($payee['proxyBankName'])) {
                $hmacSource .= $payee['proxyBankName'];
            }
            if (isset($payee['proxySwiftCode'])) {
                $hmacSource .= $payee['proxySwiftCode'];
            }
            if (isset($payee['proxyBankAddress'])) {
                $hmacSource .= $payee['proxyBankAddress'];
            }
        }
        return $this->encipher($hmacSource, ConfigurationUtils::getInstance()->getHmacKey($this->merchantId));
    }
}