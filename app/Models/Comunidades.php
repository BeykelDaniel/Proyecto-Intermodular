<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comunidades extends Model
{
    // Si tu tabla en la DB se llama 'comunidades', Laravel la detecta sola.
    // Si se llama distinto, descomenta la línea de abajo:
    // protected $table = 'comunidades';

    protected $fillable = ['nombre', 'descripcion']; // Ajusta según tus columnas

    public function users()
    {
        return $this->belongsToMany(User::class, 'comunidad_user');
    }
}