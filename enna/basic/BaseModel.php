<?php


namespace enna\basic;


use think\facade\Db;
use think\Model;

class BaseModel extends Model
{
    private static $errorMsg;

    const DEFAULT_ERROR_MSG = '操作失败,请稍后重试';

    /**
     * 开启事务
     */
    public static function beginTrans()
    {
        Db::startTrans();
    }

    /**
     * 提交事务
     */
    public static function commitTrans()
    {
        Db::commit();
    }

    /**
     * 关闭事务
     */
    public static function roobackTrans(){
        Db::rollback();
    }


    /**
     * @param string $errorInfo 错误信息
     * @param bool $rollback 是否回滚事务
     * @return bool
     */
    protected static function setErrorInfo($errorInfo = self::DEFAULT_ERROR_MSG,$rollback = false){
        if($rollback){
            self::roobackTrans();
        }
        self::$errorMsg = $errorInfo;
        return false;
    }

    /**
     * 获取错误信息
     * @param string $defaultMsg
     * @return string
     */
    public static function getErrorInfo($defaultMsg = self::DEFAULT_ERROR_MSG)
    {
        return !empty(self::$errorMsg) ? self::$errorMsg : $defaultMsg;
    }

    /**
     * 根据结果提交滚回事务
     * @param $result
     */
    public static function checkTrans($result){
        if($result){
            self::commitTrans();
        }else{
            self::roobackTrans();
        }
    }
}