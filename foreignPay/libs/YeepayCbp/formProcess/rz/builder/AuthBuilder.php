<?php
/**
 * Created by PhpStorm.
 * User: yp-tc-7044
 * Date: 2017/10/17
 * Time: 上午9:34
 */

namespace YeepayCbp\formProcess\rz\builder;


use YeepayCbp\exception\NullPointerException;
use YeepayCbp\formProcess\Process;
use YeepayCbp\utils\ConfigurationUtils;

class AuthBuilder extends Process
{
    /**
     * 商家编号
     * @var
     */
    protected $merchantId;
    /**
     * 订单号
     * @var
     */
    protected $requestId;
    /**
     * 认证类型
     * @var
     */
    protected $authType;
    /**
     * 姓名
     * @var
     */
    protected $name;
    /**
     * 证件号码
     * @var
     */
    protected $idCardNum;
    /**
     * 银行卡号
     * @var
     */
    protected $bankCardNumber;
    /**
     * 银行卡预留手机号
     * @var
     */
    protected $phoneNumber;

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
    public function getAuthType()
    {
        return $this->authType;
    }

    /**
     * @param mixed $authType
     */
    public function setAuthType($authType)
    {
        $this->authType = $authType;
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
    public function getIdCardNum()
    {
        return $this->idCardNum;
    }

    /**
     * @param mixed $idCardNum
     */
    public function setIdCardNum($idCardNum)
    {
        $this->idCardNum = $idCardNum;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBankCardNumber()
    {
        return $this->bankCardNumber;
    }

    /**
     * @param mixed $bankCardNumber
     */
    public function setBankCardNumber($bankCardNumber)
    {
        $this->bankCardNumber = $bankCardNumber;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPhoneNumber()
    {
        return $this->phoneNumber;
    }

    /**
     * @param mixed $phoneNumber
     */
    public function setPhoneNumber($phoneNumber)
    {
        $this->phoneNumber = $phoneNumber;
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
        if (empty($this->authType)) {
            throw new NullPointerException('authType is null');
        }
        if (empty($this->name)) {
            throw new NullPointerException('name is null');
        }
        if (empty($this->idCardNum)) {
            throw new NullPointerException('idCardNum is null');
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
        $hmacSource .= $this->authType;
        $hmacSource .= $this->name;
        $hmacSource .= $this->idCardNum;
        $hmacSource .= $this->bankCardNumber;
        $hmacSource .= $this->phoneNumber;
        return $this->encipher($hmacSource, ConfigurationUtils::getInstance()->getHmacKey($this->merchantId));
    }
}