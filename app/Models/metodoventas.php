<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class metodoventas extends Model
{
    protected $table = 'metodoventas';
    protected $fillable = [
        'ventaid', 
        'idmetodopago', 
        'valor'
    ];
}
