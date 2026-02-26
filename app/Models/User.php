<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'fecha_nacimiento',
        'genero',
        'numero_telefono',
        'perfil_foto',
        'font_size',
        'biografia',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'fecha_nacimiento' => 'date',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | RELACIONES DE ACTIVIDADES Y POSTS
    |--------------------------------------------------------------------------
    */

    public function actividades()
    {
        return $this->belongsToMany(Actividades::class , 'actividad_user', 'user_id', 'actividades_id');
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    /*
    |--------------------------------------------------------------------------
    | SISTEMA DE AMIGOS
    |--------------------------------------------------------------------------
    */

    // Amigos que ya han aceptado la solicitud
    public function amigos()
    {
        return $this->belongsToMany(User::class, 'amigos', 'user_id', 'amigo_id')
                    ->withPivot('status')
                    ->wherePivot('status', 'aceptada');
    }

    // Solicitudes que YO he enviado (quitamos el wherePivot para que funcione el attach)
    public function friendRequestsSent()
    {
        return $this->belongsToMany(User::class, 'amigos', 'user_id', 'amigo_id')
                    ->withPivot('status');
    }

    // Solicitudes que HE RECIBIDO y están esperando respuesta
    public function friendRequestsReceived()
    {
        return $this->belongsToMany(User::class, 'amigos', 'amigo_id', 'user_id')
                    ->withPivot('status')
                    ->wherePivot('status', 'pendiente');
    }
}