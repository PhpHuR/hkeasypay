<?php
// +----------------------------------------------------------------------
// | Copyright (c) 2015-2016 http://www.ebpays.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: xiaofeng<1034023036@qq.com>
// +----------------------------------------------------------------------


namespace Pay\Controller;


use Think\Controller;

class PaymentpageController extends Controller
{

    function index()
    {
        if (IS_POST) {
            $source = $_SERVER['HTTP_REFERER'];
            $company_code = I('company_code');
            $timestamp = I('timestamp');
            $signstrue = I('sign');
            $userinfo = M('userinfo')->where(array('user_id' => $company_code))->field('user_id,member_name,md5key,product_id')->find();
            if ($userinfo) {
                $md5key = $userinfo['md5key'];
                $param = $company_code;
                $param .= '&' . $timestamp;
                $param .= '&' . $md5key;
                $sign = hash('SHA256', $param);
                if ($signstrue <> $sign) {
                    $this->display('error_2');
                    die();
                }
            } else {
                $this->display('error');
                die();
            }
            //读取客户当前通道可用的银行
            $product_id = json_decode($userinfo['product_id']);
            //获取微信属性
            $product_list_weixin = M('product_mid_route')->where(array('product_id' => array('in', $product_id), 'product_attribute' => 'weixin'))->find();
            if ($product_list_weixin) {
                $weixin = true;
                $this->assign('weixin', $weixin);
            }
            //获取支付宝属性
            $product_list_alipay = M('product_mid_route')->where(array('product_id' => array('in', $product_id), 'product_attribute' => 'alipay'))->find();
            if ($product_list_alipay) {
                $alipay = true;
                $this->assign('alipay', $alipay);
            }
            $product_list = M('product_mid_route')->where(array('product_id' => array('in', $product_id), 'product_attribute' => '0'))->find();
            if($product_list['p_id'] == 3){
//                欲福通道就开启快捷和网关选择
                $this->assign('bank_type', 'kuaijie');
            }
            if ($product_list) {
                $this->assign('product_list', $product_list);
            }
            $this->assign('userinfo', $userinfo);
            $this->assign('source', $source);
            $this->display();
        } else {
            $this->display('error');
        }

    }

