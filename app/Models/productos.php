<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Productos extends Model
{
    protected $table = 'productos';             // nombre de la tabla
    protected $primaryKey = 'idproducto';       // clave primaria
    public $incrementing = true;                // si tu idproducto es autoincremental
    protected $keyType = 'int';                 // tipo de la PK

    protected $fillable = [
        'idproducto',
        'nombre',
        'descripcion',
        'precio',
        'stock',
    ];
}