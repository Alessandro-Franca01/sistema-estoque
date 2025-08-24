<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EntryController;
use App\Http\Controllers\PublicServantController;
use App\Http\Controllers\OutputController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// TODO: Assinar esses rotas depois quando for implementar o cadastro de usuarios por email
Route::get('/user/create', [\App\Http\Controllers\UserController::class, 'create'])->name('users.create');
Route::post('/user/store', [\App\Http\Controllers\UserController::class, 'store'])->name('users.store');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->middleware('role:administrativo')->name('profile.update');
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

    // Rotas exclusivas do administrativo
    Route::group(['middleware' => 'role:administrativo'], function () {
        Route::patch('categories/{category}/toggle-status', [\App\Http\Controllers\CategoryController::class, 'toggleStatus'])
            ->name('categories.toggle-status');
        Route::patch('products/{products}/toggle-status', [\App\Http\Controllers\ProductController::class, 'toggleStatus'])
            ->name('products.toggle-status');
        Route::get('/user', [\App\Http\Controllers\UserController::class, 'index'])->name('users.index');
        // News Routes Empties
        Route::get('entries/reversal/create', [EntryController::class, 'createReversal'])->name('entries.reversal.create');
        Route::post('entries/reversal', [EntryController::class, 'storeReversal'])->name('entries.reversal');
        Route::get('entries/feeding/create', [EntryController::class, 'createFeeding'])->name('entries.feeding.create');
        Route::post('entries/feeding', [EntryController::class, 'storeReversal'])->name('entries.feeding');
    });

    // Rotas exclusivas do almoxarife
    Route::group(['middleware' => 'role:almoxarife'], function () {
        // Alternar ativação/desativação de categoria
    });

    // Rotas acessíveis por ambos os perfis (almoxarife, administrativo)
    Route::group(['middleware' => 'role:almoxarife,administrativo'], function () {
        // Produtos (leitura para ambos)
        Route::get('/products', [ProductController::class, 'index'])->name('products.index');
        Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
        Route::put('/output/finish/{output}', [OutputController::class, 'finish'])->name('output.finish');
    });
});

require __DIR__.'/auth.php';
