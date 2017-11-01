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



// Administrator
Route::match(['get', 'post'], '/admin/author', "AdminController@admin_author")->name('admin_author');
Route::match(['get', 'post'], '/admin/author/detail/{id}', "AdminController@admin_author_detail")->name('admin_author_detail');
Route::match(['get', 'post'], '/admin/author/add', "AdminController@admin_author_add")->name('admin_author_add');

Route::match(['get', 'post'], '/admin/logout', "AdminController@admin_logout")->name('admin_logout');
Route::match(['get', 'post'], '/admin/dashboard', "AdminController@admin_dashboard")->name('admin_dashboard');

Route::match(['get', 'post'], '/admin/payment_request', "AdminController@admin_payment_request")->name('admin_payment_request');
Route::match(['get', 'post'], '/admin/payment_request/pay/{id}', "AdminController@admin_pay_request")->name('admin_pay_request');
Route::match(['get', 'post'], '/admin/payment/status', "AdminController@admin_payment_status")->name('admin_payment_status');

Route::match(['get', 'post'], '/admin/membership', "AdminController@admin_membership")->name('admin_membership');
Route::match(['get', 'post'], '/admin/membership/{id}', "AdminController@admin_membership_detail")->name('admin_membership_detail');

Route::match(['get', 'post'], '/admin/admin', "AdminController@admin_admin")->name('admin_admin');
Route::match(['get', 'post'], '/admin/admin/add', "AdminController@admin_add_admin")->name('admin_add_admin');

Route::match(['get', 'post'], '/admin/products', "AdminController@admin_product")->name('admin_product');
Route::match(['get', 'post'], '/admin/product/edit/{id}', "AdminController@admin_edit_product")->name('admin_edit_product');

Route::match(['get', 'post'], '/admin/profile/edit', "AdminController@admin_profile_edit")->name('admin_profile_edit');
Route::match(['get', 'post'], '/admin/forgot_password', "AdminController@admin_forgot_password")->name('admin_forgot_password');
Route::match(['get', 'post'], '/admin/login', "AdminController@admin_login")->name('admin_login');



Route::match(['get', 'post'], '/admin/category/delete/{id}', "AdminController@admin_delete_category")->name('admin_delete_category');
Route::match(['get', 'post'], '/admin/category/edit/{id}', "AdminController@admin_edit_category")->name('admin_edit_category');
Route::match(['get', 'post'], '/admin/category/add', "AdminController@admin_add_category")->name('admin_add_category');
Route::match(['get', 'post'], '/admin/category', "AdminController@admin_list_category")->name('admin_list_category');


// Index Route
Route::match(['get', 'post'], '/', "HomeController@index")->name('home');
Route::match(['get', 'post'], '/popular', "HomeController@product_popular")->name('product_popular');
Route::match(['get', 'post'], '/free', "HomeController@product_free")->name('product_free');


Route::match(['get', 'post'], '/{slug_url}', "HomeController@view_product")->name('view_product');
Route::match(['get', 'post'], '/category/{category_slug}', "HomeController@category")->name('category');
Route::match(['get', 'post'], '/download/{slug_url}', "HomeController@download")->name('download');

// Author Page
Route::match(['get', 'post'], '/author/', "AccountController@login")->name('author_login');
Route::match(['get', 'post'], '/author/login', "AccountController@login")->name('author_login');
Route::match(['get', 'post'], '/author/forgot_password', "AccountController@forgot_password")->name('author_forgot_password');

Route::match(['get', 'post'], '/author/profile', "AccountController@profile")->name('author_profile');
Route::match(['get', 'post'], '/author/change_password', "AccountController@change_pwd")->name('author_change_pwd');
Route::match(['get', 'post'], '/author/logout', "AccountController@author_logout")->name('author_logout');
Route::match(['get', 'post'], '/author/register', "AccountController@author_register")->name('author_register');

// Author Page Reports
Route::match(['get', 'post'], '/author/report', "AccountController@author_report")->name('author_report');
Route::match(['get', 'post'], '/author/report/earnings', "AccountController@author_report_earnings")->name('author_report_earnings');
Route::match(['get', 'post'], '/author/report/withdrawal', "AccountController@author_report_withdrawal")->name('author_report_withdrawal');
Route::match(['get', 'post'], '/author/report/withdrawal/request', "AccountController@author_report_withdrawal_request")->name('author_report_withdrawal_request');

Route::match(['get', 'post'], '/author/expired_subscription', "AccountController@expired_subscription")->name('author_expired_subscription');
Route::match(['get', 'post'], '/author/calculate_revenue', "AccountController@calculate_revenue")->name('author_calculate_revenue');

// Author Product Page
Route::match(['get', 'post'], '/author/products', "AccountController@list_product")->name('author_list_product');
Route::match(['get', 'post'], '/author/add_product', "AccountController@add_product")->name('author_add_product');
Route::match(['get', 'post'], '/author/product/delete/{id}', "AccountController@delete_product")->name('author_delete_product');
Route::match(['get', 'post'], '/author/product/edit/{id}', "AccountController@edit_product")->name('author_edit_product');

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
Route::match(['get', 'post'], '/membership/forgot_password', "SubscribeController@forgot_password")->name('subscriber_forgot_password');

Auth::routes();
