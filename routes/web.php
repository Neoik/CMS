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

Auth::routes();
//shippings
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/shippings', 'HomeController@shippings_json')->name('shippings_json');
Route::get('/add', 'HomeController@add')->name('add');
Route::post('/add', 'HomeController@add_shipping')->name('add_shipping');
Route::post('/estimate', 'HomeController@estimate')->name('estimate');
Route::get('/ports_json', 'HomeController@ports_json')->name('ports_json');
Route::get('/view/{shipping}', 'HomeController@view')->name('view');
Route::post('/view/{shipping}/update', 'HomeController@update_shipping')->name('update_shipping');
Route::get('/view/{shipping}/json', 'HomeController@view_json')->name('view_json');