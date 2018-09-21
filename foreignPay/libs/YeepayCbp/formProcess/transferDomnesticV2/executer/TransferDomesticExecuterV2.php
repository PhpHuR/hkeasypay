<?php
/**
 * Created by PhpStorm.
 * User: yp-tc-7044
 * Date: 2017/10/18
 * Time: 上午10:51
 */
namespace YeepayCbp\formProcess\transferDomnesticV2\executer;

use YeepayCbp\formProcess\Executer;
use YeepayCbp\formProcess\transferDomnesticV2\builder\OrderBuilder;
use YeepayCbp\formProcess\transferDomnesticV2\builder\QueryBuilder;
use YeepayCbp\responseHandle\transferDomesticHandleV2\OrderHandle;
use YeepayCbp\responseHandle\transferDomesticHandleV2\QueryHandle;
use YeepayCbp\utils\ConfigurationUtils;

class TransferDomesticExecuterV2 extends Executer
{

    public function orderExcuter(OrderBuilder $orderBuilder, $params)
    {
        //1.创建请求数据json
        $dataParams = $orderBuilder->builder($params);
        //2.执行请求
        return $this->execute(ConfigurationUtils::getInstance()->getTransferDomesticOrderUrl_v2(), $dataParams, new OrderHandle());

    }

    public function queryExcuter(QueryBuilder $queryBuilder, $params)
    {
        //1.创建请求数据json
        $dataParams = $queryBuilder->builder($params);
        //2.执行请求
        return $this->execute(ConfigurationUtils::getInstance()->getTransferDomesticQueryUrl_v2(), $dataParams, new QueryHandle());

    }
    public function getExecuterClass($type)
    {
        // TODO: Implement getExecuterClass() method.
        switch ($type) {
            case 'order':
                return $this->getExampleByClassName('YeepayCbp\formProcess\transferDomnesticV2\builder\OrderBuilder');
                break;
            case 'query':
                return $this->getExampleByClassName('YeepayCbp\formProcess\transferDomnesticV2\builder\QueryBuilder');
                break;
            default:
                return null;
        }
    }
}