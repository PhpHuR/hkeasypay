<?php
/**
 * Created by PhpStorm.
 * User: yiqnuan.ma <yinquan.ma@yeepay.com>
 * Date: 2017/9/24
 * Time: 下午7:00
 */

namespace YeepayCbp\utils;

class ConfigurationUtils{

    private static $that;
    private static $configuration;

    const ORDER_URL = 'order.url';
    const QUERY_URL = 'query.url';
    const REFUND_URL = 'refund.url';
    const REFUNDQUERY_URL = 'refundQuery.url';



    private function __construct($config)
    {
        if(self::$configuration == null){
            if(is_file($config))
                self::$configuration = include $config;
            else if (is_array($config)){
                self::$configuration = $config;
            }
        }
    }

    public static function getInstance($config=null)
    {
        if(self::$that)
            return self::$that;

        if($config==null)
            $config = __DIR__ . '/../resources/config/parameters.php';
        self::$that = new ConfigurationUtils($config);

        return self::$that;
    }

    public function getHmacKey($merchantId)
    {
        if (isset(self::$configuration['merchant'][$merchantId])){
            return self::$configuration['merchant'][$merchantId];
        }
        return null;
    }

    /**
     * 获取境内收款url
     * @return null
     */
    //下单
    public function getOnlinepayOrderUrl_v1 ()
    {
        if(isset(self::$configuration['onlinepay_v1.0'])){
            return self::$configuration['onlinepay_v1.0'][self::ORDER_URL];
        }
        return null;
    }

    //订单查询
    public function getOnlinepayQueryUrl_v1 ()
    {
        if(isset(self::$configuration['onlinepay_v1.0'])){
            return self::$configuration['onlinepay_v1.0'][self::QUERY_URL];
        }
        return null;
    }

    //退款
    public function getOnlinepayRefundUrl_v1 ()
    {
        if(isset(self::$configuration['onlinepay_v1.0'])){
            return self::$configuration['onlinepay_v1.0'][self::REFUND_URL];
        }
        return null;
    }

    //退款查询
    public function getOnlinepayRefundQueryUrl_v1 ()
    {
        if(isset(self::$configuration['onlinepay_v1.0'])){
            return self::$configuration['onlinepay_v1.0'][self::REFUNDQUERY_URL];
        }
        return null;
    }



    /**
     * 购付汇下单
     * @return mixed|null
     */
    public function getForeignExchangePayOrderUrl_v1() {
        if(isset(self::$configuration['foreignExchangePay_v1.0'])){
            return self::$configuration['foreignExchangePay_v1.0'][self::ORDER_URL];
        }
        return null;
    }

    /**
     * 购付汇订单查询
     * @return mixed|null
     */
    public function getForeignExchangePayQueryUrl_v1 () {
        if (isset(self::$configuration['foreignExchangePay_v1.0'])) {
            return self::$configuration['foreignExchangePay_v1.0'][self::QUERY_URL];
        }
        return null;
    }

    /**
     * 购付汇退款
     * @return mixed|null
     */
    public function getForeignExchangePayRefundUrl_v1 () {
        if (isset(self::$configuration['foreignExchangePay_v1.0'])) {
            return self::$configuration['foreignExchangePay_v1.0'][self::REFUND_URL];
        }
        return null;
    }

    /**
     * 购付汇退款查询
     * @return mixed|null
     */
    public function getForeignExchangePayRefundQueryUrl_v1 () {
        if (isset(self::$configuration['foreignExchangePay_v1.0'])) {
            return self::$configuration['foreignExchangePay_v1.0'][self::REFUNDQUERY_URL];
        }
        return null;
    }


    /**
     * 购付汇牌价
     * @return mixed|null
     */
    public function getForeignExchangePayListpriceLockUrl_v1 () {
        if (isset(self::$configuration['foreignExchangePay_v1.0'])) {
            return self::$configuration['foreignExchangePay_v1.0']['listpriceLock.url'];
        }
        return null;
    }


    /** 国检接口 */
    /**
     *  国检下单
     * @return null
     */
    public function getCiqOrderUrl_v1 () {
        if (isset(self::$configuration['ciq_v1.0'])) {
            return self::$configuration['ciq_v1.0'][self::ORDER_URL];
        }
        return null;
    }

    /**
     * 国检订单查询
     * @return null
     */
    public function getCiqQueryUrl_v1 () {
        if (isset(self::$configuration['ciq_v1.0'])) {
            return self::$configuration['ciq_v1.0'][self::QUERY_URL];
        }
        return null;
    }


    /** 海关申报 */
    /**
     * 海关下单
     * @return null
     */
    public function  getCustomsOrderUrl_v1 () {
        if (isset(self::$configuration['customs_v1.0'])) {
            return self::$configuration['customs_v1.0'][self::ORDER_URL];
        }
        return null;
    }

    /**
     * 海关订单查询
     * @return null
     */
    public function  getCustomsQueryUrl_v1 () {
        if (isset(self::$configuration['customs_v1.0'])) {
            return self::$configuration['customs_v1.0'][self::QUERY_URL];
        }
        return null;
    }

    /**
     *重复申报
     * @return null
     */
    public function  getCustomsRepeatDeclareUrl_v1 () {
        if (isset(self::$configuration['customs_v1.0'])) {
            return self::$configuration['customs_v1.0']['repeatDeclare.url'];
        }
        return null;
    }


    /** 跨境汇款 */
    /**
     * 下单
     * @return null
     */
    public function  getTransferOrderUrl_v1 () {
        if (isset(self::$configuration['transfer_v1.0'])) {
            return self::$configuration['transfer_v1.0'][self::ORDER_URL];
        }
        return null;
    }

