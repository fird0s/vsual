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

// Index Route
Route::match(['get', 'post'], '/', "HomeController@index")->name('home');
Route::match(['get', 'post'], '/{slug_url}', "HomeController@view_product")->name('view_product');
Route::match(['get', 'post'], '/category/{category_slug}', "HomeController@category")->name('category');
Route::match(['get', 'post'], '/download/{slug_url}', "HomeController@download")->name('download');

// Author Page
Route::match(['get', 'post'], '/author/login', "AccountController@login")->name('author_login');
Route::match(['get', 'post'], '/author/profile', "AccountController@profile")->name('author_profile');
Route::match(['get', 'post'], '/author/change_password', "AccountController@change_pwd")->name('author_change_pwd');
Route::match(['get', 'post'], '/author/logout', "AccountController@author_logout")->name('author_logout');
Route::match(['get', 'post'], '/author/register', "AccountController@author_register")->name('author_register');

Route::match(['get', 'post'], '/author/expired_subscription', "AccountController@expired_subscription")->name('author_expired_subscription');
Route::match(['get', 'post'], '/author/calculate_revenue', "AccountController@calculate_revenue")->name('author_calculate_revenue');

// Author Product Page
Route::match(['get', 'post'], '/author/products', "AccountController@list_product")->name('author_list_product');
Route::match(['get', 'post'], '/author/add_product', "AccountController@add_product")->name('author_add_product');
Route::match(['get', 'post'], '/author/product/delete/{id}', "AccountController@delete_product")->name('author_delete_product');
Route::match(['get', 'post'], '/author/product/edit/{id}', "AccountController@edit_product")->name('author_edit_product');

// reports
Route::match(['get', 'post'], '/author/report', "AccountController@author_report")->name('author_report');

// page
Route::match(['get', 'post'], '/page/about_us', "PageController@about_us")->name('page_about_us');
Route::match(['get', 'post'], '/page/membership', "PageController@membership")->name('page_membership');
Route::match(['get', 'post'], '/page/license', "PageController@license")->name('page_license');

// subscriber
Route::match(['get', 'post'], '/membership/register', "SubscribeController@register")->name('subscriber_register');
Route::match(['get', 'post'], '/membership/account', "SubscribeController@account")->name('subscriber_account');
Route::match(['get', 'post'], '/membership/account/payment_status', "SubscribeController@getPaymentStatus")->name('subscriber_payment_status');
Route::match(['get', 'post'], '/membership/account/subscriptions', "SubscribeController@subscriptions")->name('subscriber_subscriptions');
Route::match(['get', 'post'], '/membership/account/downloads', "SubscribeController@downloads")->name('subscriber_download');
Route::match(['get', 'post'], '/membership/login', "SubscribeController@login")->name('subscriber_login');
Route::match(['get', 'post'], '/membership/logout', "SubscribeController@logout")->name('subscriber_logout');

Auth::routes();

