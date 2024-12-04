<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GalleryController;

Route::get('/', function () {
    return view('home');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'isUser:user' // Ensure this checks the 'user' role
])->group(function () {
    Route::get('user/dashboard', function () {
        return view('userdashboard');
    })->name('userdashboard');
    Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery.index');
    Route::get('/gallery/create', [GalleryController::class, 'create'])->name('gallery.create')->middleware('auth');
    Route::post('/gallery', [GalleryController::class, 'store'])->name('gallery.store')->middleware('auth');
});






// Admin Routes
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'isAdmin:admin'
        // 'role:admin'
])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admindashboard');
    })->name('admin.dashboard');

    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');



});