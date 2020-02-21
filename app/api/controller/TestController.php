<?php


namespace app\api\controller;


use enna\basic\BaseController;
use enna\exceptions\lib\ParamerException;

class TestController extends BaseController
{
    public function index(){
        throw new ParamerException();
    }

}