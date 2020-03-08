<?php


namespace app\model;


use enna\basic\BaseModel;

class SystemConfigModel extends BaseModel
{
    protected $name = 'basic_set';

    protected $pk = 'id';

    /**
     * 更新添加设置操作
     * @param $params
     * @return array|bool|int
     * @throws \think\db\exception\DataNotFoundException
     * @throws \think\db\exception\DbException
     * @throws \think\db\exception\ModelNotFoundException
     */
    public function createOrUpdateSetUp($params)
    {
        $result = [];
        $paramsKey = array_keys($params);
        $keys = self::where('set_key','in',$paramsKey)
            ->select();
        $insert = [];
        if($keys->isEmpty()){//全部插入新的
            foreach ((array)$params as $key => $value){
                $temp = [];
                $temp['set_key'] = $key;
                if(is_array($value)){
                    $temp['set_value'] = json_encode($value);
                }else{
                    $temp['set_value'] = $value;
                }
                $temp['create_time'] = time();
                $temp['update_time'] = time();
                $insert[] = $temp;
            }
        }else{//有更新操作
            $result = true;
            $updateKey = $keys->column('set_key');
            foreach ($keys as $key){
                if(is_array($params[$key->getData('set_key')])){
                    $setValue = json_encode($params[$key->getData('set_key')]);
                }else{
                    $setValue = $params[$key->getData('set_key')];
                }

                $result = $result & $key->save([
                        'set_value'=>$setValue,
                        'update_time' => time()
                    ]);
            }
            foreach ($params as $key => $value){
                if(in_array($key,$updateKey)){
                    continue;
                }
                $temp['set_key'] = $key;
                if(is_array($value)){
                    $temp['set_value'] = json_encode($value);
                }else{
                    $temp['set_value'] = $value;
                }
                $temp['create_time'] = time();
                $temp['update_time'] = time();
                $insert[] = $temp;
            }
        }
        if($insert){
            $result = self::insertAll($insert);
        }
        return $result;
    }


}