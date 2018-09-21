<?php
// +----------------------------------------------------------------------
// | Copyright (c) 2015-2016 http://www.ebpays.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: xiaofeng<1034023036@qq.com>
// +----------------------------------------------------------------------
namespace Api\Controller;

use Org\Util\Stringnew;
use Org\Payment;
use \Think\Controller;

class TestApiPayinController extends Controller
{
    private $userinfo;
    private $payment_name;
    private $payment_mid = array();
    private $payin_rate;
    private $orderid;
    private $order_amount;
    private $bankName;
    private $product;
    private $data;
    private $username;
    private $identitycard;

    protected function _initialize()
    {

        //必须传输的字段
        $data = $_REQUEST['json_data'];
        $this->data = json_decode($data,true);
        $company_code = $this->data['company_code'];//由我們提供，於系統中的公司代碼。
        $order_number = $this->data['order_number'];//訂單號碼，可由客戶自訂，但必須是獨立且不能 與其他訂單重覆。
        $order_amount = $this->data['order_amount'];//入金訂單金額。
        $pay_id = $this->data['pay_id'];//銀行代碼，請參閱附件。
        $return_url = $this->data['return_url'];//完成支付後所跳轉的頁面。
        $notify_url = $this->data['notify_url'];//接收成功支付通知的頁面。
        $sign = $this->data['sign'];//以sha-256方式加密參數及由我們提供的鑰匙。加密米啊哟
        $timestamp = $this->data['timestamp'];//订单发起时间-時間郵戳
        $base64_memo = $this->data['base64_memo'];//備注。
        $payuser_id = $this->data['payuser_id'];//備注。
        $sign_type = $this->data['sign_type'];//SHA256。
        $version = $this->data['version'];//1.0。
        $card_type = $this->data['card_type'];//01:借記卡
        $payin_method = $this->data['payin_method'];
        $source = $this->data['source'];

        $this->username = $this->data['username'];
        $this->identitycard = $this->data['identitycard'];
        //支付提交方式，默认不填写就是api 填写了就是填写的
        if (empty($payin_method)) {
            $payin_method = 'API';
            $source = $_SERVER['HTTP_REFERER'];
        }
        $MARK = "&";
        if ($order_amount < 0.01) {
            $error = array('errorCode'=>'1','msg'=>'order_amount.invalid');
            echo json_encode($error);
            die();
        }
        if ($company_code) {
            $this->userinfo = M('userinfo')->where(array('user_id' => $company_code))->find();
        } else {
            $error = array('errorCode'=>'1','msg'=>'company_code.invalid');
            echo json_encode($error);
            die();
        }
        if (empty($order_amount) or empty($order_number)) {
            $error = array('errorCode'=>'1','msg'=>'order_number.invalid');
            echo json_encode($error);
            die();
        }
//        if (empty($pay_id)) {
//            $this->error('银行参数带入错误，请核对文档后从新提交');
//            die();
//        }

        //获取产品ID--
        $where['product_id'] = array('in', json_decode($this->userinfo['product_id']));

        if ($pay_id == 'weixin' || $pay_id == 'alipay' || $pay_id == 'jd' || $pay_id == 'baidu') {
            $where['product_attribute'] = $pay_id;
        } else {
            $where['product_attribute'] = '0';
        }

        $product_list = M('product')->where($where)->select();

        foreach ($product_list as $k => $v) {

            $product_id = $v['product_id'];

        }
        $this->product = M('product')->where(array('product_id' => $product_id))->find();

        //获取MID数组
        $this->payment_mid = M('payment_mid')->where(array('m_id' => $this->product['payment_mid']))->find(); //MID数组

        //获取支付公司名称
        $this->payment_name = M('payment_name')->where(array('api_id' => $this->payment_mid['p_id']))->getField('api_name');

        //获取费率数组
        $payin_rate = M('payin_rate')->where(array('payin_rate_id' => $this->product['payin_rate_id']))->find();

        $this->payin_rate = $payin_rate['inrate'];

        $this->order_amount = $order_amount;


        if ($pay_id) {
            $this->bankName = $this->getBankName($pay_id, $this->payment_mid['p_id']);
        } else {
//            $this->error('银行参数带入错误，请核对文档后从新提交');
//            die();
        }
        //选填字段
        $product_id = $this->product['product_id'];
        $product_body = $this->product['product_description'];

        //当前两个固定值：$sign_type = 'SHA256';  $version = '1.0';
        $string = $company_code . $MARK . $order_number . $MARK . $order_amount . $MARK . $pay_id . $MARK . $return_url . $MARK . $notify_url . $MARK . $timestamp . $MARK . $base64_memo . $MARK . 'SHA256' . $MARK . '1.0' . $MARK . $card_type . $MARK . $this->userinfo['md5key'];

        $Signature = hash('sha256', $string);

        if ($sign != $Signature) {
            $error = array('errorCode'=>'1','msg'=>'sign.invalid');
            echo json_encode($error);
            die();
        }
        //该位置写入数据库订单
        $time = time();
        $orderid = createOrder($company_code);
        $this->orderid = $orderid;
        $free = $order_amount * $this->payin_rate;
        $commission_c = $order_amount * ($this->payin_rate - $payin_rate['inprice'] - $payin_rate['ag_rate']);
        $commission_ag = $order_amount * $payin_rate['ag_rate'];
        $data = array(
            'uid' => $company_code,
            'payment_mid' => $this->payment_mid['m_id'],
            'orderid' => $orderid,
            'transid' => $order_number,
            'ordermoney' => $order_amount,
            'product_id' => $product_id,
            'remark' => $base64_memo,
            'paybank' => $pay_id,
            'payment_id' => $this->payment_mid['p_id'],
            'begin_time' => $time,
            'free' => $free,
            'settlement' => '',
            'payin_commission_c' => $commission_c,
            'payin_commission_ag' => $commission_ag,
            'status' => '0',
            'notice_status' => '0',
            'returnurl' => $return_url,
            'notifyurl' => $notify_url,
            'payin_method' => $payin_method,
            'source' => $source,
            'settlements_stats' => '0',
        );
        //校验订单重复性 商户ID， 订单号，金额， 状态 和提交的一样就更新订单，否则检测订单号重复。
        /*
         * 'uid'=>$company_code,'transid'=>$order_number,'ordermoney'=>$order_amount,'begin_time'=>$timestamp,'status'=>'0',
         */
        $transid = M('payin')->where(array('uid' => $company_code, 'transid' => $order_number, 'ordermoney' => $order_amount, 'status' => '0'))->find();
        if ($transid) {
            $transid_update = M('payin')->where(array('uid' => $company_code, 'transid' => $order_number, 'ordermoney' => $order_amount, 'status' => '0'))->save($data);
            if (!$transid_update) {
                $error = array('errorCode'=>'1','msg'=>'order_number.Submission of abnormality');
                echo json_encode($error);
                die();
            }
            $transid_check = M('payin')->where(array('transid' => $order_number, 'ordermoney' => array('neq', $order_amount)))->find();
            if ($transid_check) {
                $error = array('errorCode'=>'1','msg'=>'order_number.repeat');
                echo json_encode($error);
                die();
            }
        } else {
            //写入数据库
            $rst = M('payin')->add($data);
            if (!$rst) {
                $error = array('errorCode'=>'1','msg'=>'order_number.wrong');
                echo json_encode($error);
                die();
            }
            $payininfo_data = array(
                'payin_id' => $rst,
                'uid' => $company_code,
                'customer_name' => isset($this->data['customer_name']) ? trim($this->data['customer_name']) : '',
                'customer_id' => isset($this->data['customer_id']) ? trim($this->data['customer_id']) : '',
                'cert_type' => isset($this->data['cert_type']) ? trim($this->data['cert_type']) : '',
                'cert_number' => isset($this->data['cert_number']) ? trim($this->data['cert_number']) : '',
                'email' => isset($this->data['email']) ? trim($this->data['email']) : '',
                'tel' => isset($this->data['tel']) ? trim($this->data['tel']) : '',
                'bank_number' => isset($this->data['bank_number']) ? trim($this->data['bank_number']) : '',
                'update_time' => $time
            );
            $payininfo = M('payininfo')->add($payininfo_data);
        }
    }

