<?php

use Illuminate\Support\Facades\Route;

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

