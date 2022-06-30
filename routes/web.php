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
use App\Http\Controllers\Admins\ItemNameController;
use App\Http\Controllers\Admins\DailySetupController;
use App\Http\Controllers\Admins\ProductController;
use App\Http\Controllers\Admins\SellController;
use App\Http\Controllers\Admins\PurchaseController;
use App\Http\Controllers\Admins\PurchaseReturnController;
use App\Http\Controllers\Admins\ItemController;

use App\Http\Controllers\Pos\HomeController;
use App\Http\Controllers\Pos\SellPosController;
use App\Http\Controllers\Pos\ContactController;
use App\Http\Controllers\Pos\DailySetupPosController;



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

    // Route::post('/pos/edit_daily_setup', [DailySetupValueController::class, 'editDailySetup'])->name('pos.edit_daily_setup');

    //contact
    Route::get('/pos/customer_search', [ContactController::class, 'customerSearch'])->name('pos.customer_search');
    Route::post('/pos/save_customer', [ContactController::class, 'saveCustomer'])->name('pos.save_customer');

    Route::get('/pos/search_by_item_id', [HomeController::class, 'searchByItemId'])->name('pos.search_by_item_id');
    //customer order
    Route::post('/pos/sell', [SellPosController::class, 'sell'])->name('pos.save_order');

    //generate invoice
    Route::get('/pos/generate_invoice/{id}', [SellPosController::class, 'generateInvoice'])->name('pos.generate_invoice');

    //test route
    Route::get('/pos/json_search', [SellPosController::class, 'jsonSearch'])->name('pos.json_search');
    //get gold quality
    Route::get('/pos/get_data_for_combobox', [HomeController::class, 'getDataForCombobox'])->name('pos.get_data_for_combobox');
    //Carts
    Route::get('/pos/cart', [SellPosController::class, 'cart'])->name('pos.cart');
    Route::get('/pos/print_all_from_cart', [SellPosController::class, 'printAllFromCart'])->name('pos.print_all_from_cart');

    Route::get('/pos/daily_setups', [DailySetupPosController::class, 'index'])->name('pos.daily_setups.index');
    Route::post('/pos/daily_setups/store', [DailySetupPosController::class, 'store'])->name('pos.daily_setups.store');
    Route::post('/pos/daily_setups/update', [DailySetupPosController::class, 'update'])->name('pos.daily_setups.update');
    Route::post('/pos/daily_setups/delete', [DailySetupPosController::class, 'delete'])->name('pos.daily_setups.delete');

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
    Route::resource('products', ProductController::class);
    Route::post('/products/product_update', [ProductController::class, 'ProductUpdate'])->name('products.product_update');
    Route::resource('product_types', ProductTypeController::class)->except(['create', 'show', 'edit']);
    Route::resource('item_names', ItemNameController::class);
    Route::resource('daily_setups', DailySetupController::class)->except(['create', 'show', 'edit']);
    // Route::post('edit_daily_setup', [DailySetupController::class, 'editDailySetup'])->name('daily_setups.edit_daily_setup');

    //Order Management
    Route::resource('sells', SellController::class);
    // Route::get('/sells/detail/{id}', [SellController::class, 'detail'])->name('sells.detail');
    Route::post('/sells/product_form_save', [SellController::class, 'productFormSave'])->name('sells.product_form_save');
    Route::post('/sells/item_form_save', [SellController::class, 'itemFormSave'])->name('sells.item_form_save');
    Route::post('/sells/type_form_save', [SellController::class, 'typeFormSave'])->name('sells.type_form_save');
    Route::post('/sells/itemname_form_save', [SellController::class, 'itemNameFormSave'])->name('sells.itemname_form_save');

    //Purchase management
    Route::resource('purchases', PurchaseController::class);
    Route::post('/purchases/purchase_update', [PurchaseController::class, 'purchaseUpdate'])->name('purchases.purchase_update');
    //Purchase return
    Route::resource('purchase_returns', PurchaseReturnController::class);

    Route::get('/item_sku_search', [ItemController::class, 'searchItemSku'])->name('item_sku_search');
});
