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

Route::get('/','OrdersController@index')->name('global_index');
Route::get('/orders','OrdersController@index')->name('index');

Route::post('/orders','OrdersController@store')->name('store');

Route::get('/orders/find','OrdersController@find')->name('find');

