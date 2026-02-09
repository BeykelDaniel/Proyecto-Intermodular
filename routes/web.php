<?php

<<<<<<< HEAD
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UsuarioController;
=======
>>>>>>> b5b51b0bb45621dde3866f7afb008d296d778214
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

<<<<<<< HEAD
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::resource('usuarios', UsuarioController::class);
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::get('/inicio', function () {
    return view('inicio');
})->name('inicio');
=======
use App\Http\Controllers\UsuarioController;

Route::resource('usuarios', UsuarioController::class);
>>>>>>> b5b51b0bb45621dde3866f7afb008d296d778214
