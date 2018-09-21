<?php
/**
 * Created by PhpStorm.
 * User: yp-tc-7044
 * Date: 2017/10/9
 * Time: 下午5:05
 */

namespace YeepayCbp\formProcess\hg\builder;


use YeepayCbp\exception\NullPointerException;
use YeepayCbp\formProcess\Process;
use YeepayCbp\utils\ConfigurationUtils;

class OrderBuilder extends Process
{

    protected $merchantId;

    protected $requestId;

    protected $orderAmount;

    /**
     * 订单币种
     * @var]
     */
    protected $orderCurrency;
    protected $notifyUrl;

    protected $remark;

    protected $productDetails;

    protected $payer;

    protected $customsInfos;

    protected $ciqInfos;

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
    public function getOrderAmount()
    {
        return $this->orderAmount;
    }

    /**
     * @param mixed $orderAmount
     */
    public function setOrderAmount($orderAmount)
    {
        $this->orderAmount = $orderAmount;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getOrderCurrency()
    {
        return $this->orderCurrency;
    }

    /**
     * @param mixed $orderCurrency
     */
    public function setOrderCurrency($orderCurrency)
    {
        $this->orderCurrency = $orderCurrency;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getNotifyUrl()
    {
        return $this->notifyUrl;
    }

    /**
     * @param mixed $notifyUrl
     */
    public function setNotifyUrl($notifyUrl)
    {
        $this->notifyUrl = $notifyUrl;
        return $this;
    }


    /**
     * @return mixed
     */
    public function getRemark()
    {
        return $this->remark;
    }

    /**
     * @param mixed $remark
     */
    public function setRemark($remark)
    {
        $this->remark = $remark;
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

    /**
     * @return mixed
     */
    public function getPayer()
    {
        return $this->payer;
    }

    /**
     * @param mixed $payer
     */
    public function setPayer($payer)
    {
        $this->payer = $payer;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCustomsInfos()
    {
        return $this->customsInfos;
    }

    /**
     * @param mixed $customsInfos
     */
    public function setCustomsInfos($customsInfos)
    {
        $this->customsInfos = $customsInfos;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCiqInfos()
    {
        return $this->ciqInfos;
    }

    /**
     * @param mixed $ciqInfos
     */
    public function setCiqInfos($ciqInfos)
    {
        $this->ciqInfos = $ciqInfos;
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
        if (empty($this->orderAmount)) {
            throw new NullPointerException('orderAmount is null');
        }
        if (empty($this->orderCurrency)) {
            throw new NullPointerException('orderCurrency is null');
        }
        if (empty($this->productDetails)) {
            throw new NullPointerException('productDetails is null');
        }
        if (empty($this->payer)) {
            throw new NullPointerException('payer is null');
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
        $hmacSource .= $this->orderAmount;
        $hmacSource .= $this->orderCurrency;
        $hmacSource .= $this->notifyUrl;
        $hmacSource .= $this->remark;

        $productDetails = $this->productDetails;
        if (!empty($productDetails)) {
            if (!is_array($productDetails)) {
                $productDetails = is_object($productDetails) ? (array)$productDetails : json_decode($productDetails, true);
            }
            foreach ($productDetails as $productDetail) {
                if (!is_array($productDetail)) {
                    $productDetail = is_object($productDetail) ? (array)$productDetail : json_decode($productDetail, true);
                }
                if (!empty($productDetail)) {
                    $hmacSource .= $productDetail['name'];
                    $hmacSource .= $productDetail['quantity'];
                    $hmacSource .= $productDetail['amount'];
                    $hmacSource .= $productDetail['receiver'];
                    $hmacSource .= $productDetail['description'];
                }
            }
        }

        if (!empty($this->payer)) {
            $payer = $this->payer;
            if (!is_array($payer)) {
                $payer = is_object($payer) ? (array)$payer : json_decode($this->payer, true);
            }
            if (isset($payer['name'])) {
                $hmacSource .= $payer['name'];
            }
            if (isset($payer['idType'])) {
                $hmacSource .= $payer['idType'];
            }
            if (isset($payer['idNum'])) {
                $hmacSource .= $payer['idNum'];
            }
            if (isset($payer['customerId'])) {
                $hmacSource .= $payer['customerId'];
            }
            if (isset($payer['bankCardNum'])) {
                $hmacSource .= $payer['bankCardNum'];
            }
            if (isset($payer['phoneNum'])) {
                $hmacSource .= $payer['phoneNum'];
            }
            if (isset($payer['email'])) {
                $hmacSource .= $payer['email'];
            }
            if (isset($payer['nationality'])) {
                $hmacSource .= $payer['nationality'];
            }
        }

        if (!empty($this->customsInfos)) {
            $customsInfos = $this->customsInfos;
            if (!is_array($customsInfos)) {
                $customsInfos = is_object($customsInfos) ? (array)$customsInfos : json_decode($customsInfos, true);
            }
            foreach ($customsInfos as $customsInfo) {
                if (!is_array($customsInfo)) {
                    $customsInfo = is_object($customsInfo) ? (array)$customsInfo : json_decode($customsInfo, true);
                }
                $hmacSource .= $customsInfo['customsChannel'];
                $hmacSource .= $customsInfo['amount'];
                $hmacSource .= $customsInfo['freight'];
                $hmacSource .= $customsInfo['goodsAmount'];
                $hmacSource .= $customsInfo['tax'];
                $hmacSource .= $customsInfo['insuredAmount'];
                if (isset($customsInfo['commerceCode'])) {
                    $hmacSource .= $customsInfo['commerceCode'];
                }
                if (isset($customsInfo['commerceName'])) {
                    $hmacSource .= $customsInfo['commerceName'];
                }
                if (isset($customsInfo['storeHouse'])) {
                    $hmacSource .= $customsInfo['storeHouse'];
                }
                if (isset($customsInfo['customsCode'])) {
                    $hmacSource .= $customsInfo['customsCode'];
                }
                if (isset($customsInfo['ciqCode'])) {
                    $hmacSource .= $customsInfo['ciqCode'];
                }
                if (isset($customsInfo['functionCode'])) {
                    $hmacSource .= $customsInfo['functionCode'];
                }
                if (isset($customsInfo['businessType'])) {
                    $hmacSource .= $customsInfo['businessType'];
                }
                if (isset($customsInfo['dxpid'])) {
                    $hmacSource .= $customsInfo['dxpid'];
                }
                if (isset($customsInfo['jsonInfo'])) {
                    $temp = $customsInfo['jsonInfo'];
                    if (!is_string($temp)) {
                        $temp = json_encode($temp);
                    }
                    $hmacSource .= $temp;
                }
            }
        }
//
//        if (!empty($this->ciqInfos)) {
//            $ciqInfo = $this->ciqInfos;
//            if (!is_array($ciqInfo)) {
//                $ciqInfo = is_object($ciqInfo) ? (array)$ciqInfo : json_decode($ciqInfo, true);
//            }
//            if (isset($ciqInfo['ciqChannel'])) {
//                $hmacSource .= $ciqInfo['ciqChannel'];
//            }
//            if (isset($ciqInfo['ciqCode'])) {
//                $hmacSource .= $ciqInfo['ciqCode'];
//            }
//            if (isset($ciqInfo['amount'])) {
//                $hmacSource .= $ciqInfo['amount'];
//            }
//            if (isset($ciqInfo['commerceCode'])) {
//                $hmacSource .= $ciqInfo['commerceCode'];
//            }
//            if (isset($ciqInfo['commerceName'])) {
//                $hmacSource .= $ciqInfo['commerceName'];
//            }
//            if (isset($ciqInfo['ciqJson'])) {
//                $hmacSource .= $ciqInfo['ciqJson'];
//            }
//        }
        return $this->encipher($hmacSource, ConfigurationUtils::getInstance()->getHmacKey($this->merchantId));
    }
}