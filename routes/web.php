<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\ActividadesController;
use App\Http\Controllers\InscripcionesController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AlbumController;
use App\Http\Controllers\AmigosController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ForoController;
use App\Http\Controllers\NotificacionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| RUTAS PÚBLICAS (Accesibles sin estar logueado)
|--------------------------------------------------------------------------
*/

Route::get('/', function() {
    return view('pagina.portada');
})->name('pagina.portada');

Route::get('/inicio', [ActividadesController::class, 'indexPrincipal'])->name('pagina.inicio');
Route::get('/comunidades', function () { return view('pagina.comunidades'); })->name('pagina.comunidades');
Route::get('/nosotros', function () { return view('pagina.nosotros'); })->name('pagina.nosotros');

// --- AUTENTICACIÓN PERSONALIZADA ---
Route::get('/login-usuarios', function () { return view('pagina.login_usuarios'); })->name('pagina.login_usuarios');
Route::post('/login-usuarios', [AuthController::class, 'authenticate'])->name('login.custom');
Route::post('/registro-usuarios', [UsuarioController::class, 'store'])->name('usuarios.store_publico');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


/*
|--------------------------------------------------------------------------
| RUTAS PROTEGIDAS (Requieren Login y Verificación)
|--------------------------------------------------------------------------
*/
Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // --- SECCIÓN AMIGOS ---
    // Nota: Eliminada la ruta duplicada fuera del middleware
    Route::get('/amigos', [AmigosController::class, 'index'])->name('pagina.amigos');
    Route::post('/amigos/{id}/solicitar', [AmigosController::class, 'store'])->name('amigos.solicitar');
    Route::post('/amigos/{id}/aceptar', [AmigosController::class, 'accept'])->name('amigos.accept');
    Route::post('/amigos/{id}/rechazar', [AmigosController::class, 'reject'])->name('amigos.reject');
    Route::delete('/amigos/{id}/eliminar', [AmigosController::class, 'destroy'])->name('amigos.destroy');
    Route::get('/perfil/{id}', [UsuarioController::class, 'verPerfil'])->name('perfil.ver');

    // --- ACTIVIDADES E INSCRIPCIONES ---
    Route::get('/actividades/inscritas', [InscripcionesController::class, 'inscritas'])->name('actividades.inscritas');
    Route::post('/actividades/{id}/inscribir', [InscripcionesController::class, 'inscribir'])->name('actividades.inscribir');
    
    // CRUD completo de Actividades (Usando Resource)
    Route::resource('actividades', ActividadesController::class)->parameters([
        'actividades' => 'actividad'
    ]);

    // --- FOROS Y ÁLBUMES DE ACTIVIDADES ---
    Route::get('/foro', [ForoController::class, 'index'])->name('pagina.foro');
    Route::get('/actividades/{id}/foro', [ForoController::class, 'show'])->name('actividades.foro');
    Route::post('/actividades/{id}/foro', [ForoController::class, 'post'])->name('actividades.foro.post');
    Route::get('/actividades/{id}/foro/nuevos', [ForoController::class, 'getNewMessages'])->name('actividades.foro.nuevos');
    
    Route::get('/album', [AlbumController::class, 'index'])->name('pagina.album');
    Route::get('/actividades/{id}/album', [AlbumController::class, 'showActivityAlbum'])->name('actividades.album');
    Route::post('/album/subir', [AlbumController::class, 'subir'])->name('album.subir');
    Route::delete('/album/{id}', [AlbumController::class, 'destroy'])->name('album.destroy');

    // --- NOTIFICACIONES ---
    Route::get('/notificaciones', [NotificacionController::class, 'index'])->name('notificaciones.index');

    // --- ADMINISTRACIÓN ---
    Route::get('/admin/fotos', [AlbumController::class, 'indexAdmin'])->name('fotos.index');
    Route::delete('/admin/fotos/{id}', [AlbumController::class, 'destroy'])->name('fotos.destroy');
    Route::resource('usuarios', UsuarioController::class);

    // --- GESTIÓN DE PERFIL ---
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile/font-size', [ProfileController::class, 'updateFontSize'])->name('profile.updateFontSize');

    // --- CHAT PRIVADO ---
    Route::get('/chat/{id}', [ChatController::class, 'show'])->name('chat.show');
    Route::post('/chat/{id}', [ChatController::class, 'store'])->name('chat.store');
    Route::get('/chat/{id}/nuevos', [ChatController::class, 'getNuevos'])->name('chat.nuevos');

});

/*
|--------------------------------------------------------------------------
| RUTAS AUTOMÁTICAS DE LARAVEL (Breeze/Jetstream)
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';