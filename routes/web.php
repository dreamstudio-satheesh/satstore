<?php

use App\Http\Livewire\Dashboard;
use App\Http\Livewire\SalesList;
use App\Http\Livewire\CreateUser;
use Illuminate\Support\Facades\Auth;
use App\Http\Livewire\UserManagement;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\BillController;
use App\Http\Controllers\SaleController;
use App\Http\Livewire\ProductManagement;
use App\Http\Livewire\CategoryManagement;
use App\Http\Livewire\CustomerManagement;
use App\Http\Livewire\Reports\SalesReport;
use App\Http\Controllers\CustomerController;

Route::get('/',  [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm']);

Auth::routes([

    'register' => false, // Register Routes...
  
    'reset' => false, // Reset Password Routes...
  
    'verify' => false, // Email Verification Routes...
  
  ]);

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/api/customers/search', [CustomerController::class, 'search'])->name('customers.search');
Route::post('/api/customers', [CustomerController::class, 'store'])->name('customers.store');

// AJAX route for product searching
Route::get('/api/products/search', [BillController::class, 'searchProducts'])->name('products.search');

// Store final bill in DB
Route::post('bills', [BillController::class, 'store'])->name('bills.store');



Route::get('/billing', [SaleController::class, 'bill'])->name('sale.bill');

Route::get('/invoice/{billId}', [BillController::class, 'showInvoice'])->name('invoice.show');




 Route::get('/report/sales', SalesReport::class)->name('report.sales');


 Route::get('/home', Dashboard::class);

 Route::get('/dashboard', Dashboard::class);

 Route::get('/categories', CategoryManagement::class);

 Route::get('/products', ProductManagement::class);

 Route::get('/customers', CustomerManagement::class);

 Route::get('/users', UserManagement::class);

 Route::get('/users/create', CreateUser::class);

 Route::get('/saleslist', SalesList::class);
