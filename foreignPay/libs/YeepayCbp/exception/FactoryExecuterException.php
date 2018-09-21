<?php
/**
 * Created by PhpStorm.
 * User: yiqnuan.ma <yinquan.ma@yeepay.com>
 * Date: 2017/9/25
 * Time: 上午10:07
 */

namespace YeepayCbp\exception;


class FactoryExecuterException extends \InvalidArgumentException implements ExceptionInterface
{
    private $code = 400;
    public function __construct($message = array(), \Exception $previous = null)
    {
        if (is_null($message)) {
            $message['error'] = 'Factory reflex Exception';
        }
        parent::__construct(serialize($message), $this->code, $previous);
    }
}