<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MesasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $mesas = [];

        // 5 Mesas de tres bandas
        for ($i = 1; $i <= 5; $i++) {
            $mesas[] = [
                'estado' => 'disponible',
                'tipo' => 'tresbandas',
                'numeromesa' => 'Tres Bandas -' . $i,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // 2 Mesas libres
        for ($i = 1; $i <= 2; $i++) {
            $mesas[] = [
                'estado' => 'disponible',
                'tipo' => 'libre',
                'numeromesa' => 'Libres -' . $i,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // 2 Mesas de pool
        for ($i = 1; $i <= 2; $i++) {
            $mesas[] = [
                'estado' => 'disponible',
                'tipo' => 'pool',
                'numeromesa' => 'Pool -' . $i,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        // 9 Mesas de consumo
        for ($i = 1; $i <= 9; $i++) {
            $mesas[] = [
                'estado' => 'disponible',
                'tipo' => 'consumo',
                'numeromesa' => 'Consumo -' . $i,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('mesas')->insert($mesas);
    }
}
