<?php
/**
 * Created by PhpStorm.
 * User: yp-tc-7044
 * Date: 2017/10/23
 * Time: 上午9:16
 */

namespace YeepayCbp\entity;


class DetailList extends AbstractModel
{
    /**
     * 商品金额
     * @var
     */
    public $amount;
    /**
     * 付款人
     * @var
     */
    public $name;
    /**
     * 证件类型
     * @var
     */
    public $idType;
    /**
     * 证件号码
     * @var
     */
    public $idNum;
    /**
     * 银行卡号
     * @var
     */
    public $bankCardNum;
    /**
     * 手机号
     * @var
     */
    public $phoneNum;
    /**
     * 购汇用途
     * @var
     */
    public $forUse;

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
    public function getName()
    {
        return $this->name;
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
    public function getIdType()
    {
        return $this->idType;
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
    public function getIdNum()
    {
        return $this->idNum;
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
    public function getBankCardNum()
    {
        return $this->bankCardNum;
    }

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
    public function getPhoneNum()
    {
        return $this->phoneNum;
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


}