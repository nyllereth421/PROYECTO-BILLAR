<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Proveedores extends Model
{
    protected $table = 'proveedores';   // nombre de la tabla

    protected $primaryKey = 'idproveedor';  //  aquí indicas tu PK real
    protected $keyType = 'int';    // tipo de dato de tu PK

    protected $fillable = [
        'nombre',
        'contacto',
        'direccion',
    ];
    
    // No permitir que se asigne la clave primaria
    protected $guarded = ['idproveedor'];
     public function productos()
    {
        return $this->hasMany(Productos::class, 'idproveedor');
    }
}
