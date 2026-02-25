<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MensajePrivado extends Model
{
    protected $table = 'mensajes_privados';

    protected $fillable = [
        'user_id',
        'amigo_id',
        'contenido',
        'leido',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function amigo()
    {
        return $this->belongsTo(User::class, 'amigo_id');
    }
}
