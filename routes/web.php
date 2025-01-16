<?php

use App\Http\Livewire\Dashboard;
use App\Http\Livewire\CreateUser;
use Illuminate\Support\Facades\Auth;
use App\Http\Livewire\UserManagement;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\ProductManagement;
use App\Http\Livewire\CategoryManagement;
use App\Http\Livewire\CreateBill;
use App\Http\Livewire\CustomerManagement;

Route::get('/',  [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm']);

Auth::routes([

    'register' => false, // Register Routes...
  
    'reset' => false, // Reset Password Routes...
  
    'verify' => false, // Email Verification Routes...
  
  ]);

//Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

 Route::get('/home', Dashboard::class);

 Route::get('/dashboard', Dashboard::class);

 Route::get('/categories', CategoryManagement::class);

 Route::get('/products', ProductManagement::class);

 Route::get('/customers', CustomerManagement::class);

 Route::get('/users', UserManagement::class);

 Route::get('/users/create', CreateUser::class);

 Route::get('/bill/create', CreateBill::class);