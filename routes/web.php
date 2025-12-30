<?php

use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use Illuminate\Support\Facades\Route;
use App\Livewire\Dashboard\LeaveManagement; // Admin View
use App\Livewire\Dashboard\MyLeaves;       // Employee View

Route::get('/login', Login::class)->name('logins');
// Route::get('/register', Login::class)->name('register');
Route::get('/register', Register::class)->name('signups');
Route::get('/', function () {
    return view('welcome');
});

Route::get('/', fn () => view('pages.home'))->name('home');
Route::get('/services', fn () => view('pages.services'))->name('services');
Route::get('/about', fn () => view('pages.about'))->name('about');
Route::get('/blog', fn () => view('pages.blog'))->name('blog');
Route::get('/contact', fn () => view('pages.contact'))->name('contact');
Route::get('/employees', fn () => view('dashboard.employees'))->name('dashboard');
Route::get('/dashboard', fn () => view('dashboard.index'))->name('dashboard.index');

Route::middleware(['sessionauth'])->prefix('dashboard')->group(function () {
    
  

    // --- Employee Leave Portal ---
    // URL: /dashboard/my-leaves
    Route::get('/my-leaves', function () {
        return view('dashboard.leaves.employee-portal');
    })->name('leaves.my-history');

    // --- Employee Detail (Your existing route) ---
    Route::get('/employees/{uuid}', function ($uuid) {
        return view('dashboard.employee-detail-page', ['uuid' => $uuid]);
    })->name('employees.show');
});



Route::get('/dashboard/employees/{uuid}', function ($uuid) {
    return view('dashboard.employee-detail-page', ['uuid' => $uuid]);
})->name('employees.show');
Route::middleware(['sessionauth', 'admin'])->prefix('dashboard') ->name('dashboard.')
    ->group(function () {
        Route::view('/posts', 'dashboard.posts')->name('posts.index');


   
    });
Route::middleware(['sessionauth', 'admin'])->prefix('dashboard') ->name('admin.')
    ->group(function () {
    Route::get('/leaves/manage', function () {
        return view('dashboard.leaves.admin-manage');
    })->name('leaves.manage');
   });

