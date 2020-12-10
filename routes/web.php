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

Route::prefix('/student')->group(function () {
    // 전체 학생 목록 출력
    Route::get('/all', 'StudentController@list');

    // 새 학생 정보 입력 후 전체 목록 출력
    Route::post('/insert', 'StudentController@insert');

    // 학생 정보 수정 페이지 출력
    Route::get('/modify_view', 'StudentController@getStdInfo');

    // DB 내 학생 정보 업데이트 후 전체 목록 출력
    Route::get('/modify', 'StudentController@modify');

    // 학생의 성적 정보 삭제 후 전체 목록 출력
    Route::post('/delete', 'StudentController@delete');
});




