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


//lineのルート
Route::post('/resister', 'WordController@update');    //単語登録

Route::put('/mode', 'WordController@index');   //単語テストモード選択
Route::post('/weak', 'WordController@index');  //ニガテ単語設定
Route::delete('/delete', 'WordController@edit'); //単語削除機能

Route::get('/test', 'TestController@index');     //単語テスト ok
Route::post('/test', 'TestController@index');    //単語テスト ok

Route::get('/', 'PostController@index');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/users/{id}', 'UserController@show');
Route::middleware('auth')->group(function () {
    Route::get('me', 'UserController@edit');
    Route::post('me', 'UserController@update')->name('users.update');
});
Route::prefix('posts')->as('posts.')->group(function () {
    Route::middleware('auth')->group(function(){
        Route::get('create', 'PostController@create')->name('create');
        Route::post('store', 'PostController@store')->name('store');
        Route::post('{post}/delete', 'PostController@delete')->name('delete');
    });
    Route::get('{post}', 'PostController@show')->name('show');
});

Route::prefix('posts')->as('posts.')->group(function () {
    // auth が適用される (ログインユーザーのみ許可)
    Route::middleware('auth')->group(function () {
        Route::get('create', 'PostController@create')->name('create');
        Route::post('store', 'PostController@store')->name('store');
        Route::post('{post}/delete', 'PostController@delete')->name('delete');
    });

    // auth が適用されない (ログインしてなくても閲覧可)
    Route::get('{post}', 'PostController@show')->name('show');
    Route::post('');
});