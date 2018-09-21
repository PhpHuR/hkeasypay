<?php
/**
 * Created by PhpStorm.
 * User: yp-tc-7044
 * Date: 2017/10/18
 * Time: 上午10:35
 */

namespace YeepayCbp\responseHandle\hg_v2Handle;


use YeepayCbp\responseHandle\ResponseTypeHandle;

class MemberQueryHandle extends ResponseTypeHandle
{
    public function __construct()
    {
        $fields = get_object_vars($this);
        $fieldsKey = array();
        foreach ($fields as $key => $val) {
            array_push($fieldsKey,$key);
        }
        $this->setHmacFields($fieldsKey);
    }
}