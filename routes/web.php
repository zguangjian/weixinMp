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

Route::get('/', function () {
    return view('welcome');
});

Route::any('/connect', 'WechatController@connect');
Route::get("/menu", 'WechatController@menu');
Route::get("/qrcode", 'WechatController@qrcode');

//网页授权
Route::get("/oauth", 'WechatController@oauth')->name('oauth');
Route::get("/oauth_callback", 'WechatController@oauthCallback')->name('oauthCallback');
Route::get("/shorten", 'WechatController@shorten');

