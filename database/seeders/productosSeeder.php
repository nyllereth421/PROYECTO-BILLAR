<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('productos')->insert([
            [
                'nombre' => 'Paquete de snacks variados',
                'descripcion' => 'Caja con variedad de snacks salados y dulces para eventos.',
                'precio' => 2500.00,
                'stock' => 50,
                'idproveedor' => 1, // Distribuidora El Águila
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Botella de agua mineral 500ml',
                'descripcion' => 'Agua mineral natural en botella de 500ml.',
                'precio' => 2000.00,
                'stock' => 200,
                'idproveedor' => 3, // Suministros J&M
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Gaseosa cola 2 litros',
                'descripcion' => 'Bebida gaseosa sabor cola en presentación familiar de 2 litros.',
                'precio' => 8000.00,
                'stock' => 120,
                'idproveedor' => 4, // Comercializadora Billares Pro
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Caja de cerveza artesanal (12 unidades)',
                'descripcion' => 'Caja con 12 cervezas artesanales surtidas.',
                'precio' => 45000.00,
                'stock' => 30,
                'idproveedor' => 5, // Distribuciones La 33
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Bocaditos mixtos para eventos',
                'descripcion' => 'Paquete de bocaditos fríos y calientes para reuniones y eventos.',
                'precio' => 600.00,
                'stock' => 15,
                'idproveedor' => 6, // Proveeduría Norte
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Jugo natural 1 litro',
                'descripcion' => 'Jugo natural de frutas en presentación de un litro.',
                'precio' => 1000.00,
                'stock' => 80,
                'idproveedor' => 7, // Billares y Más
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Snack saludable (barra energética)',
                'descripcion' => 'Barra energética hecha con ingredientes naturales para un snack saludable.',
                'precio' => 3000.50,
                'stock' => 100,
                'idproveedor' => 8, // Insumos El Campeón
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Refresco de limón 1.5 litros',
                'descripcion' => 'Bebida gaseosa sabor limón en presentación de 1.5 litros.',
                'precio' => 1500.00,
                'stock' => 90,
                'idproveedor' => 9, // Todo Billar S.A.S.
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Paquete de galletas surtidas',
                'descripcion' => 'Paquete con diferentes tipos de galletas para snacks.',
                'precio' => 1200.00,
                'stock' => 60,
                'idproveedor' => 10, // Importaciones Elite
                'created_at' => now(),
                'updated_at' => now(),
            ],
            
        ]);
    }
}
