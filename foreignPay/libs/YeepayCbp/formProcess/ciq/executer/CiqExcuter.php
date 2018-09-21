<?php
/**
 * Created by PhpStorm.
 * User: yp-tc-7044
 * Date: 2017/10/9
 * Time: 下午3:58
 */

namespace YeepayCbp\formProcess\ciq\executer;

use YeepayCbp\formProcess\ciq\builder\OrderBuilder;
use YeepayCbp\formProcess\ciq\builder\QueryBuilder;
use YeepayCbp\formProcess\Executer;
use YeepayCbp\responseHandle\ciqHandle\OrderHandle;
use YeepayCbp\responseHandle\ciqHandle\OrderNotifyResponse;
use YeepayCbp\responseHandle\ciqHandle\QueryHandle;
use YeepayCbp\utils\ConfigurationUtils;

class CiqExcuter extends Executer
{

    public function orderExecuter(OrderBuilder $orderBuilder, $params)
    {
        //1.创建请求数据json
        $dataParams = $orderBuilder->builder($params);

        //2.执行请求
        return $this->execute(ConfigurationUtils::getInstance()->getCiqOrderUrl_v1(), $dataParams, new OrderHandle());
    }

    public function queryExecuter(QueryBuilder $queryBuilder, $param)
    {
        $dataParams = $queryBuilder->builder($param);
        //2.执行请求
        return $this->execute(ConfigurationUtils::getInstance()->getCiqQueryUrl_v1(), $dataParams, new QueryHandle());
    }

    public function getExecuterClass($type)
    {
        // TODO: Implement getExecuterClass() method.
        switch ($type) {
            case 'order':
                return $this->getExampleByClassName('YeepayCbp\formProcess\ciq\builder\OrderBuilder');
                break;
            case 'query':
                return $this->getExampleByClassName('YeepayCbp\formProcess\ciq\builder\QueryBuilder');
                break;
            default:
                return null;
        }
    }
}