<?php
/**
 * Created by PhpStorm.
 * User: yiqnuan.ma <yinquan.ma@yeepay.com>
 * Date: 2017/9/24
 * Time: 下午3:00
 */

namespace YeepayCbp\responseHandle;

use YeepayCbp\exception\HmacVerifyException;
use YeepayCbp\exception\InvalidResponseException;
use YeepayCbp\utils\ConfigurationUtils;

abstract class ResponseTypeHandle implements HandleInterface
{

    private $response_hmac_fields = array();

    /**
     * 结果验签属性数组
     * @param $fields :需要验证的结果
     */
    public function setHmacFields($fields)
    {
        if (!is_array($fields)) {
            $fields = json_decode($fields, true);
        }
        $this->response_hmac_fields = $fields;
    }

    /**
     * 请求结果统一处理
     * @param array $data
     * @return array
     */
    public function handle($data = array())
    {
        if (isset($data['status']) && $data['status'] == 'REDIRECT') {
            header("Location: {$data['redirectUrl']}");
            exit;
        } else if (isset($data['status']) && $data['status'] == 'SUCCESS') {
            return $data;
        } else {
            throw new InvalidResponseException(array(
                'error_description' => 'Response Error',
                'responseData' => $data
            ));
        }
    }

    /**
     * hmac 验证
     * @return mixed
     */
    public function checkHmac($data)
    {
        //忽略验签，直接返回,不忽略，则此参数不参与验签
        if (isset($this->response_hmac_fields['ignore'])) {
            if ($this->response_hmac_fields['ignore']) {
                return;
            } else {
                unset($this->response_hmac_fields['ignore']);
            }
        }
        if (!is_array($data)) {
            $data = json_decode($data, true);
        }
        $hmacSource = $this->getHmacSource($this->response_hmac_fields, $data);
        if (!empty($hmacSource)) {
            if (empty($data['hmac'])) {
                throw new HmacVerifyException(array(
                    'error_description' => 'hmac validation empty',
                    'responseData' => $data
                ));
            }
            $sourceHmac = hash_hmac('md5', $hmacSource, ConfigurationUtils::getInstance()->getHmacKey(isset($data['merchantId']) ? $data['merchantId'] : ''));
            $hmac = $data['hmac'];
            if ($sourceHmac !== $hmac) {
                throw new HmacVerifyException(array(
                    'error_description' => 'response hmac validation error'
                ));
            }
        }
    }

    /**
     * 获取加密数据源
     * @param $response_hmac_fields
     * @param $data
     * @return string
     */
    private function getHmacSource($response_hmac_fields, $data)
    {
        if (!is_array($data)) {
            $data = is_object($data) ? (array)$data : json_decode($data, true);
        }

        $hmacSource = '';
        foreach ($response_hmac_fields as $key => $hmacKey) {
            $d = null;
            if (is_scalar($hmacKey)) {
                if (!isset($data[$hmacKey]) || !is_scalar($data[$hmacKey])) {
                    continue;
                }
                $d = $data[$hmacKey];
            } else if (is_array($hmacKey)) {
                if (!isset($data[$key])) {
                    continue;
                }
                $level = $data[$key];
                if (!is_array($level)) {
                    try {
                        $level = is_object($level) ? (array)$level : json_decode($level, true);
                    } catch (\Exception $e) {
                        $level = $data[$key];
                    }
                }
                foreach ($level as $v) {
                    if (is_scalar($v)) {
                        $d = $this->getHmacSource($hmacKey, $level);
                        break;
                    } else if (is_array($v)) {
                        $d = $this->getHmacSource($hmacKey, $v);
                    } else {
                        $d = $this->getHmacSource($hmacKey, json_decode($v, true));
                    }
                }
            }
            $k = $hmacKey;
            if ($k === 'listprice') {
                $hmacSource .= $d ? number_format($d, 6, '.', '0') : '';
            } else {
                $hmacSource .= $d;
            }
        }
        return $hmacSource;
    }

}