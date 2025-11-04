<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MesasVentas extends Model
{
    use HasFactory;

    protected $table = 'mesasventas';

    protected $fillable = [
        'ventas',
        'fechainicio',
        'fechafin',
        'total',
        'idmesa',
    ];

    // Relación: cada mesa venta pertenece a una mesa
    public function mesa()
    {
        return $this->belongsTo(Mesas::class, 'idmesa', 'idmesa');
    }

    // Relación: cada mesa venta pertenece a una venta
    public function venta()
    {
        return $this->belongsTo(Ventas::class, 'ventas', 'id');
    }
}
