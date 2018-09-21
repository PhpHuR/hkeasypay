<?php
/**
 * Created by PhpStorm.
 * User: yp-tc-7044
 * Date: 2017/10/17
 * Time: 下午6:46
 */

namespace YeepayCbp\entity;


class SplitRecord extends AbstractModel
{
    public $merchantMark;

    public $merchantInfo;

    /**
     *分账金额
     * @var
     */
    public $splitAmount;

    /**
     *
     * @var
     */
    public $splitRemark;

    /**
     * @return mixed
     */
    public function getMerchantMark()
    {
        return $this->merchantMark;
    }

    /**
     * @param mixed $merchantMark
     */
    public function setMerchantMark($merchantMark)
    {
        $this->merchantMark = $merchantMark;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMerchantInfo()
    {
        return $this->merchantInfo;
    }

    /**
     * @param mixed $merchantInfo
     */
    public function setMerchantInfo($merchantInfo)
    {
        $this->merchantInfo = $merchantInfo;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSplitAmount()
    {
        return $this->splitAmount;
    }

    /**
     * @param mixed $splitAmount
     */
    public function setSplitAmount($splitAmount)
    {
        $this->splitAmount = $splitAmount;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSplitRemark()
    {
        return $this->splitRemark;
    }

    /**
     * @param mixed $splitRemark
     */
    public function setSplitRemark($splitRemark)
    {
        $this->splitRemark = $splitRemark;
        return $this;
    }


}