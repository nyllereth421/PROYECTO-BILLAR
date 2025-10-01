<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class proveedores extends Model
{
    protected $table = 'proveedores';
   

    protected $fillable = [
        'idproveedor',
        'nombre',
        'contacto',
        'direccion',
    ];
}
