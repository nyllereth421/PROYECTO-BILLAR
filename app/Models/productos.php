<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class productos extends Model
{
    protected $table = 'productos';   
    protected $primaryKey = 'idproducto';  //  aquí indicas tu PK real
    protected $keyType = 'int';    // tipo de dato de tu PK

    protected $fillable = [
        'idproducto',
        'nombre',
        'descripcion',
        'precio',
        'stock',
        'idproveedor',
    ];

    public function proveedor()
    {
        return $this->belongsTo(Proveedores::class, 'idproveedor', 'idproveedor');
    }
}
