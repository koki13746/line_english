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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/test', function () {
    return view('welcome');
});

//Route::post('/test', 'LineBotController@test');

Route::group(['namespace' => 'Api'], function() {
    // LineからのWebhookを受信
    Route::post('/line/webhook', 'LineWebhookController@webhook')->name('line.webhook');
    Route::post('/line/index', 'LineWebhookController@index')->name('line.index');
});
