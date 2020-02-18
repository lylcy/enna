<?php


namespace app\admin\controller;


use think\Request;

class Index
{
    public function index(Request $request){
        $params = $request->param();
        var_dump($params);
    }

}