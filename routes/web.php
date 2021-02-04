<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\InvoiceProformaController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleOrderController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\StatisticsController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


Auth::routes(['register' => false]);

Route::get('invitacion/{user}', [UserController::class, 'invitation'])->name('usuarios.invitation');
Route::get('password', [UserController::class, 'setPassword'])->name('usuarios.setpassword');
Route::post('password', [UserController::class, 'setPasswordStore'])->name('usuarios.setpasswordstore');

Route::middleware('auth', 'role:admin')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->name('dashboard');

    Route::get('usuarios/filtrar', [UserController::class, 'filter'])->name('usuarios.filter');
    Route::get('usuarios/{id}/restore', [UserController::class, 'restore'])->name('usuarios.restore');
    Route::get('usuarios/{id}/info', [UserController::class, 'show'])->name('usuarios.show');
    Route::get('api/usuarios', [UserController::class, 'getAutocompleteData']);
    Route::resource('usuarios', UserController::class)->names('usuarios');

    Route::get('orden-ventas/filtrar', [SaleOrderController::class, 'filter'])->name('orden-ventas.filter');
    Route::get('orden-ventas/{id}/pdf', [SaleOrderController::class, 'pdf'])->name('orden-ventas.pdf');
    Route::get('orden-ventas/condiciones', [SaleOrderController::class, 'pdfCondiciones'])->name('orden-ventas.pdfCondiciones');
    Route::get('orden-ventas/{id}/etiqueta', [SaleOrderController::class, 'tags'])->name('orden-ventas.etiqueta');
    Route::resource('orden-ventas', SaleOrderController::class)->names('orden-ventas');

    Route::get('proformas/{id}/pdf', [InvoiceProformaController::class, 'pdf'])->name('proformas.pdf');
    Route::get('proformas/pre-crear', [InvoiceProformaController::class, 'preCreate'])->name('proformas.pre-create');
    Route::get('proformas/filtrar', [InvoiceProformaController::class, 'filter'])->name('proformas.filter');
    Route::resource('proformas', InvoiceProformaController::class)->names('proformas');

    Route::get('liquidaciones/filtrar', [InvoiceController::class, 'filter'])->name('liquidaciones.filter');
    Route::get('liquidaciones/pre-crear', [InvoiceController::class, 'preCreate'])->name('liquidaciones.pre-create');
    Route::get('liquidaciones/{id}/pdf', [InvoiceController::class, 'pdf'])->name('liquidaciones.pdf');
    Route::resource('liquidaciones', InvoiceController::class)->names('liquidaciones');

    Route::get('categorias/{id}/restore', [CategoryController::class, 'restore'])->name('categorias.restore');
    Route::resource('categorias', CategoryController::class)->names('categorias');

    Route::get('mercaderias/filtrar', [ProductController::class, 'filter'])->name('productos.filter');
    Route::resource('mercaderias', ProductController::class)->names('productos');

    Route::resource('estadisticas', StatisticsController::class)->names('estadisticas');
});
