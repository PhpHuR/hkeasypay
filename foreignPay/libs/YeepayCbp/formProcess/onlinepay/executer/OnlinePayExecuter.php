<?php
/**
 * Created by PhpStorm.
 * User: yp-tc-7044
 * Date: 2017/9/25
 * Time: 下午6:25
 */

namespace YeepayCbp\formProcess\onlinepay\executer;


use YeepayCbp\formProcess\Executer;
use YeepayCbp\formProcess\onlinepay\builder\OrderBuilder;
use YeepayCbp\formProcess\onlinepay\builder\QueryBuilder;
use YeepayCbp\formProcess\onlinepay\builder\RefundBuilder;
use YeepayCbp\formProcess\onlinepay\builder\RefundQueryBuilder;
use YeepayCbp\responseHandle\onlinepayHandle\OrderHandle;
use YeepayCbp\responseHandle\onlinepayHandle\QueryHandle;
use YeepayCbp\responseHandle\onlinepayHandle\RefundHandle;
use YeepayCbp\responseHandle\onlinepayHandle\RefundQueryHandle;
use YeepayCbp\utils\ConfigurationUtils;

class OnlinePayExecuter extends Executer
{
    /**
     * 下单
     * @param $param
     * @return mixed
     */
    public function orderExecuter(OrderBuilder $orderBuilder,$param)
    {
        //1.创建请求数据json
        $dataParams = $orderBuilder->builder($param);
//        dump($dataParams);
        //2.执行请求
        return $this->execute(ConfigurationUtils::getInstance()->getOnlinepayOrderUrl_v1(), $dataParams, new OrderHandle());
    }

    /**
     * 查询
     * @param $param
     * @return mixed
     */
    public function queryExecuter(QueryBuilder $queryBuilder,$params)
    {
        //1.创建请求数据json
        $dataParams = $queryBuilder->builder($params);
        //2.执行请求
        return $this->execute(ConfigurationUtils::getInstance()->getOnlinepayQueryUrl_v1(), $dataParams, new QueryHandle());
    }

    /**
     * 退款
     * @param $param
     * @return mixed
     */
    public function refundExecuter(RefundBuilder $refundBuilder,$params)
    {
        //1.创建请求数据json
        $dataParams = $refundBuilder->builder($params);
        //2.执行请求
        return $this->execute(ConfigurationUtils::getInstance()->getOnlinepayRefundUrl_v1(), $dataParams, new RefundHandle());
    }

    /**
     *  退款查询
     * @param $param
     * @return mixed
     */
    public function refundQueryExecuter(RefundQueryBuilder $refundQueryBuilder,$params)
    {
        //1.创建请求数据json
        $dataParams = $refundQueryBuilder->builder($params);
        return $this->execute(ConfigurationUtils::getInstance()->getOnlinepayRefundQueryUrl_v1(), $dataParams, new RefundQueryHandle());

    }

    public function getExecuterClass($type)
    {
        // TODO: Implement getExecuterClass() method.
        switch ($type) {
            case 'order':
                return $this->getExampleByClassName('YeepayCbp\formProcess\onlinepay\builder\OrderBuilder');
                break;
            case 'query':
                return $this->getExampleByClassName('YeepayCbp\formProcess\onlinepay\builder\QueryBuilder');
                break;
            case 'refund':
                return $this->getExampleByClassName('YeepayCbp\formProcess\onlinepay\builder\RefundBuilder');
                break;
            case 'refundQuery' :
                return $this->getExampleByClassName('YeepayCbp\formProcess\onlinepay\builder\RefundQueryBuilder');
                break;
            default:
                return null;
        }
    }
}