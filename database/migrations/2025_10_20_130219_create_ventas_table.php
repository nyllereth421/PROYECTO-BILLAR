<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('ventas', function (Blueprint $table) {
        $table->id(); 
        $table->datetime('fecha');
        $table->decimal('total', 10, 2);
        $table->unsignedBigInteger('idusuario');
        $table->foreign('idusuario')
              ->references('id')->on('users');
        $table->unsignedBigInteger('idmesa');
        $table->foreign('idmesa')
              ->references('idmesa')->on('mesas');
        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ventas');
    }
};
