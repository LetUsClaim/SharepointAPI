<?php

use App\Http\Controllers\SubirImagenController;
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

Route::get('/subir-imagen', [SubirImagenController::class , 'vistaSubirImagen'])->name('subir-imagen');
Route::post('/cargar', [SubirImagenController::class , 'cargarImagen'])->name('cargar');
Route::get('/file-list', [SubirImagenController::class, 'fileList'])->name('file-list');
Route::get('/file-download/{id}', [SubirImagenController::class, 'downloadFile'])->name('file-download');