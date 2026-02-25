<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    public function actividades()
    {
        return $this->belongsToMany(Actividades::class , 'actividad_user', 'user_id', 'actividades_id');
    }
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
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

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'fecha_nacimiento' => 'date',
        ];
    }

    // Amigos aceptados (bidireccional simulado)
    public function amigos()
    {
        return $this->belongsToMany(User::class, 'amigos', 'user_id', 'amigo_id')
                    ->wherePivot('status', 'aceptada');
    }

    // Solicitudes recibidas (pendientes)
    public function friendRequestsReceived()
    {
        return $this->belongsToMany(User::class, 'amigos', 'amigo_id', 'user_id')
                    ->wherePivot('status', 'pendiente');
    }

    // Solicitudes enviadas (pendientes)
    public function friendRequestsSent()
    {
        return $this->belongsToMany(User::class, 'amigos', 'user_id', 'amigo_id')
                    ->wherePivot('status', 'pendiente');
    }

    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}