<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class productos extends Model
{

    protected $table = 'productos';
    protected $primaryKey = 'idproducto';
    public $timestamps = true;

    protected $fillable = [
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
  public function mesasVentas()
{
    return $this->belongsToMany(MesasVentas::class, 'mesasventas_productos', 'idproducto', 'idmesaventa')
                ->withPivot('cantidad', 'precio_unitario', 'subtotal')
                ->withTimestamps();
}
public function ventasPivot()
    {
        return $this->belongsToMany(MesasVentas::class, 'mesasventas_productos', 'idproducto', 'idmesaventa')
                    ->withPivot(['cantidad','precio_unitario','subtotal'])
                    ->withTimestamps();
    }


}
