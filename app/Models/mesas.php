<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class mesas extends Model
{   protected $primaryKey = 'idmesa';
    protected $keyType = 'string';
    protected $table = 'mesas';

    protected $fillable = [
        'idmesa',
        'estado',
        'tipo',
        'numeromesa',
    ];
 public function ventas()
    {
        return $this->hasMany(MesasVentas::class, 'idmesa', 'idmesa');
    }

    // Relación con venta activa (opcional)
    public function ventaActiva()
    {
        return $this->hasOne(MesasVentas::class, 'idmesa', 'idmesa')->whereNull('fechafin');
    }


}
