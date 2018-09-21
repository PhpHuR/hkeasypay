<?php
// +----------------------------------------------------------------------
// | Copyright (c) 2015-2016 http://www.ebpays.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: xiaofeng<1034023036@qq.com>
// +----------------------------------------------------------------------
namespace Api\Controller;

use \Think\Controller;

class PayinController extends Controller
{
    private $userinfo;
    private $payment_name;
    private $payment_mid = array();
    private $payin_rate;
    private $orderid;
    private $order_amount;
    private $bankName;
    private $product;

    private $username;
    private $identitycard;

    protected function _initialize()
    {
        //必须传输的字段
        $company_code = I('company_code');//由我們提供，於系統中的公司代碼。
        $order_number = I('order_number');//訂單號碼，可由客戶自訂，但必須是獨立且不能 與其他訂單重覆。
        $order_amount = I('order_amount');//入金訂單金額。
        $pay_id = I('pay_id');//銀行代碼，請參閱附件。
        $return_url = I('return_url');//完成支付後所跳轉的頁面。
        $notify_url = I('notify_url');//接收成功支付通知的頁面。
        $sign = I('sign');//以sha-256方式加密參數及由我們提供的鑰匙。加密米啊哟
        $timestamp = I('timestamp');//订单发起时间-時間郵戳
        $base64_memo = I('base64_memo');//備注。
        $payuser_id = I('payuser_id');//備注。
        $sign_type = I('sign_type');//SHA256。
        $version = I('version');//1.0。
        $card_type = I('card_type');//01:借記卡
        $payin_method = I('payin_method');
        $source = I('source');

        $this->username = I('username');
        $this->identitycard = I('identitycard');
        //支付提交方式，默认不填写就是api 填写了就是填写的
        if (empty($payin_method)) {
            $payin_method = 'API';
            $source = $_SERVER['HTTP_REFERER'];
        }
        $MARK = "&";
        if ($order_amount < 0.01) {
            $this->error('订单金额和订单号传入错误，请核对后再提交');
            die();
        }
        if ($company_code) {
            $this->userinfo = M('userinfo')->where(array('user_id' => $company_code))->find();
        } else {
            $this->error('商户号传入错误，请核对后再提交');
            die();
        }
        if (empty($order_amount) or empty($order_number)) {
            $this->error('订单金额和订单号传入错误，请核对后再提交');
            die();
        }
        $cert_number = isset($_POST['cert_number']) ? trim($_POST['cert_number']) : '';
        if (empty($cert_number)) {
            $this->error('没有输入证件号，请核对后再提交');
            die();
        }

        if(empty(trim(I('customer_name')))){
            $this->error('没有输入姓名，请核对后再提交');
            die();
        }

        if(empty(trim(I('tel')))){
            $this->error('没有输入电话号码，请核对后再提交');
            die();
        }
        
        $bank_number = isset($_POST['bank_number']) ? trim($_POST['bank_number']) : '';
        if (empty($bank_number)) {
            $this->error('没有输入银行卡号，请核对后再提交');
            die();
        }
        if (empty($pay_id)) {
            $this->error('请选择银行');
            die();
        }  if($pay_id == 'weixin'){
        //港币变人民币
        $currency_id = 3;
    }

        //针对客户做定制功能

        //--begin
        if ($company_code == '8822') {
            $safe_id = M('safe')->where(array('safe_id' => $payuser_id))->find();
            if ($safe_id) {
                $fp = @fopen("safe_id.txt", "a+");
                fwrite($fp, "客户保单号" . $payuser_id . "---" . date('Y-m-d H:i:s') . "消费金额---" . $order_amount . "\n");
                fclose($fp);
            } else {
//                $this->error('保单号错误，请联系商户获取保单号！');
//                die();
            }
        }
        //--end
        //定制功能结束

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
            $this->error('签名错误');
            die();
        }
        //该位置写入数据库订单
        $time = time();
        $orderid = createOrder($company_code);
        $this->orderid = $orderid;
        $free = $order_amount * $this->payin_rate;
        $commission_c = $order_amount * ($this->payin_rate - $payin_rate['inprice'] - $payin_rate['ag_rate']);
        $commission_ag = $order_amount * $payin_rate['ag_rate'];
//        计算当天人民币兑换港币
        if(in_array($company_code,C('TMPL_HKD'))){
            $order_amount_hkd = cursell_hkd($order_amount,8813);
            $free_hkd = cursell_hkd($free,8813);
            $currency_id = 3;
        }

