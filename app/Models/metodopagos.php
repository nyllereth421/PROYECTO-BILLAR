<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class metodopagos extends Model
{
    protected $table = 'metodopagos';

    protected $fillable = [
        'idmetodopago',
        'formadepago',
        'descripcion',
    ];
}
