<?php
/**
 * Created by PhpStorm.
 * User: yp-tc-7044
 * Date: 2017/10/17
 * Time: 下午3:23
 */

namespace YeepayCbp\formProcess\hg_v2\builder;


use YeepayCbp\exception\NullPointerException;
use YeepayCbp\formProcess\Process;
use YeepayCbp\utils\ConfigurationUtils;

class MemberQueryBuilder extends Process
{

    private $merchantId;
    private $memberId;

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
        $hmacSource .= trim($this->merchantId);
        $hmacSource .= trim($this->memberId);
        return $this->encipher($hmacSource,ConfigurationUtils::getInstance()->getHmacKey($this->merchantId));
    }
}