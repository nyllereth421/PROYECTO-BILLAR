<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class ProveedoresSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('proveedores')->insert([
            [
                'nombre' => 'Distribuidora El Águila',
                'contacto' => '3104567890',
                'direccion' => 'Calle 12 #45-67, Bogotá',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Suministros J&M',
                'contacto' => '3209876543',
                'direccion' => 'Carrera 8 #23-14, Medellín',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Comercializadora Billares Pro',
                'contacto' => '3156789012',
                'direccion' => 'Av. Santander #100-200, Cali',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Distribuciones La 33',
                'contacto' => '3012345678',
                'direccion' => 'Cra 33 #44-55, Bucaramanga',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Proveeduría Norte',
                'contacto' => '3123456789',
                'direccion' => 'Calle 5 #10-20, Cúcuta',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Billares y Más',
                'contacto' => '3004561237',
                'direccion' => 'Transv 19 #76-12, Barranquilla',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Insumos El Campeón',
                'contacto' => '3176543210',
                'direccion' => 'Calle 10 #15-30, Cartagena',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Todo Billar S.A.S.',
                'contacto' => '3045678901',
                'direccion' => 'Av. 1ra #20-90, Manizales',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Importaciones Elite',
                'contacto' => '3189012345',
                'direccion' => 'Cra 20 #80-10, Pereira',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nombre' => 'Súper Proveedores',
                'contacto' => '3112233445',
                'direccion' => 'Cl 50 #30-80, Armenia',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
