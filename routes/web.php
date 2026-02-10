<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\ActividadesController;
use App\Http\Controllers\InscripcionesController;
use App\Http\Controllers\AuthController; 
use Illuminate\Support\Facades\Route;

// --- RUTAS PÚBLICAS ---

Route::get('/', function () {
    return view('pagina.inicio');
});

Route::get('/inicio', function () {
    return view('pagina.inicio');
})->name('pagina.inicio');

// AQUÍ ESTABA EL ERROR: He cambiado 'auth.login_usuarios' por 'pagina.login_usuarios'
Route::get('/login-usuarios', function () {
    return view('pagina.login_usuarios'); 
})->name('pagina.login_usuarios');

Route::post('/login-usuarios', [AuthController::class, 'authenticate'])->name('login.custom');
Route::post('/registro-usuarios', [UsuarioController::class, 'store'])->name('usuarios.store_publico');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// --- RUTAS PROTEGIDAS ---

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::post('/actividades/{id}/inscribir', [InscripcionesController::class, 'inscribir'])
        ->name('actividades.inscribir');

    Route::resource('actividades', ActividadesController::class)->parameters([
        'actividades' => 'actividad'
    ]);

    Route::resource('usuarios', UsuarioController::class);

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';