    public function index()
    {
        if (IS_POST) {
            if ($this->payment_mid['p_id'] == 15) {
                $orderAmount = $this->order_amount;
            $postData = array();

            $postData["merchantId"] = $this->payment_mid['memberid'];; //商家ID
//
        $postData["orderAmount"] = strval($orderAmount*100);//订单金额
            $postData["orderCurrency"] = 'CNY';//订单币种
            $postData["requestId"] =  $this->orderid;//訂單號碼，可由客戶自訂，但必須是獨立且不能 與其他訂單重覆。;
            $postData["amount"] = '';//购汇金额，单位分
            $postData["currency"] = 'USD';//购汇币种
            $postData["forUse"] = 'GOODSTRADE';//购汇用途
            $postData["listPriceToken"] = '';//锁定牌价标识
//        $postData["notifyUrl"] = 'http://qa.ehking.com/sdk/onlinepay/notify';//异步通知
            $postData["notifyUrl"] = U("Notify/notify", array('apitype' => $this->payment_mid['p_id'], 'method' => 'notify'), false, true);//异步通知
//        $postData["callbackUrl"] = 'http://qa.ehking.com/sdk/callback'; //前台页面通知地址
            $postData["callbackUrl"] = U("Notify/notify", array('apitype' => $this->payment_mid['p_id'], 'method' => 'return'), false, true); //前台页面通知地址
            $postData["remark"] = 'remark';//备注
            $postData["paymentModeCode"] = '';
            $postData["openId"] = '';//微信公众号openId
                $arr[0]['productName'] = '商品';
                $arr[0]['quantity'] = '1';
//                $arr[$key]['productAmount'] = $value['member_goods_price'] * $value['goods_num'] * 100;
            $arr[0]['productAmount'] = strval($orderAmount*100);
                $arr[0]['receiver'] = '';
                $arr[0]['description'] = '';

            $postData["productDetails"] = $arr;
            $postData['name'] = isset($this->data['customer_name']) ? trim($this->data['customer_name']) : '';
            $postData['idType'] = '';
            $postData['idNum '] = isset($this->data['cert_number']) ? trim($this->data['cert_number']) : '';
            $postData['bankCardNum'] = isset($this->data['bank_number']) ? trim($this->data['bank_number']) : '';
            $postData['phoneNum'] = isset($this->data['tel']) ? trim($this->data['tel']) : '';
            $postData['email'] = isset($this->data['email']) ? trim($this->data['email']) : '';
//            $postData['nationality'] = '';
//            $postData["cashierVersion"] = '';
//            $postData["merchantUserId"] = '';
//            $postData["bindCardId"] = '';
//            $postData["bankCard"] = array(
//                'name' => '',
//                'cardNo' => '',
//                'cvv2' => '',
//                'idNo' => '',
//                'expiryDate' => '',
//                'mobileNo' => '',
//            );
            $postData["clientIp"] = '';
            $postData["timeout"] = '1440';
//            $postData["subOrders"] = array(array(
//                'requestId' => '',
//                'amount' => '',
//            ));
                require_once $_SERVER['DOCUMENT_ROOT'] . '/foreignPay/libs/autoload.php';
                $fp = new \Controller\ForeignExchangeController();
                $rs = $fp->orderAction($postData);
                dump($rs);die;
        }

            if ($this->payment_mid['p_id'] == 16) {
            }
            if ($this->payment_mid['p_id'] == 17) {
            }

        } else {
            $this->display();
        }

    }
    /**
     * 发起http请求
     * @param $url: 请求地址
     * @param $params:请求参数
     * @return mixed:
     */
//    public function httpRequestPost($url, $params)
//    {
//        //请求数据json格式
//        $params = is_array($params)?json_encode($params) : $params;
////        print_r($params);die();
////        return $params;
//        //curl请求句柄设置
//        $responseText =  $this->setHttpCurl($url,$params,'post');
//        //结果转换，array形式
//        $data = json_decode($responseText, true);
//        if( $data === false){
//            throw new InvalidResponseException(array(
//                'error_description'=>'Response Error'
//            ));
//        }
//        return $data;
//    }

