<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ItemPenjualanController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\ProdukController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PerusahaanController
;
use App\Http\Controllers\PengeluaranController;
/*
|--------------------------------------------------------------------------
| Halaman Utama
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('login');
});


/*
|--------------------------------------------------------------------------
| Authentication (Middleware Web & Guest)
|--------------------------------------------------------------------------
*/

Route::middleware(['web', 'guest'])->group(function () {

    // Menampilkan halaman login
    Route::get('/login', [AuthController::class, 'index'])
        ->name('login');

    // Memproses login
    Route::post('/login', [AuthController::class, 'auth'])
        ->name('login.process');

});


/*
|--------------------------------------------------------------------------
| Halaman yang Membutuhkan Login
|--------------------------------------------------------------------------
*/

Route::middleware(['web', 'auth'])->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::post('/pengeluaran', [PengeluaranController::class, 'store'])
        ->name('pengeluaran.store');
    Route::get('/pengeluaran', [PengeluaranController::class, 'index'])
        ->name('pengeluaran.index');

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');


    /*
    |--------------------------------------------------------------------------
    | Profil Saya
    |--------------------------------------------------------------------------
    */

    Route::get('/profil', [ProfileController::class, 'index'])
        ->name('profile.index');

    Route::put('/profil', [ProfileController::class, 'update'])
        ->name('profile.update');


    /*
    |--------------------------------------------------------------------------
    | Admin Management
    |--------------------------------------------------------------------------
    */

    Route::prefix('admin')
        ->name('admin.')
        ->group(function () {

            // User Management
            Route::get('/users', [UserController::class, 'index'])
                ->name('users');

            Route::get('/users/create', [UserController::class, 'create'])
                ->name('users.create');

            Route::post('/users/store', [UserController::class, 'store'])
                ->name('users.store');

            Route::get('/users/edit/{user}', [UserController::class, 'edit'])
                ->name('users.edit');

            Route::post('/users/update/{user}', [UserController::class, 'update'])
                ->name('users.update');

            Route::delete('/users/destroy/{user}', [UserController::class, 'destroy'])
                ->name('users.destroy');

        });


    /*
    |--------------------------------------------------------------------------
    | Data Master & Transactions
    |--------------------------------------------------------------------------
    */

    // Kategori
    Route::resource('/kategori', KategoriController::class);

    // Produk
    Route::patch('/produk/{produk}/diskon', [ProdukController::class, 'updateDiscount'])
        ->name('produk.discount.update');
    Route::resource('/produk', ProdukController::class);

    // Penjualan
    Route::post('/penjualan/{penjualan}/refund', [PenjualanController::class, 'refund'])
        ->name('penjualan.refund');
    Route::resource('/penjualan', PenjualanController::class);

    // Perusahaan
    Route::put('/perusahaan/profil', [PerusahaanController::class, 'updateProfile'])
        ->name('perusahaan.profile.update');
    Route::resource('/perusahaan', PerusahaanController::class);
    // Item Penjualan
    Route::resource('/itempenjualan', ItemPenjualanController::class);

});