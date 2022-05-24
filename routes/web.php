<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\Admins\RoleController;
use App\Http\Controllers\Admins\UserController;
use App\Http\Controllers\Admins\AdminController;
use App\Http\Controllers\Admins\PermissionController;
use App\Http\Controllers\Admins\AdminDashboardController;
use App\Http\Controllers\Admins\AuthController;
use App\Http\Controllers\Admins\CustomerController;
use App\Http\Controllers\Admins\SupplierController;
use App\Http\Controllers\Admins\ProductTypeController;
use App\Http\Controllers\Admins\DailySetupController;
use App\Http\Controllers\Admins\ProductController;
use App\Http\Controllers\Admins\OrderController;
use App\Http\Controllers\Pos\HomeController;
use App\Http\Controllers\Pos\CustomerOrderController;
use App\Http\Controllers\Pos\DailySetupValueController;


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
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});
//pos
Route::middleware(['auth:sanctum', 'verified', 'role: |super-admin|admin|cashier'])->group(function () {
    Route::get('/pos', [HomeController::class, 'index'])->name('pos.index');
    Route::get('/pos/poduct-list', [HomeController::class, 'productList'])->name('pos.product.lists');
    Route::post('/pos/search', [HomeController::class, 'search'])->name('pos.search');
    //product sku search
    Route::get('/pos/productsku_search/{sku}', [HomeController::class, 'productSkuSearch'])->name('pos.productsku_search');

    Route::post('/pos/edit_daily_setup', [DailySetupValueController::class, 'editDailySetup'])->name('pos.edit_daily_setup');

    //customer order
    Route::post('/pos/save_order', [CustomerOrderController::class, 'saveOrder'])->name('pos.save_order');

    //generate invoice
    Route::get('/pos/generate_invoice/{id}', [CustomerOrderController::class, 'generateInvoice'])->name('pos.generate_invoice');

    Route::get('/pos/json_search', [CustomerOrderController::class, 'jsonSearch'])->name('pos.json_search');
    //get gold quality
    Route::get('/pos/get_gold_qualitys', [HomeController::class, 'getGoldQualitys'])->name('pos.get_gold_qualitys');
    //get type and name for pos voucher1
    Route::get('/pos/get_types_and_names', [HomeController::class, 'getTypesAndNames'])->name('pos.get_types_and_names');



});



//login
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'postLogin'])->name('post.login');
Route::post('/logout', [AuthController::class, 'logout'])->name('post.logout');

## register
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'postRegister'])->name('post.register');

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->name('dashboard');


//dashboard
Route::prefix('admin')->name('admin.')->middleware(['auth:sanctum', 'verified', 'role: |super-admin|admin|cashier'])->group(function () {
    Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('dashboard.index');
});

Route::prefix('admin')->name('admin.')->middleware(['auth:sanctum', 'verified', 'role: |super-admin|admin|cashier'])->group(function () {
    //user management
    Route::resource('admins', AdminController::class)->parameters(['admins' => 'user'])->only(['index', 'update']);
    Route::resource('users', UserController::class)->except(['create', 'show', 'edit']);
    Route::resource('permissions', PermissionController::class)->except(['create', 'show', 'edit']);
    Route::resource('roles', RoleController::class)->except(['create', 'show', 'edit']);

    //contact management
    Route::resource('customers', CustomerController::class)->except(['create', 'show', 'edit']);
    Route::resource('suppliers', SupplierController::class)->except(['create', 'show', 'edit']);

    //product management
    Route::resource('products', ProductController::class)->except(['create', 'show', 'edit']);
    Route::resource('product_types', ProductTypeController::class)->except(['create', 'show', 'edit']);
    Route::resource('daily_setups', DailySetupController::class)->except(['create', 'show', 'edit']);
    Route::post('edit_daily_setup', [DailySetupController::class, 'editDailySetup'])->name('daily_setups.edit_daily_setup');

    //Order Management
    Route::resource('orders', OrderController::class)->except(['create', 'show', 'edit']);
    Route::get('/orders/detail/{id}', [OrderController::class, 'detail'])->name('orders.detail');
    Route::post('/orders/product_form_save', [OrderController::class, 'productFormSave'])->name('orders.product_form_save');
    Route::post('/orders/item_form_save', [OrderController::class, 'itemFormSave'])->name('orders.item_form_save');
    Route::post('/orders/type_form_save', [OrderController::class, 'typeFormSave'])->name('orders.type_form_save');
    Route::post('/orders/itemname_form_save', [OrderController::class, 'itemNameFormSave'])->name('orders.itemname_form_save');





});
