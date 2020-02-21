<?php


namespace app\model\admin;


use enna\basic\BaseModel;

class AdminTokenModel extends BaseModel
{
    protected $name = 'admin_token';

    protected $type = [
        'create_time' => 'datetime',
        'login_ip' => 'string'
    ];

    protected $autoWriteTimestamp = true;

    protected $updateTime = false;

    public static function onBeforeInsert(AdminTokenModel $token)
    {
        if (!isset($token['login_ip']))
            $token['login_ip'] = app()->request->ip();
    }

    /**
     * 创建token并且保存
     * @param AdminModel $admin
     * @param $type
     * @return UserToken
     */
    public static function createToken(AdminModel $admin, $type): self
    {
        $tokenInfo = $admin->getToken($type);
        return self::create([
            'user_id' => $admin->getData('id'),
            'token' => $tokenInfo['token'],
            'expires_time' => date('Y-m-d H:i:s', $tokenInfo['params']['exp'])
        ]);
    }

    /**
     * 删除一天前的过期token
     * @return bool
     * @throws \Exception
     */
    public static function delToken()
    {
        return self::where('expires_time', '<', date('Y-m-d H:i:s',strtotime('-1 day')))->delete();
    }

}