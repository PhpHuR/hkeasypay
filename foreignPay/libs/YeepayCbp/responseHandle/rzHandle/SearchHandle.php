<?php
/**
 * Created by PhpStorm.
 * User: yp-tc-7044
 * Date: 2017/10/1
 * Time: 下午3:18
 */

namespace YeepayCbp\responseHandle\rzHandle;


use YeepayCbp\exception\InvalidResponseException;
use YeepayCbp\responseHandle\ResponseTypeHandle;

class SearchHandle extends ResponseTypeHandle
{
    public function __construct()
    {
        $fields = [
            'merchantId',
            'requestId',
            'serialNumber',
            'authType',
            'name',
            'idCardNum',
            'bankCardNumber',
            'phoneNumber',
            'status',
            'photo',
        ];
        $this->setHmacFields($fields);
    }

    public function handle($data = array())
    {
        if (isset($data['status']) && $data['status'] === 'NOPASS' || $data['status'] === 'PASS') {
            return $data;
        } else {
            throw new InvalidResponseException(array(
                'error_description' => 'Response Error',
                'responseData' => $data
            ));
        }
    }
}