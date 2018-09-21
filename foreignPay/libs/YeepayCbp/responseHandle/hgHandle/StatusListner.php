<?php
/**
 * Created by PhpStorm.
 * User: yp-tc-7044
 * Date: 2017/11/15
 * Time: 下午5:07
 */

namespace YeepayCbp\responseHandle\hgHandle;

abstract class StatusListner
{
    //失败处理
     abstract function failed ($data);
    //成功处理
     abstract function success ($data);
    //处理中
     abstract function processing ($data);
    //发送中
     abstract function pending ($data);
}