<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UsuarioController;
use Illuminate\Support\Facades\Route;

// --- RUTAS PÚBLICAS ---

// Bienvenida
Route::get('/', function () {
    return view('welcome');
});

// Página de inicio (Solo visualización)
Route::get('/inicio', function () {
    return view('pagina.inicio');
})->name('pagina.inicio');

// Formulario de Login/Registro (Vista)
Route::get('/login-usuarios', function () {
    return view('pagina.login_usuarios');
})->name('pagina.login_usuarios');

// Procesar Login (Bloque Azul)
Route::post('/login-usuarios', [UsuarioController::class , 'login'])->name('login.custom');

// Procesar Registro (Bloque Teja)
Route::post('/registro-usuarios', [UsuarioController::class , 'store'])->name('usuarios.store_publico');

// Logout
Route::post('/logout', [UsuarioController::class , 'logout'])->name('logout');

// --- RUTAS PROTEGIDAS (Requieren autenticación) ---

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', function () {
            return view('dashboard');
        }
        )->name('dashboard');

        // Gestión interna de usuarios
        Route::resource('usuarios', UsuarioController::class);

        Route::get('/profile', [ProfileController::class , 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class , 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class , 'destroy'])->name('profile.destroy');
    });

require __DIR__ . '/auth.php';