<?php


namespace app\admin\validate;


use enna\basic\BaseValidate;

class LoginValidate extends BaseValidate
{
    protected $rule = [
        'account' => 'require',
        'password' => 'require'
    ];

    protected $message = [
        'account' => '登录账号必填',
        'password' => '登录秘密啊必填',
    ];
}