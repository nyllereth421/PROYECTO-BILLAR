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
        $mesas = [];

        for ($i = 1; $i <= 9; $i++) {
            $mesas[] = [
                'consumos' => 'Mesa ' . $i,
                'estado' => 'disponible',
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

        DB::table('mesas_consumos')->insert($mesas);
    }
}