        $data = array(
            'uid' => $company_code,
            'payment_mid' => $this->payment_mid['m_id'],
            'orderid' => $orderid,
            'transid' => $order_number,
            'currency_id' => isset($currency_id) ? $currency_id : 1,
            'ordermoney' => $order_amount,
            'ordermoney_hkd' => isset($order_amount_hkd) ? $order_amount_hkd : '',
            'product_id' => $product_id,
            'remark' => $base64_memo,
            'paybank' => $pay_id,
            'realname' => I('customer_name'),
            'mobile' => I('tel'),
            'idcard' => I('cert_number'),
            'bankcard' => I('bank_number'),
            'payment_id' => $this->payment_mid['p_id'],
            'begin_time' => $time,
            'free' => $free,
            'free_hkd' =>isset($free_hkd) ? $free_hkd : '',
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


        $check_data = M('check_list')->where(array('u_id'=>$company_code))->find();
        if($check_data['status'] == 1 && $check_data['number'] > 0){
//            创建鉴权订单号
            $jian_id = 'J'.createOrder($company_code);
//            检查是否启用

            //        引入鉴权控制器
            $bankData['realname'] = I('customer_name');
            $bankData['bankcard'] = I('bank_number');
            $bankData['idcard'] = I('cert_number');
            $bankData['mobile'] = I('tel');
            $bankData['ip'] = $_SERVER['REMOTE_ADDR'];

            $c_num['number'] = $check_data['number'] -1;
            if($check_data['warring_state'] == 1){
                $content = '【易通财】报警信息，您现在的可用条数是'.$c_num['number'].'条，为防止鉴权无法使用，请尽快充值';
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
            //        是国内身份证的就检验国内身份证
            if(I('cert_type') == 1){
                $jian_res = getJianQuan($bankData,'idcard');

                if($jian_res['error_code'] != 0){
                    $bankData['res'] = 2;
                    $bankData['reason'] = $jian_res['reason'];
                    $log_res = idcard_log($company_code,$bankData,$orderid);
                    if(!$log_res){
                        $this->error('导入实名身份证失败');
                        die;
                    }
                    $this->error($jian_res['reason']);
                    die();
                }
                $log_res = idcard_log($company_code,$jian_res['result'],$orderid);
                if(!$log_res){
                    $this->error('导入实名身份证失败');
                    die;
                }

            }

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
                $this->error('查询借贷数据失败');
                die;
            }

            $log_res = jiedai_log($company_code,$cheat_res,$jian_id,$_POST['tel']);
            if(!$log_res){
                $this->error('导入多头借贷数据失败');
                die;
            }

            $cheat_res1 = cheat($bankData,'anti_url');
            if($cheat_res1['mobile_status']['code'] != 0){
                $this->error('查询反欺诈数据失败');
                die;
            }
            $log_res = fanqizha_log($company_code,$cheat_res1,$orderid);
            if(!$log_res){
                $this->error('导入反欺诈数据失败');
                die;
            }


        }elseif($check_data['status'] == 1 && $check_data['number'] == 0){
//            次数用尽就直接扣钱包的钱
            $wallet = M('wallet_list')->where(array('user_id'=>$company_code))->getField('money');
            if($wallet < $check_data['money_num']){
                $this->error('钱包余额不足，请充值');
            }
            $res_wall = $wallet-$check_data['money_num'];
            M('wallet_list')->where(array('user_id'=>$company_code))->save(array('money'=>$res_wall));
        }
        //校验订单重复性 商户ID， 订单号，金额， 状态 和提交的一样就更新订单，否则检测订单号重复。
        /*
         * 'uid'=>$company_code,'transid'=>$order_number,'ordermoney'=>$order_amount,'begin_time'=>$timestamp,'status'=>'0',
         */
        $transid = M('payin')->where(array('uid' => $company_code, 'transid' => $order_number, 'ordermoney' => $order_amount, 'status' => '0'))->find();
        if ($transid) {
            $transid_update = M('payin')->where(array('uid' => $company_code, 'transid' => $order_number, 'ordermoney' => $order_amount, 'status' => '0'))->save($data);
            if (!$transid_update) {
                $this->error('订单提交异常，请重新提交');
                die();
            }
            $transid_check = M('payin')->where(array('transid' => $order_number, 'ordermoney' => array('neq', $order_amount)))->find();
            if ($transid_check) {
                $this->error('订单号重复，请重新提交');
                die();
            }
        } else {
//            检查黑名单
            $user_check = $this->back($_POST['customer_name'],$_POST['tel'],$_POST['cert_number'],$_POST['bank_number']);
            $arr_res = json_decode($user_check,true);
            if($arr_res['status']==1){
                $this->error('黑名单');
                die();
            }
            //写入数据库
            $rst = M('payin')->add($data);
            if (!$rst) {
                $this->error('订单错误，请重新提交');
                die();
            }
            $payininfo_data = array(
                'payin_id' => $rst,
                'uid' => $company_code,
                'customer_name' => isset($_POST['customer_name']) ? trim($_POST['customer_name']) : '',
                'customer_id' => isset($_POST['customer_id']) ? trim($_POST['customer_id']) : '',
                'cert_type' => isset($_POST['cert_type']) ? trim($_POST['cert_type']) : '',
                'cert_number' => isset($_POST['cert_number']) ? trim($_POST['cert_number']) : '',
                'email' => isset($_POST['email']) ? trim($_POST['email']) : '',
                'tel' => isset($_POST['tel']) ? trim($_POST['tel']) : '',
                'bank_number' => isset($_POST['bank_number']) ? trim($_POST['bank_number']) : '',
                'update_time' => $time
            );
            $payininfo = M('payininfo')->add($payininfo_data);
        }
    }

