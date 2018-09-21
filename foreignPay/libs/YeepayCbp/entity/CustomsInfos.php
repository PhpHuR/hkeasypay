<?php
/**
 * Created by PhpStorm.
 * User: yinquan.ma
 * Date: 2017/10/9
 * Time: 下午4:28
 */

namespace YeepayCbp\entity;


class CustomsInfos extends AbstractModel
{
    /**
     * 报关金额
     * @var
     */
    public $amount;

    /**
     * 报关通道
     * @var
     */
    public $customsChannel;

    /**
     * 备案号
     */
    public $commerceCode;

    /**
     * 备案名称
     */
    public $commerceName;
    /**
     * 支付运费
     * @var
     */
    public $freight;

    /**
     * 保费
     * @var
     */
    public $insuredAmount;
    /**
     * 支付货款
     * @var
     */
    public $goodsAmount;

    /**
     * 企业备案号
     * @var
     */
    public $merchantCommerceCode;

    /**
     * 企业备案名称
     * @var
     */
    public $merchantCommerceName;

    /**
     * 支付税款
     * @var
     */
    public $tax;

    /**
     * 仓
     * @var
     */
    public $storeHouse;

    /**
     * 主管海关代码
     * @var
     */
    public $customsCode;

    /**
     * 检验检疫机构 代码
     * @var
     */
    public $ciqCode;

    /**
     * 业务类型
     * @var
     */
    public $functionCode;

    /**
     * 业务类型
     * @var
     */
    public $businessType;

    public $dxpid;

    /**
     * 额外的json字符串
     * @var
     */
    public $jsonInfo;

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
    public function getCustomsChannel()
    {
        return $this->customsChannel;
    }

    /**
     * @param mixed $customsChannel
     */
    public function setCustomsChannel($customsChannel)
    {
        $this->customsChannel = $customsChannel;
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
    public function getFreight()
    {
        return $this->freight;
    }

    /**
     * @param mixed $freight
     */
    public function setFreight($freight)
    {
        $this->freight = $freight;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getInsuredAmount()
    {
        return $this->insuredAmount;
    }

    /**
     * @param mixed $insuredAmount
     */
    public function setInsuredAmount($insuredAmount)
    {
        $this->insuredAmount = $insuredAmount;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getGoodsAmount()
    {
        return $this->goodsAmount;
    }

    /**
     * @param mixed $goodsAmount
     */
    public function setGoodsAmount($goodsAmount)
    {
        $this->goodsAmount = $goodsAmount;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMerchantCommerceCode()
    {
        return $this->merchantCommerceCode;
    }

    /**
     * @param mixed $merchantCommerceCode
     */
    public function setMerchantCommerceCode($merchantCommerceCode)
    {
        $this->merchantCommerceCode = $merchantCommerceCode;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMerchantCommerceName()
    {
        return $this->merchantCommerceName;
    }

    /**
     * @param mixed $merchantCommerceName
     */
    public function setMerchantCommerceName($merchantCommerceName)
    {
        $this->merchantCommerceName = $merchantCommerceName;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTax()
    {
        return $this->tax;
    }

    /**
     * @param mixed $tax
     */
    public function setTax($tax)
    {
        $this->tax = $tax;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getStoreHouse()
    {
        return $this->storeHouse;
    }

    /**
     * @param mixed $storeHouse
     */
    public function setStoreHouse($storeHouse)
    {
        $this->storeHouse = $storeHouse;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCustomsCode()
    {
        return $this->customsCode;
    }

    /**
     * @param mixed $customsCode
     */
    public function setCustomsCode($customsCode)
    {
        $this->customsCode = $customsCode;
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
    public function getFunctionCode()
    {
        return $this->functionCode;
    }

    /**
     * @param mixed $functionCode
     */
    public function setFunctionCode($functionCode)
    {
        $this->functionCode = $functionCode;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBusinessType()
    {
        return $this->businessType;
    }

    /**
     * @param mixed $businessType
     */
    public function setBusinessType($businessType)
    {
        $this->businessType = $businessType;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDxpid()
    {
        return $this->dxpid;
    }

    /**
     * @param mixed $dxpid
     */
    public function setDxpid($dxpid)
    {
        $this->dxpid = $dxpid;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getJsonInfo()
    {
        return $this->jsonInfo;
    }

    /**
     * @param mixed $jsonInfo
     */
    public function setJsonInfo($jsonInfo)
    {
        $this->jsonInfo = $jsonInfo;
        return $this;
    }

}