<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\InvoiceProformaController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleOrderController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;


// Route::redirect('/', '/acceder');

Route::get('/', [HomeController::class, 'index'])->name('dashboard');

Route::get('usuarios/filtrar', [UserController::class, 'filter'])->name('usuarios.filter');
Route::get('usuarios/{id}/info', [UserController::class, 'show'])->name('usuarios.show');
Route::get('api/usuarios', [UserController::class, 'getAutocompleteData']);
Route::resource('usuarios', UserController::class)->names('usuarios');

Route::get('orden-ventas/filtrar', [SaleOrderController::class, 'filter'])->name('orden-ventas.filter');
Route::get('orden-ventas/{id}/pdf', [SaleOrderController::class, 'pdf'])->name('orden-ventas.pdf');
Route::resource('orden-ventas', SaleOrderController::class)->names('orden-ventas');

Route::get('proformas/{id}/pdf', [InvoiceProformaController::class, 'pdf'])->name('proformas.pdf');
Route::get('proformas/pre-crear', [InvoiceProformaController::class, 'preCreate'])->name('proformas.pre-create');
Route::get('proformas/filtrar', [InvoiceProformaController::class, 'filter'])->name('proformas.filter');
Route::resource('proformas', InvoiceProformaController::class)->names('proformas');

Route::resource('liquidaciones', InvoiceController::class)->names('liquidaciones');
Route::resource('categorias', CategoryController::class)->names('categorias');

Route::get('mercaderias/filtrar', [ProductController::class, 'filter'])->name('productos.filter');
Route::resource('mercaderias', ProductController::class)->names('productos');
