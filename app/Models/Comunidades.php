<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comunidades extends Model
{
    public function users()
    {
        return $this->belongsToMany(User::class , 'comunidad_user');
    }
    protected $table = 'comunidades';
    protected $fillable = [
        'nombre',
        'descripcion',
    ];
}