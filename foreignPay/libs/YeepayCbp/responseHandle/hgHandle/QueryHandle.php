<?php
/**
 * Created by PhpStorm.
 * User: yp-tc-7044
 * Date: 2017/10/1
 * Time: 下午3:12
 */

namespace YeepayCbp\responseHandle\hgHandle;


use YeepayCbp\responseHandle\ResponseTypeHandle;

class QueryHandle extends ResponseTypeHandle
{
    const SUCCESS = 'SUCCESS';
    const PROCESSING = 'PROCESSING';
    const FAILED = 'FAILED';
    const TEMPORARY_SCALAR = 'hgResultStatus';
    const TEMPORARY_SCALAR_PAYMENT = 'hgPaymentResultStatus';
    public function __construct()
    {
        $fields = [
            'merchantId',
            'requestId',
            'customsInfos' => [
                'customsChannel',
                'amount',
                'freight',
                'goodsAmount',
                'tax',
                'status',
            ],
//            'ciqInfo' => [
//                'ciqChannel',
//                'ciqCode',
//                'amount',
//                'status',
//            ],
        ];
        $this->setHmacFields($fields);
    }

    /**
     * 方法重写，完成返回验签之后进行的操作
     * @param array $data
     * @return array
     */
    public function handle($data = array())
    {
        $customsInfos = $data['customsInfos'];
        $ciqInfo = $data['ciqInfo'];
        //修正数据为数组
        $customsInfos = !is_array($customsInfos) ? json_decode($customsInfos, true) : $customsInfos;
        $ciqInfo = !is_array($ciqInfo) ? json_decode($ciqInfo, true) : $ciqInfo;
        //不同的结果校验
        if (!empty($customsInfos) && !empty($ciqInfo)) {
            $cusJson = $customsInfos[0];
            $cusJson = !is_array($cusJson) ? json_decode($cusJson, true) : $cusJson;
            //获取状态信息
            $cusStatus = $cusJson['status'];
            $ciqStatus = $ciqInfo['status'];
            if (self::SUCCESS === $cusStatus && self::SUCCESS === $ciqStatus) {
                $data[self::TEMPORARY_SCALAR] = self::SUCCESS;
            } else if (self::FAILED !== $cusStatus && self::FAILED !== $ciqStatus) {
                $data[self::TEMPORARY_SCALAR] = self::PROCESSING;
            } else {
                $data[self::TEMPORARY_SCALAR] = self::FAILED;
            }
        } else if (!empty($customsInfos)) {
            $cusJson = $customsInfos[0];
            $cusJson = !is_array($cusJson) ? json_decode($cusJson, true) : $cusJson;
            $cusStatus = $cusJson['status'];
            if (self::PROCESSING === $cusStatus) {
                $data[self::TEMPORARY_SCALAR] = self::PROCESSING;
            } else if (self::SUCCESS === $cusStatus) {
                $data[self::TEMPORARY_SCALAR] = self::SUCCESS;
            }
        } else if (!empty($ciqInfo)) {
            $ciqStatus = $ciqInfo['status'];
            if (self::PROCESSING === $ciqStatus) {
                $data[self::TEMPORARY_SCALAR] = self::PROCESSING;
            } else if (self::SUCCESS === $ciqStatus) {
                $data[self::TEMPORARY_SCALAR] = self::SUCCESS;
            }
        } else {
            $data[self::TEMPORARY_SCALAR_PAYMENT] = self::SUCCESS;
        }
        return $data;
    }

    /**、
     * 删除临时变量的动作
     * @param array $data
     * @return array
     */
    public function setDel($data = array())
    {
        if (isset($data[self::TEMPORARY_SCALAR])) {
            unset($data[self::TEMPORARY_SCALAR]);
        }
        if (isset($data[self::TEMPORARY_SCALAR_PAYMENT])) {
            unset($data[self::TEMPORARY_SCALAR_PAYMENT]);
        }
        return $data;
    }
}