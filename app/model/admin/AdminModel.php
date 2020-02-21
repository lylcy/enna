<?php


namespace app\model\admin;


use enna\basic\BaseModel;
use enna\traits\JwtAuthModelTrait;
use enna\traits\ModelTrait;

class AdminModel extends BaseModel
{
    use JwtAuthModelTrait;
    use ModelTrait;

    protected $pk = 'id';

    protected $name = 'admin';

    public static function getAdminByAccount(string $account)
    {
        return self::where('account','=',$account)
            ->find();
    }

}