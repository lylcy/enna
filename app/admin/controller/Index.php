<?php


namespace app\admin\controller;


use app\admin\model\AdminModel;
use app\Request;


class Index
{

    public function index(Request $request){
        $data = $request->admin()->toArray();
        return app('json')->success('执行成功', $data);
    }

}