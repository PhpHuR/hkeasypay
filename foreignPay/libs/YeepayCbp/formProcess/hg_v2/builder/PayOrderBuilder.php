<?php
/**
 * 支付业务
 * Created by PhpStorm.
 * User: yinquan.ma
 * Date: 2017/10/8
 * Time: 下午5:41
 */

namespace YeepayCbp\formProcess\hg_v2\builder;


use YeepayCbp\exception\NullPointerException;
use YeepayCbp\formProcess\Process;
use YeepayCbp\utils\ConfigurationUtils;

class PayOrderBuilder extends Process
{
    /**
     * 商户编号
     * @var
     */
    protected $merchantId;
    /**
     * 订单号
     * @var
     */
    protected $requestId;
    /**
     * 支付会员id
     * @var
     */
    protected $payerMember;
    /**
     * 转账金额
     * @var
     */
    protected $amount;
    /**
     * 转账币种
     * @var
     */
    protected $currency;
    /**
     * 商品信息
     * @var
     */
    protected $productDetails;

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
    public function getPayerMember()
    {
        return $this->payerMember;
    }

    /**
     * @param mixed $payerMember
     */
    public function setPayerMember($payerMember)
    {
        $this->payerMember = $payerMember;
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
    public function getProductDetails()
    {
        return $this->productDetails;
    }

    /**
     * @param mixed $productDetails
     */
    public function setProductDetails($productDetails)
    {
        $this->productDetails = $productDetails;
        return $this;
    }


    public function builder($params)
    {
        // TODO: Implement builder() method.
        if (empty($this->merchantId)) {
            throw new NullPointerException('merchantId is empty');
        }
        if (empty($this->requestId)) {
            throw new NullPointerException('requestId is empty');
        }
        if (empty($this->payerMember)) {
            throw new NullPointerException('payerMember is empty');
        }
        if (empty($this->amount)) {
            throw new NullPointerException('amount is empty');
        }
        if (empty($this->currency)) {
            throw new NullPointerException('currency is empty');
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
        $hmacSource .= $this->payerMember;
        $hmacSource .= $this->amount;
        $hmacSource .= $this->currency;
        if (!empty($this->productDetails)) {
            foreach ($this->productDetails as $productDetail) {
                if (!is_array($productDetail)) {
                    if (is_object($productDetail)) {
                        $productDetail = (array)$productDetail;
                    } else {
                        $productDetail = json_decode($productDetail, true);
                    }
                }
                if (isset($productDetail['name'])) {
                    $hmacSource .= $productDetail['name'];
                }
                if (isset($productDetail['quantity'])) {
                    $hmacSource .= $productDetail['quantity'];
                }
                if (isset($productDetail['amount'])) {
                    $hmacSource .= $productDetail['amount'];
                }
                if (isset($productDetail['receiver'])) {
                    $hmacSource .= $productDetail['receiver'];
                }
                if (isset($productDetail['description'])) {
                    $hmacSource .= $productDetail['description'];
                }
            }
        }
       return $this->encipher($hmacSource,ConfigurationUtils::getInstance()->getHmacKey($this->merchantId));
    }
}