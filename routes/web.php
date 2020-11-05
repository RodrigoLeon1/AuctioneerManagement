<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\InvoiceProformaController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SaleOrderController;
use App\Http\Controllers\UserController;
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

Route::resource('usuarios', UserController::class);
Route::resource('orden-ventas', SaleOrderController::class);
Route::resource('proformas', InvoiceProformaController::class);
Route::resource('liquidaciones', InvoiceController::class);
Route::resource('categorias', CategoryController::class);
Route::resource('productos', ProductController::class);
