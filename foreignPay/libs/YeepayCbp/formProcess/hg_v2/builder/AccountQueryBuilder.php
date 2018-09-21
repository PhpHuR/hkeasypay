<?php
/**
 * 账户余额查询
 * Created by PhpStorm.
 * User: yinquan.ma
 * Date: 2017/10/9
 * Time: 下午5:43
 */

namespace YeepayCbp\formProcess\hg_v2\builder;


use YeepayCbp\exception\NullPointerException;
use YeepayCbp\formProcess\Process;
use YeepayCbp\utils\ConfigurationUtils;

class AccountQueryBuilder extends Process
{

    /**
     * 商户编号
     * @var
     */
    protected $merchantId;
    /**
     * 会员id
     * @var
     */
    protected $memberId;

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
    public function getMemberId()
    {
        return $this->memberId;
    }

    /**
     * @param mixed $memberId
     */
    public function setMemberId($memberId)
    {
        $this->memberId = $memberId;
        return $this;
    }

    public function builder($params)
    {
        // TODO: Implement builder() method.
        if (empty($this->merchantId)) {
            throw new NullPointerException('merchantId is empty');
        }
        if (empty($this->memberId)) {
            throw new NullPointerException('memberId is empty');
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
        $hmacSource .= $this->memberId;

        return $this->encipher($hmacSource,ConfigurationUtils::getInstance()->getHmacKey($this->merchantId));
    }
}