<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\OfferController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\SmsController;
use App\Http\Controllers\Customer\Auth\AuthOtpController;
use App\Http\Controllers\FakeDataController;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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

Route::get('/all_cache', function() {

    Artisan::call('cache:clear');
    Artisan::call('optimize');
    Artisan::call('route:cache');
    Artisan::call('route:clear');
    Artisan::call('view:clear');
    Artisan::call('config:cache');
    return '<h1>All cache cleared</h1>';
});

//Clear Cache facade value:
Route::get('/clear_cache', function() {
    $exitCode = Artisan::call('cache:clear');
    return '<h1>Cache facade value cleared</h1>';
});

//Reoptimized class loader:
Route::get('/optimize', function() {
    $exitCode = Artisan::call('optimize');
    return '<h1>Reoptimized class loader</h1>';
});

//Route cache:
Route::get('/route_cache', function() {
    $exitCode = Artisan::call('route:cache');
    return '<h1>Routes cached</h1>';
});

//Clear Route cache:
Route::get('/route_clear', function() {
    $exitCode = Artisan::call('route:clear');
    return '<h1>Route cache cleared</h1>';
});

//Clear View cache:
Route::get('/view_clear', function() {
    $exitCode = Artisan::call('view:clear');
    return '<h1>View cache cleared</h1>';
});

//Clear Config cache:
Route::get('/config_cache', function() {
    $exitCode = Artisan::call('config:cache');
    return '<h1>Clear Config cleared</h1>';
});

Route::get('/', [HomeController::class, 'index'])->name('index');

Route::controller(AuthOtpController::class)->group(function(){
    Route::get('otp/login', 'login')->name('otp.login');
    Route::post('otp/generate', 'generate')->name('otp.generate');
    Route::get('otp/verification/{customer_id}', 'verification')->name('otp.verification');
    Route::post('otp/login', 'loginWithOtp')->name('otp.getlogin');
});

Route::get('/fakertest', [FakeDataController::class, 'index'])->name('faker_index');



Route::get('/products', [HomeController::class, 'products'])->name('products');
Route::get('/product-detail', [HomeController::class, 'product_details'])->name('product_details');
Route::get('/categories', [HomeController::class, 'categories'])->name('categories');
Route::get('/cart', [HomeController::class, 'cart'])->name('cart');
Route::get('/delivery', [HomeController::class, 'delivery'])->name('delivery');
Route::get('/payment', [HomeController::class, 'payment'])->name('payment');
Route::get('/reciept', [HomeController::class, 'reciept'])->name('reciept');

Route::group(['prefix'=>'customer', 'as'=>'customer.', 'namespace'=>'Customer\Auth'], function () {
    Route::get('/register',['uses' => 'RegisterController@create'])->name('create');
    Route::post('/store',['uses' => 'RegisterController@store'])->name('store');
    Route::get('/login', ['uses' => 'LoginController@login'])->name('login');
    Route::post('/do-login', ['uses' => 'LoginController@doLogin'])->name('do.login');
    Route::post('/logout', ['uses' => 'LoginController@logout'])->name('logout');
});

Route::get('/test', [HomeController::class, 'test'])->name('test');

Route::group(['prefix'=>'sms', 'as'=>'sms.'], function() {
    Route::get('/open', [SmsController::class, 'index'])->name('index');

    Route::post('/send',['as' => 'send', 'uses' => 'SmsController@send']);
});


// Administrator Dashboard Routes --Start--
Auth::routes(['login' => false]);
Route::prefix('admin')->group(function () {
    Route::get('/login', 'Auth\LoginController@showLoginForm');
    Route::post('/login', 'Auth\LoginController@login')->name('login');
});

