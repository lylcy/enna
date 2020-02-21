<?php


namespace enna\basic;


use app\exception\lib\ParameterException;
use enna\exceptions\lib\ParamerException;
use think\facade\Request;
use think\Validate;

class BaseValidate extends Validate
{
    /**
     * 检测所有客户端发来的参数是否符合验证类规则
     * @param string $scene 验证场景
     * @param string $param 需要验证的参数 不传则全部验证
     * @param int $isArray 是否是数组循环验证
     * @param int $must 是否必须 若不必须 没有参数又非必须 则直接验证通过
     * @param bool $isJson 是否为json数组
     * @return bool
     * @throws ParamerException
     */
    public function checkParams($scene = '',$param = '',$isArray = 0,$must = 1,$isJson = false){
        if($param){
            $params = Request::param($param);
        }else{
            $params = Request::param();
        }
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
                throw new ParamerException([
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

    /**
     * 执行验证
     * @param $params 待验证参数
     * @param string $scene  验证场景
     * @throws ParamerException
     */
    private function checkDo($params,$scene = ''){
        if($scene){
            $check = $this->scene($scene)->check($params); //场景验证
        }else{
            $check = $this->check($params);
        }
        if (!$check) {
            $exception = new ParamerException(
                [
                    'message' => is_array($this->error) ? implode(
                        ';', $this->error) : $this->error,
                ]);
            throw $exception;
        }
    }

    /**
     * 获取规则内的数据 排除其他的多余数据
     * @param $arrays 演示数据
     * @param int $all 是否严格模式1代表所有规则所对应参数都接收
     * @param string $scene
     * @param int $isArray 是否是数组循环获取
     * @param int $must 若为空是否跳过 1不跳过 0跳过
     * @return array
     */
    public function getDataByRule($arrays,$all = 0,$scene = '',$isArray = 0,$must = 1)
    {
        $newArray = [];
        if(!$scene){
            $scene = $this->currentScene;
        }
        if ($scene){
            $rule = $this->scene[$scene];
        }else{
            $rule = array_keys($this->rule);
        }
        if($isArray){
            if(!$must){
                if(!$arrays){
                    return [];
                }
            }
            foreach ($arrays as $inputKey => $inputValue) {
                foreach ($rule as $key => $value) {
                    //某些验证场景 有的不是必填数据 如果未传或者为空 可以跳过接收 最后输出的数组一定是有值的数据
                    if(!$all) {
                        if (!array_key_exists($value, $inputValue)) {
                            continue;
                        }
                        if($inputValue[$value] === '' || $inputValue[$value] === null){
                            continue;
                        }
                    }
                    //接收数据 并且把键名驼峰转下划线
                    $temp = $inputValue[$value];
                    $newKey = self::toUnderScore($value);
                    $newArray[$inputKey][$newKey] = $temp;
                }
            }
        }else{
            foreach ($rule as $key => $value) {
                //某些验证场景 有的不是必填数据 如果未传或者为空 可以跳过接收 最后输出的数组一定是有值的数据
                if(!$all) {
                    if (!array_key_exists($value, $arrays)) {
                        continue;
                    }
                    if($arrays[$value] === '' || $arrays[$value] === null){
                        continue;
                    }
                }
                //接收数据 并且把键名驼峰转下划线
                $temp = $arrays[$value];
                $newKey = self::toUnderScore($value);
                $newArray[$newKey] = $temp;
            }
        }

        return $newArray;
    }

    /**
     * 将蛇形转换未驼峰
     * @param $camelCaps
     * @param string $separator
     * @return string
     */
    protected  static function toUnderScore($camelCaps,$separator='_')
    {
        return strtolower(preg_replace('/([a-z])([A-Z])/', "$1" . $separator . "$2", $camelCaps));
    }




}