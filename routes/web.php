<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EntryController;
use App\Http\Controllers\PublicServantController;
use App\Http\Controllers\OutputController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;

Route::get('/', function () {
    return view('auth.login');
});

// Routes to register user without authentication:
Route::get('/user/register', [UserController::class, 'register'])->name('user.register');
Route::post('/user/store', [UserController::class, 'store'])->name('users.store');
Route::get('/register/email', function (Request $request) {

    if ( $request::hasValidSignature()) {
        $str_register = Str::random(16);
        $hash = password_hash($str_register, PASSWORD_DEFAULT);
        session(['str_token' => $str_register]);

        return redirect()->route('user.register',
            [
                'tokenRegister' => $hash,
                'perfil' => $request::input('perfil'),
                'email' => $request::input('email'),
            ]
        );
    }
    abort(401);
})->name('register.email');

// Routes to apresentation page (not used)
Route::get('/apresentation', function () {
    return view('apresentation');
});

Route::get('/tech-doc', function () {
    return view('tech_documentation');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// TODO: Assinar esses rotas depois quando for implementar o cadastro de usuarios por email teste12345
Route::get('/user/create', [UserController::class, 'create'])->name('users.create');

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

        // News Routes Empties
        Route::get('entries/reversal/create', [EntryController::class, 'createReversal'])->name('entries.reversal.create');
        Route::post('entries/reversal', [EntryController::class, 'storeReversal'])->name('entries.reversal');

        // Users Routers
        Route::get('/user', [\App\Http\Controllers\UserController::class, 'index'])->name('users.index');
        Route::get('/user/send-email', [UserController::class, 'sendEmailForm'])->name('users.form.send.email');
        Route::post('/user/send-email', [UserController::class, 'sendEmail'])->name('users.send.email');
    });

    // Rotas exclusivas do almoxarife
    Route::group(['middleware' => 'role:almoxarife'], function () {
        // Alternar ativação/desativação de categoria
    });

    // Rotas acessíveis por ambos os perfis (almoxarife, administrativo)
    Route::group(['middleware' => 'role:almoxarife,administrativo'], function () {
        // Produtos (leitura e cadastro)
        Route::get('/products', [ProductController::class, 'index'])->name('products.index');
        Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
        Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

        Route::put('/output/finish/{output}', [OutputController::class, 'finish'])->name('output.finish');

        // Output actions
        Route::put('/output/{output}/cancel', [OutputController::class, 'cancel'])->name('output.cancel');

        // Calls actions
        Route::put('/calls/{call}/cancel', [\App\Http\Controllers\CallController::class, 'cancel'])->name('calls.cancel');

        Route::get('entries/feeding/create', [EntryController::class, 'createFeeding'])->name('entries.feeding.create');
        Route::post('entries/feeding', [EntryController::class, 'storeFeeding'])->name('entries.feeding');
    });

    // Tenant: alterar departamento atual na sessão
    Route::post('/tenant/switch', [\App\Http\Controllers\TenantController::class, 'switch'])
        ->name('tenant.switch');
});

require __DIR__.'/auth.php';
