<?php
/**
 * Created by PhpStorm.
 * User: yp-tc-7044
 * Date: 2017/10/9
 * Time: 下午4:14
 */
namespace YeepayCbp\formProcess\customs\executer;

use YeepayCbp\formProcess\customs\builder\OrderBuilder;
use YeepayCbp\formProcess\customs\builder\QueryBuilder;
use YeepayCbp\formProcess\Executer;
use YeepayCbp\responseHandle\customsHandle\OrderHandle;
use YeepayCbp\responseHandle\customsHandle\QueryHandle;
use YeepayCbp\utils\ConfigurationUtils;

class CustomsExcuter extends Executer
{

    public function orderExecuter(OrderBuilder $orderBuilder, $params)
    {
        //1.创建请求数据json
        $dataParams = $orderBuilder->builder($params);
        //2.执行请求
        return $this->execute(ConfigurationUtils::getInstance()->getCustomsOrderUrl_v1(),$dataParams,new OrderHandle());
    }

    public function queryExecuter(QueryBuilder $queryBuilder, $param)
    {
        $dataParams = $queryBuilder->builder($param);

        //2.执行请求
        return $this->execute(ConfigurationUtils::getInstance()->getCustomsQueryUrl_v1(), $dataParams, new QueryHandle());
    }

    public function getExecuterClass($type)
    {
        // TODO: Implement getExecuterClass() method.
        switch ($type) {
            case 'order':
                return $this->getExampleByClassName('YeepayCbp\formProcess\customs\builder\OrderBuilder');
                break;
            case 'query':
                return $this->getExampleByClassName('YeepayCbp\formProcess\customs\builder\QueryBuilder');
                break;
            default:
                return null;
        }
    }
}