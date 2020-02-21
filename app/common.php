<?php
// 应用公共文件
function backResult($errorCode = 0,$message = '操作成功',$data = []){
    $return = [];
    $return['data'] = $data;
    $return['error_code'] = $errorCode;
    if($errorCode == 0){
        return app('json')->success($message,$return);
    }else{
        return app('json')->fail($message,$return);
    }
}