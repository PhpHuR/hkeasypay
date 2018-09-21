<?php
/**
 * Created by PhpStorm.
 * User: yp-tc-7044
 * Date: 2017/10/18
 * Time: 上午10:49
 */

namespace YeepayCbp\formProcess\transferDomnesticV1\executer;


use YeepayCbp\formProcess\Executer;
use YeepayCbp\formProcess\transferDomnesticV1\builder\SingleOrderBuilder;
use YeepayCbp\formProcess\transferDomnesticV1\builder\SingleQueryBuilder;
use YeepayCbp\responseHandle\transferDomesticHandleV1\OrderHandle;
use YeepayCbp\responseHandle\transferDomesticHandleV1\QueryHandle;
use YeepayCbp\utils\ConfigurationUtils;

class TransferDomesticExecuterV1 extends Executer
{

    public function singleOrderExcuter(SingleOrderBuilder $singleOrderBuilder, $params)
    {
        //1.创建请求数据json
        $dataParams = $singleOrderBuilder->builder($params);
        //2.执行请求
        return $this->execute(ConfigurationUtils::getInstance()->getTransferDomesticOrderUrl_v1(), $dataParams, new OrderHandle());

    }

    public function singleQueryExcuter(SingleQueryBuilder $singleQueryBuilder, $params)
    {
        //1.创建请求数据json
        $dataParams = $singleQueryBuilder->builder($params);return $dataParams;
        //2.执行请求
        return $this->execute(ConfigurationUtils::getInstance()->getTransferDomesticQueryUrl_v2(), $dataParams, new QueryHandle());

    }

    public function getExecuterClass($type)
    {
        // TODO: Implement getExecuterClass() method.
        switch ($type) {
            case 'singleOrder':
                return $this->getExampleByClassName('YeepayCbp\formProcess\transferDomnesticV1\builder\SingleOrderBuilder');
                break;
            case 'singleQuery':
                return $this->getExampleByClassName('YeepayCbp\formProcess\transferDomnesticV1\builder\SingleQueryBuilder');
                break;
            default:
                return null;
        }
    }
}