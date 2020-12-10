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
	return redirect()->route('admin.home');
});

Auth::routes();

/**
 * Redirect after auth of user
 */
Route::get('/home', 'Frontend\HomeController@index')->name('home');


/**
 * Admin Section Routes
 */
Route::group(['prefix' => 'admin'], function(){
	/**
	 * Admin authentication routes
	*/
	Route::get('/login', 'Auth\Admin\LoginController@showLoginForm')->name('admin.login');
	Route::post('/login', 'Auth\Admin\LoginController@login')->name('admin.login.submit');
	Route::post('/logout', 'Auth\Admin\LoginController@logout')->name('admin.logout');

	Route::post('password/email', 'Auth\Admin\ForgotPasswordController@sendResetLinkEmail')->name('admin.password.email');
	Route::get('password/reset', 'Auth\Admin\ForgotPasswordController@showLinkRequestForm')->name('admin.password.request');

	Route::post('password/reset','Auth\Admin\ResetPasswordController@reset')->name('admin.password.reset_now');
	Route::get('password/reset/{token}', 'Auth\Admin\ResetPasswordController@showResetForm')->name('admin.password.reset');

	Route::get('/change-password', 'Backend\HomeController@chnagePasswordForm')->name('admin.password.form');
  	Route::post('/change-password', 'Backend\HomeController@chnagePassword')->name('admin.password.change');

	/**
	 * Admin Dashboard
	*/
	Route::get('/', 'Backend\HomeController@index')->name('admin.home');
	Route::get('/chart', 'Backend\HomeController@chart')->name('admin.chart');
	Route::get('/form', 'Backend\HomeController@form')->name('admin.form');
	Route::get('/table', 'Backend\HomeController@table')->name('admin.table');
	
	/**
	 * Admin routes
	*/
	Route::group(['prefix' => 'myAdmin'], function(){
		Route::get('/', 'Backend\AdminController@index')->name('admin.myadmin.index');
		Route::get('/add', 'Backend\AdminController@create')->name('admin.myadmin.add');
		Route::post('/add', 'Backend\AdminController@store')->name('admin.myadmin.store');
		Route::get('/edit/{id}', 'Backend\AdminController@edit')->name('admin.myadmin.edit');
		Route::post('/edit/{slug}', 'Backend\AdminController@update')->name('admin.myadmin.update');
		Route::get('/delete/{slug}', 'Backend\AdminController@delete')->name('admin.myadmin.delete');
	});


	/**
	 * Setting routes
	*/
	Route::group(['prefix' => 'setting'], function(){
		Route::get('/', 'Backend\SettingController@index')->name('admin.setting.index');
		Route::post('/', 'Backend\SettingController@store')->name('admin.setting.store');
	});

	/**
	 * Menu routes
	*/
	Route::group(['prefix' => 'menu'], function(){
		Route::get('/', 'Backend\MenuController@index')->name('admin.menu.index');
		Route::get('/add', 'Backend\MenuController@create')->name('admin.menu.create');
		Route::post('/add', 'Backend\MenuController@store')->name('admin.menu.store');
		Route::get('/edit/{id}', 'Backend\MenuController@edit')->name('admin.menu.edit');
		Route::post('/edit/{id}', 'Backend\MenuController@update')->name('admin.menu.update');
		Route::get('/delete/{id}', 'Backend\MenuController@delete')->name('admin.menu.delete');
        
        Route::get('/sort', 'Backend\MenuController@sort')->name('admin.menu.sort');
        Route::post('/sort', 'Backend\MenuController@sort_update')->name('admin.menu.sort_update');
	});


    /**
     * Language
    **/
    Route::get('/language', 'Backend\LanguageController@language')->name('admin.language.index');
    Route::post('/language/insert', 'Backend\LanguageController@insert')->name('admin.language.insert');
    Route::post('/language/create', 'Backend\LanguageController@create')->name('admin.language.create');


    /**
     * Root
    **/
    Route::get('/root', 'Backend\RootController@index')->name('admin.root.index');
    Route::post('/root/create', 'Backend\RootController@create')->name('admin.root.create');

    /**
     * Checking
    **/
    Route::get('/checking', 'Backend\CheckingController@index')->name('admin.checking.index');
    Route::get('/checking/add', 'Backend\CheckingController@add')->name('admin.checking.add');
    Route::get('/checking/edit', 'Backend\CheckingController@edit')->name('admin.checking.edit');
    Route::get('/checking/view', 'Backend\CheckingController@view')->name('admin.checking.view');
    Route::get('/checking/model', 'Backend\CheckingController@model')->name('admin.checking.model');


	/**
	* Cost
	**/
	Route::group(['prefix' => 'cost'], function(){
		Route::get('/', 'Backend\CostController@index')->name('admin.cost.index');
    	Route::post('/', 'Backend\CostController@index')->name('admin.cost.searchPending');
		Route::get('/add', 'Backend\CostController@add')->name('admin.cost.add');
		Route::post('/add', 'Backend\CostController@store')->name('admin.cost.store');
		Route::get('/edit/{id}', 'Backend\CostController@edit')->name('admin.cost.edit');
		Route::post('/edit/{id}', 'Backend\CostController@update')->name('admin.cost.update');
		Route::get('/delete/{id}', 'Backend\CostController@delete')->name('admin.cost.delete');
	});


    /**
    * Cost_field
    **/
    Route::group(['prefix' => 'cost_field'], function(){
        Route::get('/', 'Backend\Cost_fieldController@index')->name('admin.cost_field.index');
        Route::post('/add', 'Backend\Cost_fieldController@store')->name('admin.cost_field.store');
        Route::post('/edit/{id}', 'Backend\Cost_fieldController@update')->name('admin.cost_field.update');
        Route::get('/delete/{id}', 'Backend\Cost_fieldController@delete')->name('admin.cost_field.delete');
    });


    /*Balance Sheet*/
    Route::group(['prefix' => 'balance_sheet'], function(){
        Route::get('/','Backend\BalanceSheetController@index')->name('admin.balance_sheet.index');
        Route::post('/','Backend\BalanceSheetController@index')->name('admin.balance_sheet.index');

        //closing 
        Route::get('/closing/{balance}', 'Backend\BalanceSheetController@closing')->name("admin.balance_sheet.closing");
    });


	/**
	 * Role routes
	*/
	Route::group(['prefix' => 'role'], function(){
		Route::get('/', 'Backend\RoleController@index')->name('admin.role.index');
		Route::get('/assign/{role}', 'Backend\RoleController@create')->name('admin.role.assign');
        Route::get('/assign/{role}/{admin_id}', 'Backend\RoleController@userCreate')->name('admin.role.user_assign');
		Route::post('/assign', 'Backend\RoleController@store')->name('admin.role.store');
	});


	// Admin Access Information
	Route::get('/log', 'Backend\AdminAccessInfoController@index')->name('admin.log.index');
	
	
	/**
	 * Unit routes
	*/
	Route::group(['prefix' => 'unit'], function(){
		Route::get('/', 'Backend\UnitController@index')->name('admin.unit.index');
		Route::get('/view/{id}', 'Backend\UnitController@show')->name('admin.unit.show');
		Route::post('/add', 'Backend\UnitController@store')->name('admin.unit.store');
		Route::post('/edit/{id}', 'Backend\UnitController@update')->name('admin.unit.update');
		Route::get('/delete/{id}', 'Backend\UnitController@delete')->name('admin.unit.delete');
	});
	
	
	/**
	 * Category routes
	*/
	Route::group(['prefix' => 'category'], function(){
		Route::get('/', 'Backend\CategoryController@index')->name('admin.category.index');
		Route::get('/add', 'Backend\CategoryController@create')->name('admin.category.create');
		Route::post('/add', 'Backend\CategoryController@store')->name('admin.category.store');
		Route::get('/edit/{slug}', 'Backend\CategoryController@edit')->name('admin.category.edit');
		Route::post('/edit/{slug}', 'Backend\CategoryController@update')->name('admin.category.update');
		Route::get('/delete/{slug}', 'Backend\CategoryController@delete')->name('admin.category.delete');
	});


    /**
     * SubCategory Routes
     */
    Route::group(['prefix'=>'subcategory'], function () {
    	Route::get('/', 'Backend\SubcategoryController@index')->name('admin.subcategory.index');
    	Route::get('/add', 'Backend\SubcategoryController@create')->name('admin.subcategory.create');
    	Route::post('/add', 'Backend\SubcategoryController@store')->name('admin.subcategory.store');
    	Route::get('/edit/{slug}', 'Backend\SubcategoryController@edit')->name('admin.subcategory.edit');
    	Route::post('/edit/{slug}', 'Backend\SubcategoryController@update')->name('admin.subcategory.update');
    	Route::get('/delete/{slug}', 'Backend\SubcategoryController@delete')->name('admin.subcategory.delete');
    });


    /**
     * Brand routes
     */
    Route::group(['prefix' => 'brand'], function(){
    	Route::get('/', 'Backend\BrandController@index')->name('admin.brand.index');
    	Route::get('/add', 'Backend\BrandController@create')->name('admin.brand.create');
    	Route::post('/add', 'Backend\BrandController@store')->name('admin.brand.store');
    	Route::get('/edit/{slug}', 'Backend\BrandController@edit')->name('admin.brand.edit');
    	Route::post('/edit/{slug}', 'Backend\BrandController@update')->name('admin.brand.update');
    	Route::get('/delete/{slug}', 'Backend\BrandController@delete')->name('admin.brand.delete');
    });


    /**
     * Product routes
     */
    Route::group(['prefix' => 'product'], function(){
    	Route::get('/', 'Backend\ProductController@index')->name('admin.product.index');
    	Route::post('/', 'Backend\ProductController@index')->name('admin.product.index');
    	Route::get('/view/{slug}', 'Backend\ProductController@view')->name('admin.product.view');
    	Route::get('/add', 'Backend\ProductController@create')->name('admin.product.create');
    	Route::post('/add', 'Backend\ProductController@store')->name('admin.product.store');
    	Route::get('/edit/{id}', 'Backend\ProductController@edit')->name('admin.product.edit');
    	Route::post('/edit/{id}', 'Backend\ProductController@update')->name('admin.product.update');
    	Route::get('/delete/{id}', 'Backend\ProductController@delete')->name('admin.product.delete');
    });


    /**
     * Sale routes
     */
    Route::group(['prefix' => 'sale'], function(){

    	Route::get('/', 'Backend\SaleController@index')->name('admin.sale.index');
    	Route::get('/view/{id}', 'Backend\SaleController@view')->name('admin.sale.view');
    	Route::get('/add', 'Backend\SaleController@create')->name('admin.sale.add');
    	Route::post('/add', 'Backend\SaleController@store')->name('admin.sale.store');
    	Route::get('/edit/{id}', 'Backend\SaleController@edit')->name('admin.sale.edit');
    	Route::post('/edit/{id}', 'Backend\SaleController@update')->name('admin.sale.update');
    	Route::get('/delete/{id}', 'Backend\SaleController@delete')->name('admin.sale.delete');
    	Route::post('/add-to-sale', 'Backend\SaleController@addToSale');
    	Route::get('/bill', 'Backend\SaleController@bill')->name('admin.sale.bill');
        Route::get('/custom/bill/{id?}', 'Backend\SaleController@CastomBill')->name('admin.sale.custom.bill');

        /**
        *   Route for Due
        */

        Route::get('/due/delete/{id}','Backend\SaleController@delete')->name("admin.sale.delete");
        Route::get('/due/view/{id}', 'Backend\SaleController@view')->name('admin.sale.due.view');
        /**
         * Cart Route
         */
        Route::get('/all-cart-item/{table_no?}', 'Backend\SaleController@getCartItem');
        Route::get('/tables', 'Backend\SaleController@getTable');
        Route::post('/update_cart_qty/{table_no?}', 'Backend\SaleController@updateCart');
        Route::post('/update_cart_price', 'Backend\SaleController@updateCartPrice');
        Route::post('/delete-from-cart/{table_no?}', 'Backend\SaleController@deleteFromCart');
        Route::get('/allItemDelete', 'Backend\SaleController@allItemDelete')->name('admin.sale.allItemDelete');
        Route::post('/add-to-sale-product/', 'Backend\AddToSaleController@index');
        Route::post('/update-sale-product/{table_no?}', 'Backend\AddToSaleController@SaleUpdate');
        Route::post('/update-to-sale-product/', 'Backend\AddToSaleController@update_to_sale_product');
        Route::get('/get_single_sale/{id}', 'Backend\AddToSaleController@get_single_sale');
        Route::post('/delete_from_sale/', 'Backend\AddToSaleController@delete_from_sale');

        /*
        * Customer Table
        */
        Route::group(['prefix'=>'table'], function(){
            Route::get('/', 'Backend\TableController@index')->name("admin.sale.table");
            Route::post('/add', 'Backend\TableController@store')->name("admin.sale.table.add");
            Route::get('/delete/{id}', 'Backend\TableController@delete')->name("admin.sale.table.delete");
            Route::post('/edit/{id}', 'Backend\TableController@edit')->name("admin.sale.table.edit");

        });
    });

    /**
    *   Route for Due
    */
    Route::prefix('due')->group(function(){

        Route::get('/list','Backend\DueController@due')->name("admin.sale.due");
        Route::post('/list','Backend\DueController@due')->name("admin.sale.due");

        Route::get('/transaction/collect/{id}', 'Backend\DueController@due_collect')->name('admin.due.transaction.collect');

        Route::get('/collect/{id}', 'Backend\DueController@due_collect')->name('admin.sale.due.collect');
        Route::post('/collect/{id?}', 'Backend\DueController@due_collect_store')->name('admin.sale.due.collect.store');

        Route::get('/transaction', 'Backend\DueController@Transaction')->name('admin.due.transaction');

    });


    /**
     * Backup
    */
    Route::group(['prefix' => 'backup'], function(){
    	Route::get('/', 'Backend\BackupController@index')->name('admin.backup.index');
        Route::post('/', 'Backend\BackupController@index')->name('admin.backup.index');
    	Route::get('/new', 'Backend\BackupController@newBackup')->name('admin.backup.new');
        Route::post('/restore', 'Backend\BackupController@restoreBackup')->name('admin.backup.restore');
    	Route::get('/delete/{file}', 'Backend\BackupController@deleteBakup')->name('admin.backup.delete');
    });
    

    /**
    * SMS Routes
    **/
    Route::group(['prefix' => 'sms'], function(){
        Route::get('/send', 'Backend\SMSController@sendSMS')->name('admin.sms.send');
        Route::post('/send', 'Backend\SMSController@sendSMS')->name('admin.sms.get_user');
        Route::post('/submit-send-sms', 'Backend\SMSController@submitSendSMS')->name('admin.sms.submit_send_sms');
        Route::get('/custom', 'Backend\SMSController@customSMS')->name('admin.sms.custom');
        Route::post('/custom', 'Backend\SMSController@customSMS')->name('admin.sms.submit_custom_sms');
        Route::get('/report', 'Backend\SMSController@smsReport')->name('admin.sms.report');
    });
    

    /**
    * PurchaseItem
    **/
    Route::group(['prefix' => 'purchase'], function(){
        Route::group(['prefix' => 'purchase_item'], function(){
            Route::get('/', 'Backend\PurchaseItemController@item_index')->name('admin.purchase_item.index');
            Route::get('/add', 'Backend\PurchaseItemController@item_add')->name('admin.purchase_item.add');
            Route::post('/add', 'Backend\PurchaseItemController@item_store')->name('admin.purchase_item.store');
            Route::get('/edit/{id}', 'Backend\PurchaseItemController@item_edit')->name('admin.purchase_item.edit');
            Route::post('/edit/{id}', 'Backend\PurchaseItemController@item_update')->name('admin.purchase_item.update');
            Route::get('/delete/{id}', 'Backend\PurchaseItemController@item_delete')->name('admin.purchase_item.delete');

            Route::group(['prefix' => 'row_material_category'], function(){
                Route::get('/', 'Backend\PurchaseItemController@raw_material_category_add')->name('admin.purchase_item.category');
                Route::post('/add', 'Backend\PurchaseItemController@raw_material_category_store')->name('admin.purchase_item.category.add');
                Route::get('/delete/{id}', 'Backend\PurchaseItemController@raw_material_category_delete')->name('admin.purchase_item.category.delete');
            });
        });

        Route::get('/', 'Backend\PurchaseItemController@index')->name('admin.purchase.index');
        Route::post('/', 'Backend\PurchaseItemController@index')->name('admin.purchase.index');
        Route::get('/add', 'Backend\PurchaseItemController@add')->name('admin.purchase.add');
        Route::post('/add', 'Backend\PurchaseItemController@store')->name('admin.purchase.store');
        Route::get('/edit/{id}', 'Backend\PurchaseItemController@edit')->name('admin.purchase.edit');
        Route::post('/edit/{id}', 'Backend\PurchaseItemController@update')->name('admin.purchase.update');
        Route::get('/delete/{id}', 'Backend\PurchaseItemController@delete')->name('admin.purchase.delete');
    });


    /**
    * Employee
    **/
    Route::group(['prefix' => 'employee'], function(){
        Route::get('/', 'Backend\EmployeeController@index')->name('admin.employee.index');
        Route::get('/add', 'Backend\EmployeeController@add')->name('admin.employee.add');
        Route::post('/add', 'Backend\EmployeeController@store')->name('admin.employee.store');
        Route::get('/edit/{id}', 'Backend\EmployeeController@edit')->name('admin.employee.edit');
        Route::post('/edit/{id}', 'Backend\EmployeeController@update')->name('admin.employee.update');
        Route::get('/delete/{id}', 'Backend\EmployeeController@delete')->name('admin.employee.delete');
        Route::get('/view/{id}', 'Backend\EmployeeController@view')->name('admin.employee.view');
    });


    /**
    * Report
    **/
    Route::group(['prefix' => 'report'], function(){
        Route::get('/', 'Backend\ReportController@index')->name('admin.report.index');
        Route::get('/sales', 'Backend\ReportController@sales')->name('admin.report.sales');
        Route::post('/sales', 'Backend\ReportController@sales')->name('admin.report.sales');
        Route::get('/purchase', 'Backend\ReportController@purchase')->name('admin.report.purchase');
        Route::post('/purchase', 'Backend\ReportController@purchase')->name('admin.report.purchase');
        Route::get('/cost', 'Backend\ReportController@cost')->name('admin.report.cost');
        Route::post('/cost', 'Backend\ReportController@cost')->name('admin.report.cost');
    });





});

/*Route::get('/make-controller', function (Request $request) {
	Artisan::call('make:controller', [
        'name' => $request::get('root').'/'.$request::get('url').'Controller'
    ]);
    session()->flash('add_message','Done');
    return redirect()->back();
});*/


Route::get('language/{locale}', function ($lang) {
    Session::put('locale', $lang);
    return redirect()->back();
})->name('language');
