<?php
// +----------------------------------------------------------------------
// | Copyright (c) 2015-2016 http://www.ebpays.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: xiaofeng<1034023036@qq.com>
// +----------------------------------------------------------------------

namespace Api\Controller;

use Think\Controller;

class NotifyController extends Controller
{
    /**
     * 支付结果返回
     */
    public function notify()
    {
        $apitype = $_GET['apitype'];
        $method = $_GET['method'];
        $endtime = time();
        if ($apitype == 1) {//展宇
            if ($method == 'notify') {
                $data = $_REQUEST['order'];
                $data = json_decode($data,true);
//                dump($_REQUEST);die;
//                $fp = @fopen("notify.txt", "a+");
//                fwrite($fp, var_export($_POST, true));
//                fclose($fp);
                $notify_time = trim($data['payment']['completeDateTime']);
                $sign = trim($data['hmac']);
                $outer_trade_no = trim($data['orderNo']);  //商户订单号
                $inner_trade_no = trim($data['merchantNo']);  //支付公司订单号
                $trade_amount = trim($data['amount']);
                $orderCurrency = trim('CNY');//订单币种
                $orderAmount = trim($data['orderAmount']);//订单金额
                $trade_status = trim($data['status']);
                $serialNumber = trim($data['serialNumber']);
                $totalRefundCount = trim($data['totalRefundCount']);
                $totalRefundCount = trim($data['totalRefundCount']);
                $totalRefundAmount = trim($data['totalRefundAmount']);
                $remark = trim($data['remark']);
                $payment = trim($data['payment']);
                $subOrder = trim($data['subOrder']);

                if ($trade_status != '1') {
                    $fp = @fopen("1_weixin_payin.txt", "a+");
                    fwrite($fp, date('Y-m-d H:i:s')."--"."交易状态异常，请校对");
                    fclose($fp);
                    die();
                }
                echo "SUCCESS";
                $info = M('payin')->field('payin_id,uid,transid,currency_id,paybank,product_id,payment_id,payment_mid,orderid,ordermoney,free,notifyurl,returnurl,begin_time,end_time,remark,status,source')->where(array('orderid' => $outer_trade_no, 'status' => '0'))->find();
                if ($info) {
                    $varule = (M('order_log')->where(array('orderid' => $info['orderid']))->find());
                    if (!$varule) {
                        $userinfo = M('user_balance')->field('sumcount,availablecount')->where(array('user_id' => $info['uid'], 'currency_id' => $info['currency_id']))->find();
//                        $fp = @fopen("n1.txt", "a+");
//                        fwrite($fp, var_export($userinfo, true));
//                        fclose($fp);
                        //                        港币变人民币
                        $trade_amount = cursell_cny($trade_amount,8813);
                        $fee = number_format($info['ordermoney'] * getPayinRate($info['product_id']), 4, '.', '');

                        $data = array('factmoney' => $trade_amount, 'free' => $fee, 'pay_orderid' => $inner_trade_no, 'end_time' => $endtime, 'status' => '1');
                        //订单状态修改
                        $Orderstatus = M('payin')->where(array('payin_id' => $info['payin_id']))->save($data);
                        if(in_array($info['uid'],C('TMPL_HKD'))){
//                            转换成港币计算
                            $income_hkd = cursell_hkd($info['ordermoney'],$info['uid']);
                            $outlay_hkd = cursell_hkd($fee,$info['uid']);
                            $sumcount = $userinfo['sumcount'] + $income_hkd - $outlay_hkd;
                            $availablecount = $userinfo['availablecount'] + $income_hkd - $outlay_hkd;
                        }else{
                            $sumcount = $userinfo['sumcount'] + $info['ordermoney'] - $fee;
                            $availablecount = $userinfo['availablecount'] + $info['ordermoney'] - $fee;
                        }
                        //支付成功记录
                        if ($Orderstatus) {

                            $UserInfo = M('user_balance')->where(array('user_id' => $info['uid'], 'currency_id' => $info['currency_id']))->save(array('sumcount' => $sumcount, 'availablecount' => $availablecount));
//                            $fp = @fopen("n2.txt", "a+");
//                            fwrite($fp, var_export($UserInfo, true));
//                            fclose($fp);
                            //發送客戶消息
                            $chatId_case = getChatId($info['uid'],0);
                            if ($chatId_case) {
                                if(in_array($info['uid'],C('TMPL_HKD'))){
                                    $message_case = "<code>訂單號: " . $info['orderid'] . "</code>%0A<code>金額: CNY " . number_format($info['ordermoney'], 2, '.', ',') . "</code>%0A<code>更新日期: " . date('Y-m-d', $data['end_time']) . "</code>%0A<code>更新時間: " . date('H:i:s', $data['end_time']) . "</code><code>支付类型: 入金</code>";
                                }else{
                                    $message_case = "<code>訂單號: " . $info['orderid'] . "</code>%0A<code>金額: CNY " . number_format($info['ordermoney'], 2, '.', ',') . "</code>%0A<code>更新日期: " . date('Y-m-d', $data['end_time']) . "</code>%0A<code>更新時間: " . date('H:i:s', $data['end_time']) . "</code><code>支付类型: 入金</code>";
                                }
                                //發送到客戶

                                telegramSendMessage($chatId_case, $message_case,1);
                            }

                            if($info['uid']<>8825 && $info['uid']<>8832){
                                $chatId_master = "-238443852";
                                if(in_array($info['uid'],C('TMPL_HKD'))){
                                    $message_master = "<code>供應商: " . getPaymentName($info['payment_id']) ."-".getSubUserBalanceAttributeName($info['paybank']). "</code>%0A<code>MID: " . getMidName($info['payment_mid']) . "</code>%0A<code>入金客戶: " . getUserinfoName($info['uid']) . "</code>%0A<code>訂單號: " . $info['orderid'] . "</code>%0A<code>金額: CNY " . number_format($info['ordermoney'], 2, '.', ',') .  "</code>%0A<code>可用餘額: hkd " . number_format($availablecount, 2, '.', ',')."</code>%0A<code>更新日期: " . date('Y-m-d', $data['end_time']) . "</code>%0A<code>更新時間: " . date('H:i:s', $data['end_time']) . "</code>";
                                }else{
                                    $message_master = "<code>供應商: " . getPaymentName($info['payment_id']) ."-".getSubUserBalanceAttributeName($info['paybank']). "</code>%0A<code>MID: " . getMidName($info['payment_mid']) . "</code>%0A<code>入金客戶: " . getUserinfoName($info['uid']) . "</code>%0A<code>訂單號: " . $info['orderid'] . "</code>%0A<code>金額: CNY " . number_format($info['ordermoney'], 2, '.', ',') .  "</code>%0A<code>可用餘額: CNY " . number_format($availablecount, 2, '.', ',')."</code>%0A<code>更新日期: " . date('Y-m-d', $data['end_time']) . "</code>%0A<code>更新時間: " . date('H:i:s', $data['end_time']) . "</code>";
                                }

                                telegramSendMessage($chatId_master, $message_master,1);

                            }

                            if ($UserInfo) {
                                if(in_array($info['uid'],C('TMPL_HKD'))){
                                    PayinSubUserBalanceUpdate($info['uid'],$info['payment_mid'],$info['currency_id'],$info['paybank'],$income_hkd - $outlay_hkd);
                                }else{
                                    PayinSubUserBalanceUpdate($info['uid'],$info['payment_mid'],$info['currency_id'],$info['paybank'],$info['ordermoney'] - $fee);
                                }


                                if(in_array($info['uid'],C('TMPL_HKD'))){
//                              把金额转换成港币记录
                                    $income_hkd = cursell_hkd($info['ordermoney'],$info['uid']);
                                    $outlay_hkd = cursell_hkd($fee,$info['uid']);
                                    $datalog1 = array('uid' => $info['uid'], 't_type' => '1', 'orderid' => $info['orderid'], 'income' => $info['ordermoney'],'income_hkd'=> $income_hkd, 'balance' => $sumcount + $fee, 'begin_time' => $info['begin_time'], 'end_time' => $data['end_time'], 'remark' => $info['remark']);
                                    $datalog2 = array('uid' => $info['uid'], 'orderid' => $info['orderid'], 't_type' => '4', 'outlay' => $fee,'outlay_hkd'=>$outlay_hkd, 'balance' => $sumcount, 'begin_time' => $info['begin_time'], 'end_time' => time(), 'remark' => '');
                                }else{
                                    //寫入子賬戶餘額
                                    $datalog1 = array('uid' => $info['uid'], 't_type' => '1', 'orderid' => $info['orderid'], 'income' => $info['ordermoney'], 'balance' => $sumcount + $fee, 'begin_time' => $info['begin_time'], 'end_time' => $data['end_time'], 'remark' => $info['remark']);
                                    //手续费扣除记录
                                    $datalog2 = array('uid' => $info['uid'], 'orderid' => $info['orderid'], 't_type' => '4', 'outlay' => $fee, 'balance' => $sumcount, 'begin_time' => $info['begin_time'], 'end_time' => time(), 'remark' => '');
                                }
                                M('order_log')->add($datalog1);
                                M('order_log')->add($datalog2);

                                //globalspeedlink 入金累计

                            } else {
                                $fp = @fopen("payfo_log.txt", "a+");
                                fwrite($fp, "\r\n" . date("Y-m-d H:i:s") . "   " . $outer_trade_no. "  入款日志写入失败\r\n");
                                fclose($fp);
                            }
                        } else {
                            $fp = @fopen("payfo_log.txt", "a+");
                            fwrite($fp, "\r\n" . date("Y-m-d H:i:s") . "   " . $outer_trade_no . " 入款日志写入失败\r\n");
                            fclose($fp);
                        }
                    } else {
                        $fail_reason = "订单重复";
                        $fp = @fopen("payfo_error_log.txt", "a+");
                        fwrite($fp, "\r\n" . date("Y-m-d H:i:s") . "   " . $fail_reason . "   " . $varule . "入款日志写入失败\r\n");
                        fclose($fp);
                    }

                    //定义变量  加密 然后curl传递给客户-获取返回值
                    $Signkeyi = M('userinfo')->field('md5key')->where(array('user_id' => $info['uid']))->find();

                    $Md5key = $Signkeyi['md5key'];
                    $mMark = "&";
                    $company_code = $info['uid'];
                    $order_number = $info['transid'];
                    $order_amount = $info['ordermoney'];
                    $remark = $info['remark'];
                    $order_status = '1';
                    $system_order_number = $info['orderid'];
                    $sett_date = date('d-m-Y H:i:s', $endtime);
                    $order_fee = $info['free'];
                    $timestamp = time();
                    $sign_type = 'SHA256';
                    $version = '1.0';
                    $string = $company_code . $mMark . $order_number . $mMark . $order_amount . $mMark . $order_status . $mMark . $system_order_number . $mMark . $sett_date . $mMark . $order_fee . $mMark . $timestamp . $mMark . $sign_type . $mMark . $version . $mMark . $Md5key;
                    $sign = hash('sha256', $string);
                    $post_data = array(
                        'company_code' => $company_code,
                        'order_number' => $order_number,
                        'order_amount' => $order_amount,
                        'remark' => $remark,
                        'order_status' => $order_status,
                        'system_order_number' => $system_order_number,
                        'sett_date' => $sett_date,
                        'order_fee' => $order_fee,
                        'timestamp' => $timestamp,
                        'sign_type' => $sign_type,
                        'version' => $version,
                        'orderCurrency'=>$orderCurrency,
                        'sign' => $sign,
                    );
                    $url = $info['notifyurl'];
                    $o = "";
                    foreach ($post_data as $k => $v) {
                        $o .= "$k=" . urlencode($v) . "&";
                    }
                    $post_data = substr($o, 0, -1);
                    //通知五次到客户
                    for ($i = 0; $i < 5; $i++) {

                        $res = curl_post($url, $post_data);
                        $fp = @fopen("notify.txt", "a+");
                        fwrite($fp, $url);
                        fclose($fp);
                        $fp = @fopen("post_data.txt", "a+");
                        fwrite($fp, $post_data);
                        fclose($fp);
                        $fp = @fopen("res_log.txt", "a+");
                        fwrite($fp, $company_code.'###--'.$system_order_number."---".$res . "###--" . $order_number . "--##" . date('Y-m-d H:i:s') . "\n");
                        fclose($fp);
                        if (strpos($res, "success") !== false) {
                            //更新系统通知，并中断循环
                            M('payin')->where(array('payin_id' => $info['payin_id']))->save(array('notice_status' => 1));
                            break;
                        } else {
                            M('payin')->where(array('payin_id' => $info['payin_id']))->save(array('notice_status' => 0));
                            break;
                        }
                    }
                    orderAgentCash($info['uid'], $info['orderid'], $endtime, $info['ordermoney'], $info['paybank'],$info['product_id']);

                }
            }
            if ($method == 'return') {
                $notify_time = trim($_REQUEST['ORDER_TIME']);
                $sign = trim($_REQUEST['SIGN']);
                $outer_trade_no = trim($_REQUEST['orderNo']);  //商户订单号
                $inner_trade_no = trim($_REQUEST['merchantId']);  //系统订单号
                $trade_amount = trim($_REQUEST['ORDER_AMT']);
                $trade_status = trim($_REQUEST['state']);
                $redirectUrl = trim($_REQUEST['redirectUrl']);

                $endtime = time();
                $info = M('payin')->where(array('orderid' => $outer_trade_no))->find();
                if ($info) {
                    //定义变量  加密 然后curl传递给客户-获取返回值
                    $Signkeyi = M('userinfo')->field('md5key')->where(array('user_id' => $info['uid']))->find();
                    $Md5key = $Signkeyi['md5key'];
                    $mMark = "&";
                    $company_code = $info['uid'];
                    $order_number = $info['transid'];
                    $order_amount = $info['ordermoney'];
                    $remark = $info['remark'];
                    $source = $info['source'];
                    $order_status = '2';
                    $system_order_number = $info['orderid'];
                    $sett_date = date('d-m-Y H:i:s', $endtime);
                    $order_fee = $info['free'];
                    $timestamp = time();
                    $sign_type = 'SHA256';
                    $version = '1.0';
                    $string = $company_code . $mMark . $order_number . $mMark . $order_amount . $mMark . $order_status . $mMark . $system_order_number . $mMark . $sett_date . $mMark . $order_fee . $mMark . $timestamp . $mMark . $sign_type . $mMark . $version . $mMark . $Md5key;
                    $sign = hash('sha256', $string);
//                    echo("<script>alert('支付成功');</script>");
                    echo('<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><title>提交跳转</title></head><body>');
                    echo('<form method="get" name="f1" action="' . $info['returnurl'] . '">');
                    echo('<input type="hidden" name="company_code" value="' . $company_code . '" />');
                    echo('<input type="hidden" name="order_number" value="' . $order_number . '" />');
                    echo('<input type="hidden" name="order_amount" value="' . $order_amount . '" />');
                    echo('<input type="hidden" name="remark" value="' . $remark . '" />');
                    echo('<input type="hidden" name="order_status" value="' . $order_status . '" />');
                    echo('<input type="hidden" name="system_order_number" value="' . $system_order_number . '" />');
                    echo('<input type="hidden" name="sett_date" value="' . $sett_date . '" />');
                    echo('<input type="hidden" name="order_fee" value="' . $order_fee . '" />');
                    echo('<input type="hidden" name="source" value="' . $source . '" />');
                    echo('<input type="hidden" name="timestamp" value="' . $timestamp . '" />');
                    echo('<input type="hidden" name="sign_type" value="' . $sign_type . '" />');
                    echo('<input type="hidden" name="version" value="' . $version . '" />');
                    echo('<input type="hidden" name="sign" value="' . $sign . '" />');
                    echo('</form>');
                    echo('<script>function sub(){document.f1.submit();}setTimeout(sub,100);</script>');
                    echo('</body></html>');
                    //处理想处理的事情，验证通过，根据提交的参数判断支付结果
                } else {
                    echo("error'"); //MD5校验失败
                    //处理想处理的事情
                }
            }
        }

        if($apitype == 2){//易宝
            if ($method == 'notify') {
                $post =$_POST['response'];
                $res = $this->keyopen($post);
                $data = json_decode($res,true);

                $notify_time = trim($data['payment']['completeDateTime']);
                $sign = trim($data['hmac']);
                $outer_trade_no = trim($data['requestId']);  //商户订单号
                $inner_trade_no = trim($data['merchantId']);  //系统订单号
                $trade_amount = trim($data['orderAmount']);
                $orderCurrency = trim($data['orderCurrency']);//订单币种
                $orderAmount = trim($data['orderAmount']);//订单金额
                $trade_status = trim($data['status']);
                $serialNumber = trim($data['serialNumber']);
                $totalRefundCount = trim($data['totalRefundCount']);
                $totalRefundCount = trim($data['totalRefundCount']);
                $totalRefundAmount = trim($data['totalRefundAmount']);
                $remark = trim($data['remark']);
                $payment = trim($data['payment']);
                $subOrder = trim($data['subOrder']);

                if ($trade_status != 'SUCCESS') {
                    $fp = @fopen("15_1_yb_payin.txt", "a+");
                    fwrite($fp, date('Y-m-d H:i:s')."--"."交易状态异常，请校对");
                    fclose($fp);
                    die();
                }
                echo "SUCCESS";
                $info = M('payin')->field('payin_id,uid,transid,currency_id,paybank,product_id,payment_id,payment_mid,orderid,ordermoney,free,notifyurl,returnurl,begin_time,end_time,remark,status,source')->where(array('orderid' => $outer_trade_no, 'status' => '0'))->find();
                if ($info) {
                    $varule = (M('order_log')->where(array('orderid' => $info['orderid']))->find());
                    if (!$varule) {
                        $userinfo = M('user_balance')->field('sumcount,availablecount')->where(array('user_id' => $info['uid'], 'currency_id' => $info['currency_id']))->find();
//                        $fp = @fopen("n1.txt", "a+");
//                        fwrite($fp, var_export($userinfo, true));
//                        fclose($fp);

                        $fee = number_format($info['ordermoney'] * getPayinRate($info['product_id']), 4, '.', '');
                        $data = array('factmoney' => $trade_amount, 'free' => $fee, 'pay_orderid' => $inner_trade_no, 'end_time' => $endtime, 'status' => '1');
                        //订单状态修改
                        $Orderstatus = M('payin')->where(array('payin_id' => $info['payin_id']))->save($data);

                        if(in_array($info['uid'],C('TMPL_HKD'))){
//                            转换成港币计算
                            $income_hkd = cursell_hkd($info['ordermoney'],$info['uid']);
                            $outlay_hkd = cursell_hkd($fee,$info['uid']);
                            $sumcount = $userinfo['sumcount'] + $income_hkd - $outlay_hkd;
                            $availablecount = $userinfo['availablecount'] + $income_hkd - $outlay_hkd;
                        }else{
                            $sumcount = $userinfo['sumcount'] + $info['ordermoney'] - $fee;
                            $availablecount = $userinfo['availablecount'] + $info['ordermoney'] - $fee;
                        }
                        //支付成功记录
                        if ($Orderstatus) {

                            $UserInfo = M('user_balance')->where(array('user_id' => $info['uid'], 'currency_id' => $info['currency_id']))->save(array('sumcount' => $sumcount, 'availablecount' => $availablecount));
//                            $fp = @fopen("n2.txt", "a+");
//                            fwrite($fp, var_export($UserInfo, true));
//                            fclose($fp);
                            //發送客戶消息
                            $chatId_case = getChatId($info['uid'],0);
                            if ($chatId_case) {
                                if(in_array($info['uid'],C('TMPL_HKD'))){
                                    $message_case = "<code>訂單號: " . $info['orderid'] . "</code>%0A<code>金額: CNY " . number_format($info['ordermoney'], 2, '.', ',') . "</code>%0A<code>更新日期: " . date('Y-m-d', $data['end_time']) . "</code>%0A<code>更新時間: " . date('H:i:s', $data['end_time']) . "</code><code>支付类型: 入金</code>";
                                }else{
                                    $message_case = "<code>訂單號: " . $info['orderid'] . "</code>%0A<code>金額: CNY " . number_format($info['ordermoney'], 2, '.', ',') . "</code>%0A<code>更新日期: " . date('Y-m-d', $data['end_time']) . "</code>%0A<code>更新時間: " . date('H:i:s', $data['end_time']) . "</code><code>支付类型: 入金</code>";
                                }
                                //發送到客戶

                                telegramSendMessage($chatId_case, $message_case,1);
                            }

                            if($info['uid']<>8825 && $info['uid']<>8832){
                                $chatId_master = "-238443852";
                                if(in_array($info['uid'],C('TMPL_HKD'))){
                                    $message_master = "<code>供應商: " . getPaymentName($info['payment_id']) ."-".getSubUserBalanceAttributeName($info['paybank']). "</code>%0A<code>MID: " . getMidName($info['payment_mid']) . "</code>%0A<code>入金客戶: " . getUserinfoName($info['uid']) . "</code>%0A<code>訂單號: " . $info['orderid'] . "</code>%0A<code>金額: CNY " . number_format($info['ordermoney'], 2, '.', ',') .  "</code>%0A<code>可用餘額: hkd " . number_format($availablecount, 2, '.', ',')."</code>%0A<code>更新日期: " . date('Y-m-d', $data['end_time']) . "</code>%0A<code>更新時間: " . date('H:i:s', $data['end_time']) . "</code>";
                                }else{
                                    $message_master = "<code>供應商: " . getPaymentName($info['payment_id']) ."-".getSubUserBalanceAttributeName($info['paybank']). "</code>%0A<code>MID: " . getMidName($info['payment_mid']) . "</code>%0A<code>入金客戶: " . getUserinfoName($info['uid']) . "</code>%0A<code>訂單號: " . $info['orderid'] . "</code>%0A<code>金額: CNY " . number_format($info['ordermoney'], 2, '.', ',') .  "</code>%0A<code>可用餘額: CNY " . number_format($availablecount, 2, '.', ',')."</code>%0A<code>更新日期: " . date('Y-m-d', $data['end_time']) . "</code>%0A<code>更新時間: " . date('H:i:s', $data['end_time']) . "</code>";
                                }

                                telegramSendMessage($chatId_master, $message_master,1);

                            }

                            if ($UserInfo) {
                                if(in_array($info['uid'],C('TMPL_HKD'))){
                                    PayinSubUserBalanceUpdate($info['uid'],$info['payment_mid'],$info['currency_id'],$info['paybank'],$income_hkd - $outlay_hkd);
                                }else{
                                    PayinSubUserBalanceUpdate($info['uid'],$info['payment_mid'],$info['currency_id'],$info['paybank'],$info['ordermoney'] - $fee);
                                }


                                if(in_array($info['uid'],C('TMPL_HKD'))){
//                              把金额转换成港币记录
                                    $income_hkd = cursell_hkd($info['ordermoney'],$info['uid']);
                                    $outlay_hkd = cursell_hkd($fee,$info['uid']);
                                    $datalog1 = array('uid' => $info['uid'], 't_type' => '1', 'orderid' => $info['orderid'], 'income' => $info['ordermoney'],'income_hkd'=> $income_hkd, 'balance' => $sumcount + $fee, 'begin_time' => $info['begin_time'], 'end_time' => $data['end_time'], 'remark' => $info['remark']);
                                    $datalog2 = array('uid' => $info['uid'], 'orderid' => $info['orderid'], 't_type' => '4', 'outlay' => $fee,'outlay_hkd'=>$outlay_hkd, 'balance' => $sumcount, 'begin_time' => $info['begin_time'], 'end_time' => time(), 'remark' => '');
                                }else{
                                    //寫入子賬戶餘額
                                    $datalog1 = array('uid' => $info['uid'], 't_type' => '1', 'orderid' => $info['orderid'], 'income' => $info['ordermoney'], 'balance' => $sumcount + $fee, 'begin_time' => $info['begin_time'], 'end_time' => $data['end_time'], 'remark' => $info['remark']);
                                    //手续费扣除记录
                                    $datalog2 = array('uid' => $info['uid'], 'orderid' => $info['orderid'], 't_type' => '4', 'outlay' => $fee, 'balance' => $sumcount, 'begin_time' => $info['begin_time'], 'end_time' => time(), 'remark' => '');
                                }
                                M('order_log')->add($datalog1);
                                M('order_log')->add($datalog2);

                                //globalspeedlink 入金累计

                            } else {
                                $fp = @fopen("payfo_log.txt", "a+");
                                fwrite($fp, "\r\n" . date("Y-m-d H:i:s") . "   " . $outer_trade_no. "  入款日志写入失败\r\n");
                                fclose($fp);
                            }
                        } else {
                            $fp = @fopen("payfo_log.txt", "a+");
                            fwrite($fp, "\r\n" . date("Y-m-d H:i:s") . "   " . $outer_trade_no . " 入款日志写入失败\r\n");
                            fclose($fp);
                        }
                    } else {
                        $fail_reason = "订单重复";
                        $fp = @fopen("payfo_error_log.txt", "a+");
                        fwrite($fp, "\r\n" . date("Y-m-d H:i:s") . "   " . $fail_reason . "   " . $varule . "入款日志写入失败\r\n");
                        fclose($fp);
                    }

                    //定义变量  加密 然后curl传递给客户-获取返回值
                    $Signkeyi = M('userinfo')->field('md5key')->where(array('user_id' => $info['uid']))->find();

                    $Md5key = $Signkeyi['md5key'];
                    $mMark = "&";
                    $company_code = $info['uid'];
                    $order_number = $info['transid'];
                    $order_amount = $info['ordermoney'];
                    $remark = $info['remark'];
                    $order_status = '2';
                    $system_order_number = $info['orderid'];
                    $sett_date = date('d-m-Y H:i:s', $endtime);
                    $order_fee = $info['free'];
                    $timestamp = time();
                    $sign_type = 'SHA256';
                    $version = '1.0';
                    $string = $company_code . $mMark . $order_number . $mMark . $order_amount . $mMark . $order_status . $mMark . $system_order_number . $mMark . $sett_date . $mMark . $order_fee . $mMark . $timestamp . $mMark . $sign_type . $mMark . $version . $mMark . $Md5key;
                    $sign = hash('sha256', $string);
                    $post_data = array(
                        'company_code' => $company_code,
                        'order_number' => $order_number,
                        'order_amount' => $order_amount,
                        'remark' => $remark,
                        'order_status' => $order_status,
                        'system_order_number' => $system_order_number,
                        'sett_date' => $sett_date,
                        'order_fee' => $order_fee,
                        'timestamp' => $timestamp,
                        'sign_type' => $sign_type,
                        'version' => $version,
                        'orderCurrency'=>$orderCurrency,
                        'sign' => $sign,
                    );
                    $url = $info['notifyurl'];
                    $o = "";
                    foreach ($post_data as $k => $v) {
                        $o .= "$k=" . urlencode($v) . "&";
                    }
                    $post_data = substr($o, 0, -1);
                    $fp = @fopen("xunhan.txt", "a+");
                    fwrite($fp, $post_data);
                    fclose($fp);
                    //通知五次到客户
                    for ($i = 0; $i < 5; $i++) {

                        $res = request_post($url, $post_data);

                        $fp = @fopen("res_log1.txt", "a+");
                        fwrite($fp, $company_code.'###--'.$system_order_number."---".$res . "###--" . $order_number . "--##" . date('Y-m-d H:i:s') . "\n");
                        fclose($fp);
                        if (strpos($res, "success") !== false) {
                            //更新系统通知，并中断循环
                            M('payin')->where(array('payin_id' => $info['payin_id']))->save(array('notice_status' => 1));
                            break;
                        } else {
                            M('payin')->where(array('payin_id' => $info['payin_id']))->save(array('notice_status' => 0));
                            break;
                        }
                    }
                    orderAgentCash($info['uid'], $info['orderid'], $endtime, $info['ordermoney'], $info['paybank'],$info['product_id']);

                }
            }
            if ($method == 'return') {
                $notify_time = trim($_REQUEST['ORDER_TIME']);
                $sign = trim($_REQUEST['SIGN']);
                $outer_trade_no = trim($_REQUEST['requestId']);  //商户订单号
                $inner_trade_no = trim($_REQUEST['merchantId']);  //系统订单号
                $trade_amount = trim($_REQUEST['ORDER_AMT']);
                $trade_status = trim($_REQUEST['status']);
                $redirectUrl = trim($_REQUEST['redirectUrl']);

                $endtime = time();
                $info = M('payin')->where(array('orderid' => $outer_trade_no))->find();
                if ($info) {
                    //定义变量  加密 然后curl传递给客户-获取返回值
                    $Signkeyi = M('userinfo')->field('md5key')->where(array('user_id' => $info['uid']))->find();
                    $Md5key = $Signkeyi['md5key'];
                    $mMark = "&";
                    $company_code = $info['uid'];
                    $order_number = $info['transid'];
                    $order_amount = $info['ordermoney'];
                    $remark = $info['remark'];
                    $source = $info['source'];
                    $order_status = '2';
                    $system_order_number = $info['orderid'];
                    $sett_date = date('d-m-Y H:i:s', $endtime);
                    $order_fee = $info['free'];
                    $timestamp = time();
                    $sign_type = 'SHA256';
                    $version = '1.0';
                    $string = $company_code . $mMark . $order_number . $mMark . $order_amount . $mMark . $order_status . $mMark . $system_order_number . $mMark . $sett_date . $mMark . $order_fee . $mMark . $timestamp . $mMark . $sign_type . $mMark . $version . $mMark . $Md5key;
                    $sign = hash('sha256', $string);
//                    echo("<script>alert('支付成功');</script>");
                    echo('<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><title>提交跳转</title></head><body>');
                    echo('<form method="get" name="f1" action="' . $info['returnurl'] . '">');
                    echo('<input type="hidden" name="company_code" value="' . $company_code . '" />');
                    echo('<input type="hidden" name="order_number" value="' . $order_number . '" />');
                    echo('<input type="hidden" name="order_amount" value="' . $order_amount . '" />');
                    echo('<input type="hidden" name="remark" value="' . $remark . '" />');
                    echo('<input type="hidden" name="order_status" value="' . $order_status . '" />');
                    echo('<input type="hidden" name="system_order_number" value="' . $system_order_number . '" />');
                    echo('<input type="hidden" name="sett_date" value="' . $sett_date . '" />');
                    echo('<input type="hidden" name="order_fee" value="' . $order_fee . '" />');
                    echo('<input type="hidden" name="source" value="' . $source . '" />');
                    echo('<input type="hidden" name="timestamp" value="' . $timestamp . '" />');
                    echo('<input type="hidden" name="sign_type" value="' . $sign_type . '" />');
                    echo('<input type="hidden" name="version" value="' . $version . '" />');
                    echo('<input type="hidden" name="sign" value="' . $sign . '" />');
                    echo('</form>');
                    echo('<script>function sub(){document.f1.submit();}setTimeout(sub,100);</script>');
                    echo('</body></html>');
                    //处理想处理的事情，验证通过，根据提交的参数判断支付结果
                } else {
                    echo("error'"); //MD5校验失败
                    //处理想处理的事情
                }
            }
        }
        if($apitype == 3){
            if ($method == 'notify') {
                $dt =file_get_contents("php://input");
                $arr = explode('&', $dt);

                $data = base64_decode(urldecode(substr($arr[0],5)));

                $data = json_decode($data,true);
//                dump($_REQUEST);die;
//                $fp = @fopen("notify.txt", "a+");
//                fwrite($fp, var_export($_POST, true));
//                fclose($fp);
                $notify_time = trim($data['payment']['completeDateTime']);
                $sign = trim($data['hmac']);
                $outer_trade_no = trim($data['merchantOrderId']);  //商户订单号
                $inner_trade_no = trim($data['merchantId']);  //系统订单号
                $trade_amount = trim($data['orderAmount']);
                $orderCurrency = 'CNY';//订单币种
                $orderAmount = trim($data['merchantOrderAmt']);//订单金额
                $trade_status = trim($data['transStatus']);
                $respCode = trim($data['respCode']);
                $respDesc = trim($data['respDesc']);

                if ($trade_status != 1) {
                    $fp = @fopen("20_yufu_payin.txt", "a+");
                    fwrite($fp, date('Y-m-d H:i:s')."--".$respCode."--".$respDesc);
                    fclose($fp);
                    die();
                }
                echo "success";
                $info = M('payin')->field('payin_id,uid,transid,currency_id,paybank,product_id,payment_id,payment_mid,orderid,ordermoney,free,notifyurl,returnurl,begin_time,end_time,remark,status,source')->where(array('orderid' => $outer_trade_no, 'status' => '0'))->find();
                if ($info) {
                    $varule = (M('order_log')->where(array('orderid' => $info['orderid']))->find());
                    if (!$varule) {
                        $userinfo = M('user_balance')->field('sumcount,availablecount')->where(array('user_id' => $info['uid'], 'currency_id' => $info['currency_id']))->find();
//                        $fp = @fopen("n1.txt", "a+");
//                        fwrite($fp, var_export($userinfo, true));
//                        fclose($fp);

                        $fee = number_format($info['ordermoney'] * getPayinRate($info['product_id']), 4, '.', '');
                        $data = array('factmoney' => $trade_amount, 'free' => $fee, 'pay_orderid' => $inner_trade_no, 'end_time' => $endtime, 'status' => '1');
                        //订单状态修改
                        $Orderstatus = M('payin')->where(array('payin_id' => $info['payin_id']))->save($data);
                        $income_hkd = cursell_hkd($info['ordermoney'],$info['uid']);
                        $outlay_hkd = cursell_hkd($fee,$info['uid']);
                        if(in_array($info['uid'],C('TMPL_HKD'))){
//                            转换成港币计算
                            $sumcount = $userinfo['sumcount'] + $income_hkd - $outlay_hkd;
                            $availablecount = $userinfo['availablecount'] + $income_hkd - $outlay_hkd;
                        }else{
                            $sumcount = $userinfo['sumcount'] + $info['ordermoney'] - $fee;
                            $availablecount = $userinfo['availablecount'] + $info['ordermoney'] - $fee;
                        }
                        //支付成功记录
                        if ($Orderstatus) {

                            $UserInfo = M('user_balance')->where(array('user_id' => $info['uid'], 'currency_id' => $info['currency_id']))->save(array('sumcount' => $sumcount, 'availablecount' => $availablecount));
//                            $fp = @fopen("n2.txt", "a+");
//                            fwrite($fp, var_export($UserInfo, true));
//                            fclose($fp);
                            //發送客戶消息
                            $chatId_case = getChatId($info['uid'],0);
                            if ($chatId_case) {
                                if(in_array($info['uid'],C('TMPL_HKD'))){
                                    $message_case = "<code>訂單號: " . $info['orderid'] . "</code>%0A<code>金額: CNY " . number_format($info['ordermoney'], 2, '.', ',') . "</code>%0A<code>更新日期: " . date('Y-m-d', $data['end_time']) . "</code>%0A<code>更新時間: " . date('H:i:s', $data['end_time']) . "</code><code>支付类型: 入金</code>";
                                }else{
                                    $message_case = "<code>訂單號: " . $info['orderid'] . "</code>%0A<code>金額: CNY " . number_format($info['ordermoney'], 2, '.', ',') . "</code>%0A<code>更新日期: " . date('Y-m-d', $data['end_time']) . "</code>%0A<code>更新時間: " . date('H:i:s', $data['end_time']) . "</code><code>支付类型: 入金</code>";
                                }
                                //發送到客戶

                                telegramSendMessage($chatId_case, $message_case,1);
                            }

                            if($info['uid']<>8825 && $info['uid']<>8832){
                                $chatId_master = "-238443852";
                                if(in_array($info['uid'],C('TMPL_HKD'))){
                                    $message_master = "<code>供應商: " . getPaymentName($info['payment_id']) ."-".getSubUserBalanceAttributeName($info['paybank']). "</code>%0A<code>MID: " . getMidName($info['payment_mid']) . "</code>%0A<code>入金客戶: " . getUserinfoName($info['uid']) . "</code>%0A<code>訂單號: " . $info['orderid'] . "</code>%0A<code>金額: CNY " . number_format($info['ordermoney'], 2, '.', ',') .  "</code>%0A<code>可用餘額: hkd " . number_format($availablecount, 2, '.', ',')."</code>%0A<code>更新日期: " . date('Y-m-d', $data['end_time']) . "</code>%0A<code>更新時間: " . date('H:i:s', $data['end_time']) . "</code>";
                                }else{
                                    $message_master = "<code>供應商: " . getPaymentName($info['payment_id']) ."-".getSubUserBalanceAttributeName($info['paybank']). "</code>%0A<code>MID: " . getMidName($info['payment_mid']) . "</code>%0A<code>入金客戶: " . getUserinfoName($info['uid']) . "</code>%0A<code>訂單號: " . $info['orderid'] . "</code>%0A<code>金額: CNY " . number_format($info['ordermoney'], 2, '.', ',') .  "</code>%0A<code>可用餘額: CNY " . number_format($availablecount, 2, '.', ',')."</code>%0A<code>更新日期: " . date('Y-m-d', $data['end_time']) . "</code>%0A<code>更新時間: " . date('H:i:s', $data['end_time']) . "</code>";
                                }

                                telegramSendMessage($chatId_master, $message_master,1);

                            }

                            if ($UserInfo) {
                                if(in_array($info['uid'],C('TMPL_HKD'))){
                                    PayinSubUserBalanceUpdate($info['uid'],$info['payment_mid'],$info['currency_id'],$info['paybank'],$income_hkd - $outlay_hkd);
                                }else{
                                    PayinSubUserBalanceUpdate($info['uid'],$info['payment_mid'],$info['currency_id'],$info['paybank'],$info['ordermoney'] - $fee);
                                }


                                if(in_array($info['uid'],C('TMPL_HKD'))){
//                              把金额转换成港币记录
                                    $income_hkd = cursell_hkd($info['ordermoney'],$info['uid']);
                                    $outlay_hkd = cursell_hkd($fee,$info['uid']);
                                    $datalog1 = array('uid' => $info['uid'], 't_type' => '1', 'orderid' => $info['orderid'], 'income' => $info['ordermoney'],'income_hkd'=> $income_hkd, 'balance' => $sumcount + $fee, 'begin_time' => $info['begin_time'], 'end_time' => $data['end_time'], 'remark' => $info['remark']);
                                    $datalog2 = array('uid' => $info['uid'], 'orderid' => $info['orderid'], 't_type' => '4', 'outlay' => $fee,'outlay_hkd'=>$outlay_hkd, 'balance' => $sumcount, 'begin_time' => $info['begin_time'], 'end_time' => time(), 'remark' => '');
                                }else{
                                    //寫入子賬戶餘額
                                    $datalog1 = array('uid' => $info['uid'], 't_type' => '1', 'orderid' => $info['orderid'], 'income' => $info['ordermoney'], 'balance' => $sumcount + $fee, 'begin_time' => $info['begin_time'], 'end_time' => $data['end_time'], 'remark' => $info['remark']);
                                    //手续费扣除记录
                                    $datalog2 = array('uid' => $info['uid'], 'orderid' => $info['orderid'], 't_type' => '4', 'outlay' => $fee, 'balance' => $sumcount, 'begin_time' => $info['begin_time'], 'end_time' => time(), 'remark' => '');
                                }
                                M('order_log')->add($datalog1);
                                M('order_log')->add($datalog2);

                                //globalspeedlink 入金累计

                            } else {
                                $fp = @fopen("payfo_log.txt", "a+");
                                fwrite($fp, "\r\n" . date("Y-m-d H:i:s") . "   " . $outer_trade_no. "  入款日志写入失败\r\n");
                                fclose($fp);
                            }
                        } else {
                            $fp = @fopen("payfo_log.txt", "a+");
                            fwrite($fp, "\r\n" . date("Y-m-d H:i:s") . "   " . $outer_trade_no . " 入款日志写入失败\r\n");
                            fclose($fp);
                        }
                    } else {
                        $fail_reason = "订单重复";
                        $fp = @fopen("payfo_error_log.txt", "a+");
                        fwrite($fp, "\r\n" . date("Y-m-d H:i:s") . "   " . $fail_reason . "   " . $varule . "入款日志写入失败\r\n");
                        fclose($fp);
                    }

                    //定义变量  加密 然后curl传递给客户-获取返回值
                    $Signkeyi = M('userinfo')->field('md5key')->where(array('user_id' => $info['uid']))->find();

                    $Md5key = $Signkeyi['md5key'];
                    $mMark = "&";
                    $company_code = $info['uid'];
                    $order_number = $info['transid'];
                    $order_amount = $info['ordermoney'];
                    $remark = $info['remark'];
                    $order_status = '2';
                    $system_order_number = $info['orderid'];
                    $sett_date = date('d-m-Y H:i:s', $endtime);
                    $order_fee = $info['free'];
                    $timestamp = time();
                    $sign_type = 'SHA256';
                    $version = '1.0';
                    $string = $company_code . $mMark . $order_number . $mMark . $order_amount . $mMark . $order_status . $mMark . $system_order_number . $mMark . $sett_date . $mMark . $order_fee . $mMark . $timestamp . $mMark . $sign_type . $mMark . $version . $mMark . $Md5key;
                    $sign = hash('sha256', $string);
                    $post_data = array(
                        'company_code' => $company_code,
                        'order_number' => $order_number,
                        'order_amount' => $order_amount,
                        'remark' => $remark,
                        'order_status' => $order_status,
                        'system_order_number' => $system_order_number,
                        'sett_date' => $sett_date,
                        'order_fee' => $order_fee,
                        'timestamp' => $timestamp,
                        'sign_type' => $sign_type,
                        'version' => $version,
                        'orderCurrency'=>$orderCurrency,
                        'sign' => $sign,
                    );
                    $url = $info['notifyurl'];
                    $o = "";
                    foreach ($post_data as $k => $v) {
                        $o .= "$k=" . urlencode($v) . "&";
                    }
                    $post_data = substr($o, 0, -1);
                    $fp = @fopen("xunhan.txt", "a+");
                    fwrite($fp, $post_data);
                    fclose($fp);
                    //通知五次到客户
                    for ($i = 0; $i < 5; $i++) {

                        $res = request_post($url, $post_data);

                        $fp = @fopen("res_log1.txt", "a+");
                        fwrite($fp, $company_code.'###--'.$system_order_number."---".$res . "###--" . $order_number . "--##" . date('Y-m-d H:i:s') . "\n");
                        fclose($fp);
                        if (strpos($res, "success") !== false) {
                            //更新系统通知，并中断循环
                            M('payin')->where(array('payin_id' => $info['payin_id']))->save(array('notice_status' => 1));
                            break;
                        } else {
                            M('payin')->where(array('payin_id' => $info['payin_id']))->save(array('notice_status' => 0));
                            break;
                        }
                    }
                    orderAgentCash($info['uid'], $info['orderid'], $endtime, $info['ordermoney'], $info['paybank'],$info['product_id']);

                }
            }
            if ($method == 'return') {
                $dt = file_get_contents('php://input');

                $arr = explode('&', $dt);

                $data = base64_decode(urldecode(substr($arr[0],5)));

                $data = json_decode($data,true);
                $notify_time = trim($_REQUEST['ORDER_TIME']);
                $sign = trim($_REQUEST['SIGN']);
                $outer_trade_no = trim($data['merchantOrderId']);  //商户订单号
                $inner_trade_no = trim($_REQUEST['merchantId']);  //系统订单号
                $trade_amount = trim($_REQUEST['ORDER_AMT']);
                $trade_status = trim($_REQUEST['status']);
                $redirectUrl = trim($_REQUEST['redirectUrl']);

                $endtime = time();
                $info = M('payin')->where(array('orderid' => $outer_trade_no))->find();
                if ($info) {
                    //定义变量  加密 然后curl传递给客户-获取返回值
                    $Signkeyi = M('userinfo')->field('md5key')->where(array('user_id' => $info['uid']))->find();
                    $Md5key = $Signkeyi['md5key'];
                    $mMark = "&";
                    $company_code = $info['uid'];
                    $order_number = $info['transid'];
                    $order_amount = $info['ordermoney'];
                    $remark = $info['remark'];
                    $source = $info['source'];
                    $order_status = '2';
                    $system_order_number = $info['orderid'];
                    $sett_date = date('d-m-Y H:i:s', $endtime);
                    $order_fee = $info['free'];
                    $timestamp = time();
                    $sign_type = 'SHA256';
                    $version = '1.0';
                    $string = $company_code . $mMark . $order_number . $mMark . $order_amount . $mMark . $order_status . $mMark . $system_order_number . $mMark . $sett_date . $mMark . $order_fee . $mMark . $timestamp . $mMark . $sign_type . $mMark . $version . $mMark . $Md5key;
                    $sign = hash('sha256', $string);
//                    echo("<script>alert('支付成功');</script>");
                    echo('<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><title>提交跳转</title></head><body>');
                    echo('<form method="get" name="f1" action="' . $info['returnurl'] . '">');
                    echo('<input type="hidden" name="company_code" value="' . $company_code . '" />');
                    echo('<input type="hidden" name="order_number" value="' . $order_number . '" />');
                    echo('<input type="hidden" name="order_amount" value="' . $order_amount . '" />');
                    echo('<input type="hidden" name="remark" value="' . $remark . '" />');
                    echo('<input type="hidden" name="order_status" value="' . $order_status . '" />');
                    echo('<input type="hidden" name="system_order_number" value="' . $system_order_number . '" />');
                    echo('<input type="hidden" name="sett_date" value="' . $sett_date . '" />');
                    echo('<input type="hidden" name="order_fee" value="' . $order_fee . '" />');
                    echo('<input type="hidden" name="source" value="' . $source . '" />');
                    echo('<input type="hidden" name="timestamp" value="' . $timestamp . '" />');
                    echo('<input type="hidden" name="sign_type" value="' . $sign_type . '" />');
                    echo('<input type="hidden" name="version" value="' . $version . '" />');
                    echo('<input type="hidden" name="sign" value="' . $sign . '" />');
                    echo('</form>');
                    echo('<script>function sub(){document.f1.submit();}setTimeout(sub,100);</script>');
                    echo('</body></html>');
                    //处理想处理的事情，验证通过，根据提交的参数判断支付结果
                } else {
                    echo("error'"); //MD5校验失败
                    //处理想处理的事情
                }
            }
        }

    }

