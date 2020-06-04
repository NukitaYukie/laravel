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
Route::get('XXX','Admin\AAAController@bbb');


Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::get('/', 'NewsController@index');
Route::get('/profile', 'ProfileController@index');

Route::group(['prefix' => 'admin', 'middleware' => 'auth'], function() {
    Route::get('news/create', 'Admin\NewsController@add');
    Route::post('news/create', 'Admin\NewsController@create');
    Route::get('news', 'Admin\NewsController@index');
    Route::get('news/edit', 'Admin\NewsController@edit');
    Route::post('news/edit', 'Admin\NewsController@update');
    Route::get('news/delete', 'Admin\NewsController@delete');   
 
    Route::get('profile','Admin\ProfileController@index');
    Route::get('profile/create','Admin\ProfileController@add');
    Route::post('profile/create','Admin\ProfileController@create');
    Route::get('profile/edit','Admin\ProfileController@edit');
    Route::post('profile/edit','Admin\ProfileController@update');
    Route::get('profile/delete', 'Admin\ProfileController@delete');
    
    Route::get('product', 'Admin\ProductController@index');
    Route::get('product/create', 'Admin\ProductController@add');
    Route::post('product/create', 'Admin\ProductController@create');
    Route::get('product/edit','Admin\ProductController@edit');
    Route::post('product/edit','Admin\ProductController@update');
    Route::get('product/delete', 'Admin\ProductController@delete');
    
    Route::get('orders', 'Admin\OrdersController@index');
    Route::get('orders/create', 'Admin\OrdersController@add');
    Route::post('orders/create', 'Admin\OrdersController@create');
    Route::get('orders/edit','Admin\OrdersController@edit');
    Route::post('orders/edit','Admin\OrdersController@update');
    Route::get('orders/delete', 'Admin\OrdersController@delete');
    
});
