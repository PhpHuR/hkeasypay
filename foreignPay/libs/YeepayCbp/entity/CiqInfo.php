<?php
/**
 * Created by PhpStorm.
 * User: yp-tc-7044
 * Date: 2017/10/3
 * Time: 下午4:28
 */

namespace YeepayCbp\entity;


class CiqInfo extends AbstractModel
{
    /**
     * 申报国检
     */
    public $ciqChannel;

    /**
     * 备案号
     */
    public $commerceCode;

    /**
     * 备案名称
     */
    public $commerceName;

    /**
     * 国检组织代码
     */
    public $ciqCode;

    /**
     * 申报金额
     */
    public $amount;

    /**
     * 附加信息
     * @var
     */
    public $ciqJson;

    /**
     * 状态
     */
    public $status;

    /**
     * 订单号
     * @var
     */
    public $orderId;

    /**
     * @return mixed
     */
    public function getCiqChannel()
    {
        return $this->ciqChannel;
    }

    /**
     * @param mixed $ciqChannel
     */
    public function setCiqChannel($ciqChannel)
    {
        $this->ciqChannel = $ciqChannel;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCommerceCode()
    {
        return $this->commerceCode;
    }

    /**
     * @param mixed $commerceCode
     */
    public function setCommerceCode($commerceCode)
    {
        $this->commerceCode = $commerceCode;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCommerceName()
    {
        return $this->commerceName;
    }

    /**
     * @param mixed $commerceName
     */
    public function setCommerceName($commerceName)
    {
        $this->commerceName = $commerceName;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCiqCode()
    {
        return $this->ciqCode;
    }

    /**
     * @param mixed $ciqCode
     */
    public function setCiqCode($ciqCode)
    {
        $this->ciqCode = $ciqCode;
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
    public function getCiqJson()
    {
        return $this->ciqJson;
    }

    /**
     * @param mixed $ciqJson
     */
    public function setCiqJson($ciqJson)
    {
        $this->ciqJson = $ciqJson;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param mixed $status
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getOrderId()
    {
        return $this->orderId;
    }

    /**
     * @param mixed $orderId
     */
    public function setOrderId($orderId)
    {
        $this->orderId = $orderId;
        return $this;
    }

}