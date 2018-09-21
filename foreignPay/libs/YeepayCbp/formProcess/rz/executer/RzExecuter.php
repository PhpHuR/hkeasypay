<?php
/**
 * Created by PhpStorm.
 * User: yp-tc-7044
 * Date: 2017/10/18
 * Time: 上午10:46
 */

namespace YeepayCbp\formProcess\rz\executer;


use YeepayCbp\formProcess\Executer;
use YeepayCbp\formProcess\rz\builder\AuthBuilder;
use YeepayCbp\formProcess\rz\builder\SearchBuilder;
use YeepayCbp\responseHandle\rzHandle\AuthHandle;
use YeepayCbp\responseHandle\rzHandle\SearchHandle;
use YeepayCbp\utils\ConfigurationUtils;

class RzExecuter extends Executer
{

    /**
     * 实名认证
     * @param AuthBuilder $authBuilder
     * @param $params
     * @return mixed
     */
    public function authExecuter(AuthBuilder $authBuilder, $params)
    {
        //1.创建请求数据json
        $dataParams = $authBuilder->builder($params);
        //2.执行请求
        return $this->execute(ConfigurationUtils::getInstance()->getRzAuthUrl_v1(),$dataParams,new AuthHandle());
    }

    /**
     * 认证查询
     * @param SearchBuilder $searchBuilder
     * @param $params
     * @return mixed
     */
    public function searchExecuter(SearchBuilder $searchBuilder, $params)
    {
        //1.创建请求数据json
        $dataParams = $searchBuilder->builder($params);
        //2.执行请求
        return $this->execute(ConfigurationUtils::getInstance()->getRzSearchUrl_v1(),$dataParams,new SearchHandle());
    }

    public function getExecuterClass($type)
    {
        // TODO: Implement getExecuterClass() method.
        switch ($type) {
            case 'auth':
                return $this->getExampleByClassName('YeepayCbp\formProcess\rz\builder\AuthBuilder');
                break;
            case 'search':
                return $this->getExampleByClassName('YeepayCbp\formProcess\rz\builder\SearchBuilder');
                break;
            default:
                return null;
        }
    }
}