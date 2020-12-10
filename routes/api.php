<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('/all-product', 'SaleController@allProduct');
Route::get('/get-category-product/{category_id}', 'SaleController@categoryProduct');
Route::get('/sale/all/{per_page}', 'SaleController@allSale');
Route::post('/sale/delete', 'SaleController@saleDelete');
Route::get('/sale/search/{from}/{to}/{table_no}/{per_page}', 'SaleController@search');
Route::get('/sale/get/{id}', 'SaleController@getSingleSale');
Route::get('/get-all-sale', 'SaleController@getAllSaleQuantity');
Route::get('/get-all-sale-amount', 'SaleController@getAllSalePrice');
