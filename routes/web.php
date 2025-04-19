<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CoordinadorController;
use App\Http\Controllers\VendedorController;
use App\Http\Controllers\AcudienteController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

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
Route::post('/login', [LoginController::class, 'login'])->name('submit.login');
// Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {

    // Admin
    Route::middleware('rol:1')->group(function () {

        Route::get('/admin/inicio', [AdminController::class, 'index'])->name('admin.inicio');
        Route::get('/admin/get-counts', [AdminController::class, 'getCounts']);
        Route::get('/admin/get-latest', [AdminController::class, 'getLatest']);
        
        
        Route::get('/admin/roles', [AdminController::class, 'index_roles'])->name('admin.roles');
        Route::get('/admin/user-roles', [AdminController::class, 'getRoles']);

        Route::get('/admin/menus', [AdminController::class, 'index_menus'])->name('admin.menus');
        Route::get('/admin/estudiantes-menus', [AdminController::class, 'getMenus']);

        Route::get('/admin/productos', [AdminController::class, 'index_productos'])->name('admin.productos');

        Route::get('/admin/agregar', function () {
            return view('agregar');
        });
        Route::get('/admin/ventas', function () {
            return view('ventas');
        });
    });

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
