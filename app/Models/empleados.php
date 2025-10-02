<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class empleados extends Model
{
    protected $table = 'empleados';
    protected $primaryKey = 'numerodocumento';
    public $incrementing = false; // Indica que la clave primaria no es auto-incrementable
    protected $keyType = 'integer'; // Tipo de dato de la clave primaria

    protected $fillable = [
        'numerodocumento',
        'nombre',
        'cargo',
        'salario',
        'estado',
        'tipodocumento',
        'apellidos',
        'email',
        'telefono',
        'direccion',
        'fechaingreso',
        'fechafinal'
    ];
}
