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

Auth::routes();

Route::get('/', function () {
    return redirect('/login');
});

Route::get('/home', 'HomeController@index')->name('home');
Route::resource('/products', 'Provider\ProductController')->except(['show']);
Route::resource('/inventories', 'Inventory\InventoryController')->except(['show']);
Route::get('/users/{user}/inventories', 'User\UserInventoryController@index')->name('users.inventories.index');
Route::get('/users/{user}/inventories/{inventory}', 'User\UserInventoryController@create')->name('users.inventories.create');
Route::post('/users/{user}/inventories/{inventory}', 'User\UserInventoryController@store')->name('users.inventories.store');