    /**
     * http请求句柄设置
     * @param $url:请求地址
     * @param $params:请求参数
     * @param $action:请求方式
     * @return mixed
     */
    public function setHttpCurl ($url,$params,$action) {
        //初始化请求句柄,同时校验请求url
        $curl = curl_init($this->absoluteUrl($url));
        //也可自行在会话句柄中设置url
        // curl_setopt($curl, CURLOPT_URL, $url);
        // 过滤HTTP头
        curl_setopt($curl,CURLOPT_HEADER, 0 );
        //尝试连接时等待时间,秒为单位。设置为0则无限等待
        curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 10);
        //curl执行的最长时间（秒）。
        curl_setopt($curl, CURLOPT_TIMEOUT, 3);
        //设置http请求中包含User-Agent
        curl_setopt($curl, CURLOPT_USERAGENT,'Curl/9.80');
        //是否开启CURL验证对等证书
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // stop verifying certificate
        //将curl_exec()获取的信息以字符串返回
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        if ($action === 'post') {
            //开启post请求
            curl_setopt($curl, CURLOPT_POST, true); // enable posting
            //post请求数据
            curl_setopt($curl, CURLOPT_POSTFIELDS, $params); // post images
        }
        //根据服务器返回 HTTP 头中的 "Location: " 重定向
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true); // if any redirection after upload
        //状态码大于等于400时显示错误详情
        curl_setopt($curl, CURLOPT_FAILONERROR, 1);
        //HTTP头字段的数组
        curl_setopt($curl, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/vnd.ehking-v1.0+json',
            'Content-Length: ' . strlen($params),
        ));
        //执行请求句柄，并返回结果
        $responseText = curl_exec($curl);
        //获取结果状态码
        // $intReturnCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        //关闭执行句柄
        curl_close($curl);

