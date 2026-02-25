<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\ActividadesController;
use App\Http\Controllers\InscripcionesController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AlbumController;
use App\Http\Controllers\AmigosController; // Asegúrate de tener este controlador creado
use App\Http\Controllers\ChatController;
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

Route::get('/foro', [App\Http\Controllers\ForoController::class, 'index'])->name('pagina.foro');

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

        // --- SECCIÓN AMIGOS ---
        Route::get('/amigos', [AmigosController::class, 'index'])->name('pagina.amigos');
        Route::post('/amigos/{id}/solicitar', [AmigosController::class, 'store'])->name('amigos.solicitar');
        Route::get('/perfil/{id}', [UsuarioController::class, 'verPerfil'])->name('perfil.ver');
        Route::post('/amigos/{id}/aceptar', [AmigosController::class, 'accept'])->name('amigos.accept');
        Route::post('/amigos/{id}/rechazar', [AmigosController::class, 'reject'])->name('amigos.reject');
        Route::delete('/amigos/{id}/eliminar', [AmigosController::class, 'destroy'])->name('amigos.destroy');

        // --- NOTIFICACIONES ---
        Route::get('/notificaciones', [App\Http\Controllers\NotificacionController::class, 'index'])->name('notificaciones.index');

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

        // Perfil de Usuario (Configuración)
        Route::get('/profile', function() {
            return view('pagina.profile_edit');
        })->name('profile.edit');
        Route::patch('/profile', [ProfileController::class , 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class , 'destroy'])->name('profile.destroy');
        Route::post('/profile/font-size', [ProfileController::class, 'updateFontSize'])->name('profile.updateFontSize');

        // --- FOROS Y ÁLBUMES DE ACTIVIDADES ---
        Route::get('/actividades/{id}/foro', [App\Http\Controllers\ForoController::class, 'show'])->name('actividades.foro');
        Route::post('/actividades/{id}/foro', [App\Http\Controllers\ForoController::class, 'post'])->name('actividades.foro.post');
        Route::get('/actividades/{id}/foro/nuevos', [App\Http\Controllers\ForoController::class, 'getNewMessages'])->name('actividades.foro.nuevos');
        Route::get('/actividades/{id}/album', [App\Http\Controllers\AlbumController::class, 'showActivityAlbum'])->name('actividades.album');
        Route::delete('/album/{id}', [App\Http\Controllers\AlbumController::class, 'destroy'])->name('album.destroy');
        Route::get('/actividades/inscritas', [App\Http\Controllers\InscripcionesController::class, 'inscritas'])->name('actividades.inscritas');

        // --- CHAT PRIVADO ---
        Route::get('/chat/{id}', [ChatController::class, 'show'])->name('chat.show');
        Route::post('/chat/{id}', [ChatController::class, 'store'])->name('chat.store');
        Route::get('/chat/{id}/nuevos', [ChatController::class, 'getNuevos'])->name('chat.nuevos');
    });

require __DIR__ . '/auth.php';