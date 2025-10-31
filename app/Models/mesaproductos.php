<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class mesaproductos extends Model
{
    use HasFactory;

    protected $table = 'mesaproductos';
    protected $fillable = ['idmesa', 'idproducto', 'cantidad', 'precio'];

    public function producto()
    {
        return $this->belongsTo(productos::class, 'idproducto');
    }

    public function mesa()
    {
        return $this->belongsTo(mesas::class, 'idmesa');
    }
}
