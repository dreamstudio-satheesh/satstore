<?php

use App\Http\Livewire\Dashboard;
use Illuminate\Support\Facades\Route;
use App\Http\Livewire\ProductManagement;
use App\Http\Livewire\CategoryManagement;

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