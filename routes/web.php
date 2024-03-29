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

Route::get('/', 'ShorturlController@index');

Route::get('/{short}','ShorturlController@show')->where('short', '[A-Za-z0-9]+');

Route::post('/','ShorturlController@store');
