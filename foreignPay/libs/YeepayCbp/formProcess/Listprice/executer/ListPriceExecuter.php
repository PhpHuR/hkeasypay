<?php
/**
 * Created by PhpStorm.
 * User: yp-tc-7044
 * Date: 2017/10/18
 * Time: 上午10:46
 */

namespace YeepayCbp\formProcess\Listprice\executer;


use YeepayCbp\formProcess\Executer;
use YeepayCbp\formProcess\Listprice\builder\ListPriceLockBuilder;
use YeepayCbp\formProcess\Listprice\builder\ListPriceQueryBuilder;
use YeepayCbp\responseHandle\listPriceHandle\ListPriceLockHandle;
use YeepayCbp\responseHandle\listPriceHandle\ListPriceQueryHandle;
use YeepayCbp\utils\ConfigurationUtils;

class ListPriceExecuter extends Executer
{
    /**
     * 锁定牌价
     * @param ListPriceLockBuilder $listPriceLockBuilder
     * @param $params
     * @return mixed
     */
    public function listPriceLockExecuter(ListPriceLockBuilder $listPriceLockBuilder,$params)
    {
        //1.创建请求数据json
        $dataParams = $listPriceLockBuilder->builder($params);
        //2.执行请求
        return $this->execute(ConfigurationUtils::getInstance()->getListpriceLockUrl_v1(),$dataParams,new ListPriceLockHandle());
    }

    /**
     * 牌价查询
     * @param ListPriceQueryBuilder $listPriceQueryBuilder
     * @param $params
     * @return mixed
     */
    public function listPriceQueryExecuter(ListPriceQueryBuilder $listPriceQueryBuilder,$params)
    {
        //1.创建请求数据json
        $dataParams = $listPriceQueryBuilder->builder($params);
        //2.执行请求
        return $this->execute(ConfigurationUtils::getInstance()->getListpriceQueryUrl_v1(),$dataParams,new ListPriceQueryHandle());
    }

    public function getExecuterClass($type)
    {
        // TODO: Implement getExecuterClass() method.
        switch ($type) {
            case 'listPriceLock':
                return $this->getExampleByClassName('YeepayCbp\formProcess\Listprice\builder\ListPriceLockBuilder');
                break;
            case 'listPriceQuery':
                return $this->getExampleByClassName('YeepayCbp\formProcess\Listprice\builder\ListPriceQueryBuilder');
                break;
            default:
                return null;
        }
    }
}