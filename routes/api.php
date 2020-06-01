<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// for api
Route::group(['prefix' => 'front'], function () {
    Route::post('/get_token', 'Auth\LoginController@getApiToken');
    Route::post('/user_devices', 'Api\UserDeviceController@store')->middleware('auth:api');
    Route::get('/user_devices', 'Api\UserDeviceController@store')->middleware('auth:api');
    Route::get('/system_statuses', 'Api\SystemStatusController@index');
});
Route::post('recycle/loadDataAjax', 'Front\Api\RecycleProductController@loadData')->name('front.recycle.loadDataAjax');
