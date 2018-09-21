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

class ApiPayinController extends Controller
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

    protected function _initialize()
    {
        $this->data = json_decode($_POST['order'],true);
        $sign = $_POST['sign'];
        $company_code = $this->data['company_code'];//由我們提供，於系統中的公司代碼。
        $order_number = $this->data['order_number'];//訂單號碼，可由客戶自訂，但必須是獨立且不能 與其他訂單重覆。
        $order_amount = $this->data['order_amount'];//入金訂單金額。
        $return_url = $this->data['return_url'];//接收成功支付通知的頁面。
        $notify_url = $this->data['notify_url'];//接收成功支付通知的頁面。
        $timestamp = $this->data['timestamp'];//订单发起时间-時間郵戳
        $pay_id = $this->data['pay_id'];//銀行代碼，請參閱附件。
        $base64_memo = $this->data['base64_memo'];//備注。
//        $sign_type = $this->data['sign_type'];//SHA256。
//        $version = $this->data['version'];//1.0。
        $card_type = $this->data['card_type'];//01:借記卡
        $payin_method = $this->data['payin_method'];
        $source = $this->data['source'];

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
            if(!$this->userinfo){
                $error = array('errorCode'=>'1','msg'=>'user_id.invalid');
                echo json_encode($error);
                die();
            };
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
        if (empty($pay_id)) {
            $error = array('errorCode'=>'1','msg'=>'bankid.invalid');
            echo json_encode($error);
            die();
        }elseif ($pay_id == 'weixin'){
            $currency_id = 3;
        }

        $check_data = M('check_list')->where(array('u_id'=>$company_code))->find();
        if($pay_id != 'weixin' || $check_data['status'] == 1){
            if(empty($this->data['customer_name'])){
                $error = array('errorCode'=>'1','msg'=>'customer_name.invalid');
                echo json_encode($error);
                die();
            }

            if(empty($this->data['tel'])){
                $error = array('errorCode'=>'1','msg'=>'tel.invalid');
                echo json_encode($error);
                die();
            }

            if(empty(trim($this->data['bank_number']))){
                $error = array('errorCode'=>'1','msg'=>'bank_number.invalid');
                echo json_encode($error);
                die();
            }

            if(empty(trim($this->data['cert_number']))){
                $error = array('errorCode'=>'1','msg'=>'cert_number.invalid');
                echo json_encode($error);
                die();
            }
        }


        //获取产品ID--
        $where['product_id'] = array('in', json_decode($this->userinfo['product_id']));

        if ($pay_id == 'weixin' || $pay_id == 'alipay' || $pay_id == 'jd' || $pay_id == 'baidu') {
            $where['product_attribute'] = $pay_id;
        } else {
            $where['product_attribute'] = '0';
        }

        $product_list = M('product')->where($where)->select();
        if(!$product_list){
            $error = array('errorCode'=>'1','msg'=>'pay_id.invalid');
            echo json_encode($error);
            die();
        }
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
        $string = $company_code . $MARK . $order_number . $MARK . $order_amount . $MARK . $pay_id . $MARK . $return_url . $MARK . $notify_url . $MARK . $timestamp . $MARK . 'SHA256' . $MARK . '1.0' . $MARK . $this->userinfo['md5key'];

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
            'remark' =>  isset($base64_memo) ? trim($base64_memo) : '',
            'paybank' => $pay_id,
            'currency_id' => isset($currency_id) ? $currency_id : 1,
            'realname' => $this->data['customer_name'],
            'mobile' => $this->data['phoneNum'],
            'idcard' => $this->data['bank_number'],
            'bankcard' => $this->data['cert_number'],
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


        if($check_data['status'] == 1 && $check_data['number'] > 0){
//            检查是否启用

            //        引入鉴权控制器
            $bankData['realname'] = $this->data['customer_name'];
            $bankData['bankcard'] = $this->data['bank_number'];
            $bankData['idcard'] = $this->data['cert_number'];
            $bankData['mobile'] = $this->data['phoneNum'];
            $bankData['ip'] = $_SERVER['REMOTE_ADDR'];

            $c_num['number'] = $check_data['number'] -1;
            if($check_data['warring_state'] == 1){
                $content = '【易通财】报警信息，您现在的可用条数是'.$c_num['number'].'条，为防止没有短信通知，请尽快充值';
                if($check_data['warring_count'] == $c_num['number']){
//                    发送报警短信
                    $sms_data = M('sms_list')->where(array('u_id'=>$company_code))->find();
                    $send['content'] = $content;
                    $send['mobile'] = $sms_data['mobile'];
                    $send['productid'] = $sms_data['sms_product_id'];
                    $send['xh'] = $sms_data['small_mobile'];
                    $send['username'] = $sms_data['sms_username'];
                    $send['tkey'] = date('YmdHis');
                    $send['password'] = md5(md5($sms_data['sms_pass']).$send['tkey']);
                    $send = http_build_query($send);

                    $res = go_curl('http://www.ztsms.cn/sendNSms.do','post',$send);
                    $arr_res = explode(',',$res);
                    if($arr_res[0] != 1){
                        $fp = @fopen("sms_error.txt", "a+");
                        fwrite($fp, date('Y-m-d H:i:s')."发送短信失败");
                        fclose($fp);
                    }
                }
            }

            M('check_list')->where(array('u_id'=>$company_code))->save($c_num);

            $jian_res1 = getJianQuan($bankData,'verifybankcard4');
            if($jian_res1['result']['res'] != 1){
                $bankData['jobid'] = $jian_res1['result']['jobid'];
                $bankData['message'] = $jian_res1['reason'];
                $bankData['res'] = 3;
                $log_res = bankcard_log($company_code,$bankData,$orderid);
                if(!$log_res){
                    $this->error('导入实名银行卡失败');
                    die;
                }
                $this->error($jian_res1['reason']);
                die();
            }
            $log_res = bankcard_log($company_code,$jian_res1['result'],$orderid);
            if(!$log_res){
                $this->error('导入实名银行卡失败');
                die;
            }

            $cheat_res = cheat($bankData,'multi_url');
            if(!isset($cheat_res['registered_logs'][0]['code'])){
                $this->error($cheat_res['message']);
                die;
            }

            $log_res = jiedai_log($company_code,$cheat_res,$orderid,$_POST['tel']);
            if(!$log_res){
                $this->error('导入多头欺诈数据失败');
                die;
            }

            $cheat_res1 = cheat($bankData,'anti_url');
            if($cheat_res1['mobile_status']['code'] != 0){
                $this->error($cheat_res1['message']);
                die;
            }
            $log_res = fanqizha_log($company_code,$cheat_res1,$orderid);
            if(!$log_res){
                $this->error('导入反欺诈数据失败');
                die;
            }


        }elseif($check_data['status'] == 1 && $check_data['number'] == 0){
            $this->error('鉴权次数已用尽，请充值');
        }

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
            //            检查黑名单
            $user_check = $this->black($_POST['customer_name'],$_POST['tel'],$_POST['cert_number'],$_POST['bank_number']);
            $arr_res = json_decode($user_check,true);
            if($arr_res['status']==1){
                $error = array('errorCode'=>'1','msg'=>'Blacklist');
                echo json_encode($error);
                die();
            }
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
                'cert_type' => isset($this->data['customer_id']) ? trim($this->data['customer_id']) : 1,
                'cert_number' => isset($this->data['cert_number']) ? trim($this->data['cert_number']) : '',
                'email' => isset($this->data['email']) ? trim($this->data['email']) : '',
                'tel' => isset($this->data['phoneNum']) ? trim($this->data['phoneNum']) : '',
                'bank_number' => isset($this->data['bank_number']) ? trim($this->data['bank_number']) : '',
                'update_time' => $time
            );
            $payininfo = M('payininfo')->add($payininfo_data);
        }
    }

    public function index()
    {
        if (IS_POST) {
            if ($this->payment_mid['p_id'] == 1) {//展宇微信
                $orderAmount = $this->order_amount;
                $postData = array();

                $postData["merchantNo"] = $this->payment_mid['memberid']; //商家ID
                $postData["orderNo"] =  $this->orderid;//訂單號碼，可由客戶自訂，但必須是獨立且不能 與其他訂單重覆。;
                $postData["amount"] = strval($orderAmount);//订单金额
                $postData["currency"] = 'HKD';//订单币种
                $postData["orderTime"] = date("M d, Y h:i:s A");
                $postData["pickupUrl"] = U("Notify/notify", array('apitype' => $this->payment_mid['p_id'], 'method' => 'return'), false, true);            //前台跳转地址
                $postData['proName']='商品';
                $postData["proNum"] = 1;
                $postData["merchantName"] = '商品';
                $postData["mark"] = 'md5';
                $postData["transactionType"] = '1001';
                $postData['orderText']='';
                $orderStr = json_encode($postData);
                $sign = strtoupper(md5($orderStr.$this->payment_mid['paypsd']));
                $params['order'] = $orderStr;
                $params['sign'] = $sign;
                $params['genQRflag'] = 1;
                $url = 'http://senqee.hk/payment/mvc/gateway/pay/doPayVorder';

                $curl = httpPost($url,$params);

                header('content-type:text/html;charset=utf8');
                require_once $_SERVER['DOCUMENT_ROOT'] . '/phpqrcode/phpqrcode.php';
                $arr = json_decode($curl,true);
                $code_url = $arr['parameters']['returnMsg'];//二维码内容
                if($_POST['genQRflag'] == 1){
                    echo $code_url;
                }else{
                    //输出图片
                    $weiURL = 'http://' . $_SERVER['HTTP_HOST'] . '/Api/WeixinNotify/return_url';;
                    $amount = cursell_cny($orderAmount,8813);

                    $html = '<html><head></head><body><form id="pay_form"  name="pay_form" action="' . $weiURL . '" method="post">';
                    $html .= '<input type="hidden" name="wei_path" value="' . $code_url . '"/><br/>';
                    $html .= '<input type="hidden" name="order" value="' . $postData['orderNo'] . '"/><br/>';
                    $html .= '<input type="hidden" name="amount" value="' . $amount . '"/><br/>';
                    $html .= '</form>';
                    $html .= '<script type="text/javascript">pay_form.submit();</script>';
                    $html .= '</body></html>';
                    echo $html;
                    die;
                }

            }

            if ($this->payment_mid['p_id'] == 2) {
                $orderAmount = $this->data['order_amount'];
                $postData = array();

                $postData["orderAmount"] = strval($orderAmount*100);//订单金额
                $postData["orderCurrency"] = 'CNY';//订单币种
                $postData["requestId"] =  $this->orderid;//訂單號碼，可由客戶自訂，但必須是獨立且不能 與其他訂單重覆。;
                //        $postData["notifyUrl"] = 'http://qa.ehking.com/sdk/onlinepay/notify';//异步通知
                $postData["notifyUrl"] = $this->data['return_url'];//异步通知
//        $postData["callbackUrl"] = 'http://qa.ehking.com/sdk/callback'; //前台页面通知地址
                $postData["callbackUrl"] = $this->data['gatewayNo']; //前台页面通知地址
                $postData["remark"] = 'remark';//备注
                $postData['paymentModeCode'] = '';

                $arr[0]['name'] = $this->data['productName'];
                $arr[0]['quantity'] = $this->data['quantity'];
                $arr[0]['amount'] = strval($orderAmount*100);
                $arr[0]['receiver'] = '';
                $arr[0]['description'] = '';
                $postData['productDetails'] = $arr;
                $arr1 = array(
                    'name' => isset($this->data['customer_name']) ? trim($this->data['customer_name']) :'',
                    'phoneNum' => isset($this->data['phoneNum']) ? trim($this->data['phoneNum']) :'',
                    'email' => isset($this->data['email']) ? trim($this->data['email']) :'',
                    'idType' =>'IDCARD',
                    'idNum ' =>isset($this->data['cert_number']) ? trim($this->data['cert_number']) :'',
                    'bankCardNum' =>isset($this->data['bank_number']) ? trim($this->data['bank_number']) :'',
                );
                $postData['payer'] = $arr1;

                $postData["bankCard"] = array(
                    'name' => '',
                    'cardNo' => '',
                    'cvv2' => '',
                    'idNo' => '',
                    'expiryDate' => '',
                    'mobileNo' => '',
                );

                $postData['cashierVersion'] = 'DECLARE';
                $postData['forUse'] = 'GOODSTRADE';
                $postData['merchantUserId'] = '';
                $postData['bindCardId'] = '';
                $postData["clientIp"] = '';
                $postData["timeout"] = $this->data['timeout'];
                $postData['subOrders'] = array();
                $postData['authCode'] = '';
                $postData["openId"] = '';//微信公众号openId
                $arr2 = array(
                    'receiver' => isset($this->data['customer_name']) ? trim($this->data['customer_name']) :'',
                    'phoneNum' => isset($this->data['phoneNum']) ? trim($this->data['phoneNum']) :'',
                    'address' => '',
                );

                $postData['receiver'] = $arr2;

                require_once $_SERVER['DOCUMENT_ROOT'] . '/yeepay/libs/YopClient.php';
                require_once $_SERVER['DOCUMENT_ROOT'] . '/yeepay/libs/YopClient3.php';
                require_once $_SERVER['DOCUMENT_ROOT'] . '/yeepay/libs/Util/YopSignUtils.php';
                header('content-type:text/html;charset=utf8');

                $order_res = $this->order($postData);

                dump($order_res);die;
            }
            if ($this->payment_mid['p_id'] == 3) {
                header("Content-Type: text/html; charset=utf-8");
                $orderAmount = $this->order_amount*100;

                $merchantId = $this->payment_mid['memberid'];

                $shop_data['merchantId'] = $merchantId;

                $shop_data['merchantName'] = " 裕 福 商 贸 ";
                $shop_data['sumGoodsName'] .= $this->data['productName'];
                $shop_data['orderAmt'] = "" . $orderAmount . "";

                $merchantSettleInfo_arr = json_encode(array($shop_data));

                $arr = array(
                    'version' => '1.0.0',
                    'merchantId' => $merchantId,
                    'merchantOrderId' => $this->orderid,
                    'merchantOrderTime' => date('YmdHis'),
                    'merchantOrderAmt' => '' . $orderAmount . '',
                    'merchantOrderCurrency' => '156',
                    'gwType' => '02',
                    'frontUrl' => U("Notify/notify", array('apitype' => $this->payment_mid['p_id'], 'method' => 'return'), false, true),           //前台跳转地址,
                    'backUrl' => U("Notify/notify", array('apitype' => $this->payment_mid['p_id'], 'method' => 'notify'), false, true),//异步通知,
                    'bankId' => $this->bankName,
                    'userType' => '01',
                    'merchantUserId' => "" . $this->data['customer_name'] . "",
                    'merchantSettleInfo' => $merchantSettleInfo_arr,
                    'transTimeout' => '1440'
                );
                $url = 'http://www.yfpayment.com/payment/payset.do';
                $signKeyPath = 'cert/3/000001520100000667/user-rsa.pfx';
                $public_key = 'cert/3/000001520100000667/pubkey.cer';
                $result = check_verify($arr, $url, $merchantId, $signKeyPath, $public_key);

                if ($result['p']['respCode'] == 0000) {

                    $re_url = 'http://www.yfpayment.com/payment/payshow.do';

                    $params = array(
                        "version" => $arr['version'],
                        "merchantId" => $merchantId,
                        "token" => $result['p']['token'],
                    );
                    $res = encryption($params, $merchantId, $signKeyPath);
//                    dump($res);
                    echo('<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><title>提交跳转</title></head><body>');
                    echo('<form method="post" name="paybb_form" target="_parent" action="' . $re_url . '">'); //接口商城地址
                    echo('<input type="hidden" name="merchantId" value="' . $res['merchantId'] . '" />');
                    echo('<input type="hidden" name="data" value="' . $res['data'] . '" />');
                    echo('<input type="hidden" name="enc" value="' . $res['enc'] . '" />');
                    echo('<input type="hidden" name="sign" value="' . $res['sign'] . '" />');
                    echo('</form>');
                    echo('</form><script type="text/javascript">paybb_form.submit();</script>');
                    echo('</body></html>');
                    die();
                }

            }
            if ($this->payment_mid['p_id'] == 4) {
            }
            if ($this->payment_mid['p_id'] == 5) {
            }

        } else {
            $this->display();
        }

    }

    private function order($params){
        $params = json_encode($params);
        /*商户私钥*/
        $private_key ='MIIEowIBAAKCAQEAmh/6DovrldfpXvx7ErX2GhrU1Rp4Mv0dKLrI5Cdl1fsQD9ZtpfaZA6OAGWHdvYDifBZEdVd9Mt0iScIWHBGmeZg25dtWRow/Ee/iyUJx2E6YEl66vgRE50Fyf1/xZpLLPJjT+rmKjrm6RVzuR7QdxJB/GYbWWk/nce8+YB3b0jJi6B6eYVvm5Vh6BtrDv4jprRuJZW8JF8htSUgSuPsxpgRmboVCd8JzeAi1uP0xU+JgZWymQpSUItf6lD2XU6NHK6nHoFGFSM/Hf0ZRmpfg5033SZUuXWz/RucuK9N/erdEweJ3iVFliLobXjb6JdIbP9z3Bvks47veJJX3Scp5NwIDAQABAoIBAFKMP+TcohA+dRrPxacu2CIBLu74X1qH4L8403IHe+6QqnihE1cpbajaQDjYBuiBiEyHrKDgfAjrEXtJvYfJGE3V7clMobflU75qqh+7O7hr19026XPuW200y3tXSrbydnH9NMP77i8lYJPYAzNaT/tAnSJx6oqycza9ub3HID5CsWxX7Th3v1lbXVnufM8sOGqKfdNXv9Lop3AzONKyplJukrEXlwDozyEjkq3Gydu8nDwjYl5JqOh4lu8UO8AMOsYEB09W6hFIuFNvbpXoQOjvbJtVmXI8rMspgq4QFHNh2booIBfJO3Fz20MC2nwsFJ2pHl49DvIoYmD/xhCCOSECgYEA5SeXIhXfPEo2SRo+3lii/z9d+tMepsRNjhbAz8E6ZHlukxrSXF411fC1bb0RszsDR9VTduYiQMJVB+hKXC7L4SsYwkJskI882qyqJOywvzpd8QjB0vDq39/jwRE7UwUsboURgPch+F38lEgz6JBSe4z2ILoUBu4OZxSE+pMjYKcCgYEArC45a/+3vjWe/ORiJJBaSEmAQwli85LNvg7WdW4nygXb4inxZrSEdDSbiWFHJj0sffSQxp41oyCrj5/mhSkz8ZQUvAfTQJZ1Yg2XnbjYCS73YR05zo5esv1VBiuTKNLhBw72+UUqkUVSb5LT4LgWE94Qpie0KmC30yqRodSTJPECgYAI9U1BNd2uO7B3lyESDCEDHXUNEyfFmTL29QjAlmsz9lNOSOQkXEJ6hJhzG8sPWKU+L6a9pS19nps4XepaRDIQMWEcZwBbfl4ApnNYUjBuqVd2zsLU/joQWm5K4+OP0Un1YBpZElAvp2zyVwhAdTPkRJRynxOdWb0SZoj0SsA9TQKBgQCloCl4bBoSDH6NghuuVHWkR5/r3GGlMDhddORzPa1ktlIXsoUWaNto9RoRAtRwQjRETTfe911dOBYQKJ6UxVfEMM/pOBXMcW8lDTIldCPMYbNxZa2vtl/+CZb6QnxirsfsBEcq7Y/PAkIUNcc+yZXjMqANVPAIO9VYegBxDY0l4QKBgB+jwy/RNwmHXJ/8nfyTYVW5yp9fO82Mkn/JXMCldFqo5vG9k+OvW1WoQzXAzQJ9lL2eUmNayORSLHThiBENNBCibOZl6a0ql2FVMQCexBS7vW8X3bJ9yDhrQZ7c4O+ePQ4Jyc2Jcd2gRTDw7KdFXqDk0IfvPS0FFpmEW6Y1sE1L';

        /*YOP公钥*/
        $yop_public_key ='MIIBCgKCAQEAmh/6DovrldfpXvx7ErX2GhrU1Rp4Mv0dKLrI5Cdl1fsQD9ZtpfaZA6OAGWHdvYDifBZEdVd9Mt0iScIWHBGmeZg25dtWRow/Ee/iyUJx2E6YEl66vgRE50Fyf1/xZpLLPJjT+rmKjrm6RVzuR7QdxJB/GYbWWk/nce8+YB3b0jJi6B6eYVvm5Vh6BtrDv4jprRuJZW8JF8htSUgSuPsxpgRmboVCd8JzeAi1uP0xU+JgZWymQpSUItf6lD2XU6NHK6nHoFGFSM/Hf0ZRmpfg5033SZUuXWz/RucuK9N/erdEweJ3iVFliLobXjb6JdIbP9z3Bvks47veJJX3Scp5NwIDAQAB';

        $request = new \YopRequest('cbp_120180633', $private_key,'https://open.yeepay.com/yop-center',$yop_public_key);

        $request->setJsonParam($params);

        //提交Post请求
        $response = \YopClient3::post("/rest/v1.0/kj/onlinepay/order", $request);
        if($response->validSign==1){
            echo "返回结果签名验证成功!\n";
        }

        // 判断status 如果是REDIRECT 则跳转到收银台
        $json_array =$response->stringResult;
        if(json_decode($json_array,true)["status"]=='REDIRECT'){

            $url=json_decode($json_array,true)["redirectUrl"];
            header("Location: $url");
        }elseif(json_decode($json_array,true)["status"]=='FAILURE'){
            $response = json_decode($response,true);
            $error = array('errorCode'=>'1','msg'=>$response['error']['message']);
            echo json_encode($error);
            die();
        }
        dump(json_decode($response,true));die;

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
    /**
     * 检查黑名单
     * @param $Username 用户名
     * @param $telphone 电话
     * @param $userid   证件号
     * @param $bankcard 银行卡号
     */
    public function black($Username, $telphone, $userid, $bankcard){
        $url = 'http://api.canbesystems.com';
        $Key = 'V5XVxE0F0y6tXSyo0xUhkMgF5MLwourbaKAvXqF7hOG';
        $type = '0';
        $sign = strtoupper(MD5($bankcard . $type . $telphone . $userid . $Username . $Key));

        $postData['Username'] = $Username;
        $postData['telphone'] = $telphone;
        $postData['userid'] = $userid;
        $postData['bankcard'] = $bankcard;
        $postData['type'] = $type;
        $postData['sign'] = $sign;

        return httpPost($url,$postData);
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