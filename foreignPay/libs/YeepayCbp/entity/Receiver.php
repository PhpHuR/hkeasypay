<?php
/**
 * Created by PhpStorm.
 * User: yp-tc-7044
 * Date: 2017/10/16
 * Time: 下午6:32
 */

namespace YeepayCbp\entity;


class Receiver extends AbstractModel
{
    /**
     * 收货人名称
     * @var
     */
    public $receiver;
    /**
     * 手机号码
     * @var
     */
    public $phoneNum;
    /**
     * 收货人地址
     * @var
     */
    public $address;

    /**
     * @return mixed
     */
    public function getReceiver()
    {
        return $this->receiver;
    }

    /**
     * @param mixed $receiver
     */
    public function setReceiver($receiver)
    {
        $this->receiver = $receiver;
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
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * @param mixed $address
     */
    public function setAddress($address)
    {
        $this->address = $address;
        return $this;
    }

}