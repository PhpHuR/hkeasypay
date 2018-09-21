<?php
/**
 * Created by PhpStorm.
 * User: yp-tc-7044
 * Date: 2017/11/2
 * Time: 上午10:17
 */

namespace YeepayCbp\formProcess\basebiz\builder;

use YeepayCbp\exception\NullPointerException;
use YeepayCbp\formProcess\Process;
use YeepayCbp\utils\ConfigurationUtils;

class FileUploadBuilder extends Process
{

    /**
     * 商户编号
     * @var
     */
    protected $merchantId;
    /**
     * 文件类型
     * @var
     */
    protected $fileType;
    /**
     * 文件名称
     * @var
     */
    protected $fileName;
    /**
     * 文件内容,20 兆，二进制数组
     * @var array
     */
    private $content = array();

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
    public function getFileType()
    {
        return $this->fileType;
    }

    /**
     * @param mixed $fileType
     */
    public function setFileType($fileType)
    {
        $this->fileType = $fileType;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFileName()
    {
        return $this->fileName;
    }

    /**
     * @param mixed $fileName
     */
    public function setFileName($fileName)
    {
        $this->fileName = $fileName;
        return $this;
    }

    /**
     * @return array
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param array $content
     */
    public function setContent($content)
    {
        $this->content = $content;
        return $this;
    }


    public function builder($params)
    {
        // TODO: Implement builder() method.
        if (empty($this->merchantId)) {
            throw new NullPointerException('merchantId is null');
        }
        if (empty($this->fileType)) {
            throw new NullPointerException('fileType is null');
        } else {
            $type = ['DETAIL','CONTRACT','VOUCHER'];
            if (!in_array($this->fileType,$type)) {
                throw new NullPointerException('fileType error,check it.');
            }
        }
        if (empty($this->fileName)) {
            throw new NullPointerException('fileName is null');
        }
        if (empty($this->content)) {
            throw new NullPointerException('content is null');
        }
        $returnParams = $this->buildJson();
        if (!is_array($returnParams)) {
            $returnParams = json_decode($returnParams,true);
        }
        $returnParams['content'] = $this->content;
        return json_encode($returnParams);
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
        $hmacSource .= $this->fileName;
        $hmacSource .= $this->fileType;
        return $this->encipher($hmacSource,ConfigurationUtils::getInstance()->getHmacKey($this->merchantId));

    }
}