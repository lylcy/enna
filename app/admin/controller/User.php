<?php


namespace app\admin\controller;




use app\Request;

class User
{

    /**
     * 获取用户信息
     * @param Request $request
     * @return mixed
     */
    public function getUserInfo(Request $request){
        $data = $request->admin();
        $data = $data->toArray();
        return app('json')->success('执行成功', $data);
    }

}