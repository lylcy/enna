<?php


namespace enna\basic;


use app\exception\lib\ParameterException;
use think\Validate;

class BaseValidate extends Validate
{
    public function checkParams($scene = '',$param = '',$isArray = 0,$must = 1,$isJson = false){

        if($param){
            $params = Request::param($param);
        }else{
            $params = Request::param();
        }
//        $str = '[{"cart_ids":"19,21,22,24,","address":{"id":3,"city_id":38,"account_id":20,"region":"河北省-石家庄市-长安区","address":"出去尾萼蔷薇王企鹅群无111","name":"李四","phone":"13452242234","program_id":1,"is_default":1,"create_time":"2019-09-11 10:40:11","update_time":"2019-10-15 17:41:12","status":1},"coupon_id":0,"coupon_price":0,"send_price":0,"total_price":207.7,"recovery_method":1,"discount":0},{"cart_ids":"20,23,","address":{"id":3,"city_id":38,"account_id":20,"region":"河北省-石家庄市-长安区","address":"出去尾萼蔷薇王企鹅群无111","name":"李四","phone":"13452242234","program_id":1,"is_default":1,"create_time":"2019-09-11 10:40:11","update_time":"2019-10-15 17:41:12","status":1},"coupon_id":0,"coupon_price":0,"send_price":2,"total_price":26.92,"recovery_method":1,"discount":0}]';
//        $str = json_decode($str,true);
//        var_dump($str);die;
        if($isJson){
            $params = json_decode($params,true);
        }

        if($must != 1){
            if(!$params){
                return true;
            }
        }
        if($isArray){//需要循环验证
            if(!$params){
                throw new ParameterException([
                    'message' => '参数错误,别想搞事情',
                ]);
            }
            foreach ($params as $value){
                $this->checkDo($value,$scene);
            }
        }else{
            $this->checkDo($params,$scene);
        }

        return true;
    }

}