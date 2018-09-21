<?php
/**
 * Created by PhpStorm.
 * User: yp-tc-7044
 * Date: 2017/10/9
 * Time: 下午5:02
 */

namespace YeepayCbp\formProcess\hg\executer;


use YeepayCbp\formProcess\Executer;
use YeepayCbp\formProcess\hg\builder\OrderBuilder;
use YeepayCbp\formProcess\hg\builder\QueryBuilder;
use YeepayCbp\responseHandle\hgHandle\OrderHandle;
use YeepayCbp\responseHandle\hgHandle\QueryHandle;
use YeepayCbp\responseHandle\hgHandle\StatusListner;
use YeepayCbp\utils\ConfigurationUtils;

class HgExecuter extends Executer
{

    public function orderExecuter(OrderBuilder $orderBuilder, $params)
    {
        //1.创建请求数据json
        $dataParams = $orderBuilder->builder($params);
        //2.执行请求
        return $this->execute(ConfigurationUtils::getInstance()->getHgOrderUrl_v1(), $dataParams, new OrderHandle());

    }

    public function queryExecuter(QueryBuilder $queryBuilder, $param, StatusListner $dealPayment,StatusListner $dealDeclare)
    {
        $dataParams = $queryBuilder->builder($param);
        //2.执行请求
        $handle = new QueryHandle();
        $resultData = $this->execute(ConfigurationUtils::getInstance()->getHgQueryUrl_v1(), $dataParams, $handle);

        //执行完成后，结果处理
        if ($dealPayment instanceof StatusListner && $dealDeclare instanceof StatusListner) {
            if (!is_array($resultData)) {
                $resultData = json_decode($resultData, true);
            }
            //报关结果处理
            if (isset($resultData[$handle::TEMPORARY_SCALAR])) {
                if ($resultData[$handle::TEMPORARY_SCALAR] === $handle::SUCCESS) {
                    $dealDeclare->success($handle->setDel($resultData));
                } else if ($resultData[$handle::TEMPORARY_SCALAR] === $handle::FAILED) {
                    $dealDeclare->failed($handle->setDel($resultData));
                } else {
                    $dealDeclare->processing($handle->setDel($resultData));
                }
            } else if (isset($resultData[$handle::TEMPORARY_SCALAR_PAYMENT])) {
                //支付结果处理
                if ($resultData[$handle::TEMPORARY_SCALAR_PAYMENT] === $handle::SUCCESS) {
                    $dealPayment->success($handle->setDel($resultData));
                } else if ($resultData[$handle::TEMPORARY_SCALAR_PAYMENT] === $handle::FAILED) {
                    $dealPayment->failed($handle->setDel($resultData));
                } else {
                    $dealPayment->processing($handle->setDel($resultData));
                }
            }
        }

        return $handle->setDel($resultData);
    }

    public function getExecuterClass($type)
    {
        // TODO: Implement getExecuterClass() method.
        switch ($type) {
            case 'order':
                return $this->getExampleByClassName('YeepayCbp\formProcess\hg\builder\OrderBuilder');
                break;
            case 'query':
                return $this->getExampleByClassName('YeepayCbp\formProcess\hg\builder\QueryBuilder');
                break;
            default:
                return null;
        }
    }
}