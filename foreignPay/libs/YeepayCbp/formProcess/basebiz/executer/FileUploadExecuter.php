<?php
/**
 * Created by PhpStorm.
 * User: yp-tc-7044
 * Date: 2017/11/2
 * Time: 上午10:18
 */

namespace YeepayCbp\formProcess\basebiz\executer;


use YeepayCbp\formProcess\basebiz\builder\FileUploadBuilder;
use YeepayCbp\formProcess\Executer;
use YeepayCbp\responseHandle\basebizHandle\FileUploadHandle;
use YeepayCbp\utils\ConfigurationUtils;

class FileUploadExecuter extends Executer
{

    public function fileUploadExecuter (FileUploadBuilder $fileUploadBuilder,$params) {
        //1.创建请求数据json
        $dataParams = $fileUploadBuilder->builder($params);

        //2.执行请求
        return $this->execute(ConfigurationUtils::getInstance()->getFileUploadUrl(), $dataParams, new FileUploadHandle());
    }

    public function getExecuterClass($type)
    {
        // TODO: Implement getExecuterClass() method.
        switch ($type) {
            case 'upload':
                return $this->getExampleByClassName('YeepayCbp\formProcess\basebiz\builder\FileUploadBuilder');
                break;
            default:
                return null;
        }
    }
}