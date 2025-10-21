<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ventas extends Model
{
    protected $table = 'ventas';

    protected $fillable = [
        'fecha',
        'numerodocumento',
        'idmesaconsumo',
        'total',
    ];
}
