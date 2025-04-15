<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CoordinadorController;
use App\Http\Controllers\VendedorController;
use App\Http\Controllers\AcudienteController;

Route::get('/', function () {
    return view('index');
});

Route::get('/productos', function () {
    return view('productos');
});

Route::get('/contacto', function () {
    return view('contacto');
});

Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
// Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {

    // Admin
    Route::get('/admin/inicio', [AdminController::class, 'index'])
        ->middleware('rol:1')
        ->name('admin.inicio');

    // Coordinador
    Route::get('/coordinador/inicio', [CoordinadorController::class, 'index'])
        ->middleware('rol:2')
        ->name('coordinador.inicio');

    // Vendedor
    Route::get('/vendedor/inicio', [VendedorController::class, 'index'])
        ->middleware('rol:3')
        ->name('vendedor.inicio');

    // Acudiente
    Route::get('/acudiente/inicio', [AcudienteController::class, 'index'])
        ->middleware('rol:4')
        ->name('acudiente.inicio');
});