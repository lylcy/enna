<?php
declare (strict_types = 1);

namespace app\middleware;

use app\Request;
use enna\interfaces\MiddlewareInterface;

class TokenMiddleware implements MiddlewareInterface
{
    /**
     * 处理请求
     *
     * @param \think\Request $request
     * @param \Closure       $next
     * @return Response
     */
    public function handle(Request $request, \Closure $next)
    {
        $request->pid = 19999;
        $response = $next($request);
        return $response;
    }
}
