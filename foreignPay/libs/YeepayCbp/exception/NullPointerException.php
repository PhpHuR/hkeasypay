<?php
/**
 * Created by PhpStorm.
 * User: yiqnuan.ma <yinquan.ma@yeepay.com>
 * Date: 2017/9/25
 * Time: 上午9:53
 */

namespace YeepayCbp\exception;


class NullPointerException extends \InvalidArgumentException implements ExceptionInterface
{
    public function __construct($message = array(), $code = 400, \Exception $previous = null)
    {
        $message['error'] = 'not find data';
        parent::__construct(serialize($message), $code, $previous);
    }
}