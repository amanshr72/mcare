<?php

use App\Http\Controllers\CustomAuthController;
use App\Http\Controllers\StockOutController;
use App\Http\Controllers\StockReceiptApiController;
use App\Http\Controllers\UserController;
use App\Livewire\Counter;
use App\Livewire\StockOut;
use App\Livewire\StockReceipt;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

/* Auth Routes */
Route::get('/', [CustomAuthController::class, 'showLoginForm'])->name('login');
Route::post('/', [CustomAuthController::class, 'login']);
Route::get('register', [CustomAuthController::class, 'showRegistrationForm'])->name('register');
Route::post('register', [CustomAuthController::class, 'register']);
Route::get('logout', [CustomAuthController::class, 'logout'])->name('logout');


Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () { return view('dashboard'); })->name('dashboard');
    
    /* Stock Receipt */
    Route::resource('stock-receipt', StockReceiptApiController::class);
    Route::get('getItemDetailsByName/{itemName}', [StockReceiptApiController::class, 'getItemDetails'])->name('stockReceipt.getDeatils');
    Route::get('stock-receipt-filter', [StockReceiptApiController::class, 'filter'])->name('stockReceiptFilter');
    Route::get('stock-receipt-search', [StockReceiptApiController::class, 'search'])->name('stockReceiptSearch');
    
    Route::get('push-all-stock', [StockReceiptApiController::class, 'pushAllStock'])->name('push.allStock');
    Route::get('push-stock-receipt', [StockReceiptApiController::class, 'pushStockList'])->name('view.pushList');
    Route::get('push-stock-form/{id}', [StockReceiptApiController::class, 'pushStockEditForm'])->name('edit.pushForm');
    Route::put('update-push-stock-receipt', [StockReceiptApiController::class, 'pushStockUpdate'])->name('push.update');
    
    /* Stock Out */
    Route::resource('stock-out', StockOutController::class);;
    Route::get('getItemDetails/{itemName}', [StockOutController::class, 'getItemDetails'])->name('stockOut.getDeatils');
    Route::get('stock-out-filter', [StockOutController::class, 'filter'])->name('stockOutFilter');
    Route::get('stock-out-search', [StockOutController::class, 'search'])->name('stockOutSearch');

    /* User Management */
    Route::resource('user', UserController::class);

});


