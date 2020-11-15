<?php



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

//Route::get('/', function () {
//    return view('welcome');
//});S

use Illuminate\Support\Facades\Route;

// fileUpload.blade.php 파일 이동 시 FileUploadController 내 fileUpload() 메서드 실행
Route::get('/fileUpload', 'FileUploadController@fileUpload');

// file-upload.blade.php 파일 이동 시 FileUploadController 내 fileUploadPost() 메서드 실행
Route::post('/file-upload', 'FileUploadController@fileUploadPost');

// stdlist.blade.php 파일 이동 시 studentController 내 list() 메서드 실행
Route::get('/stdlist', 'studentController@list');

// ggeneration.blade.php 파일 이동 시 studentController 내 createGroup() 메서드 실행
Route::post('/ggeneration','studentController@createGroup');



