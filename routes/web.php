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

Route::get('signup','Auth\RegisterController@showRegistrationForm')->name('signup.get');
Route::post('signup','Auth\RegisterController@register')->name('signup.post');

Route::get('login','Auth\LoginController@showLoginForm')->name('login');
Route::post('login','Auth\LoginController@login')->name('login.post');
Route::get('logout','Auth\LoginController@logout')->name('logout.get');

Route::group(['middleware'=>'auth'],function(){
   Route::get('inselect','WarehousesController@inselect')->name('warehouses.inselect');
   Route::post('warehouse/{id}/in','WarehousesController@in')->name('warehouses.in');
   Route::get('outselect','WarehousesController@outselect')->name('warehouses.outselect');
   Route::post('warehouse/{id}/out','WarehousesController@out')->name('warehouses.out');
   Route::resource('warehouses','WarehousesController');
   Route::resource('items','ItemsController');
   Route::resource('stocks','StocksController');
   Route::get('stocks/select','StocksController@select')->name('stocks.select');
   
});