Route::get('/admin', ['uses'=> 'Admin\HomeController@index'])->middleware('auth')->name('admin');
Route::group(['as'=>'admin.', 'middleware'=>'auth', 'prefix'=>'admin', 'namespace'=>'Admin'], function() {

    Route::get('/dashboard', ['uses'=> 'HomeController@index'])->name('dashboard');

    Route::resource('/planners','PlannerController');


    Route::group(['prefix'=>'categories', 'as'=>'categories.'], function() {
        Route::get('/',['as' => 'index', 'uses' => 'CategoryController@index']);
        Route::get('/create',['as' => 'create', 'uses' => 'CategoryController@create']);
        Route::post('/store',['as' => 'store', 'uses' => 'CategoryController@store']);
        Route::get('/edit/{id}',['as' => 'edit', 'uses' => 'CategoryController@edit']);
        Route::put('/update',['as' => 'update', 'uses' => 'CategoryController@update']);
        Route::delete('/destroy/{id}',['as' => 'destroy', 'uses' => 'CategoryController@destroy']);
        Route::get('/change-status/{id}',['as' => 'changeStatus', 'uses' => 'CategoryController@changeStatus']);
    });

    Route::group(['prefix'=>'sub_categories', 'as'=>'sub_categories.'], function() {
        Route::get('/',['as' => 'index', 'uses' => 'SubCategoryController@index']);
        Route::get('/create',['as' => 'create', 'uses' => 'SubCategoryController@create']);
        Route::post('/store',['as' => 'store', 'uses' => 'SubCategoryController@store']);
        Route::get('/edit/{id}',['as' => 'edit', 'uses' => 'SubCategoryController@edit']);
        Route::put('/update',['as' => 'update', 'uses' => 'SubCategoryController@update']);
        Route::delete('/destroy/{id}',['as' => 'destroy', 'uses' => 'SubCategoryController@destroy']);
        Route::get('/change-status/{id}',['as' => 'changeStatus', 'uses' => 'SubCategoryController@changeStatus']);
    });

    Route::group(['prefix'=>'rental_types', 'as'=>'rental_types.'], function() {
        Route::get('/',['as' => 'index', 'uses' => 'RentalTypeController@index']);
        Route::get('/create',['as' => 'create', 'uses' => 'RentalTypeController@create']);
        Route::post('/store',['as' => 'store', 'uses' => 'RentalTypeController@store']);
        Route::get('/edit/{id}',['as' => 'edit', 'uses' => 'RentalTypeController@edit']);
        Route::put('/update',['as' => 'update', 'uses' => 'RentalTypeController@update']);
        Route::delete('/destroy/{id}',['as' => 'destroy', 'uses' => 'RentalTypeController@destroy']);
        Route::get('/change-status/{id}',['as' => 'changeStatus', 'uses' => 'RentalTypeController@changeStatus']);
    });

    Route::group(['prefix'=>'brands', 'as'=>'brands.'], function() {
        Route::get('/',['as' => 'index', 'uses' => 'BrandController@index']);
        Route::get('/create',['as' => 'create', 'uses' => 'BrandController@create']);
        Route::post('/store',['as' => 'store', 'uses' => 'BrandController@store']);
        Route::get('/edit/{id}',['as' => 'edit', 'uses' => 'BrandController@edit']);
        Route::put('/update',['as' => 'update', 'uses' => 'BrandController@update']);
        Route::delete('/destroy/{id}',['as' => 'destroy', 'uses' => 'BrandController@destroy']);
        Route::get('/change-status/{id}',['as' => 'changeStatus', 'uses' => 'BrandController@changeStatus']);
    });

    Route::group(['prefix'=>'products', 'as'=>'products.'], function() {
        Route::get('/',['as' => 'index', 'uses' => 'ProductController@index']);
        Route::get('/create',['as' => 'create', 'uses' => 'ProductController@create']);
        Route::post('/store',['as' => 'store', 'uses' => 'ProductController@store']);
        Route::get('/edit/{id}',['as' => 'edit', 'uses' => 'ProductController@edit']);
        Route::put('/update',['as' => 'update', 'uses' => 'ProductController@update']);
        Route::delete('/destroy/{id}',['as' => 'destroy', 'uses' => 'ProductController@destroy']);
        Route::get('/change-status/{id}',['as' => 'changeStatus', 'uses' => 'ProductController@changeStatus']);
        Route::get('/inventory-transfer',['as' => 'inventory.transfer', 'uses' => 'ProductController@inventoryTransfer']);


        Route::group(['prefix'=>'reviews', 'as'=>'reviews.'], function() {
            Route::get('/',['as' => 'index', 'uses' => 'CustomerReviewController@index']);
            Route::get('/change-status/{id}',['as' => 'changeStatus', 'uses' => 'CustomerReviewController@changeStatus']);
        });

        Route::group(['prefix'=>'items', 'as'=>'items.'], function() {
            Route::get('/{productid}',['as' => 'index', 'uses' => 'ProductItemController@index']);
            Route::get('/view/{id}',['as' => 'view', 'uses' => 'ProductItemController@view']);
        });
    });

    Route::group(['prefix'=>'rent-products', 'as'=>'rent_products.'], function() {
        Route::get('/',['as' => 'index', 'uses' => 'ProductController@index']);
        Route::get('/create',['as' => 'create', 'uses' => 'ProductController@create']);
        Route::post('/store',['as' => 'store', 'uses' => 'ProductController@store']);
        Route::get('/edit/{id}',['as' => 'edit', 'uses' => 'ProductController@edit']);
        Route::put('/update',['as' => 'update', 'uses' => 'ProductController@update']);
        Route::delete('/destroy/{id}',['as' => 'destroy', 'uses' => 'ProductController@destroy']);
        Route::get('/change-status/{id}',['as' => 'changeStatus', 'uses' => 'ProductController@changeStatus']);

        Route::group(['prefix'=>'terms', 'as'=>'rent_terms.'], function() {
            Route::get('/',['as' => 'index', 'uses' => 'RentTermController@index']);
            Route::get('/create',['as' => 'create', 'uses' => 'RentTermController@create']);
            Route::post('/store',['as' => 'store', 'uses' => 'RentTermController@store']);
            Route::get('/edit/{id}',['as' => 'edit', 'uses' => 'RentTermController@edit']);
            Route::put('/update',['as' => 'update', 'uses' => 'RentTermController@update']);
            Route::delete('/destroy/{id}',['as' => 'destroy', 'uses' => 'RentTermController@destroy']);
            Route::get('/change-status/{id}',['as' => 'changeStatus', 'uses' => 'RentTermController@changeStatus']);
        });
    });

    Route::group(['prefix'=>'warehouses', 'as'=>'branches.'], function() {
        Route::get('/',['as' => 'index', 'uses' => 'BranchController@index']);
        Route::get('/create',['as' => 'create', 'uses' => 'BranchController@create']);
        Route::post('/store',['as' => 'store', 'uses' => 'BranchController@store']);
        Route::get('/edit/{id}',['as' => 'edit', 'uses' => 'BranchController@edit']);
            Route::put('/update',['as' => 'update', 'uses' => 'BranchController@update']);
            Route::delete('/destroy/{id}',['as' => 'destroy', 'uses' => 'BranchController@destroy']);
            Route::get('/change-status/{id}',['as' => 'changeStatus', 'uses' => 'BranchController@changeStatus']);
        Route::get('/view/{id}',['as' => 'view', 'uses' => 'BranchController@view']);
        Route::get('/product-items/{id}',['as' => 'show.product.items', 'uses' => 'BranchController@product_items']);

    });

    Route::group(['prefix'=>'customers', 'as'=>'customers.'], function() {

        Route::get('/',['as' => 'index', 'uses' => 'CustomerController@index']);
        Route::get('/create',['as' => 'create', 'uses' => 'CustomerController@create']);
        Route::post('/store',['as' => 'store', 'uses' => 'CustomerController@store']);
        Route::get('/edit/{id}',['as' => 'edit', 'uses' => 'CustomerController@edit']);
        Route::get('/show/{id}',['as' => 'view', 'uses' => 'CustomerController@show']);
        Route::get('/order/{customer_id}',['as' => 'order', 'uses' => 'CustomerController@order']);
        Route::get('/order-history/{customer_id}',['as' => 'history.order', 'uses' => 'CustomerController@history_order']);
        Route::get('/orders/active',['as' => 'active.orders', 'uses' => 'CustomerController@active_orders']);
        Route::get('/orders/history',['as' => 'history.orders', 'uses' => 'CustomerController@history_orders']);

        Route::put('/update',['as' => 'update', 'uses' => 'CustomerController@update']);
        Route::get('/destroy/{id}',['as' => 'destroy', 'uses' => 'CustomerController@destroy']);
        Route::get('/change-status/{id}',['as' => 'changeStatus', 'uses' => 'CustomerController@changeStatus']);

        Route::get('/renting-lists',['as' => 'items.all', 'uses' => 'CustomerController@products']);
        Route::get('/renting-lists/{customer_id}',['as' => 'listing', 'uses' => 'CustomerController@listing']);
        Route::get('/warehouses/{customer_id}',['as' => 'warehouses', 'uses' => 'CustomerController@warehouses']);
        Route::get('/sales/{customer_id}',['as' => 'sales', 'uses' => 'CustomerController@sales']);
        Route::get('/history-sales/{customer_id}',['as' => 'history.sales', 'uses' => 'CustomerController@history_sales']);
        Route::get('/tickets/{customer_id}',['as' => 'tickets', 'uses' => 'CustomerController@tickets']);
        Route::get('/language/{customer_id}/change/{lang}',['as' => 'language.change', 'uses' => 'CustomerController@change_language']);
        Route::get('/planner/{customer_id}',['as' => 'planners', 'uses' => 'CustomerController@planners']);

        Route::get('/orders/returns',['as' => 'order.return', 'uses' => 'ReturnSaleController@index']);

        Route::group(['prefix'=>'tickets', 'as'=>'tickets.'], function() {
            Route::get('/',['as' => 'index', 'uses' => 'CustomerTicketController@index']);
            Route::get('/show/{id}',['as' => 'show', 'uses' => 'CustomerTicketController@show']);
            Route::get('/destroy/{id}',['as' => 'destroy', 'uses' => 'CustomerTicketController@destroy']);
            Route::get('/change-approval/{id}',['as' => 'changeApproval', 'uses' => 'CustomerTicketController@changeApproval']);
            Route::get('/change-status/{id}/{status}',['as' => 'changeStatus', 'uses' => 'CustomerTicketController@changeStatus']);

            Route::post('/store_reply',['as'=>'reply.store', 'uses'=> 'CustomerTicketController@store_reply']);
        });
    });

    // Route::group(['prefix'=>'suppliers', 'as'=>'suppliers.'], function() {
    //     Route::get('/',['as' => 'index', 'uses' => 'SupplierController@index']);
    //     Route::get('/create',['as' => 'create', 'uses' => 'SupplierController@create']);
    //     Route::post('/store',['as' => 'store', 'uses' => 'SupplierController@store']);
    //     Route::get('/edit/{id}',['as' => 'edit', 'uses' => 'SupplierController@edit']);
    //     Route::put('/update',['as' => 'update', 'uses' => 'SupplierController@update']);
    //     Route::get('/destroy/{id}',['as' => 'destroy', 'uses' => 'SupplierController@destroy']);
    //     Route::get('/change-status/{id}',['as' => 'changeStatus', 'uses' => 'SupplierController@changeStatus']);
    // });
    Route::resource('/purchases','PurchaseController');
    Route::get('/change-status/{id}',['prefix'=>'purchases', 'as' => 'purchases.changeStatus', 'uses' => 'PurchaseController@changeStatus']);

    Route::resource('/sales','SaleController');
    Route::get('/change-status/{id}/{status}',['prefix'=>'sales', 'as' => 'sales.changeStatus', 'uses' => 'SaleController@changeStatus']);

    Route::resource('/sale_returns','ReturnSaleController');
    Route::get('/sale_returns/invoice/{id}',['prefix'=>'orders', 'as' => 'sale_returns.invoice.view', 'uses' => 'ReturnSaleController@invoice_view']);
    // Route::get('/change-status/{id}/{status}',['prefix'=>'sale_returns', 'as' => 'sale_returns.changeStatus', 'uses' => 'ReturnSaleController@changeStatus']);

    // Route::resource('/batches','SaleBatchController');

    Route::group(['prefix'=>'orders', 'as'=>'orders.'], function() {
        Route::get('/active',['as' => 'active', 'uses' => 'OrderController@active_orders']);
        Route::get('/history',['as' => 'history', 'uses' => 'OrderController@history_orders']);
        Route::get('/invoice/{id}',['as' => 'invoice.view', 'uses' => 'OrderController@invoice_view']);
        Route::get('/invoice-new/{id}',['as' => 'invoice.view_new', 'uses' => 'OrderController@invoice_view_new']);
        Route::get('/invoice/{id}/download',['as' => 'download.invoice', 'uses' => 'OrderController@createInvoice']);
        // Route::get('/invoice/{id}/pdf',['as' => 'download.pdf', 'uses' => 'OrderController@pdf']);
        Route::get('/return',['as' => 'return', 'uses' => 'ReturnSaleController@index']);
    });
    Route::resource('/orders','OrderController');

    Route::group(['prefix'=>'deliveries'], function() {
        Route::group(['prefix'=>'drivers', 'as'=>'drivers.'], function() {
            Route::get('/',['as' => 'index', 'uses' => 'DriverController@index']);
            Route::get('/create',['as' => 'create', 'uses' => 'DriverController@create']);
            Route::post('/store',['as' => 'store', 'uses' => 'DriverController@store']);
            Route::get('/show/{id}',['as' => 'view', 'uses' => 'DriverController@show']);
            Route::get('/edit/{id}',['as' => 'edit', 'uses' => 'DriverController@edit']);
            Route::put('/update',['as' => 'update', 'uses' => 'DriverController@update']);
            Route::delete('/destroy/{id}',['as' => 'destroy', 'uses' => 'DriverController@destroy']);
            Route::get('/change-status/{id}',['as' => 'changeStatus', 'uses' => 'DriverController@changeStatus']);

            Route::group(['prefix'=>'tickets', 'as'=>'tickets.'], function() {
                Route::get('/',['as' => 'index', 'uses' => 'DriverTicketController@index']);
                Route::get('/show/{id}',['as' => 'show', 'uses' => 'DriverTicketController@show']);
                Route::get('/destroy/{id}',['as' => 'destroy', 'uses' => 'DriverTicketController@destroy']);
                Route::get('/change-approval/{id}',['as' => 'changeApproval', 'uses' => 'DriverTicketController@changeApproval']);
                Route::get('/change-status/{id}/{status}',['as' => 'changeStatus', 'uses' => 'DriverTicketController@changeStatus']);

                Route::post('/store_reply',['as'=>'reply.store', 'uses'=> 'DriverTicketController@store_reply']);
            });
        });
        Route::get('/active',['as' => 'deliveries.orders.active', 'uses' => 'DriverController@active_orders']);
        Route::get('/history',['as' => 'deliveries.orders.history', 'uses' => 'DriverController@history_orders']);
        Route::get('/show/{id}',['as' => 'deliveries.show', 'uses' => 'ShipperController@show_deliveries']);

        Route::group(['prefix'=>'organizations', 'as'=>'shippers.'], function() {
            Route::get('/',['as' => 'index', 'uses' => 'ShipperController@index']);
            Route::get('/show/{id}',['as' => 'show', 'uses' => 'ShipperController@show']);
            Route::get('/active-orders/{id}',['as' => 'active.orders', 'uses' => 'ShipperController@active_orders']);
            Route::get('/history-orders/{id}',['as' => 'history.orders', 'uses' => 'ShipperController@history_orders']);
        });

    });

    Route::resource('/vehicles','VehicleController');
    Route::get('/change-status/{id}',['prefix'=>'vehicles', 'as' => 'vehicles.changeStatus', 'uses' => 'VehicleController@changeStatus']);

    Route::resource('/offers',OfferController::class);
    Route::get('/change-status/{id}',['prefix'=>'offers', 'as' => 'offers.changeStatus', 'uses' => 'OfferController@changeStatus']);

    Route::group(['prefix'=>'users', 'as'=>'users.'], function() {
        Route::get('/',['as' => 'index', 'uses' => 'UserController@index']);
        Route::get('/create',['as' => 'create', 'uses' => 'UserController@create']);
        Route::post('/store',['as' => 'store', 'uses' => 'UserController@store']);
        Route::get('/edit/{id}',['as' => 'edit', 'uses' => 'UserController@edit']);
        Route::put('/update',['as' => 'update', 'uses' => 'UserController@update']);
        Route::delete('/destroy/{id}',['as' => 'destroy', 'uses' => 'UserController@destroy']);
        Route::get('/change-status/{id}',['as' => 'changeStatus', 'uses' => 'UserController@changeStatus']);
    });

    Route::group(['prefix'=>'messages', 'as'=>'messages.'], function() {
        Route::get('/',['as' => 'index', 'uses' => 'MessageController@index']);
        Route::get('/create',['as' => 'create', 'uses' => 'MessageController@create']);
        Route::post('/store',['as' => 'store', 'uses' => 'MessageController@store']);
        Route::get('/edit/{id}',['as' => 'edit', 'uses' => 'MessageController@edit']);
        Route::put('/update',['as' => 'update', 'uses' => 'MessageController@update']);
        Route::delete('/destroy/{id}',['as' => 'destroy', 'uses' => 'MessageController@destroy']);
        Route::get('/change-status/{id}',['as' => 'changeStatus', 'uses' => 'MessageController@changeStatus']);
    });

    Route::group(['prefix'=>'faqs', 'as'=>'faqs.'], function() {
        Route::group(['prefix'=>'types', 'as'=>'types.'], function() {
            Route::get('/',['as' => 'index', 'uses' => 'FaqTypeController@index']);
            Route::get('/create',['as' => 'create', 'uses' => 'FaqTypeController@create']);
            Route::post('/store',['as' => 'store', 'uses' => 'FaqTypeController@store']);
            Route::get('/edit/{id}',['as' => 'edit', 'uses' => 'FaqTypeController@edit']);
            Route::put('/update',['as' => 'update', 'uses' => 'FaqTypeController@update']);
            Route::delete('/destroy/{id}',['as' => 'destroy', 'uses' => 'FaqTypeController@destroy']);
            Route::get('/change-status/{id}',['as' => 'changeStatus', 'uses' => 'FaqTypeController@changeStatus']);
        });

        Route::get('/',['as' => 'index', 'uses' => 'FaqController@index']);
        Route::get('/create',['as' => 'create', 'uses' => 'FaqController@create']);
        Route::post('/store',['as' => 'store', 'uses' => 'FaqController@store']);
        Route::get('/edit/{id}',['as' => 'edit', 'uses' => 'FaqController@edit']);
        Route::put('/update',['as' => 'update', 'uses' => 'FaqController@update']);
        Route::delete('/destroy/{id}',['as' => 'destroy', 'uses' => 'FaqController@destroy']);
        Route::get('/change-status/{id}',['as' => 'changeStatus', 'uses' => 'FaqController@changeStatus']);
    });


    Route::resource('/roles',RoleController::class);

    Route::group(['prefix'=>'settings', 'as'=>'settings.'], function() {
        Route::get('/',['as' => 'index', 'uses' => 'SettingsController@index']);
        Route::put('/general',['as' => 'update.general', 'uses' => 'SettingsController@update']);
        Route::get('/password/change',['as' => 'change.password', 'uses' => 'ChangePasswordController@edit']);
        Route::put('/password/update',['as' => 'update.password', 'uses' => 'ChangePasswordController@update']);
        Route::resource('/delivery-charge', 'DeliveryChargeController');
        Route::resource('/tax-types', 'TaxtypeController');
    });

    //Route::post('/store',['as'=>'tickets.reply.store', 'uses'=> 'TicketReplyController@store']);

});

