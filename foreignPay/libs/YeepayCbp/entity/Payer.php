<?php
/**
 * 
 *  
 * PHP Version 5
 *
 * @category  Class
 * @file      Payer.php
 * @package yeepayCbp\entity
 * @author    chao.ma <chao.ma@ehking.com>

 */

namespace YeepayCbp\entity;


class Payer extends AbstractModel{

    /**
     * 付款人
     */
    public $name;

    public $payerName;

    /**
     * 证件类型
     */
    public $idType;

    /**
     * 证件号码
     */
    public $idNum;

    /**
     * 商户会员id
     * @var
     */
    public $customerId;

    /**
     * 银行卡号
     */
    public $bankCardNum;

    /**
     * 电话
     */
    public $phoneNum;

    /**
     * 邮箱
     */
    public $email;

    /**
     * 国籍
     */
    public $nationality;


    /**
     * 支付方式编码
     * @var
     */
    public $paymentModeCode;

    /**
     * @param mixed $bankCardNum
     */
    public function setBankCardNum($bankCardNum)
    {
        $this->bankCardNum = $bankCardNum;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBankCardNum()
    {
        return $this->bankCardNum;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $idNum
     */
    public function setIdNum($idNum)
    {
        $this->idNum = $idNum;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getIdNum()
    {
        return $this->idNum;
    }

    /**
     * @param mixed $idType
     */
    public function setIdType($idType)
    {
        $this->idType = $idType;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getIdType()
    {
        return $this->idType;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getPayerName()
    {
        return $this->payerName;
    }

    /**
     * @param mixed $payerName
     */
    public function setPayerName($payerName)
    {
        $this->payerName = $payerName;
        return $this;
    }


    /**
     * @return mixed
     */
    public function getCustomerId()
    {
        return $this->customerId;
    }

    /**
     * @param mixed $customerId
     */
    public function setCustomerId($customerId)
    {
        $this->customerId = $customerId;
        return $this;
    }

    /**
     * @param mixed $nationality
     */
    public function setNationality($nationality)
    {
        $this->nationality = $nationality;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNationality()
    {
        return $this->nationality;
    }

    /**
     * @param mixed $phoneNum
     */
    public function setPhoneNum($phoneNum)
    {
        $this->phoneNum = $phoneNum;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPhoneNum()
    {
        return $this->phoneNum;
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
    public function getPaymentModeCode()
    {
        return $this->paymentModeCode;
    }



} 