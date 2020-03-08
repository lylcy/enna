<?php
use think\facade\Route;

//index
Route::get('index','index/index');
//login
Route::post('login','login/login');
//user
Route::get('getUserInfo','user/getUserInfo');
//gait
Route::get('getGatiSrcList','gait/getGatiSrcList');
Route::get('test','gait/test');