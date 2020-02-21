<?php
use think\facade\Route;


//Route::get('test','index/index')->allowCrossDomain();
Route::get('index','index/index');
Route::post('login','login/login');
Route::get('getAdminInfo','user/getAdminInfo');