<?php
// +----------------------------------------------------------------------
// | Copyright (c) 2015-2016 http://www.ebpays.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: xiaofeng<1034023036@qq.com>
// +----------------------------------------------------------------------


namespace Org\Payment;


class chanpay_service
{

    /**
     * 功能： 签名
     * 官方说明： http://dev.chanpay.com/doku.php/sdwg:%E6%94%B6%E5%8D%95%E7%BD%91%E5%85%B3%E6%8E%A5%E
     * author:chiefyang
     * date:2016/5/19
     * 参数：
     * $args 签名字符串数组
     * return:
     */
    function rsaSign($args,$pfxpath)
    {
        $args = array_filter($args);//过滤掉空值
        ksort($args);
        $query = '';
        foreach ($args as $k => $v) {
            if ($k == 'sign_type') {
                continue;
            }
            if ($query) {
                $query .= '&' . $k . '=' . $v;
            } else {
                $query = $k . '=' . $v;
            }
        }
        //这地方不能用 http_build_query  否则会urlencode
        //$query=http_build_query($args);
        $path = $pfxpath;  //私钥地址
        $private_key = file_get_contents($path);
        $pkeyid = openssl_get_privatekey($private_key);
        openssl_sign($query, $sign, $pkeyid);
        openssl_free_key($pkeyid);
        $sign = base64_encode($sign);
        return $sign;
    }

    /**
     * 功能： 验证签名
     * 官方说明： http://dev.chanpay.com/doku.php/sdwg:%E6%94%B6%E4%BA%A4%E4%BA%6%98%8E
     **************************************************************
     * author:chiefyang
     * date:2016/5/19
     * 参数：
     * @param $args 需要签名的数组
     * @param $sign 签名结果
     * return 验证是否成功
     */
    function rsaVerify($args, $sign,$pubfpath)
    {
        $args = array_filter($args);//过滤掉空值
        ksort($args);
        $query = '';
        foreach ($args as $k => $v) {
            if ($k == 'sign_type' || $k == 'sign') {
                continue;
            }
            if ($query) {
                $query .= '&' . $k . '=' . $v;
            } else {
                $query = $k . '=' . $v;
            }
        }
        //这地方不能用 http_build_query  否则会urlencode
        $sign = base64_decode($sign);
        $path = $pubfpath;  //公钥地址
        $public_key = file_get_contents($path);
        $pkeyid = openssl_get_publickey($public_key);
        if ($pkeyid) {
            $verify = openssl_verify($query, $sign, $pkeyid);
            openssl_free_key($pkeyid);
        }
        if ($verify == 1) {
            return true;
        } else {
            return false;
        }
    }

}