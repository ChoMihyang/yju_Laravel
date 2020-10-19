<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// uri : foo 라는 uri 가 요청되었을 경우
// action : 객체화하고자 하는 컨트롤러 @ 그 객체에서 호출할 메서드 이름

Route::get('/foo', 'FooController@name');

Route::get('/bar','BarController@info');
