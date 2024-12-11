<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FunkoController; // This line is important


Route::get('/', function () {
    return view('home');
});

// User Routes
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'isUser:user' // Ensure this checks the 'user' role
])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/gallery', [GalleryController::class, 'index'])->name('gallery.index');
    Route::get('/gallery/create', [GalleryController::class, 'create'])->name('gallery.create')->middleware('auth');
    Route::post('/gallery', [GalleryController::class, 'store'])->name('gallery.store')->middleware('auth');
});

// Admin Routes
Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'isAdmin:admin' // Check if the user has 'admin' role
])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('admindashboard');
    })->name('admin.dashboard');
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin_dashboard');
    Route::post('/funko/store', [AdminController::class, 'store'])->name('funko.store');
    Route::get('admin/gallery', [AdminController::class, 'gallery'])->name('admin.gallery');
    Route::delete('admin/gallery/{id}', [AdminController::class, 'softDelete'])->name('admin.softDelete');
    Route::post('admin/gallery/{id}/restore', [AdminController::class, 'restore'])->name('admin.restore');
    Route::delete('admin/gallery/{id}/permanent', [AdminController::class, 'permanentDelete'])->name('admin.permanentDelete');

    Route::post('/admin/funko/{id}/toggle-sold-out', [AdminController::class, 'toggleSoldOut'])->name('admin.toggleSoldOut');

    Route::get('/admin/funko/{id}/edit', [AdminController::class, 'edit'])->name('funko.edit');
    Route::put('/admin/funko/{id}', [AdminController::class, 'update'])->name('funko.update');

     // Soft delete a Funko
     Route::delete('/admin/funko/{id}/soft-delete', [FunkoController::class, 'softDelete'])->name('admin.softDeleteFunko');

     // Restore a soft-deleted Funko
     Route::post('/admin/funko/{id}/restore', [FunkoController::class, 'restore'])->name('admin.restoreFunko');
     
 
     // Permanently delete a Funko
     Route::delete('/admin/funko/{id}/permanently-delete', [FunkoController::class, 'permanentlyDelete'])->name('admin.permanentlyDelete');
     

});
