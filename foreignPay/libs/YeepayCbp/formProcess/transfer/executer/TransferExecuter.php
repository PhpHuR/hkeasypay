<?php
/**
 * Created by PhpStorm.
 * User: yp-tc-7044
 * Date: 2017/10/18
 * Time: 上午10:47
 */

namespace YeepayCbp\formProcess\transfer\executer;


use YeepayCbp\formProcess\Executer;
use YeepayCbp\formProcess\transfer\builder\ListPriceLockBuilder;
use YeepayCbp\formProcess\transfer\builder\OrderBuilder;
use YeepayCbp\formProcess\transfer\builder\QueryBuilder;
use YeepayCbp\responseHandle\transferHandle\ListpriceLockHandle;
use YeepayCbp\responseHandle\transferHandle\OrderHanlde;
use YeepayCbp\responseHandle\transferHandle\QueryHandle;
use YeepayCbp\utils\ConfigurationUtils;

class TransferExecuter extends Executer
{
    /**
     * 下单
     * @param OrderBuilder $orderBuilder
     * @param $params
     * @return mixed
     */
    public function orderExecutrt(OrderBuilder $orderBuilder, $params)
    {
        //1.创建请求数据json
        $dataParams = $orderBuilder->builder($params);
        //2.执行请求
        return $this->execute(ConfigurationUtils::getInstance()->getTransferOrderUrl_v1(), $dataParams, new OrderHanlde());
    }

    /**
     * 订单查询
     * @param QueryBuilder $queryBuilder
     * @param $params
     * @return mixed
     */
    public function queryExecutrt(QueryBuilder $queryBuilder, $params)
    {
        //1.创建请求数据json
        $dataParams = $queryBuilder->builder($params);
        //2.执行请求
        return $this->execute(ConfigurationUtils::getInstance()->getTransferQueryUrl_v1(), $dataParams, new QueryHandle());
    }

    public function listPriceLockExecuter (ListPriceLockBuilder $listPriceLockBuilder,$params) {
        //1.创建请求数据json
        $dataParams = $listPriceLockBuilder->builder($params);
        //2.执行请求
        return $this->execute(ConfigurationUtils::getInstance()->getTransferListPriceLockUrl_v1(), $dataParams, new ListpriceLockHandle());
    }
    public function getExecuterClass($type)
    {
        // TODO: Implement getExecuterClass() method.
        switch ($type) {
            case 'order':
                return $this->getExampleByClassName('YeepayCbp\formProcess\transfer\builder\OrderBuilder');
                break;
            case 'query':
                return $this->getExampleByClassName('YeepayCbp\formProcess\transfer\builder\QueryBuilder');
                break;
            case 'listPrice':
                return $this->getExampleByClassName('YeepayCbp\formProcess\transfer\builder\ListPriceLockBuilder');
                break;
            default:
                return null;
        }
    }
}