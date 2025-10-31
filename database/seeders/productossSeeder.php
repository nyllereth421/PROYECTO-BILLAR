<?php

namespace Database\Seeders;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class productossSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 60; $i++) {
            DB::table('productos')->insert([
                'nombre'       => 'Producto ' . $i,
                'descripcion'  => 'Descripción del producto ' . $i . ': ' . Str::random(20),
                'precio'       => rand(5, 100) + rand(0, 99) / 100, // Precio con decimales
                'stock'        => rand(10, 500),  // Cantidad aleatoria
                'idproveedor'  => rand(1, 10),    // Debe existir en proveedores
                'created_at'   => now(),
                'updated_at'   => now(),
            ]);
        }
    }
}
