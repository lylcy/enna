<?php


namespace enna\exceptions;


class Exception extends \Exception
{
   public $code = 400;

   public $errorCode = 10000;

   public $message = "参数异常";

   public function __construct($params = [])
   {
       if(array_key_exists('errorCode',$params)){
           $this->errorCode = $params['errorCode'];
       }

       if(array_key_exists('message',$params)){
           $this->message = $params['message'];
       }

       if(array_key_exists('code',$params)){
           $this->code = $params['code'];
       }
   }
}