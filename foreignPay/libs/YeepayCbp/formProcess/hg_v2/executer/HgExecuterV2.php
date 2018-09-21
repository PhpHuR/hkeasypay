<?php
/**
 * Created by PhpStorm.
 * User: yp-tc-7044
 * Date: 2017/10/9
 * Time: 下午5:45
 */
namespace YeepayCbp\formProcess\hg_v2\executer;

use YeepayCbp\formProcess\Executer;
use YeepayCbp\formProcess\hg_v2\builder\AccountQueryBuilder;
use YeepayCbp\formProcess\hg_v2\builder\MemberBuilder;
use YeepayCbp\formProcess\hg_v2\builder\MemberQueryBuilder;
use YeepayCbp\formProcess\hg_v2\builder\PayOrderBuilder;
use YeepayCbp\formProcess\hg_v2\builder\PayOrderQueryBuilder;
use YeepayCbp\formProcess\hg_v2\builder\RechargeOrderBuilder;
use YeepayCbp\formProcess\hg_v2\builder\RechargeQueryBuilder;
use YeepayCbp\formProcess\hg_v2\builder\TransferOrderBuilder;
use YeepayCbp\responseHandle\hgV2Handle\MemberAccountHandle;
use YeepayCbp\responseHandle\hgV2Handle\MemberHandle;
use YeepayCbp\responseHandle\hgV2Handle\MemberQueryHandle;
use YeepayCbp\responseHandle\hgV2Handle\PayOrderHandle;
use YeepayCbp\responseHandle\hgV2Handle\PayOrderQueryHandle;
use YeepayCbp\responseHandle\hgV2Handle\RechargeOrderHandle;
use YeepayCbp\responseHandle\hgV2Handle\RechargeQueryHandle;
use YeepayCbp\responseHandle\hgV2Handle\TransferOrderHandle;
use YeepayCbp\utils\ConfigurationUtils;

class HgExecuterV2 extends Executer
{
    /**
     * 创建账户
     * @param MemberBuilder $memberBuilder
     * @param $params
     * @return mixed
     */
    public function memberExecuter (MemberBuilder $memberBuilder,$params ) {
        //1.创建请求数据json
        $dataParams = $memberBuilder->builder($params);
        //2.执行请求
        return $this->execute(ConfigurationUtils::getInstance()->getHgMemberUrl_v2(),$dataParams,new MemberHandle());
    }

    /**
     * 账户查询
     * @param MemberQueryBuilder $memberQueryBuildemr
     * @param $params
     * @return mixed
     */
    public function memberQueryExecuter (MemberQueryBuilder $memberQueryBuildemr,$params) {
        //1.创建请求数据json
        $dataParams = $memberQueryBuildemr->builder($params);
        //2.执行请求
        return $this->execute(ConfigurationUtils::getInstance()->getHgMemberQueryUrl_v2(),$dataParams,new MemberQueryHandle());
    }

    /**
     * 充值
     * @param RechargeOrderBuilder $rechargeOrderBuilder
     * @param $params
     * @return mixed
     */
    public function rechargeOrderExecuter (RechargeOrderBuilder $rechargeOrderBuilder,$params) {
        //1.创建请求数据json
        $dataParams = $rechargeOrderBuilder->builder($params);
        //2.执行请求
        return $this->execute(ConfigurationUtils::getInstance()->getHgRechargeOrderUrl_v2(),$dataParams,new RechargeOrderHandle());
    }

    /**
     * 充值查询
     * @param RechargeQueryBuilder $rechargeOrderBuilder
     * @param $params
     * @return mixed
     */
    public function rechargeQueryExecuter (RechargeQueryBuilder $rechargeOrderBuilder,$params) {
        //1.创建请求数据json
        $dataParams = $rechargeOrderBuilder->builder($params);
        //2.执行请求
        return $this->execute(ConfigurationUtils::getInstance()->getHgRechargeQueryUrl_v2(),$dataParams,new RechargeQueryHandle());
    }

    /**
     * 支付
     * @param PayOrderBuilder $payOrderBuilder
     * @param $params
     * @return mixed'
     */
    public function payOrderExecuter (PayOrderBuilder $payOrderBuilder,$params) {
        //1.创建请求数据json
        $dataParams = $payOrderBuilder->builder($params);
        //2.执行请求
        return $this->execute(ConfigurationUtils::getInstance()->getHgPayOrderUrl_v2(),$dataParams,new PayOrderHandle());
    }

    /**
     * 支付订单查询
     * @param PayOrderQueryBuilder $payOrderQueryBuilder
     * @param $params
     * @return mixed
     */
    public function payQueryExecuter (PayOrderQueryBuilder $payOrderQueryBuilder,$params) {
        //1.创建请求数据json
        $dataParams = $payOrderQueryBuilder->builder($params);
        //2.执行请求
        return $this->execute(ConfigurationUtils::getInstance()->getHgPayOrderQueryUrl_v2(),$dataParams,new PayOrderQueryHandle());
    }

    /**
     * 账户余额查询
     * @param AccountQueryBuilder $accountQueryBuilder
     * @param $params
     * @return mixed
     */
    public function accountQueryExecuter (AccountQueryBuilder $accountQueryBuilder,$params) {
        //1.创建请求数据json
        $dataParams = $accountQueryBuilder->builder($params);
        //2.执行请求
        return $this->execute(ConfigurationUtils::getInstance()->getHgMemberAccountUrl_v2(),$dataParams,new MemberAccountHandle());
    }

    /**
     * 转账接口
     * @param TransferOrderBuilder $transferOrderBuilder
     * @param $params
     * @return mixed
     */
    public function transferOrderExecuter (TransferOrderBuilder $transferOrderBuilder,$params) {
        //1.创建请求数据json
        $dataParams = $transferOrderBuilder->builder($params);
        //2.执行请求
        return $this->execute(ConfigurationUtils::getInstance()->getHgTransferOrderUrl_v2(),$dataParams,new TransferOrderHandle());
    }

    public function getExecuterClass($type)
    {
        // TODO: Implement getExecuterClass() method.
        switch ($type) {
            case 'member':
                return $this->getExampleByClassName('YeepayCbp\formProcess\hg_v2\builder\MemberBuilder');
                break;
            case 'memberQuery':
                return $this->getExampleByClassName('YeepayCbp\formProcess\hg_v2\builder\MemberQueryBuilder');
                break;
            case 'rechargeOrder':
                return $this->getExampleByClassName('YeepayCbp\formProcess\hg_v2\builder\RechargeOrderBuilder');
                break;
            case 'rechargeQuery':
                return $this->getExampleByClassName('YeepayCbp\formProcess\hg_v2\builder\RechargeQueryBuilder');
                break;
            case 'payOrder':
                return $this->getExampleByClassName('YeepayCbp\formProcess\hg_v2\builder\PayOrderBuilder');
                break;
            case 'payOrderQuery':
                return $this->getExampleByClassName('YeepayCbp\formProcess\hg_v2\builder\PayOrderQueryBuilder');
                break;
            case 'accountQuery':
                return $this->getExampleByClassName('YeepayCbp\formProcess\hg_v2\builder\AccountQueryBuilder');
                break;
            case 'transferOrder':
                return $this->getExampleByClassName('YeepayCbp\formProcess\hg_v2\builder\TransferOrderBuilder');
                break;
            default:
                return null;
        }
    }
}