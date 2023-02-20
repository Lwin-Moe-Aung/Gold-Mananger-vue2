<?php

use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\Pos\HomeController;
use App\Http\Controllers\Admins\AuthController;
use App\Http\Controllers\Admins\ItemController;
use App\Http\Controllers\Admins\RoleController;
use App\Http\Controllers\Admins\SellController;
use App\Http\Controllers\Admins\UserController;
use App\Http\Controllers\Pos\ContactController;
use App\Http\Controllers\Pos\SellPosController;
use App\Http\Controllers\Admins\AdminController;
use App\Http\Controllers\Admins\AlertController;
use App\Http\Controllers\Admins\CashInController;
use App\Http\Controllers\Admins\CashOutController;
use App\Http\Controllers\Admins\ExpenseController;
use App\Http\Controllers\Admins\ProductController;
use App\Http\Controllers\Admins\CustomerController;
use App\Http\Controllers\Admins\ItemNameController;
use App\Http\Controllers\Admins\PurchaseController;
use App\Http\Controllers\Admins\SupplierController;
use App\Http\Controllers\Admins\CashInHandController;
use App\Http\Controllers\Admins\ClosingDayController;
use App\Http\Controllers\Admins\CreditInfoController;
use App\Http\Controllers\Admins\DailySetupController;
use App\Http\Controllers\Admins\ExpenseForController;
use App\Http\Controllers\Admins\OpeningDayController;
use App\Http\Controllers\Admins\PermissionController;
use App\Http\Controllers\Pos\DailySetupPosController;
use App\Http\Controllers\Admins\GoldQualityController;
use App\Http\Controllers\Admins\ProductTypeController;
use App\Http\Controllers\Admins\TransactionController;
use App\Http\Controllers\Pos\CustomerDetailController;
use App\Http\Controllers\Admins\AdminDashboardController;

use App\Http\Controllers\Admins\PurchaseReturnController;
use App\Http\Controllers\Admins\ExpenseCategoryController;
use App\Http\Controllers\Admins\LimitationPriceController;
use App\Http\Controllers\Admins\OpeningClosingDayController;
use App\Http\Controllers\Admins\DebtPaymentToSupplierController;
use App\Http\Controllers\Admins\DebtPaymentFromCustomerController;

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
    // Route::get('/pos/customer_search', [ContactController::class, 'customerSearch'])->name('pos.customer_search');
    Route::get('/pos/contact_search', [ContactController::class, 'contactSearch'])->name('pos.contact_search');
    Route::post('/pos/save_customer', [ContactController::class, 'saveCustomer'])->name('pos.save_customer');
    Route::post('/pos/save_contact', [ContactController::class, 'saveContact'])->name('pos.save_contact');

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

    Route::get('/pos/customer-lists', [CustomerDetailController::class, 'index'])->name('pos.customer-lists.index');
    Route::get('/pos/pos-get-customers-data-who-have-credits',[CustomerDetailController::class,'getCustomersDataWhoHaveCredit'])->name('pos.getCustomersDataWhoHaveCredit');
    Route::get('/pos/customer-lists/detail', [CustomerDetailController::class, 'detail'])->name('pos.customer-lists.detail');


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

