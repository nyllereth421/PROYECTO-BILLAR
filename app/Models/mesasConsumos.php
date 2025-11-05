<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class mesasConsumos extends Model
{
    protected $table = 'mesas_consumos';
    protected $primaryKey = 'idmesaconsumo';
    protected $fillable = [
        'idmesaconsumo',
        'consumos',
        'estado',
    ];

 
public function ventaActiva()
    {
        return $this->hasOne(MesasVentas::class, 'idmesa', 'idmesaconsumo')
                    ->whereNull('fechafin')
                    ->latest();
    }

}
