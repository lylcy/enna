<?php


namespace enna\exceptions\lib;


use enna\exceptions\Exception;

class AuthTokenException extends Exception
{
    public $errorCode = 80000;

    public $message = '令牌异常';
}