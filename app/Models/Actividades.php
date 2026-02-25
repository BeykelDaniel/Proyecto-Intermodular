<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Actividades extends Model
{
    public function users() {
        return $this->belongsToMany(User::class, 'actividad_user');
    }
    protected $table = 'actividades';
    protected $fillable = [
        'nombre',
        'descripcion',
        'fecha',
        'hora',
        'lugar',
        'precio',
        'cupos',
        'imagen',
    ];

    public function posts()
    {
        return $this->hasMany(Post::class, 'actividades_id');
    }

    public function media()
    {
        return $this->hasMany(Foto::class, 'actividad_id');
    }
}
