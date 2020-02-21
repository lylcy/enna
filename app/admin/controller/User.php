<?php


namespace app\admin\controller;




use app\Request;

class User extends BaseAdminController
{
    public function getAdminInfo(Request $request){
        $data = $request->admin();
        $data = $data->toArray();
        return app('json')->success('执行成功', $data);
    }

}