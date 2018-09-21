<?php
/**
 * Created by PhpStorm.
 * User: yiqnuan.ma <yinquan.ma@yeepay.com>
 * Date: 2017/9/25
 * Time: 上午9:28
 */

namespace YeepayCbp\httpRequest;


use YeepayCbp\exception\InvalidRequestException;
use YeepayCbp\exception\InvalidResponseException;

class HttpInstance
{
    //静态变量保存全局实例
    private static $_instance = null;
    //私有构造函数，防止外界实例化对象
    private function __construct() {
    }
    //私有克隆函数，防止外办克隆对象
    private function __clone() {
    }
    //静态方法，单例统一访问入口
    public static function getInstance() {
        if (is_null ( self::$_instance ) || isset ( self::$_instance )) {
            self::$_instance = new self ();
        }
        return self::$_instance;
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

    /**
     * 发起http请求
     * @param $url: 请求地址
     * @param $params:请求参数
     * @return mixed:
     */
    public function httpRequestPost($url, $params)
    {
//        dump(json_decode($params,true));die;
        $fp = @fopen("params.txt", "a+");
        fwrite($fp, $params);
        fclose($fp);
        //请求数据json格式
        $params = is_array($params)?json_encode($params) : $params;
        //curl请求句柄设置
        $responseText =  $this->setHttpCurl($url,$params,'post');
        //结果转换，array形式
        $data = json_decode($responseText, true);
        if( $data === false){
            throw new InvalidResponseException(array(
                'error_description'=>'Response Error'
            ));
        }
        return $data;
    }


    /**
     * http GET方式请求
     * @param $url
     * @param $params
     * @return mixed
     */
    public function httpRequestGet ($url,$params) {
        $params = is_array($params)?json_encode($params) : $params;

        //curl请求句柄设置
        $responseText =  $this->setHttpCurl($url,$params,'get');
        //结果转换，array形式
        $data = json_decode($responseText, true);
        if($data === false){
            throw new InvalidResponseException(array(
                'error_description'=>'Response Error'
            ));
        }
        return $data;
    }

    /**
     * http请求句柄设置
     * @param $url:请求地址
     * @param $params:请求参数
     * @param $action:请求方式
     * @return mixed
     */
    private function setHttpCurl ($url,$params,$action) {
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
        if (curl_errno($curl) || $responseText === false) {
            curl_close($curl);
            throw new InvalidRequestException(array(
                'error_description'=> 'Request Error',
                'error_code' => curl_getinfo($curl, CURLINFO_HTTP_CODE),
                'error_meg' => curl_error($curl),
            ));
        }
        //关闭执行句柄
        curl_close($curl);
        return $responseText;
    }

}