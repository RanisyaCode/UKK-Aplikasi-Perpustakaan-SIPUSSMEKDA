<?php

use App\Http\Controllers\AnggotaController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DataBukuController;
use App\Http\Controllers\PerpustakaanSiswaController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TransaksiAdminController;
use App\Http\Controllers\TransaksiSiswaController;
use App\Models\Buku;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| GUEST (BELUM LOGIN)
|--------------------------------------------------------------------------
*/
Route::middleware('guest')->group(function () {
    Route::get('/', function () {
        $semua_buku = Buku::latest()->take(6)->get(); 
        return view('welcome', compact('semua_buku'));
    })->name('welcome');

    Route::get('login', [AuthController::class, 'login'])->name('login');
    Route::post('login', [AuthController::class, 'process'])->name('login.process');

    Route::get('register', [AuthController::class, 'register'])->name('register');
    Route::post('register', [AuthController::class, 'registerProses'])->name('registerProses');
});

Route::post('/update-theme', [AuthController::class, 'updateTheme'])->name('update.theme');
Route::post('logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect()->route('login')->with('success', 'Berhasil logout');
})->name('logout');

/*
|--------------------------------------------------------------------------
| WAJIB LOGIN - ADMIN
|--------------------------------------------------------------------------
*/
Route::middleware('checkLogin:Admin')->group(function () {
    Route::get('dashboardadmin', [DashboardController::class, 'index'])->name('dashboardadmin');
    // Menu Admin - Buku
    Route::get('databuku', [DataBukuController::class, 'databuku'])->name('databuku');
    Route::get('databuku/create', [DataBukuController::class, 'create'])->name('buku.create');
    Route::post('databuku/store', [DataBukuController::class, 'store'])->name('buku.store');
    Route::get('databuku/edit/{id}', [DataBukuController::class, 'edit'])->name('buku.edit');
    Route::put('databuku/update/{id}', [DataBukuController::class, 'update'])->name('buku.update');
    Route::delete('databuku/delete/{id}', [DataBukuController::class, 'destroy'])->name('buku.destroy');

    // Bagian Anggota
    Route::get('/admin/anggota', [AnggotaController::class, 'index'])->name('anggota');
    Route::get('/admin/anggota/create', [AnggotaController::class, 'create'])->name('anggota.create');
    Route::post('/admin/anggota/store', [AnggotaController::class, 'store'])->name('anggota.store');
    Route::get('/admin/anggota/{id}/edit', [AnggotaController::class, 'edit'])->name('anggota.edit'); 
    Route::put('/admin/anggota/{id}/update', [AnggotaController::class, 'update'])->name('anggota.update');
    Route::delete('/admin/anggota/{id}', [AnggotaController::class, 'destroy'])->name('anggota.destroy');

    // Menu Admin - Transaksi
    Route::prefix('admin/transaksi')->group(function () {
        Route::get('/peminjaman', [TransaksiAdminController::class, 'indexPeminjaman'])->name('admin.transaksi.peminjaman');
        Route::get('/pengembalian', [TransaksiAdminController::class, 'indexPengembalian'])->name('admin.transaksi.pengembalian');
        Route::post('/approve/{id}', [TransaksiAdminController::class, 'approve'])->name('admin.transaksi.approve');
        Route::post('/reject/{id}', [TransaksiAdminController::class, 'reject'])->name('admin.transaksi.reject');
        Route::post('/proses-kembali/{id}', [TransaksiAdminController::class, 'prosesKembali'])->name('admin.transaksi.prosesKembali');
        Route::get('/edit-pengembalian/{id}', [TransaksiAdminController::class, 'edit_pengembalian'])->name('admin.transaksi.edit_pengembalian');
        Route::get('/create', [TransaksiAdminController::class, 'create'])->name('admin.transaksi.create');
        Route::post('/store', [TransaksiAdminController::class, 'store'])->name('admin.transaksi.store');
        Route::patch('/update-status/{id}', [TransaksiAdminController::class, 'updateStatus'])->name('admin.transaksi.updateStatus');
        Route::get('/edit/{id}', [TransaksiAdminController::class, 'edit'])->name('admin.transaksi.edit');
        Route::put('/update/{id}', [TransaksiAdminController::class, 'update'])->name('admin.transaksi.update');
        Route::delete('/delete/{id}', [TransaksiAdminController::class, 'destroy'])->name('admin.transaksi.destroy');
    });
}); // <--- Penutup Grup Admin

/*
|--------------------------------------------------------------------------
| WAJIB LOGIN - SISWA
|--------------------------------------------------------------------------
*/
Route::middleware('checkLogin:Siswa')->group(function () {
    Route::get('/dashboard', [PerpustakaanSiswaController::class, 'index'])->name('dashboard');
    Route::get('/buku/{id}', [PerpustakaanSiswaController::class, 'detailBuku'])->name('siswa.buku.detail');
    
    Route::prefix('transaksi')->group(function () {
        Route::get('pinjam', [TransaksiSiswaController::class, 'pinjam'])->name('pinjam');
        Route::get('/pinjam-buku/{id}/edit', [TransaksiSiswaController::class, 'edit'])->name('pinjam.edit');
        Route::put('/pinjam-buku/{id}/update', [TransaksiSiswaController::class, 'updatePinjam'])->name('pinjam.update');
        Route::get('pilih-buku', [TransaksiSiswaController::class, 'formPilih'])->name('pinjam.form');        Route::post('pinjam/store', [TransaksiSiswaController::class, 'store'])->name('pinjam.store');
        Route::delete('pinjam/delete/{id}', [TransaksiSiswaController::class, 'destroy'])->name('pinjam.destroy');
    
        Route::get('pengembalian', [TransaksiSiswaController::class, 'index'])->name('pengembalian');
        Route::put('pengembalian/{id}', [TransaksiSiswaController::class, 'update'])->name('pengembalian.update');
    });
}); // <--- Penutup Grup Siswa

/*
|--------------------------------------------------------------------------
| PROFILE (UNTUK SEMUA ROLE)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/delete-photo', [ProfileController::class, 'deletePhoto'])->name('profile.deletePhoto');
});