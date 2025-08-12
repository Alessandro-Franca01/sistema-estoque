<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EntryController;
use App\Http\Controllers\PublicServantController;
use App\Http\Controllers\OutputController;

Route::get('/', function () {
    return view('auth.login');
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
    Route::resource('outputs', OutputController::class);
    Route::resource('inventories', \App\Http\Controllers\InventoryController::class);
    Route::resource('calls', \App\Http\Controllers\CallController::class);

    // Custom Routes:
    Route::put('/output/finish/{output}', [OutputController::class, 'finish'])->name('output.finish');
});

require __DIR__.'/auth.php';
