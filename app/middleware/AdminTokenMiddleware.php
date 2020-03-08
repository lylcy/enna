<?php
declare (strict_types = 1);

namespace app\middleware;



use app\Request;
use enna\exceptions\lib\AuthTokenException;
use enna\interfaces\MiddlewareInterface;
use enna\repositories\AdminRepositorie;
use think\facade\App;


class AdminTokenMiddleware implements MiddlewareInterface
{


    public function handle(Request $request, \Closure $next, $force = true)
    {
        if($request->url() == '/admin/login'
            || $request->controller() == '/Admin/Login'){
            return $next($request);
        }
        $authInfo = null;
        $token = $request->header('Authorization');
        if(!$token){
            $token = $request->header('Authori-zation');
        }
        if(!$token){
            $sattus = 400;
            return app('json')->makeTo($sattus, '暂未登录');
        }
        $token = trim(ltrim($token, 'Bearer'));
        try {
            $authInfo = AdminRepositorie::parseToken($token);
        } catch (AuthTokenException $e){
            if ($force){
                return app('json')->fail($e->getMessage());
            }
        }
        if (!is_null($authInfo)) {
            Request::macro('admin', function () use (&$authInfo) {
                return $authInfo['admin'];
            });
            Request::macro('tokenData', function () use (&$authInfo) {
                return $authInfo['tokenData'];
            });
        }
        Request::macro('isLogin', function () use (&$authInfo) {
            return !is_null($authInfo);
        });
        Request::macro('uid', function () use (&$authInfo) {
            return is_null($authInfo) ? 0 : $authInfo['admin']->user_id;
        });
        return $next($request);
    }
}