// Administrator Dashboard Routes --End--


// Seller Dashboard Routes --Start--

Route::get('/seller', ['uses'=> 'seller\HomeController@index'])->middleware('seller.auth')->name('seller');
Route::group(['as'=>'seller.', 'prefix'=>'seller'], function() {
    Route::group(['namespace'=>'Seller\Auth'], function () {
        Route::get('/register',['uses' => 'RegisterController@create'])->name('create');
        Route::post('/store',['uses' => 'RegisterController@store'])->name('store');
        Route::get('/login', ['uses' => 'LoginController@login'])->name('login');
        Route::post('/do-login', ['uses' => 'LoginController@doLogin'])->name('do.login');
        Route::post('/logout', ['uses' => 'LoginController@logout'])->name('logout');
    });

    Route::get('/dashboard', ['middleware'=>'seller.auth', 'uses' => 'Seller\HomeController@index'])->name('dashboard');

    Route::group(['middleware'=>'seller.auth', 'namespace'=>'Seller'], function () {

        Route::group(['prefix'=>'products', 'as'=>'products.'], function() {
            // Route::get('/',['as' => 'index', 'uses' => 'ProductController@index']);
            // Route::get('/create',['as' => 'create', 'uses' => 'ProductController@create']);
            // Route::post('/store',['as' => 'store', 'uses' => 'ProductController@store']);
            // Route::get('/edit/{id}',['as' => 'edit', 'uses' => 'ProductController@edit']);
            // Route::put('/update',['as' => 'update', 'uses' => 'ProductController@update']);
            // Route::delete('/destroy/{id}',['as' => 'destroy', 'uses' => 'ProductController@destroy']);
            // Route::get('/change-status/{id}',['as' => 'changeStatus', 'uses' => 'ProductController@changeStatus']);
            // Route::group(['prefix'=>'reviews', 'as'=>'reviews.'], function() {
            //     Route::get('/',['as' => 'index', 'uses' => 'CustomerReviewController@index']);
            //     Route::get('/change-status/{id}',['as' => 'changeStatus', 'uses' => 'CustomerReviewController@changeStatus']);
            // });
        });

        Route::group(['prefix'=>'rent-products', 'as'=>'rent_products.'], function() {
            // Route::get('/',['as' => 'index', 'uses' => 'ProductController@index']);
            // Route::get('/create',['as' => 'create', 'uses' => 'ProductController@create']);
            // Route::post('/store',['as' => 'store', 'uses' => 'ProductController@store']);
            // Route::get('/edit/{id}',['as' => 'edit', 'uses' => 'ProductController@edit']);
            // Route::put('/update',['as' => 'update', 'uses' => 'ProductController@update']);
            // Route::delete('/destroy/{id}',['as' => 'destroy', 'uses' => 'ProductController@destroy']);
            // Route::get('/change-status/{id}',['as' => 'changeStatus', 'uses' => 'ProductController@changeStatus']);
        });

        Route::group(['prefix'=>'warehouses', 'as'=>'branches.'], function() {
            Route::get('/',['as' => 'index', 'uses' => 'BranchController@index']);
            Route::get('/create',['as' => 'create', 'uses' => 'BranchController@create']);
            Route::post('/store',['as' => 'store', 'uses' => 'BranchController@store']);
            Route::get('/edit/{id}',['as' => 'edit', 'uses' => 'BranchController@edit']);
            Route::get('/view/{id}',['as' => 'view', 'uses' => 'BranchController@view']);
            Route::put('/update',['as' => 'update', 'uses' => 'BranchController@update']);
            // Route::get('/order/{customer_id}',['as' => 'order', 'uses' => 'BranchController@order']);
            // Route::get('/active-orders',['as' => 'active.orders', 'uses' => 'BranchController@active_orders']);
            // Route::get('/history-orders',['as' => 'history.orders', 'uses' => 'BranchController@history_orders']);
            // Route::get('/order-returns',['as' => 'order.return', 'uses' => 'ReturnSaleController@index']);
            // Route::get('/invoice/{id}',['as' => 'invoice.view', 'uses' => 'BranchController@invoice_view']);
            // Route::delete('/destroy/{id}',['as' => 'destroy', 'uses' => 'BranchController@destroy']);
            // Route::get('/change-status/{id}',['as' => 'changeStatus', 'uses' => 'BranchController@changeStatus']);
            // Route::get('/product-items/{id}',['as' => 'show.product.items', 'uses' => 'BranchController@product_items']);
        });

    });

});

