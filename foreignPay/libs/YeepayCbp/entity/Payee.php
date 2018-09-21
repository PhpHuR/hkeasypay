<?php
/**
 * 收款人信息
 * Created by PhpStorm.
 * User: yinquan.ma
 * Date: 2017/10/8
 * Time: 下午5:39
 */

namespace YeepayCbp\entity;


class Payee extends AbstractModel
{
    /**
     * 收款人姓名
     * @var
     */
    public $name;

    /**
     * 银行卡号
     * @var
     */
    public $bankCardNum;

    /**
     * 银行名称
     * @var
     */
    public $bankName;

    /**
     * 支行名称
     * @var
     */
    public $branchBankName;

    /**
     * 省
     * @var
     */
    public $province;

    /**
     * 市
     * @var
     */
    public $city;

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
    public function getBranchBankName()
    {
        return $this->branchBankName;
    }

    /**
     * @param mixed $branchBankName
     */
    public function setBranchBankName($branchBankName)
    {
        $this->branchBankName = $branchBankName;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getProvince()
    {
        return $this->province;
    }

    /**
     * @param mixed $province
     */
    public function setProvince($province)
    {
        $this->province = $province;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * @param mixed $city
     */
    public function setCity($city)
    {
        $this->city = $city;
        return $this;
    }



}