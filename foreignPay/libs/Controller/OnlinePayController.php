<?php
/**
 * Created by PhpStorm.
 * User: yiqnuan.ma <yinquan.ma@yeepay.com>
 * Date: 2017/9/14
 * Time: 下午2:19
 */

namespace Controller;

use YeepayCbp\entity\BankCard;
use YeepayCbp\entity\Payer;
use YeepayCbp\entity\ProductDetail;
use YeepayCbp\entity\Receiver;
use YeepayCbp\exception\ExceptionInterface;
use YeepayCbp\formProcess\onlinepay\executer\OnlinePayExecuter;
use YeepayCbp\responseHandle\NotifyHandle;
use YeepayCbp\responseHandle\onlinepayHandle\OrderCallBackResponse;


/**
 * 人民币收单
 * Class OnlinePayController
 * @package yeepayCbp\Controller
 */
class OnlinePayController
{

    const ORDER = 'order';
    const QUERY = 'query';
    const REFUND = 'refund';
    const REFUNDQUERY = 'refundQuery';

    private $onlinePayExecuter;

    public function __construct()
    {
        $this->onlinePayExecuter = new OnlinePayExecuter();
    }

    /**
     * 下单
     */
    public function orderAction($params)
    {
        //获取参数执行类
        $orderClass = $this->onlinePayExecuter->getExecuterClass(self::ORDER);
        //获取数据参数
//        $params = $_POST;

        $orderClass->setMerchantId($params['merchantId'])
            ->setOrderAmount($params['orderAmount'])
            ->setOrderCurrency($params['orderCurrency'])
            ->setRequestId($params['requestId'])
            ->setNotifyUrl($params['notifyUrl'])
            ->setCallbackUrl($params['callbackUrl'])
            ->setRemark($params['remark'])
            ->setPaymentModeCode(!isset($params['paymentModeCode']) ? '' : $params['paymentModeCode'] == null ? '' : $params['paymentModeCode']);

        //商品信息
        if (!empty($params['product'])) {
            $postProduct = $params['product'];
            $products = array();
            foreach ($postProduct as $val) {
                $product = new ProductDetail();
                $product->setDescription($val['description'])
                    ->setAmount($val['productAmount'])
                    ->setName($val['productName'])
                    ->setQuantity($val['quantity'])
                    ->setReceiver($val['receiver']);

                array_push($products, $product);
            }
            $orderClass->setProductDetails($products);
        }

        if (!empty($params['details'])) {
            $details = json_decode(str_replace("'", '"', $params['details']), true);
            $products = array();
            foreach ($details as $val) {
                $product = new ProductDetail();
                $product->setDescription($val['description'])
                    ->setAmount($val['amount'])
                    ->setName($val['name'])
                    ->setQuantity($val['quantity'])
                    ->setReceiver($val['receiver']);

                array_push($products, $product);
            }
            $orderClass->setProductDetails($products);
        }

        $payer = new Payer();
        $payer->setName($params['payerName'])
            ->setIdType($params['payerIdType'])
            ->setIdNum($params['payerIdNum'])
            ->setBankCardNum($params['bankCardNum'])
            ->setPhoneNum($params['payerPhoneNum'])
            ->setEmail($params['email']);
        $orderClass->setPayer($payer);

        $bankCard = new BankCard();
        $bankCard->setCardNo($params["cardNo"])
            ->setCvv2($params["cvv2"])
            ->setExpiryDate($params["expiryDate"])
            ->setIdNo($params["idNo"])
            ->setMobileNo($params["mobileNo"])
            ->setName($params["name"]);
        $orderClass->setBankCard($bankCard);

        $orderClass->setCashierVersion($params['cashierVersion'])
            ->setForUse($params['forUse'])
            ->setMerchantUserId($params['merchantUserId'])
            ->setBindCardId($params['bindCardId'])
            ->setClientIp($params['clientIp'])
            ->setTimeout($params['timeout'])
            ->setAuthCode($params['authCode'])
            ->setOpenId(!isset($params['openId']) ? '' : $params['openId'] === null ? '' : $params['openId']);

        $receiver = new Receiver();
        $receiver->setReceiver($params['receiverName'])
            ->setPhoneNum($params['receiverPhoneNum'])
            ->setAddress($params['address']);

        $orderClass->setReceiver($receiver);
        try {
            return $this->onlinePayExecuter->orderExecuter($orderClass, $params);
        } catch (ExceptionInterface $e) {
            return json_encode(unserialize($e->getMessage()));
        }
    }

    /**
     * 查询
     */
    public function queryAction()
    {
        //获取参数执行类
        $queryClass = $this->onlinePayExecuter->getExecuterClass(self::QUERY);
        //获取数据参数
        $params = $_POST;

        $queryClass->setMerchantId($params['merchantId'])
            ->setRequestId($params['requestId']);
        try {
            return $this->onlinePayExecuter->queryExecuter($queryClass, $params);
        } catch (ExceptionInterface $e) {
            return json_encode(unserialize($e->getMessage()));
        }
    }

    /**
     * 退款
     */
    public function refundAction()
    {
        //获取参数执行类
        $refundClass = $this->onlinePayExecuter->getExecuterClass(self::REFUND);
        //获取数据参数
        $params = $_POST;

        $refundClass->setMerchantId($params['merchantId'])
            ->setRequestId($params['requestId'])
            ->setAmount($params['amount'])
            ->setOrderId($params['orderId'])
            ->setNotifyUrl($params['notifyUrl'])
            ->setRemark($params['remark']);
        try {
            return $this->onlinePayExecuter->refundExecuter($refundClass, $params);
        } catch (ExceptionInterface $e) {
            return json_encode(unserialize($e->getMessage()));
        }
    }

    /**
     * 退款查询
     */
    public function refundQueryAction()
    {
        //获取参数执行类
        $refundQueryClass = $this->onlinePayExecuter->getExecuterClass(self::REFUNDQUERY);
        //获取数据参数
        $params = $_POST;
        $refundQueryClass->setMerchantId($params['merchantId'])
            ->setRequestId($params['requestId']);
        try {
            return $this->onlinePayExecuter->refundQueryExecuter($refundQueryClass, $params);
        } catch (ExceptionInterface $e) {
            return json_encode(unserialize($e->getMessage()));
        }
    }


    /**
     * 通知处理
     */
    public function notifyAction()
    {
        $raw_post_data = file_get_contents('php://input', 'r');
        if (empty($raw_post_data)) {
            $raw_post_data = file_get_contents('php://input');
        }

        $post = json_decode($raw_post_data, true);
        //验签
        $check = new OrderCallBackResponse();
        $check->checkHmac($post);
        $handle = new NotifyHandle();
        $handle->handle($post);
    }

    /**
     * 回调处理
     */
    public function callbackAction()
    {
        $this->notifyAction();
    }
} 