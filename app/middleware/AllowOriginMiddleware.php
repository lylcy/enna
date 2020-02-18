<?php
declare (strict_types = 1);

namespace app\middleware;

use app\Request;
use enna\interfaces\MiddlewareInterface;
use think\facade\Config;
use think\Response;

class AllowOriginMiddleware implements MiddlewareInterface
{
    /**
     * header头
     * @var array
     */
    protected $header = [
        'Access-Control-Allow-Origin'   => '*',
        'Access-Control-Allow-Headers'  => 'Authori-zation,Authorization, Content-Type, If-Match, If-Modified-Since, If-None-Match, If-Unmodified-Since, X-Requested-With',
        'Access-Control-Allow-Methods'  => 'GET,POST,PATCH,PUT,DELETE,OPTIONS,DELETE',
        'Access-Control-Max-Age'        =>  '1728000'
    ];

    /**
     * 允许跨域的域名
     * @var string
     */
    protected $cookieDomain;
    /**
     * 处理请求
     *
     * @param \think\Request $request
     * @param \Closure       $next
     * @return Response
     */
    public function handle(Request $request, \Closure $next)
    {
        $this->cookieDomain = Config::get('cookie.domain', '');
        $header = $this->header;
        $origin = $request->header('origin');

        if ($origin && ('' != $this->cookieDomain && strpos($origin, $this->cookieDomain)))
            $header['Access-Control-Allow-Origin'] = $origin;

        if ($request->method(true) == 'OPTIONS') {
            $response = Response::create('ok')->code(200)->header($header);
        } else {
            $response = $next($request)->header($header);
        }

        return $response;
    }
}
