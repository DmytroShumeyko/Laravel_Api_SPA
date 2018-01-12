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

Route::prefix('api')->group(function () {
    Route::group(['middleware' => ['auth']], function () {
        Route::get('/company_data', 'CompanyController@getAllCompanyData');
        Route::resource('/sales', 'SaleController', ['only' => [
            'store', 'update', 'destroy'
        ]]);
        Route::resource('/sales/{sale}/sale_items', 'SaleItemController', ['only' => [
            'store', 'update', 'destroy'
        ]]);
        Route::resource('/orders/{order}/order_items', 'OrderItemController', ['only' => [
            'store', 'update', 'destroy'
        ]]);
        Route::resource('/orders', 'OrderController', ['only' => [
            'store', 'update', 'destroy'
        ]]);
        Route::resource('/payments', 'PaymentController', ['only' => [
            'store', 'update', 'destroy'
        ]]);
        Route::resource('/withdraws', 'WithdrawController', ['only' => [
            'store', 'update', 'destroy'
        ]]);
        Route::get('/user_data', 'UserController@getAllUserData');
        Route::get('/allProducts', 'ProductController@allProducts');
        Route::resource('/users', 'UserController', ['only' => [
            'update'
        ]]);
        Route::resource('/company', 'CompanyController', ['only' => [
            'store', 'update'
        ]]);
        Route::resource('/vendors', 'VendorController', ['only' => [
            'store', 'update'
        ]]);
        Route::resource('/products', 'ProductController', ['only' => [
            'store', 'update', 'destroy'
        ]]);
        Route::resource('/products/{product}/products_history', 'ProductHistoryController', ['only' => [
            'store', 'update', 'destroy'
        ]]);
    });
});
Route::group(['middleware' => ['auth']], function () {
    Route::any('{all}', function () {
        return view('Home');
    })->where(['all' => '.*']);
});