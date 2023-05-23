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
    return view('welcome');
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
