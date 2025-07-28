<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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
});

Route::resource('categories', \App\Http\Controllers\CategoryController::class);
Route::resource('products', \App\Http\Controllers\ProductController::class);
Route::get('products/{product}/entries', [\App\Http\Controllers\ProductController::class, 'entries'])->name('products.entries');
Route::resource('suppliers', \App\Http\Controllers\SupplierController::class);
Route::resource('product_entries', \App\Http\Controllers\ProductEntryController::class);
Route::resource('measurement-types', App\Http\Controllers\MeasurementTypeController::class);

# Rotas para Validação e Analise
Route::get('/product_outputs/create', function () {
    return view('product_outputs.create');
})->middleware(['auth', 'verified'])->name('product_outputs.create');

Route::get('/product_writeoffs/create', function () {
    return view('product_writeoffs.create');
})->middleware(['auth', 'verified'])->name('product_writeoffs.create');

require __DIR__.'/auth.php';
