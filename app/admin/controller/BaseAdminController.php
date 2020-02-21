<?php


namespace app\admin\controller;


use app\middleware\AdminTokenMiddleware;
use enna\basic\BaseController;

class BaseAdminController extends BaseController
{
    protected $middleware = [
        AdminTokenMiddleware::class,
    ];



}