    //易宝通知解码
    private function keyopen($data){
        require_once $_SERVER['DOCUMENT_ROOT'] . '/yeepay/libs/YopClient.php';
        require_once $_SERVER['DOCUMENT_ROOT'] . '/yeepay/libs/YopClient3.php';
        require_once $_SERVER['DOCUMENT_ROOT'] . '/yeepay/libs/Util/YopSignUtils.php';

        /*商户私钥*/
        $private_key ='MIIEowIBAAKCAQEAmh/6DovrldfpXvx7ErX2GhrU1Rp4Mv0dKLrI5Cdl1fsQD9ZtpfaZA6OAGWHdvYDifBZEdVd9Mt0iScIWHBGmeZg25dtWRow/Ee/iyUJx2E6YEl66vgRE50Fyf1/xZpLLPJjT+rmKjrm6RVzuR7QdxJB/GYbWWk/nce8+YB3b0jJi6B6eYVvm5Vh6BtrDv4jprRuJZW8JF8htSUgSuPsxpgRmboVCd8JzeAi1uP0xU+JgZWymQpSUItf6lD2XU6NHK6nHoFGFSM/Hf0ZRmpfg5033SZUuXWz/RucuK9N/erdEweJ3iVFliLobXjb6JdIbP9z3Bvks47veJJX3Scp5NwIDAQABAoIBAFKMP+TcohA+dRrPxacu2CIBLu74X1qH4L8403IHe+6QqnihE1cpbajaQDjYBuiBiEyHrKDgfAjrEXtJvYfJGE3V7clMobflU75qqh+7O7hr19026XPuW200y3tXSrbydnH9NMP77i8lYJPYAzNaT/tAnSJx6oqycza9ub3HID5CsWxX7Th3v1lbXVnufM8sOGqKfdNXv9Lop3AzONKyplJukrEXlwDozyEjkq3Gydu8nDwjYl5JqOh4lu8UO8AMOsYEB09W6hFIuFNvbpXoQOjvbJtVmXI8rMspgq4QFHNh2booIBfJO3Fz20MC2nwsFJ2pHl49DvIoYmD/xhCCOSECgYEA5SeXIhXfPEo2SRo+3lii/z9d+tMepsRNjhbAz8E6ZHlukxrSXF411fC1bb0RszsDR9VTduYiQMJVB+hKXC7L4SsYwkJskI882qyqJOywvzpd8QjB0vDq39/jwRE7UwUsboURgPch+F38lEgz6JBSe4z2ILoUBu4OZxSE+pMjYKcCgYEArC45a/+3vjWe/ORiJJBaSEmAQwli85LNvg7WdW4nygXb4inxZrSEdDSbiWFHJj0sffSQxp41oyCrj5/mhSkz8ZQUvAfTQJZ1Yg2XnbjYCS73YR05zo5esv1VBiuTKNLhBw72+UUqkUVSb5LT4LgWE94Qpie0KmC30yqRodSTJPECgYAI9U1BNd2uO7B3lyESDCEDHXUNEyfFmTL29QjAlmsz9lNOSOQkXEJ6hJhzG8sPWKU+L6a9pS19nps4XepaRDIQMWEcZwBbfl4ApnNYUjBuqVd2zsLU/joQWm5K4+OP0Un1YBpZElAvp2zyVwhAdTPkRJRynxOdWb0SZoj0SsA9TQKBgQCloCl4bBoSDH6NghuuVHWkR5/r3GGlMDhddORzPa1ktlIXsoUWaNto9RoRAtRwQjRETTfe911dOBYQKJ6UxVfEMM/pOBXMcW8lDTIldCPMYbNxZa2vtl/+CZb6QnxirsfsBEcq7Y/PAkIUNcc+yZXjMqANVPAIO9VYegBxDY0l4QKBgB+jwy/RNwmHXJ/8nfyTYVW5yp9fO82Mkn/JXMCldFqo5vG9k+OvW1WoQzXAzQJ9lL2eUmNayORSLHThiBENNBCibOZl6a0ql2FVMQCexBS7vW8X3bJ9yDhrQZ7c4O+ePQ4Jyc2Jcd2gRTDw7KdFXqDk0IfvPS0FFpmEW6Y1sE1L';

        /*YOP公钥*/
        $yop_public_key ='MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEA6p0XWjscY+gsyqKRhw9MeLsEmhFdBRhT2emOck/F1Omw38ZWhJxh9kDfs5HzFJMrVozgU+SJFDONxs8UB0wMILKRmqfLcfClG9MyCNuJkkfm0HFQv1hRGdOvZPXj3Bckuwa7FrEXBRYUhK7vJ40afumspthmse6bs6mZxNn/mALZ2X07uznOrrc2rk41Y2HftduxZw6T4EmtWuN2x4CZ8gwSyPAW5ZzZJLQ6tZDojBK4GZTAGhnn3bg5bBsBlw2+FLkCQBuDsJVsFPiGh/b6K/+zGTvWyUcu+LUj2MejYQELDO3i2vQXVDk7lVi2/TcUYefvIcssnzsfCfjaorxsuwIDAQAB';

        $res=\YopSignUtils::decrypt($data,$private_key,$yop_public_key);

        //解码后返回参数
        return $res;
    }
}