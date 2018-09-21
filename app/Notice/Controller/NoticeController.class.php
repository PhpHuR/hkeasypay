<?php
// +----------------------------------------------------------------------
// | Copyright (c) 2015-2017 http://www.ebpays.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: xiaofeng<1034023036@qq.com>
// +----------------------------------------------------------------------

/**
 * 补通知--五分钟执行一次
 */
namespace Notice\Controller;


use Think\Controller;

class NoticeController extends Controller
{
    function index()
    {
        echo "success";
    }

    function notice()
    {

        $sldate = date('Y-m-d') . ' - ' . date('Y-m-d'); //初始化时间段
        $arr = explode(" - ", $sldate);//转换成数组
        if (count($arr) == 2) {
            $arrdateone = strtotime($arr[0]);
            $arrdatetwo = strtotime($arr[1] . ' 23:59:59');
            $map['begin_time'] = array(array('egt', $arrdateone), array('elt', $arrdatetwo), 'AND');
        }
        $map['status'] = '1';
        $map['notice_status'] = '0';
        $map['_logic'] = 'AND';

        $info = M('payin')->field('payin_id,uid,transid,orderid,ordermoney,free,notifyurl,returnurl,begin_time,end_time,remark,status')->where($map)->select();

        if ($info) {
            foreach ($info as $key => $value) {

                $Signkeyi = M('userinfo')->field('md5key')->where(array('user_id' => $value['uid']))->find();
                $Md5key = $Signkeyi['md5key'];
                $mMark = "&";
                $company_code = $value['uid'];
                $order_number = $value['transid'];
                $order_amount = $value['ordermoney'];
                $remark = $value['remark'];
                $order_status = '2';
                $system_order_number = $value['orderid'];
                $sett_date = date('d-m-Y H:i:s', $value['end_time']);
                $order_fee = $value['free'];
                $timestamp = $value['end_time'];
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
                    'sign' => $sign
                );

                $url = $value['notifyurl'];
                $o = "";
                //格式化数组成为字符串
                foreach ($post_data as $k => $v) {
                    $o .= "$k=" . urlencode($v) . "&";
                }
                $post_data = substr($o, 0, -1);
                //通知五次到客户
                $res = go_curl($url, 'POST', $post_data);

                $LOG_FILE = "./log/" . $company_code . '###--' . date("Ymd") . ".txt";
                $fp2 = @fopen($LOG_FILE, "a+");
                fwrite($fp2, $res . '###--' . date("Ymd") . '###--' . $order_number . "\n");
                fclose($fp2);

                if (strpos($res, "success") !== false) {
                    //更新系统通知，并中断循环
                    $rs = M('payin')->where(array('payin_id' => $value['payin_id']))->save(array('notice_status' => 1));
                    if ($rs) {
                        return true;
                    } else {
                        return false;
                    }
                    break;
                }


            }

        } else {
            echo "Nothing data !";
        }


    }

    function notice_send_1()
    {

        $sldate = date('Y-m-d') . ' - ' . date('Y-m-d'); //初始化时间段
        $arr = explode(" - ", $sldate);//转换成数组
        if (count($arr) == 2) {
            $arrdateone = strtotime($arr[0]);
            $arrdatetwo = strtotime($arr[1] . ' 23:59:59');
            $map['begin_time'] = array(array('egt', $arrdateone), array('elt', $arrdatetwo), 'AND');
        }
        $map['status'] = '1';
        $map['notice_status'] = '0';
        $map['_logic'] = 'AND';

        $info = M('payin')->field('payin_id,uid,transid,orderid,ordermoney,free,notifyurl,returnurl,begin_time,end_time,remark,status')->where($map)->select();

        if ($info) {
            foreach ($info as $key => $value) {

                $Signkeyi = M('userinfo')->field('md5key')->where(array('user_id' => $value['uid']))->find();
                $Md5key = $Signkeyi['md5key'];
                $mMark = "&";
                $company_code = $value['uid'];
                $order_number = $value['transid'];
                $order_amount = $value['ordermoney'];
                $remark = $value['remark'];
                $order_status = '2';
                $system_order_number = $value['orderid'];
                $sett_date = date('d-m-Y H:i:s', $value['end_time']);
                $order_fee = $value['free'];
                $timestamp = $value['end_time'];
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
                    'sign' => $sign
                );

                $url = $value['notifyurl'];
                $o = "";
                //格式化数组成为字符串
                foreach ($post_data as $k => $v) {
                    $o .= "$k=" . urlencode($v) . "&";
                }
                $post_data = substr($o, 0, -1);
                //通知五次到客户
                $res = go_curl($url, 'POST', $post_data);

                $LOG_FILE = "./log/" . $company_code . '###--' . date("Ymd") . ".txt";
                $fp2 = @fopen($LOG_FILE, "a+");
                fwrite($fp2, $res . '###--' . date("Ymd") . '###--' . $order_number . "\n");
                fclose($fp2);

                //更新系统通知，并中断循环
                $rs = M('payin')->where(array('payin_id' => $value['payin_id']))->save(array('notice_status' => 1));


            }

        } else {
            echo "Nothing data !";
        }


    }


}