<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdministrasiController;

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::group(['middleware' => ['auth']], function() {
    Route::resource('roles', \App\Http\Controllers\RoleController::class);
    //Route::get('users/cekrole', [\App\Http\Controllers\UserController::class, 'cekrole'])->name('cekrole');
    Route::resource('users', \App\Http\Controllers\UserController::class);
    Route::resource('products', \App\Http\Controllers\ProductController::class);
    Route::get('/presensi/laporan', [\App\Http\Controllers\PresensiController::class, 'laporan'])->name('presensi.laporan');
    Route::get('/presensi/edit', [\App\Http\Controllers\PresensiController::class, 'edit'])->name('presensi.edit');
    Route::get('/presensi/admin', [\App\Http\Controllers\PresensiController::class, 'admin'])->name('presensi.admin');
    Route::resource('presensi', \App\Http\Controllers\PresensiController::class)->except('edit');
    Route::resource('walikelas', \App\Http\Controllers\WalikelasController::class);
    Route::resource('woroworo', \App\Http\Controllers\WoroworoController::class);
    //Route::get('pelanggaran/create', [\App\Http\Controllers\BkController::class,'create'])->name('pelanggaran.create');
    //Route::post('pelanggaran', [\App\Http\Controllers\BkController::class,'store'])->name('pelanggaran.store');
    //Route::get('pelanggaran/search', [\App\Http\Controllers\BkController::class,'search'])->name('siswa.search');
    Route::controller(\App\Http\Controllers\EventController::class)->group(function(){
        Route::get('kalender', 'index')->name('kalender.index');
        Route::get('kalender/show', 'show')->name('kalender.show');
        Route::post('kalender-ajax', 'ajax');
    });
    Route::view('about', 'about')->name('about');
    Route::get('users', [\App\Http\Controllers\UserController::class, 'index'])->name('users.index');
    Route::get('siswas', [\App\Http\Controllers\SiswaController::class, 'index'])->name('siswas.index');
    Route::get('siswas/{id}', [\App\Http\Controllers\SiswaController::class, 'show'])->name('siswas.show');
    Route::post('siswas/ajax', [\App\Http\Controllers\SiswaController::class, 'getSiswas'])->name('siswas.getSiswas');
    //Route::get('siswas/datatable', [\App\Http\Controllers\SiswaController::class, 'datatable'])->name('siswas.datatable');

    Route::get('profile', [\App\Http\Controllers\ProfileController::class, 'show'])->name('profile.show');
    Route::put('profile', [\App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::get('alpha/{tanggal}',[\App\Http\Controllers\DetailController::class,'alpha'])->name('detail.alpha');
    Route::get('terlambat/{tanggal}',[\App\Http\Controllers\DetailController::class,'terlambat'])->name('terlambat.show');
    Route::controller(\App\Http\Controllers\PelanggaranController::class)->group(function(){
        Route::get('jenispelanggaran', 'jenispelanggaranIndex')->name('jenispelanggaran.index');
        Route::post('jenispelanggaran/store', 'jenispelanggaranStore')->name('jenispelanggaran.store');
        Route::get('jenispelanggaran/edit/{id}', 'jenispelanggaranEdit')->name('jenispelanggaran.edit');
        Route::put('jenispelanggaran/update/{id}', 'jenispelanggaranUpdate')->name('jenispelanggaran.update');
        Route::delete('jenispelanggaran/destroy/{id}', 'jenispelanggaranDestroy')->name('jenispelanggaran.destroy');
        Route::get('pelanggaran', 'pelanggaranIndex')->name('pelanggaran.index');
        Route::get('pelanggaran/create', 'pelanggaranCreate')->name('pelanggaran.create');
        Route::post('pelanggaran/store', 'pelanggaranStore')->name('pelanggaran.store');
        Route::get('pelanggaran/edit/{id}', 'pelanggaranEdit')->name('pelanggaran.edit');
        Route::put('pelanggaran/update/{id}', 'pelanggaranUpdate')->name('pelanggaran.update');
        Route::delete('pelanggaran/destroy/{id}', 'pelanggaranDestroy')->name('pelanggaran.destroy');
        Route::any('pelanggaran/cari', 'pelanggaranCari')->name('pelanggaran.cari');
    });
    Route::get('administrasi', [AdministrasiController::class, 'index'])->name('administrasi.index');
    Route::resource('tagihan', \App\Http\Controllers\TagihanController::class);
    
});
/** Route::get('cekkelas/{id}', function($id){
    $guru=User::find($id);
    $siswas=$guru->siswas()->get();
    foreach($siswas as $siswa){
        dump($siswa->attributesToArray());
    }})->name('cekkelas');
**/