// Seller Dashboard Routes --End--


// Branch Dashboard Routes --Start--

Route::get('/warehouse', ['uses'=> 'Branch\HomeController@index'])->middleware('branch.auth')->name('branch');
Route::group(['as'=>'branch.', 'prefix'=>'warehouse'], function() {

    Route::group(['namespace'=>'Branch\Auth'], function () {
        Route::get('/register',['uses' => 'RegisterController@create'])->name('create');
        Route::post('/store',['uses' => 'RegisterController@store'])->name('store');
        Route::get('/login', ['uses' => 'LoginController@login'])->name('login');
        Route::post('/do-login', ['uses' => 'LoginController@doLogin'])->name('do.login');
        Route::post('/logout', ['uses' => 'LoginController@logout'])->name('logout');
    });

    Route::get('/dashboard', ['middleware'=>'branch.auth', 'uses' => 'Branch\HomeController@index'])->name('dashboard');

    Route::group(['middleware'=>'branch.auth', 'namespace'=>'Branch'], function () {

        // Route::group(['prefix'=>'products', 'as'=>'product_items.'], function() {
        //     Route::get('/',['as' => 'index', 'uses' => 'ProductItemController@index']);
        //     Route::get('/create',['as' => 'create', 'uses' => 'ProductItemController@create']);
        //     Route::post('/store',['as' => 'store', 'uses' => 'ProductItemController@store']);
        //     Route::get('/edit/{id}',['as' => 'edit', 'uses' => 'ProductItemController@edit']);
        //     Route::put('/update',['as' => 'update', 'uses' => 'ProductItemController@update']);
        //     Route::delete('/destroy/{id}',['as' => 'destroy', 'uses' => 'ProductItemController@destroy']);
        //     Route::get('/change-status/{id}',['as' => 'changeStatus', 'uses' => 'ProductItemController@changeStatus']);
        //     // Route::group(['prefix'=>'reviews', 'as'=>'reviews.'], function() {
        //     //     Route::get('/',['as' => 'index', 'uses' => 'CustomerReviewController@index']);
        //     //     Route::get('/change-status/{id}',['as' => 'changeStatus', 'uses' => 'CustomerReviewController@changeStatus']);
        //     // });
        // });

        Route::resource('/sales','SaleController');
        Route::get('/change-status/{id}/{status}',['prefix'=>'sales', 'as' => 'sales.changeStatus', 'uses' => 'SaleController@changeStatus']);

        Route::resource('/orders','SaleBatchController');
        Route::post('/accept-order/{id}',['prefix'=>'orders', 'as' => 'orders.accept', 'uses' => 'SaleBatchController@accept']);
        Route::post('/accept-single-order/{id}/{item_id}',['prefix'=>'orders', 'as' => 'orders.single.accept', 'uses' => 'SaleBatchController@accept_single']);
        Route::get('/change-status/{id}/{status}',['prefix'=>'orders', 'as' => 'orders.changeStatus', 'uses' => 'SaleBatchController@changeStatus']);

        Route::resource('/offers','OfferController');
        Route::get('/change-status/{id}',['prefix'=>'offers', 'as' => 'offers.changeStatus', 'uses' => 'OfferController@changeStatus']);

        Route::group(['prefix'=>'messages', 'as'=>'messages.'], function() {
            Route::get('/',['as' => 'index', 'uses' => 'MessageController@index']);
        });

        Route::group(['prefix'=>'notifications', 'as'=>'notifications.'], function() {
            Route::get('/',['as' => 'index', 'uses' => 'NotificationController@index']);
        });

        Route::group(['prefix'=>'tickets', 'as'=>'tickets.'], function() {
            Route::get('/',['as' => 'index', 'uses' => 'BranchTicketController@index']);
            Route::get('/show/{id}',['as' => 'show', 'uses' => 'BranchTicketController@show']);
            // Route::get('/destroy/{id}',['as' => 'destroy', 'uses' => 'BranchTicketController@destroy']);
            // Route::get('/change-approval/{id}',['as' => 'changeApproval', 'uses' => 'BranchTicketController@changeApproval']);
            Route::get('/change-status/{id}/{status}',['as' => 'changeStatus', 'uses' => 'BranchTicketController@changeStatus']);

            Route::post('/store_reply',['as'=>'reply.store', 'uses'=> 'BranchTicketController@store_reply']);
        });

    });


});

