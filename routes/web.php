<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('landing');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Kategori
Route::get('/kategori', [App\Http\Controllers\KategoriController::class, 'index'])->name('kategori.index');
Route::get('/kategori/create', [App\Http\Controllers\KategoriController::class, 'create'])->name('kategori.create');
Route::post('/kategori', [App\Http\Controllers\KategoriController::class, 'store'])->name('kategori.store');
Route::get('/kategori/{id}/edit', [App\Http\Controllers\KategoriController::class, 'edit'])->name('kategori.edit');
Route::put('/kategori/{id}', [App\Http\Controllers\KategoriController::class, 'update'])->name('kategori.update');
Route::delete('/kategori/{id}', [App\Http\Controllers\KategoriController::class, 'destroy'])->name('kategori.destroy');
Route::get('/kategori/{id}', [App\Http\Controllers\KategoriController::class, 'show'])->name('kategori.show');

// Barang
Route::get('/barang', [App\Http\Controllers\BarangController::class, 'index'])->name('barang.index');
Route::get('/barang/create', [App\Http\Controllers\BarangController::class, 'create'])->name('barang.create');
Route::post('/barang', [App\Http\Controllers\BarangController::class, 'store'])->name('barang.store');
Route::get('/barang/{id}/edit', [App\Http\Controllers\BarangController::class, 'edit'])->name('barang.edit');
Route::put('/barang/{id}', [App\Http\Controllers\BarangController::class, 'update'])->name('barang.update');
Route::delete('/barang/{id}', [App\Http\Controllers\BarangController::class, 'destroy'])->name('barang.destroy');
Route::get('/barang/{id}', [App\Http\Controllers\BarangController::class, 'show'])->name('barang.show');

// Supplier
Route::get('/supplier', [App\Http\Controllers\SupplierController::class, 'index'])->name('supplier.index');
Route::get('/supplier/create', [App\Http\Controllers\SupplierController::class, 'create'])->name('supplier.create');
Route::post('/supplier', [App\Http\Controllers\SupplierController::class, 'store'])->name('supplier.store');
Route::get('/supplier/{id}/edit', [App\Http\Controllers\SupplierController::class, 'edit'])->name('supplier.edit');
Route::put('/supplier/{id}', [App\Http\Controllers\SupplierController::class, 'update'])->name('supplier.update');
Route::delete('/supplier/{id}', [App\Http\Controllers\SupplierController::class, 'destroy'])->name('supplier.destroy');
Route::get('/supplier/{id}', [App\Http\Controllers\SupplierController::class, 'show'])->name('supplier.show');

// Rule
Route::get('/rule', [App\Http\Controllers\RuleController::class, 'index'])->name('rule.index');
Route::get('/rule/create', [App\Http\Controllers\RuleController::class, 'create'])->name('rule.create');
Route::post('/rule', [App\Http\Controllers\RuleController::class, 'store'])->name('rule.store');
Route::get('/rule/{id}/edit', [App\Http\Controllers\RuleController::class, 'edit'])->name('rule.edit');
Route::put('/rule/{id}', [App\Http\Controllers\RuleController::class, 'update'])->name('rule.update');
Route::delete('/rule/{id}', [App\Http\Controllers\RuleController::class, 'destroy'])->name('rule.destroy');
Route::get('/rule/{id}', [App\Http\Controllers\RuleController::class, 'show'])->name('rule.show');

