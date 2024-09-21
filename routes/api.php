<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('register','Front\ApiController@registerCustomerGenerate');
Route::post('login','Front\ApiController@loginCustomerGenerate');
Route::post('otp-authenticate','Front\ApiController@otpAuthenticate');
Route::post('get-product-types','Front\ApiController@getProductTypes');
Route::post('get-categories','Front\ApiController@getCategories');
Route::post('get-default-categories','Front\ApiController@getDefaultCategories');
Route::post('get-subcategories','Front\ApiController@getSubCategories');
Route::post('get-default-subcategories','Front\ApiController@getDefaultSubCategories');
Route::post('get-products','Front\ApiController@getProducts');
Route::post('get-filter-products','Front\ApiController@getFilterProducts');
Route::post('get-product-on-date','Front\ApiController@getProductOnDate');
Route::post('get-sort-products','Front\ApiController@getSortProducts');
Route::post('search-results','Front\ApiController@searchResults');
Route::post('get-product-details','Front\ApiController@getProductDetails');


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


Route::middleware('auth:sanctum')->group(function () {
    Route::post('take-rent','Front\ApiController@takeRentItem');
    Route::post('get-profile','Front\ApiController@getCustomerProfile');
    Route::post('get-active-orders','Front\ApiController@getActiveOrders');
    Route::post('get-previous-orders','Front\ApiController@getPreviousOrders');
    Route::post('get-warehouses','Front\ApiController@getwarehouses');
    Route::post('get-open-tickets','Front\ApiController@getCustomerOpenTickets');
    Route::post('get-closed-tickets','Front\ApiController@getCustomerclosedTickets');
    Route::post('get-listing','Front\ApiController@getCustomerListing');
    Route::post('get-sales','Front\ApiController@getCustomerSales');
    Route::post('get-sale-detail','Front\ApiController@getCustomerSaleDetail');
    Route::post('confirm-sale','Front\ApiController@confirmCustomerSale');
    Route::post('my-sales','Front\ApiController@mySales');
    Route::post('get-planners','Front\ApiController@getCustomerPlanner');
    Route::post('add-warehouse','Front\ApiController@addWarehouse');
    Route::post('add-listing','Front\ApiController@addListing');
    Route::post('rent-booking','Front\ApiController@rentBooking');
    Route::post('confirm-order','Front\ApiController@confirmOrder');
    Route::post('get-all-product-items','Front\ApiController@getAllProductItems');
    Route::post('get-available-product-items','Front\ApiController@getAvailableProductItems');
    Route::post('get-planner','Front\ApiController@getPlanner');
    Route::post('get-support-categories','Front\ApiController@getSupportCategories');
    Route::post('get-support-tickets','Front\ApiController@getSupportTickets');
    Route::post('logout','Front\ApiController@logout');

});
