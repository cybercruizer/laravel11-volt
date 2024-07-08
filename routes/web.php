<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\WoroworoController;


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => ['auth']], function() {
    Route::resource('roles', \App\Http\Controllers\RoleController::class);
    Route::resource('users', \App\Http\Controllers\UserController::class);
    Route::resource('products', \App\Http\Controllers\ProductController::class);
    Route::get('/presensi/laporan', [\App\Http\Controllers\PresensiController::class, 'laporan'])->name('presensi.laporan');
    Route::resource('presensi', \App\Http\Controllers\PresensiController::class);
    Route::resource('walikelas', \App\Http\Controllers\WalikelasController::class);
    Route::resource('woroworo', WoroworoController::class);
});

Route::middleware('auth')->group(function () {
    Route::view('about', 'about')->name('about');

    Route::get('users', [\App\Http\Controllers\UserController::class, 'index'])->name('users.index');
    Route::get('siswas', [\App\Http\Controllers\SiswaController::class, 'index'])->name('siswas.index');
    //Route::get('siswas/datatable', [\App\Http\Controllers\SiswaController::class, 'datatable'])->name('siswas.datatable');

    Route::get('profile', [\App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
    Route::put('profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
});
