<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class mesas extends Model
{
    protected $table = 'mesas';

    protected $fillable = [
        'idmesa',
        'estado',
        'tipo',
        'numeromesa',
    ];
}
