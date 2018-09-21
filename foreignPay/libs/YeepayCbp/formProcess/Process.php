<?php
/**
 * Created by PhpStorm.
 * User: yiqnuan.ma <yinquan.ma@yeepay.com>
 * Date: 2017/9/14
 * Time: 下午2:19
 */

namespace YeepayCbp\formProcess;

use YeepayCbp\entity\AbstractModel;

abstract class Process
{

    const STATUS = 'status';
    const SUCCESS = 'SUCCESS';
    const FAILED = 'FAILED';
    const CANCEL = 'CANCEL';
    const INIT = 'INIT';
    const ERROR = 'ERROR';
    const REDIRECT = 'REDIRECT';


    public abstract function builder($params);

    /**
     * 创建json请求参数
     * @return string 返回请求参数的json字符串
     */
    protected function buildJson($param = null)
    {
        $vars = $param ?: get_object_vars($this);
        $data = $this->objectLoop($vars);
        foreach ($data as $key => $val) {
            if (is_array($val) && empty($val)) {
                unset($data[$key]);
            }
        }
        $data['hmac'] = $this->generateHmac();
        return json_encode($data);
    }

    /**
     * 参数对象循环的递归方法，得到准确的参数结果
     * @param $vars : 需要出处理的参数信息
     * @return array: 返回构造的结果数组
     */
    private function objectLoop($vars)
    {
        $data = array();
        foreach ($vars as $k => $var) {
            if (is_scalar($var) && $var !== null) {
                $data[$k] = $var;
            } else if (is_object($var) && $var instanceof AbstractModel) {
                $data[$k] = array_filter($this->objectLoop((array)$var));
            } else if (is_array($var)) {
                $data[$k] = array_filter($this->objectLoop((array)$var));
            }
        }
        return $data;
    }

    /**
     * 生成认证串
     * @return mixed
     */
    abstract function generateHmac();

    /**
     * 加密数据
     * @param $data
     * @param $key
     * @return string
     */
    public function encipher($data, $key)
    {
        $data = $this->characet($data);
        return hash_hmac("md5", $data, $key);
    }

    private function characet($data)
    {
        if (!empty($data)) {
            $fileType = mb_detect_encoding($data, array('UTF-8', 'GBK', 'LATIN1', 'BIG5', 'GB2312'));
            if ($fileType != 'UTF-8') {
                $data = mb_convert_encoding($data, 'utf-8', $fileType);
            }
        }
        return $data;
    }
} 