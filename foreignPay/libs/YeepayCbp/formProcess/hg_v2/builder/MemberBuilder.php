<?php
/**
 * 创建账户
 * Created by PhpStorm.
 * User: yinquan.ma
 * Date: 2017/10/8
 * Time: 下午5:38
 */

namespace YeepayCbp\formProcess\hg_v2\builder;


use YeepayCbp\exception\NullPointerException;
use YeepayCbp\formProcess\Process;
use YeepayCbp\utils\ConfigurationUtils;

class MemberBuilder extends Process
{
    /**
     * 商户编号
     * @var
     */
    protected $merchantId;
    /**
     * 手机号
     * @var
     */
    protected $mobile;
    /**
     * 邮箱
     * @var
     */
    protected $email;
    /**
     * 姓名
     * @var
     */
    protected $realname;
    /**
     * 身份证号
     * @var
     */
    protected $idNum;
    /**
     * 用户类型
     * @var
     */
    protected $userType;
    /**
     * 是否绑定扣款
     * @var
     */
    protected $bingPayment;
    /**
     * 账户类型
     * @var
     */
    protected $accountType;
    /**
     * 商户会员id
     * @var
     */
    protected $customerId;
    /**
     * 账户类型
     * @var
     */
    protected $accountHolder;
    /**
     * 商户名称
     * @var
     */
    protected $merchantName;
    /**
     * 公司域名
     * @var
     */
    protected $webSite;
    /**
     * 公司备案号
     * @var
     */
    protected $icp;
    /**
     * 公司相关证件照片rar压缩包
     * @var
     */
    protected $papers;

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
    public function getMobile()
    {
        return $this->mobile;
    }

    /**
     * @param mixed $mobile
     */
    public function setMobile($mobile)
    {
        $this->mobile = $mobile;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param mixed $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRealname()
    {
        return $this->realname;
    }

    /**
     * @param mixed $realname
     */
    public function setRealname($realname)
    {
        $this->realname = $realname;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getIdNum()
    {
        return $this->idNum;
    }

    /**
     * @param mixed $idNum
     */
    public function setIdNum($idNum)
    {
        $this->idNum = $idNum;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getUserType()
    {
        return $this->userType;
    }

    /**
     * @param mixed $userType
     */
    public function setUserType($userType)
    {
        $this->userType = $userType;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getBingPayment()
    {
        return $this->bingPayment;
    }

    /**
     * @param mixed $bingPayment
     */
    public function setBingPayment($bingPayment)
    {
        $this->bingPayment = $bingPayment;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAccountType()
    {
        return $this->accountType;
    }

    /**
     * @param mixed $accountType
     */
    public function setAccountType($accountType)
    {
        $this->accountType = $accountType;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCustomerId()
    {
        return $this->customerId;
    }

    /**
     * @param mixed $customerId
     */
    public function setCustomerId($customerId)
    {
        $this->customerId = $customerId;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAccountHolder()
    {
        return $this->accountHolder;
    }

    /**
     * @param mixed $accountHolder
     */
    public function setAccountHolder($accountHolder)
    {
        $this->accountHolder = $accountHolder;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMerchantName()
    {
        return $this->merchantName;
    }

    /**
     * @param mixed $merchantName
     */
    public function setMerchantName($merchantName)
    {
        $this->merchantName = $merchantName;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getWebSite()
    {
        return $this->webSite;
    }

    /**
     * @param mixed $webSite
     */
    public function setWebSite($webSite)
    {
        $this->webSite = $webSite;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getIcp()
    {
        return $this->icp;
    }

    /**
     * @param mixed $icp
     */
    public function setIcp($icp)
    {
        $this->icp = $icp;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPapers()
    {
        return $this->papers;
    }

    /**
     * @param mixed $papers
     */
    public function setPapers($papers)
    {
        $this->papers = $papers;
        return $this;
    }


    public function builder($params)
    {
        // TODO: Implement builder() method.
        if (empty($this->merchantId)) {
            throw new NullPointerException('merchantId is empty');
        }
        if (empty($this->mobile)) {
            throw new NullPointerException('mobile is empty');
        }
        if (empty($this->email)) {
            throw new NullPointerException('email is empty');
        }
        if (empty($this->realname)) {
            throw new NullPointerException('realname is empty');
        }
        if (empty($this->idNum)) {
            throw new NullPointerException('idNum is empty');
        }
        if (empty($this->userType)) {
            throw new NullPointerException('userType is empty');
        }
        if (empty($this->bingPayment)) {
            throw new NullPointerException('bingPayment is empty');
        }
        if (empty($this->accountType)) {
            throw new NullPointerException('accountType is empty');
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
        $hmacSource .= $this->mobile;
        $hmacSource .= $this->email;
        $hmacSource .= $this->realname;
        $hmacSource .= $this->idNum;
        $hmacSource .= $this->userType;
        $hmacSource .= $this->bingPayment;
        $hmacSource .= $this->accountType;
        $hmacSource .= $this->customerId;
        $hmacSource .= $this->accountHolder;
        $hmacSource .= $this->webSite;
        $hmacSource .= $this->icp;
        $hmacSource .= $this->papers;

        return $this->encipher($hmacSource, ConfigurationUtils::getInstance()->getHmacKey($this->merchantId));
    }
}