    function post()
    {
        if (IS_POST) {
            $source = I('source');
            $company_code = $_POST['company_code']; //商户号
            $order_number = $_POST['order_number']; //流水号
            $order_amount = $_POST['order_amount']; //订单金额
            $pay_id = $_POST['pay_id']; //银行参数
            $return_url = $_POST['return_url']; //服务器底层通知地址
            $notify_url = $_POST['notify_url']; //通知商户页面端地址
            $timestamp = $_POST['timestamp']; //交易时间
            $base64_memo = $_POST['base64_memo']; //订单附加消息
            $customer_id = $_POST['customer_id']; //订单附加消息
            $customer_name = $_POST['customer_name']; //订单附加消息
            $cert_type = $_POST['cert_type']; //证件类型
            $bank_type = $_POST['bank_type']; //证件类型
            $cert_number = $_POST['cert_number']; //证件号码
            $email = $_POST['email']; //邮箱
            $tel = $_POST['tel']; //电话
            $bank_number = $_POST['bank_number']; //支付银行卡号
            $payin_method = $_POST['payin_method']; //支付方式
            $sign_type = 'SHA256';
            $version = '1.0';
            $card_type = '1';
            $Md5key = $_POST['md5key']; //md5密钥（KEY）
            $MARK = "&";
//MD5签名格式
            $string = $company_code . $MARK . $order_number . $MARK . $order_amount . $MARK . $pay_id . $MARK . $return_url . $MARK . $notify_url . $MARK . $timestamp . $MARK . $base64_memo . $MARK . $sign_type . $MARK . $version . $MARK . $card_type . $MARK . $Md5key;
            $Signature = hash('sha256', $string);
            $url = 'http://' . $_SERVER['HTTP_HOST'] . '/Api/Payin';
            echo('<html><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><title>提交跳转</title></head><body>');
            echo('<form method="post" name="paybb_form" target="_parent" action="' . $url . '">'); //接口商城地址
            echo('<input type="hidden" name="company_code" value="' . $company_code . '" />');
            echo('<input type="hidden" name="source" value="' . $source . '" />');
            echo('<input type="hidden" name="order_number" value="' . $order_number . '" />');
            echo('<input type="hidden" name="order_amount" value="' . $order_amount . '" />');
            echo(' <input type="hidden" name="pay_id" value="' . $pay_id . '" />');
            echo('<input type="hidden" name="return_url" value="' . $return_url . '" />');
            echo('<input type="hidden" name="notify_url" value="' . $notify_url . '" />');
            echo('<input type="hidden" name="timestamp" value="' . $timestamp . '" />');
            echo('<input type="hidden" name="base64_memo" value="' . $base64_memo . '" />');
            echo('<input type="hidden" name="customer_id" value="' . $customer_id . '" />');
            echo('<input type="hidden" name="customer_name" value="' . $customer_name . '" />');
            echo('<input type="hidden" name="cert_type" value="' . $cert_type . '" />');
            echo('<input type="hidden" name="bank_type" value="' . $bank_type . '" />');
            echo('<input type="hidden" name="cert_number" value="' . $cert_number . '" />');
            echo('<input type="hidden" name="email" value="' . $email . '" />');
            echo('<input type="hidden" name="tel" value="' . $tel . '" />');
            echo('<input type="hidden" name="bank_number" value="' . $bank_number . '" />');
            echo('<input type="hidden" name="payin_method" value="' . $payin_method . '" />');
            echo('<input type="hidden" name="sign_type" value="' . $sign_type . '" />');
            echo('<input type="hidden" name="version" value="' . $version . '" />');
            echo('<input type="hidden" name="card_type" value="' . $card_type . '" />');
            echo('<input type="hidden" name="sign" value="' . $Signature . '" />');
            echo('</form>');
            echo('</form><script type="text/javascript">paybb_form.submit();</script>');
            echo('</body></html>');
            die();

        } else {
            $this->display('error');
        }

    }

    function return_url()
    {
        $company_code = trim($_REQUEST['company_code']);
        $userinfo = M('userinfo')->where(array('user_id' => $company_code))->field('md5key')->find();
        $order_number = trim($_REQUEST['order_number']);
        $order_amount = trim($_REQUEST['order_amount']);
        $order_status = trim($_REQUEST['order_status']);
        $system_order_number = trim($_REQUEST['system_order_number']);
        $sett_date = trim($_REQUEST['sett_date']);
        $order_fee = trim($_REQUEST['order_fee']);
        $timestamp = $_REQUEST['timestamp'];
        $remark = trim($_REQUEST['remark']);
        $source = trim($_REQUEST['source']);
        $sign_type = trim($_REQUEST['sign_type']);
        $version = trim($_REQUEST['version']);
        $sign = trim($_REQUEST['sign']);
        $mMark = "&";
        $key = $userinfo['md5key'];
        $string = $company_code . $mMark . $order_number . $mMark . $order_amount . $mMark . $order_status . $mMark . $system_order_number . $mMark . $sett_date . $mMark . $order_fee . $mMark . $timestamp . $mMark . $sign_type . $mMark . $version . $mMark . $key;
        $sign_1 = hash('sha256', $string);
        if ($sign_1 == $sign) {
            $message = "付款成功！";
            $this->assign('message', $message);
            $this->assign('order_number', $order_number);
            $this->assign('order_amount', $order_amount);
            $this->assign('sett_date', $sett_date);
            $this->assign('source', $source);
            $this->display();
            //处理想处理的事情，验证通过，根据提交的参数判断支付结果
        } else {
            $message = "付款失敗！";
            $this->assign('message', $message);
            $this->display();
            //处理想处理的事情

        }
    }

