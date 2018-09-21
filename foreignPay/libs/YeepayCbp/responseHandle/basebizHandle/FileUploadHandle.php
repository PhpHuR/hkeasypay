<?php
/**
 * Created by PhpStorm.
 * User: yp-tc-7044
 * Date: 2017/11/2
 * Time: 上午10:50
 */
namespace YeepayCbp\responseHandle\basebizHandle;
use YeepayCbp\responseHandle\ResponseTypeHandle;

class FileUploadHandle extends ResponseTypeHandle
{
    public function __construct()
    {
        //忽略验签
        $fields = [
            'ignore'=>true,
        ];
        $this->setHmacFields($fields);
    }

}