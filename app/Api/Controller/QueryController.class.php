<?php
// +----------------------------------------------------------------------
// | Copyright (c) 2015-2016 http://www.ebpays.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: xiaofeng<1034023036@qq.com>
// +----------------------------------------------------------------------


namespace Api\Controller;


use Think\Controller;

class QueryController extends Controller
{
    function index()
    {
        $this->display();
    }
    function orderResult()
    {
        $company_code = I('company_code');
        $order_type = I('order_type');
        $order_number = I('order_number');
        $start_datetime = I('start_datetime');
        $end_datetime = I('end_datetime');
        $timestamp = I('timestamp');

        $key = I('sign');
//        $str = I('string');
        $MARK = "&";
        if (empty($company_code) || empty($order_type)){
            $error = array('errorCode'=>'1','msg'=>'order_type or company_code invalid');
            echo json_encode($error);
            die();
        }
        $user_info = M('userinfo')->where(array('user_id' => $company_code))->field('md5key')->find();
        if ($user_info){
            //验证签名咯
            $string = $company_code . $MARK . $order_type. $MARK. $order_number . $MARK . $start_datetime . $MARK . $end_datetime . $MARK . $timestamp . $MARK . 'SHA256' . $MARK . '1.0' . $MARK . $user_info['md5key'];
            $Signature = hash('sha256', $string);
            if ($key != $Signature) {
                $error = array('errorCode'=>'1','msg'=>'sign.invalid');
                echo json_encode($error);
                die();
            }
            if ($order_type==1) {
                if ($order_number) {
                    $order_status = M('payin')->where(array('uid' => $company_code, 'transid' => $order_number))->field('transid,orderid,ordermoney,free,status')->find();
                    if ($order_status) {
                        $this->ajaxReturn($order_status);
                    } else {
                        $error = array('errorCode'=>'0','msg'=>'null');
                        echo json_encode($error);
                        die();
                    }
                } elseif ($start_datetime && $end_datetime) {
                    $start_datetime = strtotime($start_datetime);
                    $end_datetime = strtotime($end_datetime);
                    $order_status_list = M('payin')->where(array('uid' => $company_code, 'begin_time' => array(array('egt', $start_datetime), array('elt', $end_datetime), 'AND')))->field('transid,orderid,ordermoney,free,status')->limit(100)->select();
                    $this->ajaxReturn($order_status_list);
                }else{
                    $error = array('errorCode'=>'0','msg'=>'null');
                    echo json_encode($error);
                    die();
                }
            } elseif ($order_type==2) {

                if ($order_number) {
                    $order_status = M('payout')->where(array('uid' => $company_code, 'payout_orderid' => $order_number))->field('payout_orderid,transfermoney,free,status')->find();
                    if ($order_status) {
                        $this->ajaxReturn($order_status);
                    } else {
                        $error = array('errorCode'=>'0','msg'=>'null');
                        echo json_encode($error);
                        die();
                    }
                } elseif ($start_datetime && $end_datetime) {
                    $start_datetime = strtotime($start_datetime);
                    $end_datetime = strtotime($end_datetime);
                    $order_status_list = M('payout')->where(array('uid' => $company_code, 'begin_time' => array(array('egt', $start_datetime), array('elt', $end_datetime), 'AND')))->select();
                    $this->ajaxReturn($order_status_list);
                }else{
                    $error = array('errorCode'=>'0','msg'=>'null');
                    echo json_encode($error);
                    die();
                }
            } else {
                $error = array('errorCode'=>'1','msg'=>'order_type invalid');
                echo json_encode($error);
                die();
            }
        }else{
            $error = array('errorCode'=>'1','msg'=>'company_code invalid');
            echo json_encode($error);
            die();
        }


    }

    function orderSelect()
    {
        $order = I('order');
        $resualt = M('payin')->where(array('orderid' => $order,'status'=>1))->field('status,returnurl,source,orderid')->find();
        if ($resualt) {
            $this->ajaxReturn($resualt);
        } else {
            return false;
        }
    }

}