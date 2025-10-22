<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class usuarios extends Model
{
    protected $table = 'usuarios';
    protected $fillable = [
        'numerodocumento',
        'usuario',
        'contraseña',
        'tipo',
    ];
}