    function NotifyUrl()
    {
        $company_code = trim($_REQUEST['company_code']);
        $userinfo = M('userinfo')->where(array('user_id' => $company_code))->field('md5key')->find();
        $order_number = trim($_REQUEST['order_number']);
        $order_amount = trim($_REQUEST['order_amount']);
        $order_status = trim($_REQUEST['order_status']);
        $system_order_number = trim($_REQUEST['system_order_number']);
        $sett_date = trim($_REQUEST['sett_date']);
        $order_fee = trim($_REQUEST['order_fee']);
        $timestamp = $_REQUEST['timestamp'];
        $remark = trim($_REQUEST['remark']);
        $sign_type = trim($_REQUEST['sign_type']);
        $version = trim($_REQUEST['version']);
        $sign = trim($_REQUEST['sign']);
        $mMark = "&";
        $key = $userinfo['md5key'];
        $string = $company_code . $mMark . $order_number . $mMark . $order_amount . $mMark . $order_status . $mMark . $system_order_number . $mMark . $sett_date . $mMark . $order_fee . $mMark . $timestamp . $mMark . $sign_type . $mMark . $version . $mMark . $key;
        $sign_1 = hash('sha256', $string);
        if ($sign_1 == $sign) {
            //校验通过开始处理订单
            echo "\n";
            echo $company_code;
            echo "<br />";
            echo $order_number;
            echo "<br />";
            echo $order_amount;
            echo "<br />";
            echo $order_status;
            echo "<br />";
            echo $system_order_number;
            echo "<br />";
            echo $sett_date;
            echo "<br />";
            echo $order_fee;
            echo "<br />";
            echo $timestamp;
            echo "<br />";
            echo '##############################';
            echo "<br />";
            echo $sign;
            echo "<br />";
            echo("success"); //全部正确了输出OK
            die();
            //处理想处理的事情，验证通过，根据提交的参数判断支付结果
        } else {
            echo("error"); //MD5校验失败
            die();
            //处理想处理的事情

        }
    }

    function term()
    {
        $u_name = I('u_name');
        $this->assign('u_name', $u_name);
        $this->display();
    }
    function ajaxXian(){
        $banklist = I('get.banklist');
        if($banklist == 'gonghang'){
            $this->display('Paymentpage/'.$banklist);
        }else if($banklist == 'jianhang'){
            $this->display('Paymentpage/'.$banklist);
        }else if($banklist == 'nonghang'){
            $this->display('Paymentpage/'.$banklist);
        }else if($banklist == 'zhaohang'){
            $this->display('Paymentpage/'.$banklist);
        }else if($banklist == 'jiaohang'){
            $this->display('Paymentpage/'.$banklist);
        }else if($banklist == 'pufa'){
            $this->display('Paymentpage/'.$banklist);
        }else if($banklist == 'minsheng'){
            $this->display('Paymentpage/'.$banklist);
        }else if($banklist == 'xingye'){
            $this->display('Paymentpage/'.$banklist);
        }else if($banklist == 'guangda'){
            $this->display('Paymentpage/'.$banklist);
        }else if($banklist == 'zhongxin'){
            $this->display('Paymentpage/'.$banklist);
        }else if($banklist == 'chuxu'){
            $this->display('Paymentpage/'.$banklist);
        }else if($banklist == 'shenfa'){
            $this->display('Paymentpage/'.$banklist);
        }else if($banklist == 'guangfa'){
            $this->display('Paymentpage/'.$banklist);
        }else if($banklist == 'beijing'){
            $this->display('Paymentpage/'.$banklist);
        }else if($banklist == 'huaxia'){
            $this->display('Paymentpage/'.$banklist);
        }else if($banklist == 'shanghai'){
            $this->display('Paymentpage/'.$banklist);
        }else if($banklist == 'zhonghang'){
            $this->display('Paymentpage/'.$banklist);
        }

    }
}