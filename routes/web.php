<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EntryController;
use App\Http\Controllers\PublicServantController;
use App\Http\Controllers\OutputController;
use App\Http\Controllers\ProductController;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->middleware('role:administrativo')->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');


    // Resources Routes:
    Route::resource('categories', \App\Http\Controllers\CategoryController::class);
    // Alternar ativação/desativação de categoria
    Route::patch('categories/{category}/toggle-status', [\App\Http\Controllers\CategoryController::class, 'toggleStatus'])
        ->name('categories.toggle-status');
    Route::resource('suppliers', \App\Http\Controllers\SupplierController::class);
    Route::resource('products', \App\Http\Controllers\ProductController::class);
    Route::resource('entries', EntryController::class);
    Route::resource('public_servants', PublicServantController::class);
    Route::resource('outputs', OutputController::class);
    Route::resource('inventories', \App\Http\Controllers\InventoryController::class);
    Route::resource('calls', \App\Http\Controllers\CallController::class);

    // Rotas exclusivas do administrativo
    Route::group(['middleware' => 'role:administrativo'], function () {
        Route::get('/user/create', [\App\Http\Controllers\UserController::class, 'create'])->name('users.create');
        Route::post('/user/store', [\App\Http\Controllers\UserController::class, 'store'])->name('users.store');
    });

    // Rotas exclusivas do almoxarife
    Route::group(['middleware' => 'role:almoxarife'], function () {
        Route::put('/output/finish/{output}', [OutputController::class, 'finish'])->name('output.finish');
        Route::get('/user', [\App\Http\Controllers\UserController::class, 'index'])->name('users.index');
    });

    // Rotas acessíveis por ambos os perfis (almoxarife, administrativo)
    Route::group(['middleware' => 'role:almoxarife,administrativo'], function () {
        // Produtos (leitura para ambos)
        Route::get('/products', [ProductController::class, 'index'])->name('products.index');
        Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
    });
});

require __DIR__.'/auth.php';