//        if (curl_errno($curl) || $responseText === false) {
//            curl_close($curl);
//            dump('error');
//        }
        curl_close($curl);
        return $responseText;
    }
    /**
     * url检查
     * @param $url
     * @param null $param
     * @return string
     */
    private function absoluteUrl($url, $param=null) {
        if ($param !== null) {
            $parse = parse_url($url);

            $port = '';
            if ( ($parse['scheme'] == 'http') && ( empty($parse['port']) || $parse['port'] == 80) ){
                $port = '';
            }else{
                $port = $parse['port'];
            }
            $url = $parse['scheme'].'//'.$parse['host'].$port. $parse['path'];

            if(!empty($parse['query'])){
                parse_str($parse['query'], $output);
                $param = array_merge($output, $param);
            }
            $url .= '?'. http_build_query($param);
        }

        return $url;
    }
    //判斷訂單是否重複訂單
    public function chack_orderid($orderNum)
    {
        $payin_list = M('payin');
        $orderid = $payin_list->where('orderid = ' . $orderNum)->find();
        if ($orderid) {
            return false;
        } else {
            return true;
        }

    }

    //獲取通道銀行信息
    public function getBankName($pay_id, $p_id)
    {
        /*
         * 1、通过$company_code 获取支付通道p_id
         */
        $bankname_list = M('bankroute')->where(array('p_id' => $p_id))->find();
        if ($bankname_list) {
            $bankName = $bankname_list[$pay_id];
            return $bankName;
        } else {
            return false;
        }


    }

    //RSA加密
    function rsaSign($certPaths, $certPass, $signData)
    {
        $rtValue = array();
        $pkcs12 = file_get_contents($certPaths);
        openssl_pkcs12_read($pkcs12, $certs, $certPass);
        $privateKey = $certs['pkey'];
        $publicKey = $certs['cert'];
        $merchantCert = strtoupper(bin2hex(base64_decode($publicKey)));
        $merchantCert = substr($merchantCert, 24, strlen($merchantCert));
        $merchantCert = substr($merchantCert, 0, strlen($merchantCert) - 20);
        openssl_sign($signData, $binarySignature, $privateKey, OPENSSL_ALGO_SHA1);
        $merchantSign = strtoupper(bin2hex($binarySignature));
        $rtValue['merchantCert'] = $merchantCert;
        $rtValue['merchantSign'] = $merchantSign;
        return $rtValue;
    }


}