<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MesasConsumosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        DB::table('mesas_consumos')->insert([
            [
                'consumos' => 'Mesa 1',
                'estado' => 'disponible',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'consumos' => 'Mesa 2',
                'estado' => 'disponible',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'consumos' => 'Mesa 3',
                'estado' => 'disponible',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'consumos' => 'Mesa 4',
                'estado' => 'disponible',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'consumos' => 'Mesa 5',
                'estado' => 'disponible',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'consumos' => 'Mesa 6',
                'estado' => 'disponible',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'consumos' => 'Mesa 7',
                'estado' => 'disponible',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'consumos' => 'Mesa 8',
                'estado' => 'disponible',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'consumos' => 'Mesa 9',
                'estado' => 'disponible',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
