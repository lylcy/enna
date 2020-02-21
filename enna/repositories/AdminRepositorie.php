<?php


namespace enna\repositories;


use app\model\admin\AdminModel;
use app\model\admin\AdminTokenModel;
use enna\exceptions\lib\AuthTokenException;

class AdminRepositorie
{

    public static function parseToken($token): array
    {
        if(!$token){
            throw new AuthTokenException(['errorCode' =>800002]);
        }
        $tokenData = AdminTokenModel::where('token','=', $token)->find();
        if(!$tokenData){
            throw new AuthTokenException();
        }
        try {
            [$admin, $type] = AdminModel::parseToken($token);
        } catch (\Throwable $e) {
            $tokenData->delete();
            throw new AuthTokenException();
        }

        if (!$admin || $admin->id != $tokenData->getData('user_id')) {
            $tokenData->delete();
            throw new AuthTokenException(['message'=>'登录状态有误,请重新登录', 'errorCode'=>800001]);
        }
        $tokenData->type = $type;
        return compact('admin', 'tokenData');
    }

}