    /**
     *  查询
     * @return null
     */
    public function  getTransferQueryUrl_v1 () {
        if (isset(self::$configuration['transfer_v1.0'])) {
            return self::$configuration['transfer_v1.0'][self::QUERY_URL];
        }
        return null;
    }

    /**
     * 锁牌
     * @return null
     */
    public function  getTransferListPriceLockUrl_v1 () {
        if (isset(self::$configuration['transfer_v1.0'])) {
            return self::$configuration['transfer_v1.0']['listpriceLock.url'];
        }
        return null;
    }

    /** 联名账户v1.0 */

    /**
     * 下单
     * @return null
     */
    public function  getHgOrderUrl_v1 () {
        if (isset(self::$configuration['hg_v1.0'])) {
            return self::$configuration['hg_v1.0'][self::ORDER_URL];
        }
        return null;
    }

    /**
     * 查询
     * @return null
     */
    public function  getHgQueryUrl_v1 () {
        if (isset(self::$configuration['hg_v1.0'])) {
            return self::$configuration['hg_v1.0'][self::QUERY_URL];
        }
        return null;
    }

    /** 联名账户2.0 */

    /**
     * 创建账户
     * @return null
     */
    public function  getHgMemberUrl_v2 () {
        if (isset(self::$configuration['hg_v2.0'])) {
            return self::$configuration['hg_v2.0']['member.url'];
        }
        return null;
    }

    /**
     * 账户查询
     * @return null
     */
    public function  getHgMemberQueryUrl_v2 () {
        if (isset(self::$configuration['hg_v2.0'])) {
            return self::$configuration['hg_v2.0']['member.query.url'];
        }
        return null;
    }
    /**
     * 充值
     * @return null
     */
    public function  getHgRechargeOrderUrl_v2 () {
        if (isset(self::$configuration['hg_v2.0'])) {
            return self::$configuration['hg_v2.0']['rechargeOrder.url'];
        }
        return null;
    }

    /**
     * 充值查询
     * @return null
     */
    public function  getHgRechargeQueryUrl_v2 () {
        if (isset(self::$configuration['hg_v2.0'])) {
            return self::$configuration['hg_v2.0']['rechargeQuery.url'];
        }
        return null;
    }

    /**
     * 转账接口
     * @return null
     */
    public function  getHgTransferOrderUrl_v2 () {
        if (isset(self::$configuration['hg_v2.0'])) {
            return self::$configuration['hg_v2.0']['transferOrder.url'];
        }
        return null;
    }

    /**
     * 支付
     * @return null
     */
    public function  getHgPayOrderUrl_v2 () {
        if (isset(self::$configuration['hg_v2.0'])) {
            return self::$configuration['hg_v2.0']['payOrder.url'];
        }
        return null;
    }

    /**
     * 账户余额查询
     * @return null
     */
    public function  getHgMemberAccountUrl_v2 () {
        if (isset(self::$configuration['hg_v2.0'])) {
            return self::$configuration['hg_v2.0']['member.account.url'];
        }
        return null;
    }

    /**
     * 支付订单查询
     * @return null
     */
    public function  getHgPayOrderQueryUrl_v2 () {
        if (isset(self::$configuration['hg_v2.0'])) {
            return self::$configuration['hg_v2.0']['payOrder.query.url'];
        }
        return null;
    }

    /** 牌价系统 */
    /**
     * 锁牌
     * @return null
     */
    public function  getListpriceLockUrl_v1 () {
        if (isset(self::$configuration['listprice_v1.0'])) {
            return self::$configuration['listprice_v1.0']['lock.url'];
        }
        return null;
    }

    /**
     * 牌价查询
     * @return null
     */
    public function  getListpriceQueryUrl_v1 () {
        if (isset(self::$configuration['listprice_v1.0'])) {
            return self::$configuration['listprice_v1.0'][self::QUERY_URL];
        }
        return null;
    }

    /** 实名认证 */

    /**
     * 认证链接
     * @return null
     */
    public function  getRzAuthUrl_v1 () {
        if (isset(self::$configuration['rz_v1.0'])) {
            return self::$configuration['rz_v1.0']['auth.url'];
        }
        return null;
    }

    /**
     * 认证查询
     * @return null
     */
    public function  getRzSearchUrl_v1 () {
        if (isset(self::$configuration['rz_v1.0'])) {
            return self::$configuration['rz_v1.0']['search.url'];
        }
        return null;
    }

    /** 转账1.0 */

    /**
     * 下单1.0
     * @return null
     */
    public function  getTransferDomesticOrderUrl_v1 () {
        if (isset(self::$configuration['transferDomestic_v1.0'])) {
            return self::$configuration['transferDomestic_v1.0'][self::ORDER_URL];
        }
        return null;
    }

    /**
     * 订单查询2.0
     * @return null
     */
    public function  getTransferDomesticQueryUrl_v1 () {
        if (isset(self::$configuration['transferDomestic_v1.0'])) {
            return self::$configuration['transferDomestic_v1.0'][self::QUERY_URL];
        }
        return null;
    }

    /** 转账2.0 */

    /**
     * 下单2.0
     * @return null
     */
    public function  getTransferDomesticOrderUrl_v2 () {
        if (isset(self::$configuration['transferDomestic_v2.0'])) {
            return self::$configuration['transferDomestic_v2.0'][self::ORDER_URL];
        }
        return null;
    }

    /**
     * 订单查询2.0
     * @return null
     */
    public function  getTransferDomesticQueryUrl_v2 () {
        if (isset(self::$configuration['transferDomestic_v2.0'])) {
            return self::$configuration['transferDomestic_v2.0'][self::QUERY_URL];
        }
        return null;
    }

    public function getFileUploadUrl () {
        if (isset(self::$configuration['file.upload'])) {
            return self::$configuration['file.upload']['url'];
        }
        return null;
    }
}