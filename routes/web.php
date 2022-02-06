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
   Route::get('warehouse/{id}/in','WarehousesController@in')->name('warehouses.in');
   Route::post('stocks/{id}/store','StocksController@store')->name('stocks.matching');
   Route::get('outselect','WarehousesController@outselect')->name('warehouses.outselect');
   Route::get('warehouse/{id}/out','WarehousesController@out')->name('warehouses.out');
   Route::post('stocks/{id}/out','StocksController@out')->name('stocks.out');
   Route::get('deleteselect','WarehousesController@deleteselect')->name('warehouses.deleteselect');
   Route::get('warehouse/{id}/delete','WarehousesController@delete')->name('warehouses.delete');
   Route::delete('histories/{id}/delete','StocksController@delete')->name('histories.delete');
   
   Route::resource('warehouses','WarehousesController');
   Route::resource('items','ItemsController');
   //Route::resource('stocks','StocksController');
   Route::resource('customers','CustomersController');
   
   Route::get('stocks/select','StocksController@warehouse_select')->name('warehouses.stocksSelect');
   Route::get('stocks/{id}/list','StocksController@show')->name('stocks.show');
   Route::get('stocks/{id}/pdf','StocksController@stocksPDF')->name('stocks.PDF');
   Route::get('stocks/{id}/csv','StocksController@stocksCSV')->name('stocks.CSV');    
   
   Route::get('histories/select','StocksController@historiesSelect')->name('warehouses.historiesSelect');
   Route::get('histories/{id}/list','StocksController@history')->name('histories.list');
   Route::get('histories/{id}/pdf','StocksController@historiesPDF')->name('histories.PDF');
   Route::get('histories/{id}/csv','StocksController@historiesCSV')->name('histories.CSV'); 
   Route::get('customer/{id}','CustomersController@month_choose')->name('customers.month_select');
   Route::get('customer/{id}/pdf','CustomersController@invoicePDF')->name('customer.PDF');
   Route::get('customerslist','CustomersController@list')->name('customers.list');
   Route::get('inout', 'StocksController@inoutfile')->name('stocks.inoutfile');
   Route::post('/import','StocksController@import')->name('stocks.import');
});
// php artisan serve --host=$IP --port=$PORT
//php -S $IP:$PORT -c php.ini
