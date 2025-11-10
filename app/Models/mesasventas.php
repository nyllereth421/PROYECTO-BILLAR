<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MesasVentas extends Model
{
    use HasFactory;

    protected $table = 'mesasventas';

    protected $fillable = [
        'ventas',
        'fechainicio',
        'fechafin',
        'total',
        'idmesa',
        ''
    ];

    

    // Relación: cada mesa venta pertenece a una venta
    public function venta()
    {
        return $this->belongsTo(Ventas::class, 'ventas', 'id');
    }
 public function productos()
{
    return $this->belongsToMany(Productos::class, 'mesasventas_productos', 'idmesaventa', 'idproducto')
                ->withPivot('cantidad', 'precio_unitario', 'subtotal')
                ->withTimestamps();
}
 public function mesa()
    {
        // Puede ser mesa normal o de consumo según cómo guardes idmesa
        return $this->belongsTo(Mesas::class, 'idmesa', 'idmesa');
    }
public function showFactura($id)
{
    $venta = Ventas::find($id);

    if (!$venta) {
        abort(404, 'Venta no encontrada');
    }

    return view('ventas.factura', compact('venta'));
}


}
