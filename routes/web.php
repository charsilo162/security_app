<?php

use App\Livewire\Auth\Login;
use App\Livewire\Auth\Register;
use App\Livewire\Auth\UnifiedSignup;
use App\Livewire\Blogs\BlogShow;
use App\Livewire\Client\Dashboard;
use App\Livewire\Client\MyRequests;
use App\Livewire\Client\RequestService;
use App\Livewire\Dashboard\ClientTable;
use App\Livewire\Dashboard\EmployeeTable;
use Illuminate\Support\Facades\Route;
use App\Livewire\Dashboard\LeaveManagement; // Admin View
use App\Livewire\Dashboard\MyLeaves;       // Employee View
use App\Livewire\Dashboard\ServiceRequestTable;
use App\Livewire\Employee\DutyRoster;

Route::get('/login', Login::class)->name('logins');
// Route::get('/register', Login::class)->name('register');
Route::get('/', function () {
    return view('welcome');
});
Route::get('/blog/{uuid}', BlogShow::class)->name('blog.show');
Route::get('/signup', UnifiedSignup::class)->name('register');
Route::get('/', fn () => view('pages.home'))->name('home');
Route::get('/services', fn () => view('pages.services'))->name('services');
Route::get('/about', fn () => view('pages.about'))->name('about');
Route::get('/blog', fn () => view('pages.blog'))->name('blog');
Route::get('/contact', fn () => view('pages.contact'))->name('contact');
Route::get('/employees', fn () => view('dashboard.employees'))->name('dashboard');
Route::get('/dashboard', fn () => view('dashboard.index'))->name('dashboard.index');
// Route::get('/dashboard/employees/{uuid}', function ($uuid)
//  {
//     return view('dashboard.employee-detail-page', ['uuid' => $uuid]);
// })->name('employees.show');


Route::get('/services/{slug}', function ($slug) {

    $service = collect(config('services_list'))
        ->firstWhere('slug', $slug);

    abort_unless($service, 404);

    return view('services.show', compact('service'));

})->name('services.show');

 




// Protected Main Group (Requires valid API Session)
Route::middleware(['sessionauth'])->group(function () {

    // ==========================================
    // 1. ADMIN ROUTES (Dashboard Management)
    // ==========================================
    Route::middleware(['admin'])->prefix('dashboard')->name('admin.')->group(function () {
        
        // --- Core Management ---
        Route::get('/', function () { return view('dashboard.index'); })->name('index');
        //Route::get('/clients', function () { return view('dashboard.index'); })->name('index');
        Route::get('/employees', EmployeeTable::class)->name('employees');
        Route::get('/clients', ClientTable::class)->name('clients');
        Route::get('/requests', ServiceRequestTable::class)->name('requests');
        
        // --- Leave Management (Your Old Route) ---
        Route::get('/leaves/manage', function () {
            return view('dashboard.leaves.admin-manage');
        })->name('leaves.manage');

        // --- Posts ---
        Route::view('/posts', 'dashboard.posts')->name('posts.index');
        
        // --- Employee Detail (View specific guard profile) ---
        
        Route::get('/employees/{uuid}', function ($uuid) {
            return view('dashboard.employee-detail-page', ['uuid' => $uuid]);
        })->name('employees.show');
    });

    // ==========================================
    // 2. CLIENT ROUTES (Corporate Hiring)
    // ==========================================
    Route::middleware(['client'])->prefix('client')->name('client.')->group(function () {
        
        Route::get('/dashboard', Dashboard::class)->name('dashboard');
        Route::get('/hire', RequestService::class)->name('request-service');
        Route::get('/my-requests', MyRequests::class)->name('my-requests');
        
    });

    // ==========================================
    // 3. EMPLOYEE ROUTES (Security Guards)
    // ==========================================
    Route::middleware(['employee'])->prefix('me')->name('employee.')->group(function () {
        
        // Duty Roster (The one we just built)
        Route::get('/roster', DutyRoster::class)->name('roster');

        // Leave Portal (Your Old Route migrated here)
        Route::get('/my-leaves', function () {
            return view('dashboard.leaves.employee-portal');
        })->name('leaves.my-history');

        Route::get('/employees/{uuid}', function ($uuid) {
            return view('dashboard.employee-detail-page', ['uuid' => $uuid]);
        })->name('employees.show');
        
    });
});
