<?php
/**
 * Created by PhpStorm.
 * User: yiqnuan.ma <yinquan.ma@yeepay.com>
 * Date: 2017/9/24
 * Time: 下午7:00
 */

namespace YeepayCbp\formProcess\foreignExchangePay\executer;

use YeepayCbp\formProcess\Executer;
use YeepayCbp\formProcess\foreignExchangePay\builder\ListPriceLockBuilder;
use YeepayCbp\formProcess\foreignExchangePay\builder\OrderBuilder;
use YeepayCbp\formProcess\foreignExchangePay\builder\QueryBuilder;
use YeepayCbp\formProcess\foreignExchangePay\builder\RefundBuilder;
use YeepayCbp\formProcess\foreignExchangePay\builder\RefundQueryBuilder;
use YeepayCbp\responseHandle\foreignExchangePayHandle\ListPriceLockHandle;
use YeepayCbp\responseHandle\foreignExchangePayHandle\OrderHandle;
use YeepayCbp\responseHandle\foreignExchangePayHandle\QueryHandle;
use YeepayCbp\responseHandle\foreignExchangePayHandle\RefundQueryHandle;
use YeepayCbp\responseHandle\NotifyHandle;
use YeepayCbp\utils\ConfigurationUtils;

class ForeignExchangePayExecuter extends Executer
{
    public function orderExecuter(OrderBuilder $orderBuilder, $params)
    {
        //1.创建请求数据json
        $dataParams = $orderBuilder->builder($params); 
        //2.执行请求
        return $this->execute(ConfigurationUtils::getInstance()->getForeignExchangePayOrderUrl_v1(),$dataParams,new OrderHandle());
    }

    public function queryExecuter(QueryBuilder $queryBuilder, $param)
    {
        $dataParams = $queryBuilder->builder($param);

        //2.执行请求
        return $this->execute(ConfigurationUtils::getInstance()->getForeignExchangePayQueryUrl_v1(), $dataParams, new QueryHandle());
    }

    public function refundExecuter(RefundBuilder $refundBuilder, $param)
    {
        //1.创建请求数据json
        $dataParams = $refundBuilder->builder($param);

        //2.执行请求
        return $this->execute(ConfigurationUtils::getInstance()->getForeignExchangePayRefundUrl_v1(), $dataParams, new QueryHandle());
    }

    public function refundQueryExecuter(RefundQueryBuilder $refundQueryBuilder, $param)
    {
        //1.创建请求数据json
        $dataParams = $refundQueryBuilder->builder($param);
        //2.执行请求
        return $this->execute(ConfigurationUtils::getInstance()->getForeignExchangePayRefundQueryUrl_v1(), $dataParams, new RefundQueryHandle());
    }

    public function listPriceLockExecuter(ListPriceLockBuilder $listPriceLockBuilder, $param)
    {
        $dataParams = $listPriceLockBuilder->builder($param);
        //2.执行请求
        return $this->execute(ConfigurationUtils::getInstance()->getForeignExchangePayListpriceLockUrl_v1(), $dataParams, new ListPriceLockHandle());
    }

    /**
     * 通知处理
     */
    public function notifyAction()
    {
        $raw_post_data = file_get_contents('php://input', 'r');

        $post = json_decode($raw_post_data, true);

        $handle = new NotifyHandle();
        $handle->handle($post);
    }

    public function getExecuterClass($type)
    {
        // TODO: Implement getExecuterClass() method.
        switch ($type) {
            case 'order':
                return $this->getExampleByClassName('YeepayCbp\formProcess\foreignExchangePay\builder\OrderBuilder');
                break;
            case 'query':
                return $this->getExampleByClassName('YeepayCbp\formProcess\foreignExchangePay\builder\QueryBuilder');
                break;
            case 'refund':
                return $this->getExampleByClassName('YeepayCbp\formProcess\foreignExchangePay\builder\RefundBuilder');
                break;
            case 'refundQuery' :
                return $this->getExampleByClassName('YeepayCbp\formProcess\foreignExchangePay\builder\RefundQueryBuilder');
                break;
            case 'listPrice' :
                return $this->getExampleByClassName('YeepayCbp\formProcess\foreignExchangePay\builder\ListPriceLockBuilder');
                break;
            default:
                return null;
        }
    }
}