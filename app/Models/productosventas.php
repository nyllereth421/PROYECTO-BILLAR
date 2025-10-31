<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class productosventas extends Model
{
    protected $table = 'productosventas';
    protected $fillable = [
        'idproducto',
        'idventa',
        'cantidad',
        'total',
        'descripcion',
    ];
}
