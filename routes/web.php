<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\ActividadesController;
use App\Http\Controllers\InscripcionesController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AlbumController;
use App\Http\Controllers\AmigosController; // Asegúrate de tener este controlador creado
use Illuminate\Support\Facades\Route;

/*
 |--------------------------------------------------------------------------
 | RUTAS PÚBLICAS
 |--------------------------------------------------------------------------
 */

Route::get('/', function() {
    return view('pagina.portada');
})->name('pagina.portada');

Route::get('/inicio', [ActividadesController::class , 'indexPrincipal'])->name('pagina.inicio');

Route::get('/login-usuarios', function () {
    return view('pagina.login_usuarios');
})->name('pagina.login_usuarios');

Route::get('/comunidades', function () {
    return view('pagina.comunidades');
})->name('pagina.comunidades');

Route::get('/nosotros', function () {
    return view('pagina.nosotros');
})->name('pagina.nosotros');

Route::get('/amigos', function () {
    return view('pagina.amigos');
})->name('pagina.amigos');

Route::get('/foro', function () {
    return view('pagina.foro');
})->name('pagina.foro');

// --- RUTAS DEL ÁLBUM ---
Route::get('/album', [AlbumController::class , 'index'])->name('pagina.album');
Route::post('/album/subir', [AlbumController::class , 'subir'])->name('album.subir');

/*
 |--------------------------------------------------------------------------
 | AUTENTICACIÓN
 |--------------------------------------------------------------------------
 */
Route::post('/login-usuarios', [AuthController::class , 'authenticate'])->name('login.custom');
Route::post('/registro-usuarios', [UsuarioController::class , 'store'])->name('usuarios.store_publico');
Route::post('/logout', [AuthController::class , 'logout'])->name('logout');

/*
 |--------------------------------------------------------------------------
 | RUTAS PROTEGIDAS (Requieren Login)
 |--------------------------------------------------------------------------
 */
Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', function () {
            return view('dashboard');
        }
        )->name('dashboard');

        // --- SECCIÓN AMIGOS (Añadida aquí) ---
        // Usamos 'anadir' para evitar errores de codificación con la 'ñ'
        Route::post('/amigos/{id}/anadir', [AmigosController::class , 'store'])
            ->name('amigos.anadir');

        // Inscripciones a actividades
        Route::post('/actividades/{id}/inscribir', [InscripcionesController::class , 'inscribir'])
            ->name('actividades.inscribir');

        // CRUD de Actividades (Admin)
        Route::resource('actividades', ActividadesController::class)->parameters([
            'actividades' => 'actividad'
        ]);

        // Administración de Fotos
        Route::get('/admin/fotos', [AlbumController::class , 'indexAdmin'])->name('fotos.index');
        Route::delete('/admin/fotos/{id}', [AlbumController::class , 'destroy'])->name('fotos.destroy');

        // Gestión de Usuarios
        Route::resource('usuarios', UsuarioController::class);

        // Perfil de Usuario
        Route::get('/profile', [ProfileController::class , 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class , 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class , 'destroy'])->name('profile.destroy');
    });

require __DIR__ . '/auth.php';