Route::prefix('admin')->name('admin.')->middleware(['auth:sanctum', 'verified', 'role: |super-admin|admin|cashier'])->group(function () {
    Route::middleware(['check_closed_day', 'check_opened_day'])->group(function() {

        Route::delete('sells/delete-record/{id}', [SellController::class, 'deleteRecord'])->name('sells.deleteRecord');
        Route::resource('purchases', PurchaseController::class)->only(['create', 'edit', 'delete']);

        //user management
        Route::resource('admins', AdminController::class)->parameters(['admins' => 'user'])->only(['update']);
        Route::resource('users', UserController::class)->only(['create','edit', 'delete']);
        Route::resource('permissions', PermissionController::class)->only(['create','edit', 'delete']);
        Route::resource('roles', RoleController::class)->only(['create', 'edit', 'delete']);

        //contact management
        Route::resource('customers', CustomerController::class);
        Route::resource('suppliers', SupplierController::class);

        //product management
        Route::resource('products', ProductController::class);
        Route::post('products/storeDialog', [ProductController::class, 'storeDialog'])->name('products.storeDialog');
        Route::post('/products/product_update', [ProductController::class, 'ProductUpdate'])->name('products.product_update');
        Route::resource('gold_qualities', GoldQualityController::class);
        Route::resource('product_types', ProductTypeController::class);
        Route::post('product_types/storeDialog', [ProductTypeController::class, 'storeDialog'])->name('product_types.storeDialog');
        Route::post('item_names/storeDialog', [ItemNameController::class, 'storeDialog'])->name('item_names.storeDialog');
        Route::resource('item_names', ItemNameController::class);
        Route::resource('daily_setups', DailySetupController::class);
        Route::post('daily_setups/storeDialog', [DailySetupController::class, 'storeDialog'])->name('daily_setups.storeDialog');
        // Route::get('/sells/detail/{id}', [SellController::class, 'detail'])->name('sells.detail');
        // SellController
        Route::resource('sells', SellController::class);
        Route::post('/sells/product_form_save', [SellController::class, 'productFormSave'])->name('sells.product_form_save');
        Route::post('/sells/item_form_save', [SellController::class, 'itemFormSave'])->name('sells.item_form_save');
        Route::post('/sells/type_form_save', [SellController::class, 'typeFormSave'])->name('sells.type_form_save');
        Route::post('/sells/itemname_form_save', [SellController::class, 'itemNameFormSave'])->name('sells.itemname_form_save');
        // purchase
        Route::delete('purchases/delete-record/{id}', [PurchaseController::class, 'deleteRecord'])->name('purchases.deleteRecord');
        Route::resource('purchases', PurchaseController::class);
        Route::post('/purchases/purchase_update', [PurchaseController::class, 'purchaseUpdate'])->name('purchases.purchase_update');
        // PurchaseReturnController
        Route::delete('purchase_returns/delete-record/{id}', [PurchaseReturnController::class, 'deleteRecord'])->name('purchase_returns.deleteRecord');
        Route::resource('purchase_returns', PurchaseReturnController::class);
        //limitation Price
        Route::resource('limitation_prices', LimitationPriceController::class);
        //expense
        Route::resource('expenses', ExpenseController::class);
        Route::delete('expenses/delete-record/{id}', [ExpenseController::class, 'deleteRecord'])->name('expenses.deleteRecord');
        Route::post('/expenses/expenses_update', [ExpenseController::class, 'expensesUpdate'])->name('expenses.expenses_update');
        //expense category
        Route::resource('expense_categories', ExpenseCategoryController::class);
        Route::post('expense_categories/storeDialog', [ExpenseCategoryController::class, 'storeDialog'])->name('expense_categories.storeDialog');
        //Expense For
        Route::resource('expense-fors', ExpenseForController::class);
        Route::post('expense-fors/storeDialog', [ExpenseForController::class, 'storeDialog'])->name('expense-fors.storeDialog');
        // CashInController
        Route::resource('cash_ins', CashInController::class);
        // CashOutController
        Route::resource('cash_outs', CashOutController::class);
        // DebtPaymentFromCustomerController
        Route::resource('debt-payment-from-customers', DebtPaymentFromCustomerController::class);
        // DebtPaymentToSupplierController
        Route::resource('debt-payment-to-suppliers', DebtPaymentToSupplierController::class);
        // opening and closing day
        Route::resource('opening-closing-days', OpeningClosingDayController::class);
        // ClosingDayController
        Route::resource('closing-days', ClosingDayController::class);
        //cash in hand
        Route::resource('cash-in-hands', CashInHandController::class);
    });

    Route::middleware(['check_closed_day'])->group(function() {
        // OpeningDayController
        Route::post('opening-days/save-data', [OpeningDayController::class, 'saveData'])->name('opening-days.saveData');
        Route::resource('opening-days', OpeningDayController::class);
    });

    // dashboard
    Route::get('dashboard', [AdminDashboardController::class, 'index'])->name('dashboard.index');

    // Alert
    Route::get('require-close-day-alert', [AlertController::class, 'requireCloseDayAlert'])->name('alert.requireCloseDayAlert');
    Route::get('require-open-day-alert', [AlertController::class, 'requireOpenDayAlert'])->name('alert.requireOpenDayAlert');

    //user management
    Route::resource('admins', AdminController::class);
    Route::resource('users', UserController::class);
    Route::resource('permissions', PermissionController::class);
    Route::resource('roles', RoleController::class);

    //contact management
    Route::resource('customers', CustomerController::class);
    Route::resource('suppliers', SupplierController::class);

    //product management
    Route::resource('products', ProductController::class);
    Route::get('gold_qualities/get_list', [GoldQualityController::class, 'getList'])->name('gold_qualities.get_list');
    Route::resource('gold_qualities', GoldQualityController::class);
    Route::get('/product_sku_search', [ProductController::class, 'productSkuSearch'])->name('product_sku_search');

    Route::get('product_types/get_list', [ProductTypeController::class, 'getList'])->name('product_types.get_list');
    Route::resource('product_types', ProductTypeController::class);
    Route::get('item_names/get_list', [ItemNameController::class, 'getList'])->name('item_names.get_list');
    Route::resource('item_names', ItemNameController::class);
    Route::resource('daily_setups', DailySetupController::class);

    // Route::post('edit_daily_setup', [DailySetupController::class, 'editDailySetup'])->name('daily_setups.edit_daily_setup');
    //Sell Management
    Route::get('get-sell-data-lists', [SellController::class, 'getSellDataLists'])->name('sells.getDataLists');
    Route::get('sells/get-customer-lists', [SellController::class, 'getCustomerLists'])->name('sells.getCustomerLists');
    Route::resource('sells', SellController::class);

    //Purchase management
    Route::get('purchase-invoice/{transaction_id}', [PurchaseController::class, 'purchaseInvoice'])->name('purchases.invoice');
    Route::get('/purchases/get-supplier-lists', [PurchaseController::class, 'getSupplierLists'])->name('purchases.getSupplierLists');
    Route::get('/get-purchase-data-lists', [PurchaseController::class, 'getPurchaseDataLists'])->name('purchases.getDataLists');
    Route::resource('purchases', PurchaseController::class);

    //Purchase return
    Route::get('purchase-return-invoice/{transaction_id}', [PurchaseReturnController::class, 'purchaseReturnInvoice'])->name('purchase_returns.invoice');
    Route::get('get-purchase-return-data-lists', [PurchaseReturnController::class, 'getPurchaseReturnDataLists'])->name('purchase_returns.getDataLists');
    Route::resource('purchase_returns', PurchaseReturnController::class);

    // ItemController
    Route::get('/item_sku_search', [ItemController::class, 'searchItemSku'])->name('item_sku_search');
    Route::get('/search_by_item_sku/{item_sku}', [ItemController::class, 'searchByItemSku'])->name('search_by_item_sku');

    // TransactionController
    Route::get('/invoice_no_search', [TransactionController::class, 'invoiceNoSearch'])->name('invoice_no_search');
    Route::get('/search_by_invoice_no/{invoice_no}', [TransactionController::class, 'searchByInvoiceNo'])->name('search_by_invoice_no');

    //limitation Price
    Route::resource('limitation_prices', LimitationPriceController::class);

    //expense
    Route::resource('expenses', ExpenseController::class);

    //expense category
    Route::resource('expense_categories', ExpenseCategoryController::class);

    //Expense For
    Route::resource('expense-fors', ExpenseForController::class);

    // CashInController
    Route::resource('cash_ins', CashInController::class);
    Route::get('get-cash-in-data-lists', [CashInController::class, 'getCashInDataLists'])->name('getCashInDataLists');

    // CashOutController
    Route::resource('cash_outs', CashOutController::class);
    Route::get('get-cash-out-data-lists', [CashOutController::class, 'getCashOutDataLists'])->name('getCashOutDataLists');

    // DebtPaymentFromCustomerController
    Route::resource('debt-payment-from-customers', DebtPaymentFromCustomerController::class);
    Route::get('get-debt-payment-lists', [DebtPaymentFromCustomerController::class, 'getDebtPaymentLists'])->name('getDebtPaymentLists');
    Route::get('customer/get-credit-data-lists', [DebtPaymentFromCustomerController::class, 'getCustomerCreditDataLists'])->name('getCustomerCreditDataLists');
    Route::get('credit/get-customer-lists', [DebtPaymentFromCustomerController::class, 'getCustomerLists'])->name('getCustomerLists');

    // DebtPaymentToSupplierController
    Route::resource('debt-payment-to-suppliers', DebtPaymentToSupplierController::class);
    Route::get('supplier/get-credit-data-lists', [DebtPaymentToSupplierController::class, 'getSupplierCreditDataLists'])->name('getSupplierCreditDataLists');

    // CreditInfoController
    Route::get('credit-info-customers', [CreditInfoController::class, 'creditInfoCustomers'])->name('creditInfoCustomers');
    Route::get('get-customers-data-who-have-credits', [CreditInfoController::class, 'getCustomersDataWhoHaveCredit'])->name('getCustomersDataWhoHaveCredit');
    Route::get('credit/get-remain-credit-customer-lists', [CreditInfoController::class, 'getRemainCreditCustomerLists'])->name('getRemainCreditCustomerLists');
    Route::get('credit-info-suppliers', [CreditInfoController::class, 'creditInfoSuppliers'])->name('creditInfoSuppliers');
    Route::get('debt-payment-from-customer-with-contact-id', [CreditInfoController::class, 'createDebtPaymentFromCustomerWithContactId'])->name('createDebtPaymentFromCustomerWithContactId');
    Route::get('credit/get-remain-credit-to-supplier-lists', [CreditInfoController::class, 'getRemainCreditToSupplierLists'])->name('getRemainCreditToSupplierLists');
    Route::get('get-suppliers-data-who-have-credits', [CreditInfoController::class, 'getSuppliersDataWhoHaveCredit'])->name('getSuppliersDataWhoHaveCredit');
    Route::get('debt-payment-to-supplier-with-contact-id', [CreditInfoController::class, 'createDebtPaymentToSupplierWithContactId'])->name('createDebtPaymentToSupplierWithContactId');
    //generate invoice for debt payment customer and to supplier
    Route::get('customer-debt-payment-generate-invoice/{transaction_id}', [CreditInfoController::class, 'customerDebtPaymentGenerateInvoice'])->name('customerDebtPaymentGenerateInvoice');
    Route::get('supplier-debt-payment-generate-invoice/{transaction_id}', [CreditInfoController::class, 'supplierDebtPaymentGenerateInvoice'])->name('supplierDebtPaymentGenerateInvoice');

    // opening and closing day
    Route::get('get-opening-closing-data-lists', [OpeningClosingDayController::class, 'getOpeningClosingDataLists'])->name('getOpeningClosingDataLists');
    Route::resource('opening-closing-days', OpeningClosingDayController::class);

    // OpeningDayController
    Route::resource('opening-days', OpeningDayController::class);

    // ClosingDayController
    // Route::get('closing-days', [ClosingDayController::class, 'index'])->name('closing-days.index');
    Route::resource('closing-days', ClosingDayController::class);

    //cash in hand
    Route::resource('cash-in-hands', CashInHandController::class);
    Route::get('get-cash-in-hand-by-date', [CashInHandController::class, 'getCashInHandByDate'])->name('cash-in-hands.getCashInHandByDate');

    // cash in hand for Close Day
    Route::get('get-cash-in-hand', [CashInHandController::class, 'getCashInHandForCloseDay'])->name('cash-in-hands.getCashInHandForCloseDay');

});
