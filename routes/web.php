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
Route::get('usuarios/filtrar', [UserController::class, 'show'])->name('usuarios.filter');
Route::post('usuarios/filtrar', [UserController::class, 'show'])->name('usuarios.filter');
Route::get('usuarios/{id}/editar', [UserController::class, 'edit'])->name('usuarios.edit');
Route::get('usuarios/{id}/actualizar', [UserController::class, 'update'])->name('usuarios.update');


Route::resource('orden-ventas', SaleOrderController::class)->names('orden-ventas');
Route::get('orden-ventas/filtrar', [SaleOrderController::class, 'filter'])->name('orden-ventas.filter');
Route::get('orden-ventas/{id}/pdf', [SaleOrderController::class, 'pdf'])->name('orden-ventas.pdf');

Route::resource('proformas', InvoiceProformaController::class)->names('proformas');
Route::resource('liquidaciones', InvoiceController::class)->names('liquidaciones');
Route::resource('categorias', CategoryController::class)->names('categorias');
Route::resource('productos', ProductController::class)->names('productos');
