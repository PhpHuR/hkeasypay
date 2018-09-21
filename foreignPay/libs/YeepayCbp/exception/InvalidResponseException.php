<?php

namespace YeepayCbp\exception;



class InvalidResponseException extends \InvalidArgumentException implements ExceptionInterface
{
    public function __construct($message = array(), $code = 400, \Exception $previous = null)
    {
        $message['error'] = 'invalid_response';
        parent::__construct(serialize($message), $code, $previous);
    }
}
