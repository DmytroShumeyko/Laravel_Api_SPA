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

Route::get('/', 'HomeController@index')->name('home');


Route::group(['middleware' => ['auth']], function () {
    Route::group(['middleware' => ['checkCompany']], function () {
        Route::resource('/sales', 'SaleController');
        Route::resource('/sales/{sale}/sale_items', 'SaleItemController');
        Route::resource('/orders/{order}/order_items', 'OrderItemController');
        Route::resource('/orders', 'OrderController');
        Route::resource('/payments', 'PaymentController');
        Route::resource('/withdraws', 'WithdrawController');
        Route::get('/company_data', 'CompanyController@getAllCompanyData');
    });
    Route::get('/user_data', 'UserController@getAllUserData');
    Route::resource('/users', 'UserController');
    Route::resource('/company', 'CompanyController');
    Route::resource('/vendors', 'VendorController');
    Route::resource('/vendors/{vendor}/products', 'ProductController');
    Route::resource('/products/{product}/products_history', 'ProductHistoryController');
});



