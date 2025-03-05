<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\UnitController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\PurchaseOrderController;
use App\Http\Controllers\Admin\WarehouseController;
use App\Http\Controllers\Reports\InventoryReportController;
use App\Http\Controllers\Reports\OrderReportController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Reports\ProductReportController;
use App\Http\Controllers\Reports\TaxReportController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Spatie\Permission\Models\Permission;
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

define('PAGINATION_COUNT',11);
Route::group(['prefix' => LaravelLocalization::setLocale(), 'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']], function () {

    //Search Product in Jquery
Route::get('/products/search', [ProductController::class, 'search'])->name('products.search');



 Route::group(['prefix'=>'admin','middleware'=>'auth:admin'],function(){
 Route::get('/',[DashboardController::class,'index'])->name('admin.dashboard');
 Route::get('logout',[LoginController::class,'logout'])->name('admin.logout');





/*         start  update login admin                 */
Route::get('/admin/edit/{id}',[LoginController::class,'editlogin'])->name('admin.login.edit');
Route::post('/admin/update/{id}',[LoginController::class,'updatelogin'])->name('admin.login.update');
/*         end  update login admin                */

/// Role and permission
Route::resource('employee', 'App\Http\Controllers\Admin\EmployeeController',[ 'as' => 'admin']);
Route::get('role', 'App\Http\Controllers\Admin\RoleController@index')->name('admin.role.index');
Route::get('role/create', 'App\Http\Controllers\Admin\RoleController@create')->name('admin.role.create');
Route::get('role/{id}/edit', 'App\Http\Controllers\Admin\RoleController@edit')->name('admin.role.edit');
Route::patch('role/{id}', 'App\Http\Controllers\Admin\RoleController@update')->name('admin.role.update');
Route::post('role', 'App\Http\Controllers\Admin\RoleController@store')->name('admin.role.store');
Route::post('admin/role/delete', 'App\Http\Controllers\Admin\RoleController@delete')->name('admin.role.delete');

Route::get('/permissions/{guard_name}', function($guard_name){
    return response()->json(Permission::where('guard_name',$guard_name)->get());
});




//Reports
Route::get('/inventory_report', [InventoryReportController::class, 'index'])->name('inventory_report');
Route::get('/order_report', [OrderReportController::class, 'index'])->name('order_report');
Route::get('/product_move', [ProductReportController::class, 'index'])->name('product_move');
Route::get('/tax_report', [TaxReportController::class, 'index'])->name('tax_report');



// Resource Route

Route::resource('users', UserController::class);
Route::resource('warehouses', WarehouseController::class);
Route::resource('products', ProductController::class);
Route::resource('categories', CategoryController::class);
Route::resource('units', UnitController::class);
Route::resource('purchaseOrders', PurchaseOrderController::class);



});
});



Route::group(['namespace'=>'Admin','prefix'=>'admin','middleware'=>'guest:admin'],function(){
    Route::get('login',[LoginController::class,'show_login_view'])->name('admin.showlogin');
    Route::post('login',[LoginController::class,'login'])->name('admin.login');

});







