<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\InvoiceProformaController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleOrderController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


// Route::redirect('/', '/acceder');

Route::get('/', function () {
    return view('layouts.dashboard');
})->name('dashboard');

Route::resource('usuarios', UserController::class)->names('usuarios');

Route::resource('orden-ventas', SaleOrderController::class)->names('orden-ventas');
Route::get('orden-ventas/filtrar', [SaleOrderController::class, 'filter'])->name('orden-ventas.filter');

Route::resource('proformas', InvoiceProformaController::class)->names('proformas');
Route::resource('liquidaciones', InvoiceController::class)->names('liquidaciones');
Route::resource('categorias', CategoryController::class)->names('categorias');
Route::resource('productos', ProductController::class)->names('productos');
