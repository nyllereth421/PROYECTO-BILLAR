<?php

namespace Database\Seeders;

use App\Models\mesas;
use App\Models\mesasConsumos;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            proveedoresSeeder::class,
        ]);
        
        $this->call([
        ProductosSeeder::class,
        ]); 

        $this->call([
            MesasSeeder::class,
        ]);

    }
}
