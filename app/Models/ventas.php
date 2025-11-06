<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// models/Ventas.php
class Ventas extends Model
{
    protected $table = 'ventas';

    protected $fillable = [
        'fecha',
        'numerodocumento',
        'idmesaconsumo',
        'total',
    ];

    public function productos()
    {
        return $this->hasMany(ProductosVentas::class, 'idventa', 'id');
    }
}

