<?php


namespace enna\exceptions\lib;


use enna\exceptions\Exception;

class ParamerException extends Exception
{
    public $errorCode = 10000;

    public $message = '参数异常';

}