// Branch Dashboard Routes --End--


// Driver Dashboard Routes --Start--

Route::get('/driver', ['uses'=> 'Driver\HomeController@index'])->middleware('driver.auth')->name('driver');
Route::group(['as'=>'driver.', 'prefix'=>'driver'], function() {

    Route::group(['namespace'=>'Driver\Auth'], function () {
        Route::get('/register',['uses' => 'RegisterController@create'])->name('create');
        Route::post('/store',['uses' => 'RegisterController@store'])->name('store');
        Route::get('/login', ['uses' => 'LoginController@login'])->name('login');
        Route::post('/do-login', ['uses' => 'LoginController@doLogin'])->name('do.login');
        Route::post('/logout', ['uses' => 'LoginController@logout'])->name('logout');
    });

    Route::get('/dashboard', ['middleware'=>'driver.auth', 'uses' => 'Driver\HomeController@index'])->name('dashboard');

    Route::group(['middleware'=>'driver.auth', 'namespace'=>'Driver'], function () {

        Route::group(['prefix'=>'products', 'as'=>'product_items.'], function() {
            Route::get('/',['as' => 'index', 'uses' => 'ProductItemController@index']);
            Route::get('/create',['as' => 'create', 'uses' => 'ProductItemController@create']);
            Route::post('/store',['as' => 'store', 'uses' => 'ProductItemController@store']);
            Route::get('/edit/{id}',['as' => 'edit', 'uses' => 'ProductItemController@edit']);
            Route::put('/update',['as' => 'update', 'uses' => 'ProductItemController@update']);
            Route::delete('/destroy/{id}',['as' => 'destroy', 'uses' => 'ProductItemController@destroy']);
            Route::get('/change-status/{id}',['as' => 'changeStatus', 'uses' => 'ProductItemController@changeStatus']);
            // Route::group(['prefix'=>'reviews', 'as'=>'reviews.'], function() {
            //     Route::get('/',['as' => 'index', 'uses' => 'CustomerReviewController@index']);
            //     Route::get('/change-status/{id}',['as' => 'changeStatus', 'uses' => 'CustomerReviewController@changeStatus']);
            // });
        });

        Route::resource('/sales','SaleController');
        Route::get('/change-status/{id}/{status}',['prefix'=>'sales', 'as' => 'sales.changeStatus', 'uses' => 'SaleController@changeStatus']);



        Route::group(['prefix'=>'deliveries', 'as'=>'deliveries.'], function() {
            Route::get('/active',['as' => 'active', 'uses' => 'DeliveryController@open_deliveries']);
            Route::get('/history',['as' => 'history', 'uses' => 'DeliveryController@closed_deliveries']);
            Route::get('/show/{id}',['as' => 'show', 'uses' => 'DeliveryController@show']);
        });
        // Route::resource('/orders','SaleBatchController');

        Route::post('/accept-order/{id}',['prefix'=>'orders', 'as' => 'orders.accept', 'uses' => 'SaleBatchController@accept']);
        Route::post('/accept-single-order/{id}/{item_id}',['prefix'=>'orders', 'as' => 'orders.single.accept', 'uses' => 'SaleBatchController@accept_single']);
        Route::get('/change-status/{id}/{status}',['prefix'=>'orders', 'as' => 'orders.changeStatus', 'uses' => 'SaleBatchController@changeStatus']);

        Route::resource('/offers','OfferController');
        Route::get('/change-status/{id}',['prefix'=>'offers', 'as' => 'offers.changeStatus', 'uses' => 'OfferController@changeStatus']);

        Route::group(['prefix'=>'messages', 'as'=>'messages.'], function() {
            Route::get('/',['as' => 'index', 'uses' => 'MessageController@index']);
        });

        Route::group(['prefix'=>'notifications', 'as'=>'notifications.'], function() {
            Route::get('/',['as' => 'index', 'uses' => 'NotificationController@index']);
        });

        Route::group(['prefix'=>'tickets', 'as'=>'tickets.'], function() {
            Route::get('/',['as' => 'index', 'uses' => 'DriverTicketController@index']);
            Route::get('/create',['as' => 'create', 'uses' => 'DriverTicketController@create']);
            Route::post('/store',['as' => 'store', 'uses' => 'DriverTicketController@store']);
            Route::get('/show/{id}',['as' => 'show', 'uses' => 'DriverTicketController@show']);
            // Route::get('/destroy/{id}',['as' => 'destroy', 'uses' => 'DriverTicketController@destroy']);
            // Route::get('/change-approval/{id}',['as' => 'changeApproval', 'uses' => 'DriverTicketController@changeApproval']);
            Route::get('/change-status/{id}/{status}',['as' => 'changeStatus', 'uses' => 'DriverTicketController@changeStatus']);

            Route::post('/store_reply',['as'=>'reply.store', 'uses'=> 'DriverTicketController@store_reply']);
        });

    });


});

// Driver Dashboard Routes --End--


// Route::group(['prefix' => 'admin', 'middleware' => 'auth', 'as' => 'admin.'], function(){


// });



Route::get('{any}', [App\Http\Controllers\HomeController::class, 'index1'])->name('index1');

//Language Translation
Route::get('index/{locale}', [App\Http\Controllers\HomeController::class, 'lang']);

#Route::get('/', [App\Http\Controllers\HomeController::class, 'root'])->name('root');

//Update User Details
Route::post('/update-profile/{id}', [App\Http\Controllers\HomeController::class, 'updateProfile'])->name('updateProfile');
Route::post('/update-password/{id}', [App\Http\Controllers\HomeController::class, 'updatePassword'])->name('updatePassword');



Route::get('/test', [App\Http\Controllers\HomeController::class, 'test'])->name('test');