    public function index()
    {
        if (IS_POST) {
            if ($this->payment_mid['p_id'] == 1) { //微信展宇
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
                $code_url = $arr['parameters']['returnMsg']; //二维码内容

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
            if ($this->payment_mid['p_id'] == 2) { //易宝
                $orderAmount = $this->order_amount;
                $postData = array();

                $postData["orderAmount"] = strval($orderAmount*100);//订单金额
                $postData["orderCurrency"] = 'CNY';//订单币种
                $postData["requestId"] =  $this->orderid;//訂單號碼，可由客戶自訂，但必須是獨立且不能 與其他訂單重覆。;
                //        $postData["notifyUrl"] = 'http://qa.ehking.com/sdk/onlinepay/notify';//异步通知
                $postData["notifyUrl"] = U("Notify/notify", array('apitype' => $this->payment_mid['p_id'], 'method' => 'notify'), false, true);//异步通知
//        $postData["callbackUrl"] = 'http://qa.ehking.com/sdk/callback'; //前台页面通知地址
                $postData["callbackUrl"] = U("Notify/notify", array('apitype' => $this->payment_mid['p_id'], 'method' => 'return'), false, true); //前台页面通知地址
                $postData["remark"] = 'remark';//备注
                $postData['paymentModeCode'] = '';

                $arr[0]['name'] = '商品';
                $arr[0]['quantity'] = '1';
                $arr[0]['amount'] = strval($orderAmount*100);
                $arr[0]['receiver'] = '';
                $arr[0]['description'] = '';
                $postData['productDetails'] = $arr;
                $arr1 = array(
                    'name' => isset($_POST['customer_name']) ? trim($_POST['customer_name']) :'',
                    'phoneNum' => isset($_POST['tel']) ? trim($_POST['tel']) :'',
                    'email' => isset($_POST['email']) ? trim($_POST['email']) :'',
                    'idType' =>'IDCARD',
                    'idNum ' =>isset($_POST['cert_number']) ? trim($_POST['cert_number']) :'',
                    'bankCardNum' =>isset($_POST['bank_number']) ? trim($_POST['bank_number']) :'',
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
                $postData["timeout"] = '1440';
                $postData['subOrders'] = array();
                $postData['authCode'] = '';
                $postData["openId"] = '';//微信公众号openId
                $arr2 = array(
                    'receiver' => isset($_POST['customer_name']) ? trim($_POST['customer_name']) :'',
                    'phoneNum' => isset($_POST['tel']) ? trim($_POST['tel']) :'',
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
            if ($this->payment_mid['p_id'] == 3) {//欲福支付
                $orderAmount = $this->order_amount*100;

                $merchantId = $this->payment_mid['memberid'];

                if(I('bank_type') == 1){
                    $shop_data['merchantId'] = $merchantId;

                    $shop_data['merchantName'] = " 商 贸 ";
                    $shop_data['sumGoodsName'] .= "商品";
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
                        'merchantUserId' => "" . I('company_code') . "",
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
//                    $postData['merchantId'] = $res['merchantId'];
//                    $postData['data'] = $res['data'];
//                    $postData['enc'] = $res['enc'];
//                    $postData['sign'] = $res['sign'];
//
//                    $res = httpPost($url, $postData);
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
                }elseif (I('bank_type') == 2){
                        //                    快捷通道

                        $name = I('company_code');

                        $cardNo = I('bank_number');

                        $certNo = I('cert_number');

                        $phone = I('tel');

                        $merchantOrderTime = date("Ymdhis",time());

                        $Auth_arr = array(
                            'version' => '1.0.0',
                            'authType' => '05',
                            'merchantId' => $merchantId,
                            'merchantOrderId' => $this->order,
                            'merchantOrderTime' => $merchantOrderTime,
                            'authUserName' => $name,
                            'authUserIdCard' => $certNo,
                            'authUserBankCardNo' => $cardNo,
                            'authUserPhone' => $phone,
                        );

                        $auth_url = 'http://www.yfpayment.com/payment/authentication.do';
                        $signKeyPath = 'cert/3/000001520100000667/user-rsa.pfx';
                        $public_key = 'cert/3/000001520100000667/pubkey.cer';
                        $result = check_verify($Auth_arr,$auth_url,$merchantId,$signKeyPath,$public_key);

                        if ($result['p']['respCode'] == 0000) {

                            if ($result['p']['authResult'] == 3) {
                                $data['msg'] = "银行无响应，请稍后重试";
                                $data['status'] = 0;
                                $this->error('银行无响应，请稍后重试');
                            }

                            if ($result['p']['authResult'] == 2) {
                                $data['msg'] = "验证未通过（验证要素不匹配）";
                                $data['status'] = 0;
                                $this->error('验证未通过（验证要素不匹配）');
                            }

                            if ($result['p']['authResult'] == 1) {

                                $order_amount = $orderAmount * 100;

                                $add_time = time();

                                $add_time = date('YmdHis', $add_time);

                                $shop_data['merchantId'] = $merchantId;

                                $shop_data['merchantName'] = " 裕 福 商 贸 ";

                                $shop_data['sumGoodsName'] .= "，商品";


                                $shop_data['orderAmt'] = "" . $order_amount . "";

                                $merchantSettleInfo_arr = json_encode(array($shop_data));

                                $card_arr = array(
                                    'name' => $name,
                                    'cardNo' => $cardNo,
                                    'certNo' => $certNo,
                                    'bankNo' => 'CDB',
                                    'cardType' => 'P1',
                                    'certType' => '01',
                                    'phone' => $phone,
                                );

                                $payCardList_arr = json_encode(array($card_arr));

                                $arr = array(
                                    'version' => '1.0.0',
                                    'merchantId' => $merchantId,
                                    'merchantOrderId' => $this->order,
                                    'merchantOrderTime' => $add_time,
                                    'merchantOrderAmt' => '' . $order_amount . '',
                                    'merchantOrderCurrency' => '156',
                                    'gwType' => '04',
//            'frontUrl' => 'http://hp.ydshops.com/index.php/Home/Payment/getQuickFront',
                                    'backUrl' => 'http://hp.ydshops.com/index.php/Home/Payment/getQuickBack',
                                    'merchantUserId' => '255',
                                    'merchantOrderDesc' => 'merchantOrderDesc',
                                    'merchantSettleInfo' => $merchantSettleInfo_arr,
                                    'payCardList' => $payCardList_arr,
                                    'transTimeout' => '1440'
                                );

                                $url = 'http://www.yfpayment.com/payment/service/payset.do';

                                $rs = check_verify($arr, $url, $merchantId, $signKeyPath, $public_key);
                                dump($rs);
                                if ($rs['p']['respCode'] == 0000) {

                                    $key = 'iiewefv255f56g_55sadsdhppoirqv3655mj';

                                    $str_data = json_encode($rs['curl_data']);

                                    $encrypt_data = authcode($str_data, 'ENCODE', $key, 0); //加密 ;

                                    $data['order_id'] = $this->order;

                                    $data['encrypt'] = $encrypt_data;

                                    $data['status'] = 1;

                                    $this->ajaxReturn($data, 'JSON');
                                }

                            }
                        }
                }
            }
            if ($this->payment_mid['p_id'] == 4) {
                $orderAmount = $this->order_amount;
                $postData = array();

                $postData["orderAmount"] = strval($orderAmount*100);//订单金额
                $postData["orderCurrency"] = 'CNY';//订单币种
                $postData["requestId"] =  $this->orderid;//訂單號碼，可由客戶自訂，但必須是獨立且不能 與其他訂單重覆。;
                //        $postData["notifyUrl"] = 'http://qa.ehking.com/sdk/onlinepay/notify';//异步通知
                $postData["notifyUrl"] = U("Notify/notify", array('apitype' => $this->payment_mid['p_id'], 'method' => 'notify'), false, true);//异步通知
//        $postData["callbackUrl"] = 'http://qa.ehking.com/sdk/callback'; //前台页面通知地址
                $postData["callbackUrl"] = U("Notify/notify", array('apitype' => $this->payment_mid['p_id'], 'method' => 'return'), false, true); //前台页面通知地址
                $postData["remark"] = 'remark';//备注
                $postData['paymentModeCode'] = $this->bankName;
                dump($this->bankName);die;

                $arr[0]['name'] = '商品';
                $arr[0]['quantity'] = '1';
                $arr[0]['amount'] = strval($orderAmount*100);
                $arr[0]['receiver'] = '';
                $arr[0]['description'] = '';
                $postData['productDetails'] = $arr;
                $arr1 = array(
                    'name' => isset($_POST['customer_name']) ? trim($_POST['customer_name']) :'',
                    'phoneNum' => isset($_POST['tel']) ? trim($_POST['tel']) :'',
                    'email' => isset($_POST['email']) ? trim($_POST['email']) :'',
                    'idType' =>'IDCARD',
                    'idNum ' =>isset($_POST['cert_number']) ? trim($_POST['cert_number']) :'',
                    'bankCardNum' =>isset($_POST['bank_number']) ? trim($_POST['bank_number']) :'',
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
                $postData["timeout"] = '1440';
                $postData['subOrders'] = array();
                $postData['authCode'] = '';
                $postData["openId"] = '';//微信公众号openId
                $arr2 = array(
                    'receiver' => isset($_POST['customer_name']) ? trim($_POST['customer_name']) :'',
                    'phoneNum' => isset($_POST['tel']) ? trim($_POST['tel']) :'',
                    'address' => '',
                );

                $postData['receiver'] = $arr2;

                require_once $_SERVER['DOCUMENT_ROOT'] . '/yeepay/libs/YopClient.php';
                require_once $_SERVER['DOCUMENT_ROOT'] . '/yeepay/libs/YopClient3.php';
                require_once $_SERVER['DOCUMENT_ROOT'] . '/yeepay/libs/Util/YopSignUtils.php';
                header('content-type:text/html;charset=utf8');

                $order_res = $this->order($postData);
                $arr = json_decode($order_res);
                dump($arr);die;
            }
                if ($this->payment_mid['p_id'] == 5) {
                }
            if ($this->payment_mid['p_id'] == 5) {
            }
        } else {
            $this->display();
        }

    }

    /**
     * @param $Username 用户名
     * @param $telphone 电话
     * @param $userid   证件号
     * @param $bankcard 银行卡号
     */
    public function back($Username, $telphone, $userid, $bankcard){
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

        return $this->setHttpCurl($url,$postData,'post');
    }
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
        //取得返回结果
        $arr = json_decode($response);
//        dump($arr);
        // 判断status 如果是REDIRECT 则跳转到收银台
        $json_array =$response->stringResult;
        if(json_decode($json_array,true)["status"]=='REDIRECT'){

            $url=json_decode($json_array,true)["redirectUrl"];
            header("Location: $url");
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