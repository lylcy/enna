<?php


namespace app\admin\controller;


use app\admin\validate\LoginValidate;
use app\model\admin\AdminModel;
use app\model\admin\AdminTokenModel;

class Login
{
    public function login(){
        $validate = new LoginValidate();
        $validate->checkParams();
        $params = $validate->getDataByRule(input('post.'));
        $admin = AdminModel::getAdminByAccount($params['account']);
        if($admin) {
            if ($admin->getData('password') !== md5($params['password'].$admin->getData('salt'))){
                return app('json')->fail('账号或密码错误');
            }
        }else{
            return app('json')->fail('账号或密码错误');
        }
        $token = AdminTokenModel::createToken($admin, 'admin');
        if ($token) {
            event('AdminLogin', [$admin, $token]);
            return app('json')->success('登录成功', ['token' => $token->token, 'expires_time' => $token->expires_time]);
        }else{
            return app('json')->fail('登录失败',[],80000);
        }
    }

}