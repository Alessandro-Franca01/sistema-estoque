<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EntryController;
use App\Http\Controllers\PublicServantController;
use App\Http\Requests\StoreCallRequest;
use App\Http\Requests\UpdateCallRequest;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Resources Routes:
    Route::resource('categories', \App\Http\Controllers\CategoryController::class);
    Route::resource('suppliers', \App\Http\Controllers\SupplierController::class);
    Route::resource('products', \App\Http\Controllers\ProductController::class);
    Route::resource('entries', EntryController::class);
    Route::resource('public_servants', PublicServantController::class);
    Route::resource('outputs', \App\Http\Controllers\OutputController::class);
    Route::resource('inventories', \App\Http\Controllers\InventoryController::class);
    Route::resource('calls', \App\Http\Controllers\CallController::class);
});

require __DIR__.'/auth.php';
