<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    protected $fillable = [
        'actividades_id',
        'user_id',
        'contenido',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function actividad()
    {
        return $this->belongsTo(Actividades::class, 'actividades_id');
    }
}
