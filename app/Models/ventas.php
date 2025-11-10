<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// models/Ventas.php
class Ventas extends Model
{
    protected $table = 'ventas';

    protected $fillable = [
        'fecha',
        'idmesa',
        'numerodocumento',
        'idmesaconsumo',
        'total',
    ];

    public function productos()
    {
        return $this->hasMany(ProductosVentas::class, 'idventa', 'id');
    }
    public function users()
    {
        // Clave foránea local 'idusuario' referencia 'id' en el modelo User
        return $this->belongsTo(User::class, 'id', 'id');
    }
    public function consumo()
    {
        // Clave foránea local 'idmesaconsumo' referencia 'idmesaconsumo' en el modelo MesaConsumo
        return $this->belongsTo(MesaConsumo::class, 'idmesaconsumo', 'idmesaconsumo');
    }
    public function mesa()
    {
        // Clave foránea local 'idmesa' referencia 'idmesa' en el modelo Mesa
        return $this->belongsTo(Mesa::class, 'idmesa', 'idmesa');
    }


}

