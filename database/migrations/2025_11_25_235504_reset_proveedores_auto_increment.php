<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Reset the auto-increment counter for proveedores table
        // Get the max ID and set auto_increment to max_id + 1
        DB::statement('ALTER TABLE proveedores AUTO_INCREMENT = ' . (DB::table('proveedores')->max('idproveedor') + 1));
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
