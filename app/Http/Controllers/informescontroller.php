<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MesasVentas;
use App\Models\productos;
use App\Models\Mesas;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class informescontroller extends Controller
{
    /**
     * Mostrar la vista de informes con filtros
     */
    public function index()
    {
        return view('informes.informes');
    }

    /**
     * Obtener datos de ventas por período (JSON)
     */
    public function ventasPorPeriodo(Request $request)
    {
        $tipo = $request->get('tipo', 'dia'); // dia, semana, mes
        $fechaInicio = $request->get('fecha_inicio') ? Carbon::parse($request->get('fecha_inicio')) : Carbon::now()->startOfMonth();
        $fechaFin = $request->get('fecha_fin') ? Carbon::parse($request->get('fecha_fin'))->endOfDay() : Carbon::now();
        $metodo_pago = $request->get('metodo_pago');

        $query = MesasVentas::whereBetween('fechafin', [$fechaInicio, $fechaFin])
            ->whereNotNull('fechafin');

        if ($metodo_pago) {
            $query->where('metodo_pago', $metodo_pago);
        }

        if ($tipo === 'dia') {
            $datos = $query->selectRaw('DATE(fechafin) as fecha, SUM(total) as total, COUNT(*) as cantidad')
                ->groupBy(DB::raw('DATE(fechafin)'))
                ->orderBy('fecha')
                ->get();
            
            $labels = $datos->pluck('fecha')->map(fn($f) => Carbon::parse($f)->format('d/m'))->toArray();
        } elseif ($tipo === 'semana') {
            $datos = $query->selectRaw('YEARWEEK(fechafin) as semana, SUM(total) as total, COUNT(*) as cantidad')
                ->groupBy(DB::raw('YEARWEEK(fechafin)'))
                ->orderBy('semana')
                ->get();
            
            $labels = $datos->pluck('semana')->map(fn($s) => "Sem $s")->toArray();
        } else { // mes
            $datos = $query->selectRaw('DATE_TRUNC(\'month\', fechafin) as mes, SUM(total) as total, COUNT(*) as cantidad')
                ->groupByRaw('DATE_TRUNC(\'month\', fechafin)')
                ->orderBy('mes')
                ->get();
            
            $labels = $datos->pluck('mes')->map(fn($m) => Carbon::parse($m)->format('M/Y'))->toArray();
        }

        $valores = $datos->pluck('total')->map(fn($v) => (float)$v)->toArray();
        $cantidades = $datos->pluck('cantidad')->toArray();
        $total = array_sum($valores);

        return response()->json([
            'labels' => $labels,
            'valores' => $valores,
            'cantidades' => $cantidades,
            'total' => round($total, 2),
            'promedio' => count($valores) > 0 ? round($total / count($valores), 2) : 0,
        ]);
    }

    /**
     * Obtener productos más vendidos (JSON)
     */
    public function productosMasVendidos(Request $request)
    {
        $fechaInicio = $request->get('fecha_inicio') ? Carbon::parse($request->get('fecha_inicio')) : Carbon::now()->startOfMonth();
        $fechaFin = $request->get('fecha_fin') ? Carbon::parse($request->get('fecha_fin'))->endOfDay() : Carbon::now();
        $limite = $request->get('limite', 10);

        $productos = DB::table('mesasventas_productos')
            ->join('productos', 'mesasventas_productos.idproducto', '=', 'productos.idproducto')
            ->join('mesasventas', 'mesasventas_productos.idmesaventa', '=', 'mesasventas.id')
            ->whereBetween('mesasventas.fechafin', [$fechaInicio, $fechaFin])
            ->whereNotNull('mesasventas.fechafin')
            ->selectRaw('productos.nombre, SUM(mesasventas_productos.cantidad) as cantidad_vendida, SUM(mesasventas_productos.subtotal) as total_vendido')
            ->groupBy('productos.nombre')
            ->orderByDesc('cantidad_vendida')
            ->limit($limite)
            ->get();

        return response()->json([
            'productos' => $productos,
            'total' => $productos->count(),
        ]);
    }

    /**
     * Obtener ingresos por método de pago (JSON)
     */
    public function ingresosPorMetodoPago(Request $request)
    {
        $fechaInicio = $request->get('fecha_inicio') ? Carbon::parse($request->get('fecha_inicio')) : Carbon::now()->startOfMonth();
        $fechaFin = $request->get('fecha_fin') ? Carbon::parse($request->get('fecha_fin'))->endOfDay() : Carbon::now();

        $datos = MesasVentas::whereBetween('fechafin', [$fechaInicio, $fechaFin])
            ->whereNotNull('fechafin')
            ->selectRaw('metodo_pago, SUM(total) as total, COUNT(*) as cantidad')
            ->groupBy('metodo_pago')
            ->get();

        $metodos = ['efectivo' => 0, 'transferencia' => 0, 'tarjeta' => 0];
        foreach ($datos as $fila) {
            $metodos[$fila->metodo_pago] = (float)$fila->total;
        }

        return response()->json([
            'metodos' => $metodos,
            'total' => array_sum($metodos),
        ]);
    }

    /**
     * Obtener ocupación de mesas (JSON)
     */
    public function ocupacionMesas(Request $request)
    {
        $fechaInicio = $request->get('fecha_inicio') ? Carbon::parse($request->get('fecha_inicio')) : Carbon::now()->startOfDay();
        $fechaFin = $request->get('fecha_fin') ? Carbon::parse($request->get('fecha_fin'))->endOfDay() : Carbon::now();

        $totalMesas = Mesas::count();
        $mesasOcupadas = Mesas::where('estado', 'ocupada')->count();
        $mesasDisponibles = Mesas::where('estado', 'disponible')->count();

        $ventasPorMesa = DB::table('mesasventas')
            ->join('mesas', 'mesasventas.idmesa', '=', 'mesas.idmesa')
            ->whereBetween('mesasventas.fechafin', [$fechaInicio, $fechaFin])
            ->whereNotNull('mesasventas.fechafin')
            ->selectRaw('mesas.numeromesa, mesas.tipo, COUNT(*) as usos, SUM(mesasventas.total) as ingresos')
            ->groupBy('mesas.numeromesa', 'mesas.tipo')
            ->orderByDesc('ingresos')
            ->get();

        return response()->json([
            'total_mesas' => $totalMesas,
            'ocupadas' => $mesasOcupadas,
            'disponibles' => $mesasDisponibles,
            'ventas_por_mesa' => $ventasPorMesa,
        ]);
    }

    /**
     * Obtener resumen general (JSON)
     */
    public function resumenGeneral(Request $request)
    {
        $fechaInicio = $request->get('fecha_inicio') ? Carbon::parse($request->get('fecha_inicio')) : Carbon::now()->startOfMonth();
        $fechaFin = $request->get('fecha_fin') ? Carbon::parse($request->get('fecha_fin'))->endOfDay() : Carbon::now();

        $totalVentas = MesasVentas::whereBetween('fechafin', [$fechaInicio, $fechaFin])
            ->whereNotNull('fechafin')
            ->sum('total');

        $cantidadTransacciones = MesasVentas::whereBetween('fechafin', [$fechaInicio, $fechaFin])
            ->whereNotNull('fechafin')
            ->count();

        $productosTotales = productos::count();
        $mesasTotales = Mesas::count();

        return response()->json([
            'total_ventas' => round($totalVentas, 2),
            'cantidad_transacciones' => $cantidadTransacciones,
            'promedio_transaccion' => $cantidadTransacciones > 0 ? round($totalVentas / $cantidadTransacciones, 2) : 0,
            'productos_registrados' => $productosTotales,
            'mesas_totales' => $mesasTotales,
        ]);
    }

    /**
     * Obtener comparación de meses (JSON)
     */
    public function comparacionMeses(Request $request)
    {
        $meses = $request->get('meses', []); // Array de años-meses: ['2025-01', '2025-02', ...]
        
        if (empty($meses)) {
            // Si no hay meses seleccionados, devolver últimos 6 meses
            $meses = [];
            for ($i = 5; $i >= 0; $i--) {
                $meses[] = Carbon::now()->subMonths($i)->format('Y-m');
            }
        }

        $datos = [];
        foreach ($meses as $mes) {
            $inicio = Carbon::createFromFormat('Y-m', $mes)->startOfMonth();
            $fin = $inicio->copy()->endOfMonth();

            $totalVentas = MesasVentas::whereBetween('fechafin', [$inicio, $fin])
                ->whereNotNull('fechafin')
                ->sum('total');

            $cantidadTransacciones = MesasVentas::whereBetween('fechafin', [$inicio, $fin])
                ->whereNotNull('fechafin')
                ->count();

            $datos[] = [
                'mes' => $mes,
                'label' => Carbon::createFromFormat('Y-m', $mes)->format('M/Y'),
                'total_ventas' => round($totalVentas, 2),
                'cantidad_transacciones' => $cantidadTransacciones,
                'promedio' => $cantidadTransacciones > 0 ? round($totalVentas / $cantidadTransacciones, 2) : 0,
            ];
        }

        return response()->json([
            'datos' => $datos,
            'total_general' => array_sum(array_column($datos, 'total_ventas')),
        ]);
    }
}
