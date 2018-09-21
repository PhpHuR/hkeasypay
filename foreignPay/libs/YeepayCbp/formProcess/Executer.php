<?php
/**
 * Created by PhpStorm.
 * User: yiqnuan.ma <yinquan.ma@yeepay.com>
 * Date: 2017/9/25
 * Time: 上午9:13
 */

namespace YeepayCbp\formProcess;


use YeepayCbp\exception\FactoryExecuterException;
use YeepayCbp\httpRequest\HttpInstance;
use YeepayCbp\responseHandle\ResponseTypeHandle;
use YeepayCbp\utils\FactoryUtils;

abstract class Executer
{

    /**
     * 请求方式执行器
     * @param $url
     * @param $param
     * @param ResponseTypeHandle|null $handle
     * @return mixed
     */
    public function execute($url, $param, ResponseTypeHandle $handle = null)
    {
        // 1.发送http请求
        $responseData = HttpInstance::getInstance()->httpRequestPost($url, $param);
        // 2.验签
        $handle->checkHmac($responseData);
        // 3.结果验证
        if ($handle !== null && $handle instanceof ResponseTypeHandle) {
            $responseData = $handle->handle($responseData);
        }
        return $responseData;
    }

    /**
     * 根据类名，创建相关类
     * @param $className
     * @return null|object
     */
    public function getExampleByClassName($className)
    {
        $obj = FactoryUtils::getObjectByClassName($className);
        if (is_null($obj)) {
            throw new FactoryExecuterException(['error_description' => 'Factory ReflectionClass error']);
        }
        return $obj;
    }

    //根据类型获取需要执行的实例
    public abstract function getExecuterClass($type);

}