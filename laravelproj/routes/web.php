<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('home');
});

Route::middleware(['auth:sanctum', 'verified'])->group(function () {
    Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery.index');
    Route::get('/gallery/create', [GalleryController::class, 'create'])->name('gallery.create')->middleware('auth');
    Route::post('/gallery', [GalleryController::class, 'store'])->name('gallery.store')->middleware('auth');
});

Route::middleware(['auth', 'is_admin'])->group(function () {
    // Admin Routes
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin_dashboard');
    Route::post('/funko/store', [AdminController::class, 'store'])->name('funko.store');
    Route::get('admin/gallery', [AdminController::class, 'gallery'])->name('admin.gallery');
    Route::delete('admin/gallery/{id}', [AdminController::class, 'softDelete'])->name('admin.softDelete');
    Route::post('admin/gallery/{id}/restore', [AdminController::class, 'restore'])->name('admin.restore');
    Route::delete('admin/gallery/{id}/permanent', [AdminController::class, 'permanentDelete'])->name('admin.permanentDelete');
});

