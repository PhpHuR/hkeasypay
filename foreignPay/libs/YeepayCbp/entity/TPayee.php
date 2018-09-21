<?php
/**
 * Created by PhpStorm.
 * User: yp-tc-7044
 * Date: 2017/10/17
 * Time: 上午11:02
 */

namespace YeepayCbp\entity;


class TPayee extends AbstractModel
{
    /**
     * 收款方姓名，非空
     * @var
     */
    public $recName;
    /**
     * 收款方账号，非空
     * @var
     */
    public $accountNumber;
    /**
     * 收款方地址
     * @var
     */
    public $recAddress;
    /**
     * 收款方常驻国家代码，非空
     * @var
     */
    public $countryCode;
    /**
     * IBAN
     * @var
     */
    public $ibanCode;
    /**
     * 收款行名称，非空
     * @var
     */
    public $bankName;
    /**
     * 收款行 SWIFT
     * @var
     */
    public $swiftCode;
    /**
     * Routing Number
     * @var
     */
    public $routingCode;
    /**
     * BSB Numbe
     * @var
     */
    public $bsbCode;
    /**
     * 收款行地址
     * @var
     */
    public $bankAddress;
    /**
     * 汇款附言
     * @var
     */
    public $postScript;
    /**
     * 收款行之代理行名称
     * @var
     */
    public $proxyBankAccountNumber;
    /**
     * 收款行之代理行名称
     * @var
     */
    public $proxyBankName;
    /**
     * 收款行之代理行 SWIFT
     * @var
     */
    public $proxySwiftCode;
    /**
     * 收款行之代理行地址
     * @var
     */
    public $proxyBankAddress;

    /**
     * @return mixed
     */
    public function getRecName()
    {
        return $this->recName;
    }

    /**
     * @param mixed $recName
     */
    public function setRecName($recName)
    {
        $this->recName = $recName;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAccountNumber()
    {
        return $this->accountNumber;
    }

    /**
     * @param mixed $accountNumber
     */
    public function setAccountNumber($accountNumber)
    {
        $this->accountNumber = $accountNumber;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRecAddress()
    {
        return $this->recAddress;
    }

    /**
     * @param mixed $recAddress
     */
    public function setRecAddress($recAddress)
    {
        $this->recAddress = $recAddress;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCountryCode()
    {
        return $this->countryCode;
    }

    /**
     * @param mixed $countryCode
     */
    public function setCountryCode($countryCode)
    {
        $this->countryCode = $countryCode;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getIbanCode()
    {
        return $this->ibanCode;
    }

    /**
     * @param mixed $ibanCode
     */
    public function setIbanCode($ibanCode)
    {
        $this->ibanCode = $ibanCode;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBankName()
    {
        return $this->bankName;
    }

    /**
     * @param mixed $bankName
     */
    public function setBankName($bankName)
    {
        $this->bankName = $bankName;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSwiftCode()
    {
        return $this->swiftCode;
    }

    /**
     * @param mixed $swiftCode
     */
    public function setSwiftCode($swiftCode)
    {
        $this->swiftCode = $swiftCode;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRoutingCode()
    {
        return $this->routingCode;
    }

    /**
     * @param mixed $routingCode
     */
    public function setRoutingCode($routingCode)
    {
        $this->routingCode = $routingCode;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBsbCode()
    {
        return $this->bsbCode;
    }

    /**
     * @param mixed $bsbCode
     */
    public function setBsbCode($bsbCode)
    {
        $this->bsbCode = $bsbCode;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBankAddress()
    {
        return $this->bankAddress;
    }

    /**
     * @param mixed $bankAddress
     */
    public function setBankAddress($bankAddress)
    {
        $this->bankAddress = $bankAddress;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPostScript()
    {
        return $this->postScript;
    }

    /**
     * @param mixed $postScript
     */
    public function setPostScript($postScript)
    {
        $this->postScript = $postScript;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getProxyBankAccountNumber()
    {
        return $this->proxyBankAccountNumber;
    }

    /**
     * @param mixed $proxyBankAccountNumber
     */
    public function setProxyBankAccountNumber($proxyBankAccountNumber)
    {
        $this->proxyBankAccountNumber = $proxyBankAccountNumber;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getProxyBankName()
    {
        return $this->proxyBankName;
    }

    /**
     * @param mixed $proxyBankName
     */
    public function setProxyBankName($proxyBankName)
    {
        $this->proxyBankName = $proxyBankName;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getProxySwiftCode()
    {
        return $this->proxySwiftCode;
    }

    /**
     * @param mixed $proxySwiftCode
     */
    public function setProxySwiftCode($proxySwiftCode)
    {
        $this->proxySwiftCode = $proxySwiftCode;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getProxyBankAddress()
    {
        return $this->proxyBankAddress;
    }

    /**
     * @param mixed $proxyBankAddress
     */
    public function setProxyBankAddress($proxyBankAddress)
    {
        $this->proxyBankAddress = $proxyBankAddress;
        return $this;
    }

}