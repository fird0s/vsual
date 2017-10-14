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

// Author Page

Route::match(['get', 'post'], '/author/login', "AccountController@login")->name('author_login');
Route::match(['get', 'post'], '/author/profile', "AccountController@profile")->name('author_profile');
Route::match(['get', 'post'], '/author/change_password', "AccountController@change_pwd")->name('author_change_pwd');
Route::match(['get', 'post'], '/author/products', "AccountController@list_product")->name('author_list_product');
Route::match(['get', 'post'], '/author/add_product', "AccountController@add_product")->name('author_add_product');
