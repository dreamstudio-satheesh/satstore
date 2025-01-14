<?php

use App\Http\Livewire\Dashboard;
use App\Http\Livewire\CategoryManagement;
use Illuminate\Support\Facades\Route;

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