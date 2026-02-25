<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    protected $table = 'media';

    protected $fillable = [
        'url',
        'tipo',
        'actividad_id',
        'user_id',
    ];

    public function actividad()
    {
        return $this->belongsTo(Actividades::class, 'actividad_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
