<?php


namespace enna\utils;


use think\Response;

class Json
{
    private $code = 200;

    public function code(int $code): self
    {
        $this->code = $code;
        return $this;
    }

    public function makeTo(int $status, string $message, ?array $data = null,int $errorCode = 0): Response
    {
        $res = compact('status', 'message','errorCode');

        if (!is_null($data)){
            $res['data'] = $data;
        }

        return Response::create($res, 'json', $this->code);
    }

    public function success($msg = 'ok', ?array $data = null): Response
    {
        if (is_array($msg)) {
            $data = $msg;
            $msg = 'ok';
        }

        return $this->makeTo(200, $msg, $data);
    }

    public function successful(...$args): Response
    {
        return $this->success(...$args);
    }

    public function fail($msg = 'fail', ?array $data = null,$errorCode = 0): Response
    {
        if (is_array($msg)) {
            $data = $msg;
            $msg = 'ok';
        }
        if(!$errorCode){
            $errorCode = 10000;
            if($data){
                if(array_key_exists('errorCode',$data)){
                    $errorCode = $data['errorCode'];
                }
            }
        }
        return $this->makeTo(400, $msg, $data,$errorCode);
    }

    public function status($status, $msg, $result = [])
    {
        $status = strtoupper($status);
        if (is_array($msg)) {
            $result = $msg;
            $msg = 'ok';
        }
        return $this->success($msg, compact('status', 'result'));
    }

}