// Pembelian
Route::get('/pembelian', [App\Http\Controllers\PembelianController::class, 'index'])->name('pembelian.index');
Route::get('/pembelian/create', [App\Http\Controllers\PembelianController::class, 'create'])->name('pembelian.create');
Route::post('/pembelian', [App\Http\Controllers\PembelianController::class, 'store'])->name('pembelian.store');
Route::get('/pembelian/{id}/edit', [App\Http\Controllers\PembelianController::class, 'edit'])->name('pembelian.edit');
Route::put('/pembelian/{id}', [App\Http\Controllers\PembelianController::class, 'update'])->name('pembelian.update');
Route::delete('/pembelian/{id}', [App\Http\Controllers\PembelianController::class, 'destroy'])->name('pembelian.destroy');
Route::get('/pembelian/{id}', [App\Http\Controllers\PembelianController::class, 'show'])->name('pembelian.show');
Route::get('/pembelian/new/generate_kode', [App\Http\Controllers\PembelianController::class, 'generate_kode'])->name('pembelian.generate_kode');
Route::post('/pembelian/confirm/barang', [App\Http\Controllers\PembelianController::class, 'confirm_barang'])->name('pembelian.confirm_barang');

// Barang Masuk
Route::get('/barang_masuk', [App\Http\Controllers\BarangMasukController::class, 'index'])->name('barang_masuk.index');
Route::get('/barang_masuk/create', [App\Http\Controllers\BarangMasukController::class, 'create'])->name('barang_masuk.create');
Route::post('/barang_masuk', [App\Http\Controllers\BarangMasukController::class, 'store'])->name('barang_masuk.store');
Route::get('/barang_masuk/{id}/edit', [App\Http\Controllers\BarangMasukController::class, 'edit'])->name('barang_masuk.edit');
Route::put('/barang_masuk/{id}', [App\Http\Controllers\BarangMasukController::class, 'update'])->name('barang_masuk.update');
Route::delete('/barang_masuk/{id}', [App\Http\Controllers\BarangMasukController::class, 'destroy'])->name('barang_masuk.destroy');
Route::get('/barang_masuk/{id}', [App\Http\Controllers\BarangMasukController::class, 'show'])->name('barang_masuk.show');

// Permintaan
Route::get('/permintaan', [App\Http\Controllers\PermintaanController::class, 'index'])->name('permintaan.index');
Route::get('/permintaan/create', [App\Http\Controllers\PermintaanController::class, 'create'])->name('permintaan.create');
Route::post('/permintaan', [App\Http\Controllers\PermintaanController::class, 'store'])->name('permintaan.store');
Route::get('/permintaan/{id}/edit', [App\Http\Controllers\PermintaanController::class, 'edit'])->name('permintaan.edit');
Route::put('/permintaan/{id}', [App\Http\Controllers\PermintaanController::class, 'update'])->name('permintaan.update');
Route::delete('/permintaan/{id}', [App\Http\Controllers\PermintaanController::class, 'destroy'])->name('permintaan.destroy');
Route::get('/permintaan/{id}', [App\Http\Controllers\PermintaanController::class, 'show'])->name('permintaan.show');
Route::get('/permintaan/new/generate_kode', [App\Http\Controllers\PermintaanController::class, 'generate_kode'])->name('permintaan.generate_kode');

// Distribusi
Route::get('/distribusi', [App\Http\Controllers\DistribusiController::class, 'index'])->name('distribusi.index');
Route::get('/distribusi/create', [App\Http\Controllers\DistribusiController::class, 'create'])->name('distribusi.create');
Route::post('/distribusi', [App\Http\Controllers\DistribusiController::class, 'store'])->name('distribusi.store');
Route::get('/distribusi/{id}/edit', [App\Http\Controllers\DistribusiController::class, 'edit'])->name('distribusi.edit');
Route::put('/distribusi/{id}', [App\Http\Controllers\DistribusiController::class, 'update'])->name('distribusi.update');
Route::delete('/distribusi/{id}', [App\Http\Controllers\DistribusiController::class, 'destroy'])->name('distribusi.destroy');
Route::get('/distribusi/{id}', [App\Http\Controllers\DistribusiController::class, 'show'])->name('distribusi.show');

// Generate Password
Route::get('/generate_password/{plaintext}', [App\Http\Controllers\GeneratePasswordController::class, 'index'])->name('generate_password.index');
